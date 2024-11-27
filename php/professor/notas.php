<?php
// Incluir a conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($host, $username, $password, $dbname);

if (isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    if (strpos($acao, 'calcular_') === 0) {
        // Ação de calcular a média
        $id_usuario = str_replace('calcular_', '', $acao);  // Obtém o ID do usuário (aluno ou professor)
        $nota1 = $_POST['nota1'][$id_usuario];
        $nota2 = $_POST['nota2'][$id_usuario];

        // Calcular a média
        $media = ($nota1 + $nota2) / 2;

        // Atualizar no banco de dados a média na tabela notas
        $sql = "UPDATE notas SET media = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $media, $id_usuario);
        $stmt->execute();
        $stmt->close();

        echo "Média calculada e salva com sucesso!";
    }

    if (strpos($acao, 'editar_') === 0) {
        // Ação de editar a nota
        $id_usuario = str_replace('editar_', '', $acao);  // Obtém o ID do usuário (aluno ou professor)
        $nota1 = $_POST['nota1'][$id_usuario];
        $nota2 = $_POST['nota2'][$id_usuario];

        // Atualizar as notas no banco de dados
        $sql = "UPDATE notas SET nota1 = ?, nota2 = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddi", $nota1, $nota2, $id_usuario);
        $stmt->execute();
        $stmt->close();

        echo "Notas editadas e salvas com sucesso!";
    }

    if ($acao === 'salvar_notas') {
        // Ação de salvar todas as notas
        foreach ($_POST['nota1'] as $id_usuario => $nota1) {
            $nota2 = $_POST['nota2'][$id_usuario];
            $observacao = $_POST['observacoes'][$id_usuario];

            // Calcular a média
            $media = ($nota1 + $nota2) / 2;

            // Atualizar as notas e a média no banco de dados
            $sql = "UPDATE notas SET nota1 = ?, nota2 = ?, media = ?, observacao = ? WHERE id_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ddssi", $nota1, $nota2, $media, $observacao, $id_usuario);
            $stmt->execute();
            $stmt->close();
        }
        echo "Notas salvas com sucesso!";
    }

    if ($acao === 'enviar_coord') {
        // Ação de enviar para coordenação/diretoria
        // Você pode implementar a lógica para enviar as notas para a coordenação por email, por exemplo
        echo "Notas enviadas para coordenação!";
    }
}