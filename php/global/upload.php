<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=sam';
$username = 'root';
$password = '';

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Erro ao conectar ao banco de dados: " . $e->getMessage());
    header("Location: ../../index.html");
    exit();
}

// Session management
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: ../../index.html");
    exit();
}

$user = $_SESSION['user'];

// Form input validation and sanitization
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = $_POST;
    $validator = new Respect\Validation\Validator();
    $input = $validator->validate($input, [
        'nome' => v::notEmpty()->alpha(),
        'telefone' => v::notEmpty()->phone(),
        'email' => v::notEmpty()->email(),
        'endereco' => v::notEmpty()->string(),
        'curso' => v::notEmpty()->string(),
        'data_nascimento' => v::notEmpty()->date(),
        'genero' => v::notEmpty()->string(),
    ]);

    if ($input->isValid()) {
        // Update student data
        $sql = "UPDATE aluno 
                SET nome = ?, telefone = ?, email = ?, endereco = ?, curso = ?, data_nascimento = ?, genero = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $input['nome'],
            $input['telefone'],
            $input['email'],
            $input['endereco'],
            $input['curso'],
            $input['data_nascimento'],
            $input['genero'],
            $id,
        ]);

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Dados do aluno atualizados com sucesso!'); window.location.href='../../pages/aluno/configuracoes.php';</script>";
        } else {
            error_log("Erro ao atualizar dados: " . $stmt->error);
            echo "<script>alert('Erro ao atualizar os dados do aluno.'); window.location.href='../../pages/aluno/configuracoes.php';</script>";
        }

        $stmt->close();

        // Handle file upload
        if (isset($_FILES['foto'])) {
            $file = $_FILES['foto'];
            $fileType = mime_content_type($file['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($fileType, $allowedTypes)) {
                $fileName = uniqid('foto_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileDir = '../../assets/img/uploads/';
                $filePath = $fileDir . $fileName;

                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    // Update photo in database
                    $sqlFoto = "UPDATE aluno SET foto = ? WHERE id = ?";
                    $stmtFoto = $conn->prepare($sqlFoto);
                    $stmtFoto->execute([$fileName, $id]);

                    if ($stmtFoto->rowCount() > 0) {
                        echo "<script>alert('Foto do aluno atualizada com sucesso')</script>";
                    }
                }
            }
        }
    }
