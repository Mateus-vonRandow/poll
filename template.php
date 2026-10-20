<?php

function render($view, $vars = []) {
    extract($vars);
    // Cabecalho
    require __DIR__ . '/partials/header.php';
    // Conteudo
    require __DIR__ . '/views/'. $view . '.php';
    // Rodape
    require __DIR__ . '/partials/footer.php';
}