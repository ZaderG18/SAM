<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'sam');

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nota1 = $_POST['nota1'];
    $nota2 = $_POST['nota2'];
    $media = $_POST['media'];
    $recuperacao = $_POST['recuperacao'];
    $media_rec = $_POST['media_rec'];
    $observacoes = $_POST['observacoes'];

    $success = true;

    // Usar prepared statement para evitar SQL injection
    $stmt = $conn->prepare("
        INSERT INTO notas (aluno_id, nota1, nota2, nota_media, recuperacao, media_rec, observacoes) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        nota1 = VALUES(nota1), 
        nota2 = VALUES(nota2), 
        nota_media = VALUES(nota_media), 
        recuperacao = VALUES(recuperacao), 
        media_rec = VALUES(media_rec), 
        observacoes = VALUES(observacoes)
    ");

    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    foreach ($nota1 as $id => $n1) {
        $n2 = $nota2[$id];
        $med = $media[$id];
        $rec = $recuperacao[$id];
        $med_rec = $media_rec[$id];
        $obs = $observacoes[$id];

        // Associar parâmetros e executar
        $stmt->bind_param('iddddds', $id, $n1, $n2, $med, $rec, $med_rec, $obs);

        if (!$stmt->execute()) {
            $success = false;
            echo "Erro ao salvar nota para o aluno $id: " . $stmt->error;
        }
    }

    $stmt->close();

    if ($success) {
        echo "<script>alert('Notas salvas com sucesso!'); window.location.href='../../pages/professor/boletim.php';</script>";
    } else {
        echo "Erro ao salvar notas.";
    }
}

$conn->close();
?>
