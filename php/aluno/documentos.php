<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Erro de conexão com o banco de dados']));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    // Processamento de rematrícula
    if ($action == 'rematricula') {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_SPECIAL_CHARS);

        // Validar se estamos dentro do prazo de rematrícula
        $dataAtual = date('Y-m-d');
        $inicioRematricula = '2024-12-09';
        $fimRematricula = '2024-12-16';

        if ($dataAtual < $inicioRematricula || $dataAtual > $fimRematricula) {
            echo json_encode(['success' => false, 'message' => 'Rematrícula fora do prazo.']);
            exit();
        }

        // Verificar se o aluno já fez a rematrícula
        $anoAtual = date('Y');
        $stmt = $conn->prepare("SELECT COUNT(*) FROM rematricula WHERE aluno_id = ? AND YEAR(data_rematricula) = ?");
        $stmt->bind_param("is", $matricula, $anoAtual);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();

        if ($total > 0) {
            echo json_encode(['success' => false, 'message' => 'Você já realizou a rematrícula neste ano.']);
            exit();
        }

        // Inserir a rematrícula no banco
        $stmt = $conn->prepare("INSERT INTO rematricula (aluno_id, data_rematricula, status) VALUES (?, ?, ?)");
        $status = "ativo";
        $stmt->bind_param("iss", $matricula, $dataAtual, $status);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Rematrícula realizada com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao realizar a rematrícula.']);
        }
        $stmt->close();
    }

    // Processamento de declaração
    if ($action == 'declaracao') {
        $tipo_declaracao = filter_input(INPUT_POST, 'tipo_declaracao', FILTER_SANITIZE_SPECIAL_CHARS);
        $motivo = filter_input(INPUT_POST, 'motivo', FILTER_SANITIZE_SPECIAL_CHARS);
        $protocolo = uniqid(); // Gerar um protocolo único

        // Inserir a solicitação de declaração no banco
        $stmt = $conn->prepare("INSERT INTO declaracoes (tipo_declaracao, motivo, protocolo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $tipo_declaracao, $motivo, $protocolo);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Declaração solicitada com sucesso!', 'protocolo' => $protocolo]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao solicitar a declaração.']);
        }
        $stmt->close();
    }
}
