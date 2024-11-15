<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco". $conn->connect_error);
}
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';
include_once '../../php/professor/chamada.php';

$user = $_SESSION['user'];
$id = $user['id'];

// Prepare SQL statement to retrieve photo
$sql = "SELECT foto FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($fotoNome);
$stmt->fetch();
$stmt->close();

// Check if there is a photo for the user
if (!empty($fotoNome)) {
    $fotoCaminho = "../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../assets/img/logo.jpg"; // Default image if no photo is uploaded
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequência</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/frequencia/frequencia.css">
    <link rel="stylesheet" href="../../assets/scss/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/scss/global/estilogeral.css">
 
    <!-- Favicon -->
    <link rel="icon" href="../../assets/img/Group 4.png" type="image/png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Box-icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    
    <!-- Remixicons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <!--========== HEADER ==========-->
<header class="header">
    <div class="header__container">
        <div class="header__search">
            <input type="search" placeholder="Search" class="header__input" id="searchInput" oninput="showSuggestions()" autocomplete="off">
            <div id="suggestions"></div>
            <button onclick="redirectToPage()"><i class='bx bx-search header__icon'></i></button>
        </div>
        <div class="header__dropdown">
            <i class='bx bx-bell header__notification'></i>
            <div class="header__dropdown-content">
                    <?php $notificacoes = obterNotificacoes($conn, $id, true);
                if (!empty($notificacoes)) { 
                    echo "<p> Nenhuma notificação no momento.</p>";
                } else{
                    foreach ($notificacoes as $notificacao){?>
                <a href="<?php echo $notificacao['link'] ? $notificacao['link'] : '#'; ?>" class="header__dropdown-item">
                    <div class="header__notification-item">
                        <?php if ($notificacao['imagem']){?>
                        <img src="<?php echo $notificacao['imagem']; ?>" alt="Notificação 1">
                        <?php } ?>
                        <div>
                            <h4><?php echo htmlspecialchars($notificacao['titulo']); ?></h4>
                            <p><?php echo htmlspecialchars($notificacao['mensagem']);?></p>
                            <small><?php date("d/m/Y H:i", strtotime($notificacao['data_criacao']))?></small>
                        </div>
                    </div>
                </a>
                <?php } }?>
            </div>
        </div>
        <div class="header__dropdown">
            <img src="<?php echo $fotoCaminho ?>" alt="" class="header__img">
            <div class="header__dropdown-content">
                <a href="perfil.php" class="header__dropdown-item">
                    <i class='bx bx-user'></i> Perfil
                </a>
                <a href="configuracoes.php" class="header__dropdown-item">
                    <i class='bx bx-cog'></i> Configurações
                </a>
                <a href="faq.php" class="header__dropdown-item">
                    <i class='bx bx-help-circle'></i> Ajuda
                </a>
            </div>
        </div>
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
    </div>
</header>

<!--========== NAV ==========-->
<div class="nav" id="navbar">
    <nav class="nav__container">
        <div>
            <a href="#" class="nav__link nav__logo">
                <img src="../../assets/img/Group 4.png" alt="Logo SAM" class="nav__logo-img">
                <span class="nav__logo-name">SAM</span>
            </a>
            <div class="nav__list">
                <div class="nav__items">
                    <h3 class="nav__subtitle">Home</h3>
                    <a href="home_professor.php" class="nav__link">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Home</span>
                    </a>
                    <a href="historico.php" class="nav__link active">
                        <i class='bx bx-history nav__icon'></i>
                        <span class="nav__name">Histórico</span>
                    </a>
                    <a href="documentos.php" class="nav__link">
                        <i class='bx bx-file nav__icon'></i>
                        <span class="nav__name">Documentos</span>
                    </a>
                    <a href="calendario.php" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Cronograma</span>
                    </a>
                    <a href="enquetes.php" class="nav__link">
                        <i class='bx bx-poll nav__icon'></i>
                        <span class="nav__name">Pesquisas Secretaria</span>
                    </a>
                    <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a>
                    <h2 class="nav__subtitle">Orientador</h2>
                    <a href="dashboard/dashboard.php" class="nav__link">
                        <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
        <a href="../../php/login/logout.php" class="nav__link nav__logout">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Sair</span>
        </a>
    </nav>
</div>


<!--=================================================================== MAIN CONTENT ============================================================-->

<main>

    <div class="container">
        <h1>Chamada de Aula</h1>
        
        <!-- Filtros -->
        <div class="filters">
            <form action="../../php/professor/chamada.php" method="get">
            <select id="turma" name="turma" required>
                <option value="">Selecione a Turma</option>
                <?php foreach ($turmas as $turma) :?>
                    <option value="<?= $turma['id'] ?>" <?= (isset($_GET['turma']) && $_GET['turma'] == $turma['id']) ? 'selected' : '' ?>>
                        <?= $turma['nome'] ?>
                    </option>
                <?php endforeach; ?>
                    </select>

            <select id="materia" name="materia" required>
                <option value="">Selecione a Matéria</option>
                <?php foreach ($materias as $materia) :?>
                    <option value="<?= $materia['id'] ?>" <?= (isset($_GET['materia']) && $_GET['materia'] == $materia['id']) ? 'selected' : '' ?>>
                        <?= $materia['nome_disciplina'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select id="turno" name="turno" required>
                <option value="">Selecione o Turno</option>
                <option value="manha">Matutino</option>
                <option value="tarde">Vespertino</option>
                <option value="noite">Noturno</option>
            </select>

            <select id="periodo" name="periodo" required>
                <option value="">Selecione o Período</option>
                <option value="1">1º Período</option>
                <option value="2">2º Período</option>
                <option value="3">3º Período</option>
                <option value="4">4º Período</option>
            </select>

            <select id="periodo-dia" name="periodo-dia" required>
                <option value="">Selecione o Período do Dia</option>
                <option value="1aula">1° aula</option>
                <option value="2aula">2° aula</option>
                <option value="3aula">3° aula</option>
                <option value="4aula">4° aula</option>
            </select>

            <input type="date" name="filtro-dia" value="<?= isset($_GET['filtro-dia']) ? $_GET['filtro-dia'] : '' ?>" required>

            <select id="status-chamada">
                <option value="">Status da Chamada</option>
                <option value="feitas">Feitas</option>
                <option value="pendentes">Pendentes</option>
            </select>
            <button type="submit">Carregar Alunos</button>
        </div>
        </form>

        <!-- Tabela de Chamada -->
         <?php if (!empty($alunos)) : ?>
        <div class="table-wrapper">
            <form action="../../php/professor/chamada.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nome do Aluno</th>
                        <th>Status</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tabela-alunos">
                <?php foreach ($alunos as $index => $aluno): ?>
                    <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $aluno['nome'] ?></td>
                    <td><?= $aluno['status'] ?></td>
                        <td class="actions">
                            <button onclick="marcarPresenca(this)" value="1">Presente</button>
                            <button onclick="marcarAusencia(this)" value="0">Ausente</button>
                        </td>
                        <td><textarea name="observacao[<?= $aluno['id'] ?>]" placeholder="Adicionar observação"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="editarStatus(this)">Editar</button>
                        </td>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

        <!-- Botão de Salvar Chamada -->
        <div class="save-button">
            <button type="submit" name="salvar" id="salvarChamada()">Salvar Chamada</button>
        </div>
        </form>
        <?php endif; ?>
    </div>
</main>
    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/frequencia/frequencia.js"></script>
</body>
</html>
