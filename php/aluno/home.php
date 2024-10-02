<?php
include "../global/conexao.php";

$usuario_id = 1;

$sql_usuario = "SELECT * FROM aluno WHERE id = $usuario_id";
$resultado_usuario = $conn->query($sql_usuario);
$usuario = $resultado_usuario->fetch_assoc();

// Recuperando notas do aluno
$sql_notas = "SELECT * FROM nota WHERE aluno_id = $usuario_id";
$resultado_notas = $conn->query($sql_notas);

// recuperando atualizações do aluno
$sql_atualizacoes = "SELECT * FROM atualizacao WHERE aluno_id = $usuario_id";
$resultado_atualizacoes = $conn->query($sql_atualizacoes);

// recupera a frequencia do aluno
$sql_frequencia = "SELECT * FROM frequencia WHERE aluno_id = $usuario_id";
$resultado_frequencia = $conn->query($sql_frequencia);

//calcula a média geral da nota do aluno
$media_geral = 0;
$conta_notas = $resultado_notas->num_rows;
if($conta_notas > 0){
    while($nota = $resultado_notas->fetch_assoc()){
        $media_geral += $nota['nota'];
        }
        $media_geral = $media_geral / $conta_notas;
}