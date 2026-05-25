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
$sucesso = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    
    // Validações
    if(empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)) {
        $erro = "Todos os campos são obrigatórios!";
    } elseif($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem!";
    } elseif(strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres!";
    } else {
        // Verificar se e-mail já existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->fetch()) {
            $erro = "Este e-mail já está cadastrado!";
        } else {
            // Criar usuário
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'cliente')");
            $stmt->execute([$nome, $email, $senha_hash]);
            
            $sucesso = "Conta criada com sucesso! Faça o login para acessar.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registrar - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <div style="max-width:450px; margin:40px auto; background:#141a30; padding:40px; border-radius:15px; border:1px solid #c5a059;">
        <h2 style="text-align:center; color:#c5a059;">CRIAR CONTA</h2>
        <p style="text-align:center; color:#b8b8b8; margin-bottom:20px;">Cadastre-se para acessar sua galeria privada</p>
        
        <?php if($erro): ?>
            <div style="background:#ff6b6b; padding:10px; border-radius:5px; text-align:center; margin-bottom:15px;"><?= $erro ?></div>
        <?php endif; ?>
        
        <?php if($sucesso): ?>
            <div style="background:#2ecc71; padding:10px; border-radius:5px; text-align:center; margin-bottom:15px;"><?= $sucesso ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <label style="color:#c5a059;">Nome Completo</label>
            <input type="text" name="nome" required style="width:100%; padding:10px; margin-bottom:15px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
            
            <label style="color:#c5a059;">E-mail</label>
            <input type="email" name="email" required style="width:100%; padding:10px; margin-bottom:15px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
            
            <label style="color:#c5a059;">Senha (mínimo 6 caracteres)</label>
            <input type="password" name="senha" required minlength="6" style="width:100%; padding:10px; margin-bottom:15px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
            
            <label style="color:#c5a059;">Confirmar Senha</label>
            <input type="password" name="confirmar_senha" required minlength="6" style="width:100%; padding:10px; margin-bottom:20px; background:#0a0e1f; border:1px solid #2a2f45; border-radius:5px; color:#fff;">
            
            <button type="submit" class="btn-gold" style="width:100%;">CRIAR CONTA</button>
        </form>
        
        <p style="text-align:center; margin-top:15px; font-size:0.8rem;">
            Já tem uma conta? <a href="login.php" style="color:#c5a059;">Faça login</a>
        </p>
        <p style="text-align:center; font-size:0.7rem; color:#b8b8b8; margin-top:10px;">
            Ao criar uma conta, você concorda com nossos termos de uso.
        </p>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>