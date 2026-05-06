<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rafael Lima - Fotógrafo Profissional</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">Rafael <span>Lima</span></a>
    <nav>
        <a href="index.php">Home</a>
        <a href="portfolio.php">Portfólio</a>
        <a href="pacotes.php">Pacotes</a>
        <a href="agendamento.php">Agendamento</a>
        <a href="contato.php">Contato</a>
        <a href="login.php">Área do Cliente</a>
    </nav>
</header>

<div class="container">
    <h2>Capturando momentos que contam sua história</h2>
    <p style="margin-bottom:2rem;">Especialista em casamentos, eventos e ensaios fotográficos. Seu grande dia merece as melhores memórias.</p>

    <div style="display:flex; gap: 1rem; margin-bottom:2rem;">
        <a href="portfolio.php" class="btn">Ver Portfólio</a>
        <a href="agendamento.php" class="btn">Agende sua Sessão</a>
    </div>

    <h3>Depoimentos de Clientes</h3>
    <div class="depoimentos">
        <?php
        $stmt = $pdo->query("SELECT nome, texto, data FROM depoimentos WHERE aprovado = 1 ORDER BY data DESC LIMIT 3");
        while($row = $stmt->fetch()):
        ?>
        <div class="depoimento">
            <p>"<?= htmlspecialchars($row['texto']) ?>"</p>
            <strong><?= htmlspecialchars($row['nome']) ?> – <?= date("d/m/Y", strtotime($row['data'])) ?></strong>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<footer>
    <p>Siga nas redes: @raffaellimafotografia | Contato: (11) 99999-9999</p>
    <p>&copy; 2025 Rafael Lima Fotografia</p>
</footer>
</body>
</html>