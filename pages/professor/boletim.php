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
    <title>Boletim</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/boletim/boletim.css">
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
        <h1>Lançamento de Notas</h1>

        <!-- Filtros -->
        <div class="filters">
            <select id="modulo">
                <option value="">Selecione o Módulo</option>
                <option value="modulo1">Módulo 1</option>
                <option value="modulo2">Módulo 2</option>
            </select>

            <select id="turma">
                <option value="">Selecione a Turma</option>
                <option value="turma1">Turma 1</option>
                <option value="turma2">Turma 2</option>
            </select>

            <select id="materia">
                <option value="">Selecione a Matéria</option>
                <option value="matematica">Banco de dados</option>
                <option value="portugues">Programação</option>
            </select>

            <select id="turno">
                <option value="">Selecione o Turno</option>
                <option value="manha">Manhã</option>
                <option value="tarde">Tarde</option>
            </select>

            <select id="semestre">
                <option value="">Selecione o Semestre</option>
                <option value="1sem">1º Semestre</option>
                <option value="2sem">2º Semestre</option>
            </select>

            <input type="date" id="filtro-dia">
        </div>

        <!-- Tabela de Notas -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nome do Aluno</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Média Final</th>
                        <th>Recuperação</th>
                        <th>Média com Recuperação</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>João Silva</td>
                        <td><input type="number" id="nota1-1" min="0" max="10"></td>
                        <td><input type="number" id="nota2-1" min="0" max="10"></td>
                        <td><input type="number" id="media-1" readonly></td>
                        <td><input type="number" id="recuperacao-1" min="0" max="10"></td>
                        <td><input type="number" id="media-rec-1" readonly></td>
                        <td><textarea id="observacoes-1" placeholder="Observações"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="calcularMedia(1)">Calcular Média</button>
                            <button class="edit" onclick="editarNota(1)">Editar Nota</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Ana Souza</td>
                        <td><input type="number" id="nota1-2" min="0" max="10"></td>
                        <td><input type="number" id="nota2-2" min="0" max="10"></td>
                        <td><input type="number" id="media-2" readonly></td>
                        <td><input type="number" id="recuperacao-2" min="0" max="10"></td>
                        <td><input type="number" id="media-rec-2" readonly></td>
                        <td><textarea id="observacoes-2" placeholder="Observações"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="calcularMedia(2)">Calcular Média</button>
                            <button class="edit" onclick="editarNota(2)">Editar Nota</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Pedro Lima</td>
                        <td><input type="number" id="nota1-3" min="0" max="10"></td>
                        <td><input type="number" id="nota2-3" min="0" max="10"></td>
                        <td><input type="number" id="media-3" readonly></td>
                        <td><input type="number" id="recuperacao-3" min="0" max="10"></td>
                        <td><input type="number" id="media-rec-3" readonly></td>
                        <td><textarea id="observacoes-3" placeholder="Observações"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="calcularMedia(3)">Calcular Média</button>
                            <button class="edit" onclick="editarNota(3)">Editar Nota</button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Maria Oliveira</td>
                        <td><input type="number" id="nota1-4" min="0" max="10"></td>
                        <td><input type="number" id="nota2-4" min="0" max="10"></td>
                        <td><input type="number" id="media-4" readonly></td>
                        <td><input type="number" id="recuperacao-4" min="0" max="10"></td>
                        <td><input type="number" id="media-rec-4" readonly></td>
                        <td><textarea id="observacoes-4" placeholder="Observações"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="calcularMedia(4)">Calcular Média</button>
                            <button class="edit" onclick="editarNota(4)">Editar Nota</button>
                        </td>
                    </tr>
                    <!-- Adicione mais alunos conforme necessário -->
                </tbody>
            </table>
        </div>

        <!-- Botões de Ações -->
        <div class="save-button">
            <button onclick="salvarNotas()">Salvar Notas</button>
        </div>

        <div class="send-button">
            <button onclick="enviarParaCoordenacao()">Enviar para Coordenação/Diretoria</button>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/boletim/boletim.js"></script>
</body>
</html>
