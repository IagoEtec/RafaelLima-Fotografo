<?php
include __DIR__ . '/includes/config.php';

if(isset($_SESSION['usuario_id'])) {
    if($_SESSION['usuario_tipo'] == 'admin') {
        header("Location: painel_admin.php");
    } else {
        header("Location: painel_cliente.php");
    }
    exit;
}

$erro = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];
        $_SESSION['usuario_tipo'] = $user['tipo'];
        
        if($user['tipo'] == 'admin') {
            header("Location: painel_admin.php");
        } else {
            header("Location: painel_cliente.php");
        }
        exit;
    } else {
        $erro = "E-mail ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <div style="max-width:400px; margin:40px auto; background:#141a30; padding:40px; border-radius:15px; border:1px solid #c5a059;">
        <h2 style="text-align:center; color:#c5a059;">LOGIN</h2>
        
        <?php if($erro): ?>
            <div style="background:#ff6b6b; padding:10px; border-radius:5px; text-align:center; margin-bottom:15px;"><?= $erro ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <label style="color:#c5a059;">E-mail</label>
            <input type="email" name="email" required style="width:100%; padding:10px; margin-bottom:15px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
            
            <label style="color:#c5a059;">Senha</label>
            <input type="password" name="senha" required style="width:100%; padding:10px; margin-bottom:20px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
            
            <button type="submit" class="btn-gold" style="width:100%;">ENTRAR</button>
        </form>
        
        <p style="text-align:center; margin-top:15px; font-size:0.8rem;">
            Não tem uma conta? <a href="registrar.php" style="color:#c5a059;">Crie sua conta aqui</a>
        </p>
        <p style="text-align:center; font-size:0.7rem; color:#b8b8b8; margin-top:10px;">
            Esqueceu sua senha? <a href="contato.php" style="color:#c5a059;">Entre em contato</a>
        </p>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>