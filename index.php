<?php

require __DIR__ . '/template.php';
require __DIR__ . '/lib.php';

$data = get_current_poll();

render('home', [
    'title' => 'Home do site',
    'hero' => 'Bem-vindo',
    'herolead' => 'Site de noticias, leia o que quiser!',
    'data' => $data,
    'withWidget' => true,

]);