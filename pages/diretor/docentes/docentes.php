<?php
$host = "localhost";
$senha= "";
$username= "root";
$banco = "sam";
$conn = new mysqli($host, $username, $senha, $banco);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco". $conn->connect_error);
}
include "../../../php/global/funcao.php";
require_once '../../../php/login/validar.php';
$user = $_SESSION['user'];
$professor = get_todos_professores($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/scss/diretor/global/sidebar.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/global/menumobile.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/doscente/style.css">
    
    <link rel="stylesheet" href="../../../assets/scss/doscente/swiper-bundle.min.css">
    <link rel="stylesheet" href="../../../assets/scss/doscente/slide.css">
    <link rel="icon" href="../../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

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
                  <li><a href="home_diretor.php" class="nav__link"><img src="../../../assets/img/home/icons/home.svg" alt="" srcset="">Home</a></li>

                  <!-- <li><a href="#" class="nav__link"><img src="../../../assets/img/home/icons/docentes.svg" alt="" srcset="">Docentes</a></li> -->

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
                  
                  <li><a href="cursos.php" class="nav__link">Cursos</a></li>

                  <li><a href="dashboard.php" class="nav__link"><img src="../../../assets/img/home/icons/dashboard.svg" alt="" srcset="">Dashboard</a></li>

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
                                            <?php echo htmlspecialchars($user ['nome']); ?>
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
                        
                                    <li class="side-item active">
                                        <a href="docentes.php">
                                            <img src="../../../assets/img/home/icons/docentes.svg" alt="">
                                            <span class="item-description">
                                                Docentes
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="../cursos/cursos.php">
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
                                <button id="logout_btn" onclick="window.location.href='../../../php/login/logout.php'">
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
                        <h1>Gestão de professores</h1>
                        <div class="box-img"><img src="../../../assets/img/docente/image 1.png" alt="" srcset=""></div>
                    </div>
                </div><!--box-title-->

                <div class="container-painel-docente">
                    <div class="container-filtro">

                        <div class="box-filtro">
                            <label for="">Nome:</label>
                            <input type="text">
                        </div>
                        <div class="box-filtro">
                            <label for="">Disciplinas ministradas</label>
                            <select name="disciplinas" id="disciplinas">
                                <option value="volvo">Desenvolvimento de Sistemas</option>
                                <option value="saab">Nutrição</option>
                                <option value="opel">Adiministração</option>
                                <option value="audi">Enfermagem</option>
                              </select>
                        </div>
                        <div class="box-filtro">
                            <label for="">Registro de Matrícula</label>
                            <input type="text">
                        </div>

                        <input type="button" value="Filtrar" id="filtrar">
                    </div>

                    <div class="filtro-tabela">
                        <!-- <nav class="nav">
                            <ul>
                                <li><a href="">Prestadores de serviço</a></li>
                                <li><a href="">Coordenador</a></li>
                                <li><a href="" class="active">Docentes</a></li>
                            </ul>
                        </nav> 
                        <div class="line" style="display: none;"></div>-->

                        <div class="table-flex-title">
                            <div class="title-foto table"><h5>foto</h5></div>
                            <div class="title-dados table"><h5>Dados gerais</h5></div>
                            <div class="title-disciplina table"><h5>Disciplina</h5></div>
                        </div>

                        <?php foreach ($professores as $professor) { ?>
                        <div class="tabela" ><!--Tabela-->
                            <div class="box-foto">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-0Zx1bDv5BNY-unsplash.jpg" alt="" class="image">
                            </div>
                            <div class="box-info-geral" style="display: flex; flex-direction: column;">
                                <div class="flex-info nome-info">
                                    <h5>Nome:</h5>
                                    <span><?php $professor['nome'] ?></span>
                                </div>
                                <div class="flex-info nome-info">
                                    <h5>CPF:</h5>
                                    <span><?php $professor['cpf']?></span>
                                </div>
                                <div class="flex-info nome-info">
                                    <h5>Setor:</h5>
                                    <span>Área pedagógica</span>
                                </div>
                                <div class="flex-info nome-info">
                                    <h5>RM:</h5>
                                    <span><?php $professor['rm']?></span>
                                </div>
                            </div>
                            <div class="box-disciplina">
                                <span><?php $professor['disciplina']?></span>
                            </div>
                        </div><!--tabela--> 
                            <?php }?>
                        <div class="tabela" ><!--Tabela-->
                            <div class="box-foto">
                                <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="" class="image">
                            </div>
                            <div class="box-info-geral" style="display: flex; flex-direction: column;">
                                <div class="flex-info nome-info">
                                    <h5>Nome:</h5>
                                    <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</span>
                                </div>
                                <div class="flex-info nome-info">
                                    <h5>CPF:</h5>
                                    <span>000.000.000-00</span>
                                </div>
                                <div class="flex-info nome-info">
                                    <h5>Setor:</h5>
                                    <span>Área pedagógica</span>
                                </div>
                                <div class="flex-info nome-info">
                                    <h5>RM:</h5>
                                    <span>000-00-00</span>
                                </div>
                            </div>
                            <div class="box-disciplina">
                                <span>Nutrição</span>
                            </div>
                        </div><!--tabela--> 

                        <div class="tabela" ><!--Tabela-->
                            <div class="box-foto">
                                <img src="../../../assets/img/persona/coqui-chang-COP.jpg" alt="" class="image">
                            </div>
                            <div class="box-info-geral" style="display: flex; flex-direction: column;">
                                <div class="flex-info nome-info">
                                    <h5>Nome:</h5>
                                    <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</span>
                                </div>
                                <div class="flex-info nome-info">
                                    <h5>CPF:</h5>
                                    <span>000.000.000-00</span>
                                </div>
                                <div class="flex-info nome-info">
                                    <h5>Setor:</h5>
                                    <span>Área pedagógica</span>
                                </div>
                                <div class="flex-info nome-info">
                                    <h5>RM:</h5>
                                    <span>000-00-00</span>
                                </div>
                            </div>
                            <div class="box-disciplina">
                                <span>Nutrição</span>
                            </div>
                        </div><!--tabela--> 

                    </div><!--filtro-tabela-desktop-->



                                            <!--TABELA DOCENTE MOBILE-->


                        <div class="testimonial mySwiper">
                            <div class="testi-content swiper-wrapper">
                              <div class="slide swiper-slide tabela" ><!--Tabela-->
                                <div class="box-foto">
                                    <img src="../../../assets/img/persona/jurica-koletic-7YVZYZeITc8-unsplash.jpg" alt="" class="image">
                                </div>
                                <div class="box-info-geral" style="display: flex; flex-direction: column;">
                                    <div class="flex-info nome-info">
                                        <h5>Nome:</h5>
                                        <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</span>
                                    </div>
                                    <div class="flex-info nome-info">
                                        <h5>CPF:</h5>
                                        <span>000.000.000-00</span>
                                    </div>
                                    <div class="flex-info nome-info">
                                        <h5>Setor:</h5>
                                        <span>Área pedagógica</span>
                                    </div>
                                    <div class="flex-info nome-info">
                                        <h5>RM:</h5>
                                        <span>000-00-00</span>
                                    </div>
                                </div>
                                <div class="box-disciplina">
                                    <span>Nutrição</span>
                                </div>
                            </div><!--tabela--> 

                            <div class="slide swiper-slide tabela" ><!--Tabela-->
                                <div class="box-foto">
                                    <img src="../../../assets/img/persona/linkedin-sales-solutions-pAtA8xe_iVM-unsplash.jpg" alt="" class="image">
                                </div>
                                <div class="box-info-geral" style="display: flex; flex-direction: column;">
                                    <div class="flex-info nome-info">
                                        <h5>Nome:</h5>
                                        <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</span>
                                    </div>
                                    <div class="flex-info nome-info">
                                        <h5>CPF:</h5>
                                        <span>000.000.000-00</span>
                                    </div>
                                    <div class="flex-info nome-info">
                                        <h5>Setor:</h5>
                                        <span>Área pedagógica</span>
                                    </div>
                                    <div class="flex-info nome-info">
                                        <h5>RM:</h5>
                                        <span>000-00-00</span>
                                    </div>
                                </div>
                                <div class="box-disciplina">
                                    <span>Nutrição</span>
                                </div>
                            </div><!--tabela--> 

                            <div class="slide swiper-slide tabela" ><!--Tabela-->
                                <div class="box-foto">
                                    <img src="../../../assets/img/persona/coqui-chang-COP.jpg" alt="" class="image">
                                </div>
                                <div class="box-info-geral" style="display: flex; flex-direction: column;">
                                    <div class="flex-info nome-info">
                                        <h5>Nome:</h5>
                                        <span>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</span>
                                    </div>
                                    <div class="flex-info nome-info">
                                        <h5>CPF:</h5>
                                        <span>000.000.000-00</span>
                                    </div>
                                    <div class="flex-info nome-info">
                                        <h5>Setor:</h5>
                                        <span>Área pedagógica</span>
                                    </div>
                                    <div class="flex-info nome-info">
                                        <h5>RM:</h5>
                                        <span>000-00-00</span>
                                    </div>
                                </div>
                                <div class="box-disciplina">
                                    <span>Nutrição</span>
                                </div>
                            </div><!--tabela--> 
                
                              </div>
                            </div>
                </div>
            </div><!--container-->
        </main>
    </div>

        <!-- Swiper JS -->
        <script src="../../../assets/js/diretor/docente/swiper-bundle.min.js"></script>

        <!-- JavaScript -->
        <script src="../../../assets/js/diretor/docente/script.js"></script>

    <script src="../../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../../assets/js/home/bottomnav.js"></script>
    <script src="../../../assets/js/home/menumobile.js"></script>
</body>
</html>