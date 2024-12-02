<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuração do banco de dados
$host = "localhost";
$username = "root";
$password = "";
$database = "sam";

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica qual formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualizar usuário
    if (isset($_POST['nome'], $_POST['email'], $_POST['cargo'], $_POST['senha'])) {
        $nome = $conn->real_escape_string($_POST['nome']);
        $email = $conn->real_escape_string($_POST['email']);
        $cargo = $conn->real_escape_string($_POST['cargo']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $id = $_SESSION['user']['id'];

        // Atualizar foto
        $fotoNovoNome = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto = $_FILES['foto'];
            $fotoNome = basename($foto['name']);
            $fotoTemp = $foto['tmp_name'];
            $fotoPasta = '../../assets/img/uploads/';

            if (!is_dir($fotoPasta)) {
                mkdir($fotoPasta, 0777, true);
            }

            $fotocargo = mime_content_type($fotoTemp);
            $cargosPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($fotocargo, $cargosPermitidos)) {
                $fotoNovoNome = uniqid() . '_' . $fotoNome;
                $fotoCaminhoCompleto = $fotoPasta . $fotoNovoNome;

                if (!move_uploaded_file($fotoTemp, $fotoCaminhoCompleto)) {
                    echo "<script> alert('Erro no upload da foto.');</script>";
                }
            } else {
                echo "<script> alert('Formato de arquivo não permitido.');
                window.location.href = '../../pages/diretor/configuracoes.php';</script>";
            }
        }

        $sql = "UPDATE usuarios SET nome = ?, email = ?, cargo = ?, senha = ? " . 
               ($fotoNovoNome ? ", foto = ?" : "") . " WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($fotoNovoNome) {
            $stmt->bind_param("sssssi", $nome, $email, $cargo, $senha, $fotoNovoNome, $id);
        } else {
            $stmt->bind_param("ssssi", $nome, $email, $cargo, $senha, $id);
        }

        if ($stmt->execute()) {
            echo "<script> alert('Usuário atualizado com sucesso!'); window.location.href = '../../pages/diretor/configuracoes.php'; </script>";
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    }

    // Configurações do sistema
    if (isset($_POST['ano-letivo'], $_POST['nota-minima'], $_POST['frequencia-minima'], $_POST['modulos'])) {
        $anoLetivo = $conn->real_escape_string($_POST['ano-letivo']);
        $notaMinima = $conn->real_escape_string($_POST['nota-minima']);
        $frequenciaMinima = $conn->real_escape_string($_POST['frequencia-minima']);
        $modulos = implode(',', $_POST['modulos']);

        $sql = "UPDATE sistema SET ano_letivo = ?, nota_minima = ?, frequencia_minima = ?, modulos = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdds", $anoLetivo, $notaMinima, $frequenciaMinima, $modulos);

        if ($stmt->execute()) {
            echo "<script> alert('Configurações do sistema salvas com sucesso!'); window.location.href = '../../pages/diretor/configuracoes.php'; </script>";
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    }

    // Notificações
    if (isset($_POST['canais'], $_POST['frequencia-notif'])) {
        $canais = implode(',', $_POST['canais']);
        $frequenciaNotif = $conn->real_escape_string($_POST['frequencia-notif']);

        $sql = "UPDATE notificacoes SET canais = ?, frequencia_notif = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $canais, $frequenciaNotif);

        if ($stmt->execute()) {
            echo "<script> alert('Notificações salvas com sucesso!'); window.location.href = '../../pages/diretor/configuracoes.php'; </script>";
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
