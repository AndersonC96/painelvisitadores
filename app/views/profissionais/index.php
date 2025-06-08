<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section" style="min-height:85vh; display:flex; align-items:flex-start;">
  <div class="container" style="max-width: 1200px; margin:auto;">
    <div class="box" style="border-radius: 18px; box-shadow: 0 6px 36px 0 #2563eb22, 0 2px 12px 0 #1111; padding: 2.2rem 2.3rem 2.1rem 2.3rem; backdrop-filter: blur(1.5px);">
      <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem 1.3rem;">
        <h1 class="title" style="
            font-size:2.1rem;
            font-family:'Montserrat',Segoe UI,sans-serif;
            font-weight:800;
            margin-bottom:1.2rem;
            text-shadow:0 2px 8px #2563eb33;">
          Profissionais
        </h1>
        <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
        <a href="/profissionais/create" class="button is-link" style="
          font-weight:700;
          font-size:1.13rem;
          border-radius:12px;
          padding:.7em 2em;
          box-shadow:0 3px 18px #2563eb66;">
          Novo Profissional
        </a>
        <?php endif; ?>
      </div>
      <form method="get" action="" autocomplete="off" style="margin-bottom:1.4rem;">
        <div class="columns is-multiline is-vcentered" style="gap:0.8rem 0;">
          <div class="column is-5">
            <div class="field has-addons">
              <div class="control is-expanded">
                <input class="input" type="text" name="busca" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>" placeholder="Buscar por nome, CRM, representante ou vendedora..." style="border-radius:10px;">
              </div>
              <div class="control">
                <button class="button is-link" type="submit" style="border-radius:10px;">
                  <span class="icon"><i class="fas fa-search"></i></span>
                  <span>Buscar</span>
                </button>
              </div>
            </div>
          </div>
          <div class="column is-3">
            <div class="select is-fullwidth">
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
          </div>
          <div class="column is-2">
            <?php if (!empty($_GET['busca']) || !empty($_GET['ordenar'])): ?>
              <a href="/profissionais" class="button is-light" style="border-radius:10px;">Limpar filtros</a>
            <?php endif; ?>
          </div>
        </div>
      </form>
      <div class="table-responsive">
        <table class="table is-striped is-fullwidth" style="border-radius:10px;overflow:hidden;">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Tipo</th>
              <th>Estado</th>
              <th>Registro</th>
              <th>Representante</th>
              <th>Vendedora</th>
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
                <td><?= htmlspecialchars($p['vendedora_nome']) ?></td>
                <td><?= htmlspecialchars($p['filial_nome']) ?></td>
                <td>
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
                <td colspan="9" style="text-align:center;opacity:0.7;">Nenhum profissional encontrado.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>