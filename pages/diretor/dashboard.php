<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/scss/diretor/global/navgation.css">
     <!--========== BOX ICONS ==========-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

     <link rel="stylesheet" href="../../assets/scss/dashboard/dashboard.css">
     <link rel="icon" href="../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->
    <title>Dashboard SAM</title>
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

                            <a href="#" class="nav__link active">
                                <i class='bx bx-trending-up nav__icon'></i>
                                <span class="nav__name">Dashboard</span>
                            </a>
                            
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Gerenciamento</h3>
    
                        
                            <a href="usuarios/gerenuser.php" class="nav__link">
                                <i class='bx bx-user nav__icon'></i>
                                <span class="nav__name">Gerenciar Usuários</span>
                            </a>

                            <a href="cursos/cursos.php" class="nav__link">
                                <i class='bx bx-edit-alt nav__icon'></i>
                                <span class="nav__name">Gerenciar Cursos</span>
                            </a>
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

        <div class="global-container">
           
            <main>
                <div class="box-title-dashboard">
                    <div class="flexh1">
                        <h1>Dashboard</h1>
                        <i class='bx bx-trending-up nav__icon'></i>
                    </div>
                    <nav class="navbar">
                        <div class="menu-toggle"><i class='bx bx-menu-alt-right'></i></div> <!-- Ícone hambúrguer -->
                        <ul>
                            <li><a href="#" onclick="loadContent('coordedenador')" class="nav_link active" data-section="coordedenador">Coordenador</a></li>
                            <li><a href="#" onclick="loadContent('professor')" class="nav_link" data-section="professor">Professor</a></li>
                            <li><a href="#" onclick="loadContent('aluno')" class="nav_link" data-section="aluno">Aluno</a></li>
                            <li><a href="#" onclick="loadContent('curso')" class="nav_link" data-section="cursos">Curso</a></li>
                            <!-- <li><a href="#" class="nav_link" data-section="relatorios">Relatórios</a></li>
                            <li><a href="#" class="nav_link" data-section="integracoes">Integrações</a></li> -->
                        </ul>
                    </nav>
                    <!-- <input type="date" name="" id=""> -->
                </div>
                <div class="container-content" id="main-content">
                    <section class="dashboard">
                        <div class="flex-box-dashboard">
                            <div class="box-dashboard">
                                <div class="box-icon">
                                    <img src="../../assets/img/dashboard/docente02.svg" alt="" srcset="">
                                </div><!--box-icon-->
                                <div class="box-flex-dados">
                                    <div class="dados">
                                        <span>Professores ativos</span>
                                        <h3>15</h3>
                                    </div><!--dados-->
                                    <!-- <div class="grafico"></div> -->
                                </div><!--box-flex-dados-->
                                <!-- <span >últimas 24 horas</span> -->
                            </div>
        
                            <div class="box-dashboard">
                                <div class="box-icon">
                                    <img src="../../assets/img/dashboard/student.svg" alt="" srcset="">
                                </div><!--box-icon-->
                                <div class="box-flex-dados">
                                    <div class="dados">
                                        <span>Alunos matriculados</span>
                                        <h3>358</h3>
                                    </div><!--dados-->
                                    <!-- <div class="grafico"></div> -->
                                </div><!--box-flex-dados-->
                                <!-- <span >últimas 24 horas</span> -->
                            </div>
        
                            <div class="box-dashboard">
                                <div class="box-icon">
                                    <img src="../../assets/img/dashboard/curso.svg" alt="" srcset="">
                                </div><!--box-icon-->
                                <div class="box-flex-dados">
                                    <div class="dados">
                                        <span>cursos ativos</span>
                                        <h3>10</h3>
                                    </div><!--dados-->
                                    <!-- <div class="grafico"></div> -->
                                </div><!--box-flex-dados-->
                                <!-- <span >últimas 24 horas</span> -->
                            </div>
                        </div>
                    </section>
                    <section class="section-registro">
                        <h3>Últimos registros</h3>
                        <div class="table-container">
                            <table>
                              <thead>
                                <tr>
                                  <th>Nome</th>
                                  <th>Matrícula</th>
                                  <th>Gênero</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td data-label="Nome">Ana Souza</td>
                                  <td data-label="Matrícula">20231001</td>
                                  <td data-label="Gênero">Feminino</td>
                                </tr>
                                <tr>
                                  <td data-label="Nome">Carlos Santos</td>
                                  <td data-label="Matrícula">20231002</td>
                                  <td data-label="Gênero">Masculino</td>
                                </tr>
                                <tr>
                                  <td data-label="Nome">Mariana Oliveira</td>
                                  <td data-label="Matrícula">20231003</td>
                                  <td data-label="Gênero">Feminino</td>
                                </tr>
                                <tr>
                                    <td data-label="Nome">Ana Souza</td>
                                    <td data-label="Matrícula">20231001</td>
                                    <td data-label="Gênero">Feminino</td>
                                  </tr>
                                  <tr>
                                    <td data-label="Nome">Carlos Santos</td>
                                    <td data-label="Matrícula">20231002</td>
                                    <td data-label="Gênero">Masculino</td>
                                  </tr>
                                  <tr>
                                    <td data-label="Nome">Mariana Oliveira</td>
                                    <td data-label="Matrícula">20231003</td>
                                    <td data-label="Gênero">Feminino</td>
                                  </tr>
                              </tbody>
                            </table>
                          </div>
                    </section>
                </div><!--container-content-->
            </main>
            
            <aside >
                <section class="section-aluno">
                    <h6>Alunos com matrículas pendentes</h6>
                    <div class="box-global-alunos">
                        <div class="aluno">
                            <img src="../../assets/img/persona/minhafoto.PNG" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>David Richard</h5>
                                    <span>3ºDesenvolvimento de sistemas</span>
                                </div>
                                <p>RM:<span>000-00-000</span></p>
                            </div>
                        </div><!--aluno-->

                        <div class="aluno">
                            <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>David Richard</h5>
                                    <span>3ºDesenvolvimento de sistemas</span>
                                </div>
                                <p>RM:<span>000-00-000</span></p>
                            </div>
                        </div><!--aluno-->

                        <div class="aluno">
                            <img src="../../assets/img/persona/christina-wocintechchat-com-0Zx1bDv5BNY-unsplash.jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>David Richard</h5>
                                    <span>3ºDesenvolvimento de sistemas</span>
                                </div>
                                <p>RM:<span>000-00-000</span></p>
                            </div>
                        </div><!--aluno-->
                        <button>Ver todos</button>
                    </div>
                </section>

                <section class="section-aluno">
                    <h6>Alunos com risco de evasão</h6>
                    <div class="box-global-alunos">
                        <div class="aluno">
                            <img src="../../assets/img/persona/christina-wocintechchat-com-0Zx1bDv5BNY-unsplash.jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>David Richard</h5>
                                    <span>3ºDesenvolvimento de sistemas</span>
                                </div>
                                <p>RM:<span>000-00-000</span></p>
                            </div>
                        </div><!--aluno-->

                        <div class="aluno">
                            <img src="../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>David Richard</h5>
                                    <span>3ºDesenvolvimento de sistemas</span>
                                </div>
                                <p>RM:<span>000-00-000</span></p>
                            </div>
                        </div><!--aluno-->

                        <div class="aluno">
                            <img src="../../assets/img/persona/jurica-koletic-7YVZYZeITc8-unsplash.jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>David Richard</h5>
                                    <span>3ºDesenvolvimento de sistemas</span>
                                </div>
                                <p>RM:<span>000-00-000</span></p>
                            </div>
                        </div><!--aluno-->
                        <button>Ver todos</button>
                    </div>
                </section>

                <!-- <section class="section-docentes">
                    <h2>Docentes</h2>
                </section> -->
                 <!-- <section class="section-grafico">
                    <h1>Total de acessos no SAM</h1>
                    <div class="box-grifico">
                        <canvas id="grafico1"></canvas>
                    </div>
                </section> -->
            </aside>
        </div><!--global-container-->

        <script src="../../assets/js/global/navgation.js"></script>
        <script src="../../assets/js/dashboard/spa/spa.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="../../assets/js/dashboard/dashboard.js"></script>
        <script src="../../assets/js/dashboard/navdash.js"></script>
        <script src="../../assets/js/global/dropdown.js"></script>
</body>
</html>