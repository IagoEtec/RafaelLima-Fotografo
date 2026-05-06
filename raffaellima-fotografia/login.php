<?php
session_start();
include 'config.php';
if(isset($_POST['email'])) {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $cliente = $stmt->fetch();
    if($cliente && password_verify($_POST['senha'], $cliente['senha'])) {
        $_SESSION['cliente_id'] = $cliente['id'];
        $_SESSION['cliente_nome'] = $cliente['nome'];
        header('Location: area-cliente.php');
        exit;
    } else {
        $erro = "Credenciais inválidas.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"><title>Login Cliente</title><link rel="stylesheet" href="style.css">
</head>
<body>
<header><a href="index.php" class="logo">Rafael <span>Lima</span></a></header>
<div class="container">
    <h1>Área do Cliente</h1>
    <?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
    <form method="post">
        <label>E-mail:</label><input type="email" name="email" required>
        <label>Senha:</label><input type="password" name="senha" required>
        <button type="submit" class="btn">Entrar</button>
    </form>
    <p>Ainda não tem acesso? Entre em contato para receber sua senha da galeria privada.</p>
</div>
</body>
</html>