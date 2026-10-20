<?php if (!empty($data['poll']) && !empty($data['options'])): ?>
    <div class="position-fixed bottom-0 end-0 p-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="fw-semibold mb-3">
                    <?= htmlspecialchars((string)$data['poll']['question'], ENT_QUOTES, 'UTF-8'); ?>
                </div>

                <?php if (has_voted((int)$data['poll']['id'])): ?>
                    <div class="alert alert-success mb-0">
                        Você já votou!
                    </div>

                <?php else: ?>
                    <div class="alert alert-info mb-2">
                        Você ainda não votou nesta enquete.
                    </div>
                    <form action="vote.php" method="post" class="vstack gap-2">
                        <input type="hidden" name="poll_id" value="<?= (int)$data['poll']['id']; ?>">

                        <?php foreach ($data['options'] as $o) : ?>

                            <div class="form-check mb-1">
                                <input
                                    type="radio"
                                    class="form-check-input"
                                    name="option_id"
                                    id="opt<?= (int)$o['id'] ?>"
                                    value="<?= (int)$o['id'] ?>"
                                    required>

                                <label
                                    for="opt<?= (int)$o['id'] ?>" class="form-check-label">
                                    <?= htmlspecialchars((string)$o['label'], ENT_QUOTES, 'UTF-8'); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>

                        <button class="btn btn-primary btn-sm mt-2 w-100" type="submit">
                            Votar
                        </button>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; ?>