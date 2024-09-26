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
<<<<<<< HEAD
        RM VARCHAR(10) NOT NULL,
<<<<<<< HEAD
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255) DEFAULT NULL,
=======
        cargo int NOT NULL,
        cpf VARCHAR(11) NOT NULL,
        foto LONGBLOB NOT NULL,
>>>>>>> 669cf1401154097bd37094133604fec66fc6b04e
=======
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255),
        cargo ENUM('aluno') NOT NULL,
>>>>>>> ce59a6049b974f4dab4fea36a875e551f3cd8b09
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        sobrenome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        data_nascimento DATE NOT NULL,
        genero ENUM('masculino', 'feminino', 'nao-binario', 'prefiro-nao-dizer') NOT NULL,
        endereco TEXT,
        curso VARCHAR(50),
        codigo INT NOT NULL UNIQUE,
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    "professor" => "CREATE TABLE IF NOT EXISTS professor (
        id INT AUTO_INCREMENT PRIMARY KEY,
<<<<<<< HEAD
        RM VARCHAR(10) NOT NULL,
<<<<<<< HEAD
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255) DEFAULT NULL,
=======
        foto LONGBLOB NOT NULL,
        cargo int NOT NULL,
        disciplina varchar (15) NOT NULL,
        cpf VARCHAR(11) NOT NULL,
>>>>>>> 669cf1401154097bd37094133604fec66fc6b04e
=======
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255),
        cargo ENUM('professor') NOT NULL,
>>>>>>> ce59a6049b974f4dab4fea36a875e551f3cd8b09
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        sobrenome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        disciplina VARCHAR(50) NOT NULL,
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
   "coordenador" => "CREATE TABLE IF NOT EXISTS coordenador (
        id INT AUTO_INCREMENT PRIMARY KEY,
<<<<<<< HEAD
        RM VARCHAR(10) NOT NULL,
<<<<<<< HEAD
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255) DEFAULT NULL,
=======
        cargo int NOT NULL,
        cpf VARCHAR(11) NOT NULL,
        foto LONGBLOB NOT NULL,
>>>>>>> 669cf1401154097bd37094133604fec66fc6b04e
=======
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255),
        cargo ENUM('coordenador') NOT NULL,
>>>>>>> ce59a6049b974f4dab4fea36a875e551f3cd8b09
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        sobrenome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
     "diretor" => "CREATE TABLE IF NOT EXISTS diretor (
        id INT AUTO_INCREMENT PRIMARY KEY,
<<<<<<< HEAD
        RM VARCHAR(10) NOT NULL,
<<<<<<< HEAD
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255) DEFAULT NULL,
=======
        cargo int NOT NULL,
        foto LONGBLOB NOT NULL,
        cpf VARCHAR(11) NOT NULL,
>>>>>>> 669cf1401154097bd37094133604fec66fc6b04e
=======
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255),
        cargo ENUM('diretor') NOT NULL,
>>>>>>> ce59a6049b974f4dab4fea36a875e551f3cd8b09
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        sobrenome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
     "turma" => "CREATE TABLE IF NOT EXISTS turma (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        disciplina VARCHAR(30) NOT NULL,
        professor_id INT NOT NULL,
        coordenador_id INT NOT NULL,
        data_inicio DATE NOT NULL,
        data_fim DATE NOT NULL,
        status ENUM('ativa', 'concluida', 'cancelada') DEFAULT 'ativa',
        FOREIGN KEY (professor_id) REFERENCES professor(id) ON DELETE CASCADE,
        FOREIGN KEY (coordenador_id) REFERENCES coordenador(id) ON DELETE CASCADE
    )",
   "disciplina" => "CREATE TABLE IF NOT EXISTS disciplina (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome_disciplina VARCHAR(30) NOT NULL,
        carga_horaria INT NOT NULL,
        semestre INT NOT NULL,
        ano INT NOT NULL,
        professor_id INT NOT NULL,
        coordenador_id INT NOT NULL,
        FOREIGN KEY (professor_id) REFERENCES professor(id) ON DELETE CASCADE,
        FOREIGN KEY (coordenador_id) REFERENCES coordenador(id) ON DELETE CASCADE
    )",
    "matricula" => "CREATE TABLE IF NOT EXISTS matricula (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        data_matricula DATE DEFAULT CURRENT_DATE,
        status ENUM('ativa', 'concluida', 'cancelada') DEFAULT 'ativa',
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
  "avaliacao" => "CREATE TABLE IF NOT EXISTS avaliacao (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        nota DECIMAL(3,2) NOT NULL,
        data_avaliacao DATE DEFAULT CURRENT_DATE,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "atividade" => "CREATE TABLE IF NOT EXISTS atividade (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        descricao TEXT NOT NULL,
        data DATE NOT NULL,
        status ENUM('pendente', 'concluida') DEFAULT 'pendente',
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
   "frequencia" => "CREATE TABLE IF NOT EXISTS frequencia (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        data DATE NOT NULL,
        presenca ENUM('presente', 'ausente') NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "mensao" => "CREATE TABLE IF NOT EXISTS mensao (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        mensao VARCHAR(100) NOT NULL,
        data_mensao DATE DEFAULT CURRENT_DATE,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
     "mensagens_chat" => "CREATE TABLE IF NOT EXISTS mensagens_chat (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        receptor_id INT NOT NULL,
        mensagem TEXT NOT NULL,
        data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
        user_role ENUM('aluno', 'professor', 'coordenador', 'diretor') NOT NULL,
        FOREIGN KEY (user_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (receptor_id) REFERENCES aluno(id) ON DELETE CASCADE
    )",
    "cronograma" => "CREATE TABLE IF NOT EXISTS cronograma (
        id INT AUTO_INCREMENT PRIMARY KEY,
        turma_id INT NOT NULL,
        data DATE NOT NULL,
        hora TIME NOT NULL,
        atividade VARCHAR(100) NOT NULL,
        status ENUM('pendente', 'concluida') DEFAULT 'pendente',
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "declaracoes" => "CREATE TABLE IF NOT EXISTS declaracoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        declaracao TEXT NOT NULL,
        data_emissao DATE DEFAULT CURRENT_DATE,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "chamada" => "CREATE TABLE IF NOT EXISTS chamada (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        nome_aluno VARCHAR(50) NOT NULL,
        presente TINYINT(1) NOT NULL,
        motivo_ausencia VARCHAR(50) DEFAULT NULL,
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