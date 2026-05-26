<?php include __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Portfólio - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <h2>PORTFÓLIO COMPLETO</h2>
    <p>Explore todas as nossas categorias</p>
    
    <div class="portfolio-grid">
        <div class="portfolio-card">
            <i class="fas fa-church"></i>
            <h3>CASAMENTOS</h3>
            <small>120+ fotos</small>
            <a href="galeria-casamentos.php">VER GALERIA →</a>
        </div>
        <div class="portfolio-card">
            <i class="fas fa-glass-cheers"></i>
            <h3>EVENTOS</h3>
            <small>85+ fotos</small>
            <a href="galeria-eventos.php">VER GALERIA →</a>
        </div>
        <div class="portfolio-card">
            <i class="fas fa-portrait"></i>
            <h3>ENSAIOS</h3>
            <small>65+ fotos</small>
            <a href="galeria-ensaios.php">VER GALERIA →</a>
        </div>
    </div>
    
    <a href="index.php" class="btn-outline" style="display:inline-block; margin-top:30px;">← Voltar ao Início</a>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>