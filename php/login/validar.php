<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$session_options = [
    'cookie_lifetime' => 86400,
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict'
];

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
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

    // Valida se o email é um formato válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Por favor, insira um email válido.');
                window.location.href = '../../index.html';
              </script>";
        exit();
    }

    $tables = ['aluno', 'professor', 'coordenador', 'diretor'];
    $userFound = false;

    foreach ($tables as $table) {
        if ($table === 'aluno') {
            $stmt = $conn->prepare("SELECT id, nome, RM, status, foto, email, senha, curso, frequencia, endereco, nacionalidade, telefone FROM aluno WHERE email = ?");
        } elseif ($table === 'professor') {
            $stmt = $conn->prepare("SELECT id, nome, RM, status, foto, email, senha, cpf, disciplina, genero FROM professor WHERE email = ?");
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
            if ($table === 'aluno') {
                $stmt->bind_result($id, $nome, $RM, $status, $foto, $emailBD, $hashed_password, $curso_id, $nacionalidade, $frequencia, $endereco, $telefone);
            } elseif($table === 'professor') {
                $stmt->bind_result($id, $nome, $RM, $status, $foto, $emailBD, $hashed_password, $cpf, $disciplina, $genero);
            } else {
                $stmt->bind_result($id, $nome, $RM, $status, $foto, $emailBD, $hashed_password, $cpf);
            }
            
            $stmt->fetch();

            if (password_verify($senha, $hashed_password)) {
                session_regenerate_id(true);

                if ($table === 'aluno') {
                    $_SESSION['user'] = [
                        'id' => $id,
                        'nome' => $nome,
                        'foto' => $foto,
                        'email' => $emailBD,
                        'RM' => $RM,
                        'status' => $status,
                        'curso' => $curso_id,
                        'frequencia' => $frequencia,
                        'telefone' => $telefone,
                        'endereco' => $endereco,
                        'nacionalidade' => $nacionalidade,
                        'role' => $table
                    ];
                } elseif ($table === 'professor') {
                    // Determina o título com base no gênero
                    $titulo = ($genero === 'F') ? 'Professora' : 'Professor';

                    $_SESSION['user'] = [
                        'id' => $id,
                        'nome' => $titulo . ' ' . $nome,
                        'foto' => $foto,
                        'email' => $emailBD,
                        'RM' => $RM,
                        'disciplina' => $disciplina,
                        'cpf' => $cpf,
                        'genero' => $genero,
                        'status' => $status,
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

                header("Location: ../../pages/$table/home_$table.php");
                exit();
            }
            $userFound = true;
            break;
        }
    }

    if (!$userFound) {
        echo "<script>
                alert('Email ou senha incorretos.');
                window.location.href = '../../index.html';
              </script>";
    }
}
