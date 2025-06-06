<?php
    $title = "Login - Painel Visitadores";
    require dirname(__DIR__, 2) . '/views/shared/header.php';
?>
<div class="login-bg">
  <section class="section is-flex is-justify-content-center is-align-items-center" style="min-height: 100vh;">
    <div class="login-container">
      <h1 class="login-title has-text-centered">Acesso ao Sistema</h1>
      <?php if (isset($erro)): ?>
        <div class="notification is-danger"><?= htmlspecialchars($erro) ?></div>
      <?php endif; ?>
      <form method="POST" action="/login">
        <div class="field">
          <label class="label"><b>Usuário</b></label>
          <div class="control">
            <input class="input" type="text" name="username" required autofocus>
          </div>
        </div>
        <div class="field">
          <label class="label"><b>Senha</b></label>
          <div class="control">
            <input class="input" type="password" name="senha" required>
          </div>
        </div>
        <div class="field mt-4">
          <button class="button is-link is-fullwidth login-btn" type="submit">Entrar</button>
        </div>
      </form>
    </div>
  </section>
</div>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>