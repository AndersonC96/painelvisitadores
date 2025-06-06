<?php
    $title = "Dashboard - Painel Visitadores";
    require dirname(__DIR__) . '/shared/header.php';
    require dirname(__DIR__) . '/shared/navbar.php';
    $nomeUsuario = isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : 'Usuário';
    function saudacao() {
        date_default_timezone_set('America/Sao_Paulo');
        $hora = intval(date('H'));
        if ($hora >= 5 && $hora < 12) return "Bom dia";
        if ($hora >= 12 && $hora < 18) return "Boa tarde";
        return "Boa noite";
    }
?>
<section class="section">
    <div class="container" style="max-width: 480px; margin-top: 40px;">
        <div class="box has-text-centered" style="background: rgba(30,41,59,0.7); box-shadow: 0 4px 32px #33415577;">
            <svg width="44" height="44" fill="none" viewBox="0 0 48 48" style="margin-bottom: 12px;">
                <rect width="48" height="48" rx="12" fill="#2563eb"/>
                <path d="M14 33c0-5.33 7.33-8 10-8s10 2.67 10 8v2a2 2 0 0 1-2 2H16a2 2 0 0 1-2-2v-2z" fill="#fff" opacity="0.18"/>
                <circle cx="24" cy="21" r="6" fill="#fff" opacity="0.85"/>
            </svg>
            <h1 class="title" style="color: #fff;">
                <?= saudacao() ?>, <span style="color:#60a5fa"><?= htmlspecialchars($nomeUsuario) ?></span>
            </h1>
            <p style="color: #cbd5e1;">Use o menu acima para navegar pelo sistema.</p>
        </div>
    </div>
</section>
<?php require dirname(__DIR__) . '/shared/footer.php'; ?>