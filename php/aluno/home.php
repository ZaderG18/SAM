<?php
// Iniciar sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar se o usuário está logado
if (!isset($_SESSION['user']['id'])) {
    die("Usuário não está logado.");
}

$usuario_id = $_SESSION['user']['id'];

// Função para realizar consulta no banco
function consultarBanco($conn, $sql, $usuario_id) {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erro ao preparar consulta: " . $conn->error);
    }
    
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result;
}

// Buscar notas do aluno
$notas_sql = "SELECT nota_media FROM notas WHERE aluno_id = ?";
$notas_result = consultarBanco($conn, $notas_sql, $usuario_id);

$notas = [];
if ($notas_result->num_rows > 0) {
    while ($row = $notas_result->fetch_assoc()) {
        $notas[] = $row['nota_media']; // Usar a coluna correta
    }
    $media = array_sum($notas) / count($notas);
    $maior_nota = max($notas);
    $menor_nota = min($notas);
} else {
    $media = $maior_nota = $menor_nota = 0;
}

// Buscar tarefas pendentes do aluno
$atividades_sql = "SELECT descricao, data_entrega FROM atividade WHERE aluno_id = ? AND status = 'pendente'";
$atividades_result = consultarBanco($conn, $atividades_sql, $usuario_id);

$atividades = [];
$tarefas_pendentes = 0; // Contador para tarefas pendentes

if ($atividades_result->num_rows > 0) {
    while ($row = $atividades_result->fetch_assoc()) {
        $atividades[] = [
            "descricao" => $row['descricao'],
            "data_entrega" => $row['data_entrega'] // Certifique-se de que 'data_entrega' é o nome correto
        ];
        $tarefas_pendentes++; // Incrementa o contador
    }
} 

// Buscar horários de aula
$horarios_sql = "SELECT disciplina, dia_semana, hora_inicio, hora_fim FROM horarios WHERE aluno_id = ?";
$horarios_result = consultarBanco($conn, $horarios_sql, $usuario_id);

$horarios = [];
if ($horarios_result->num_rows > 0) {
    while ($row = $horarios_result->fetch_assoc()) {
        $horarios[] = [
            "disciplina" => $row['disciplina'],
            "dia_semana" => $row['dia_semana'],
            "hora_inicio" => $row['hora_inicio'],
            "hora_fim" => $row['hora_fim']
        ];
    }
}

// Buscar atualizações recentes
$atualizacoes_sql = "SELECT descricao, data_atualizacao FROM atualizacoes WHERE aluno_id = ? ORDER BY data_atualizacao DESC LIMIT 5";
$atualizacoes_result = consultarBanco($conn, $atualizacoes_sql, $usuario_id);

$atualizacoes = [];
$atualizacoes_importantes = 0; // Contador para atualizações importantes

if ($atualizacoes_result->num_rows > 0) {
    while ($row = $atualizacoes_result->fetch_assoc()) {
        $atualizacoes[] = [
            "descricao" => $row['descricao'],
            "data_atualizacao" => $row['data_atualizacao']
        ];
        $atualizacoes_importantes++; // Incrementa o contador
    }
}

// // Adicionar evento
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titulo'], $_POST['descricao'], $_POST['data'])) {
//     $titulo = $_POST['titulo'];
//     $descricao = $_POST['descricao'];
//     $data = $_POST['data'];

//     // Ajuste aqui para usar aluno_id em vez de usuario_id
//     $inserir_evento_sql = "INSERT INTO eventos (aluno_id, data, titulo, descricao) VALUES (?, ?, ?, ?)";
//     $stmt = $conn->prepare($inserir_evento_sql);
//     if (!$stmt) {
//         die("Erro ao preparar inserção: " . $conn->error);
//     }
//     $stmt->bind_param("isss", $usuario_id, $data, $titulo, $descricao);
//     $stmt->execute();
//     $stmt->close();
// }

// // Buscar eventos do aluno
// $eventos_sql = "SELECT data, titulo, descricao FROM eventos WHERE aluno_id = ?";
// $eventos_result = consultarBanco($conn, $eventos_sql, $usuario_id);

// $eventos = [];
// if ($eventos_result->num_rows > 0) {
//     while ($row = $eventos_result->fetch_assoc()) {
//         $eventos[] = [
//             "data" => $row['data'],
//             "titulo" => $row['titulo'],
//             "descricao" => $row['descricao']
//         ];
//     }
// }
?>
