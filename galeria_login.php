<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acessar Galeria - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<section>
    <h2>GALERIA PRIVADA</h2>
    <p>Área exclusiva para clientes acessarem suas fotos com segurança</p>
    
    <div class="galeria-form">
        <div style="text-align:center; margin-bottom:20px;">
            <i class="fas fa-lock fa-3x" style="color:var(--gold);"></i>
            <h3 style="margin-top:10px;">ACESSE SUA GALERIA</h3>
        </div>
        
        <?php
        if(isset($_POST['login_galeria'])) {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            
            $stmt = $pdo->prepare("SELECT * FROM clientes_galeria WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if($user && password_verify($senha, $user['senha'])) {
                $_SESSION['galeria_user'] = $user['id'];
                header("Location: galeria_privada.php");
                exit;
            } else {
                echo '<div style="color:#ff6b6b; text-align:center; margin-bottom:15px;">E-mail ou senha incorretos</div>';
            }
        }
        ?>
        
        <form method="POST">
            <label style="color:var(--gold); font-family:sans-serif; font-size:0.8rem;">E-MAIL</label>
            <input type="email" name="email" required>
            
            <label style="color:var(--gold); font-family:sans-serif; font-size:0.8rem;">SENHA DE ACESSO</label>
            <input type="password" name="senha" required>
            
            <button type="submit" name="login_galeria" class="btn-gold" style="width:100%;">ACESSAR GALERIA</button>
            <p style="text-align:center; font-size:0.8rem; margin-top:15px; color:var(--text-light);">
                A senha é fornecida após a conclusão do evento
            </p>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
</body>
</html>