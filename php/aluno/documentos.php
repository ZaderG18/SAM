<?php
// Conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

require_once '../../vendor/autoload.php';
use TCPDF;

$mensagem = "";
$protocolo = "";
$resultadoConsulta = [];

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    // Solicitação de declaração
    if ($action === 'declaracao') {
        $tipo_declaracao = filter_input(INPUT_POST, 'declaração', FILTER_SANITIZE_SPECIAL_CHARS);
        $motivo = filter_input(INPUT_POST, 'motivo', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($tipo_declaracao) && !empty($motivo) && !empty($turma_id)) {
            $protocolo = uniqid();
            $stmt = $conn->prepare("INSERT INTO declaracao (tipo_declaracao, motivo, protocolo, turma_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $tipo_declaracao, $motivo, $protocolo, $turma_id);

            if ($stmt->execute()) {
                // Gerar PDF com TCPDF
                $pdf = new TCPDF();
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('Nome da Instituição');
                $pdf->SetTitle('Declaração');
                $pdf->SetMargins(10, 10, 10);

                // Adicionar página
                $pdf->AddPage();

                // Conteúdo do PDF
                $html = '
                <h1 style="text-align: center;">Declaração de ' . htmlspecialchars($tipo_declaracao) . '</h1>
                <p>Motivo: ' . htmlspecialchars($motivo) . '</p>
                <p>Protocolo: ' . htmlspecialchars($protocolo) . '</p>
                ';

                // Escrever o HTML no PDF
                $pdf->writeHTML($html, true, false, true, false, '');

                // Caminho para salvar o PDF
                $pdfFilePath = 'declaracao_' . $protocolo . '.pdf';
                $pdf->Output($pdfFilePath, 'F'); // Salva o PDF no servidor

                $mensagem = "<script>
                alert('Declaração solicitada com sucesso! Protocolo: $protocolo');
                window.location.href= '../../pages/aluno/documentos.php'; 
                </script>";
            } else {
                $mensagem = "<script>
                alert('Erro ao solicitar a declaração. Por favor, tente novamente.');
                window.location.href= '../../pages/aluno/documentos.php'; 
                </script>";
            }
            $stmt->close();
        } else {
            $mensagem = "<script>
            alert('Preencha todos os campos para solicitar uma declaração.');
            window.location.href= '../../pages/aluno/documentos.php'; 
            </script>";
        }
    }

    // Processar a rematrícula
    if ($action === 'rematricula') {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $matricula = filter_input(INPUT_POST, 'RM', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($nome) && !empty($matricula)) {
            // Validar se estamos no prazo de rematrícula
            $dataAtual = date('Y-m-d');
            $inicioRematricula = '2024-10-09';
            $fimRematricula = '2024-12-16';

            if ($dataAtual < $inicioRematricula || $dataAtual > $fimRematricula) {
                $mensagem = "<script> alert('Rematrícula fora do prazo.')
                window.location.href= '../../pages/aluno/documentos.php'; 
                </script>";
            } else {
                // Verificar se o aluno já fez a rematrícula no ano atual
                $anoAtual = date('Y');
                $stmt = $conn->prepare("SELECT COUNT(*) FROM rematricula WHERE aluno_id = ? AND YEAR(data_rematricula) = ?");
                $stmt->bind_param("ii", $matricula, $anoAtual);
                $stmt->execute();
                $stmt->bind_result($total);
                $stmt->fetch();
                $stmt->close();

                if ($total > 0) {
                    $mensagem = "<script> alert('Você já realizou a rematrícula neste ano.');
                    window.location.href= '../../pages/aluno/documentos.php'; 
                    </script>";
                } else {
                    // Inserir a rematrícula no banco
                    $stmt = $conn->prepare("INSERT INTO rematricula (aluno_id, data_rematricula, status) VALUES (?, ?, ?)");
                    $status = "ativo";
                    $stmt->bind_param("iss", $matricula, $dataAtual, $status);

                    if ($stmt->execute()) {
                        $mensagem = "<script> alert('Rematrícula realizada com sucesso!');
                        window.location.href= '../../pages/aluno/documentos.php'; 
                        </script>";
                    } else {
                        $mensagem = "<script> alert('Erro ao realizar a rematrícula. Tente novamente.');
                        window.location.href= '../../pages/aluno/documentos.php'; 
                        </script>";
                    }
                    $stmt->close();
                }
            }
        } else {
            $mensagem = "<script> alert('Preencha todos os campos para realizar a rematrícula.');
            window.location.href= '../../pages/aluno/documentos.php'; 
            </script>";
        }
    }

    // Consulta de protocolo
    if ($action === 'consulta') {
        $protocoloConsulta = filter_input(INPUT_POST, 'protocolo', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if (!empty($protocoloConsulta)) {
            $stmt = $conn->prepare("SELECT * FROM declaracoes WHERE protocolo = ?");
            $stmt->bind_param("s", $protocoloConsulta);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $resultadoConsulta = $result->fetch_assoc();
            } else {
                $mensagem = "<script> alert('Protocolo não encontrado.');
                window.location.href= '../../pages/aluno/documentos.php'; 
                </script>";
            }
            $stmt->close();
        } else {
            $mensagem = "<script> alert('Informe um protocolo para a consulta.');
            window.location.href= '../../pages/aluno/documentos.php'; 
            </script>";
        }
    }

    // Processar a rematrícula
    if ($action === 'rematricula') {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $matricula = filter_input(INPUT_POST, 'RM', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($nome) && !empty($matricula)) {
            // Validar se estamos no prazo de rematrícula
            $dataAtual = date('Y-m-d');
            $inicioRematricula = '2024-10-09';
            $fimRematricula = '2024-12-16';

            if ($dataAtual < $inicioRematricula || $dataAtual > $fimRematricula) {
                $mensagem = "<script> alert('Rematrícula fora do prazo.')
                window.location.href= '../../pages/aluno/documentos.php'; 
                </script>";
            } else {
                // Verificar se o aluno já fez a rematrícula no ano atual
                $anoAtual = date('Y');
                $stmt = $conn->prepare("SELECT COUNT(*) FROM rematricula WHERE aluno_id = ? AND YEAR(data_rematricula) = ?");
                $stmt->bind_param("ii", $matricula, $anoAtual);
                $stmt->execute();
                $stmt->bind_result($total);
                $stmt->fetch();
                $stmt->close();

                if ($total > 0) {
                    $mensagem = "<script> alert('Você já realizou a rematrícula neste ano.');
                    window.location.href= '../../pages/aluno/documentos.php'; 
                    </script>";
                } else {
                    // Inserir a rematrícula no banco
                    $stmt = $conn->prepare("INSERT INTO rematricula (aluno_id, data_rematricula, status) VALUES (?, ?, ?)");
                    $status = "ativo";
                    $stmt->bind_param("iss", $matricula, $dataAtual, $status);

                    if ($stmt->execute()) {
                        $mensagem = "<script> alert('Rematrícula realizada com sucesso!');
                        window.location.href= '../../pages/aluno/documentos.php'; 
                        </script>";
                    } else {
                        $mensagem = "<script> alert('Erro ao realizar a rematrícula. Tente novamente.');
                        window.location.href= '../../pages/aluno/documentos.php'; 
                        </script>";
                    }
                    $stmt->close();
                }
            }
        } else {
            $mensagem = "<script> alert('Preencha todos os campos para realizar a rematrícula.');
            window.location.href= '../../pages/aluno/documentos.php'; 
            </script>";
        }
    }
} 
?>

<!-- Exibindo a mensagem -->
<?php if (!empty($mensagem)): ?>
    <p><?= $mensagem ?></p>
<?php endif; ?>
