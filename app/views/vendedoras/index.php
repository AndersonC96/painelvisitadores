<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section">
  <div class="container">
    <h1 class="title">Vendedoras</h1>
    <a href="/vendedoras/create" class="button is-link mb-4">Nova Vendedora</a>
    <table class="table is-fullwidth is-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Time</th>
          <th>Status</th>
          <th>Criado em</th>
          <th>Ações</th>
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
              <span class="tag is-success">Ativa</span>
            <?php else: ?>
              <span class="tag is-danger">Inativa</span>
            <?php endif; ?>
          </td>
          <td><?= $v['criado_em'] ?></td>
          <td>
            <a href="/vendedoras/edit?id=<?= $v['id'] ?>" class="button is-small is-info">Editar</a>
            <a href="/vendedoras/delete?id=<?= $v['id'] ?>" class="button is-small is-danger" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>