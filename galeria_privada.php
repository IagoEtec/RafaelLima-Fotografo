<?php
include 'includes/config.php';
if(!isset($_SESSION['galeria_user'])) {
    header("Location: galeria_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Minha Galeria - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<section>
    <h2>MINHAS FOTOS</h2>
    <p>Bem-vindo à sua galeria exclusiva</p>
    
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
        <?php for($i=1; $i<=12; $i++): ?>
        <div style="background:#1a1f36; height:150px; border-radius:10px; display:flex; align-items:center; justify-content:center; border:1px solid #2a2f45; cursor:pointer; flex-direction:column;">
            <i class="fas fa-image" style="color:var(--gold); font-size:2rem;"></i>
            <span style="font-size:0.8rem; color:var(--text-light); margin-top:10px;">Foto <?= $i ?></span>
        </div>
        <?php endfor; ?>
    </div>
    
    <a href="index.php" class="btn-outline" style="display:inline-block; margin-top:30px;">← Voltar ao Site</a>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>