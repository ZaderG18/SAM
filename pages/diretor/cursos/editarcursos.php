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
    <!-- <link rel="stylesheet" href="../../assets/scss/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/scss/global/menumobile.css"> -->
    <link rel="stylesheet" href="../../assets/scss/diretor/global/navgation.css">
    <link rel="stylesheet" href="../../assets/scss/cursos/editar.css">

    <!--==== Box-icons ====-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Gestão de professores</title>
</head>
<body>
   <!--========== HEADER ==========-->
   <header class="header">
    <div class="header__container">
        <a href="#" class="header__logo">SAM</a>

        <div class="header__search">
            <button onclick="redirectToPage()"><i class='bx bx-search header__icon'></i></button>
            <input type="search" placeholder="Search" class="header__input" id="searchInput" oninput="showSuggestions()" autocomplete="off">
            <div id="suggestions"></div>
        </div>

        <!-- Notificações -->
        <div class="dropdown notification-dropdown">
            <div class="dropdown-toggle" id="notification-toggle">
                <span class="notification-count">3</span>
                <i class='bx bxs-bell'></i>
            </div>
            <div class="dropdown-content content-noti" id="notification-content">
                <hr>
                <h4>Alertas</h4>
                <hr>
                <ul>
                    <li>Aviso: Prazo de matrícula termina em 2 dias!</li>
                </ul>
                <hr>
                <h4>Notificações</h4>
                <hr>
                <div class="box-flex-notification">
                   <div class="boximg-noti">
                    <img src="../../assets/img/persona/minhafoto.PNG" alt="Profile">
                    <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                   </div>
                    <div class="dados-notification">
                        <h6>fulanodetal0110@gmail.com</h6>
                        <p>Chat - Aluno - 3°DS</p>
                    </div>
                </div>
                <div class="box-flex-notification">
                    <div class="boximg-noti">
                     <img src="../../assets/img/persona/christina-wocintechchat-com-0Zx1bDv5BNY-unsplash.jpg" alt="Profile">
                     <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                    </div>
                     <div class="dados-notification">
                         <h6>fulanodetal0110@gmail.com</h6>
                         <p>Chat - Coordenação</p>
                     </div>
                 </div>
                 <div class="box-flex-notification">
                    <div class="boximg-noti">
                     <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="Profile">
                     <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                    </div>
                     <div class="dados-notification">
                         <h6>fulanodetal0110@gmail.com</h6>
                         <p>Chat - Coordenação</p>
                     </div>
                 </div>
                 <div class="box-flex-notification">
                    <div class="boximg-noti">
                     <img src="../../assets/img/persona/linkedin-sales-solutions-pAtA8xe_iVM-unsplash.jpg" alt="Profile">
                     <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                    </div>
                     <div class="dados-notification">
                         <h6>fulanodetal0110@gmail.com</h6>
                         <p>Chat - Professor - nutrição</p>
                     </div>
                 </div>
                 <div class="box-flex-notification">
                    <div class="boximg-noti">
                     <img src="../../assets/img/persona/jurica-koletic-7YVZYZeITc8-unsplash.jpg" alt="Profile">
                     <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                    </div>
                     <div class="dados-notification">
                         <h6>fulanodetal0110@gmail.com</h6>
                         <p>Chat - Professor - Física</p>
                     </div>
                 </div>
            </div>
        </div>

        <!-- Perfil -->
        <div class="dropdown profile-dropdown" style="margin: 0 15px;">
            <img src="../../assets/img/persona/coqui-chang-COP.jpg" alt="Profile" class="header__img" id="profile-toggle">
            <div class="dropdown-content" id="profile-content">
                <h5>Etec | Centro Paula souza</h5>
                <div class="flex-conta">
                    <img src="../../assets/img/persona/coqui-chang-COP.jpg" alt="Profile">
                    <div class="box-info-conta">
                        <h4>David Richard Ramos Rosa</h4>
                        <p>david.rosa4@etec.sp.gov.br</p>
                        <span><a href="">Exibir Conta <i class='bx bx-check-square'></i></a></span>
                    </div>
                </div><!--flex-conta-->

                <!-- Sub-dropdown de Configurações -->
                <div class="profile-option" id="settings-toggle">
                    <p><i class='bx bxs-check-circle'></i> Disponivel</p>
                    <i class='bx bx-chevron-right'></i>
                </div>
                <div class="sub-dropdown" id="settings-content">
                    <p><a href=""><i class='bx bxs-check-circle'></i>Disponivel</a></p>
                    <p><a href=""><i class='bx bxs-circle'></i>Ocupado</a></p>
                    <p><a href=""><i class='bx bxs-minus-circle'></i>Não incomodar</a></p>
                    <p><a href=""><i class='bx bxs-time-five'></i>Volto logo</a></p>
                    <p><a href=""><i class='bx bxs-time-five'></i>Aparecer como ausente</a></p>
                    <p><a href=""><i class='bx bx-x-circle'></i>Aparecer offline</a></p>
                </div>

                <!-- Sub-dropdown de Localização -->
                <div class="profile-option" id="location-toggle">
                    <p><i class='bx bxs-location-plus' ></i>Definir local de trabalho</p>
                    <i class='bx bx-chevron-right'></i>
                </div>
                <div class="sub-dropdown sub-drop-localiza" id="location-content">
                    <h6>Para hoje</h6>
                    <p><i class='bx bx-buildings'></i>Office</p>
                    <p><i class='bx bxs-home'></i>Remoto</p>
                </div>

                <button class="logout-btn" style="float: right; margin: 15px 5px 0 5px;"><i class='bx bx-log-out-circle'></i>Logout</button>
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
                        <i class='bx bxs-disc nav__icon' ></i>
                        <span class="nav__logo-name">SAM</span>
                    </a>
    
                    <div class="nav__list">
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Principais</h3>
    
                            <a href="home_diretor.php" class="nav__link">
                                <i class='bx bx-home nav__icon' ></i>
                                <span class="nav__name">Home</span>
                            </a>
                            
                            <a href="calendario.php" class="nav__link ">
                                <i class='bx bx-calendar-event  nav__icon'></i>
                                <span class="nav__name">calendário</span>
                            </a>
                        
                            <a href="dashboard.php" class="nav__link">
                                <i class='bx bx-trending-up nav__icon'></i>
                                <span class="nav__name">Dashboard</span>
                            </a>
                        </div>
  
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Gerenciamento</h3>
  
                            <a href="usuarios/gerenuser.php" class="nav__link">
                                <i class='bx bx-user nav__icon'></i>
                                <span class="nav__name">Gerenciar Usuários</span>
                            </a>
                            
                            <div class="nav__dropdown">
                              <a href="#" class="nav__link active">
                                <i class='bx bx-edit-alt nav__icon'></i>
                                  <span class="nav__name">Gerenciar Cursos</span>
                                  <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                              </a>
  
                              <div class="nav__dropdown-collapse">
                                  <div class="nav__dropdown-content">
                                      <a href="index.html" class="nav__dropdown-item">Home</a>
                                      <a href="criarcurso.html" class="nav__dropdown-item">Criar</a>
                                      <a href="#" class="nav__dropdown-item">Remover</a>
                                  </div>
                              </div>
                          </div>
                        </div>
    
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Comunicações</h3>
    
                            <a href="#" class="nav__link">
                                <i class='bx bx-broadcast nav__icon'></i>
                                <span class="nav__name">Comunicados</span>
                            </a>
  
                            <a href="#" class="nav__link">
                                <i class='bx bx-archive-in nav__icon' ></i>
                                <span class="nav__name">Envio de Documentos</span>
                            </a>
                        </div>
  
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Interação</h3>
  
                            <a href="chat.php" class="nav__link">
                                <i class='bx bx-conversation nav__icon'></i>
                                <span class="nav__name">Chat</span>
                            </a>
                        </div>
  
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Configurações</h3>
  
                            <a href="configuracoes.php" class="nav__link">
                                <i class='bx bx-cog nav__icon'></i>
                                <span class="nav__name">Configurações</span>
                            </a>
                        </div>
                    </div>
                </div>
  
                <a href="../../php/login/logout.php" class="nav__link nav__logout">
                    <i class='bx bx-log-out nav__icon' ></i>
                    <span class="nav__name">Log Out</span>
                </a>
            </nav>
        </div>
    
        <main>
            <div class="container">
                <div class="box-title">
                    <div class="flex-title">
                        <h1>Gerenciamento de Cursos</h1>
                        <div class="box-img"><img src="../../assets/img/cursos/cusos.svg" alt="" srcset=""></div>
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
                                <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
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
                                <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
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
                                <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
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
                                <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
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
                                <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
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
                                <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
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
                                <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
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
                                <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                                <span>35 Membros</span>
                            </div>
                        </div>
                    </div><!--box-curso-->

                </div><!--container-cursos-->
            </div><!--container-->
        </main>

    <!-- <script src="../../assets/js/sidebar/sidebar.js"></script> -->
    <!-- <script src="../../assets/js/home/bottomnav.js"></script> -->
     <script src="../../assets/js/cursos/modal.js"></script>
     <script src="../../assets/js/global/navgation.js"></script>
     <script src="../../assets/js/global/navgation.js"></script>
     <script src="../../assets/js/global/dropdown.js"></script>
    <!-- <script src="../../assets/js/home/menumobile.js"></script> -->
</body>
</html>