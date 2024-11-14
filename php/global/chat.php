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

// Conectando ao banco de dados MySQL
$conn = new mysqli($host, $username, $password, $dbName);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Função para enviar uma nova mensagem
function enviarMensagem($conn, $remetente_id, $receptor_id, $mensagem) {
    $sql = "INSERT INTO mensagens_chat (user_id, mensagem, receptor_id, data_envio) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("isi", $remetente_id, $mensagem, $receptor_id);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado ? ['success' => true] : ['success' => false, 'error' => $stmt->error];
    }
    return ['success' => false, 'error' => $conn->error];
}

// Função para buscar as mensagens do chat
function buscarMensagens($conn, $usuario_id) {
    $sql = "SELECT m.mensagem,
                   IF(m.user_id = ?, 'Você', u.nome) AS remetente,
                   m.data_envio
            FROM mensagens_chat m
            LEFT JOIN usuarios u ON m.user_id = u.id
            WHERE m.receptor_id = ? OR m.user_id = ?
            ORDER BY m.data_envio DESC";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iii", $usuario_id, $usuario_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $mensagens = [];
        while ($row = $result->fetch_assoc()) {
            $mensagens[] = $row;
        }
        $stmt->close();
        return $mensagens;
    }
    return [];
}

// Função para buscar usuários recentes com quem o usuário conversou
function buscarUsuariosRecentes($conn, $usuario_id) {
    $sql = "SELECT DISTINCT 
                CASE 
                    WHEN m.user_id = ? THEN m.receptor_id 
                    ELSE m.user_id 
                END AS id_usuario,
                u.nome
            FROM mensagens_chat m
            LEFT JOIN usuarios u ON u.id = CASE WHEN m.user_id = ? THEN m.receptor_id ELSE m.user_id END
            WHERE m.user_id = ? OR m.receptor_id = ?
            ORDER BY MAX(m.data_envio) DESC";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiii", $usuario_id, $usuario_id, $usuario_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios_recentes = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios_recentes[] = ['id' => $row['id_usuario'], 'nome' => $row['nome']];
        }
        $stmt->close();
        return $usuarios_recentes;
    }
    return [];
}

// Verifica se o método de solicitação é POST para enviar mensagem
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $remetente_id = $_SESSION['user']['id'];
    $receptor_id = filter_input(INPUT_POST, 'receptor_id', FILTER_SANITIZE_NUMBER_INT);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

    if (!empty($mensagem) && !empty($receptor_id)) {
        $resultado = enviarMensagem($conn, $remetente_id, $receptor_id, $mensagem);
        header('Content-Type: application/json');
        echo json_encode($resultado);
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

// Fecha a conexão com o banco de dados
$conn->close();
?>
