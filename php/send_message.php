<?php
session_start(); // Inicia a sessão ou retoma a sessão existente. Necessário para acessar variáveis de sessão.

include('conexao.php'); // Inclui o arquivo 'processamento.php', que deve conter a conexão com o banco de dados.

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Verifica se a requisição foi feita via método POST.
    $remetente_id = $_SESSION['user_id']; // Obtém o ID do usuário remetente a partir da variável de sessão.
    $receptor_id = $_POST['receptor_id']; // Obtém o ID do receptor da mensagem a partir dos dados POST.
    $mensagem = $_POST['mensagem']; // Obtém o conteúdo da mensagem a partir dos dados POST.

    if (empty($mensagem)) { // Verifica se a mensagem está vazia.
        echo json_encode(['sucesso' => false, 'messagem' => 'A mensagem não pode estar vazia']); // Retorna um JSON indicando falha e uma mensagem de erro.
        exit; // Encerra a execução do script se a mensagem estiver vazia.
    }

    // Prepara a consulta SQL para inserir a mensagem na tabela 'mensagens_chat'.
    $sql = "INSERT INTO mensagens_chat (user_id, mensagem, receptor_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql); // Prepara a declaração SQL para execução segura.
    $stmt->bind_param("isi", $remetente_id, $mensagem, $receptor_id); // Liga os parâmetros da consulta SQL aos valores fornecidos.

    if ($stmt->execute()) { // Executa a consulta SQL e verifica se a execução foi bem-sucedida.
        echo json_encode(['sucesso' => true]); // Retorna um JSON indicando sucesso.
    } else {
        echo json_encode(['sucesso' => false, 'messagem' => 'Erro ao enviar a mensagem']); // Retorna um JSON indicando falha e uma mensagem de erro.
    }

    $stmt->close(); // Fecha a declaração preparada, liberando os recursos associados.
    $conn->close(); // Fecha a conexão com o banco de dados.
}
?>
