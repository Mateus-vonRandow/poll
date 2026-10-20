    </main>

    <footer class="border-top py-3 mt-auto bg-white">
        <div class="container text-center text-muted small">
            © 2026 Meu Site
        </div>
    </footer>

    <!-- Enquete -->
    <?php if (!empty($withWidget)): ?>
        <?php require __DIR__.'/poll_widget.php'; ?>
    <?php endif; ?>
</body>
</html>