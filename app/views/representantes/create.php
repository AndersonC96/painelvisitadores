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
        Novo Representante
      </h1>
      <form method="POST" action="/representantes/store" autocomplete="off">
        <div class="field">
          <label class="label">Nome</label>
          <div class="control">
            <input class="input" type="text" name="nome" required maxlength="120" autofocus>
          </div>
        </div>
        <div class="field">
          <label class="label">Filial</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select name="filial_id" required>
                <?php foreach ($filiais as $filial): ?>
                  <option value="<?= $filial['id'] ?>"><?= htmlspecialchars($filial['nome']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="field" style="margin-top:8px;">
          <label class="checkbox" style="font-weight:700;letter-spacing:.1em;">
            <input type="checkbox" name="ativo" checked style="margin-right:7px;">
            Ativo
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
            <a class="button is-light" style="border-radius:10px;font-weight:700;" href="/representantes">Cancelar</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>