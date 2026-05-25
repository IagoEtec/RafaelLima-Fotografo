<header>
    <div class="logo">
        <h1>RAFAEL LIMA</h1>
        <span>FOTOGRAFIA</span>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">PORTFÓLIO</a></li>
            <li><a href="pacotes.php">PACOTES</a></li>
            <li><a href="agendamento.php">AGENDAMENTO</a></li>
            <li><a href="index.php#depoimentos">CLIENTES</a></li>
            <li><a href="contato.php">CONTATO</a></li>
            <?php if(isset($_SESSION['usuario_id'])): ?>
                <?php if($_SESSION['usuario_tipo'] == 'admin'): ?>
                    <li><a href="painel_admin.php" style="color:#c5a059;">🔧 ADMIN</a></li>
                <?php else: ?>
                    <li><a href="painel_cliente.php" style="color:#c5a059;">👤 MINHA CONTA</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </nav>
    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <?php if(isset($_SESSION['usuario_id'])): ?>
            <span style="color:#c5a059; font-size:0.8rem;">Olá, <?= $_SESSION['usuario_nome'] ?></span>
            <a href="logout.php" class="btn-outline" style="font-size:0.7rem; padding:5px 15px;">SAIR</a>
        <?php else: ?>
            <a href="login.php" class="btn-gold" style="font-size:0.8rem;">LOGIN</a>
            <a href="registrar.php" class="btn-outline" style="font-size:0.8rem;">REGISTRAR</a>
        <?php endif; ?>
        <a href="agendamento.php" class="btn-gold" style="font-size:0.8rem;">AGENDAR</a>
    </div>
</header>