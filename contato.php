<?php include __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Contato - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <h2>SOLICITE SEU ORÇAMENTO</h2>
    <p>Conte-nos sobre seu evento e receba uma proposta personalizada</p>
    
    <div class="contato-container">
        <div class="contato-form">
            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $telefone = $_POST['telefone'];
                $tipo_evento = $_POST['tipo_evento'];
                $mensagem = $_POST['mensagem'];
                
                $sql = "INSERT INTO clientes (nome, email, telefone, tipo_evento, mensagem) VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $email, $telefone, $tipo_evento, $mensagem]);
                
                echo '<div style="background:#1a1f36; padding:20px; border:1px solid var(--gold); text-align:center; margin-bottom:20px;">✅ Orçamento solicitado! Entraremos em contato em até 24h.</div>';
            }
            ?>
            <form method="POST">
                <input type="text" name="nome" placeholder="NOME COMPLETO" required>
                <input type="email" name="email" placeholder="E-MAIL" required>
                <input type="text" name="telefone" placeholder="TELEFONE">
                <input type="text" name="tipo_evento" placeholder="TIPO DE EVENTO">
                <textarea name="mensagem" rows="5" placeholder="MENSAGEM" required></textarea>
                <button type="submit" class="btn-gold">ENVIAR SOLICITAÇÃO</button>
            </form>
        </div>
        
        <div class="contato-info">
            <h3>INFORMAÇÕES DE CONTATO</h3>
            <ul>
                <li><i class="fas fa-envelope"></i> contato@rafaellima.com.br</li>
                <li><i class="fas fa-phone"></i> (11) 99999-8888</li>
                <li><i class="fas fa-map-marker-alt"></i> São Paulo - SP</li>
                <li><i class="fas fa-clock"></i> Atendimento: Seg a Sáb, 9h às 19h</li>
                <li><i class="fab fa-instagram"></i> @rafaellimafotografia</li>
            </ul>
            <div style="margin-top:30px;">
                <h4>REDES SOCIAIS</h4>
                <div style="display:flex; gap:20px; margin-top:10px;">
                    <a href="#" style="color:#fff;">Instagram</a>
                    <a href="#" style="color:#fff;">Facebook</a>
                    <a href="#" style="color:#fff;">Pinterest</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>