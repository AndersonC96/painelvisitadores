<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php if (!empty($_SESSION['mensagem'])): ?>
    <div class="notification <?= $_SESSION['mensagem_tipo'] ?? 'is-info' ?>">
        <?= htmlspecialchars($_SESSION['mensagem']) ?>
        <button class="delete" onclick="this.parentElement.style.display='none';"></button>
    </div>
    <?php unset($_SESSION['mensagem'], $_SESSION['mensagem_tipo']); ?>
<?php endif; ?>
<section class="section">
    <div class="container">
        <h1 class="title">Usuários</h1>
        <a href="/usuarios/create" class="button is-primary">Novo Usuário</a>
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
    </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>