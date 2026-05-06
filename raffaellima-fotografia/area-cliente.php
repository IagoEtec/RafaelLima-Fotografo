<?php
session_start();
if(!isset($_SESSION['cliente_id'])){
    header('Location: login.php');
    exit;
}
// Exibe fotos da pasta privada. Adapte conforme sua regra de negócio.
$fotos = glob('galerias/privadas/*.{jpg,png,jpeg}', GLOB_BRACE);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"><title>Minha Galeria - Rafael Lima</title><link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">Olá, <?= $_SESSION['cliente_nome'] ?></a>
    <nav><a href="logout.php">Sair</a></nav>
</header>
<div class="container">
    <h1>Galeria Privada</h1>
    <div class="galeria">
        <?php foreach($fotos as $img): ?>
        <div class="card"><img src="<?= $img ?>" alt="foto"></div>
        <?php endforeach; ?>
    </div>
    <p><em>As fotos são de uso exclusivo, protegidas por senha.</em></p>
</div>
</body>
</html>