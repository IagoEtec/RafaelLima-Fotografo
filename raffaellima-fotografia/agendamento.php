<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agendamento - Rafael Lima</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">Rafael <span>Lima</span></a>
    <nav>
        <a href="index.php">Home</a>
        <a href="portfolio.php">Portfólio</a>
        <a href="pacotes.php">Pacotes</a>
        <a href="agendamento.php">Agendamento</a>
        <a href="contato.php">Contato</a>
        <a href="login.php">Área do Cliente</a>
    </nav>
</header>
<div class="container">
    <h1>Solicitar Agendamento</h1>
    <form method="POST" action="obrigado.php">
        <label>Serviço desejado:</label>
        <input type="text" name="servico" value="<?= htmlspecialchars($_GET['servico'] ?? '') ?>" required>

        <label>Seu nome completo:</label>
        <input type="text" name="nome" required>

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <label>Data do evento/sessão:</label>
        <input type="date" name="data" required>

        <label>Horário:</label>
        <input type="time" name="horario" required>

        <label>Mensagem adicional:</label>
        <textarea name="mensagem" rows="3"></textarea>

        <button type="submit" class="btn">Enviar Solicitação</button>
    </form>
    <p style="text-align:center; margin-top:1rem;">Após o envio, nossa equipe entrará em contato para confirmação e orientações de pagamento.</p>
</div>
<footer><p>&copy; 2025 Rafael Lima Fotografia</p></footer>
</body>
</html>