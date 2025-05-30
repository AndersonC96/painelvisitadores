<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php if (!empty($_SESSION['mensagem'])): ?>
    <div class="notification <?= $_SESSION['mensagem_tipo'] ?? 'is-info' ?>">
        <?= htmlspecialchars($_SESSION['mensagem']) ?>
        <button class="delete" onclick="this.parentElement.style.display='none';"></button>
    </div>
    <?php unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']); ?>
<?php endif; ?>
<section class="section">
  <div class="container" style="max-width: 500px;">
    <h1 class="title">Editar Usuário</h1>
    <form method="POST" action="/usuarios/update">
      <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
      <div class="field">
        <label class="label">Nome</label>
        <div class="control">
          <input class="input" type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required maxlength="120">
        </div>
      </div>
      <div class="field">
        <label class="label">Usuário</label>
        <div class="control">
          <input class="input" type="text" name="username" value="<?= htmlspecialchars($usuario['username']) ?>" required maxlength="60">
        </div>
      </div>
      <div class="field">
        <label class="label">Nova Senha <small>(preencha para trocar)</small></label>
        <div class="control">
          <input class="input" type="password" name="senha" minlength="6">
        </div>
      </div>
      <div class="field">
        <label class="checkbox">
          <input type="checkbox" name="ativo" <?= $usuario['ativo'] ? 'checked' : '' ?>>
          Ativo
        </label>
      </div>
      <div class="field is-grouped mt-4">
        <div class="control">
          <button class="button is-link" type="submit">Salvar</button>
        </div>
        <div class="control">
          <a class="button is-light" href="/usuarios">Cancelar</a>
        </div>
      </div>
    </form>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>