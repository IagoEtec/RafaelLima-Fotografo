<?php
include __DIR__ . '/includes/config.php';
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}

if(isset($_POST['foto_id']) && isset($_POST['status'])) {
    $stmt = $pdo->prepare("UPDATE fotos SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['foto_id']]);
}

header("Location: painel_admin.php");
exit;
?>