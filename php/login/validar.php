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
    // Conexão ao banco de dados
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "SAM";
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    // Filtrando os dados de entrada
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

    // Definindo as tabelas para a busca do usuário
    $tables = ['aluno', 'professor', 'coordenador', 'diretor'];
    $userFound = false;

    // Loop por cada tabela para buscar o usuário
    foreach ($tables as $table) {
        // Preparando a consulta específica para cada tipo de usuário
        if ($table === 'aluno') {
            $stmt = $conn->prepare("SELECT id, nome, RM, status, foto, email, senha, curso, frequencia FROM aluno WHERE email = ?");
        } elseif ($table === 'professor') {
            $stmt = $conn->prepare("SELECT id, nome, RM, status, foto, email, senha, cpf FROM professor WHERE email = ?");
        } elseif ($table === 'coordenador') {
            $stmt = $conn->prepare("SELECT id, nome, RM, status, foto, email, senha, cpf FROM coordenador WHERE email = ?");
        } else {
            $stmt = $conn->prepare("SELECT id, nome, RM, status, foto, email, senha, cpf FROM diretor WHERE email = ?");
        }

        if (!$stmt) {
            die("Erro ao preparar a consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Bind dos resultados com base na tabela atual
            if ($table === 'aluno') {
                $stmt->bind_result($id, $nome, $RM, $status, $foto, $emailBD, $hashed_password, $curso_id, $frequencia);
            } else {
                $stmt->bind_result($id, $nome, $RM, $status, $foto, $emailBD, $hashed_password, $cpf);
            }
            
            $stmt->fetch();

            // Verifica se a senha é correta
            if (password_verify($senha, $hashed_password)) {
                session_regenerate_id(true);

                // Armazenando informações específicas na sessão de acordo com o tipo de usuário
                if ($table === 'aluno') {
                    $_SESSION['user'] = [
                        'id' => $id,
                        'nome' => $nome,
                        'foto' => $foto,
                        'email' => $emailBD,
                        'RM' => $RM,
                        'status' => $status,
                        'curso' => $curso,
                        'frequencia' => $frequencia,
                        'role' => $table
                    ];
                } else {
                    $_SESSION['user'] = [
                        'id' => $id,
                        'nome' => $nome,
                        'foto' => $foto,
                        'email' => $emailBD,
                        'RM' => $RM,
                        'status' => $status,
                        'cpf' => $cpf,
                        'role' => $table
                    ];
                }

                // Redireciona o usuário para a página específica
                header("Location: ../../pages/$table/home_$table.php");
                exit();
            }
            $userFound = true;
            break;
        }
    }

    // Se o usuário não foi encontrado
    if (!$userFound) {
        echo "<script>
                alert('Email ou senha incorretos.');
                window.location.href = '../../index.html';
              </script>";
    }
}
