<?php
// Função para obter todos os alunos do banco de dados.
function get_todos_alunos($conn) {
    // Prepara a consulta SQL para selecionar todos os campos necessários da tabela 'aluno'.
    $stmt = $conn->prepare("SELECT id, nome, email, RM, codigo FROM aluno");
    // Executa a consulta.
    $stmt->execute();
    // Retorna o resultado da execução da consulta.
    return $stmt->get_result();
}

// Função para obter todos os professores do banco de dados.
function get_todos_professores($conn) {
    // Prepara a consulta SQL para selecionar todos os campos necessários da tabela 'professor'.
    $stmt = $conn->prepare("SELECT id, RM, nome, email, codigo FROM professor");
    // Executa a consulta.
    $stmt->execute();
    // Retorna o resultado da execução da consulta.
    return $stmt->get_result();
}

// Função para obter todos os alunos e professores do banco de dados.
function get_todos_alunos_e_professores($conn) {
    // Chama a função para obter todos os alunos.
    $alunos = get_todos_alunos($conn);
    // Chama a função para obter todos os professores.
    $professores = get_todos_professores($conn);
    // Retorna um array associativo contendo os alunos e os professores.
    return ['aluno' => $alunos, 'professor' => $professores];
}

// Função para obter um aluno específico com base no RM.
function get_aluno_especifico($conn, $RM) {
    // Prepara a consulta SQL para selecionar os dados do aluno com o RM especificado.
    $stmt = $conn->prepare("SELECT id, nome, email, RM, codigo FROM aluno WHERE RM = ?");
    // Liga o parâmetro RM à consulta.
    $stmt->bind_param("s", $RM);
    // Executa a consulta.
    $stmt->execute();
    // Retorna o resultado da execução da consulta.
    return $stmt->get_result();
}
?>
