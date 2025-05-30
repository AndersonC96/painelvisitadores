<?php
    $title = "Login - SimpleVisitadores";
    require dirname(__DIR__, 2) . '/views/shared/header.php';
?>
<section class="section">
  <div class="container" style="max-width: 400px;">
    <h1 class="title has-text-centered">Acesso ao Sistema</h1>
    <?php if (isset($erro)): ?>
      <div class="notification is-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <form method="POST" action="/login">
      <div class="field">
        <label class="label">Usuário</label>
        <div class="control">
          <input class="input" type="text" name="username" required autofocus>
        </div>
      </div>
      <div class="field">
        <label class="label">Senha</label>
        <div class="control">
          <input class="input" type="password" name="senha" required>
        </div>
      </div>
      <div class="field mt-4">
        <button class="button is-link is-fullwidth" type="submit">Entrar</button>
      </div>
    </form>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>