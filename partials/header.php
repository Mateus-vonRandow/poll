<?php require __DIR__ . '/head.php'; ?>

<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar navbar-light bg-light border-bottom">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Meu Site</span>
        </div>
    </nav>

    <header class="bg-white">
        <div class="container py-5">
            <h1 class="display-6 mb-1"><?= $hero ?? 'Bem-vindo' ?></h1>
            <p class="text-muted mb-0"><?= $herolead ?? 'Subtitulo' ?></p>
        </div>
    </header>

    <main class="container py-4 flex-grow-1">