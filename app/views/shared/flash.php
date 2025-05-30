<?php if (!empty($_SESSION['mensagem'])): ?>
    <div class="notification <?= $_SESSION['mensagem_tipo'] ?? 'is-info' ?>">
        <?= htmlspecialchars($_SESSION['mensagem']) ?>
        <button class="delete" onclick="this.parentElement.style.display='none';"></button>
    </div>
    <?php unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']); ?>
<?php endif; ?>