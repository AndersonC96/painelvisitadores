<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section">
  <div class="container" style="max-width: 600px;">
    <h1 class="title">Novo Profissional</h1>
    <form method="POST" action="/profissionais/store">
      <div class="field">
        <label class="label">Nome</label>
        <div class="control">
          <input class="input" type="text" name="nome_profissional" required maxlength="100">
        </div>
      </div>
      <div class="field">
        <label class="label">Tipo</label>
        <div class="control">
          <input class="input" type="text" name="tipo" required maxlength="100">
        </div>
      </div>
      <div class="field">
        <label class="label">Estado</label>
        <div class="control">
          <input class="input" type="text" name="estado" required maxlength="2">
        </div>
      </div>
      <div class="field">
        <label class="label">Registro</label>
        <div class="control">
          <input class="input" type="text" name="registro" required maxlength="30">
        </div>
      </div>
      <div class="field">
        <label class="label">Categoria</label>
        <div class="control">
          <input class="input" type="text" name="categoria" required maxlength="50">
        </div>
      </div>
      <div class="field">
        <label class="label">Representante</label>
        <div class="control">
          <div class="select is-fullwidth">
            <select name="representante_id" required>
              <option value="">Selecione o representante</option>
              <?php foreach ($representantes as $r): ?>
                <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nome']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <div class="field">
        <label class="label">Vendedora</label>
        <div class="control">
          <div class="select is-fullwidth">
            <select name="vendedora_id" required>
              <option value="">Selecione a vendedora</option>
              <?php foreach ($vendedoras as $v): ?>
                <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nome']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <div class="field">
        <label class="label">Filial</label>
        <div class="control">
          <div class="select is-fullwidth">
            <select name="filial_id" required>
              <option value="">Selecione a filial</option>
              <?php foreach ($filiais as $f): ?>
                <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nome']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <div class="field is-grouped mt-4">
        <div class="control">
          <button class="button is-link" type="submit">Salvar</button>
        </div>
        <div class="control">
          <a class="button is-light" href="/profissionais">Cancelar</a>
        </div>
      </div>
    </form>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>