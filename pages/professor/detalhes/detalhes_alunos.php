<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes - Alunos</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/detalhes/detalhes_alunos.css">
    <link rel="stylesheet" href="../../assets/css/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/global/estilogeral.css">
 
    <!-- Favicon -->
    <link rel="icon" href="../../assets/img/Group 4.png" type="image/png">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
            <img src="../../assets/img/home/fotos/Usuário_Header.png" alt="" class="header__img">
            <div class="header__dropdown-content">
                <a href="../../html/perfil/index.html" class="header__dropdown-item">
                    <i class='bx bx-user'></i> Perfil
                </a>
                <a href="../../html/configuracoes/index.html" class="header__dropdown-item">
                    <i class='bx bx-cog'></i> Configurações
                </a>
                <a href="../../html/faq/index.html" class="header__dropdown-item">
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
                    <a href="../../html/home/home.html" class="nav__link">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Home</span>
                    </a>
                    <a href="../../html/historico/index.html" class="nav__link active">
                        <i class='bx bx-history nav__icon'></i>
                        <span class="nav__name">Histórico</span>
                    </a>
                    <a href="../../html/documentos/index.html" class="nav__link">
                        <i class='bx bx-file nav__icon'></i>
                        <span class="nav__name">Documentos</span>
                    </a>
                    <a href="../../html/calendario/index.html" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Cronograma</span>
                    </a>
                    <a href="../../html/enquetes/index.html" class="nav__link">
                        <i class='bx bx-poll nav__icon'></i>
                        <span class="nav__name">Pesquisas Secretaria</span>
                    </a>
                    <a href="../../html/chat/index.html" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a>
                    <h2 class="nav__subtitle">Orientador</h2>
                    <a href="../../html/dashboard/index.html" class="nav__link">
                        <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
        <a href="../../html/login/login.html" class="nav__link nav__logout">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Sair</span>
        </a>
    </nav>
</div>

<!--=================================================================== MAIN CONTENT ============================================================-->

<main>
  
    <!-- Container Principal -->
    <div class="container">
        <div class="student-header">
            <div class="student-info">
                <h2>Maria Silva</h2>
                <p>Matrícula: 2023001234</p>
                <p>Turma: 3º Ano B</p>
            </div>   
        </div>

        <!-- Seção de Detalhes -->
        <div class="detail-section">
            <div class="card">
                <h3>Desempenho Acadêmico</h3>
                <i class="fas fa-chart-line icon"></i>
                <p>Média: 8.7</p>
                <p>Disciplinas em Risco: Lógica de Programação e Phyton</p>
            </div>

            <div class="card">
                <h3>Frequência</h3>
                <i class="fas fa-calendar-check icon"></i>
                <p>Frequência Geral: 95%</p>
                <p>Faltas: 5</p>
            </div>

            <div class="card">
                <h3>Observações</h3>
                <i class="fas fa-sticky-note icon"></i>
                <p>Bom desenvolvimento, mas precisa de mais prática em Matemática.</p>
            </div>

            <div class="card">
                <h3>Relatórios</h3>
                <i class="fas fa-file-alt icon"></i>
                <ul>
                    <li><a href="#">Relatório de Desempenho - Set 2024</a></li>
                    <li><a href="#">Relatório de Frequência - Out 2024</a></li>
                    <li><a href="#">Relatório de Participação - Jul 2024</a></li>
                </ul>
            </div>
        </div>

        <!-- Seção de Gráfico Simulada 
        <div class="graph-container">
            <canvas id="performanceChart" class="graph"></canvas>
        </div>-->

        <!-- Ações -->
        <div class="actions">
            <button id="sendMessageBtn"><i class="fas fa-envelope"></i> Enviar Mensagem</button>
            <button onclick="alert('Gerar novo relatório');"><i class="fas fa-file-medical"></i> Gerar Relatório</button>
            <button id="openModalBtn"><i class="fas fa-calendar-plus"></i> Agendar Reunião</button>
        </div>
    </div>

    <!-- Modal Agendar Reunião -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Agendar Reunião</h2>
            </div>
            <div class="modal-body">
                <form id="meetingForm">
                    <label for="date">Data:</label>
                    <input type="date" id="date" name="date" required><br><br>
                    <label for="time">Hora:</label>
                    <input type="time" id="time" name="time" required><br><br>
                    <label for="responsavel">Responsável:</label>
                    <input type="text" id="responsavel" name="responsavel" placeholder="Nome do Responsável" required><br><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email do Responsável" required><br><br>
                    <label for="phone">Telefone:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Telefone do Responsável" required><br><br>
                    <label for="description">Descrição:</label><br>
                    <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="meetingForm">Agendar</button>
            </div>
        </div>
    </div>

    <!-- Modal Enviar Mensagem -->
    <div id="sendMessageModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Enviar Mensagem</h2>
            </div>
            <div class="modal-body">
                <form id="sendMessageForm">
                    <label for="emailTo">Para:</label>
                    <input type="email" id="emailTo" name="emailTo" placeholder="Email do Aluno" required><br><br>
                    <label for="subject">Assunto:</label>
                    <input type="text" id="subject" name="subject" placeholder="Assunto da Mensagem" required><br><br>
                    <label for="message">Mensagem:</label><br>
                    <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>
                </form>
            </div>
        </div>
    </div>

</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/detalhes/detalhes_aluno.js"></script>
</body>
</html>
