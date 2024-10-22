<?php
// Inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['user']['id'])) {
    die("Acesso negado: Usuário não autenticado.");
}

// Declara variáveis de conexão ao banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";

// Conectando ao banco de dados MySQL e selecionando o banco
$conn = new mysqli($host, $username, $password, $dbName);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Função para enviar uma nova mensagem
function enviarMensagem($conn, $remetente_id, $receptor_id, $mensagem) {
    $sql = "INSERT INTO mensagens_chat (user_id, mensagem, receptor_id, data_envio) VALUES (?, ?, ?, NOW())";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isi", $remetente_id, $mensagem, $receptor_id);
        if ($stmt->execute()) {
            return ['success' => true]; // Mensagem enviada com sucesso
        } else {
            return ['success' => false, 'error' => "Erro ao enviar a mensagem: " . $stmt->error];
        }
    } else {
        return ['success' => false, 'error' => "Erro na preparação da consulta: " . $conn->error];
    }
}

// Função para buscar as mensagens do chat
function buscarMensagens($conn, $usuario_id) {
    $sql = "SELECT mensagens_chat.mensagem, 
                   CASE 
                       WHEN user_id = ? THEN 'Você' 
                       ELSE 
                           CASE 
                               WHEN EXISTS (SELECT * FROM aluno WHERE id = user_id) THEN (SELECT nome FROM aluno WHERE id = user_id) 
                               WHEN EXISTS (SELECT * FROM professor WHERE id = user_id) THEN (SELECT nome FROM professor WHERE id = user_id) 
                               WHEN EXISTS (SELECT * FROM diretor WHERE id = user_id) THEN (SELECT nome FROM diretor WHERE id = user_id) 
                               WHEN EXISTS (SELECT * FROM coordenador WHERE id = user_id) THEN (SELECT nome FROM coordenador WHERE id = user_id) 
                           END 
                   END AS remetente,
                   mensagens_chat.data_envio
            FROM mensagens_chat
            WHERE receptor_id = ? OR user_id = ?
            ORDER BY data_envio DESC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iii", $usuario_id, $usuario_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $mensagens = [];
        while ($row = $result->fetch_assoc()) {
            $mensagens[] = $row;
        }

        $stmt->close();
        return $mensagens;
    } else {
        return "Erro na preparação da consulta: " . $conn->error;
    }
}

// Função para buscar usuários recentes
function buscarUsuariosRecentes($conn, $usuario_id) {
    $sql = "SELECT DISTINCT 
                CASE 
                    WHEN user_id = ? THEN receptor_id 
                    ELSE user_id 
                END AS id_usuario
            FROM mensagens_chat
            WHERE user_id = ? OR receptor_id = ?
            ORDER BY MAX(data_envio) DESC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iii", $usuario_id, $usuario_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios_recentes = [];
        while ($row = $result->fetch_assoc()) {
            // Obtem o nome do usuário
            $id_usuario = $row['id_usuario'];
            $nome_usuario = '';

            // Verifica em cada tabela
            $nome_usuario = obterNomeUsuario($conn, $id_usuario);

            if ($nome_usuario) {
                $usuarios_recentes[] = ['id' => $id_usuario, 'nome' => $nome_usuario];
            }
        }

        $stmt->close();
        return $usuarios_recentes;
    } else {
        return "Erro na preparação da consulta: " . $conn->error;
    }
}

// Função para obter o nome do usuário a partir de seu ID
function obterNomeUsuario($conn, $usuario_id) {
    $tables = ['aluno', 'professor', 'coordenador', 'diretor'];
    foreach ($tables as $table) {
        $sql = "SELECT nome FROM $table WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $usuario_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['nome'];
            }
        }
    }
    return null; // Retorna null se o usuário não for encontrado em nenhuma tabela
}

// Verifica se o método de solicitação é POST para enviar mensagem
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $remetente_id = $_SESSION['user']['id'];
    $receptor_id = filter_input(INPUT_POST, 'receptor_id', FILTER_SANITIZE_NUMBER_INT);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!empty($mensagem) && !empty($receptor_id)) {
        $resultado = enviarMensagem($conn, $remetente_id, $receptor_id, $mensagem);
        if ($resultado['success']) {
            echo json_encode(['success' => true, 'message' => "Mensagem enviada com sucesso!"]);
        } else {
            echo json_encode(['success' => false, 'error' => $resultado['error']]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => "Mensagem ou receptor não pode ser vazio!"]);
    }
} else {
    // Se for uma requisição GET, busca as mensagens do chat e usuários recentes
    $usuario_atual_id = $_SESSION['user']['id'];
    $mensagens = buscarMensagens($conn, $usuario_atual_id);
    $usuarios_recentes = buscarUsuariosRecentes($conn, $usuario_atual_id);

    // Define o cabeçalho como JSON e retorna as mensagens e usuários em formato JSON
    header('Content-Type: application/json');
    echo json_encode(['mensagens' => $mensagens, 'usuarios_recentes' => $usuarios_recentes]);
}

