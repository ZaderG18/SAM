<?php
// Conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Verifica se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo formulário
    $user_id = $_POST['user_id'];
    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];

    // Definir tipo de usuário como 'aluno' (isso pode ser modificado conforme necessário)
    $tipo_usuarios = 'aluno' . 'professor' . 'coordenador' . 'diretor'; // Isso pode ser dinâmico, baseado no usuário logado ou selecionado

    $imagem = NULL; // Aqui você pode adicionar a lógica para imagem, se necessário
    $link = NULL;   // Aqui você pode adicionar a lógica para link, se necessário

    // Prepara a query para inserir a notificação
    $query = "INSERT INTO notificacoes (user_id, tipo_usuarios, titulo, mensagem, imagem, link) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Bind dos parâmetros
    $stmt->bind_param('isssss', $user_id, $tipo_usuarios, $titulo, $mensagem, $imagem, $link);

    // Executa a query e verifica se foi bem-sucedido
    if ($stmt->execute()) {
        echo "<script>alert('Mensagem enviada com sucesso!')
        window.location.href='../../pages/professor/aulas.php';</script>";
    } else {
        echo "<script>alert('Erro ao enviar a mensagem: " . $stmt->error . "');
        window.location.href='../../pages/professor/aulas.php';</script>";
    }
}
?>
