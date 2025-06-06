<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section">
  <div class="container" style="max-width: 500px;">
    <h1 class="title">Editar Vendedora</h1>
    <form method="POST" action="/vendedoras/update">
      <input type="hidden" name="id" value="<?= $vendedora['id'] ?>">
      <div class="field">
        <label class="label">Nome</label>
        <div class="control">
          <input class="input" type="text" name="nome" value="<?= htmlspecialchars($vendedora['nome']) ?>" required maxlength="120">
        </div>
      </div>
      <div class="field">
        <label class="label">Time</label>
        <div class="control">
          <div class="select is-fullwidth">
            <select name="time_id" required>
              <option value="">Selecione o time</option>
              <?php foreach ($times as $time): ?>
                <option value="<?= $time['id'] ?>" <?= ($vendedora['time_id'] == $time['id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($time['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <div class="field">
        <label class="checkbox">
          <input type="checkbox" name="ativo" <?= $vendedora['ativo'] ? 'checked' : '' ?>>
          Ativa
        </label>
      </div>
      <div class="field is-grouped mt-4">
        <div class="control">
          <button class="button is-link" type="submit">Salvar</button>
        </div>
        <div class="control">
          <a class="button is-light" href="/vendedoras">Cancelar</a>
        </div>
      </div>
    </form>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>