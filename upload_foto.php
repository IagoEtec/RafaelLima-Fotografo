<?php
include __DIR__ . '/includes/config.php';
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $descricao = $_POST['descricao'] ?? '';
    
    $upload_dir = 'uploads/';
    if(!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nome_arquivo = uniqid() . '.' . $extensao;
    $caminho = $upload_dir . $nome_arquivo;
    
    if(move_uploaded_file($_FILES['foto']['tmp_name'], $caminho)) {
        $stmt = $pdo->prepare("INSERT INTO fotos (usuario_id, caminho, descricao, status) VALUES (?, ?, ?, 'pendente')");
        $stmt->execute([$usuario_id, $caminho, $descricao]);
    }
}

header("Location: painel_cliente.php");
exit;
?>