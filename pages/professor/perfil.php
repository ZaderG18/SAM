<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/perfil/perfil.css">
    <link rel="stylesheet" href="../../assets/css/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/global/estilogeral.css">
 
    <!-- Favicon -->
    <link rel="icon" href="../../assets/img/Group 4.png" type="image/png">
    
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
    <div class="containerpx">
        <!-- Cabeçalho -->
        <div class="headerpx">
            <img src="../../assets/img/home/fotos/Usuário_Header.png" alt="Foto da Professora">
            <div class="info">
                <h2>Prof. Luana Silva</h2>
                <p>ID: 987654</p>
                <p>Email: luana.silva@exemplo.com</p>
                <p>Departamento: Engenharia de Computação</p>
                <p>Status: Ativo</p>
            </div>
        </div>

        <!-- Informações Pessoais -->
        <div class="section">
            <h3 class="section-title">Informações Pessoais</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Nome Completo:</label>
                    <p>Prof. Luana Silva</p>
                </div>
                <div class="detail-item">
                    <label>Data de Nascimento:</label>
                    <p>10/05/1975</p>
                </div>
                <div class="detail-item">
                    <label>Telefone:</label>
                    <p>(11) 98888-8888</p>
                </div>
                <div class="detail-item">
                    <label>Endereço:</label>
                    <p>Rua Exemplo, 456, São Paulo - SP</p>
                </div>
                <div class="detail-item">
                    <label>Estado Civil:</label>
                    <p>Casada</p>
                </div>
                <div class="detail-item">
                    <label>Nacionalidade:</label>
                    <p>Brasileira</p>
                </div>
                <div class="detail-item">
                    <label>Data de Admissão:</label>
                    <p>01/03/2010</p>
                </div>
            </div>
        </div>

        <!-- Informações Acadêmicas -->
        <div class="section">
            <h3 class="section-title">Informações Acadêmicas</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Departamento:</label>
                    <p>Engenharia de Computação</p>
                </div>
                <div class="detail-item">
                    <label>Cargo:</label>
                    <p>Professora Titular</p>
                </div>
                <div class="detail-item">
                    <label>Disciplinas Ministradas:</label>
                    <p>Algoritmos, Estrutura de Dados, Inteligência Artificial</p>
                </div>
                <div class="detail-item">
                    <label>Sala:</label>
                    <p>Sala 101, Bloco A</p>
                </div>
                <div class="detail-item">
                    <label>Orientações:</label>
                    <p>10 alunos de mestrado, 5 alunos de doutorado</p>
                </div>
                <div class="detail-item">
                    <label>Projetos de Pesquisa:</label>
                    <p>Inteligência Artificial Aplicada, Robótica Autônoma</p>
                </div>
                <div class="detail-item">
                    <label>Publicações:</label>
                    <p>20 artigos em revistas internacionais</p>
                </div>
            </div>
        </div>

        <!-- Desempenho Acadêmico -->
        <div class="section">
            <h3 class="section-title">Desempenho Acadêmico</h3>
            <ul>
                <li>Participação em 95% das reuniões departamentais.</li>
                <li>Avaliação média pelos alunos: 9.2</li>
                <li>Coordenação de 3 projetos de extensão.</li>
                <li>Prêmio de Melhor Professora do Departamento em 2022.</li>
            </ul>
        </div>

        <!-- Projetos e Pesquisas -->
        <div class="section">
            <h3 class="section-title">Projetos e Pesquisas</h3>
            <ul>
                <li>Projeto de robótica autônoma (em andamento).</li>
                <li>Pesquisa sobre algoritmos de inteligência artificial (concluída em 2023).</li>
                <li>Projeto de Sistema de Energia Solar (em desenvolvimento).</li>
            </ul>
        </div>

        <!-- Contato de Emergência -->
        <div class="section">
            <h3 class="section-title">Contato de Emergência</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Nome do Contato:</label>
                    <p>João Silva</p>
                </div>
                <div class="detail-item">
                    <label>Parentesco:</label>
                    <p>Esposo</p>
                </div>
                <div class="detail-item">
                    <label>Telefone de Contato:</label>
                    <p>(11) 97777-7777</p>
                </div>
                <div class="detail-item">
                    <label>Email de Contato:</label>
                    <p>joao.silva@email.com</p>
                </div>
            </div>
        </div>

        <!-- Atividades Extracurriculares -->
        <div class="section">
            <h3 class="section-title">Atividades Extracurriculares</h3>
            <ul>
                <li>Participação no grupo de robótica da universidade.</li>
                <li>Organizadora do Simpósio de Inteligência Artificial.</li>
                <li>Voluntária no projeto de inclusão digital da comunidade local.</li>
                <li>Membro do Conselho de Pesquisa da Universidade.</li>
            </ul>
        </div>

        <!-- Eventos -->
        <div class="section">
            <h3 class="section-title">Eventos Acadêmicos</h3>
            <ul>
                <li>Semana da Engenharia - 12/11/2024</li>
                <li>Hackathon Acadêmico - 25/11/2024</li>
                <li>Feira de Ciências e Tecnologia - 10/12/2024</li>
            </ul>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/perfil/perfil.js"></script>
</body>
</html>
