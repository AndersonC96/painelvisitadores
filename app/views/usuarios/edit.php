<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section" style="min-height:85vh; display:flex; align-items:center;">
  <div class="container" style="max-width:520px; margin:auto;">
    <div class="box" style="
      border-radius: 18px;
      box-shadow: 0 6px 36px 0 #2563eb22, 0 2px 12px 0 #1111;
      padding: 2.2rem 2.3rem 2rem 2.3rem;
      backdrop-filter: blur(1.5px);">
      <h1 class="title has-text-centered"
          style="font-size:2.1rem; font-family:'Montserrat',Segoe UI,sans-serif;font-weight:800;
          margin-bottom:1.6rem;text-shadow:0 2px 8px #2563eb44;">
        Editar Usuário
      </h1>
      <form method="POST" action="/usuarios/update" autocomplete="off">
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
          <label class="label">Filiais</label>
          <div class="filiais-pills">
            <?php foreach ($lista_filiais as $filial): $checked = in_array($filial['id'], $filiais_do_usuario);?>
            <label class="checkbox-pill<?= $checked ? ' selected' : '' ?>">
              <input type="checkbox" name="filiais[]" value="<?= $filial['id'] ?>" <?= $checked ? 'checked' : '' ?> onchange="this.parentNode.classList.toggle('selected', this.checked)">
              <span><?= htmlspecialchars($filial['nome']) ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="field">
          <label class="label">Nível de Acesso</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select name="tipo" required>
                <option value="comum" <?= ($usuario['tipo'] ?? '') == 'comum' ? 'selected' : '' ?>>Comum</option>
                <option value="admin" <?= ($usuario['tipo'] ?? '') == 'admin' ? 'selected' : '' ?>>Administrador</option>
              </select>
            </div>
          </div>
        </div>
        <div class="field">
          <label class="checkbox-pill-single<?= $usuario['ativo'] ? ' selected' : '' ?>">
            <input type="checkbox" name="ativo"
              <?= $usuario['ativo'] ? 'checked' : '' ?>
              onchange="this.parentNode.classList.toggle('selected', this.checked)">
            <span>Ativo</span>
          </label>
        </div>
        <div class="field is-grouped mt-4" style="justify-content:center;">
          <div class="control">
            <button class="button is-link" style="
              font-weight:700;
              padding:0.7em 2.1em;
              border-radius:10px;
              background:linear-gradient(90deg, #2563eb 60%, #60a5fa 100%) !important;
              box-shadow:0 3px 18px #2563eb55;
              transition:.2s;
            " type="submit">Salvar</button>
          </div>
          <div class="control">
            <a class="button is-light" style="border-radius:10px;font-weight:700;" href="/usuarios">Cancelar</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>