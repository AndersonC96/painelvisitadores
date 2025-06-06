<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<?php
use App\Models\Time;
use App\Models\Representante;
?>
<section class="section">
  <div class="container">
    <h1 class="title">Times</h1>
    <a href="/times/create" class="button is-link mb-3">Novo Time</a>
    <table class="table is-striped is-fullwidth">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Filial</th>
          <th>Representantes</th>
          <th>Vendedoras</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($times as $time): ?>
          <tr>
            <td><?= htmlspecialchars($time['nome']) ?></td>
            <td><?= htmlspecialchars($time['filial_nome']) ?></td>
            <td>
              <?php
                $representante_ids = Time::representantesDoTime($time['id']);
                if (count($representante_ids)) {
                  $nomes = [];
                  foreach ($representante_ids as $rid) {
                    $rep = Representante::buscarPorId($rid);
                    if ($rep) $nomes[] = htmlspecialchars($rep['nome']);
                  }
                  echo implode('<br>', $nomes);
                } else {
                  echo '<span class="has-text-grey-light">Nenhum</span>';
                }
              ?>
            </td>
            <td>
              <?php
                $vendedoras = Time::vendedorasDoTime($time['id']);
                if (count($vendedoras)) {
                  echo implode('<br>', array_map('htmlspecialchars', $vendedoras));
                } else {
                  echo '<span class="has-text-grey-light">Nenhuma</span>';
                }
              ?>
            </td>
            <td><?= $time['ativo'] ? 'Ativo' : 'Inativo' ?></td>
            <td>
              <a href="/times/edit?id=<?= $time['id'] ?>" class="button is-small is-info">Editar</a>
              <a href="/times/delete?id=<?= $time['id'] ?>" class="button is-small is-danger" onclick="return confirm('Deseja excluir este time?')">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>