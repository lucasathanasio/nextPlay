CREATE DATABASE nextplay;

USE nextplay;

-- Tabela de Usuários
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    profile_pic VARCHAR(255) DEFAULT NULL,
    data_cadastro DATE NOT NULL,
    tipo ENUM('comum', 'administrador') NOT NULL
);

-- Tabela de Jogos
CREATE TABLE jogos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL
);

-- Tabela Posts para diferenciar o tipo de post
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    tipo ENUM('normal', 'jogo') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE postnormal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL UNIQUE,
    titulo VARCHAR(255) NOT NULL,
    conteudo TEXT NOT NULL,
    image_path VARCHAR(255),
    file_path VARCHAR(255),
    youtube_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE postjogo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL UNIQUE,
    jogo_id INT NOT NULL,
    descricao TEXT NOT NULL,
    data_partida DATE NOT NULL,
    horario TIME NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (jogo_id) REFERENCES jogos(id) ON DELETE CASCADE
);

-- Cadastro de jogos para criar posts de convites
INSERT INTO jogos (nome) VALUES
('Rocket League'),
('Fortnite'),
('Valorant'),
('CS:GO'),
('COD Warzone');

-- Tabela de Participantes da Partida
CREATE TABLE participantepartida (
    id_partida INT,
    id_usuario INT,
    PRIMARY KEY (id_partida, id_usuario),
    FOREIGN KEY (id_partida) REFERENCES postjogo(id),
    FOREIGN KEY (id_usuario) REFERENCES users(id)
);

-- Tabela de links
CREATE TABLE IF NOT EXISTS links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES postnormal(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE dislikes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

-- Tabela de mensagens (chat)
CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  remetente_id INT NOT NULL,
  destinatario_id INT NOT NULL,
  mensagem TEXT NOT NULL,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (remetente_id) REFERENCES users(id)ON DELETE CASCADE,
  FOREIGN KEY (destinatario_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Relacionamentos específicos de Administradores
-- Exclusão de usuários
CREATE TABLE AdministradorExcluiUser (
    id_admin INT,
    user_id INT,
    PRIMARY KEY (id_admin, user_id),
    FOREIGN KEY (id_admin) REFERENCES users(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Exclusão de postagens
CREATE TABLE AdministradorExcluiPostagem (
    id_admin INT,
    post_id INT,
    PRIMARY KEY (id_admin, post_id),
    FOREIGN KEY (id_admin) REFERENCES users(id),
    FOREIGN KEY (post_id) REFERENCES postnormal(id)
);

-- Tabela de Planos
CREATE TABLE planos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_plano ENUM('básico', 'pro', 'ultimate') NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de seguidores
CREATE TABLE seguidores (
    id_seguidor INT NOT NULL,
    id_seguindo INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_seguidor, id_seguindo),
    FOREIGN KEY (id_seguidor) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_seguindo) REFERENCES users(id) ON DELETE CASCADE
);