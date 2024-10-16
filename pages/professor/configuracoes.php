<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/configuracoes/configuracoes.css">
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
    <div class="cards-container">
        <!-- Lado esquerdo - Info Card -->
        <div class="info-card">
            <div class="profile-picture">
                <h3>Upload Foto(150px X 150px)</h3>
                <img src="profile-placeholder.png" id="profile-pic"/>
                <label for="upload" class="upload-button">Escolher Arquivo</label>
                <input type="file" id="upload" accept="image/*" class="input">
                <button class="btn-padrao">Salvar</button>
            </div>
            <div class="notifications">
                <h3>Notificações</h3>
                <label>Email</label>
                <select>
                    <option>Selecione</option>
                    <option>Sim</option>
                    <option>Não</option>
                </select>
                <label>Telefone</label>
                <select>
                    <option>Selecione</option>
                    <option>Sim</option>
                    <option>Não</option>
                </select>
                <button class="btn-padrao">Salvar</button>
            </div>
            <div class="security">
                <h3>Segurança e Privacidade</h3>
                <label class="toggle">
                    <div class="toggle-row">
                        <label>Mantenha suas senhas seguras</label>
                        <i class='bx bxs-toggle-left toggle-icon' id="toggle-1"></i>
                    </div>
                    <div class="toggle-row">
                        <label>Aceito receber notificações</label>
                        <i class='bx bxs-toggle-left toggle-icon' id="toggle-2"></i>
                    </div>
                    <div class="toggle-row">
                        <label>Não aceito o compartilhamento de dados</label>
                        <i class='bx bxs-toggle-left toggle-icon' id="toggle-3"></i>
                    </div>
                </label>
            </div>
        </div>
    
        <!-- Lado direito - Personal Info e Password Update -->
        <div class="main-content">
            <form>
                <div class="personal-info">
                    <h3>Informações Pessoais</h3>
                    <label>Nome Completo*</label>
                    <input type="text" required>
                    <label>Telefone*</label>
                    <input type="tel" required>
                    <label>Email*</label>
                    <input type="email" required>
                    <label>Gênero*</label>
                    <select required>
                        <option>Selecione seu gênero</option>
                        <option>Homem Cis</option>
                        <option>Mulher cis</option>
                        <option>Mulher Trans</option>
                        <option>Homem Trans</option>
                        <option>Não-Binário</option>
                        <option>Prefiro Não Dizer</option>
                    </select>
                    <label>Estado Civil*</label>
                    <select required>
                        <option>Selecione</option>
                        <option>Solteiro</option>
                        <option>Casado</option>
                        <option>Divorciado</option>
                        <option>Viúvo</option>
                    </select>
                    <label>Data de Nascimento*</label>
                    <input type="date" required>
                    <label>Nacionalidade*</label>
                    <input type="text" required>
                    <label>Endereço*</label>
                    <input type="text" required>
                    <label>ID</label>
                    <input type="text">
                    <label>Curso*</label>
                    <select required>
                        <option>Selecione o curso</option>
                        <option>Desenvolvimento de Sistemas</option>
                        <option>Enfermagem</option>
                        <option>Nutrição</option>
                        <option>Gastronomia</option>
                    </select>
                    <h3>Contato de Emergência</h3>
                    <label>Nome do Contato*</label>
                    <input type="text" required>
                    <label>Parentesco*</label>
                    <input type="text" required>
                    <label>Telefone de Contato*</label>
                    <input type="text" required>
                    <label>Email de Contato*</label>
                    <input type="text" required>
                    <button class="btn-padrao">Editar</button>
                    <button class="btn-padrao">Salvar</button>
                </div>
    
                <div class="password-update">
                    <h3>Atualizar Senha</h3>
                    <label>Senha Atual</label>
                    <input type="password" required>
                    <label>Nova Senha*</label>
                    <input type="password" required>
                    <label>Confirmar Nova Senha*</label>
                    <input type="password" required>
                    <button class="btn-padrao">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/configuracoes/configuracoes.js"></script>
</body>
</html>
