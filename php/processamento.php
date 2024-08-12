<?php

session_start();


$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";


$conn = new mysqli($host, $username, $password);


if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
} else {
    echo "Conectado ao servidor com sucesso!<br>";
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados '$dbName' criado com sucesso!<br>";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error;
}

$conn = new mysqli($host, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

$tableQueries = [
    "aluno" => "CREATE TABLE IF NOT EXISTS aluno (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL,
        email VARCHAR(40) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        cargo INT NOT NULL
    )",
    "professor" => "CREATE TABLE IF NOT EXISTS professor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL,
        email VARCHAR(40) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        cargo INT NOT NULL
    )",
    "responsavel" => "CREATE TABLE IF NOT EXISTS responsavel (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL,
        email VARCHAR(40) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        cargo INT NOT NULL
    )",
    "coordenador" => "CREATE TABLE IF NOT EXISTS coordenador (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL,
        email VARCHAR(40) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        cargo INT NOT NULL
    )"
];


foreach ($tableQueries as $tableName => $sqlTable) {
    if ($conn->query($sqlTable) === TRUE) {
        echo "Tabela '$tableName' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar a tabela '$tableName': " . $conn->error . "<br>";
    }
}


$RM = filter_input(INPUT_POST, 'RM', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_STRING);
$cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);


if (!$RM || !$email || !$senha || !$nome || !$codigo || !$cargo) {
    die("Todos os campos são obrigatórios.");
}


$tableMap = [
    1 => 'aluno',
    2 => 'professor',
    3 => 'coordenador',
    4 => 'responsavel'
];
$tableName = $tableMap[$cargo] ?? 'aluno';



$hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

$sqlInsert = "INSERT INTO $tableName (RM, email, senha, nome, codigo) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlInsert);
$stmt->bind_param("sssss", $RM, $email, $hashedPassword, $nome, $codigo);

if ($stmt->execute()) {
    echo "Os dados foram inseridos com sucesso!<br>";
} else {
    echo "Não foi possível inserir os dados na tabela: " . $stmt->error;
}

$sqlSelect = "SELECT * FROM aluno";
$result = $conn->query($sqlSelect);
$count = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $count++;
        header('Location:../cadastro.html');
       // echo $count . " - RM: " . htmlspecialchars($row["RM"]) . " - Email: " . htmlspecialchars($row["email"]) . " - Senha: " . htmlspecialchars($row["senha"]) . " - Nome: " . htmlspecialchars($row["nome"]) . " - Código: " . htmlspecialchars($row["codigo"]) . "<br>";
    }
} else {
    echo "Nenhum resultado encontrado.";
}
$sqlSelect = "SELECT * FROM professor";
$result = $conn->query($sqlSelect);
$count = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $count++;
        header('Location:../cadastro.html');
       // echo $count . " - RM: " . htmlspecialchars($row["RM"]) . " - Email: " . htmlspecialchars($row["email"]) . " - Senha: " . htmlspecialchars($row["senha"]) . " - Nome: " . htmlspecialchars($row["nome"]) . " - Código: " . htmlspecialchars($row["codigo"]) . "<br>";
    }
} else {
    echo "Nenhum resultado encontrado.";
}
$sqlSelect = "SELECT * FROM coordenador";
$result = $conn->query($sqlSelect);
$count = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $count++;
        header('Location:../cadastro.html');
       // echo $count . " - RM: " . htmlspecialchars($row["RM"]) . " - Email: " . htmlspecialchars($row["email"]) . " - Senha: " . htmlspecialchars($row["senha"]) . " - Nome: " . htmlspecialchars($row["nome"]) . " - Código: " . htmlspecialchars($row["codigo"]) . "<br>";
    }
} else {
    echo "Nenhum resultado encontrado.";
}
$sqlSelect = "SELECT * FROM responsavel";
$result = $conn->query($sqlSelect);
$count = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $count++;
        header('Location:../cadastro.html');
       // echo $count . " - RM: " . htmlspecialchars($row["RM"]) . " - Email: " . htmlspecialchars($row["email"]) . " - Senha: " . htmlspecialchars($row["senha"]) . " - Nome: " . htmlspecialchars($row["nome"]) . " - Código: " . htmlspecialchars($row["codigo"]) . "<br>";
    }
} else {
    echo "Nenhum resultado encontrado.";
}

$conn->close();
?>
