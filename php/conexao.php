<?php

// Inicia a sessão se ainda não estiver iniciada.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Declarando variáveis para conectar ao banco de dados.
$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";

// Conectando ao servidor MySQL.
$conn = new mysqli($host, $username, $password);

// Verifica se houve erro na conexão com o servidor MySQL.
if ($conn->connect_error) {
    die("Erro ao conectar ao servidor de banco de dados: " . $conn->connect_error);
} else {
    echo "Conectado ao servidor com sucesso!<br>";
}

// Criando o banco de dados 'SAM' se ele não existir.
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados '$dbName' criado com sucesso!<br>";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error;
}

// Reestabelece a conexão ao banco de dados específico 'SAM'.
$conn = new mysqli($host, $username, $password, $dbName);

// Verifica se houve erro na conexão com o banco de dados específico.
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Consultas para criar as tabelas, se não existirem.
$tableQueries = [
    "aluno" => "CREATE TABLE IF NOT EXISTS aluno (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL,
        cargo int NOT NULL,
        cpf VARCHAR(11) NOT NULL,
        foto VARCHAR NOT NULL,
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "professor" => "CREATE TABLE IF NOT EXISTS professor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL,
        foto VARCHAR NOT NULL,
        cargo int NOT NULL,
        disciplina varchar (15) NOT NULL,
        cpf VARCHAR(11) NOT NULL,
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "coordenador" => "CREATE TABLE IF NOT EXISTS coordenador (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL,
        cargo int NOT NULL,
        cpf VARCHAR(11) NOT NULL,
        foto VARCHAR NOT NULL,
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "diretor" => "CREATE TABLE IF NOT EXISTS diretor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL,
        cargo int NOT NULL,
        foto VARCHAR NOT NULL,
        cpf VARCHAR(11) NOT NULL,
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        cargo INT NOT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "turma" => "CREATE TABLE IF NOT EXISTS turma (
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
    )",
    "disciplina" => "CREATE TABLE IF NOT EXISTS disciplina (
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
    )",
    "matricula" => "CREATE TABLE IF NOT EXISTS matricula (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "avaliacao" => "CREATE TABLE IF NOT EXISTS avaliacao (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        nota DECIMAL(3,2) NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "atividade" => "CREATE TABLE IF NOT EXISTS atividade (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        data DATE NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "frequencia" => "CREATE TABLE IF NOT EXISTS frequencia (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        data DATE NOT NULL,
        presenca VARCHAR(10) NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "mensao" => "CREATE TABLE IF NOT EXISTS mensao (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        mensao VARCHAR(100) NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "mensagens_chat" => "CREATE TABLE IF NOT EXISTS mensagens_chat (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        receptor_id INT NOT NULL,
        mensagem TEXT NOT NULL,
        data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
        user_role ENUM('aluno', 'professor', 'coordenador') NOT NULL,
        FOREIGN KEY (user_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (receptor_id) REFERENCES aluno(id) ON DELETE CASCADE
    )",
    "cronograma" => "CREATE TABLE IF NOT EXISTS cronograma(
        id INT AUTO_INCREMENT PRIMARY KEY,
        turma_id INT NOT NULL,
        data DATE NOT NULL,
        hora TIME NOT NULL,
        atividade VARCHAR(100) NOT NULL,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "declaracoes" => "CREATE TABLE IF NOT EXISTS declaracoes(
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        declaracao TEXT NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "chamada" => "CREATE TABLE IF NOT EXISTS chamada (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        nome_aluno VARCHAR(50) NOT NULL,
        presente TINYINT(1) NOT NULL,
        motivo_ausencia VARCHAR(50) NULL,
        data DATE NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE
    )"
];

// Itera sobre o array de consultas para criar as tabelas no banco de dados.
foreach ($tableQueries as $tableName => $sqlTable) {
    if ($conn->query($sqlTable) === TRUE) {
        echo "Tabela '$tableName' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar a tabela '$tableName': " . $conn->error . "<br>";
    }
}