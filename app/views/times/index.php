<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<?php
  use App\Models\Time;
  use App\Models\Representante;
?>
<section class="section" style="min-height:85vh;">
  <div class="container" style="max-width:1200px;margin:auto;">
    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem 1.3rem; margin-bottom:1.2rem;">
      <h1 class="title" style="
          font-size:2.1rem;
          font-family:'Montserrat',Segoe UI,sans-serif;
          font-weight:800;
          margin-bottom:0;
          text-shadow:0 2px 8px #2563eb33;">
        Times
      </h1>
      <a href="/times/create" class="button is-link" style="
        font-weight:700;
        font-size:1.13rem;
        border-radius:12px;
        padding:.7em 2em;
        box-shadow:0 3px 18px #2563eb66;">
        Novo Time
      </a>
    </div>
    <!-- Grid de cards -->
    <div class="columns is-multiline" style="gap:1.5rem 0;">
      <?php foreach ($times as $time): ?>
        <div class="column is-4-desktop is-6-tablet" style="display:flex;">
          <div class="box" style="width:100%; border-radius:18px; box-shadow: 0 6px 36px 0 #2563eb22, 0 2px 12px 0 #1111; padding:2.1rem 2rem 1.7rem 2rem; display:flex; flex-direction:column; justify-content:space-between;">
            <div>
              <div style="display:flex;align-items:center;gap:.5rem 1rem;justify-content:space-between;">
                <h2 class="title" style="font-size:1.3rem;margin-bottom:0;font-weight:800;letter-spacing:0.01em;text-shadow:0 1.5px 6px #2563eb1a;">
                  <?= htmlspecialchars($time['nome']) ?>
                </h2>
                <?php if ($time['ativo']): ?>
                  <span class="status-badge" style="background:#e9faec;color:#219c34;font-weight:700;padding:.28em 1em;border-radius:7px;font-size:1.07em;box-shadow:0 2px 8px #3fff180c;">Ativo</span>
                <?php else: ?>
                  <span class="status-badge inativo" style="background:#fbe6e7;color:#db2d43;font-weight:700;padding:.28em 1em;border-radius:7px;font-size:1.07em;box-shadow:0 2px 8px #db2d430c;">Inativo</span>
                <?php endif; ?>
              </div>
              <div style="margin:.7rem 0 0 0;">
                <span style="font-weight:600;color:#5976b8;font-size:.97em;">Filial:</span>
                <span style="font-weight:600"><?= htmlspecialchars($time['filial_nome']) ?></span>
              </div>
              <div style="margin:.4rem 0 0 0;">
                <span style="font-weight:600;color:#5976b8;font-size:.97em;">Representantes</span>
                <br>
                <?php
                  $representante_ids = Time::representantesDoTime($time['id']);
                  if (count($representante_ids)) {
                    $nomes = [];
                    foreach ($representante_ids as $rid) {
                      $rep = Representante::buscarPorId($rid);
                      if ($rep) $nomes[] = '<span style="display:inline-block;background:#2563eb10;padding:2px 9px;border-radius:7px;font-weight:600;margin:2px 3px 2px 0;">' . htmlspecialchars($rep['nome']) . '</span>';
                    }
                    echo implode(' ', $nomes);
                  } else {
                    echo '<span class="has-text-grey-light">Nenhum</span>';
                  }
                ?>
              </div>
              <div style="margin:.4rem 0 0 0;">
                <span style="font-weight:600;color:#5976b8;font-size:.97em;">Vendedoras</span>
                <br>
                <?php
                  $vendedoras = Time::vendedorasDoTime($time['id']);
                  if (count($vendedoras)) {
                    echo implode(' ', array_map(fn($v) => '<span style="display:inline-block;background:#fbbc0520;padding:2px 9px;border-radius:7px;font-weight:600;margin:2px 3px 2px 0;">'.htmlspecialchars($v).'</span>', $vendedoras));
                  } else {
                    echo '<span class="has-text-grey-light">Nenhuma</span>';
                  }
                ?>
              </div>
            </div>
            <div style="margin-top:1.3rem;display:flex;gap:1rem;">
              <a href="/times/edit?id=<?= $time['id'] ?>" class="button is-small is-info" style="font-weight:600;border-radius:8px;">Editar</a>
              <a href="/times/delete?id=<?= $time['id'] ?>" class="button is-small is-danger" style="font-weight:600;border-radius:8px;" onclick="return confirm('Deseja excluir este time?')">Excluir</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($times)): ?>
        <div class="column is-12" style="text-align:center;opacity:.7;">
          Nenhum time encontrado.
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>