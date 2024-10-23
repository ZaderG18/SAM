<?php
session_start();

// Verificar se o usuário está logado e pertence à role 'aluno'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'aluno') {
    header('Location: validar.php');
    exit();
}

// Requerendo arquivos necessários
require_once '../../php/global/funcao.php';
require_once '../../php/global/upload.php';
require_once '../../php/aluno/home.php';

// Acessando os dados do usuário da sessão
$user = $_SESSION['user'];

// Verificando o status do usuário, com valor padrão se não estiver definido
$status = isset($user['status']) ? $user['status'] : 'Desconhecido';

$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
$id = $user['id']; // ID do usuário

// Prepara SQL statement para recuperar a foto
$sql = "SELECT foto FROM aluno WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($fotoNome);
$stmt->fetch();
$stmt->close();
$conn->close();

// Verifica se há uma foto para o usuário
if (!empty($fotoNome)) {
    $fotoCaminho = "../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../assets/img/logo.jpg"; // Imagem padrão se nenhuma foto for carregada
}?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo ao SAM</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/home.scss">
    <link rel="stylesheet" href="../../assets/scss/global/sidebar.scss">
    <link rel="stylesheet" href="../../assets/scss/global/estilogeral.scss">
 
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
            <img src="<?php echo $fotoCaminho ?>" alt="" class="header__img">
            <div class="header__dropdown-content">
                <a href="perfil.php" class="header__dropdown-item">
                    <i class='bx bx-user'></i> Perfil
                </a>
                <a href="configuracoes.php" class="header__dropdown-item">
                    <i class='bx bx-cog'></i> Configurações
                </a>
                <a href="faq.php" class="header__dropdown-item">
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
                    <a href="home_aluno.php" class="nav__link">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Home</span>
                    </a>
                    <a href="historico.php" class="nav__link active">
                        <i class='bx bx-history nav__icon'></i>
                        <span class="nav__name">Histórico</span>
                    </a>
                    <a href="documentos.php" class="nav__link">
                        <i class='bx bx-file nav__icon'></i>
                        <span class="nav__name">Documentos</span>
                    </a>
                    <a href="cronograma.php" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Cronograma</span>
                    </a>
                    <a href="secretaria.php" class="nav__link">
                        <i class='bx bx-poll nav__icon'></i>
                        <span class="nav__name">Pesquisas Secretaria</span>
                    </a>
                    <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a>
                </div>
            </div>
        </div>
        <a href="../../php/login/logout.php" class="nav__link nav__logout">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Sair</span>
        </a>
    </nav>
</div>

<!--=================================================================== MAIN CONTENT ============================================================-->
                   <!--Banner-->
            <main>

                <div class="container">
                    <!-- Banner de saudação -->
                    <div class="banner">
                        <div>
                            <h1>Bem-vindo, <?php echo htmlspecialchars($user['nome']);?>!</h1>
                            <p>Você tem <?= $atualizacoes_importantes ?> atualizações importantes e <?= $tarefas_pendentes ?> tarefas pendentes.</p>
                            </div>
                        <img src="../../assets/img/home/fotos/aluno_de_pé.png" alt="Avatar">
                    </div>

                    <!-- Cards principais -->
                    <div class="cards">
                        <div class="card">
                            <a href="frequencia.php">
                            <img src="../../assets/img/home/fotos/circulo_verde.png" alt="Frequência">
                            </a>
                            <h3>Frequência</h3>
                            <p>Acompanhe suas presenças.</p>
                        </div>
                        <div class="card">
                            <a href="boletim.php">
                            <img src="../../assets/img/home/fotos/circulo_azul.png" alt="Boletim">
                            </a>
                            <h3>Boletim</h3>
                            <p>Visualize suas notas.</p>
                        </div>
                        <div class="card">
                            <a href="materiais.php">
                            <img src="../../assets/img/home/fotos/circulo_amarelo.png" alt="Disciplinas">
                            </a>
                            <h3>Disciplinas</h3>
                            <p>Veja suas disciplinas.</p>
                        </div>
                        <div class="card">
                            <a href="suporte.php">
                            <img src="../../assets/img/home/fotos/circulo_rosa.png" alt="Secretaria">
                            </a>
                            <h3>Secretaria</h3>
                            <p>Acesse serviços da secretaria.</p>
                        </div>
                    </div>

                    <!-- Calendário -->
                <div class="sections">
                    <div class="calendar">
                        <h3>Calendário</h3>
                        
                        <div class="calendar-header">
                            <button id="prevMonth">Anterior</button>
                            <h3 id="monthYear"></h3>
                            <button id="nextMonth">Próximo</button>
                        </div>
                        <div class="calendar-weekdays">
                            <div>Dom</div>
                            <div>Seg</div>
                            <div>Ter</div>
                            <div>Qua</div>
                            <div>Qui</div>
                            <div>Sex</div>
                            <div>Sáb</div>
                        </div>
                        <div class="calendar-days" id="calendarDays"></div>
                    </div>

                    <!-- Perfil do aluno -->
               
                    <div class="profile">
                        <h3>Dados Aluno</h3>
                        <img src="<?php echo $fotoCaminho;?>" alt="Perfil do Aluno">
                        <h2><?php echo htmlspecialchars($_SESSION['user']['nome']);?></h2>
                        <p>Curso: <?php echo htmlspecialchars($user['curso_id']);?></p>
                        <p>Matrícula: <?php echo htmlspecialchars($user['RM']);?></p>
                        <p>3º Semestre</p>
                        <p>Situação: <?php echo htmlspecialchars($_SESSION['user']['status'])?></p>
                        <p>Email: <?php echo htmlspecialchars($user['email']);?></p>
                    </div>

                    <!-- Notas e Desempenho -->
                  
                        <div class="section">
                            <h3>Notas e Desempenho</h3>
                            <p><span class="media">Sua média geral:</span><?= number_format($media, 2, ',', '.')?></p>
                            <p><span class="maior">Maior Nota:</span><?= number_format($maior_nota, 2, ',', '.')?></p>
                            <p><span class="menor">Menor Nota:</span><?= number_format($menor_nota, 2, ',', '.')?></p>
                        </div>

                        <!-- Tarefas Pendentes -->
                        <div class="section">
                            <h3>Tarefas Pendentes</h3>
                            <ul>
                                <?php if(!empty($atividades)): ?>
                                    <?php foreach($atividades as $atividade): ?>
                                <li><?= $atividade['descricao']?> <span>(entrega em <?= date('d/m/Y', strtotime($atividade['data'])) ?>)</span></li>
                                <li>Projeto de Banco de Dados <span>(entrega em 5 dias)</span></li>
                                <li>Revisão de Prova de Redes <span>(entrega em 1 semana)</span></li>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <li>Não há tarefas pendentes</li>
                                    <?php endif; ?>
                            </ul>
                        </div>

                        <!-- Horário de Aula -->
                        <div class="section">
                            <h3>Horário de Aula</h3>
                           <ul>
                            <?php if(!empty($horarios)): ?>
                                <?php foreach($horarios as $horario): ?>
                                    <li><?= $horario['disciplina']?> <span><?= $horario['hora_inicio']?> - <?= $horario['dia_semana']?></span></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li>Não há horários de aula</li>
                                    <?php endif; ?>
                           </ul>
                        </div>

                        <!-- Feed de atualizações recentes -->
                        <div class="feed">
                            <h3>Atualizações Recentes</h3>
                            <ul>
                                <?php if(!empty($atualizacoes)): ?>
                                    <?php foreach($atualizacoes as $atualizacao): ?>
                                        <li><?= $atualizacao['descricao']?> <span>(<?= date('d/m/Y', strtotime($atualizacao['data'])) ?>)</span></li>
                                     <?php endforeach; ?>
                                    <?php else: ?>
                                       <li>Não há atualizações recentes</li>
                                    <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                  
                </div>
            </main>

    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/aluno/home/menumobile.js"></script>
    <script src="../../assets/js/aluno/home/home.js"></script>
</body>
</html>