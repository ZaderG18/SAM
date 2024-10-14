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
require '../../php/aluno/frequencia.php';

$user = $_SESSION['user'];
$id = $user['id'];

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
$stmt->close(); // Fechamos o statement aqui, pois ele já foi utilizado.

// Check if there is a photo for the user
if (!empty($fotoNome)) {
    $fotoCaminho = "../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../assets/img/logo.jpg"; // Default image if no photo is uploaded
}

// Consulta para buscar as frequências do aluno
$frequencias = []; // Inicializa como array vazio para evitar o erro

$sql_frequencias = "SELECT * FROM frequencia WHERE aluno_id = ?";
$stmt_frequencias = $conn->prepare($sql_frequencias);

if (!$stmt_frequencias) {
    die("Prepare failed: " . $conn->error);
}

$stmt_frequencias->bind_param("i", $id);
$stmt_frequencias->execute();
$result_frequencias = $stmt_frequencias->get_result();

if ($result_frequencias->num_rows > 0) {
    // Preenche o array $frequencias com os resultados da consulta
    while ($row = $result_frequencias->fetch_assoc()) {
        $frequencias[] = $row;
    }
}

$stmt_frequencias->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequência</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/frequencia/frequencia.css">
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
    <!---------------------------------------------------------------------Modulo 1-------------------------------------------------------->
    <div id="tabelamodulo1" class="module-selection">
        <div>
            <label for="module-select">Selecione o Módulo:</label>
            <select id="module-select">
                <option value="modulo1">Módulo 1</option>
                <option value="modulo2">Módulo 2</option>
                <option value="modulo3">Módulo 3</option>
            </select>
           <!--<button id="downloadbtn" class="button">Baixar Boletim</button>--> 
        </div>

        <div id="modulo1" class="module-table">
            <table class="module-selection">
                <thead>
                    <tr>
                        <th>Disciplinas</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                        <th>Faltas Permitidas</th>
                        <th>Freq. Atual</th>
                        <th>Freq. Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-mobile')">Programação Mobile</a></td>
                        <td>50</td>
                        <td>1</td>
                        <td>25</td>
                        <td>99%</td>
                      <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-banco')">Banco de dados</a></td>
                        <td>30</td>
                        <td>2</td>
                        <td>15</td>
                        <td>98%</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-reprovado-internet')">Internet e Protocolos</a></td>
                        <td>40</td>
                        <td>3</td>
                        <td>20</td>
                        <td>97%</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-sistemas')">Desenvolvimento de sistemas</a></td> 
                        <td>50</td>
                        <td>4</td>
                        <td>25</td>
                        <td>96%</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-web')">Programação Web</a></td>
                        <td>26</td>
                        <td>5</td>
                        <td>13</td>
                        <td>94%</td>
                       <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-poo')">Programação Orientada a Objetos</a></td>
                        <td>33</td>
                        <td>6</td>
                        <td>16</td>
                        <td>93%</td>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
        </div>
<!---------------------------------------------------------------------Modulo 2-------------------------------------------------------->
        <div id="modulo2" class="module-table" style="display:none;">
            <table class="module-selection">
                <thead>
                    <tr>
                        <th>Disciplinas</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                        <th>Faltas Permitidas</th>
                        <th>Freq. Atual</th>
                        <th>Freq. Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-mobile')">Programação Mobile</a></td>
                        <td>40</td>
                        <td>1</td>
                        <td>25</td>
                        <td>99%</td>
                      <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-banco')">Banco de dados</a></td>
                        <td>60</td>
                        <td>2</td>
                        <td>15</td>
                        <td>98%</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-reprovado-internet')">Internet e Protocolos</a></td>
                        <td>70</td>
                        <td>3</td>
                        <td>20</td>
                        <td>97%</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-sistemas')">Desenvolvimento de sistemas</a></td> 
                        <td>80</td>
                        <td>4</td>
                        <td>25</td>
                        <td>96%</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-web')">Programação Web</a></td>
                        <td>30</td>
                        <td>5</td>
                        <td>13</td>
                        <td>94%</td>
                       <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-poo')">Programação Orientada a Objetos</a></td>
                        <td>23</td>
                        <td>6</td>
                        <td>16</td>
                        <td>93%</td>
                        <td>100%</td>
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
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                        <th>Faltas Permitidas</th>
                        <th>Freq. Atual</th>
                        <th>Freq. Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-mobile')">Programação Mobile</a></td>
                        <td>100</td>
                        <td>1</td>
                        <td>25</td>
                        <td>99%</td>
                      <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-banco')">Banco de dados</a></td>
                        <td>100</td>
                        <td>2</td>
                        <td>15</td>
                        <td>98%</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-reprovado-internet')">Internet e Protocolos</a></td>
                        <td>100</td>
                        <td>3</td>
                        <td>20</td>
                        <td>97%</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-sistemas')">Desenvolvimento de sistemas</a></td> 
                        <td>100</td>
                        <td>4</td>
                        <td>25</td>
                        <td>96%</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-web')">Programação Web</a></td>
                        <td>100</td>
                        <td>5</td>
                        <td>13</td>
                        <td>94%</td>
                       <td>100%</td>
                    </tr>
                    <tr>
                        <td><a href="#" onclick="showModal('modal-aprovado-poo')">Programação Orientada a Objetos</a></td>
                        <td>100</td>
                        <td>6</td>
                        <td>16</td>
                        <td>93%</td>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
    </div>

    <!---------------------------------------------------------------------Modal-------------------------------------------------------->
    <div id="modal-aprovado-mobile" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-mobile')">&times;</span>
            <h2>Programação Mobile</h2>
            <table class="modal-selection">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Conteúdo</th>
                        <th>Professor</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>19/08</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>12/09</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    <div id="modal-aprovado-banco" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-banco')">&times;</span>
            <h2>Banco de dados</h2>
            <table class="modal-selection">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Conteúdo</th>
                        <th>Professor</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>19/08</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>12/09</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    <div id="modal-reprovado-internet" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-reprovado-internet')">&times;</span>
            <h2>Internet e Protocolos</h2>
            <table class="modal-selection">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Conteúdo</th>
                        <th>Professor</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>19/08</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>12/09</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    <div id="modal-aprovado-sistemas" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-sistemas')">&times;</span>
            <h2>Desenvolvimento de sistemas</h2>
            <table class="modal-selection">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Conteúdo</th>
                        <th>Professor</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>19/08</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>12/09</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    <div id="modal-aprovado-web" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-web')">&times;</span>
            <h2>Programação Web</h2>
            <table class="modal-selection">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Conteúdo</th>
                        <th>Professor</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>19/08</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>12/09</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div id="modal-aprovado-poo" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-aprovado-poo')">&times;</span>
            <h2>Programação Orientada a Objetos</h2>
            <table class="module-selection">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Conteúdo</th>
                        <th>Professor</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>19/08</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>12/09</td>
                        <td>Definição e conceito. Criar um mapa mental usando exemplos nas frases e grifar onde cada item se encontra.</td>
                        <td>Daniela</td>
                        <td>2,5</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/frequencia/frequencia.js"></script>
</body>
</html>
