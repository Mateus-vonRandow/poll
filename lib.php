<?php

function pdo() {

    static $pdo = null;

    if ($pdo === null) {
        require __DIR__ . '/config.php';
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,            
        ]);
    }

    return $pdo;

}


function get_current_poll() {
    $db = pdo();

    $row = $db->query("SELECT current_poll_id FROM settings WHERE id = 1")->fetch();

    if(!$row || !$row['current_poll_id']) return null;

    $poll_id = (int)$row['current_poll_id'];

    $st = $db->prepare("SELECT * FROM polls WHERE id = ?");

    $st->execute([$poll_id]);

    $poll = $st->fetch();

    $st = $db->prepare("SELECT * FROM poll_options WHERE poll_id = ? ORDER BY id ASC");

    $st->execute([$poll_id]);

    $options = $st->fetchAll();

    $total = 0;

    foreach ($options as $o) {
        $total += (int)$o['votes'];
    }

    return ['poll' => $poll, 'options' => $options, 'total' => $total];


}

function has_voted($poll_id) {

    return isset($_COOKIE['voted_poll'.$poll_id]);

}

function set_voted_cookie($poll_id) {
    $days = defined('VOTE_COOKIE_DAYS') ? VOTE_COOKIE_DAYS : 30;
    setcookie('voted_poll'.$poll_id, '1', time() + (60 * 60 * 24 * $days), '/');
}