<?php include 'config.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO contatos (nome, email, telefone, mensagem) VALUES (?,?,?,?)");
    $stmt->execute([$_POST['nome'], $_POST['email'], $_POST['telefone'], $_POST['mensagem']]);
    $msg = "Mensagem enviada com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"><title>Contato</title><link rel="stylesheet" href="style.css">
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
    <h1>Entre em contato</h1>
    <?php if(isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
    <form method="post">
        <label>Nome:</label><input type="text" name="nome" required>
        <label>E-mail:</label><input type="email" name="email" required>
        <label>Telefone:</label><input type="text" name="telefone">
        <label>Mensagem:</label><textarea name="mensagem" rows="4" required></textarea>
        <button type="submit">Enviar</button>
    </form>
</div>
</body>
</html>