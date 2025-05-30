<?php require dirname(__DIR__, 2) . '/views/shared/header.php'; ?>
<?php require dirname(__DIR__, 2) . '/views/shared/navbar.php'; ?>
<?php include dirname(__DIR__, 2) . '/views/shared/flash.php'; ?>
<section class="section">
  <div class="container" style="max-width: 500px;">
    <h1 class="title">Novo Usuário</h1>
    <form method="POST" action="/usuarios/store">
      <div class="field">
        <label class="label">Nome</label>
        <div class="control">
          <input class="input" type="text" name="nome" required maxlength="120">
        </div>
      </div>
      <div class="field">
        <label class="label">Usuário</label>
        <div class="control">
          <input class="input" type="text" name="username" required maxlength="60">
        </div>
      </div>
      <div class="field">
        <label class="label">Senha</label>
        <div class="control">
          <input class="input" type="password" name="senha" required minlength="6">
        </div>
      </div>
      <div class="field">
        <label class="label">Filial</label>
        <div class="control">
          <div class="select">
            <select name="filial" required>
                <option value="SP">São Paulo</option>
                <option value="BSB">Brasília</option>
            </select>
          </div>
      </div>
      <div class="field">
        <label class="label">Nível de Acesso</label>
        <div class="control">
          <div class="select">
            <select name="tipo" required>
                <option value="comum">Orçamentista</option>
                <option value="admin">Administrador</option>
            </select>
          </div>
        </div>
      </div>
      <div class="field">
        <label class="checkbox">
          <input type="checkbox" name="ativo" checked>
          Ativo
        </label>
      </div>
      <div class="field is-grouped mt-4">
        <div class="control">
          <button class="button is-link" type="submit">Salvar</button>
        </div>
        <div class="control">
          <a class="button is-light" href="/usuarios">Cancelar</a>
        </div>
      </div>
    </form>
  </div>
</section>
<?php require dirname(__DIR__, 2) . '/views/shared/footer.php'; ?>