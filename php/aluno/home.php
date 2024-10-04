<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

// Improved database connection with error handling
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user ID is set in session
if (!isset($_SESSION['user']['id'])) {
    die("User not logged in.");
}

$usuario_id = $_SESSION['user']['id'];

// Função para consultar o banco de dados de forma genérica
function consultarBanco($conn, $tabela, $usuario_id) {
    $sql = "SELECT * FROM $tabela WHERE aluno_id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return null; // Return null instead of false
    }
    
    $stmt->bind_param("i", $usuario_id);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return null; // Return null on execution failure
    }
    
    $result = $stmt->get_result();
    $stmt->close(); // Close the statement
    return $result; // Return the result
}

// Recupera as informações do aluno
function obterAluno($conn, $usuario_id) {
    $sql_usuario = "SELECT * FROM aluno WHERE id = ?";
    $stmt = $conn->prepare($sql_usuario);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return null; // Handle prepare failure
    }
    
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado_usuario = $stmt->get_result();
    $stmt->close(); // Close the statement
    return $resultado_usuario->fetch_assoc(); // Retorna os dados do aluno
}

// Improved average calculation with error handling
function calcularMedia($resultado_notas) {
    if ($resultado_notas->num_rows === 0) return 0; // No grades found

    $soma_notas = 0;
    $total_notas = 0; // To keep track of the total number of grades

    while ($nota = $resultado_notas->fetch_assoc()) {
        // Assuming your columns are named nota1, nota2, nota3, nota4
        for ($i = 1; $i <= 4; $i++) {
            $nota_column = 'nota' . $i; // Construct the column name
            if (isset($nota[$nota_column]) && is_numeric($nota[$nota_column])) {
                $soma_notas += $nota[$nota_column];
                $total_notas++;
            }
        }
    }

    return $total_notas > 0 ? $soma_notas / $total_notas : 0; // Return average
}

$usuario = obterAluno($conn, $usuario_id);

if ($usuario) {
    // Obtendo dados do aluno
    $notas = consultarBanco($conn, "nota_media", $usuario_id);
    if ($notas === null) {
        echo "Erro ao consultar notas.<br>";
    } else {
        // Calculando a média das notas
        $media_notas = calcularMedia($notas);
        echo "Média das notas: " . htmlspecialchars($media_notas) . "<br>";
    }
    
    // Obtendo atualizações
    $atualizacoes = consultarBanco($conn, "atualizacao", $usuario_id);
    if ($atualizacoes === null) {
        echo "Erro ao consultar atualizações.<br>";
    } else {
        if ($atualizacoes->num_rows > 0) {
            while ($atualizacao = $atualizacoes->fetch_assoc()) {
                echo "Atualização: " . htmlspecialchars($atualizacao['descricao']) . "<br>";
            }
        } else {
            echo "Nenhuma atualização encontrada.<br>";
        }
    }
    
    // Obtendo frequência
    $frequencia = consultarBanco($conn, "frequencia", $usuario_id);
    if ($frequencia === null) {
        echo "Erro ao consultar frequência.<br>";
    } else {
        if ($frequencia->num_rows > 0) {
            while ($registro_frequencia = $frequencia->fetch_assoc()) {
                echo "Frequência: " . htmlspecialchars($registro_frequencia['status']) . "<br>";
            }
        } else {
            echo "Nenhum registro de frequência encontrado.<br>";
        }
    }
    
} else {
    echo "Aluno não encontrado.";
}
?>
