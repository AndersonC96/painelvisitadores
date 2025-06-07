<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section" style="min-height:85vh; display:flex; align-items:flex-start;">
    <div class="container" style="max-width:1100px; margin:auto;">
        <div class="box" style="border-radius: 18px; box-shadow: 0 6px 36px 0 #2563eb22, 0 2px 12px 0 #1111; padding: 2.3rem 2.4rem 2.1rem 2.4rem; backdrop-filter: blur(1.5px);">
            <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem 1.3rem;">
                <h1 class="title" style="font-size:2.1rem; font-family:'Montserrat',Segoe UI,sans-serif; font-weight:800;margin-bottom:1.2rem; text-shadow:0 2px 8px #2563eb33;">
                    Usuários
                </h1>
                <a href="/usuarios/create" class="button is-link" style="font-weight:700; font-size:1.13rem; border-radius:12px; padding:.7em 2em; box-shadow:0 3px 18px #2563eb66;">
                    Novo Usuário
                </a>
            </div>
            <form method="GET" action="/usuarios" autocomplete="off" style="margin-bottom:1.2rem;">
                <div class="field has-addons" style="max-width:380px;">
                    <div class="control is-expanded">
                        <input class="input" type="text" name="busca" placeholder="Buscar por nome ou usuário" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>" style="border-radius:10px;">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit" style="border-radius:10px;">
                            <span class="icon"><i class="fas fa-search"></i></span>
                            <span>Buscar</span>
                        </button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table is-striped is-fullwidth" style="border-radius:10px;overflow:hidden;">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Usuário</th>
                            <th>Status</th>
                            <th style="text-align:center;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['nome']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td>
                                <?php if ($user['ativo']): ?>
                                <span class="status-badge">Ativo</span>
                                <?php else: ?>
                                <span class="status-badge inativo">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:center;">
                                <a href="/usuarios/edit?id=<?= $user['id'] ?> "class="button is-small is-info" style="font-weight:600;border-radius:7px;margin-right:6px;">
                                    Editar
                                </a>
                                <a href="/usuarios/delete?id=<?= $user['id'] ?>" class="button is-small is-danger" style="font-weight:600;border-radius:7px;" onclick="return confirm('Excluir este usuário?')">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;opacity:0.7;">Nenhum usuário encontrado.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <nav class="pagination is-centered mt-4" role="navigation">
                <ul class="pagination-list">
                    <?php for ($p = 1; $p <= $totalPaginas; $p++): ?>
                    <li>
                        <a class="pagination-link <?= ($p == $pagina) ? 'is-current' : '' ?>" href="/usuarios?pagina=<?= $p ?>&busca=<?= urlencode($busca) ?>"><?= $p ?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>