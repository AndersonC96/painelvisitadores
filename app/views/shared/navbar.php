<nav class="navbar custom-navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item logo-text" href="/">
      <span class="navbar-logo">
        <svg width="32" height="32" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="21" fill="#2563eb"/><rect x="13" y="13" width="22" height="22" rx="7" fill="#fff" /></svg>
      </span>
      <span>Painel Visitadores</span>
    </a>
    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu" onclick="document.getElementById('navbarMenu').classList.toggle('is-active');this.classList.toggle('is-active');">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>
  <div id="navbarMenu" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="/profissionais">Profissionais</a>
      <?php if ($_SESSION['usuario_tipo'] === 'admin'): ?>
        <a class="navbar-item" href="/">Dashboard</a>
        <a class="navbar-item" href="/representantes">Representantes</a>
        <a class="navbar-item" href="/auditoria">Auditoria</a>
        <a class="navbar-item" href="/usuarios">Usuários</a>
        <a class="navbar-item" href="/vendedoras">Vendedoras</a>
        <a class="navbar-item" href="/times">Times</a>
      <?php endif; ?>
    </div>
    <div class="navbar-end">
      <div class="navbar-item">
        <a class="button logout-btn" href="/logout">
          <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
          <span>Sair</span>
        </a>
      </div>
    </div>
  </div>
</nav>