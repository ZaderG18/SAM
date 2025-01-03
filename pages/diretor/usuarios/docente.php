<?php
require '../../../php/global/cabecario2.php';
require '../../../php/login/validar.php';
require '../../../php/global/notificacao.php';
$notificacoes = obterNotificacoes($conn, $id);
$countNaoLidas = count(array_filter($notificacoes, fn($n) => $n['lida'] == 0));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../../../assets/scss/global/sidebar.css">
    <link rel="stylesheet" href="../../../assets/scss/global/menumobile.css"> -->
    <link rel="stylesheet" href="../../../assets/scss/diretor/global/navgation.css">
    <!-- <link rel="stylesheet" href="../../../assets/scss/usuario/style.css"> -->
    
    <link rel="stylesheet" href="../../../assets/scss/diretor/usuario/swiper-bundler.min.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/usuario/docente/docente.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/usuario/docente/modal-gestao.css">
    <link rel="icon" href="../../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Certifique-se de carregar a biblioteca Chart.js antes do script -->

      <!-- Swiper JS -->
      <script src="../../../assets/js/diretor/docente/swiper-bundle.min.js"></script>

      <!-- JavaScript -->
      <script src="../../../assets/js/diretor/docente/main.js"></script>


     <!--========== BOX ICONS ==========-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <title>Gestão de Professores</title>
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
  
                          <a href="../home_diretor.php" class="nav__link">
                              <i class='bx bx-home nav__icon' ></i>
                              <span class="nav__name">Home</span>
                          </a>
                          
                          <a href="../calendario.php" class="nav__link ">
                            <i class='bx bx-calendar-event  nav__icon'></i>
                            <span class="nav__name">calendário</span>
                        </a>
                      
                          <a href="../dashboard/dashboard.php" class="nav__link">
                              <i class='bx bx-trending-up nav__icon'></i>
                              <span class="nav__name">Dashboard</span>
                          </a>
                      </div>

                      <div class="nav__items">
                          <h3 class="nav__subtitle">Gerenciamento</h3>


                          <div class="nav__dropdown">
                            <a href="#" class="nav__link active">
                              <i class='bx bx-user nav__icon'></i>
                                <span class="nav__name">Gerenciar Usuários</span>
                                <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                            </a>

                            <div class="nav__dropdown-collapse">
                                <div class="nav__dropdown-content">
                                    <a href="gerenuser.php" class="nav__dropdown-item">Home</a>
                                    <a href="coordenador.html" class="nav__dropdown-item">Coordenador</a>
                                    <a href="aluno.php" class="nav__dropdown-item">Aluno</a>
                                </div>
                            </div>
                        </div>

                          <a href="../cursos/cursos.php" class="nav__link">
                              <i class='bx bx-edit-alt nav__icon'></i>
                              <span class="nav__name">Gerenciar Cursos</span>
                          </a>
                      </div>
  
                      <div class="nav__items">
                          <h3 class="nav__subtitle">Comunicações</h3>
  
                          <a href="../comunicado.php" class="nav__link">
                              <i class='bx bx-broadcast nav__icon'></i>
                              <span class="nav__name">Comunicados</span>
                          </a>

                          <a href="../documentos/solicdocument.php" class="nav__link">
                              <i class='bx bx-archive-in nav__icon' ></i>
                              <span class="nav__name">Envio de Documentos</span>
                          </a>
                      </div>

                      <div class="nav__items">
                          <h3 class="nav__subtitle">Interação</h3>

                          <a href="../chat.php" class="nav__link">
                              <i class='bx bx-conversation nav__icon'></i>
                              <span class="nav__name">Chat</span>
                          </a>
                      </div>

                      <div class="nav__items">
                          <h3 class="nav__subtitle">Configurações</h3>

                          <a href="../configuracoes.php" class="nav__link">
                              <i class='bx bx-cog nav__icon'></i>
                              <span class="nav__name">Configurações</span>
                          </a>
                      </div>
                  </div>
              </div>

              <a href="../../../php/login/logout.php" class="nav__link nav__logout">
                  <i class='bx bx-log-out nav__icon' ></i>
                  <span class="nav__name">Log Out</span>
              </a>
          </nav>
      </div>
        <main>
            <div class="box-title">
                <div class="flex-title">
                    <h1>Gestão de Professores</h1>
                    <div class="box-img"><img src="../../../assets/img/docente/image 1.png" alt="" srcset=""></div>
                </div>
            </div><!--box-title-->

                <div class="slider-container swiper">
                    <div class="slider-content">
                      <div class="card-wrapper swiper-wrapper">
                        <div class="card swiper-slide">
                          <div class="image-content">
                            <span class="overlay"></span>
                            <div class="card-image">
                              <img src="../../../assets/img/persona/minhafoto.PNG" alt="" />
                            </div>
                          </div>
                          <div class="card-content">
                            <h2 class="name">David</h2>
                            <p class="description">
                              Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam,
                              quas. Modi suscipit animi quas praesentium dolore excepturi,
                              magnam ullam facilis!
                            </p>
                            <button class="button">Read More</button>
                          </div>
                        </div>
              
                        <div class="card swiper-slide">
                          <div class="image-content">
                            <span class="overlay"></span>
                            <div class="card-image">
                              <img src="<?php echo $fotoCaminho ?>" alt="" />
                            </div>
                          </div>
                          <div class="card-content">
                            <h2 class="name">David</h2>
                            <p class="description">
                              Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam,
                              quas. Modi suscipit animi quas praesentium dolore excepturi,
                              magnam ullam facilis!
                            </p>
                            <button class="button">Read More</button>
                          </div>
                        </div>
              
                        <div class="card swiper-slide">
                          <div class="image-content">
                            <span class="overlay"></span>
                            <div class="card-image">
                              <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="" />
                            </div>
                          </div>
                          <div class="card-content">
                            <h2 class="name">Christy</h2>
                            <p class="description">
                              Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam,
                              quas. Modi suscipit animi quas praesentium dolore excepturi,
                              magnam ullam facilis!
                            </p>
                            <button class="button">Read More</button>
                          </div>
                        </div>

                        <div class="card swiper-slide">
                          <div class="image-content">
                            <span class="overlay"></span>
                            <div class="card-image">
                              <img src="../../../assets/img/persona/christina-wocintechchat-com-0Zx1bDv5BNY-unsplash.jpg" alt="" />
                            </div>
                          </div>
                          <div class="card-content">
                            <h2 class="name">Christy</h2>
                            <p class="description">
                              Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam,
                              quas. Modi suscipit animi quas praesentium dolore excepturi,
                              magnam ullam facilis!
                            </p>
                            <button class="button">Read More</button>
                          </div>
                        </div>
                      </div>
                    </div>
              
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next swiper-navBtn"></div>
                    <div class="swiper-button-prev swiper-navBtn"></div>
                  </div>
                   <!-- Modal única e reutilizável -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <div style="display: flex; flex-direction: column; align-items: center;">
            <img src="assets/img/persona/user-default.jpg" alt="Foto do Usuário" style="width: 120px; height: 120px; border-radius: 50%;">
            <h2 id="modalName">Nome do Professor</h2>
        </div>
        <div class="modal-navigation">
            <button class="nav-button" data-topic="personal-info">Informações Pessoais</button>
            <button class="nav-button" data-topic="professional-data">Dados Profissionais</button>
            <button class="nav-button" data-topic="class-management">Gestão de Turmas</button>
            <button class="nav-button" data-topic="performance-reports">Relatórios de Desempenho</button>
        </div>
        <div id="modalContent">
            <!-- Informações Pessoais -->
            <div class="topic" id="personal-info">
                <h3>Informações Pessoais</h3>
                <p>Nome completo: <span id="fullName"></span></p>
                <p>Data de nascimento: <span id="birthDate"></span></p>
                <p>CPF: <span id="cpf"></span></p>
                <p>Contatos de emergência: <span id="emergencyContacts"></span></p>
                <p>Endereço: <span id="address"></span></p>
            </div>
            <!-- Dados Profissionais -->
            <div class="topic" id="professional-data" style="display: none;">
                <h3>Dados Profissionais</h3>
                <p>Disciplina(s) lecionada(s): <span id="subjects"></span></p>
                <p>Carga horária semanal: <span id="weeklyHours"></span></p>
                <p>Departamento: <span id="department"></span></p>
                <p>Data de contratação: <span id="hireDate"></span></p>
                <p>Certificações: <span id="certifications"></span></p>
            </div>
            <!-- Gestão de Turmas -->
            <div class="topic" id="class-management" style="display: none;">
                <h3>Gestão de Turmas</h3>
                <p>Turmas atuais: <span id="currentClasses"></span></p>
                <p>Total de alunos: <span id="totalStudents"></span></p>
                <p>Agenda de aulas: <span id="classSchedule"></span></p>
                <p>Projetos ou atividades: <span id="projectsActivities"></span></p>
            </div>
            <!-- Relatórios de Desempenho -->
            <div class="topic" id="performance-reports" style="display: none;">
                <h3>Relatórios de Desempenho</h3>
                <p>Notas atribuídas: <span id="assignedGrades"></span></p>
                <p>Feedbacks enviados: <span id="sentFeedbacks"></span></p>
                <p>Relatórios de progresso dos alunos: <span id="studentReports"></span></p>
                <p>Frequência registrada: <span id="attendanceRecords"></span></p>
            </div>
        </div>
    </div>
</div>
    </main>             
    </div>

  

    <!-- <script src="../../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../../assets/js/home/bottomnav.js"></script>
    <script src="../../../assets/js/home/menumobile.js"></script> -->
    <script src="../../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../../assets/js/diretor/global/dropdown.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../../assets/js/diretor/usuarios/modal-docente.js"></script>

</body>
</html>