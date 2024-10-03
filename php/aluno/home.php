<?php
include "../global/conexao.php";

// ID do usuário 
$usuario_id = $_SESSION['user']['id'];

// Função para consultar o banco de dados de forma genérica
function consultarBanco($conn, $tabela, $usuario_id) {
    $sql = "SELECT * FROM $tabela WHERE aluno_id = ?";
    $stmt = $conn->prepare($sql);  // Utilizando prepared statement
    $stmt->bind_param("i", $usuario_id);  // 'i' significa que o parâmetro é um inteiro
    $stmt->execute();
    return $stmt->get_result();  // Retorna o resultado da consulta
}

// Recupera as informações do aluno
function obterAluno($conn, $usuario_id) {
    $sql_usuario = "SELECT * FROM aluno WHERE id = ?";
    $stmt = $conn->prepare($sql_usuario);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado_usuario = $stmt->get_result();
    return $resultado_usuario->fetch_assoc();  // Retorna os dados do aluno
}

// Função para calcular a média de notas
function calcularMedia($resultado_notas) {
    $media_geral = 0;
    $conta_notas = $resultado_notas->num_rows;
    
    if ($conta_notas > 0) {
        while ($nota = $resultado_notas->fetch_assoc()) {
            $media_geral += $nota['nota'];  // Soma todas as notas
        }
        $media_geral = $media_geral / $conta_notas;  // Calcula a média
    }
    
    return $media_geral;
}

// Execução

// Obtendo informações do aluno
$usuario = obterAluno($conn, $usuario_id);

if ($usuario) {
    // Obtendo dados do aluno
    $notas = consultarBanco($conn, "nota", $usuario_id);
    $atualizacoes = consultarBanco($conn, "atualizacao", $usuario_id);
    $frequencia = consultarBanco($conn, "frequencia", $usuario_id);

    // Calculando a média das notas
    $media_notas = calcularMedia($notas);

    // Exibindo dados
    echo "Aluno: " . $usuario['nome'] . "<br>";
    echo "Média das notas: " . $media_notas . "<br>";

    // Exemplo de exibição das atualizações
    while ($atualizacao = $atualizacoes->fetch_assoc()) {
        echo "Atualização: " . $atualizacao['descricao'] . "<br>";
    }

    // Exemplo de exibição da frequência
    while ($registro_frequencia = $frequencia->fetch_assoc()) {
        echo "Frequência: " . $registro_frequencia['status'] . "<br>";
    }
} else {
    echo "Aluno não encontrado.";
}

$conn->close();
?>
