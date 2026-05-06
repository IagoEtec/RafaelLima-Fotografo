<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Portfólio - Rafael Lima</title>
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
    <h1>Portfólio</h1>
    <p>Selecione uma categoria:</p>
    <div style="margin-bottom: 2rem;">
        <a href="?categoria=1" class="btn">Casamentos</a>
        <a href="?categoria=2" class="btn">Eventos</a>
        <a href="?categoria=3" class="btn">Ensaios</a>
        <a href="portfolio.php" class="btn">Todos</a>
    </div>

    <div class="galeria">
    <?php
    $cat = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;
    $sql = "SELECT * FROM portfolio";
    if($cat > 0) $sql .= " WHERE categoria_id = $cat";
    $sql .= " ORDER BY id DESC";
    $fotos = $pdo->query($sql);
    while($f = $fotos->fetch()):
    ?>
        <div class="card">
            <img src="uploads/<?= htmlspecialchars($f['imagem']) ?>" alt="<?= $f['titulo'] ?>">
            <div class="card-body">
                <h4><?= $f['titulo'] ?></h4>
                <p><?= $f['descricao'] ?></p>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</div>
<footer><p>&copy; 2025 Rafael Lima Fotografia</p></footer>
</body>
</html>