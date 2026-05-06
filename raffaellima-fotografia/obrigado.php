<?php
include 'config.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO agendamentos (cliente_nome, cliente_email, servico, data_evento, horario, mensagem) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$_POST['nome'], $_POST['email'], $_POST['servico'], $_POST['data'], $_POST['horario'], $_POST['mensagem']]);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Obrigado - Rafael Lima</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><a href="index.php" class="logo">Rafael <span>Lima</span></a></header>
<div class="container" style="text-align:center;">
    <h1>Pedido recebido com sucesso!</h1>
    <p>Entraremos em contato em breve para acertar os detalhes e o pagamento.</p>
    <a href="index.php" class="btn">Voltar ao site</a>
</div>
</body>
</html>