<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section">
    <div class="container">
        <h1 class="title">Usuários</h1>
        <a href="/usuarios/create" class="button is-primary">Novo Usuário</a>
        <form method="GET" action="/usuarios" class="mb-4">
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input class="input" type="text" name="busca" placeholder="Buscar por nome ou usuário" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                </div>
                <div class="control">
                    <button class="button is-link">Buscar</button>
                </div>
            </div>
        </form>
        <table class="table is-striped is-fullwidth">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>Status</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['nome']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= $user['ativo'] ? 'Ativo' : 'Inativo' ?></td>
                    <td><?= $user['criado_em'] ?></td>
                    <td>
                        <a href="/usuarios/edit?id=<?= $user['id'] ?>" class="button is-small is-info">Editar</a>
                        <a href="/usuarios/delete?id=<?= $user['id'] ?>" class="button is-small is-danger" onclick="return confirm('Excluir este usuário?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <nav class="pagination is-centered mt-4" role="navigation">
            <ul class="pagination-list">
                <?php for ($p = 1; $p <= $totalPaginas; $p++): ?>
                <li>
                    <a class="pagination-link <?= ($p == $pagina) ? 'is-current' : '' ?>"href="/usuarios?pagina=<?= $p ?>&busca=<?= urlencode($busca) ?>"><?= $p ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>