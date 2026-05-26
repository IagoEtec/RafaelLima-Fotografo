<?php
include __DIR__ . '/includes/config.php';
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'cliente') {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar dados do cliente
$stmt = $pdo->prepare("SELECT nome, email, data_criacao FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$cliente = $stmt->fetch();

// Pedidos do cliente
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY data_criacao DESC");
$stmt->execute([$usuario_id]);
$pedidos = $stmt->fetchAll();

// Fotos aprovadas
$stmt = $pdo->prepare("SELECT * FROM fotos WHERE usuario_id = ? AND status = 'aprovada' ORDER BY data_upload DESC");
$stmt->execute([$usuario_id]);
$fotos = $stmt->fetchAll();

// Contagem de fotos e pedidos
$total_fotos = count($fotos);
$total_pedidos = count($pedidos);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        section { padding: 40px 5%; }
    </style>
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <!-- DASHBOARD HEADER -->
    <div class="dashboard-welcome">
        <div class="welcome-text">
            <h3><i class="fas fa-camera-retro" style="color:var(--gold); margin-right:10px;"></i> Olá, <?= htmlspecialchars($cliente['nome']) ?>!</h3>
            <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($cliente['email']) ?> • Cliente desde <?= date('m/Y', strtotime($cliente['data_criacao'])) ?></p>
        </div>
        <div class="welcome-stats">
            <div class="stat-card">
                <div class="number"><?= $total_pedidos ?></div>
                <div class="label">Pedidos</div>
            </div>
            <div class="stat-card">
                <div class="number"><?= $total_fotos ?></div>
                <div class="label">Fotos aprovadas</div>
            </div>
        </div>
    </div>

    <!-- MEUS PEDIDOS -->
    <h3 style="color:var(--gold); margin: 40px 0 20px 0;"><i class="fas fa-calendar-check"></i> Meus Pedidos</h3>
    <?php if(empty($pedidos)): ?>
        <div style="background:#141a30; padding:25px; border-radius:15px; text-align:center; color:#b8b8b8;">
            <i class="fas fa-inbox fa-2x" style="margin-bottom:10px; display:block;"></i>
            Você ainda não fez nenhum pedido. <a href="agendamento.php" style="color:var(--gold);">Solicite um orçamento agora</a>
        </div>
    <?php else: ?>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(320px,1fr)); gap:25px;">
            <?php foreach($pedidos as $pedido): ?>
            <div class="pedido-card">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h4 style="color:#fff; margin:0;"><?= htmlspecialchars($pedido['nome_evento']) ?></h4>
                    <span class="status-badge status-<?= $pedido['status'] ?>">
                        <?= $pedido['status'] == 'em_analise' ? 'Em análise' : ($pedido['status'] == 'aceito' ? 'Aceito' : 'Recusado') ?>
                    </span>
                </div>
                <p style="color:#b8b8b8; margin-top:8px;"><i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($pedido['data_evento'])) ?></p>
                <p style="color:#b8b8b8;"><i class="fas fa-box"></i> Pacote: <?= ucfirst($pedido['pacote']) ?></p>
                <?php if($pedido['mensagem_admin']): ?>
                    <div style="background:#0a0e1f; padding:12px; border-radius:12px; margin-top:12px;">
                        <i class="fas fa-comment-dots" style="color:var(--gold);"></i>
                        <span style="color:#ddd; font-size:0.85rem;"><?= htmlspecialchars($pedido['mensagem_admin']) ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- UPLOAD DE FOTOS ESTILIZADO -->
    <div class="upload-area">
        <h3 style="color:var(--gold); margin-bottom:15px;"><i class="fas fa-upload"></i> Enviar novas fotos</h3>
        <form action="upload_foto.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="foto" accept="image/*" required>
            <input type="text" name="descricao" placeholder="Descreva a foto (ex: Ensaio de casamento - detalhe das alianças)">
            <button type="submit" class="btn-gold"><i class="fas fa-cloud-upload-alt"></i> Enviar</button>
        </form>
        <p style="font-size:0.7rem; color:#b8b8b8; margin-top:12px;"><i class="fas fa-info-circle"></i> As fotos enviadas serão aprovadas pelo administrador antes de aparecerem na sua galeria.</p>
    </div>

    <!-- GALERIA DE FOTOS APROVADAS -->
    <h3 style="color:var(--gold); margin: 30px 0 15px 0;"><i class="fas fa-images"></i> Minhas fotos aprovadas</h3>
    <?php if(empty($fotos)): ?>
        <div style="background:#141a30; padding:25px; border-radius:15px; text-align:center; color:#b8b8b8;">
            <i class="fas fa-camera-slash fa-2x"></i>
            <p style="margin-top:10px;">Nenhuma foto aprovada ainda. Envie suas fotos acima e aguarde a aprovação.</p>
        </div>
    <?php else: ?>
        <div class="fotos-grid">
            <?php foreach($fotos as $foto): ?>
            <div class="foto-card">
                <div class="foto-preview">
                    <i class="fas fa-image" style="color:var(--gold); font-size:2.5rem;"></i>
                </div>
                <div class="foto-info">
                    <p><strong><?= htmlspecialchars($foto['descricao']) ?></strong></p>
                    <p style="font-size:0.7rem; color:#aaa;">Enviado em: <?= date('d/m/Y', strtotime($foto['data_upload'])) ?></p>
                    <a href="comentario.php?foto_id=<?= $foto['id'] ?>" class="comentario-link"><i class="fas fa-comment"></i> Ver comentários</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- BOTÃO DO CHAT EM DESTAQUE -->
    <div class="chat-button-wrapper">
        <a href="chat.php" class="btn-gold" style="background: linear-gradient(135deg, #c5a059, #a57c3a);">
            <i class="fas fa-comments"></i> Fale diretamente com Rafael
        </a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>