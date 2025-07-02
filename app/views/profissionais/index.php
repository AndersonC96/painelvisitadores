<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section" style="min-height:85vh; display:flex; align-items:flex-start;">
  <div class="container" style="max-width: 1200px; margin:auto;">
    <div class="box" style="border-radius: 18px; box-shadow: 0 6px 36px 0 #2563eb22, 0 2px 12px 0 #1111; padding: 2.2rem 2.3rem 2.1rem 2.3rem; backdrop-filter: blur(1.5px);">
      <div style="display: flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:2rem 1.4rem; margin-bottom:1.5rem;">
        <h1 class="title" style="font-size:2.1rem; font-family:'Montserrat',Segoe UI,sans-serif; font-weight:800; margin-bottom:0; text-shadow:0 2px 8px #2563eb33;">Profissionais</h1>
        <div style="flex:1; min-width:350px; max-width:560px;">
          <form method="get" action="" autocomplete="off" style="display:flex;align-items:center;gap:10px;">
            <input class="input" type="text" name="busca" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>" placeholder="Buscar por nome, CRM, representante ou vendedora..." style="border-radius:10px; flex:1; min-width:170px;">
            <button class="button is-link" type="submit" style="border-radius:10px; margin-left:5px;">
              <span class="icon"><i class="fas fa-search"></i></span>
              <span>Buscar</span>
            </button>
            <div class="select" style="margin-left:10px; min-width:140px;">
              <select name="ordenar" onchange="this.form.submit()">
                <option value="">Ordenar por...</option>
                <option value="nome_asc"   <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == 'nome_asc') ? 'selected' : '' ?>>Nome A-Z</option>
                <option value="nome_desc"  <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == 'nome_desc') ? 'selected' : '' ?>>Nome Z-A</option>
                <option value="rep_asc"    <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == 'rep_asc') ? 'selected' : '' ?>>Representante A-Z</option>
                <option value="rep_desc"   <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == 'rep_desc') ? 'selected' : '' ?>>Representante Z-A</option>
                <option value="uf_asc"     <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == 'uf_asc') ? 'selected' : '' ?>>Estado A-Z</option>
                <option value="uf_desc"    <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == 'uf_desc') ? 'selected' : '' ?>>Estado Z-A</option>
                <option value="vend_asc"   <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == 'vend_asc') ? 'selected' : '' ?>>Vendedora A-Z</option>
                <option value="vend_desc"  <?= (isset($_GET['ordenar']) && $_GET['ordenar'] == 'vend_desc') ? 'selected' : '' ?>>Vendedora Z-A</option>
              </select>
            </div>
          </form>
        </div>
        <div style="display: flex; gap: 14px; flex-wrap:wrap;">
          <?php
            $pode_ver_todas = $_SESSION['usuario_tipo'] === 'admin' || (is_array($filiais_usuario) && count($filiais_usuario) > 1);
          ?>
          <?php if ($pode_ver_todas): ?>
            <a href="/profissionais?filial=1" class="button is-link is-light <?= (($_GET['filial'] ?? '') == '1') ? 'is-active' : '' ?>">São Paulo</a>
            <a href="/profissionais?filial=2" class="button is-link is-light <?= (($_GET['filial'] ?? '') == '2') ? 'is-active' : '' ?>">Brasília</a>
          <?php endif; ?>
          <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
            <button type="button" class="button is-link" style="font-weight:700;font-size:1.13rem;border-radius:12px;padding:.7em 2em;box-shadow:0 3px 18px #2563eb66;" onclick="printTable()">
              <span class="icon"><i class="fas fa-print"></i></span>
              <span>Imprimir</span>
            </button>
            <a href="/profissionais/create" class="button is-link" style="font-weight:700; font-size:1.13rem; border-radius:12px; padding:.7em 2em; box-shadow:0 3px 18px #2563eb66;">Novo Profissional</a>
          <?php endif; ?>
          <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
            <a href="/profissionais/exportar?<?= http_build_query($_GET) ?>"class="button is-success" style="font-weight:700; font-size:1.13rem; border-radius:12px; padding:.7em 2em; box-shadow:0 3px 18px #43eb2577;">
              <span class="icon"><i class="fas fa-file-excel"></i></span>
              <span>Exportar Excel</span>
            </a>
          <?php endif; ?>
        </div>
      </div>
      <div class="table-responsive" id="table-profissionais">
        <table class="table is-striped is-fullwidth" style="border-radius:10px; width:100%;">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Tipo</th>
              <th>Estado</th>
              <th>Registro</th>
              <th>
                <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                <form method="get" style="display:inline;">
                  <input type="hidden" name="busca" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                  <input type="hidden" name="ordenar" value="<?= htmlspecialchars($_GET['ordenar'] ?? '') ?>">
                  <?php if (!empty($_GET['filial'])): ?>
                  <input type="hidden" name="filial" value="<?= htmlspecialchars($_GET['filial']) ?>">
                  <?php endif; ?>
                  <select name="representante_id" onchange="this.form.submit()" class="custom-select">
                    <option value="">Representantes</option>
                    <?php foreach ($representantes as $rep): ?>
                    <option value="<?= $rep['id'] ?>" <?= (isset($_GET['representante_id']) && $_GET['representante_id'] == $rep['id']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($rep['nome']) ?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                  <?php
                    foreach($_GET as $k => $v) {
                      if ($k !== 'representante_id') {
                        echo '<input type="hidden" name="'.htmlspecialchars($k).'" value="'.htmlspecialchars($v).'">';
                      }
                    }
                  ?>
                </form>
                <?php else: ?>
                Representantes
                <?php endif; ?>
              </th>
              <th>Categoria</th>
              <th>
                <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                <form method="get" style="display:inline;">
                  <input type="hidden" name="busca" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                  <input type="hidden" name="ordenar" value="<?= htmlspecialchars($_GET['ordenar'] ?? '') ?>">
                  <?php if (!empty($_GET['filial'])): ?>
                  <input type="hidden" name="filial" value="<?= htmlspecialchars($_GET['filial']) ?>">
                  <?php endif; ?>
                  <select name="vendedora_id" onchange="this.form.submit()" class="custom-select">
                    <option value="">Vendedoras</option>
                    <?php foreach ($vendedoras as $vend): ?>
                    <option value="<?= $vend['id'] ?>" <?= (isset($_GET['vendedora_id']) && $_GET['vendedora_id'] == $vend['id']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($vend['nome']) ?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                  <?php
                    foreach($_GET as $k => $v) {
                      if ($k !== 'vendedora_id') {
                        echo '<input type="hidden" name="'.htmlspecialchars($k).'" value="'.htmlspecialchars($v).'">';
                      }
                    }
                  ?>
                </form>
                <?php else: ?>
                  Vendedoras
                <?php endif; ?>
              </th>
              <th>Criação</th>
              <th>Filial</th>
              <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
              <th>Ações</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($profissionais as $p): ?>
              <tr>
                <td><?= htmlspecialchars($p['nome_profissional']) ?></td>
                <td><?= htmlspecialchars($p['tipo']) ?></td>
                <td><?= htmlspecialchars($p['estado']) ?></td>
                <td><?= htmlspecialchars($p['registro']) ?></td>
                <td><?= htmlspecialchars($p['representante_nome']) ?></td>
                <td><?= htmlspecialchars($p['categoria']) ?></td>
                <td><?= htmlspecialchars($p['vendedora_nome']) ?></td>
                <td>
                  <?php
                    if (!empty($p['criado_em'])) {
                        $dt = new DateTime($p['criado_em']);
                        echo $dt->format('d/m/Y');
                    }
                  ?>
                </td>
                <td><?= htmlspecialchars($p['filial_nome']) ?></td>
                <td class="col-acoes">
                  <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
                    <a href="/profissionais/edit?id=<?= $p['id'] ?>" class="button is-small is-info" style="font-weight:600;border-radius:7px;margin-right:6px;">
                      Editar
                    </a>
                    <a href="/profissionais/delete?id=<?= $p['id'] ?>" class="button is-small is-danger" style="font-weight:600;border-radius:7px;" onclick="return confirm('Deseja excluir este profissional?')">
                      Excluir
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($profissionais)): ?>
              <tr>
                <td colspan="9" style="text-align:center; padding: 1.5rem; opacity: 0.8; font-style: italic; color: #555;">
                  🔍 Nenhum profissional encontrado.<br>
                  Inicie uma busca para visualizar os resultados.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<!--<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>-->
<script>
  function printTable() {
    var container = document.getElementById('table-profissionais').cloneNode(true);
    var theadThs = container.querySelectorAll('thead th');
    theadThs.forEach(function(th, i) {
      if (th.textContent.trim() === "Ações") {
        th.parentNode.removeChild(th);
        container.querySelectorAll('tbody tr').forEach(function(row){
          if(row.children[i]) row.removeChild(row.children[i]);
        });
      }
    });
    var style = `
      <style>
        body { background: #fff; color: #222; font-family: Montserrat, Arial, sans-serif; margin: 25px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #888; padding: 8px; text-align: left; font-size: 1rem; }
        th { background: #f0f2fa; }
        h2 { font-family: Montserrat, Arial, sans-serif; }
      </style>
    `;
    var win = window.open('', '', 'width=900,height=600');
    win.document.write('<html><head><title>Imprimir Profissionais</title>' + style + '</head><body>');
    win.document.write('<h2>Lista de Profissionais</h2>');
    win.document.write(container.innerHTML);
    win.document.write('</body></html>');
    win.document.close();
    win.focus();
    win.print();
    win.close();
  }
</script>