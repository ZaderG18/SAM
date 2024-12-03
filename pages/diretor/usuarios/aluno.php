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
    <link rel="stylesheet" href="../../../assets/scss/diretor/usuario/aluno/modal-gestao.css">
    <!-- <link rel="stylesheet" href="../../../assets/scss/docente/style.css"> -->
    
    <link rel="stylesheet" href="../../../assets/scss/diretor/usuario/swiper-bundler.min.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/usuario/aluno/aluno.css">
    <link rel="icon" href="../../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->

      <!-- Swiper JS -->
      <script src="../../../assets/js/diretor/docente/swiper-bundle.min.js"></script>

      <!-- JavaScript -->
      <script src="../../../assets/js/diretor/docente/main.js"></script>

     <!--========== BOX ICONS ==========-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <title>Gestão de Alunos</title>
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
                            <a href="gerenuser.php" class="nav__link active">
                              <i class='bx bx-user nav__icon'></i>
                                <span class="nav__name">Gerenciar Usuários</span>
                                <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                            </a>

                            <div class="nav__dropdown-collapse">
                                <div class="nav__dropdown-content">
                                    <a href="gerenuser.php" class="nav__dropdown-item">Home</a>
                                    <a href="coordenador.html" class="nav__dropdown-item">Coordenador</a>
                                    <a href="docente.php" class="nav__dropdown-item">Docente</a>
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
                    <h1>Gestão de Alunos</h1>
                    <!-- <div class="box-img"><img src="../../../assets/img/docente/image 1.png" alt="" srcset=""></div> -->
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
                    <img src="" alt="Foto aluno" srcset="" style="width: 120px; height: 120px; border-radius: 50%;">
                    <h2 id="modalName">Nome do Usuário</h2>
                </div>
                <div class="modal-navigation">
                    <button class="nav-button" data-topic="personal-info">Informações Pessoais</button>
                    <button class="nav-button" data-topic="academic-data">Dados Acadêmicos</button>
                    <button class="nav-button" data-topic="financial-situation">Situação Financeira e Relatórios</button>
                    <button class="nav-button" data-topic="graficos">Gráficos</button>
                </div>
                <div id="modalContent">
                    <div class="topic" id="personal-info">
                        <h3>Informações Pessoais</h3>
                        <p>Nome completo: <span id="fullName"></span></p>
                        <p>Data de nascimento: <span id="birthDate"></span></p>
                        <p>Número de matrícula: <span id="registrationNumber"></span></p>
                        <p>Contatos de emergência: <span id="emergencyContacts"></span></p>
                        <p>Responsáveis: <span id="responsibles"></span></p>
                    </div>
                    <div class="topic" id="academic-data" style="display: none;">
                        <h3>Dados Acadêmicos</h3>
                        <p>Série/ano atual: <span id="currentYear"></span></p>
                        <p>Turma: <span id="class"></span></p>
                        <p>Boletim: <span id="reportCard"></span></p>
                        <p>Histórico escolar: <span id="academicHistory"></span></p>
                        <p>Faltas acumuladas: <span id="absences"></span></p>
                    </div>
                    <div class="topic" id="financial-situation" style="display: none;">
                        <h3>Situação Financeira e Relatórios</h3>
                        <p>Situacão financeira: <span id="financialStatus"></span></p>
                        <p>Logs de atividades: <span id="activityLogs"></span></p>
                        <p>Relatórios de desempenho: <span id="performanceReports"></span></p>
                        <p>Notas e comentários: <span id="notesComments"></span></p>
                        <p>Eventos e datas importantes: <span id="importantDates"></span></p>
                    </div>
                    <div class="topic topic-grafico" id="graficos" style="display: none;">
                        <div id="grafico1">
                            <!-- Gráfico de Faltas Acumuladas -->
                            <canvas id="graficoFaltas"></canvas>

                            <!-- Gráfico de Desempenho Acadêmico -->
                            <canvas style="margin-top: 40px;" id="graficoDesempenho"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>             
    </div>

    <script>
   var ctxFaltas = document.getElementById('graficoFaltas').getContext('2d');
var graficoFaltas = new Chart(ctxFaltas, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'], // Todos os meses
        datasets: [{
            label: 'Faltas Acumuladas',
            data: [1, 2, 3, 2, 1, 3, 0, 4, 5, 3, 2, 1], // Exemplo de faltas para cada mês
            backgroundColor: '#ebaa31',
            borderColor: '#ebaa31',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
               text: 'Faltas Acumuladas ao Longo do Ano',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                color: '#333'
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

        // Gráfico 2: Desempenho Acadêmico por Bimestre (Dados Acadêmicos)
var ctxDesempenho = document.getElementById('graficoDesempenho').getContext('2d');
var graficoDesempenho = new Chart(ctxDesempenho, {
    type: 'line',
    data: {
        labels: ['1º Bim', '2º Bim', '3º Bim', '4º Bim'], // Bimestres
        datasets: [{
            label: 'Notas de Desempenho', // Rótulo da linha
            data: [8.5, 9.2, 7.8, 8.9], // Notas de desempenho
            fill: false, // Não preencher a área abaixo da linha
            borderColor: '#ebaa31', // Cor da linha
            borderWidth: 3, // Espessura da linha
            tension: 0.4, // Curvatura da linha
            pointBackgroundColor: '#6923d0', // Cor dos pontos
            pointBorderColor: '#6923d0', // Cor da borda dos pontos
            pointRadius: 6, // Tamanho dos pontos
            pointHoverBackgroundColor: '#FF6384', // Cor do ponto ao passar o mouse
            pointHoverBorderColor: '#FF6384' // Cor da borda do ponto ao passar o mouse
        }]
    },
    options: {
        responsive: true, // Tornar o gráfico responsivo
        plugins: {
            title: {
                display: true,
                text: 'Desempenho Acadêmico por Bimestre', // Título do gráfico
                font: {
                    size: 18, // Tamanho da fonte do título
                    weight: 'bold' // Peso da fonte do título
                },
                color: '#333' // Cor do título
            },
            tooltip: {
                mode: 'index', // Mostrar tooltip para cada ponto
                intersect: false, // Tooltip vai aparecer mesmo quando não estiver no ponto exato
                callbacks: {
                    label: function(tooltipItem) {
                        return 'Nota: ' + tooltipItem.raw.toFixed(2); // Exibir a nota com 2 casas decimais
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: false, // O gráfico não precisa começar do zero
                min: 6, // Definir o valor mínimo do eixo y
                max: 10, // Definir o valor máximo do eixo y
                ticks: {
                    stepSize: 0.5 // Definir o intervalo das marcas no eixo y
                }
            }
        },
        animation: {
            duration: 1000, // Duração da animação do gráfico
            easing: 'easeOutQuart' // Tipo de animação
        }
    }
});


    </script>
    <!-- <script src="../../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../../assets/js/home/bottomnav.js"></script>
    <script src="../../../assets/js/home/menumobile.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../../assets/js/diretor/usuarios/modal-aluno.js"></script>
    <script src="../../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../../assets/js/diretor/global/dropdown.js"></script>
</body>
</html>