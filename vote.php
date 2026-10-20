<?php

require __DIR__ . '/lib.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$poll_id = (int)($_POST['poll_id'] ?? 0);
$option_id = (int)($_POST['option_id'] ?? 0);

if ($poll_id < 1 || $option_id < 1) {
    header('Location: index.php');
    exit;
}

$db = pdo();

$row = $db->query("SELECT current_poll_id FROM settings WHERE id = 1")->fetch();

if (!$row || (int)$row['current_poll_id'] !== $poll_id) {
    header('Location: index.php');
    exit;
}

if (has_voted($poll_id)) {
    header('Location: index.php');
    exit;
}

$st = $db->prepare("SELECT id FROM poll_options WHERE id = ? AND poll_id = ?");

$st->execute([$option_id, $poll_id]);

if (!$st->fetch()) {
    header('Location: index.php');
    exit;
}

$st = $db->prepare("UPDATE poll_options SET votes = votes + 1 WHERE id = ? AND poll_id = ?");
$st->execute([$option_id, $poll_id]);

set_voted_cookie($poll_id);

header("Location: index.php");
exit;