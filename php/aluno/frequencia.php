<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Suponha que o ID do aluno esteja disponível (por exemplo, passado por GET ou SESSION)
$aluno_id = isset($_SESSION['aluno_id']); // Exemplo de ID do aluno

// Obter o módulo atual do aluno
$stmt = $conn->prepare("SELECT modulo_id FROM matricula WHERE aluno_id = ?");
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$stmt->bind_result($modulo_atual);
$stmt->fetch();
$stmt->close();

// Verifica se um módulo foi encontrado
if (!$modulo_atual) {
    die("Módulo não encontrado para o aluno com ID: " . $aluno_id);
}

// Inicialize a variável
$frequencias = []; // Garante que a variável é um array vazio

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_SANITIZE_NUMBER_INT);
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
    $presenca = filter_input(INPUT_POST, 'presenca', FILTER_SANITIZE_STRING);

    try {
        if (!empty($_POST['id'])) {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $stmt = $conn->prepare("UPDATE frequencia SET presenca = ? WHERE id = ?");
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("si", $presenca, $id);
            $stmt->execute();
            $mensagem = 'FREQUENCIA_ATUALIZADA';
        } else {
            $stmt = $conn->prepare("INSERT INTO frequencia (aluno_id, turma_id, data, presenca) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("iiss", $aluno_id, $turma_id, $data, $presenca);
            $stmt->execute();
            $mensagem = 'FREQUENCIA_ADICIONADA';
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Obter informações da frequência para o módulo atual
$frequencia_sql = "SELECT disciplina, aulas_dadas, faltas, faltas_permitidas, frequencia_atual, frequencia_total 
                   FROM frequencia WHERE turma_id = ?"; // Ajuste conforme necessário
$stmt = $conn->prepare($frequencia_sql);
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("i", $modulo_atual); // Usar módulo atual
$stmt->execute();
$frequencia_result = $stmt->get_result();

if ($frequencia_result->num_rows > 0) {
    while ($row = $frequencia_result->fetch_assoc()) {
        $frequencias[] = $row; // Adiciona cada linha ao array
    }
}
$stmt->close();

// Lógica para buscar dados específicos da disciplina "Programação Mobile"
$dadosModal = [];
if (isset($_GET['disciplina']) && $_GET['disciplina'] === 'Programação Mobile') {
    $stmt = $conn->prepare("SELECT data, conteudo, professor, aulas_dadas, faltas FROM aulas WHERE disciplina = ?");
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $disciplina = 'Programação Mobile';
    $stmt->bind_param("s", $disciplina);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $dadosModal[] = $row;
    }
    $stmt->close();
}
