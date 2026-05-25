<?php
include __DIR__ . '/includes/config.php';
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$foto_id = $_GET['foto_id'] ?? 0;

// Enviar comentário
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comentario'])) {
    $comentario = trim($_POST['comentario']);
    if(!empty($comentario)) {
        $stmt = $pdo->prepare("INSERT INTO comentarios (foto_id, usuario_id, comentario, status) VALUES (?, ?, ?, 'pendente')");
        $stmt->execute([$foto_id, $_SESSION['usuario_id'], $comentario]);
    }
}

// Buscar foto
$stmt = $pdo->prepare("SELECT * FROM fotos WHERE id = ?");
$stmt->execute([$foto_id]);
$foto = $stmt->fetch();

// Buscar apenas comentários aprovados
$stmt = $pdo->prepare("SELECT c.*, u.nome as autor FROM comentarios c JOIN usuarios u ON c.usuario_id = u.id WHERE c.foto_id = ? AND c.status = 'aprovado' ORDER BY c.data_comentario DESC");
$stmt->execute([$foto_id]);
$comentarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comentários</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <div style="max-width:600px; margin:0 auto;">
        <h2 style="color:#c5a059;">Comentários</h2>
        
        <?php if($foto): ?>
        <div style="background:#141a30; padding:15px; border-radius:10px; margin:15px 0;">
            <div style="background:#0a0e1f; height:150px; display:flex; align-items:center; justify-content:center; border-radius:5px;">
                <i class="fas fa-image" style="color:#c5a059; font-size:2rem;"></i>
            </div>
            <p style="color:#b8b8b8; margin-top:10px;"><?= htmlspecialchars($foto['descricao']) ?></p>
        </div>
        <?php endif; ?>

        <div style="background:#0a0e1f; border:1px solid #2a2f45; border-radius:10px; padding:15px; max-height:400px; overflow-y:auto;">
            <?php foreach($comentarios as $com): ?>
            <div style="background:#141a30; padding:10px; border-radius:5px; margin-bottom:10px;">
                <strong style="color:#c5a059;"><?= htmlspecialchars($com['autor']) ?></strong>
                <span style="font-size:0.7rem; color:#b8b8b8;"><?= date('d/m H:i', strtotime($com['data_comentario'])) ?></span>
                <p style="color:#fff; margin-top:5px;"><?= htmlspecialchars($com['comentario']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <form method="POST" style="margin-top:15px;">
            <textarea name="comentario" rows="3" placeholder="Digite seu comentário..." required style="width:100%; padding:10px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff; resize:vertical;"></textarea>
            <button type="submit" class="btn-gold" style="margin-top:10px;">ENVIAR COMENTÁRIO</button>
        </form>

        <div style="text-align:center; margin-top:20px;">
            <a href="painel_cliente.php" class="btn-outline">← Voltar</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>