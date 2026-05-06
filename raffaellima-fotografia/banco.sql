CREATE DATABASE IF NOT EXISTS rafael_fotografia;
USE rafael_fotografia;

-- Clientes com acesso à galeria privada
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categorias do portfólio
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);
INSERT INTO categorias (nome) VALUES ('Casamentos'), ('Eventos'), ('Ensaios');

-- Portfólio público
CREATE TABLE portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT,
    titulo VARCHAR(100),
    imagem VARCHAR(255),
    descricao TEXT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Pacotes de serviços
CREATE TABLE pacotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    preco DECIMAL(10,2),
    descricao TEXT,
    itens TEXT
);

-- Agendamentos
CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_nome VARCHAR(100),
    cliente_email VARCHAR(100),
    servico VARCHAR(100),
    data_evento DATE,
    horario TIME,
    mensagem TEXT,
    status ENUM('pendente','confirmado') DEFAULT 'pendente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Depoimentos
CREATE TABLE depoimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    texto TEXT,
    data DATE,
    aprovado TINYINT(1) DEFAULT 0
);

-- Contatos
CREATE TABLE contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100),
    telefone VARCHAR(20),
    mensagem TEXT,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);