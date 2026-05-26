<?php include __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Galeria de Casamentos - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .galeria-header {
            text-align: center;
            padding: 40px 0;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--dark-blue-light) 100%);
            margin-bottom: 40px;
        }
        
        .galeria-header h1 {
            color: var(--gold);
            font-size: 2.5rem;
        }
        
        .galeria-header p {
            color: var(--text-light);
            margin-top: 10px;
        }
        
        .galeria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }
        
        .galeria-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            cursor: pointer;
            aspect-ratio: 1 / 1;
        }
        
        .galeria-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .galeria-item:hover img {
            transform: scale(1.1);
        }
        
        .galeria-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 20px;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }
        
        .galeria-item:hover .galeria-overlay {
            transform: translateY(0);
        }
        
        .galeria-overlay h3 {
            color: var(--gold);
            font-size: 1rem;
        }
        
        .galeria-overlay p {
            color: #fff;
            font-size: 0.8rem;
        }
        
        .voltar-btn {
            text-align: center;
            margin: 50px 0;
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="galeria-header">
    <h1><i class="fas fa-church"></i> Casamentos</h1>
    <p>Momentos únicos e eternos dos nossos casais</p>
</div>

<section>
    <div class="galeria-grid">
        <?php
        // Fotos de exemplo para casamentos
        $fotos_casamentos = [
            ['img' => 'assets/img/casamento1.jpg', 'titulo' => 'Ana & Pedro', 'data' => '15/03/2025'],
            ['img' => 'assets/img/casamento2.jpg', 'titulo' => 'Mariana & Lucas', 'data' => '22/02/2025'],
            ['img' => 'assets/img/casamento3.jpg', 'titulo' => 'Fernanda & Rafael', 'data' => '10/01/2025'],
            ['img' => 'assets/img/casamento4.jpg', 'titulo' => 'Camila & Bruno', 'data' => '05/12/2024'],
            ['img' => 'assets/img/casamento5.jpg', 'titulo' => 'Juliana & Marcos', 'data' => '18/11/2024'],
            ['img' => 'assets/img/casamento6.jpg', 'titulo' => 'Patrícia & André', 'data' => '30/10/2024'],
        ];
        
        foreach($fotos_casamentos as $foto):
        ?>
        <div class="galeria-item">
            <img src="<?php echo $foto['img']; ?>" alt="<?php echo $foto['titulo']; ?>">
            <div class="galeria-overlay">
                <h3><?php echo $foto['titulo']; ?></h3>
                <p><i class="far fa-calendar-alt"></i> <?php echo $foto['data']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="voltar-btn">
        <a href="portfolio.php" class="btn-outline"><i class="fas fa-arrow-left"></i> Voltar ao Portfólio</a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>