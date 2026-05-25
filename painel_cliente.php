<?php
include __DIR__ . '/includes/config.php';
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'cliente') {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar pedidos do cliente
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY data_criacao DESC");
$stmt->execute([$usuario_id]);
$pedidos = $stmt->fetchAll();

// Buscar apenas fotos aprovadas do cliente
$stmt = $pdo->prepare("SELECT * FROM fotos WHERE usuario_id = ? AND status = 'aprovada' ORDER BY data_upload DESC");
$stmt->execute([$usuario_id]);
$fotos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Cliente</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2 style="color:#c5a059;">Bem-vindo, <?= $_SESSION['usuario_nome'] ?>!</h2>
    </div>

    <!-- Status dos Pedidos -->
    <h3 style="margin-top:30px; color:#c5a059;">Meus Pedidos</h3>
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px,1fr)); gap:20px; margin-top:15px;">
        <?php foreach($pedidos as $pedido): ?>
        <div style="background:#141a30; padding:20px; border-radius:10px; border:1px solid #2a2f45;">
            <h4 style="color:#fff;"><?= htmlspecialchars($pedido['nome_evento']) ?></h4>
            <p style="color:#b8b8b8;">Data: <?= date('d/m/Y', strtotime($pedido['data_evento'])) ?></p>
            <p style="color:#b8b8b8;">Pacote: <?= $pedido['pacote'] ?></p>
            <div style="margin-top:10px;">
                <span style="padding:5px 15px; border-radius:20px; font-size:0.8rem; 
                    <?php 
                    if($pedido['status'] == 'em_analise') echo 'background:#ffd700; color:#0a0e1f;';
                    elseif($pedido['status'] == 'aceito') echo 'background:#2ecc71; color:#fff;';
                    else echo 'background:#e74c3c; color:#fff;';
                    ?>">
                    <?= ucfirst(str_replace('_', ' ', $pedido['status'])) ?>
                </span>
            </div>
            <?php if($pedido['mensagem_admin']): ?>
                <p style="margin-top:10px; color:#c5a059; font-size:0.9rem;">Mensagem: <?= htmlspecialchars($pedido['mensagem_admin']) ?></p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Upload de Fotos -->
    <h3 style="margin-top:40px; color:#c5a059;">Minhas Fotos</h3>
    <form action="upload_foto.php" method="POST" enctype="multipart/form-data" style="margin:15px 0;">
        <input type="file" name="foto" required style="background:#0a0e1f; padding:10px; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
        <input type="text" name="descricao" placeholder="Descrição da foto" style="padding:10px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
        <button type="submit" class="btn-gold">UPLOAD</button>
    </form>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:15px;">
        <?php foreach($fotos as $foto): ?>
        <div style="background:#141a30; padding:10px; border-radius:10px;">
            <div style="background:#0a0e1f; height:150px; display:flex; align-items:center; justify-content:center; border-radius:5px;">
                <i class="fas fa-image" style="color:#c5a059; font-size:2rem;"></i>
            </div>
            <p style="font-size:0.8rem; margin-top:5px;"><?= htmlspecialchars($foto['descricao']) ?></p>
            <a href="comentario.php?foto_id=<?= $foto['id'] ?>" style="color:#c5a059; font-size:0.8rem;">Ver comentários</a>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Chat com Rafael -->
    <div style="margin-top:40px; text-align:center;">
        <a href="chat.php" class="btn-gold" style="font-size:1.2rem;">
            <i class="fas fa-comments"></i> CHAT COM RAFAEL
        </a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>