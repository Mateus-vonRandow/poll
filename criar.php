<?php

require __DIR__ . '/template.php';
require __DIR__ . '/lib.php';

render('create', [
    'title' => 'Criacão de Enquete',
    'hero' => 'Criar enquete',
    'herolead' => 'Crie uma nova enquete para o site',
    'withWidget' => false,

]);
