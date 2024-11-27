<?php
require_once '../../vendor/mpdf/mpdf/mpdf.php'; // Certifique-se de que o caminho está correto

use Mpdf\Mpdf;

// Dados dinâmicos
$nome = "Arthur Oliveira";
$data = date("d/m/Y");
$turma = "3º Ano do Ensino Médio";

// Caminho do template HTML
$templateHTML = '../../pages/doc/certificado.html';

// Verifica se o arquivo do template HTML existe
if (!file_exists($templateHTML)) {
    die("Erro: Template HTML não encontrado.");
}

// Lê o conteúdo do template HTML
$html = file_get_contents($templateHTML);

// Substitui os placeholders pelos dados dinâmicos
$html = str_replace('{{nome}}', $nome, $html);
$html = str_replace('{{data}}', $data, $html);
$html = str_replace('{{turma}}', $turma, $html);

try {
    // Inicializa o mPDF
    $mpdf = new Mpdf();

    // Adiciona o HTML ao mPDF
    $mpdf->WriteHTML($html);

    // Gera o PDF para download
    $mpdf->Output("declaracao.pdf", "D"); // "D" para download
} catch (\Mpdf\MpdfException $e) {
    die("Erro ao gerar o PDF: " . $e->getMessage());
}
?>
