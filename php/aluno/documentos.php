<?php
// Conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados");
}

$mensagem = "";
$protocolo = "";
$resultadoConsulta = [];

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Solicitação de declaração
    if ($action == 'declaracao') {
        $tipo_declaracao = filter_input(INPUT_POST, 'tipo-declaracao', FILTER_SANITIZE_SPECIAL_CHARS);
        $motivo = filter_input(INPUT_POST, 'motivo', FILTER_SANITIZE_SPECIAL_CHARS);
        $protocolo = uniqid();

        $stmt = $conn->prepare("INSERT INTO declaracoes (tipo_declaracao, motivo, protocolo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $tipo_declaracao, $motivo, $protocolo);

        if ($stmt->execute()) {
            $mensagem = "Declaração solicitada com sucesso! Protocolo: $protocolo";
        } else {
            $mensagem = "Erro ao solicitar a declaração.";
        }
        $stmt->close();
    }

    // Consulta de protocolo
    if ($action == 'consulta') {
        $protocoloConsulta = filter_input(INPUT_POST, 'protocolo', FILTER_SANITIZE_SPECIAL_CHARS);
        $stmt = $conn->prepare("SELECT * FROM declaracoes WHERE protocolo = ?");
        $stmt->bind_param("s", $protocoloConsulta);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $resultadoConsulta = $result->fetch_assoc();
        } else {
            $mensagem = "Protocolo não encontrado.";
        }
        $stmt->close();
    }

    // Processar a rematrícula
    if ($action == 'rematricula') {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_SPECIAL_CHARS);

        // Validar se estamos no prazo de rematrícula
        $dataAtual = date('Y-m-d');
        $inicioRematricula = '2024-10-09';
        $fimRematricula = '2024-12-16';

        if ($dataAtual < $inicioRematricula || $dataAtual > $fimRematricula) {
            $mensagem = "Rematrícula fora do prazo.";
        } else {
            // Verificar se o aluno já fez a rematrícula
            $anoAtual = date('Y');
            $stmt = $conn->prepare("SELECT COUNT(*) FROM rematricula WHERE aluno_id = ? AND YEAR(data_rematricula) = ?");
            $stmt->bind_param("is", $matricula, $anoAtual);
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
            $stmt->close();

            if ($total > 0) {
                $mensagem = "Você já realizou a rematrícula neste ano.";
            } else {
                // Inserir a rematrícula no banco
                $stmt = $conn->prepare("INSERT INTO rematricula (aluno_id, data_rematricula, status) VALUES (?, ?, ?)");
                $status = "ativo";
                $stmt->bind_param("iss", $matricula, $dataAtual, $status);

                if ($stmt->execute()) {
                    $mensagem = "Rematrícula realizada com sucesso!";
                } else {
                    $mensagem = "Erro ao realizar a rematrícula.";
                }
                $stmt->close();
            }
        }
    }
}