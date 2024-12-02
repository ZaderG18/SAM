<?php 
include '../../php/global/cabecario.php';
include '../../php/diretor/gerenCalend.php';
require '../../php/global/notificacao.php';
$notificacoes = obterNotificacoes($conn, $id);
$countNaoLidas = count(array_filter($notificacoes, fn($n) => $n['lida'] == 0));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->
    <!-- <link rel="stylesheet" href="../../assets/scss/diretor/home/style.css"> -->
    <link rel="stylesheet" href="../../assets/scss/diretor/global/navgation.css">
    <!-- <link rel="stylesheet" href="../../assets/scss/diretor/home/style.css"> -->
    <link rel="stylesheet" href="../../assets/scss/diretor/calendario/calendario.css">

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />

     <!--========== BOX ICONS ==========-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <title>Calendário de eventos</title>
</head>
<body>
    
   <!--========== HEADER ==========-->
   <header class="header">
    <div class="header__container">
        <a href="#" class="header__logo">SAM</a>

        <div class="header__search">
            <i class='bx bx-search header__icon'></i>
            <input type="search" placeholder="Search" class="header__input">
        </div>

        <!-- Notificações -->
                <div class="dropdown notification-dropdown">
              <div class="dropdown-toggle" id="notification-toggle">
                  <span class="notification-count"><?= $countNaoLidas ?></span>
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
                  <?php if (empty($notificacoes)): ?>
                    <p>Não há notificações!</p>
                    <?php else: ?>
                        <?php foreach ($notificacoes as $notificacao): ?>
                  <div class="box-flex-notification">
                     <div class="boximg-noti">
                      <img src="<?= htmlspecialchars($notificacao['imagem'])?>" alt="Profile">
                      <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                     </div>
                      <div class="dados-notification">
                          <h6><?= htmlspecialchars($notificacao['titulo'])?></h6>
                          <p><?= htmlspecialchars($notificacao['mensagem'])?></p>
                          <small><?= date('d/m/Y H:i', strtotime($notificacao['data_criacao']))?></small>
                      </div>
                  </div>
                  <?php endforeach?>
                  <?php endif?>
              </div>
          </div>

        <!-- Perfil -->
        <div class="dropdown profile-dropdown" style="margin: 0 15px;">
            <img src="<?php echo $fotoCaminho ?>" alt="Profile" class="header__img" id="profile-toggle">
            <div class="dropdown-content" id="profile-content">
                <h5>Etec | Centro Paula souza</h5>
                <div class="flex-conta">
                    <img src="<?php echo $fotoCaminho ?>" alt="Profile">
                    <div class="box-info-conta">
                        <h4><?php echo htmlspecialchars($user['nome'])?></h4>
                        <p><?php echo htmlspecialchars($user['email'])?></p>
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
                            
                            <a href="calendario.php" class="nav__link active">
                                <i class='bx bx-calendar-event  nav__icon'></i>
                                <span class="nav__name">calendário</span>
                            </a>
                        
                            <a href="dashboard/dashboard.php" class="nav__link">
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

                            <a href="cursos/cursos.php" class="nav__link">
                                <i class='bx bx-edit-alt nav__icon'></i>
                                <span class="nav__name">Gerenciar Cursos</span>
                            </a>
                        </div>
    
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Comunicações</h3>
    
                            <a href="comunicado.php" class="nav__link">
                                <i class='bx bx-broadcast nav__icon'></i>
                                <span class="nav__name">Comunicados</span>
                            </a>

                            <a href="documentos/solicdocument.php" class="nav__link">
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
            <div class="container calendar-container">
                <div class="left">
                  <div class="calendar">
                    <div class="month">
                      <i class="fas fa-angle-left prev"></i>
                      <div class="date">dezembro 2015</div>
                      <i class="fas fa-angle-right next"></i>
                    </div>
                    <div class="weekdays">
                      <div>Dom</div>
                      <div>Seg</div>
                      <div>Ter</div>
                      <div>Qua</div>
                      <div>Qui</div>
                      <div>Sex</div>
                      <div>Sáb</div>
                    </div>
                    <div class="days"></div>
                    <div class="goto-today">
                      <div class="goto">
                        <input type="text" placeholder="mm/aaaa" class="date-input" />
                        <button class="goto-btn">Ir</button>
                      </div>
                      <button class="today-btn">Hoje</button>
                    </div>
                  </div>
                </div>
                <div class="right">
                  <div class="today-date">
                    <div class="event-day">qua</div>
                    <div class="event-date">12 de dezembro de 2022</div>
                  </div>
                  <div class="events"></div>
                  <div class="add-event-wrapper">
                    <div class="add-event-header">
                      <div class="title">Adicionar Evento</div>
                      <i class="fas fa-times close"></i>
                    </div>
                    <div class="add-event-body">
                      <div class="add-event-input">
                        <input type="text" placeholder="Nome do Evento" class="event-name" />
                      </div>
                      <div class="add-event-input">
                        <input
                          type="text"
                          placeholder="Horário de Início"
                          class="event-time-from"
                        />
                      </div>
                      <div class="add-event-input">
                        <input
                          type="text"
                          placeholder="Horário de Término"
                          class="event-time-to"
                        />
                      </div>
                    </div>
                    <div class="add-event-footer">
                      <button class="add-event-btn">Adicionar Evento</button>
                    </div>
                  </div>
                </div>
                <button class="add-event">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              
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

    <!-- <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/home/bottomnav.js"></script>
    <script src="../../assets/js/home/menumobile.js"></script> -->

    <script src="../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../assets/js/diretor/global/dropdown.js"></script>
    
    <script src="../../assets/js/diretor/calendario/calendario.js"></script>
</body>
</html>