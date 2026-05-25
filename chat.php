<?php
include __DIR__ . '/includes/config.php';
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$admin_id = 1; // ID do admin (Rafael Lima)

// Enviar mensagem
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mensagem'])) {
    $mensagem = trim($_POST['mensagem']);
    if(!empty($mensagem)) {
        $stmt = $pdo->prepare("INSERT INTO mensagens_chat (remetente_id, destinatario_id, mensagem) VALUES (?, ?, ?)");
        $stmt->execute([$usuario_id, $admin_id, $mensagem]);
    }
}

// Buscar mensagens
$stmt = $pdo->prepare("SELECT * FROM mensagens_chat WHERE (remetente_id = ? AND destinatario_id = ?) OR (remetente_id = ? AND destinatario_id = ?) ORDER BY data_envio ASC");
$stmt->execute([$usuario_id, $admin_id, $admin_id, $usuario_id]);
$mensagens = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Chat com Rafael</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <div style="max-width:800px; margin:0 auto;">
        <h2 style="color:#c5a059; text-align:center;">Chat com Rafael Lima</h2>
        
        <div style="background:#0a0e1f; border:1px solid #2a2f45; border-radius:10px; height:400px; overflow-y:auto; padding:20px; margin-top:20px;">
            <?php foreach($mensagens as $msg): ?>
            <div style="margin-bottom:15px; text-align:<?= ($msg['remetente_id'] == $usuario_id) ? 'right' : 'left'; ?>">
                <div style="display:inline-block; background:<?= ($msg['remetente_id'] == $usuario_id) ? '#c5a059' : '#141a30'; ?>; padding:10px 15px; border-radius:10px; max-width:70%;">
                    <p style="color:<?= ($msg['remetente_id'] == $usuario_id) ? '#0a0e1f' : '#fff'; ?>; margin:0;"><?= htmlspecialchars($msg['mensagem']) ?></p>
                    <span style="font-size:0.6rem; color:#b8b8b8;"><?= date('H:i', strtotime($msg['data_envio'])) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <form method="POST" style="margin-top:15px; display:flex; gap:10px;">
            <input type="text" name="mensagem" placeholder="Digite sua mensagem..." required style="flex:1; padding:12px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
            <button type="submit" class="btn-gold">Enviar</button>
        </form>
        
        <div style="text-align:center; margin-top:20px;">
            <a href="<?= ($_SESSION['usuario_tipo'] == 'admin') ? 'painel_admin.php' : 'painel_cliente.php'; ?>" class="btn-outline">← Voltar</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>