<?php
session_start();

//declarando variaveis para conexão ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "SAM";

// conectando ao banco de dados

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }
    
//filtrando os dados de entrada

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    // Verifica se o usuário existe em qualquer uma das tabelas
    $tables = ['aluno', 'professor', 'coordenador', 'diretor'];
    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT id, nome, email, senha FROM $table WHERE email = ?");
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
                    'role' => $table  // Define o papel do usuário com base na tabela
                ];
                header("Location: ../pages/$table/home_$table.php"); // Redireciona para a página correspondente
                exit();
            }
        }
    }
    ?>
    <script>
     alert ("Email ou senha incorretos.");
     window.location.href = "../index.html";
    </script>
    <?php
    $stmt->close();
    $conn->close();
}
?>