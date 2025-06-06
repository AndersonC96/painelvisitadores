<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section">
  <div class="container" style="max-width: 500px;">
    <h1 class="title">Editar Time</h1>
    <form method="POST" action="/times/update">
      <input type="hidden" name="id" value="<?= $time['id'] ?>">
      <div class="field">
        <label class="label">Nome do Time</label>
        <div class="control">
          <input class="input" type="text" name="nome" value="<?= htmlspecialchars($time['nome']) ?>" required maxlength="100">
        </div>
      </div>
      <div class="field">
        <label class="label">Representantes</label>
        <div class="control">
          <select name="representantes[]" multiple class="select is-fullwidth">
            <?php foreach ($representantes as $r): ?>
            <option value="<?= $r['id'] ?>" <?= in_array($r['id'], $representantes_do_time) ? 'selected' : '' ?>>
              <?= htmlspecialchars($r['nome']) ?>
            </option>
            <?php endforeach; ?>
          </select>
          <p class="help">Segure Ctrl (ou Cmd) para selecionar vários.</p>
        </div>
      </div>
      <div class="field">
        <label class="label">Filial</label>
        <div class="control">
          <div class="select is-fullwidth">
            <select name="filial_id" required>
              <option value="">Selecione a filial</option>
              <?php foreach ($filiais as $filial): ?>
                <option value="<?= $filial['id'] ?>" <?= ($time['filial_id'] == $filial['id']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($filial['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <div class="field">
        <label class="checkbox">
          <input type="checkbox" name="ativo" <?= $time['ativo'] ? 'checked' : '' ?>>
          Ativo
        </label>
      </div>
      <div class="field is-grouped mt-4">
        <div class="control">
          <button class="button is-link" type="submit">Salvar</button>
        </div>
        <div class="control">
          <a class="button is-light" href="/times">Cancelar</a>
        </div>
      </div>
    </form>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>