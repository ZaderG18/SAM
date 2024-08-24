<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: validar.php');
    exit();
}

require_once 'funcao.php';
$user = $_SESSION['user'];

$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

$alunos = get_todos_alunos($conn);

// Processa o formulário de presença
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = date('Y-m-d'); // Data atual

    // Prepara a declaração para inserção
    $stmt = $conn->prepare('INSERT INTO chamada (aluno_id, nome_aluno, presente, motivo_ausencia, data) VALUES (?, ?, ?, ?, ?)');
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }

    // Executa a inserção para cada aluno
    foreach ($_POST['presenca'] as $aluno_id => $values) {
        $presente = $values['status'] == 'presente' ? 1 : 0;
        $motivo_ausencia = $values['motivo'] ?? ''; // Use an empty string if no motivo is provided
        
        $stmt->bind_param('iisss', $aluno_id, $presente, $motivo_ausencia, $data);
        if (!$stmt->execute()) {
            echo "Erro ao registrar presença para o aluno ID $aluno_id: " . $stmt->error . "<br>";
        }
    }

    $stmt->close();
    echo 'Chamada registrada com sucesso!';
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Chamada</title>
</head>
<body>
    <h1>Lista de Chamada</h1>
    <form method="POST">
        <table>
            <tr>
                <th>Nome</th>
                <th>Presença</th>
                <th>Motivo da Ausência</th>
            </tr>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                    <td>
                        <input type="radio" name="presenca[<?php echo $aluno['id']; ?>][status]" value="presente" checked> Presente
                        <input type="radio" name="presenca[<?php echo $aluno['id']; ?>][status]" value="ausente"> Ausente
                    </td>
                    <td>
                        <input type="text" name="presenca[<?php echo $aluno['id']; ?>][motivo]" placeholder="Motivo da ausência">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
