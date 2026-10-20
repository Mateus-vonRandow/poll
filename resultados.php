<?php

require __DIR__ . '/template.php';
require __DIR__ . '/lib.php';

$data = get_current_poll();

render('results', [
    'title' => 'Resultados da Enquete',
    'hero' => 'Resultados da Enquete',
    'herolead' => 'Veja os percentuais da enquete ativa!',
    'data' => $data,
    'withWidget' => false,

]);
