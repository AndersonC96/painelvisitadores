<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>

<section class="section" style="min-height:85vh; display:flex; align-items:flex-start;">
  <div class="container" style="max-width:1050px; margin:auto;">
    <div class="box" style="
      border-radius: 18px;
      box-shadow: 0 6px 36px 0 #2563eb22, 0 2px 12px 0 #1111;
      padding: 2.2rem 2.3rem 2.1rem 2.3rem;
      backdrop-filter: blur(1.5px);">
      
      <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem 1.3rem;">
        <h1 class="title" style="
            font-size:2.1rem;
            font-family:'Montserrat',Segoe UI,sans-serif;
            font-weight:800;
            margin-bottom:1.2rem;
            text-shadow:0 2px 8px #2563eb33;">
          Vendedoras
        </h1>
        <a href="/vendedoras/create" class="button is-link" style="
          font-weight:700;
          font-size:1.13rem;
          border-radius:12px;
          padding:.7em 2em;
          box-shadow:0 3px 18px #2563eb66;">
          Nova Vendedora
        </a>
      </div>
      <!-- Campo de busca -->
      <form method="get" action="" autocomplete="off" style="margin-bottom:1.2rem;">
        <div class="field has-addons" style="max-width:380px;">
          <div class="control is-expanded">
            <input class="input" type="text" name="busca" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
              placeholder="Buscar por nome, time ou status..." style="border-radius:10px;">
          </div>
          <div class="control">
            <button class="button is-link" type="submit" style="border-radius:10px;">Buscar</button>
          </div>
        </div>
      </form>
      <div class="table-responsive">
        <table class="table is-striped is-fullwidth" style="border-radius:10px;overflow:hidden;">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Time</th>
              <th>Status</th>
              <th style="text-align:center;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($vendedoras as $v): ?>
            <tr>
              <td><?= $v['id'] ?></td>
              <td><?= htmlspecialchars($v['nome']) ?></td>
              <td><?= htmlspecialchars($v['time_nome'] ?? '-') ?></td>
              <td>
                <?php if ($v['ativo']): ?>
                  <span class="status-badge">Ativa</span>
                <?php else: ?>
                  <span class="status-badge inativo">Inativa</span>
                <?php endif; ?>
              </td>
              <td style="text-align:center;">
                <a href="/vendedoras/edit?id=<?= $v['id'] ?>" class="button is-small is-info" style="font-weight:600;border-radius:7px;margin-right:6px;">
                  Editar
                </a>
                <a href="/vendedoras/delete?id=<?= $v['id'] ?>" class="button is-small is-danger" style="font-weight:600;border-radius:7px;" onclick="return confirm('Deseja realmente excluir?')">
                  Excluir
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($vendedoras)): ?>
              <tr>
                <td colspan="6" style="text-align:center;opacity:0.7;">Nenhuma vendedora encontrada.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Paginação -->
      <?php if ($totalPaginas > 1): ?>
        <nav class="pagination is-centered mt-4" role="navigation">
          <ul class="pagination-list">
            <?php for ($p = 1; $p <= $totalPaginas; $p++): ?>
              <li>
                <a class="pagination-link <?= ($p == $pagina) ? 'is-current' : '' ?>"
                  href="/vendedoras?pagina=<?= $p ?>&busca=<?= urlencode($busca) ?>">
                  <?= $p ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>

    </div>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>
