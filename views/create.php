<?php

$db = pdo();

$error = " ";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $q = trim($_POST['question'] ?? '');
    $labels = array_values(array_filter(
        array_map('trim', $_POST['options'] ?? []),
        static fn($label) => $label !== ''
    ));

    if ($q === '' || count($labels) < 2) {
        $error = "Informe a pergunta e pelo menos duas opções.";
    } else {
        try {
            $db->beginTransaction();

            $st = $db->prepare("INSERT INTO polls (question) VALUES (?)");
            $st->execute([$q]);

            $poll_id = (int)$db->lastInsertId();

            $st = $db->prepare("INSERT INTO poll_options (poll_id, label) VALUES (?, ?)");
            foreach ($labels as $l) {
                $st->execute([$poll_id, $l]);
            }

            $st = $db->prepare("UPDATE settings SET current_poll_id = ? WHERE id = 1");
            $st->execute([$poll_id]);

            $db->commit();

            header("location: resultados.php");

            exit;
        } catch (Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            error_log('Erro ao criar enquete: ' . $e->getMessage());
            $error = 'Erro ao criar enquete';
        }
    }
}

?>

<?php if ($error !== " "): ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>


<div class="card">
    <div class="card-body">
        <form class="vstack gap-2" method="POST">
            <div class="form-floating">
                <input type="text" id="question" name="question" class="form-control" placeholder="Pergunta">
                <label for="question">Pergunta</label>
            </div>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="form-floating">
                    <input type="text" id="option<?= $i ?>" name="options[]" class="form-control" placeholder="Opção <?= $i ?>">
                    <label for="option<?= $i ?>">Opção <?= $i ?></label>
                </div>
            <?php endfor; ?>
            <button class="btn btn-primary mt-2" type="submit">Criar Enquete</button>
        </form>
    </div>
</div>

<div class="mt-3">
    <a href="resultados.php" class="btn btn-primary btn-sm">Ver Resultados</a>
    <a href="index.php" class="btn btn-outline-secondary btn-sm">Voltar para a Home</a>
</div>