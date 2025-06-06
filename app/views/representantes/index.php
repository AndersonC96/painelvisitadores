<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section">
  <div class="container">
    <h1 class="title">Representantes</h1>
    <a href="/representantes/create" class="button is-link mb-3">Novo Representante</a>
    <table class="table is-striped is-fullwidth">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Filial</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($representantes as $rep): ?>
          <tr>
            <td><?= htmlspecialchars($rep['nome']) ?></td>
            <td><?= htmlspecialchars($rep['filial_nome']) ?></td>
            <td><?= $rep['ativo'] ? 'Ativo' : 'Inativo' ?></td>
            <td>
              <a href="/representantes/edit?id=<?= $rep['id'] ?>" class="button is-small is-info">Editar</a>
              <a href="/representantes/delete?id=<?= $rep['id'] ?>" class="button is-small is-danger" onclick="return confirm('Deseja excluir este representante?')">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>