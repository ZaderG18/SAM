-- Conecte ao MySQL Server e crie o banco de dados
CREATE DATABASE IF NOT EXISTS SAM;

-- Use o banco de dados criado
USE SAM;

-- Criação das tabelas
CREATE TABLE IF NOT EXISTS aluno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    RM VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(40) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(40) NOT NULL,
    codigo INT NOT NULL,
    cargo INT NOT NULL
);

CREATE TABLE IF NOT EXISTS professor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    RM VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(40) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(40) NOT NULL,
    codigo INT NOT NULL,
    cargo INT NOT NULL
);

CREATE TABLE IF NOT EXISTS coordenador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    RM VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(40) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(40) NOT NULL,
    codigo INT NOT NULL,
    cargo INT NOT NULL
);

CREATE TABLE IF NOT EXISTS diretor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        cargo INT NOT NULL,
        codigo INT NOT NULL
    );
    
CREATE TABLE IF NOT EXISTS turma (
    id INT AUTO_INCREMENT PRIMARY KEY,
    disciplina VARCHAR(30) NOT NULL,
    professor_id INT NOT NULL,
    coordenador_id INT NOT NULL,
    aluno_id INT NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    FOREIGN KEY (professor_id) REFERENCES professor(id) ON DELETE CASCADE,
    FOREIGN KEY (coordenador_id) REFERENCES coordenador(id) ON DELETE CASCADE,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS disciplina (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_disciplina VARCHAR(30) NOT NULL,
    carga_horaria INT NOT NULL,
    semestre INT NOT NULL,
    ano INT NOT NULL,
    coordenador_id INT NOT NULL,
    professor_id INT NOT NULL,
    turma_id INT NOT NULL,
    FOREIGN KEY (coordenador_id) REFERENCES coordenador(id) ON DELETE CASCADE,
    FOREIGN KEY (professor_id) REFERENCES professor(id) ON DELETE CASCADE,
    FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS matricula (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    turma_id INT NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
    FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS avaliacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    turma_id INT NOT NULL,
    nota DECIMAL(3,2) NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
    FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS atividade (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    turma_id INT NOT NULL,
    data DATE NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
    FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS frequencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    turma_id INT NOT NULL,
    data DATE NOT NULL,
    presenca VARCHAR(10) NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
    FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS mensao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    turma_id INT NOT NULL,
    mensao VARCHAR(100) NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
    FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS mensagens_chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    receptor_id INT NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_role ENUM('aluno', 'professor', 'coordenador') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES aluno(id) ON DELETE CASCADE,
    FOREIGN KEY (receptor_id) REFERENCES aluno(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS cronograma (
    id INT AUTO_INCREMENT PRIMARY KEY,
    turma_id INT NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,
    atividade VARCHAR(100) NOT NULL,
    FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS declaracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    turma_id INT NOT NULL,
    declaracao TEXT NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
    FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS chamada (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    nome_aluno VARCHAR(50) NOT NULL,
    presente TINYINT(1) NOT NULL,
    motivo_ausencia VARCHAR(50) NULL,
    data DATE NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE
);
