<?php
include __DIR__ . '/includes/config.php';
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Processar ações
if(isset($_POST['acao_pedido'])) {
    $status = $_POST['acao_pedido'] == 'aceitar' ? 'aceito' : 'recusado';
    $mensagem = $_POST['mensagem'] ?? '';
    $stmt = $pdo->prepare("UPDATE pedidos SET status = ?, mensagem_admin = ? WHERE id = ?");
    $stmt->execute([$status, $mensagem, $_POST['pedido_id']]);
}

if(isset($_POST['acao_foto'])) {
    $status = $_POST['acao_foto'];
    $stmt = $pdo->prepare("UPDATE fotos SET status = ? WHERE id = ?");
    $stmt->execute([$status, $_POST['foto_id']]);
}

if(isset($_POST['acao_comentario'])) {
    $status = $_POST['acao_comentario'];
    $stmt = $pdo->prepare("UPDATE comentarios SET status = ? WHERE id = ?");
    $stmt->execute([$status, $_POST['comentario_id']]);
}

// Buscar dados
$pedidos = $pdo->query("SELECT p.*, u.nome as cliente_nome, u.email as cliente_email FROM pedidos p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.data_criacao DESC")->fetchAll();
$fotos_pendentes = $pdo->query("SELECT f.*, u.nome as cliente_nome FROM fotos f JOIN usuarios u ON f.usuario_id = u.id WHERE f.status = 'pendente' ORDER BY f.data_upload DESC")->fetchAll();
$comentarios_pendentes = $pdo->query("SELECT c.*, u.nome as autor, f.descricao as foto_desc FROM comentarios c JOIN usuarios u ON c.usuario_id = u.id JOIN fotos f ON c.foto_id = f.id WHERE c.status = 'pendente' ORDER BY c.data_comentario DESC")->fetchAll();
$clientes = $pdo->query("SELECT * FROM usuarios WHERE tipo = 'cliente'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <h2 style="color:#c5a059;">🔧 Painel Administrativo</h2>

    <!-- Menu do Admin -->
    <div style="display:flex; gap:20px; flex-wrap:wrap; margin:20px 0;">
        <a href="admin_chat.php" class="btn-gold" style="font-size:1rem;">
            <i class="fas fa-comments"></i> CHAT COM CLIENTES
        </a>
        <a href="logout.php" class="btn-outline">SAIR</a>
    </div>

    <!-- Pedidos -->
    <h3 style="color:#c5a059; margin-top:30px;">📋 Pedidos de Agendamento</h3>
    <div style="display:grid; gap:15px; margin-top:15px;">
        <?php foreach($pedidos as $pedido): ?>
        <div style="background:#141a30; padding:15px; border-radius:10px; border:1px solid #2a2f45;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap;">
                <div>
                    <h4 style="color:#fff;"><?= htmlspecialchars($pedido['nome_evento']) ?></h4>
                    <p style="color:#b8b8b8;">Cliente: <?= htmlspecialchars($pedido['cliente_nome']) ?> (<?= htmlspecialchars($pedido['cliente_email']) ?>)</p>
                    <p style="color:#b8b8b8;">Data: <?= date('d/m/Y', strtotime($pedido['data_evento'])) ?> | Pacote: <?= $pedido['pacote'] ?></p>
                    <span style="padding:3px 12px; border-radius:15px; font-size:0.75rem;
                        <?php 
                        if($pedido['status'] == 'em_analise') echo 'background:#ffd700; color:#0a0e1f;';
                        elseif($pedido['status'] == 'aceito') echo 'background:#2ecc71; color:#fff;';
                        else echo 'background:#e74c3c; color:#fff;';
                        ?>">
                        <?= ucfirst(str_replace('_', ' ', $pedido['status'])) ?>
                    </span>
                </div>
                
                <?php if($pedido['status'] == 'em_analise'): ?>
                <div style="margin-top:10px;">
                    <form method="POST" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                        <input type="hidden" name="pedido_id" value="<?= $pedido['id'] ?>">
                        <input type="text" name="mensagem" placeholder="Mensagem..." style="padding:5px 10px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff; font-size:0.9rem;">
                        <button type="submit" name="acao_pedido" value="aceitar" class="btn-gold" style="padding:5px 20px; font-size:0.9rem;">Aceitar</button>
                        <button type="submit" name="acao_pedido" value="recusar" class="btn-outline" style="padding:5px 20px; font-size:0.9rem;">Recusar</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Moderação de Fotos -->
    <h3 style="color:#c5a059; margin-top:40px;">📸 Fotos para Moderar</h3>
    <?php if(empty($fotos_pendentes)): ?>
        <p style="color:#2ecc71;">✅ Nenhuma foto pendente</p>
    <?php else: ?>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px,1fr)); gap:20px; margin-top:15px;">
            <?php foreach($fotos_pendentes as $foto): ?>
            <div style="background:#141a30; padding:15px; border-radius:10px;">
                <div style="background:#0a0e1f; height:150px; display:flex; align-items:center; justify-content:center; border-radius:5px;">
                    <i class="fas fa-image" style="color:#c5a059; font-size:3rem;"></i>
                    <span style="display:block; margin-top:10px; font-size:0.8rem; color:#b8b8b8;">Imagem pendente</span>
                </div>
                <p style="color:#b8b8b8; margin-top:10px; font-size:0.9rem;">Cliente: <?= htmlspecialchars($foto['cliente_nome']) ?></p>
                <p style="color:#b8b8b8; font-size:0.8rem;"><?= htmlspecialchars($foto['descricao']) ?></p>
                <div style="display:flex; gap:10px; margin-top:10px;">
                    <form method="POST" style="flex:1;">
                        <input type="hidden" name="foto_id" value="<?= $foto['id'] ?>">
                        <button type="submit" name="acao_foto" value="aprovada" class="btn-gold" style="width:100%; padding:5px; font-size:0.8rem;">Aprovar</button>
                    </form>
                    <form method="POST" style="flex:1;">
                        <input type="hidden" name="foto_id" value="<?= $foto['id'] ?>">
                        <button type="submit" name="acao_foto" value="reprovada" class="btn-outline" style="width:100%; padding:5px; font-size:0.8rem;">Reprovar</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Moderação de Comentários -->
    <h3 style="color:#c5a059; margin-top:40px;">💬 Comentários para Moderar</h3>
    <?php if(empty($comentarios_pendentes)): ?>
        <p style="color:#2ecc71;">✅ Nenhum comentário pendente</p>
    <?php else: ?>
        <div style="display:grid; gap:15px; margin-top:15px;">
            <?php foreach($comentarios_pendentes as $com): ?>
            <div style="background:#141a30; padding:15px; border-radius:10px; border:1px solid #2a2f45;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <strong style="color:#c5a059;"><?= htmlspecialchars($com['autor']) ?></strong>
                        <span style="font-size:0.7rem; color:#b8b8b8;">em <?= date('d/m H:i', strtotime($com['data_comentario'])) ?></span>
                        <p style="color:#fff; margin:5px 0;">"<?= htmlspecialchars($com['comentario']) ?>"</p>
                        <p style="font-size:0.7rem; color:#b8b8b8;">Sobre a foto: <?= htmlspecialchars($com['foto_desc']) ?></p>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <form method="POST">
                            <input type="hidden" name="comentario_id" value="<?= $com['id'] ?>">
                            <button type="submit" name="acao_comentario" value="aprovado" class="btn-gold" style="padding:5px 15px; font-size:0.8rem;">✅</button>
                        </form>
                        <form method="POST">
                            <input type="hidden" name="comentario_id" value="<?= $com['id'] ?>">
                            <button type="submit" name="acao_comentario" value="reprovado" class="btn-outline" style="padding:5px 15px; font-size:0.8rem;">❌</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Lista de Clientes -->
    <h3 style="color:#c5a059; margin-top:40px;">👥 Clientes</h3>
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:15px; margin-top:15px;">
        <?php foreach($clientes as $cliente): ?>
        <div style="background:#141a30; padding:15px; border-radius:10px; border:1px solid #2a2f45;">
            <h4 style="color:#c5a059;"><?= htmlspecialchars($cliente['nome']) ?></h4>
            <p style="color:#b8b8b8; font-size:0.8rem;"><?= htmlspecialchars($cliente['email']) ?></p>
            <p style="font-size:0.7rem; color:#b8b8b8;">Cliente desde: <?= date('d/m/Y', strtotime($cliente['data_criacao'])) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>