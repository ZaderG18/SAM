<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequência</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/frequencia/frequencia.css">
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

    <div class="container">
        <h1>Chamada de Aula</h1>
        
        <!-- Filtros -->
        <div class="filters">
            <select id="turma">
                <option value="">Selecione a Turma</option>
                <option value="turma1">Turma 1</option>
                <option value="turma2">Turma 2</option>
            </select>

            <select id="materia">
                <option value="">Selecione a Matéria</option>
                <option value="html">HTML</option>
                <option value="css">CSS</option>
                <option value="javascript">JavaScript</option>
                <option value="python">Python</option>
            </select>

            <select id="turno">
                <option value="">Selecione o Turno</option>
                <option value="manha">Manhã</option>
                <option value="tarde">Tarde</option>
                <option value="noite">Noturno</option>
            </select>

            <select id="periodo">
                <option value="">Selecione o Período</option>
                <option value="1bim">1º Bimestre</option>
                <option value="2bim">2º Bimestre</option>
            </select>

            <select id="periodo-dia">
                <option value="">Selecione o Período do Dia</option>
                <option value="primeira-aula">Primeira Aula</option>
                <option value="segunda-aula">Segunda Aula</option>
            </select>

            <input type="date" id="filtro-dia">

            <select id="status-chamada">
                <option value="">Status da Chamada</option>
                <option value="feitas">Feitas</option>
                <option value="pendentes">Pendentes</option>
            </select>
        </div>

        <!-- Tabela de Chamada -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nome do Aluno</th>
                        <th>Status</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>João Silva</td>
                        <td class="actions">
                            <button onclick="marcarPresenca(this)">Presente</button>
                            <button onclick="marcarAusencia(this)">Ausente</button>
                        </td>
                        <td><textarea placeholder="Adicionar observação"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="editarStatus(this)">Editar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Ana Souza</td>
                        <td class="actions">
                            <button onclick="marcarPresenca(this)">Presente</button>
                            <button onclick="marcarAusencia(this)">Ausente</button>
                        </td>
                        <td><textarea placeholder="Adicionar observação"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="editarStatus(this)">Editar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Carlos Oliveira</td>
                        <td class="actions">
                            <button onclick="marcarPresenca(this)">Presente</button>
                            <button onclick="marcarAusencia(this)">Ausente</button>
                        </td>
                        <td><textarea placeholder="Adicionar observação"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="editarStatus(this)">Editar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Maria Lima</td>
                        <td class="actions">
                            <button onclick="marcarPresenca(this)">Presente</button>
                            <button onclick="marcarAusencia(this)">Ausente</button>
                        </td>
                        <td><textarea placeholder="Adicionar observação"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="editarStatus(this)">Editar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Pedro Santos</td>
                        <td class="actions">
                            <button onclick="marcarPresenca(this)">Presente</button>
                            <button onclick="marcarAusencia(this)">Ausente</button>
                        </td>
                        <td><textarea placeholder="Adicionar observação"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="editarStatus(this)">Editar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Lucas Almeida</td>
                        <td class="actions">
                            <button onclick="marcarPresenca(this)">Presente</button>
                            <button onclick="marcarAusencia(this)">Ausente</button>
                        </td>
                        <td><textarea placeholder="Adicionar observação"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="editarStatus(this)">Editar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Botão de Salvar Chamada -->
        <div class="save-button">
            <button onclick="salvarChamada()">Salvar Chamada</button>
        </div>
    </div>
</main>
    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/frequencia/frequencia.js"></script>
</body>
</html>
