<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão ao banco de dados
    $conn = new mysqli("localhost", "root", "", "SAM");
    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    // Sanitização e validação de email
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, insira um email válido.'); window.location.href = '../../index.html';</script>";
        exit();
    }

    // Prepara a consulta SQL para buscar o usuário na tabela 'usuarios'
    $query = "SELECT id, nome, RM, status, foto, email, senha, cargo, endereco, nacionalidade, telefone, cpf, genero 
              FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Associa as variáveis aos resultados da consulta
        $stmt->bind_result($id, $nome, $RM, $status, $foto, $emailBD, $hashed_password, $cargo, $endereco, $nacionalidade, $telefone, $cpf, $genero);
        $stmt->fetch();

        // Verifica a senha
        if (password_verify($senha, $hashed_password)) {
            session_regenerate_id(true);

            // Estrutura da sessão com base nas informações do usuário
            $_SESSION['user'] = [
                'id' => $id,
                'nome' => ($cargo == 2 ? (($genero === 'F') ? 'Professora' : 'Professor') . ' ' : '') . $nome,
                'foto' => $foto,
                'email' => $emailBD,
                'RM' => $RM,
                'status' => $status,
                'role' => $cargo,
                'telefone' => $cargo == 1 ? $telefone : ($cargo == 2 ? $telefone : null),
                'endereco' => $cargo == 1 ? $endereco : null,
                'nacionalidade' => $cargo == 1 ? $nacionalidade : null,
                'cpf' => in_array($cargo, [2, 3, 4]) ? $cpf : null,
                'genero' => $cargo == 2 ? $genero : null
            ];

            $stmt->close();
            $conn->close();
            
            // Redireciona o usuário para a página inicial com base no cargo
            $roleMap = [
                1 => 'aluno',
                2 => 'professor',
                3 => 'coordenador',
                4 => 'diretor'
            ];
            $role = $roleMap[$cargo];
            header("Location: ../../pages/$cargo/home_$cargo.php");
            exit();
        }
    }

    // Fecha a declaração e a conexão se a validação falhar
    $stmt->close();
    $conn->close();

    // Mensagem de erro se o login falhar
    echo "<script>alert('Email ou senha incorretos.'); window.location.href = '../../index.html';</script>";
}
