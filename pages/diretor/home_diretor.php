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
$usuarios = get_todos_usuarios($conn);
$totalAlunos = total_alunos($conn);
$totalProfessor = total_professores($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo ao sam</title>
                            <!-- CSS-->
    <link rel="stylesheet" href="../../assets/scss/diretor/style.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/sidebar.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/bottomnav.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/menumobile.css">
                            <!-- CSS-->
    <link rel="icon" href="../../assets/imagens/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--==== Box-icons ====-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

      <!--=============== REMIXICONS ===============-->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="logo-sam"><img src="../../assets/imagens/home/logo/Mask group.png" alt=""></div>
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
                  <li><a href="#" class="nav__link">Home</a></li>

                  <li><a href="#" class="nav__link">Company</a></li>

                  <!--=============== DROPDOWN 1 ===============-->
                  <li class="dropdown__item">
                     <div class="nav__link">
                        Analytics <i class="ri-arrow-down-s-line dropdown__arrow"></i>
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

                        <!--=============== DROPDOWN SUBMENU ===============-->
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
                        </li>
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
                                    <img src="../../assets/imagens/home/coqui-chang-COP.jpg" id="user_avatar" alt="Avatar">
                        
                                    <p id="user_infos">
                                        <span class="item-description">
                                            Fulano de Tal
                                        </span>
                                        <span class="item-description">
                                            Lorem Ipsum
                                        </span>
                                    </p>
                                </div>
                        
                                <ul id="side_items">
                                    <li class="side-item active">
                                        <a href="#">
                                            <i class="fa-solid fa-chart-line"></i>
                                            <span class="item-description">
                                                Dashboard
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <i class="fa-solid fa-user"></i>
                                            <span class="item-description">
                                                Usuários
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <i class="fa-solid fa-bell"></i>
                                            <span class="item-description">
                                                Notificações
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <i class="fa-solid fa-box"></i>
                                            <span class="item-description">
                                                Produtos
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <i class="fa-solid fa-image"></i>
                                            <span class="item-description">
                                                Imagens
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <i class="fa-solid fa-gear"></i>
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
                                <button id="logout_btn">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span class="item-description">
                                        <a href="../../php/logout.php">
                                        Logout
                                        </a>
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
                        <h1>Seja bem vinda </h1>
                    </div>
                    <div class="img-welcome"></div>
                </div>
    
                <div class="box-visao-geral">
                    <h2>Visão geral</h2>
    
                    <div class="flex-visao-geral" >
                        <div class="content-visao" id="content-visao01">
                            <div class="box-menu"><a href=""><img src="../../assets/imagens/home/logo/icon-menu.png" alt="" width="30px" style="float: right;"></a></div>
                            <div class="visao-elements">
                                <img id="img1" src="../../assets/imagens/home/logo/Layer_1.png" alt="">
                                <h4><?php echo htmlspecialchars($totalAlunos); ?></h4>
                            </div>
                            <p>Total de estudantes </p>
                        </div>
    
                        <div class="content-visao" id="content-visao02">
                            <div class="box-menu"><a href=""><img src="../../assets/imagens/home/logo/icon-menu.png" alt="" width="30px" style="float: right;"></a></div>
                            <div class="visao-elements">
                                <img id="img2" src="../../assets/imagens/home/logo/sala-de-aula (3) 1.png" alt="">
                                <h4><?php echo htmlspecialchars($totalProfessor); ?></h4>
                            </div>
                            <p>Total de docentes   </p>
                        </div>
    
                        <div class="content-visao" id="content-visao03">
                            <div class="box-menu"><a href=""><img src="../../assets/imagens/home/logo/icon-menu.png" alt="" width="30px" style="float: right;"></a></div>
                            <div class="visao-elements img3">
                                <img id="img3" src="../../assets/imagens/home/logo/Layer_1-1.png" alt="">
                                <h4>150</h4>
                            </div>
                            <p>Total de responsáveis   </p>
                        </div>
                    </div>
                </div> <!--box-visão-geral-->
                <section class="box-registro">
                    <div class="box-flex-registro">

                        <div class="grafico">
                            <h2>Perfis <br>incompletos</h2>
                            <img src="../../assets/imagens/home/logo/grafic.png" alt="">
                            <span>63.8%</span>
                        </div>

                        <div class="registro">
                            <h2>últimos  registros </h2>

                            <table>
                                <div class="line"></div>
                                <tr>
                                    <th>Nome</th>
                                    <th>Matricula</th>
                                    <th>Função</th>
                                </tr>
                                <?php foreach ($usuarios as $usuario){ ?>
                                <tr style=" margin-top: 100px;">
                                    <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['RM']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['cargo']); ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div><!--box-flex-registro-->
                </section>
            </div><!--container-->
            <!--<div class="bottom-nav">
                <button class="nav-item"><img src="../../assets/img/home/icons/icon1.png" alt="" > <span>gestão</span></button>
                <button class="nav-item"><img src="../../assets/img/home/icons/icon2.png" alt="" srcset=""><span>Docentes</span></button>
                <button class="nav-item"><img src="../../assets/img/home/icons/icon3.png" alt="" srcset=""><span>cursos</span></button>
                <button class="nav-item"><img src="../../assets/img/home/icons/icon4.png" alt="" srcset=""><span>Usuários</span></button>
                <button id="add-btn" class="nav-item plus"><img src="../../assets/img/home/icons/icon-menu.png" alt="" srcset=""><span>Mais</span></button>
              </div>
              
              <div id="expand-menu" class="expand-menu">
                <button class="close-btn">&times;</button>
                <div class="menu-options">
                  <button class="menu-item"><img src="../../assets/img/home/icons/icon5.png" alt="" ><span>Comunicados</span></button>
                  <button class="menu-item"><img src="../../assets/img/home/icons/icon6.png" alt="" ><span>Documentos</span></button>
                  <button class="menu-item"><img src="../../assets/img/home/icons/icon7.png" alt="" ><span>Financeiro</span></button>
                </div>
              </div>-->
        </main>
    </div>

    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/home/bottomnav.js"></script>
    <script src="../../assets/js/home/menumobile.js"></script>
</body>
</html>
<?php $conn->close(); ?>