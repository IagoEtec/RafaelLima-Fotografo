<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pacotes - Rafael Lima</title>
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
    <h1>Pacotes de Serviços</h1>
    <?php
    $pacotes = $pdo->query("SELECT * FROM pacotes ORDER BY preco");
    while($p = $pacotes->fetch()):
    ?>
    <div class="pacote">
        <h2><?= $p['nome'] ?> – R$ <?= number_format($p['preco'], 2, ',', '.') ?></h2>
        <p><?= nl2br(htmlspecialchars($p['descricao'])) ?></p>
        <p><strong>Inclui:</strong> <?= htmlspecialchars($p['itens']) ?></p>
        <a href="agendamento.php?servico=<?= urlencode($p['nome']) ?>" class="btn">Contratar este pacote</a>
    </div>
    <?php endwhile; ?>
</div>
<footer><p>&copy; 2025 Rafael Lima Fotografia</p></footer>
</body>
</html>