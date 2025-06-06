<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section">
  <div class="container" style="max-width: 500px;">
    <h1 class="title">Editar Representante</h1>
    <form method="POST" action="/representantes/update">
      <input type="hidden" name="id" value="<?= $representante['id'] ?>">
      <div class="field">
        <label class="label">Nome</label>
        <div class="control">
          <input class="input" type="text" name="nome" value="<?= htmlspecialchars($representante['nome']) ?>" required maxlength="120">
        </div>
      </div>
      <div class="field">
        <label class="label">Filial</label>
        <div class="control">
          <div class="select">
            <select name="filial_id" required>
              <?php foreach ($filiais as $filial): ?>
                <option value="<?= $filial['id'] ?>" <?= $filial['id'] == $representante['filial_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($filial['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <div class="field">
        <label class="checkbox">
          <input type="checkbox" name="ativo" <?= $representante['ativo'] ? 'checked' : '' ?>>
          Ativo
        </label>
      </div>
      <div class="field is-grouped mt-4">
        <div class="control">
          <button class="button is-link" type="submit">Salvar</button>
        </div>
        <div class="control">
          <a class="button is-light" href="/representantes">Cancelar</a>
        </div>
      </div>
    </form>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>