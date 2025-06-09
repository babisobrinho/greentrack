-- CREATE DATABASE greentrack;
USE greentrack;

-- Tabela de utilizadores
CREATE TABLE utilizadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL,
    palavra_passe VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'regular') DEFAULT 'regular',
    data_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de conteúdos
CREATE TABLE conteudos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    conteudo TEXT NOT NULL,
    data_publicacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    utilizador_id INT,
    FOREIGN KEY (utilizador_id) REFERENCES utilizadores(id)
);

-- Tabela de ações sustentáveis
CREATE TABLE acoes_sustentaveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    impacto DECIMAL(10,2) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    data_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    utilizador_id INT,
    FOREIGN KEY (utilizador_id) REFERENCES utilizadores(id)
);

-- Tabela de votos
CREATE TABLE votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('like', 'dislike') NOT NULL,
    conteudo_id INT,
    utilizador_id INT,
    data_voto DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conteudo_id) REFERENCES conteudos(id),
    FOREIGN KEY (utilizador_id) REFERENCES utilizadores(id),
    UNIQUE KEY (conteudo_id, utilizador_id)
);

-- Tabela de categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT,
    icone VARCHAR(50)
);

-- Inserir categorias padrão
INSERT INTO categorias (nome, descricao, icone) VALUES 
('Mobilidade', 'Ações relacionadas a transporte e locomoção', 'fa-car'),
('Energia', 'Ações relacionadas ao consumo de energia', 'fa-bolt'),
('Água', 'Ações relacionadas ao consumo de água', 'fa-tint'),
('Resíduos', 'Ações relacionadas a gestão de resíduos', 'fa-trash'),
('Consumo Sustentável', 'Ações relacionadas a hábitos de consumo', 'fa-shopping-bag'),
('Alimentação', 'Ações relacionadas a hábitos alimentares', 'fa-utensils'),
('Florestas e Natureza', 'Ações relacionadas a preservação ambiental', 'fa-tree');

-- Inserir administrador
INSERT INTO utilizadores (nome, email, data_nascimento, palavra_passe, tipo)
VALUES (
    'Administrador', 
    'admin@greentrack.pt', 
    '1998-12-02', 
    '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', -- 12345678
    'admin'
) ON DUPLICATE KEY UPDATE tipo = 'admin';