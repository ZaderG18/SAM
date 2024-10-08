<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações seguras para o cookie da sessão
$session_options = [
    'cookie_lifetime' => 86400,    // Duração do cookie (1 dia)
    'cookie_secure' => true,       // Garante que o cookie só será enviado via HTTPS
    'cookie_httponly' => true,     // Impede que o cookie seja acessado por JavaScript
    'cookie_samesite' => 'Strict'  // Evita o envio do cookie em requests cross-site
];

// Verificar se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Declarando variáveis para conexão ao banco de dados
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
    // Ajuste na consulta SQL para incluir as colunas corretas
    $stmt = $conn->prepare("SELECT id, nome, RM, status, foto, email, senha FROM $table WHERE email = ?");

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Recuperando os valores do banco de dados
        // Ajuste aqui: deve corresponder exatamente ao número de colunas retornadas
        $stmt->bind_result($id, $nome, $RM, $status, $foto, $emailBD, $hashed_password);
        $stmt->fetch();

        // Verifica se a senha inserida é igual à senha armazenada no banco de dados
        if (password_verify($senha, $hashed_password)) {
            // Regenerar a sessão após o login para evitar ataque de Session Fixation
            session_regenerate_id(true);

            // Armazena os dados do usuário na sessão
            $_SESSION['user'] = [
                'id' => $id,
                'nome' => $nome,
                'foto' => $foto,
                'email' => $emailBD,
                'RM' => $RM,
                'status' => $status,
                'role' => $table // Define o papel do usuário com base na tabela
            ];

            // Redireciona para a página correspondente ao papel do usuário
            header("Location: ../../pages/$table/home_$table.php");
            exit();
        } else {
            // Senha incorreta, continua a busca nas próximas tabelas
        }
        $userFound = true; // Define que o usuário foi encontrado
        break; // Sai do loop, pois já encontrou o usuário
    }
}

// Se o usuário não for encontrado em nenhuma tabela
if (!$userFound) {
    echo "<script>
            alert('Email ou senha incorretos.');
            window.location.href = '../../index.html';
          </script>";
}
}