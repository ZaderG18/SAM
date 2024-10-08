<?php
// Configuração do banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

// Conexão com o banco de dados usando mysqli
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para recuperar o módulo atual de um aluno
function getModuloAtual($conn, $aluno_id) {
    $stmt = $conn->prepare("SELECT modulo_id FROM matricula WHERE aluno_id = ?");
    $stmt->bind_param("i", $aluno_id);
    $stmt->execute();
    $stmt->bind_result($modulo_atual);
    $stmt->fetch();
    $stmt->close();
    return $modulo_atual;
}

// Função para processar as requisições POST
function handlePostRequest($conn, $aluno_id, $turma_id, $data, $presenca) {
    try {
        if (!empty($_POST['id'])) {
            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $stmt = $conn->prepare("UPDATE frequencia SET presenca = ? WHERE id = ?");
            $stmt->bind_param("si", $presenca, $id);
            $stmt->execute();
            $mensagem = 'FREQUENCIA_ATUALIZADA';
        } else {
            $stmt = $conn->prepare("INSERT INTO frequencia (aluno_id, turma_id, data, presenca) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $aluno_id, $turma_id, $data, $presenca);
            $stmt->execute();
            $mensagem = 'FREQUENCIA_ADICIONADA';
        }
        return $mensagem;
    } catch (mysqli_sql_exception $e) {
        logError($e->getMessage());
        return 'Erro ao processar requisição';
    }
}

// Função para obter os dados de frequência do módulo atual
function getFrequenciaData($conn, $modulo_atual) {
    $stmt = $conn->prepare("SELECT disciplina, aulas_dadas, faltas, faltas_permitidas, frequencia_atual, frequencia_total 
                           FROM frequencia WHERE turma_id = ?");
    $stmt->bind_param("i", $modulo_atual);
    $stmt->execute();
    $frequencia_result = $stmt->get_result();
    $frequencia_data = array();
    while ($row = $frequencia_result->fetch_assoc()) {
        $frequencia_data[] = $row;
    }
    $stmt->close();
    return $frequencia_data;
}

// Função para recuperar dados específicos da disciplina "Programação Mobile"
function getDadosModal($conn, $disciplina) {
    $stmt = $conn->prepare("SELECT data, conteudo, professor, aulas_dadas, faltas FROM aulas WHERE disciplina = ?");
    $stmt->bind_param("s", $disciplina);
    $stmt->execute();
    $result = $stmt->get_result();
    $dadosModal = array();
    while ($row = $result->fetch_assoc()) {
        $dadosModal[] = $row;
    }
    $stmt->close();
    return $dadosModal;
}

// Função para registrar erros em um arquivo de log
function logError($message) {
    $logFile = 'logs/error.log';
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
}

// Script principal
session_start();
$aluno_id = isset($_SESSION['aluno_id']) ? $_SESSION['aluno_id'] : null;

if ($aluno_id) {
    $modulo_atual = getModuloAtual($conn, $aluno_id);
    
    if ($modulo_atual) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $turma_id = filter_var($_POST['turma_id'], FILTER_SANITIZE_NUMBER_INT);
            $data = filter_var($_POST['data'], FILTER_SANITIZE_STRING);
            $presenca = filter_var($_POST['presenca'], FILTER_SANITIZE_STRING);
            
            // Valida se a data está no formato correto
            $dateObject = DateTime::createFromFormat('Y-m-d', $data);
            if (!$dateObject) {
                logError("Data inválida: $data");
                echo 'Data inválida. Tente novamente.';
                exit();
            }

            $mensagem = handlePostRequest($conn, $aluno_id, $turma_id, $data, $presenca);
            echo $mensagem;

        } else {
            // Obtém os dados de frequência
            $frequencia_data = getFrequenciaData($conn, $modulo_atual);

            // Caso seja necessário mostrar dados específicos da disciplina
            if (isset($_GET['disciplina']) && $_GET['disciplina'] === 'Programação Mobile') {
                $dadosModal = getDadosModal($conn, 'Programação Mobile');
                // Processa os dados do modal, se necessário
            }
        }
    } else {
        echo 'Módulo não encontrado para o aluno com ID: ' . $aluno_id;
    }
} else {
    echo 'Aluno ID não encontrado';
}
?>
