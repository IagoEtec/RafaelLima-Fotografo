<?php include __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Galeria de Ensaios - Rafael Lima</title>
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
    <h1><i class="fas fa-portrait"></i> Ensaios Fotográficos</h1>
    <p>Ensaios personalizados que contam sua história</p>
</div>

<section>
    <div class="galeria-grid">
        <?php
        $fotos_ensaios = [
            ['img' => 'assets/img/ensaio1.jpg', 'titulo' => 'Beatriz - Formatura', 'data' => '10/03/2025'],
            ['img' => 'assets/img/ensaio2.jpg', 'titulo' => 'Família Santos', 'data' => '01/03/2025'],
            ['img' => 'assets/img/ensaio3.jpg', 'titulo' => 'Laura - 15 Anos', 'data' => '20/02/2025'],
            ['img' => 'assets/img/ensaio4.jpg', 'titulo' => 'Ensaio Gestante', 'data' => '05/01/2025'],
            ['img' => 'assets/img/ensaio5.jpg', 'titulo' => 'Casal Renato & Carla', 'data' => '15/12/2024'],
            ['img' => 'assets/img/ensaio6.jpg', 'titulo' => 'Ensaio Newborn', 'data' => '28/11/2024'],
        ];
        
        foreach($fotos_ensaios as $foto):
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