<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "SAM";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    // Verifica se é aluno
    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM aluno WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome, $email, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($senha, $hashed_password)) {
            $_SESSION['user'] = [
                'id' => $id,
                'nome' => $nome,
                'email' => $email,
                'role' => 'aluno'  // Define o papel como aluno
            ];
            header("Location: ../pages/home_aluno.php");
            exit();
        }
    }

    // Verifica se é professor
    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM professor WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome, $email, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($senha, $hashed_password)) {
            $_SESSION['user'] = [
                'id' => $id,
                'nome' => $nome,
                'email' => $email,
                'role' => 'professor'  // Define o papel como professor
            ];
            header("Location: ../pages/home_professor.php");
            exit();
        }
    }

    // Verifica se é coordenador (assumindo que coordenadores têm acesso a professores e alunos)
    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM coordenador WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome, $email, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($senha, $hashed_password)) {
            $_SESSION['user'] = [
                'id' => $id,
                'nome' => $nome,
                'email' => $email,
                'role' => 'coordenador'  // Define o papel como coordenador
            ];
            header("Location: ../pages/home_coordenador.php");
            exit();
        }
    }
    echo "Email ou senha incorretos.";

    $stmt->close();
    $conn->close();
}
?>
