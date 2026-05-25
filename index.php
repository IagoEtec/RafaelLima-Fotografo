<?php include __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rafael Lima Fotografia</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <h1>CAPTURANDO MOMENTOS <span>QUE DURAM PARA SEMPRE</span></h1>
        <p>Fotografia de casamentos, eventos e ensaios com sensibilidade, arte e profissionalismo desde 2015.</p>
        <div class="hero-btn-group">
            <a href="portfolio.php" class="btn-outline">VER PORTFÓLIO</a>
            <a href="contato.php" class="btn-gold">SOLICITAR ORÇAMENTO</a>
        </div>
        <div class="stats">
            <div><h3>500+</h3><span>Eventos Realizados</span></div>
            <div><h3>8</h3><span>Anos de Experiência</span></div>
            <div><h3>98%</h3><span>Clientes Satisfeitos</span></div>
        </div>
    </div>
    <div class="hero-img">
        <i class="fas fa-camera fa-4x" style="color: var(--gold);"></i>
    </div>
</section>

<!-- PORTFOLIO -->
<section>
    <h2>PORTFÓLIO</h2>
    <p>Conheça nosso trabalho através das categorias abaixo</p>
    <div class="portfolio-grid">
        <div class="portfolio-card">
            <i class="fas fa-church"></i>
            <h3>CASAMENTOS</h3>
            <small>120+ fotos</small>
            <a href="portfolio.php?cat=casamentos">VER GALERIA →</a>
        </div>
        <div class="portfolio-card">
            <i class="fas fa-glass-cheers"></i>
            <h3>EVENTOS</h3>
            <small>85+ fotos</small>
            <a href="portfolio.php?cat=eventos">VER GALERIA →</a>
        </div>
        <div class="portfolio-card">
            <i class="fas fa-portrait"></i>
            <h3>ENSAIOS</h3>
            <small>65+ fotos</small>
            <a href="portfolio.php?cat=ensaios">VER GALERIA →</a>
        </div>
    </div>
</section>

<!-- PACOTES -->
<section>
    <h2>PACOTES E PREÇOS</h2>
    <p>Escolha o plano ideal para eternizar seus momentos especiais</p>
    <div class="pacotes-grid">
        <div class="pacote-card">
            <h3>BÁSICO</h3>
            <div class="price">R$ 1.500</div>
            <ul>
                <li>✓ 4 horas de cobertura</li>
                <li>✓ 200 fotos editadas</li>
                <li>✓ Álbum digital</li>
                <li>✓ Galeria online privada</li>
            </ul>
            <a href="contato.php" class="btn-outline">CONTRATAR</a>
        </div>
        <div class="pacote-card destaque">
            <h3>PREMIUM</h3>
            <div class="price">R$ 3.200</div>
            <ul>
                <li>✓ 8 horas de cobertura</li>
                <li>✓ 500 fotos editadas</li>
                <li>✓ Álbum impresso capa dura</li>
                <li>✓ Video highlight</li>
            </ul>
            <a href="agendamento.php" class="btn-gold">CONTRATAR</a>
        </div>
        <div class="pacote-card">
            <h3>ELITE</h3>
            <div class="price">R$ 5.800</div>
            <ul>
                <li>✓ 12 horas de cobertura</li>
                <li>✓ 800+ fotos editadas</li>
                <li>✓ Álbum de luxo personalizado</li>
                <li>✓ Ensaio pré-wedding</li>
            </ul>
            <a href="contato.php" class="btn-outline">CONTRATAR</a>
        </div>
    </div>
</section>

<!-- DEPOIMENTOS -->
<section id="depoimentos">
    <h2>DEPOIMENTOS</h2>
    <p>O que nossos clientes dizem sobre nosso trabalho</p>
    <div class="depoimentos-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM depoimentos ORDER BY data_postagem DESC LIMIT 3");
        while($dep = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
        <div class="depoimento-card">
            <i class="fas fa-quote-left"></i>
            <div class="stars">★★★★★</div>
            <p>"<?= htmlspecialchars($dep['texto']) ?>"</p>
            <h4><?= htmlspecialchars($dep['nome_cliente']) ?></h4>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>