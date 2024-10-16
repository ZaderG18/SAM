<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico Acadêmico </title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/historico/historico.css">
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
  
    <div class="containerxx">
        <!-- Cabeçalho com título e busca -->
        <div class="header-section">
            <h1 class="headerpx">Histórico Acadêmico - Turmas e Alunos</h1>
        </div>

        <!-- Filtros de Turma, Bimestre, Turno, etc. -->
        <div class="filters">
            <div>
                <label for="turma">Selecionar Turma:</label>
                <select id="turma">
                    <option value="todas">Todas</option>
                    <option value="turmaA">Turma A</option>
                    <option value="turmaB">Turma B</option>
                    <option value="turmaC">Turma C</option>
                </select>
            </div>
            <div>
                <label for="bimestre">Selecionar Bimestre:</label>
                <select id="bimestre">
                    <option value="todos">Todos</option>
                    <option value="1bim">1º Bimestre</option>
                    <option value="2bim">2º Bimestre</option>
                    <option value="3bim">3º Bimestre</option>
                    <option value="4bim">4º Bimestre</option>
                </select>
            </div>
            <div>
                <label for="turno">Selecionar Turno:</label>
                <select id="turno">
                    <option value="todos">Todos</option>
                    <option value="manha">Manhã</option>
                    <option value="tarde">Tarde</option>
                    <option value="noite">Noite</option>
                </select>
            </div>
            <div>
                <label for="periodo">Selecionar Período:</label>
                <select id="periodo">
                    <option value="todos">Todos</option>
                    <option value="1periodo">1º Período</option>
                    <option value="2periodo">2º Período</option>
                    <option value="3periodo">3º Período</option>
                </select>
            </div>
        </div>

        <!-- Visão Geral da Turma -->
        <div class="dashboard-overview">
            <h2>Visão Geral da Turma</h2>
            <div class="cards-overview">
                <div class="card">
                    <h3>Média da Turma</h3>
                    <p>7.8</p>
                </div>
                <div class="card">
                    <h3>Disciplinas Críticas</h3>
                    <p>2 Disciplinas com alta taxa de reprovação</p>
                </div>
                <div class="card">
                    <h3>Progresso da Turma</h3>
                    <div class="progress-bar">
                        <div class="progress" style="width: 65%;">65% Concluído</div>
                    </div>
                </div>
                <div class="card">
                    <h3>Alunos com Desempenho Crítico</h3>
                    <p>3 alunos com nota média abaixo de 5.0</p>
                </div>
            </div>
        </div>

        <!-- Análise Individualizada -->
        <div class="student-analysis">
            <h2>Análise Individualizada do Aluno</h2>
            <div class="filters">
                <label for="student-select">Selecionar Aluno:</label>
                <select id="student-select">
                    <option value="juliana">Juliana Santos</option>
                    <option value="joao">João Pereira</option>
                    <option value="maria">Maria Silva</option>
                </select>
            </div>

            <!-- Resumo Acadêmico do Aluno -->
            <div class="summary">
                <p><strong>Nome:</strong> Juliana Santos</p>
                <p><strong>RM:</strong> 202312345</p>
                <p><strong>Média Geral:</strong> 8.2</p>
                <p><strong>Disciplinas Pendentes:</strong> 6</p>
                <p><strong>Prazo Estimado de Conclusão:</strong> Dezembro de 2024</p>

                <div class="progress-bar">
                    <div class="progress" style="width: 67%;">67% Concluído</div>
                </div>
            </div>

            <!-- Desempenho por Disciplina -->
            <h3>Desempenho por Disciplina</h3>
            <div class="table-container">
                <table class="performance-table">
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Nota</th>
                            <th>Faltas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Algoritmos e Programação</td>
                            <td>8.7</td>
                            <td>4</td>
                            <td class="approved">Aprovado</td>
                        </tr>
                        <tr>
                            <td>Banco de Dados</td>
                            <td>7.5</td>
                            <td>4</td>
                            <td class="approved">Aprovado</td>
                        </tr>
                        <tr>
                            <td>Desenvolvimento Web</td>
                            <td>6.0</td>
                            <td>4</td>
                            <td class="approved">Aprovado</td>
                        </tr>
                        <tr>
                            <td>Programação Mobile</td>
                            <td>5.0</td>
                            <td>5</td>
                            <td class="failed">Reprovado</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Alertas e Recomendações -->
        <div class="alerts-section">
            <h2>Alertas e Recomendações</h2>
            <ul class="alerts-list">
                <li><strong>Alerta:</strong> Aluno com alta taxa de faltas em Banco de Dados (Juliana Santos)</li>
                <li><strong>Recomendação:</strong> Considerar recuperação para João Pereira em Programação Mobile</li>
            </ul>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/historico/historico.js"></script>
</body>
</html>
