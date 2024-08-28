<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";

// Connect to MySQL server
$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Erro ao conectar ao servidor de banco de dados: " . $conn->connect_error);
} else {
    echo "Conectado ao servidor com sucesso!<br>";
}

// Create database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados '$dbName' criado com sucesso!<br>";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error;
}

// Connect to the specific database
$conn = new mysqli($host, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Table creation queries
$tableQueries = [
    "aluno" => "CREATE TABLE IF NOT EXISTS aluno (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        cargo INT NOT NULL
    )",
    "professor" => "CREATE TABLE IF NOT EXISTS professor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        cargo INT NOT NULL
    )",
    "coordenador" => "CREATE TABLE IF NOT EXISTS coordenador (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        cargo INT NOT NULL
    )",
    "diretor"=> "CREATE TABLE IF NOT EXISTS diretor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    RM VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(40) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(40) NOT NULL,
    cargo INT NOT NULL,
    codigo INT NOT NULL
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

foreach ($tableQueries as $tableName => $sqlTable) {
    if ($conn->query($sqlTable) === TRUE) {
        echo "Tabela '$tableName' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar a tabela '$tableName': " . $conn->error . "<br>";
    }
}

// Sanitize and validate form inputs
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);

if ( !$email || !$senha || !$nome || !$cargo) {
    die("Todos os campos são obrigatórios.");
}

// Check if the email already exists
if (emailExiste($conn, $email)) {
    die("Email já existe");
}

$tableMap = [
    1 => 'aluno',
    2 => 'professor',
    3 => 'coordenador',
    4 => 'diretor'
];

$tableName = $tableMap[$cargo] ?? 'aluno';
$tableName = $tableMap[$cargo] ?? 'professor';
$tableName = $tableMap[$cargo] ?? 'coordenador';
$tableName = $tableMap[$cargo] ?? 'diretor';

$hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

$sqlInsert = "INSERT INTO $tableName ( email, senha, nome) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sqlInsert);
$stmt->bind_param("sss", $email, $hashedPassword, $nome);

if ($stmt->execute()) {
    echo "Os dados foram inseridos com sucesso!<br>";
} else {
    echo "Não foi possível inserir os dados na tabela: " . $stmt->error;
}

// Redirect after operations
header('Location: ../pages/cadastro.html');
exit;

function emailExiste($conn, $email) {
    $sql = "SELECT id FROM aluno WHERE email = ?
            UNION
            SELECT id FROM professor WHERE email = ?
            UNION
            SELECT id FROM coordenador WHERE email = ?
            UNION
            SELECT id FROM diretor WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $email, $email, $email, $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    } else {
        die("Erro na query: " . $conn->error);
    }
}

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}


$conn -> close();