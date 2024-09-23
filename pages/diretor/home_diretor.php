<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: validar.php');
    exit();
}
require_once '../../php/funcao.php';
$user = $_SESSION['user'];

$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Obtenha todos os usuários e os totais.
$usuarios = get_todos_usuarios($conn);
$totalAlunos = total_alunos($conn);
$totalProfessor = total_professores($conn);
$totalCoordenador = total_coordenadores($conn);
$totalDiretores = total_diretores($conn); // Se precisar, adicione isso.

$maximo_registros = 6;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao SAM</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/diretor/style.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/global/bottomnav.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/global/menumobile.css">
    <!-- CSS -->
    <link rel="icon" href="../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Box-icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- Remixicons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
<header class="header"> 
        <div class="logo-sam"><img src="../../assets/img/home/logo/Mask group.png" alt=""></div>
        <div class="box-search"><i class='bx bx-search'></i><input type="text" placeholder="Pesquisar"></div>
        <nav class="nav container" id="menu-mobile">
            <div class="nav__data">
               <!-- <a href="#" class="nav__logo">
                  <i class="ri-planet-line"></i> Company
               </a> -->
               
               <div class="nav__toggle" id="nav-toggle">
                  <i class="ri-menu-line nav__burger"></i>
                  <i class="ri-close-line nav__close"></i>
               </div>
            </div>

            <!--=============== NAV MENU ===============-->
            <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li><a href="#" class="nav__link"><img src="../../assets/img/home/icons/home.svg" alt="" srcset="">Home</a></li>

                  <li><a href="#" class="nav__link"><img src="../../assets/img/home/icons/docentes.svg" alt="" srcset="">Docentes</a></li>

                  <!--=============== DROPDOWN 1 ===============-->
                  <li class="dropdown__item">
                     <div class="nav__link"><img src="../../assets/img/home/icons/dashboard.svg" alt="" srcset="">
                        Dashboard<i class="ri-arrow-down-s-line dropdown__arrow"></i>
                     </div>

                     <ul class="dropdown__menu">
                        <li>
                           <a href="#" class="dropdown__link">
                              <i class="ri-pie-chart-line"></i> Overview
                           </a>                          
                        </li>

                        <li>
                           <a href="#" class="dropdown__link">
                              <i class="ri-arrow-up-down-line"></i> Transactions
                           </a>
                        </li>

                        <!--=============== DROPDOWN SUBMENU ===============
                        <li class="dropdown__subitem">
                           <div class="dropdown__link">
                              <i class="ri-bar-chart-line"></i> Reports <i class="ri-add-line dropdown__add"></i>
                           </div>

                           <ul class="dropdown__submenu">
                              <li>
                                 <a href="#" class="dropdown__sublink">
                                    <i class="ri-file-list-line"></i> Documents
                                 </a>
                              </li>
      
                              <li>
                                 <a href="#" class="dropdown__sublink">
                                    <i class="ri-cash-line"></i> Payments
                                 </a>
                              </li>
      
                              <li>
                                 <a href="#" class="dropdown__sublink">
                                    <i class="ri-refund-2-line"></i> Refunds
                                 </a>
                              </li>
                           </ul>
                        </li>-->
                     </ul>
                  </li>
                  
                  <li><a href="#" class="nav__link">Products</a></li>

                  <!--=============== DROPDOWN 2 ===============-->
                  <li class="dropdown__item">
                     <div class="nav__link">
                        Users <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                     </div>

                     <ul class="dropdown__menu">
                        <li>
                           <a href="#" class="dropdown__link">
                              <i class="ri-user-line"></i> Profiles
                           </a>                          
                        </li>

                        <li>
                           <a href="#" class="dropdown__link">
                              <i class="ri-lock-line"></i> Accounts
                           </a>
                        </li>

                        <li>
                           <a href="#" class="dropdown__link">
                              <i class="ri-message-3-line"></i> Messages
                           </a>
                        </li>
                     </ul>
                  </li>

                  <li><a href="#" class="nav__link">Contact</a></li>
               </ul>
            </div>
         </nav>
    </header>
    <div class="global-container">
        <aside>
            <div class="sidebar">
                        <!--aside bar-->
                        <nav id="sidebar">
                            <div id="sidebar_content">
                                <div id="user">
                                    <img src="../../assets/img/home/coqui-chang-COP.jpg" id="user_avatar" alt="Avatar">
                        
                                    <p id="user_infos">
                                        <span class="item-description">
                                            <?php echo htmlspecialchars($user['nome']); ?>
                                        </span>
                                        <span class="item-description">
                                            Lorem Ipsum
                                        </span>
                                    </p>
                                </div>
                        
                                <ul id="side_items">
                                    <li class="side-item active">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/home.svg" alt="" >
                                            <span class="item-description">
                                                Home
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="docentes.php">
                                            <img src="../../assets/img/home/icons/docentes.svg" alt="">
                                            <span class="item-description">
                                                Docentes
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/cursos.svg" alt="" width="30px">
                                            <span class="item-description">
                                                Gerenciar Cursos
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/user.svg" alt="">
                                            <span class="item-description">
                                                Gerenciar usuarios
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/comunicado.svg" alt="">
                                            <span class="item-description">
                                                Gerenciar comunicados
                                            </span>
                                        </a>
                                    </li>

                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/documento.svg" alt="">
                                            <span class="item-description">
                                                Gerenciar documentos
                                            </span>
                                        </a>
                                    </li>

                                    <li class="side-item">
                                        <a href="dashboard.php">
                                            <img src="../../assets/img/home/icons/dashboard.svg" alt="">
                                            <span class="item-description">
                                                Dashboard
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/configuracao.svg" alt="">
                                            <span class="item-description">
                                                Configurações
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                        
                                <button id="open_btn">
                                    <i id="open_btn_icon" class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                    
                            <div id="logout">
                                <button id="logout_btn" onclick="window.location.href='../../index.html'">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span class="item-description">
                                        Logout
                                    </span>
                                </button>
                            </div>
                        </nav>
            </div>
        </aside>
        <main>            
            <div class="container">
                <div class="box-welcome">
                    <div class="title-welcome">
                        <span>Olá <?php echo htmlspecialchars($user['nome']); ?></span>
                        <h1>Seja bem-vindo</h1>
                    </div>
                    <div class="img-welcome"></div>
                </div>
                <div class="box-visao-geral">
                    <h2>Visão geral</h2>
                    <div class="flex-visao-geral">
                        <div class="content-visao" id="content-visao01">
                            <div class="box-menu"><a href="#"><img src="../../assets/img/home/logo/icon-menu.png" alt="" width="30px" style="float: right;"></a></div>
                            <div class="visao-elements">
                                <img id="img1" src="../../assets/img/home/logo/Layer_1.png" alt="">
                                <h4><?php echo htmlspecialchars($totalAlunos); ?></h4>
                            </div>
                            <p>Total de estudantes</p>
                        </div>
                        <div class="content-visao" id="content-visao02">
                            <div class="box-menu"><a href="#"><img src="../../assets/img/home/logo/icon-menu.png" alt="" width="30px" style="float: right;"></a></div>
                            <div class="visao-elements">
                                <img id="img2" src="../../assets/img/home/logo/sala-de-aula (3) 1.png" alt="">
                                <h4><?php echo htmlspecialchars($totalProfessor); ?></h4>
                            </div>
                            <p>Total de docentes</p>
                        </div>
                        <div class="content-visao" id="content-visao03">
                            <div class="box-menu"><a href="#"><img src="../../assets/img/home/logo/icon-menu.png" alt="" width="30px" style="float: right;"></a></div>
                            <div class="visao-elements img3">
                                <img id="img3" src="../../assets/img/home/logo/Layer_1-1.png" alt="">
                                <h4><?php echo htmlspecialchars($totalCoordenador); ?></h4>
                            </div>
                            <p>Total de responsáveis</p>
                        </div>
                    </div>
                </div>
                <section class="box-registro">
                    <div class="box-flex-registro">
                        <div class="grafico">
                            <h2>Perfis <br>incompletos</h2>
                            <img src="../../assets/img/home/logo/grafic.png" alt="">
                            <span>63.8%</span>
                        </div>
                        <div class="registro">
                            <h2>Últimos registros</h2>
                            <table>
                                <tr>
                                    <th>Nome</th>
                                    <th>Matrícula</th>
                                    <th>Função</th>
                                </tr>
                                <?php
                                $contador = 0; // Reinicia o contador para garantir a exibição correta
                                foreach ($usuarios as $usuario) {
                                    if ($contador >= $maximo_registros) {
                                        break;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['RM']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['cargo']); ?></td>
                                    </tr>
                                    <?php
                                    $contador++;
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/home/bottomnav.js"></script>
    <script src="../../assets/js/home/menumobile.js"></script>
</body>
</html>

<?php
$conn->close();
?>