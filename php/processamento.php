<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



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
    "coordenador" => "CREATE TABLE IF NOT EXISTS coordenador (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL,
        email VARCHAR(40) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        codigo INT NOT NULL,
        cargo INT NOT NULL
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
    "faltas" => "CREATE TABLE IF NOT EXISTS faltas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        data DATE NOT NULL,
        motivo_ausencia VARCHAR(50) NULL,
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
    3 => 'coordenador'
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

function emailExiste($conn, $email){
    $sql = "SELECT id FROM aluno WHERE email = ?
    UNION
    SELECT id FROM professor WHERE email = ?
    UNION
    SELECT id FROM coordenador WHERE email = ?";
    if ($stmt = $conn->prepare($sql)){
        $stmt->bind_param("sss", $email, $email, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0){
            return true;
            }else{
                return false;
            }
            $stmt->close();
    }else{
        die("erro na query: " . $conn->error);
    }
}
if(emailExiste($conn, $email)){
    echo "Email já existe";
}else{
    echo "O email não está cadastrado";
}

$conn->close();
?>
