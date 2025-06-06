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
        Novo Profissional
      </h1>
      <form method="POST" action="/profissionais/store" autocomplete="off">
        <div class="field">
          <label class="label">Nome</label>
          <div class="control">
            <input class="input" type="text" name="nome_profissional" required maxlength="100" autofocus>
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
            <input class="input" type="text" name="estado" required maxlength="2" style="text-transform:uppercase;">
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
            <a class="button is-light" style="border-radius:10px;font-weight:700;" href="/profissionais">Cancelar</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>