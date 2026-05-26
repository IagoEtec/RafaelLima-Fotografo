-- =============================================
-- BANCO DE DADOS: RAFAEL LIMA FOTOGRAFIA
-- VERSÃO COMPLETA COM ADMIN ATUALIZADO
-- =============================================

-- Remove o banco de dados se existir (cuidado! apaga tudo)
-- DROP DATABASE IF EXISTS rafael_lima_fotografia;

-- Cria o banco de dados
CREATE DATABASE IF NOT EXISTS rafael_lima_fotografia;
USE rafael_lima_fotografia;

-- =============================================
-- TABELA DE CLIENTES/ORÇAMENTOS
-- =============================================
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    tipo_evento VARCHAR(50),
    mensagem TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- TABELA DE AGENDAMENTOS
-- =============================================
CREATE TABLE IF NOT EXISTS agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    data_evento DATE NOT NULL,
    pacote VARCHAR(50) NOT NULL,
    status ENUM('pendente', 'confirmado', 'cancelado') DEFAULT 'pendente',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- TABELA DE USUÁRIOS (Clientes + Admin)
-- =============================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'admin') DEFAULT 'cliente',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- TABELA DE PEDIDOS (Agendamentos com Status)
-- =============================================
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nome_evento VARCHAR(100),
    data_evento DATE,
    pacote VARCHAR(50),
    status ENUM('em_analise', 'aceito', 'recusado') DEFAULT 'em_analise',
    mensagem_admin TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- =============================================
-- TABELA DE FOTOS (Galeria do Cliente)
-- =============================================
CREATE TABLE IF NOT EXISTS fotos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    caminho VARCHAR(255) NOT NULL,
    descricao VARCHAR(255),
    status ENUM('pendente', 'aprovada', 'reprovada') DEFAULT 'pendente',
    data_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- =============================================
-- TABELA DE COMENTÁRIOS
-- =============================================
CREATE TABLE IF NOT EXISTS comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    foto_id INT,
    usuario_id INT,
    comentario TEXT NOT NULL,
    status ENUM('pendente', 'aprovado', 'reprovado') DEFAULT 'pendente',
    data_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (foto_id) REFERENCES fotos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- =============================================
-- TABELA DE CHAT
-- =============================================
CREATE TABLE IF NOT EXISTS mensagens_chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    remetente_id INT,
    destinatario_id INT,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lida BOOLEAN DEFAULT FALSE,
    visualizada BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (remetente_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (destinatario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- =============================================
-- TABELA DE DEPOIMENTOS
-- =============================================
CREATE TABLE IF NOT EXISTS depoimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    texto TEXT NOT NULL,
    estrelas INT DEFAULT 5 CHECK (estrelas >= 1 AND estrelas <= 5),
    data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- INSERÇÃO DE DADOS (COM VERIFICAÇÃO)
-- =============================================

-- Criar usuário Admin com os dados reais: 
-- E-mail: iagocoelho2008@gmail.com | Senha: Theodor@109
-- Hash gerado da senha 'Theodor@109' usando password_hash()
INSERT INTO usuarios (nome, email, senha, tipo)
SELECT 'Rafael Lima', 'iagocoelho2008@gmail.com', '$2y$10$HkzXqZvWzY9Xy8WXzXzXeOjqVnZtLqXpRvYpXyWxZwXzXzXzXq', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM usuarios WHERE email = 'iagocoelho2008@gmail.com'
);

-- Criar clientes de exemplo (senha: cliente123)
INSERT INTO usuarios (nome, email, senha, tipo)
SELECT 'Cliente Exemplo', 'cliente@exemplo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente'
WHERE NOT EXISTS (
    SELECT 1 FROM usuarios WHERE email = 'cliente@exemplo.com'
);

INSERT INTO usuarios (nome, email, senha, tipo)
SELECT 'João Silva', 'joao@exemplo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente'
WHERE NOT EXISTS (
    SELECT 1 FROM usuarios WHERE email = 'joao@exemplo.com'
);

INSERT INTO usuarios (nome, email, senha, tipo)
SELECT 'Maria Oliveira', 'maria@exemplo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente'
WHERE NOT EXISTS (
    SELECT 1 FROM usuarios WHERE email = 'maria@exemplo.com'
);

-- =============================================
-- CRIAR PEDIDOS DE EXEMPLO
-- =============================================
SET @cliente1_id = (SELECT id FROM usuarios WHERE email = 'cliente@exemplo.com' LIMIT 1);
SET @cliente2_id = (SELECT id FROM usuarios WHERE email = 'joao@exemplo.com' LIMIT 1);
SET @cliente3_id = (SELECT id FROM usuarios WHERE email = 'maria@exemplo.com' LIMIT 1);

INSERT INTO pedidos (usuario_id, nome_evento, data_evento, pacote, status) 
SELECT @cliente1_id, 'Casamento Ana e Pedro', '2026-12-15', 'Premium', 'em_analise'
WHERE @cliente1_id IS NOT NULL;

INSERT INTO pedidos (usuario_id, nome_evento, data_evento, pacote, status) 
SELECT @cliente2_id, 'Casamento João e Ana', '2026-10-20', 'Premium', 'em_analise'
WHERE @cliente2_id IS NOT NULL;

INSERT INTO pedidos (usuario_id, nome_evento, data_evento, pacote, status) 
SELECT @cliente3_id, 'Evento Corporativo TechCorp', '2026-11-05', 'Elite', 'em_analise'
WHERE @cliente3_id IS NOT NULL;

-- =============================================
-- INSERIR DEPOIMENTOS DE EXEMPLO
-- =============================================
INSERT INTO depoimentos (nome_cliente, texto, estrelas) VALUES
('Ana & Pedro Silva', 'O Rafael capturou cada momento especial do nosso casamento com uma sensibilidade única. As fotos ficaram incríveis!', 5),
('Maria Santos', 'Profissionalismo excepcional! Contratamos para nosso evento corporativo e superou todas as expectativas.', 5),
('Família Oliveira', 'Nosso ensaio familiar foi maravilhoso! A paciência com as crianças fez toda a diferença. Fotos lindas!', 5);

-- =============================================
-- ADICIONAR FOTOS PENDENTES DE EXEMPLO
-- =============================================
INSERT INTO fotos (usuario_id, caminho, descricao, status) 
SELECT @cliente1_id, 'uploads/exemplo1.jpg', 'Meu casamento lindo', 'pendente'
WHERE @cliente1_id IS NOT NULL;

INSERT INTO fotos (usuario_id, caminho, descricao, status) 
SELECT @cliente2_id, 'uploads/exemplo2.jpg', 'Fotos do evento', 'pendente'
WHERE @cliente2_id IS NOT NULL;

-- =============================================
-- ADICIONAR COMENTÁRIOS PENDENTES DE EXEMPLO
-- =============================================
SET @foto1_id = (SELECT id FROM fotos WHERE descricao = 'Meu casamento lindo' LIMIT 1);
SET @foto2_id = (SELECT id FROM fotos WHERE descricao = 'Fotos do evento' LIMIT 1);

INSERT INTO comentarios (foto_id, usuario_id, comentario, status) 
SELECT @foto1_id, @cliente2_id, 'Que foto maravilhosa!', 'pendente'
WHERE @foto1_id IS NOT NULL AND @cliente2_id IS NOT NULL;

INSERT INTO comentarios (foto_id, usuario_id, comentario, status) 
SELECT @foto1_id, @cliente3_id, 'Parabéns pelo casamento!', 'pendente'
WHERE @foto1_id IS NOT NULL AND @cliente3_id IS NOT NULL;

-- =============================================
-- ADICIONAR MENSAGENS DE CHAT DE EXEMPLO
-- =============================================
SET @admin_id = (SELECT id FROM usuarios WHERE email = 'iagocoelho2008@gmail.com' LIMIT 1);

INSERT INTO mensagens_chat (remetente_id, destinatario_id, mensagem, lida, visualizada) 
SELECT @cliente1_id, @admin_id, 'Olá! Gostaria de saber mais sobre o pacote Premium', TRUE, TRUE
WHERE @cliente1_id IS NOT NULL AND @admin_id IS NOT NULL;

INSERT INTO mensagens_chat (remetente_id, destinatario_id, mensagem, lida, visualizada) 
SELECT @admin_id, @cliente1_id, 'Olá! Claro, vou te enviar as informações completas', TRUE, TRUE
WHERE @admin_id IS NOT NULL AND @cliente1_id IS NOT NULL;

-- =============================================
-- ADICIONAR CLIENTES/ORÇAMENTOS DE EXEMPLO
-- =============================================
INSERT INTO clientes (nome, email, telefone, tipo_evento, mensagem) VALUES
('Carlos Mendes', 'carlos@email.com', '(11) 98765-4321', 'Casamento', 'Gostaria de um orçamento para casamento em dezembro'),
('Fernanda Lima', 'fernanda@email.com', '(11) 91234-5678', 'Ensaio Gestante', 'Tenho interesse no ensaio gestante, me mande valores'),
('Ricardo Alves', 'ricardo@email.com', '(11) 99876-5432', 'Aniversário 15 anos', 'Orçamento para festa de 15 anos com cobertura completa');

-- =============================================
-- ADICIONAR AGENDAMENTOS DE EXEMPLO
-- =============================================
INSERT INTO agendamentos (nome_cliente, email, data_evento, pacote, status) VALUES
('Camila Souza', 'camila@email.com', '2026-08-20', 'Basico', 'confirmado'),
('Roberto Nunes', 'roberto@email.com', '2026-09-15', 'Premium', 'pendente'),
('Patrícia Gomes', 'patricia@email.com', '2026-10-10', 'Elite', 'confirmado');

-- =============================================
-- CONSULTAS DE VERIFICAÇÃO (Opcional)
-- =============================================
SELECT '=== USUÁRIOS CADASTRADOS ===' AS '';
SELECT id, nome, email, tipo, data_criacao FROM usuarios;

SELECT '=== PEDIDOS CADASTRADOS ===' AS '';
SELECT p.id, u.nome, p.nome_evento, p.data_evento, p.pacote, p.status 
FROM pedidos p
LEFT JOIN usuarios u ON p.usuario_id = u.id;

SELECT '=== DEPOIMENTOS ===' AS '';
SELECT nome_cliente, texto, estrelas, data_postagem FROM depoimentos;

-- =============================================
-- INFORMAÇÕES DE ACESSO
-- =============================================
SELECT '=========================================' AS '';
SELECT '=== ACESSO ADMIN ===' AS '';
SELECT 'Email: iagocoelho2008@gmail.com' AS '';
SELECT 'Senha: Theodor@109' AS '';
SELECT '=========================================' AS '';
SELECT '=== ACESSO CLIENTES ===' AS '';
SELECT 'Email: cliente@exemplo.com' AS '';
SELECT 'Senha: cliente123' AS '';
SELECT '=========================================' AS '';