-- Cria o banco de dados
CREATE DATABASE IF NOT EXISTS rafael_lima_fotografia;
USE rafael_lima_fotografia;

-- Tabela de Clientes/Orçamentos
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    tipo_evento VARCHAR(50),
    mensagem TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Agendamentos
CREATE TABLE IF NOT EXISTS agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    data_evento DATE NOT NULL,
    pacote VARCHAR(50) NOT NULL,
    status ENUM('pendente', 'confirmado', 'cancelado') DEFAULT 'pendente',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Usuários (Clientes + Admin)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'admin') DEFAULT 'cliente',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Pedidos (Agendamentos com Status)
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nome_evento VARCHAR(100),
    data_evento DATE,
    pacote VARCHAR(50),
    status ENUM('em_analise', 'aceito', 'recusado') DEFAULT 'em_analise',
    mensagem_admin TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de Fotos (Galeria do Cliente)
CREATE TABLE IF NOT EXISTS fotos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    caminho VARCHAR(255) NOT NULL,
    descricao VARCHAR(255),
    status ENUM('pendente', 'aprovada', 'reprovada') DEFAULT 'pendente',
    data_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de Comentários
CREATE TABLE IF NOT EXISTS comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    foto_id INT,
    usuario_id INT,
    comentario TEXT NOT NULL,
    status ENUM('pendente', 'aprovado', 'reprovado') DEFAULT 'pendente',
    data_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (foto_id) REFERENCES fotos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de Chat
CREATE TABLE IF NOT EXISTS mensagens_chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    remetente_id INT,
    destinatario_id INT,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lida BOOLEAN DEFAULT FALSE,
    visualizada BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (remetente_id) REFERENCES usuarios(id),
    FOREIGN KEY (destinatario_id) REFERENCES usuarios(id)
);

-- Tabela de Depoimentos
CREATE TABLE IF NOT EXISTS depoimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    texto TEXT NOT NULL,
    estrelas INT DEFAULT 5,
    data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Criar usuário Admin (senha: admin123)
INSERT INTO usuarios (nome, email, senha, tipo) VALUES 
('Rafael Lima', 'admin@rafaellima.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Criar clientes de exemplo (senha: cliente123)
INSERT INTO usuarios (nome, email, senha, tipo) VALUES 
('Cliente Exemplo', 'cliente@exemplo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente'),
('João Silva', 'joao@exemplo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente'),
('Maria Oliveira', 'maria@exemplo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente');

-- Criar pedidos de exemplo
INSERT INTO pedidos (usuario_id, nome_evento, data_evento, pacote, status) VALUES 
(2, 'Casamento Ana e Pedro', '2026-12-15', 'Premium', 'em_analise'),
(3, 'Casamento João e Ana', '2026-10-20', 'Premium', 'em_analise'),
(4, 'Evento Corporativo TechCorp', '2026-11-05', 'Elite', 'em_analise');

-- Inserir depoimentos de exemplo
INSERT INTO depoimentos (nome_cliente, texto, estrelas) VALUES
('Ana & Pedro Silva', 'O Rafael capturou cada momento especial do nosso casamento com uma sensibilidade única. As fotos ficaram incríveis!', 5),
('Maria Santos', 'Profissionalismo excepcional! Contratamos para nosso evento corporativo e superou todas as expectativas.', 5),
('Família Oliveira', 'Nosso ensaio familiar foi maravilhoso! A paciência com as crianças fez toda a diferença. Fotos lindas!', 5);

-- Adicionar fotos pendentes de exemplo
INSERT INTO fotos (usuario_id, caminho, descricao, status) VALUES 
(2, 'uploads/exemplo1.jpg', 'Meu casamento lindo', 'pendente'),
(3, 'uploads/exemplo2.jpg', 'Fotos do evento', 'pendente');

-- Adicionar comentários pendentes de exemplo
INSERT INTO comentarios (foto_id, usuario_id, comentario, status) VALUES 
(1, 3, 'Que foto maravilhosa!', 'pendente'),
(1, 4, 'Parabéns pelo casamento!', 'pendente');