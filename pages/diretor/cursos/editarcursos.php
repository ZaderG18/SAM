<?php

$host = 'localhost';
$database = 'sam';
$username = 'root';
$password = '';
$conn = new mysqli($host, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    require_once '../../../php/login/validar.php';
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/scss/diretor/global/sidebar.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/global/menumobile.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/cursos/editar.css">
    <link rel="shortcut icon" href="../../../assets/img/Group 4.png" type="image/x-icon">
    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!--==== Box-icons ====-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Gestão de professores</title>
</head>
<body>
    <header class="header"> 
        <div class="logo-sam"><img src="../../../assets/img/home/logo/Mask group.png" alt=""></div>
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
                  <li><a href="../home_diretor.php" class="nav__link"><img src="../../../assets/img/home/icons/home.svg" alt="" srcset="">Home</a></li>

                  <li><a href="../docentes/docentes.php" class="nav__link"><img src="../../../assets/img/home/icons/docentes.svg" alt="" srcset="">Docentes</a></li>

                  <li><a href="../dashboard.php" class="nav__link"><img src="../../../assets/img/home/icons/dashboard.svg" alt="" srcset="">Dashboard</a></li>
                  <!--=============== DROPDOWN 1 
                  <li class="dropdown__item">
                     <div class="nav__link"><img src="../../../assets/img/home/icons/dashboard.svg" alt="" srcset="">
                        Dashboard<i class="ri-arrow-down-s-line dropdown__arrow"></i>
                     </div>

                     <ul class="dropdown__menu">
                        <li>
                           <a href="../dashboard/index.html" class="dropdown__link">
                              <i class="ri-pie-chart-line"></i> Painel
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
                                    <img src="../../../assets/img/home/coqui-chang-COP.jpg" id="user_avatar" alt="Avatar">
                        
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
                                    <li class="side-item">
                                        <a href="../home_diretor.php">
                                            <img src="../../../assets/img/home/icons/home.svg" alt="" >
                                            <span class="item-description">
                                                Home
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="../docentes/docentes.php">
                                            <img src="../../../assets/img/home/icons/docentes.svg" alt="">
                                            <span class="item-description">
                                                Docentes
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item active">
                                        <a href="#">
                                            <img src="../../../assets/img/home/icons/cursos.svg" alt="" width="30px">
                                            <span class="item-description">
                                                Gerenciar Cursos
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../../assets/img/home/icons/user.svg" alt="">
                                            <span class="item-description">
                                                Gerenciar usuarios
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../../assets/img/home/icons/comunicado.svg" alt="">
                                            <span class="item-description">
                                                Gerenciar comunicados
                                            </span>
                                        </a>
                                    </li>

                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../../assets/img/home/icons/documento.svg" alt="">
                                            <span class="item-description">
                                                Gerenciar documentos
                                            </span>
                                        </a>
                                    </li>

                                    <li class="side-item">
                                        <a href="../dashboard.php">
                                            <img src="../../../assets/img/home/icons/dashboard.svg" alt="">
                                            <span class="item-description">
                                                Dashboard
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../../assets/img/home/icons/configuracao.svg" alt="">
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
                                <button id="logout_btn" onclick="window.location.href='../../php/login/logout.php'">
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
                <div class="box-title">
                    <div class="flex-title">
                        <h1>Gerenciamento de Cursos</h1>
                        <div class="box-img"><img src="../../../assets/img/cursos/cusos.svg" alt="" srcset=""></div>
                    </div>
                    <div class="line"></div>
                </div><!--box-title-->

                <div class="container-cursos">
                    <div class="box-curso">
                        <div class="menu-opition">
                            <div class="box-numeracao"><h6>8</h6></div>
                            <i class='bx bx-dots-horizontal-rounded' onclick="toggleModal(event)"></i>
                            <div class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal(event)">&times;</span>
                                    <ul>
                                        <li><button onclick="editCourse()">Editar</button></li>
                                        <li><button onclick="deleteCourse(this)">Deletar</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex-curso">
                            <h5>Geografia</h5>
                            <p>professor:<span>Florinda</span></p>
                            <div class="box-docente">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                                <span>35 Membros</span>
                            </div>
                        </div>
                    </div><!--box-curso-->

                    <div class="box-curso">
                        <div class="menu-opition">
                            <div class="box-numeracao"><h6>8</h6></div>
                            <i class='bx bx-dots-horizontal-rounded' onclick="toggleModal(event)"></i>
                            <div class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal(event)">&times;</span>
                                    <ul>
                                        <li><button onclick="editCourse()">Editar</button></li>
                                        <li><button onclick="deleteCourse(this)">Deletar</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex-curso">
                            <h5>Geografia</h5>
                            <p>professor:<span>Florinda</span></p>
                            <div class="box-docente">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                                <span>35 Membros</span>
                            </div>
                        </div>
                    </div><!--box-curso-->

                    <div class="box-curso">
                        <div class="menu-opition">
                            <div class="box-numeracao"><h6>8</h6></div>
                            <i class='bx bx-dots-horizontal-rounded' onclick="toggleModal(event)"></i>
                            <div class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal(event)">&times;</span>
                                    <ul>
                                        <li><button onclick="editCourse()">Editar</button></li>
                                        <li><button onclick="deleteCourse(this)">Deletar</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex-curso">
                            <h5>Geografia</h5>
                            <p>professor:<span>Florinda</span></p>
                            <div class="box-docente">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                                <span>35 Membros</span>
                            </div>
                        </div>
                    </div><!--box-curso-->

                    <div class="box-curso">
                        <div class="menu-opition">
                            <div class="box-numeracao"><h6>8</h6></div>
                            <i class='bx bx-dots-horizontal-rounded' onclick="toggleModal(event)"></i>
                            <div class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal(event)">&times;</span>
                                    <ul>
                                        <li><button onclick="editCourse()">Editar</button></li>
                                        <li><button onclick="deleteCourse(this)">Deletar</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex-curso">
                            <h5>Geografia</h5>
                            <p>professor:<span>Florinda</span></p>
                            <div class="box-docente">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                                <span>35 Membros</span>
                            </div>
                        </div>
                    </div><!--box-curso-->

                    <div class="box-curso">
                        <div class="menu-opition">
                            <div class="box-numeracao"><h6>8</h6></div>
                            <i class='bx bx-dots-horizontal-rounded' onclick="toggleModal(event)"></i>
                            <div class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal(event)">&times;</span>
                                    <ul>
                                        <li><button onclick="editCourse()">Editar</button></li>
                                        <li><button onclick="deleteCourse(this)">Deletar</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex-curso">
                            <h5>Geografia</h5>
                            <p>professor:<span>Florinda</span></p>
                            <div class="box-docente">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                                <span>35 Membros</span>
                            </div>
                        </div>
                    </div><!--box-curso-->

                    <div class="box-curso">
                        <div class="menu-opition">
                            <div class="box-numeracao"><h6>8</h6></div>
                            <i class='bx bx-dots-horizontal-rounded' onclick="toggleModal(event)"></i>
                            <div class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal(event)">&times;</span>
                                    <ul>
                                        <li><button onclick="editCourse()">Editar</button></li>
                                        <li><button onclick="deleteCourse(this)">Deletar</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex-curso">
                            <h5>Geografia</h5>
                            <p>professor:<span>Florinda</span></p>
                            <div class="box-docente">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                                <span>35 Membros</span>
                            </div>
                        </div>
                    </div><!--box-curso-->

                    <div class="box-curso">
                        <div class="menu-opition">
                            <div class="box-numeracao"><h6>8</h6></div>
                            <i class='bx bx-dots-horizontal-rounded' onclick="toggleModal(event)"></i>
                            <div class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal(event)">&times;</span>
                                    <ul>
                                        <li><button onclick="editCourse()">Editar</button></li>
                                        <li><button onclick="deleteCourse(this)">Deletar</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex-curso">
                            <h5>Geografia</h5>
                            <p>professor:<span>Florinda</span></p>
                            <div class="box-docente">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                                <span>35 Membros</span>
                            </div>
                        </div>
                    </div><!--box-curso-->

                    <div class="box-curso">
                        <div class="menu-opition">
                            <div class="box-numeracao"><h6>8</h6></div>
                            <i class='bx bx-dots-horizontal-rounded' onclick="toggleModal(event)"></i>
                            <div class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal(event)">&times;</span>
                                    <ul>
                                        <li><button onclick="editCourse()">Editar</button></li>
                                        <li><button onclick="deleteCourse(this)">Deletar</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex-curso">
                            <h5>Geografia</h5>
                            <p>professor:<span>Florinda</span></p>
                            <div class="box-docente">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                                <span>35 Membros</span>
                            </div>
                        </div>
                    </div><!--box-curso-->
                    

                 
                </div><!--container-cursos-->
            </div><!--container-->
        </main>
    </div>

    <script src="../../../assets/js/sidebar/sidebar.js"></script>
    <!-- <script src="../../../assets/js/home/bottomnav.js"></script> -->
     <script src="../../../assets/js/diretor/cursos/modal.js"></script>
    <script src="../../../assets/js/home/menumobile.js"></script>
</body>
</html>