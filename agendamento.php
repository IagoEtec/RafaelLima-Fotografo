<?php include __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agendamento - Rafael Lima</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<section>
    <h2>AGENDAMENTO ONLINE</h2>
    <p>Escolha a melhor data e horário para sua sessão fotográfica</p>
    
    <div class="agendamento-container">
        <div class="calendario">
            <div class="calendario-grid">
                <div class="header">DOM</div>
                <div class="header">SEG</div>
                <div class="header">TER</div>
                <div class="header">QUA</div>
                <div class="header">QUI</div>
                <div class="header">SEX</div>
                <div class="header">SÁB</div>
                
                <?php
                $mes = date('m');
                $ano = date('Y');
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
                $primeiro_dia = date('w', strtotime("$ano-$mes-01"));
                
                for($i=0; $i<$primeiro_dia; $i++) {
                    echo '<div></div>';
                }
                for($i=1; $i<=$dias_mes; $i++) {
                    echo '<div class="date">'.$i.'</div>';
                }
                ?>
            </div>
        </div>
        
        <div class="info-agendamento">
            <h3>INFORMAÇÕES</h3>
            <ul>
                <li><i class="fas fa-credit-card"></i> Pagamento online seguro</li>
                <li><i class="fas fa-check-circle"></i> Confirmação imediata por e-mail</li>
                <li><i class="fas fa-calendar-alt"></i> Reagendamento gratuito até 48h</li>
                <li><i class="fas fa-camera"></i> Equipe e equipamentos profissionais</li>
            </ul>
            
            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $data = $_POST['data'];
                $pacote = $_POST['pacote'];
                
                $sql = "INSERT INTO agendamentos (nome_cliente, email, data_evento, pacote) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $email, $data, $pacote]);
                
                echo '<div style="background:#1a1f36; padding:15px; border:1px solid var(--gold); margin-top:15px; text-align:center;">✅ Agendamento confirmado! Verifique seu e-mail.</div>';
            }
            ?>
            
            <form method="POST" style="margin-top:20px;">
                <input type="text" name="nome" placeholder="Seu nome" required>
                <input type="email" name="email" placeholder="Seu e-mail" required>
                <input type="date" name="data" required>
                <select name="pacote">
                    <option value="basico">Básico</option>
                    <option value="premium">Premium</option>
                    <option value="elite">Elite</option>
                </select>
                <button type="submit" class="btn-gold" style="width:100%;">CONFIRMAR AGENDAMENTO</button>
            </form>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>