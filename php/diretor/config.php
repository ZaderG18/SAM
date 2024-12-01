<?php
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
    // Verificar os dados do formulário "perfil"
    if (isset($_POST['nome'], $_POST['email'], $_POST['cargo'], $_POST['senha'])) {
        $nome = $conn->real_escape_string($_POST['nome']);
        $email = $conn->real_escape_string($_POST['email']);
        $cargo = $conn->real_escape_string($_POST['cargo']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha
        
        // Processamento da imagem
        $foto = "";
        if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
            // Caminho onde a foto será armazenada
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($_FILES['imageUpload']['name']);

            // Verificar se o arquivo é uma imagem válida
            if (getimagesize($_FILES['imageUpload']['tmp_name'])) {
                // Mover o arquivo para o diretório de uploads
                if (move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploadFile)) {
                    $foto = $uploadFile; // Armazenar o caminho da foto
                } else {
                    echo "Erro ao fazer upload da imagem.";
                }
            } else {
                echo "O arquivo não é uma imagem válida.";
            }
        }

        // Inserir os dados no banco de dados
        $sql = "INSERT INTO perfil (nome, email, cargo, senha, foto) VALUES ('$nome', '$email', '$cargo', '$senha', '$foto')";

        if ($conn->query($sql) === TRUE) {
            // Redireciona de volta para a página de configurações com os dados salvos
            header("Location: ../../pages/diretor/configuracoes.php"); // Altere para o caminho correto da sua página
            exit();
        } else {
            echo "Erro: " . $conn->error;
        }
    }


    // Verificar os dados do formulário "sistema"
    if (isset($_POST['ano-letivo'], $_POST['nota-minima'], $_POST['frequencia-minima'], $_POST['modulos'])) {
        $anoLetivo = $conn->real_escape_string($_POST['ano-letivo']);
        $notaMinima = $conn->real_escape_string($_POST['nota-minima']);
        $frequenciaMinima = $conn->real_escape_string($_POST['frequencia-minima']);
        $modulos = implode(',', $_POST['modulos']); // Transformar array em string

        $sql = "INSERT INTO sistema (ano_letivo, nota_minima, frequencia_minima, modulos) VALUES ('$anoLetivo', '$notaMinima', '$frequenciaMinima', '$modulos')";

        if ($conn->query($sql) === TRUE) {
            echo "Configurações do sistema salvas com sucesso!";
        } else {
            echo "Erro: " . $conn->error;
        }
    }

    // Formulário de Notificações
    if (isset($_POST['canais'], $_POST['frequencia-notif'])) {
        $canais = implode(',', $_POST['canais']); // Transformar array em string
        $frequenciaNotif = $conn->real_escape_string($_POST['frequencia-notif']);

        $sql = "INSERT INTO notificacoes (canais, frequencia_notif) VALUES ('$canais', '$frequenciaNotif')";
        if ($conn->query($sql) === TRUE) {
            echo "Notificações salvas com sucesso!";
        } else {
            echo "Erro: " . $conn->error;
        }
    }

    // Formulário de Permissões
    if (isset($_POST['papel'], $_POST['modulo-acesso'])) {
        $papel = $conn->real_escape_string($_POST['papel']);
        $moduloAcesso = $conn->real_escape_string($_POST['modulo-acesso']);

        $sql = "INSERT INTO permissoes (papel, modulo_acesso) VALUES ('$papel', '$moduloAcesso')";
        if ($conn->query($sql) === TRUE) {
            echo "Permissões salvas com sucesso!";
        } else {
            echo "Erro: " . $conn->error;
        }
    }

    // Formulário de Relatórios
    if (isset($_POST['kpis'], $_POST['frequencia-relatorios'])) {
        $kpis = implode(',', $_POST['kpis']); // Transformar array em string
        $frequenciaRelatorios = $conn->real_escape_string($_POST['frequencia-relatorios']);

        $sql = "INSERT INTO relatorios (kpis, frequencia_relatorios) VALUES ('$kpis', '$frequenciaRelatorios')";
        if ($conn->query($sql) === TRUE) {
            echo "Relatórios salvos com sucesso!";
        } else {
            echo "Erro: " . $conn->error;
        }
    }

    // Formulário de Integrações
    // if (isset($_POST['backup'])) {
    //     $backup = $conn->real_escape_string($_POST['backup']);
    //
    //     $sql = "INSERT INTO integracoes (backup) VALUES ('$backup')";
    //     if ($conn->query($sql) === TRUE) {
    //         echo "Configurações de integração salvas com sucesso!";
    //     } else {
    //         echo "Erro: " . $conn->error;
    //     }
    // }
}

// Fechar conexão
$conn->close();
?>