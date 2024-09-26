<?php
include('../../php/turmas.php');

// Supondo que $conn seja a conexão
$turmasAtribuidas = getTurmasAtribuidas($conn);

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "SAM");

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
require_once '../../php/validar.php';
$user = $_SESSION['user'];
// Busca os alunos e as turmas do banco de dados
$alunos = $conn->query("SELECT id, nome FROM aluno");
$turmas = $conn->query("SELECT id, disciplina FROM turma");
$turmasAtribuidas = getTurmasAtribuidas($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['escolher_turma'])) {
    $aluno_id = filter_input(INPUT_POST, 'aluno_id', FILTER_VALIDATE_INT);
    $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);

    if (!$aluno_id || !$turma_id) {
        die("Selecione um aluno e uma turma válidos.");
    }

    $message = atribuirTurma($conn, $aluno_id, $turma_id);

    // Exibe uma mensagem e redireciona
    echo "<script>alert('$message'); window.location.href = 'escolher_turma.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Escolher Turma</title>
    <link rel="shortcut icon" href="../../assets/img/icone_logo 1.png" type="image/x-icon">
</head>
<body>
<h1>Criar Turma</h1>
    <form action="../../php/turmas.php" method="post">
        <label for="disciplina">Disciplina:</label>
        <input type="text" id="disciplina" name="disciplina" required><br><br>

        <label for="professor">Professor:</label>
        <select id="professor" name="professor_id" required>
            <!-- PHP para preencher com opções de professores -->
            <?php
        
            $sql = "SELECT id, nome FROM professor";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="aluno">Selecionar Alunos:</label><br>
        <!-- PHP para listar os alunos com checkboxes -->
        <?php
        $sql = "SELECT id, nome FROM aluno";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            echo "<input type='checkbox' name='aluno[]' value='" . $row['id'] . "'> " . $row['nome'] . "<br>";
        }
        ?><br>

        <input type="submit" value="Criar Turma">
    </form>
    

<h1>Atribuir Aluno a uma Turma</h1>

<form action="../../php/turmas.php" method="POST">
    <label for="aluno_id">Selecione o Aluno:</label>
    <select name="aluno_id" id="aluno_id" required>
        <option value="">Escolha um aluno</option>
        <?php while($aluno = $alunos->fetch_assoc()): ?>
            <option value="<?php echo $aluno['id']; ?>"><?php echo $aluno['nome']; ?></option>
        <?php endwhile; ?>
    </select>
    <br><br>

    <label for="turma_id">Selecione a Turma:</label>
    <select name="turma_id" id="turma_id" required>
        <option value="">Escolha uma turma</option>
        <?php while($turma = $turmas->fetch_assoc()): ?>
            <option value="<?php echo $turma['id']; ?>"><?php echo $turma['disciplina']; ?></option>
        <?php endwhile; ?>
    </select>
    <br><br>

    <input type="submit" name="escolher_turma" value="Atribuir Aluno à Turma">
</form>

<h2>Turmas Atribuídas</h2>
<table border="">
    <tr>
        <th>Aluno</th>
        <th>Turma</th>
        <th>Ação</th>
    </tr>
    <?php while($turmaAtribuida = $turmasAtribuidas->fetch_assoc()): ?>
        <tr>
            <td><?php echo $turmaAtribuida['aluno_nome']; ?></td>
            <td><?php echo $turmaAtribuida['turma_nome']; ?></td>
            <td>
                <form action="../../php/conexao.php" method="POST" style="display:inline;">
                    <input type="hidden" name="aluno_id" value="<?php echo $turmaAtribuida['id']; ?>">
                    <input type="submit" name="remover_turma" value="Remover">
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
