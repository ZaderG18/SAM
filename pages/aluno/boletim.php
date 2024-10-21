<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
require '../../php/login/validar.php';
require '../../php/aluno/boletim.php';

$user = $_SESSION['user'];
$id = $user['id'];
$notas = getNotas($id);
$moduloId = isset($_GET['modulo']) ? $_GET['modulo'] : 1;
// Prepare SQL statement to retrieve photo
$sql = "SELECT foto FROM aluno WHERE id = ?";
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
$conn->close();

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
    <link rel="stylesheet" href="../../assets/scss/aluno/boletim/boletim.css">
    <link rel="stylesheet" href="../../assets/scss/global/sidebar.scss">
    <link rel="stylesheet" href="../../assets/scss/global/estilogeral.scss">
 
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
            <input type="search" placeholder="Search" class="header__input">
            <i class='bx bx-search header__icon'></i>
        </div>
        <div class="header__dropdown">
            <i class='bx bx-bell header__notification'></i>
            <div class="header__dropdown-content">
                <a href="#" class="header__dropdown-item">
                    <div class="header__notification-item">
                        <img src="../../assets/img/home/fotos/Ana_Icon.png" alt="Notificação 1">
                        <div>
                            <h4>Notificação 1</h4>
                            <p>Descrição da notificação 1</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="header__dropdown-item">
                    <div class="header__notification-item">
                        <img src="../../assets/img/home/fotos/img_enrico.png" alt="Notificação 2">
                        <div>
                            <h4>Notificação 2</h4>
                            <p>Descrição da notificação 2</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="header__dropdown-item">
                    <div class="header__notification-item">
                        <img src="../../assets/img/home/fotos/img_neide.png" alt="Notificação 3">
                        <div>
                            <h4>Notificação 3</h4>
                            <p>Descrição da notificação 3</p>
                        </div>
                    </div>
                </a>
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
                    <a href="home_aluno.php" class="nav__link">
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
                    <a href="cronograma.php" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Cronograma</span>
                    </a>
                    <a href="secretaria.php" class="nav__link">
                        <i class='bx bx-poll nav__icon'></i>
                        <span class="nav__name">Pesquisas Secretaria</span>
                    </a>
                    <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
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
          
    <div class="student-info">
        <h2>Dados do Aluno</h2>
        <p>Nome: <?php echo htmlspecialchars($user['nome']) ?></p>
        <p>Turma: 3º Módulo</p>
        <p>Curso: <?php echo htmlspecialchars($user['curso'])?></p>
        <p>Turma: A</p>
        <p>Inicio Curso: Jan de 2024</p>
        <p>Final Curso: Dez de 2025</p>
        <p>Situação: Cursando</p>
    </div>
    <!---------------------------------------------------------------------Modulo 1-------------------------------------------------------->
    <div id="tabelamodulo1" class="module-selection">
        <div>
            <label for="module-select">Selecione o Módulo:</label>
            <select id="module-select">
                <option value="modulo1">Módulo 1</option>
                <option value="modulo2">Módulo 2</option>
                <option value="modulo3">Módulo 3</option>
            </select>
            <button id="downloadbtn" class="button">Baixar Boletim</button>
        </div>

        <div id="modulo1" class="module-table">
            <table class="module-selection">
                <thead>
                    <tr>
                        <th>Disciplinas</th>
                        <th>Faltas</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Nota 3</th>
                        <th>Nota 4</th>
                        <th>Critérios</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($notas as $nota) {
                        // Calcular a média das notas
                        $media = ($nota['nota1'] + $nota['nota2'] + $nota['nota3'] + $nota['nota4']) / 4;

                        // Definindo a situação com base na média
                        $situacao = ($media >= 5) ? 'Aprovado' : 'Reprovado';
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nota['disciplina']); ?></td>
                        <td><?php echo htmlspecialchars($nota['faltas']); ?></td>
                        <td><?php echo htmlspecialchars($nota['nota1']); ?></td>
                        <td><?php echo htmlspecialchars($nota['nota2']); ?></td>
                        <td><?php echo htmlspecialchars($nota['nota3']); ?></td>
                        <td><?php echo htmlspecialchars($nota['nota4']); ?></td>
                        <td><a href="#" onclick="showModal('modal-<?php echo strtolower(str_replace(' ', '_', $nota['disciplina'])); ?>')"><?php echo $situacao; ?></a></td>
                        <td><a href="#" onclick="showModal('modal-<?php echo strtolower(str_replace(' ', '_', $nota['disciplina'])); ?>')"><?php echo htmlspecialchars($nota['observacoes']); ?></a></td>
                    </tr>
                    <?php }?>
                    <!-- <tr>
                        <td>Banco de dados</td>
                        <td>1</td>
                        <td>7.0</td>
                        <td>6.5</td>
                        <td>8.0</td>
                        <td>7.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-banco')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-banco')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Internet e Protocolos</td>
                        <td>3</td>
                        <td>6.0</td>
                        <td>5.5</td>
                        <td>7.0</td>
                        <td>6.5</td>
                        <td><a href="#" onclick="showModal('modal-reprovado-internet')">Reprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-insatisfatorio-internet')">Desempenho insatisfatório</a></td>
                    </tr>
                    <tr>
                        <td>Desenvolvimento de sistemas</td>
                        <td>0</td>
                        <td>9.0</td>
                        <td>8.5</td>
                        <td>10.0</td>
                        <td>9.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-sistemas')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-sistemas')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Programação Web</td>
                        <td>1</td>
                        <td>7.0</td>
                        <td>6.5</td>
                        <td>8.0</td>
                        <td>7.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-web')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-web')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Programação Orientada a Objetos</td>
                        <td>2</td>
                        <td>8.0</td>
                        <td>7.5</td>
                        <td>9.0</td>
                        <td>8.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-poo')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-poo')">Bom desempenho</a></td>
                    </tr> -->
                </tbody>
            </table>
        </div>
<!---------------------------------------------------------------------Modulo 2-------------------------------------------------------->
        <div id="modulo2" class="module-table" style="display:none;">
            <table class="module-selection">
                <thead>
                    <tr>
                        <th>Disciplinas</th>
                        <th>Faltas</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Nota 3</th>
                        <th>Nota 4</th>
                        <th>Critérios</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Programação Mobile</td>
                        <td>0</td>
                        <td>10.0</td>
                        <td>9.0</td>
                        <td>9.0</td>
                        <td>8.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-mobile')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-mobile')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Banco de dados</td>
                        <td>2</td>
                        <td>7.0</td>
                        <td>6.5</td>
                        <td>8.0</td>
                        <td>7.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-banco')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-banco')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Internet e Protocolos</td>
                        <td>6</td>
                        <td>6.0</td>
                        <td>5.5</td>
                        <td>7.0</td>
                        <td>6.5</td>
                        <td><a href="#" onclick="showModal('modal-reprovado-internet')">Reprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-insatisfatorio-internet')">Desempenho insatisfatório</a></td>
                    </tr>
                    <tr>
                        <td>Desenvolvimento de sistemas</td>
                        <td>0</td>
                        <td>9.0</td>
                        <td>8.5</td>
                        <td>10.0</td>
                        <td>9.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-sistemas')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-sistemas')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Programação Web</td>
                        <td>1</td>
                        <td>7.0</td>
                        <td>6.5</td>
                        <td>8.0</td>
                        <td>7.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-web')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-web')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Programação Orientada a Objetos</td>
                        <td>2</td>
                        <td>8.0</td>
                        <td>7.5</td>
                        <td>9.0</td>
                        <td>8.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-poo')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-poo')">Bom desempenho</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
<!---------------------------------------------------------------------Modulo 3-------------------------------------------------------->
        <div id="modulo3" class="module-table" style="display:none;" >
            <table class="module-selection">
                <thead>
                    <tr>
                        <th>Disciplinas</th>
                        <th>Faltas</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Nota 3</th>
                        <th>Nota 4</th>
                        <th>Critérios</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Programação Mobile</td>
                        <td>2</td>
                        <td>10.0</td>
                        <td>10.0</td>
                        <td>10.0</td>
                        <td>10.0</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-mobile')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-mobile')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Banco de dados</td>
                        <td>1</td>
                        <td>7.0</td>
                        <td>6.5</td>
                        <td>8.0</td>
                        <td>7.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-banco')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-banco')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Internet e Protocolos</td>
                        <td>5</td>
                        <td>6.0</td>
                        <td>5.5</td>
                        <td>7.0</td>
                        <td>6.5</td>
                        <td><a href="#" onclick="showModal('modal-reprovado-internet')">Reprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-insatisfatorio-internet')">Desempenho insatisfatório</a></td>
                    </tr>
                    <tr>
                        <td>Desenvolvimento de sistemas</td>
                        <td>0</td>
                        <td>9.0</td>
                        <td>8.5</td>
                        <td>10.0</td>
                        <td>9.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-sistemas')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-sistemas')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Programação Web</td>
                        <td>1</td>
                        <td>7.0</td>
                        <td>6.5</td>
                        <td>8.0</td>
                        <td>7.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-web')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-web')">Bom desempenho</a></td>
                    </tr>
                    <tr>
                        <td>Programação Orientada a Objetos</td>
                        <td>2</td>
                        <td>8.0</td>
                        <td>7.5</td>
                        <td>9.0</td>
                        <td>8.5</td>
                        <td><a href="#" onclick="showModal('modal-aprovado-poo')">Aprovado</a></td>
                        <td><a href="#" onclick="showModal('modal-bom-poo')">Bom desempenho</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!---------------------------------------------------------------------Modal-------------------------------------------------------->
    <div id="modal-aprovado-mobile" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-mobile')">&times;</span>
            <h2>Aprovado - Programação Mobile</h2>
            <ul>
                <li>Critério 1: Alta participação nas aulas</li>
                <li>Critério 2: Entrega de todos os trabalhos</li>
                <li>Critério 3: Boas notas nas avaliações</li>
                <li>Critério 4: Compreensão dos conceitos</li>
            </ul>
        </div>
    </div>

    <div id="modal-bom-mobile" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-bom-mobile')">&times;</span>
            <h2>Bom desempenho - Programação Mobile</h2>
            <p>O aluno demonstrou um bom desempenho devido à sua dedicação e compreensão dos conceitos abordados.</p>
        </div>
    </div>

    <div id="modal-aprovado-banco" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-banco')">&times;</span>
            <h2>Aprovado - Banco de dados</h2>
            <ul>
                <li>Critério 1: Alta participação nas aulas</li>
                <li>Critério 2: Entrega de todos os trabalhos</li>
                <li>Critério 3: Boas notas nas avaliações</li>
                <li>Critério 4: Compreensão dos conceitos</li>
            </ul>
        </div>
    </div>

    <div id="modal-bom-banco" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-bom-banco')">&times;</span>
            <h2>Bom desempenho - Banco de dados</h2>
            <p>O aluno demonstrou um bom desempenho devido à sua dedicação e compreensão dos conceitos abordados.</p>
        </div>
    </div>

    <div id="modal-reprovado-internet" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-reprovado-internet')">&times;</span>
            <h2>Reprovado - Internet e Protocolos</h2>
            <ul>
                <li>Critério 1: Baixa participação nas aulas</li>
                <li>Critério 2: Falta de entrega de trabalhos</li>
                <li>Critério 3: Notas insuficientes nas avaliações</li>
                <li>Critério 4: Dificuldade na compreensão dos conceitos</li>
            </ul>
        </div>
    </div>

    <div id="modal-insatisfatorio-internet" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-insatisfatorio-internet')">&times;</span>
            <h2>Desempenho insatisfatório - Internet e Protocolos</h2>
            <p>O aluno apresentou um desempenho insatisfatório devido à falta de dedicação e dificuldade na compreensão dos conceitos.</p>
        </div>
    </div>

    <div id="modal-aprovado-sistemas" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-sistemas')">&times;</span>
            <h2>Aprovado - Desenvolvimento de sistemas</h2>
            <ul>
                <li>Critério 1: Alta participação nas aulas</li>
                <li>Critério 2: Entrega de todos os trabalhos</li>
                <li>Critério 3: Boas notas nas avaliações</li>
                <li>Critério 4: Compreensão dos conceitos</li>
            </ul>
        </div>
    </div>

    <div id="modal-bom-sistemas" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-bom-sistemas')">&times;</span>
            <h2>Bom desempenho - Desenvolvimento de sistemas</h2>
            <p>O aluno demonstrou um bom desempenho devido à sua dedicação e compreensão dos conceitos abordados.</p>
        </div>
    </div>

    <div id="modal-aprovado-web" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-web')">&times;</span>
            <h2>Aprovado - Programação Web</h2>
            <ul>
                <li>Critério 1: Alta participação nas aulas</li>
                <li>Critério 2: Entrega de todos os trabalhos</li>
                <li>Critério 3: Boas notas nas avaliações</li>
                <li>Critério 4: Compreensão dos conceitos</li>
            </ul>
        </div>
    </div>

    <div id="modal-bom-web" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-bom-web')">&times;</span>
            <h2>Bom desempenho - Programação Web</h2>
            <p>O aluno demonstrou um bom desempenho devido à sua dedicação e compreensão dos conceitos abordados.</p>
        </div>
    </div>

    <div id="modal-aprovado-poo" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-poo')">&times;</span>
            <h2>Aprovado - Programação Orientada a Objetos</h2>
            <u>
                <li>Critério 1: Alta participação nas aulas</li>
                <li>Critério 2: Entrega de todos os trabalhos</li>
                <li>Critério 3: Boas notas nas avaliações</li>
                <li>Critério 4: Compreensão dos conceitos</li>
            </u</div>l>
        </div>
    </div>

    <div id="modal-bom-poo" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-bom-poo')">&times;</span>
            <h2>Bom desempenho - Programação Orientada a Objetos</h2>
            <p>O aluno demonstrou um bom desempenho devido à sua dedicação e compreensão dos conceitos abordados.</p>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/boletim/boletim.js"></script>
</body>
</html>
