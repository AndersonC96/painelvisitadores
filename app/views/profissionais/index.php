<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section" style="min-height: 90vh;">
  <div class="container">
    <h1 class="title has-text-white" style="font-size:2.3rem; margin-bottom:1rem;">Profissionais</h1>
    <a href="/profissionais/create" 
       class="button is-link mb-4" 
       style="box-shadow:0 0 16px #2563eb90, 0 0 8px #2563eb50; font-weight:600; font-size:1.1rem; border-radius:10px; padding:0.7em 2em;">
      Novo Profissional
    </a>
    <!-- Barra de pesquisa e filtros -->
    <form method="get" class="mb-5">
      <div class="columns is-multiline is-vcentered">
        <!-- Busca -->
        <div class="column is-5">
          <div class="field has-addons">
            <div class="control is-expanded">
              <input 
                class="input" 
                type="text" 
                name="busca" 
                value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
                placeholder="Buscar por nome, CRM, representante ou vendedora...">
            </div>
            <div class="control">
              <button class="button is-info" type="submit">
                <span class="icon"><i class="fas fa-search"></i></span>
                <span>Buscar</span>
              </button>
            </div>
          </div>
        </div>
        <!-- Filtros de ordenação -->
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
            <a href="/profissionais" class="button is-light">Limpar filtros</a>
          <?php endif; ?>
        </div>
      </div>
    </form>
    <div style="overflow-x:auto; background: #23262d; border-radius: 10px; box-shadow: 0 2px 8px #0001;">
      <table class="table is-striped is-fullwidth" style="background:transparent; color:#fff;">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Registro</th>
            <th>Categoria</th>
            <th>Representante</th>
            <th>Vendedora</th>
            <th>Filial</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($profissionais as $p): ?>
            <tr>
              <td><?= htmlspecialchars($p['nome_profissional']) ?></td>
              <td><?= htmlspecialchars($p['tipo']) ?></td>
              <td><?= htmlspecialchars($p['estado']) ?></td>
              <td><?= htmlspecialchars($p['registro']) ?></td>
              <td><?= htmlspecialchars($p['categoria']) ?></td>
              <td><?= htmlspecialchars($p['representante_nome']) ?></td>
              <td><?= htmlspecialchars($p['vendedora_nome']) ?></td>
              <td><?= htmlspecialchars($p['filial_nome']) ?></td>
              <td>
                <a href="/profissionais/edit?id=<?= $p['id'] ?>" class="button is-small is-info">Editar</a>
                <a href="/profissionais/delete?id=<?= $p['id'] ?>" class="button is-small is-danger" onclick="return confirm('Deseja excluir este profissional?')">Excluir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>