<?php
include __DIR__ . '/includes/config.php';
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['usuario_id'];
$cliente_id = isset($_GET['cliente_id']) ? intval($_GET['cliente_id']) : 0;

// Se um cliente foi selecionado, marcar mensagens como lidas
if($cliente_id > 0) {
    $stmt = $pdo->prepare("UPDATE mensagens_chat SET visualizada = TRUE WHERE remetente_id = ? AND destinatario_id = ?");
    $stmt->execute([$cliente_id, $admin_id]);
}

// Enviar mensagem para cliente
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mensagem']) && $cliente_id > 0) {
    $mensagem = trim($_POST['mensagem']);
    if(!empty($mensagem)) {
        $stmt = $pdo->prepare("INSERT INTO mensagens_chat (remetente_id, destinatario_id, mensagem) VALUES (?, ?, ?)");
        $stmt->execute([$admin_id, $cliente_id, $mensagem]);
    }
}

// Buscar clientes com mensagens não lidas
$stmt = $pdo->query("
    SELECT DISTINCT u.id, u.nome, u.email,
    (SELECT COUNT(*) FROM mensagens_chat WHERE remetente_id = u.id AND destinatario_id = $admin_id AND visualizada = FALSE) as nao_lidas
    FROM usuarios u
    JOIN mensagens_chat m ON (m.remetente_id = u.id OR m.destinatario_id = u.id)
    WHERE u.tipo = 'cliente'
    ORDER BY u.nome
");
$clientes = $stmt->fetchAll();

// Buscar mensagens com cliente selecionado
$mensagens = [];
if($cliente_id > 0) {
    $stmt = $pdo->prepare("
        SELECT m.*, u.nome as remetente_nome 
        FROM mensagens_chat m 
        JOIN usuarios u ON m.remetente_id = u.id
        WHERE (m.remetente_id = ? AND m.destinatario_id = ?) OR (m.remetente_id = ? AND m.destinatario_id = ?)
        ORDER BY m.data_envio ASC
    ");
    $stmt->execute([$admin_id, $cliente_id, $cliente_id, $admin_id]);
    $mensagens = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Chat com Clientes</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <div style="display:flex; gap:20px; height:600px; max-width:1000px; margin:0 auto;">
        
        <!-- Lista de Clientes -->
        <div style="flex: 0 0 250px; background:#141a30; border-radius:10px; border:1px solid #2a2f45; overflow-y:auto;">
            <h4 style="color:#c5a059; padding:15px; border-bottom:1px solid #2a2f45;">Clientes</h4>
            <?php foreach($clientes as $cliente): ?>
            <a href="?cliente_id=<?= $cliente['id'] ?>" style="text-decoration:none; display:block;">
                <div style="padding:12px 15px; border-bottom:1px solid #2a2f45; background:<?= ($cliente_id == $cliente['id']) ? '#1a1f36' : 'transparent'; ?>;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#fff;"><?= htmlspecialchars($cliente['nome']) ?></span>
                        <?php if($cliente['nao_lidas'] > 0): ?>
                        <span style="background:#c5a059; color:#0a0e1f; border-radius:50%; padding:2px 8px; font-size:0.7rem; font-weight:bold;">
                            <?= $cliente['nao_lidas'] ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <span style="font-size:0.7rem; color:#b8b8b8;"><?= htmlspecialchars($cliente['email']) ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Chat -->
        <div style="flex:1; background:#141a30; border-radius:10px; border:1px solid #2a2f45; display:flex; flex-direction:column;">
            <?php if($cliente_id > 0): ?>
                <?php
                $stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE id = ?");
                $stmt->execute([$cliente_id]);
                $cliente_nome = $stmt->fetchColumn();
                ?>
                <div style="padding:15px; border-bottom:1px solid #2a2f45;">
                    <h4 style="color:#c5a059;">Chat com <?= htmlspecialchars($cliente_nome) ?></h4>
                </div>
                
                <div style="flex:1; overflow-y:auto; padding:15px;">
                    <?php foreach($mensagens as $msg): ?>
                    <div style="margin-bottom:10px; text-align:<?= ($msg['remetente_id'] == $admin_id) ? 'right' : 'left'; ?>">
                        <div style="display:inline-block; background:<?= ($msg['remetente_id'] == $admin_id) ? '#c5a059' : '#0a0e1f'; ?>; padding:8px 15px; border-radius:10px; max-width:70%;">
                            <p style="color:<?= ($msg['remetente_id'] == $admin_id) ? '#0a0e1f' : '#fff'; ?>; margin:0;">
                                <?= htmlspecialchars($msg['mensagem']) ?>
                            </p>
                            <span style="font-size:0.6rem; color:#b8b8b8;"><?= date('d/m H:i', strtotime($msg['data_envio'])) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <form method="POST" style="padding:15px; border-top:1px solid #2a2f45; display:flex; gap:10px;">
                    <input type="text" name="mensagem" placeholder="Digite sua mensagem..." required style="flex:1; padding:10px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
                    <button type="submit" class="btn-gold">Enviar</button>
                </form>
            <?php else: ?>
                <div style="flex:1; display:flex; align-items:center; justify-content:center; color:#b8b8b8;">
                    Selecione um cliente para iniciar o chat
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div style="text-align:center; margin-top:20px;">
        <a href="painel_admin.php" class="btn-outline">← Voltar ao Painel</a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>