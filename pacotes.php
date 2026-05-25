<?php include __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pacotes - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

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

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>