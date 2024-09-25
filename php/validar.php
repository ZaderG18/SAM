<?php
session_start();

// Declarando variáveis para conexão ao banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "SAM";

    // Conectando ao banco de dados
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }
    
    // Filtrando os dados de entrada
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    // Verifica se o usuário existe em qualquer uma das tabelas
    $tables = ['aluno', 'professor', 'coordenador', 'diretor'];
    $userFound = false; // Variável para controlar se o usuário foi encontrado

    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT id, nome, RM, email, senha FROM $table WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $nome, $RM, $emailBD, $hashed_password);
            $stmt->fetch();

            if (password_verify($senha, $hashed_password)) {
                // Armazena os dados do usuário na sessão
                $_SESSION['user'] = [
                    'id' => $id,
                    'nome' => $nome,
                    'email' => $emailBD, // Altera para a variável correta
                    'RM' => $RM,
                    'role' => $table  // Define o papel do usuário com base na tabela
                ];
                header("Location: ../pages/$table/home_$table.php"); // Redireciona para a página correspondente
                exit();
            } else {
                // Senha incorreta, não faz nada e continua a busca nas próximas tabelas
            }
            $userFound = true; // Define que o usuário foi encontrado
            break; // Sai do loop, pois já encontrou o usuário
        }
    }

    if (!$userFound) {
        echo "<script>
                alert('Email ou senha incorretos.');
                window.location.href = '../index.html';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
