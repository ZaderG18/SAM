<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
require '../../php/login/validar.php';

$user = $_SESSION['user'];
$id = $user['id'];

// Prepare SQL statement to retrieve photo
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

// Check if there is a photo for the user
if (!empty($fotoNome)) {
    $fotoCaminho = "../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../assets/img/logo.jpg"; // Default image if no photo is uploaded
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria</title>
                            <!-- CSS-->
    <link rel="stylesheet" href="../../assets/scss/aluno/suporte/suporte.css">
    <link rel="stylesheet" href="../../assets/scss/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/scss/global/header.css">
    <!-- <link rel="stylesheet" href="../../assets/scss/home/bottomnav.css"> -->
    <link rel="stylesheet" href="../../assets/scss/global/menumobile.css">
                            <!-- CSS-->
    <link rel="icon" href="../../assets/img/Group 4.png" type="image/png"> <!-- Ícone da aba do navegador -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!----- Box-icons ----->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
     

      <!------ REMIXICONS ----->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <header class="header"> 
        <div class="logo-sam"><img src="../../assets/img/Group 4.png" alt=""></div>
        <div class="box-search"><i class='bx bx-search'></i><input type="text" placeholder="Pesquisar"></div>
        <nav class="nav container" id="menu-mobile">
            <div class="nav__data">
               <div class="nav__toggle" id="nav-toggle">
                  <i class="ri-menu-line nav__burger"></i>
                  <i class="ri-close-line nav__close"></i>
               </div>
            </div>
            <!----- NAV MENU ----->
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                 <li><a href="home_aluno.php" class="nav__link"><img src="../../assets/img/home/icons/Inicio.svg" alt="" srcset="">Início</a></li>
                 <li><a href="chat.php" class="nav__link"><img src="../../assets/img/home/icons/Chat.svg" alt="" srcset="">Chat</a></li>
                 <li><a href="#" class="nav__link"><img src="../../assets/img/home/icons/Cronograma.svg" alt="" srcset="">Cronograma</a></li>
                 <li><a href="materiais.php" class="nav__link"><img src="../../assets/img/home/icons/Matérias.svg" alt="" srcset="">Matérias</a></li>
                 <li><a href="documentos.php" class="nav__link"><img src="../../assets/img/home/icons/Solicitação de Documentos.svg" alt="" srcset="">Solicitação de Documentos </a></li>
                 <li><a href="configuracoes.php" class="nav__link"><img src="../../assets/img/home/icons/Configurações.svg" alt="" srcset="">Configurações</a></li>
                 <li><a href="../../php/login/logout.php" class="nav__link"><img src="../../assets/img/home/icons/Sair.svg" alt="" srcset="">Sair</a></li>
             </div>
         </nav>
          </div>   

          <!--notificação-->
          <div class="notification-area">
            <div class="dropdown">
        <!-- Ícone de notificação com bolinha -->
        <img id="notificationWithAlert" src="../../assets/img/home/icons/notificação com bolinha.svg" alt="Notification Bell" class="notification-icon" onclick="toggleNotificationDropdown()">
        
        <!-- Ícone de notificação sem bolinha -->
        <img id="notificationNoAlert" src="../../assets/img/home/icons/Notificação.svg" alt="Notification Bell" class="notification-icon hidden" onclick="toggleNotificationDropdown()">
                
                <!-- Dropdown de notificações -->
                <div id="notificationDropdown" class="dropdown-content notification-dropdown">
                    <h3>Não Lidas <span><button onclick="markAllAsRead()">Todas lidas</button></span></h3>
                    <div class="notification-item unread">
                        <img src="../../assets/img/home/fotos/img_notificacao.png" alt="User" class="user-avatar-small">
                        <p>Julio Silva convidou você a <strong>arquivos</strong></p>
                        <span class="time">3 meses atrás</span>
                    </div>
                    <div class="notification-item unread">
                        <img src="../../assets/img/home/fotos/Usuário_Header.png" alt="User" class="user-avatar-small">
                        <p>Maria Silva convidou você a <strong>logo</strong></p>
                        <span class="time">2 meses atrás</span>
                    </div>
                </div>
            </div>
        </div>

            <!-- perfil-->

            <div class="dropdown">
               <img src="<?php echo $fotoCaminho;?>" alt="Perfil do Aluno" class="user-avatar"onclick="toggleProfileDropdown()">
                <div id="profileDropdown" class="dropdown-content profile-dropdown">
                    <div class="profile-info">
                        <img src="../../assets/img/home/fotos/Usuário_Header.png" alt="Profile Avatar" class="user-avatar-small">
                        <p>Nome: <?php echo htmlspecialchars($user['nome']); ?></p>
                        <p>RM: <?php echo htmlspecialchars($user['RM']); ?></p>
                    </div>
                    <div class="edit-profile">
                        <img src="../../assets/img/home/icons/icone_profile.svg" alt="Edit Icon">
                        <p><a href="configuracoes.php">Editar Perfil </a></p>
                    </div>
                </div>
            </div>
        </div>

    </header>

<!----- Sidebar ----->
    <div class="global-container">
        <aside>
            <div class="sidebar">
                        <!--aside bar-->
                        <nav id="sidebar">
                            <div id="sidebar_content">
                                <div id="user">
                                    <img src="../../assets/img/Group 4.png" id="user_avatar" alt="Avatar">
                        
                                    <p id="user_infos">
                                        <span class="item-description">
                                            SAM
                                        </span>
                                    </p>
                                </div>
                               <!----- Icone Home ------>
                                <ul id="side_items">
                                    <li class="side-item">
                                        <a href="home_aluno.php">
                                            <svg width="25" height="25" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.8889 6.01673L12.2222 0.763019C11.6111 0.271652 10.82 0 10 0C9.18011 0 8.38896 0.271652 7.77783 0.763019L1.11121 6.01673C0.758287 6.30047 0.476658 6.64853 0.285072 7.03776C0.0934866 7.42698 -0.00365837 7.84842 0.000105326 8.27403V17.0036C0.000105326 17.7983 0.351292 18.5604 0.976409 19.1224C1.60153 19.6843 2.44937 20 3.33341 20H16.6667C17.5507 20 18.3985 19.6843 19.0237 19.1224C19.6488 18.5604 20 17.7983 20 17.0036V8.26404C20.0021 7.84011 19.9042 7.42059 19.7127 7.0332C19.5212 6.6458 19.2404 6.29935 18.8889 6.01673ZM12.2222 18.0024H7.77783V13.0084C7.77783 12.7435 7.89489 12.4894 8.10326 12.3021C8.31163 12.1148 8.59425 12.0096 8.88893 12.0096H11.1111C11.4058 12.0096 11.6884 12.1148 11.8968 12.3021C12.1052 12.4894 12.2222 12.7435 12.2222 13.0084V18.0024ZM17.7778 17.0036C17.7778 17.2685 17.6607 17.5225 17.4523 17.7098C17.2439 17.8972 16.9613 18.0024 16.6667 18.0024H14.4444V13.0084C14.4444 12.2137 14.0933 11.4515 13.4681 10.8896C12.843 10.3276 11.9952 10.012 11.1111 10.012H8.88893C8.00488 10.012 7.15704 10.3276 6.53192 10.8896C5.90681 11.4515 5.55562 12.2137 5.55562 13.0084V18.0024H3.33341C3.03873 18.0024 2.75612 17.8972 2.54775 17.7098C2.33937 17.5225 2.22231 17.2685 2.22231 17.0036V8.26404C2.22251 8.12223 2.2563 7.98208 2.32144 7.85291C2.38658 7.72375 2.48157 7.60854 2.60009 7.51494L9.26671 2.27121C9.46947 2.11109 9.73014 2.02278 10 2.02278C10.2699 2.02278 10.5306 2.11109 10.7334 2.27121L17.4 7.51494C17.5185 7.60854 17.6135 7.72375 17.6786 7.85291C17.7438 7.98208 17.7776 8.12223 17.7778 8.26404V17.0036Z" fill="white"/>
                                              </svg>
                                            <span class="item-description">
                                                Início
                                            </span>
                                        </a>
                                    </li>
                                    <!----- Icone Chat ------->
                                    <li class="side-item">
                                        <a href="chat.php">
                                            <svg width="25" height="25" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.6115 17.1914C19.2378 16.3518 19.6676 15.3822 19.8692 14.3543C20.0708 13.3263 20.039 12.2662 19.7762 11.2522C19.5133 10.2382 19.0261 9.2961 18.3506 8.49554C17.675 7.69497 16.8283 7.05632 15.873 6.62673C15.6649 5.42943 15.1867 4.29532 14.4746 3.31057C13.7625 2.32581 12.8354 1.51633 11.7636 0.943619C10.6918 0.370908 9.50363 0.0500409 8.28927 0.00539774C7.07491 -0.0392454 5.86635 0.19351 4.75542 0.685978C3.64449 1.17845 2.66042 1.91767 1.87798 2.84748C1.09554 3.77729 0.535324 4.87323 0.239892 6.05201C-0.0555399 7.2308 -0.0784126 8.46142 0.173012 9.65037C0.424437 10.8393 0.943544 11.9553 1.69089 12.9136L0.301664 14.2929C0.162983 14.4334 0.0690394 14.6119 0.0316861 14.8058C-0.00566725 14.9997 0.0152438 15.2003 0.0917806 15.3823C0.166759 15.5649 0.294086 15.7211 0.457715 15.8314C0.621344 15.9417 0.813953 16.001 1.01127 16.002H6.6981C7.26443 17.196 8.15732 18.2052 9.27341 18.9127C10.3895 19.6203 11.6831 19.9973 13.0046 20H19.0012C19.1986 19.999 19.3912 19.9396 19.5548 19.8294C19.7184 19.7191 19.8458 19.5628 19.9207 19.3803C19.9973 19.1983 20.0182 18.9977 19.9808 18.8038C19.9435 18.6099 19.8495 18.4314 19.7108 18.2909L18.6115 17.1914ZM6.00848 13.0035C6.00986 13.3382 6.03659 13.6724 6.08844 14.003H3.41993L3.76973 13.6632C3.86341 13.5703 3.93776 13.4597 3.9885 13.3379C4.03924 13.2161 4.06537 13.0855 4.06537 12.9535C4.06537 12.8216 4.03924 12.691 3.9885 12.5692C3.93776 12.4474 3.86341 12.3368 3.76973 12.2439C3.2096 11.6899 2.76554 11.0298 2.46351 10.3021C2.16148 9.57445 2.00755 8.79388 2.01071 8.00603C2.01071 6.41554 2.6425 4.89018 3.76709 3.76553C4.89168 2.64088 6.41696 2.00905 8.00737 2.00905C9.24836 2.00159 10.4605 2.38325 11.4734 3.10037C12.4862 3.81749 13.2489 4.83401 13.6542 6.00704C13.4343 6.00704 13.2245 6.00704 13.0046 6.00704C11.1491 6.00704 9.36962 6.74417 8.0576 8.05626C6.74557 9.36836 6.00848 11.1479 6.00848 13.0035ZM16.5426 18.001L16.5926 18.051H13.0046C11.8486 18.0489 10.729 17.6461 9.83667 16.9112C8.94432 16.1762 8.33436 15.1546 8.11071 14.0204C7.88706 12.8861 8.06355 11.7094 8.61011 10.6907C9.15667 9.672 10.0395 8.87431 11.1082 8.43352C12.1769 7.99273 13.3653 7.93612 14.4711 8.27333C15.5768 8.61054 16.5315 9.3207 17.1724 10.2828C17.8133 11.245 18.1008 12.3996 17.986 13.5499C17.8712 14.7003 17.3611 15.7753 16.5426 16.5917C16.3543 16.7763 16.2465 17.0277 16.2428 17.2914C16.2433 17.4236 16.2701 17.5544 16.3216 17.6762C16.3731 17.7981 16.4482 17.9084 16.5426 18.001Z" fill="white"/>
                                                </svg>  
                                            <span class="item-description">
                                                Chat
                                            </span>
                                        </a>
                                    <!----- Icone Cronograma ----->
                                    </li>
                                    <li class="side-item">
                                        <a href="#">
                                            <svg width="25" height="25" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 16.3636C10.1978 16.3636 10.3911 16.3103 10.5556 16.2104C10.72 16.1105 10.8482 15.9686 10.9239 15.8024C10.9996 15.6363 11.0194 15.4535 10.9808 15.2772C10.9422 15.1008 10.847 14.9389 10.7071 14.8117C10.5673 14.6846 10.3891 14.598 10.1951 14.5629C10.0011 14.5278 9.80004 14.5458 9.61732 14.6147C9.43459 14.6835 9.27841 14.8 9.16853 14.9495C9.05865 15.099 9 15.2747 9 15.4545C9 15.6957 9.10536 15.9269 9.29289 16.0974C9.48043 16.2679 9.73478 16.3636 10 16.3636ZM15 16.3636C15.1978 16.3636 15.3911 16.3103 15.5556 16.2104C15.72 16.1105 15.8482 15.9686 15.9239 15.8024C15.9996 15.6363 16.0194 15.4535 15.9808 15.2772C15.9422 15.1008 15.847 14.9389 15.7071 14.8117C15.5673 14.6846 15.3891 14.598 15.1951 14.5629C15.0011 14.5278 14.8 14.5458 14.6173 14.6147C14.4346 14.6835 14.2784 14.8 14.1685 14.9495C14.0586 15.099 14 15.2747 14 15.4545C14 15.6957 14.1054 15.9269 14.2929 16.0974C14.4804 16.2679 14.7348 16.3636 15 16.3636ZM15 12.7273C15.1978 12.7273 15.3911 12.674 15.5556 12.5741C15.72 12.4742 15.8482 12.3322 15.9239 12.1661C15.9996 12 16.0194 11.8172 15.9808 11.6408C15.9422 11.4645 15.847 11.3025 15.7071 11.1754C15.5673 11.0482 15.3891 10.9616 15.1951 10.9266C15.0011 10.8915 14.8 10.9095 14.6173 10.9783C14.4346 11.0471 14.2784 11.1636 14.1685 11.3131C14.0586 11.4626 14 11.6384 14 11.8182C14 12.0593 14.1054 12.2905 14.2929 12.461C14.4804 12.6315 14.7348 12.7273 15 12.7273ZM10 12.7273C10.1978 12.7273 10.3911 12.674 10.5556 12.5741C10.72 12.4742 10.8482 12.3322 10.9239 12.1661C10.9996 12 11.0194 11.8172 10.9808 11.6408C10.9422 11.4645 10.847 11.3025 10.7071 11.1754C10.5673 11.0482 10.3891 10.9616 10.1951 10.9266C10.0011 10.8915 9.80004 10.9095 9.61732 10.9783C9.43459 11.0471 9.27841 11.1636 9.16853 11.3131C9.05865 11.4626 9 11.6384 9 11.8182C9 12.0593 9.10536 12.2905 9.29289 12.461C9.48043 12.6315 9.73478 12.7273 10 12.7273ZM17 1.81818H16V0.909091C16 0.667985 15.8946 0.436754 15.7071 0.266267C15.5196 0.0957789 15.2652 0 15 0C14.7348 0 14.4804 0.0957789 14.2929 0.266267C14.1054 0.436754 14 0.667985 14 0.909091V1.81818H6V0.909091C6 0.667985 5.89464 0.436754 5.70711 0.266267C5.51957 0.0957789 5.26522 0 5 0C4.73478 0 4.48043 0.0957789 4.29289 0.266267C4.10536 0.436754 4 0.667985 4 0.909091V1.81818H3C2.20435 1.81818 1.44129 2.10552 0.87868 2.61698C0.316071 3.12844 0 3.82214 0 4.54545V17.2727C0 17.996 0.316071 18.6897 0.87868 19.2012C1.44129 19.7127 2.20435 20 3 20H17C17.7956 20 18.5587 19.7127 19.1213 19.2012C19.6839 18.6897 20 17.996 20 17.2727V4.54545C20 3.82214 19.6839 3.12844 19.1213 2.61698C18.5587 2.10552 17.7956 1.81818 17 1.81818ZM18 17.2727C18 17.5138 17.8946 17.7451 17.7071 17.9156C17.5196 18.086 17.2652 18.1818 17 18.1818H3C2.73478 18.1818 2.48043 18.086 2.29289 17.9156C2.10536 17.7451 2 17.5138 2 17.2727V9.09091H18V17.2727ZM18 7.27273H2V4.54545C2 4.30435 2.10536 4.07312 2.29289 3.90263C2.48043 3.73214 2.73478 3.63636 3 3.63636H4V4.54545C4 4.78656 4.10536 5.01779 4.29289 5.18828C4.48043 5.35877 4.73478 5.45455 5 5.45455C5.26522 5.45455 5.51957 5.35877 5.70711 5.18828C5.89464 5.01779 6 4.78656 6 4.54545V3.63636H14V4.54545C14 4.78656 14.1054 5.01779 14.2929 5.18828C14.4804 5.35877 14.7348 5.45455 15 5.45455C15.2652 5.45455 15.5196 5.35877 15.7071 5.18828C15.8946 5.01779 16 4.78656 16 4.54545V3.63636H17C17.2652 3.63636 17.5196 3.73214 17.7071 3.90263C17.8946 4.07312 18 4.30435 18 4.54545V7.27273ZM5 12.7273C5.19778 12.7273 5.39112 12.674 5.55557 12.5741C5.72002 12.4742 5.84819 12.3322 5.92388 12.1661C5.99957 12 6.01937 11.8172 5.98079 11.6408C5.9422 11.4645 5.84696 11.3025 5.70711 11.1754C5.56725 11.0482 5.38907 10.9616 5.19509 10.9266C5.00111 10.8915 4.80004 10.9095 4.61732 10.9783C4.43459 11.0471 4.27841 11.1636 4.16853 11.3131C4.05865 11.4626 4 11.6384 4 11.8182C4 12.0593 4.10536 12.2905 4.29289 12.461C4.48043 12.6315 4.73478 12.7273 5 12.7273ZM5 16.3636C5.19778 16.3636 5.39112 16.3103 5.55557 16.2104C5.72002 16.1105 5.84819 15.9686 5.92388 15.8024C5.99957 15.6363 6.01937 15.4535 5.98079 15.2772C5.9422 15.1008 5.84696 14.9389 5.70711 14.8117C5.56725 14.6846 5.38907 14.598 5.19509 14.5629C5.00111 14.5278 4.80004 14.5458 4.61732 14.6147C4.43459 14.6835 4.27841 14.8 4.16853 14.9495C4.05865 15.099 4 15.2747 4 15.4545C4 15.6957 4.10536 15.9269 4.29289 16.0974C4.48043 16.2679 4.73478 16.3636 5 16.3636Z" fill="white"/>
                                                </svg>
                                            <span class="item-description">
                                                Cronograma
                                            </span>
                                        </a>
                                    <!----- Icone Matérias ----->
                                    </li>
                                    <li class="side-item">
                                        <a href="materiais.php">
                                            <svg width="25" height="25" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.0645 2.6087H17.7419V1.73913C17.7419 0.78 17.1632 0 16.4516 0H12.9032C11.881 0 10.8665 0.396087 10 1.12304C9.13355 0.396087 8.11903 0 7.09677 0H3.54839C2.83677 0 2.25806 0.78 2.25806 1.73913V2.6087H1.93548C0.868064 2.6087 0 3.7787 0 5.21739V17.3913C0 18.83 0.868064 20 1.93548 20H18.0645C19.1319 20 20 18.83 20 17.3913V5.21739C20 3.7787 19.1319 2.6087 18.0645 2.6087ZM16.4516 1.73913V15.2174H12.9032C12.1255 15.2174 11.3523 15.4461 10.6452 15.8752V2.6287C11.3161 2.05261 12.1065 1.73913 12.9032 1.73913H16.4516ZM3.54839 1.73913H7.09677C7.89355 1.73913 8.68387 2.05261 9.35484 2.6287V15.8752C8.64774 15.4461 7.87452 15.2174 7.09677 15.2174H3.54839V1.73913ZM1.29032 17.3913V5.21739C1.29032 4.73783 1.57968 4.34783 1.93548 4.34783H2.25806V15.2174C2.25806 16.1765 2.83677 16.9565 3.54839 16.9565H7.09677C7.89355 16.9565 8.68387 17.2713 9.35484 17.8478V18.2609H1.93548C1.57968 18.2609 1.29032 17.8709 1.29032 17.3913ZM18.7097 17.3913C18.7097 17.8709 18.4203 18.2609 18.0645 18.2609H10.6452V17.8478C11.3161 17.2713 12.1065 16.9565 12.9032 16.9565H16.4516C17.1632 16.9565 17.7419 16.1765 17.7419 15.2174V4.34783H18.0645C18.4203 4.34783 18.7097 4.73783 18.7097 5.21739V17.3913Z" fill="white"/>
                                                <path d="M5.16176 4.78259H7.74241C8.09854 4.78259 8.38757 4.39302 8.38757 3.91302C8.38757 3.43302 8.09854 3.04346 7.74241 3.04346H5.16176C4.80563 3.04346 4.5166 3.43302 4.5166 3.91302C4.5166 4.39302 4.80563 4.78259 5.16176 4.78259ZM5.16176 8.26085H7.74241C8.09854 8.26085 8.38757 7.87128 8.38757 7.39128C8.38757 6.91128 8.09854 6.52172 7.74241 6.52172H5.16176C4.80563 6.52172 4.5166 6.91128 4.5166 7.39128C4.5166 7.87128 4.80563 8.26085 5.16176 8.26085ZM8.38757 10.8695C8.38757 10.3895 8.09854 9.99998 7.74241 9.99998H5.16176C4.80563 9.99998 4.5166 10.3895 4.5166 10.8695C4.5166 11.3495 4.80563 11.7391 5.16176 11.7391H7.74241C8.09854 11.7391 8.38757 11.3495 8.38757 10.8695ZM12.2585 4.78259H14.8392C15.1953 4.78259 15.4843 4.39302 15.4843 3.91302C15.4843 3.43302 15.1953 3.04346 14.8392 3.04346H12.2585C11.9024 3.04346 11.6134 3.43302 11.6134 3.91302C11.6134 4.39302 11.9024 4.78259 12.2585 4.78259ZM12.2585 8.26085H14.8392C15.1953 8.26085 15.4843 7.87128 15.4843 7.39128C15.4843 6.91128 15.1953 6.52172 14.8392 6.52172H12.2585C11.9024 6.52172 11.6134 6.91128 11.6134 7.39128C11.6134 7.87128 11.9024 8.26085 12.2585 8.26085ZM12.2585 11.7391H14.8392C15.1953 11.7391 15.4843 11.3495 15.4843 10.8695C15.4843 10.3895 15.1953 9.99998 14.8392 9.99998H12.2585C11.9024 9.99998 11.6134 10.3895 11.6134 10.8695C11.6134 11.3495 11.9024 11.7391 12.2585 11.7391Z" fill="white"/>
                                                </svg>  
                                            <span class="item-description">
                                                Matérias
                                            </span>
                                        </a>
                                    <!----Icone Solicitação de Documentos---->
                                    </li>
                                    <li class="side-item">
                                        <a href="documentos.php">
                                            <svg width="25" height="25" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.42857 17.5H2.85714V18.75C2.85714 19.0815 3.00765 19.3995 3.27556 19.6339C3.54347 19.8683 3.90683 20 4.28571 20H18.5714C18.9503 20 19.3137 19.8683 19.5816 19.6339C19.8495 19.3995 20 19.0815 20 18.75V3.75C20 3.41848 19.8495 3.10054 19.5816 2.86612C19.3137 2.6317 18.9503 2.5 18.5714 2.5H17.1429V1.25C17.1429 0.918479 16.9923 0.600537 16.7244 0.366117C16.4565 0.131696 16.0932 0 15.7143 0L1.42857 0C1.04969 0 0.686328 0.131696 0.418419 0.366117C0.15051 0.600537 0 0.918479 0 1.25V16.25C0 16.5815 0.15051 16.8995 0.418419 17.1339C0.686328 17.3683 1.04969 17.5 1.42857 17.5ZM15.7143 16.25H1.42857V1.25H15.7143V16.25ZM18.5714 3.75V18.75H4.28571V17.5H15.7143C16.0932 17.5 16.4565 17.3683 16.7244 17.1339C16.9923 16.8995 17.1429 16.5815 17.1429 16.25V3.75H18.5714ZM5.71429 4.375C5.71429 4.54076 5.78954 4.69973 5.9235 4.81694C6.05745 4.93415 6.23913 5 6.42857 5H13.5714C13.7609 5 13.9426 4.93415 14.0765 4.81694C14.2105 4.69973 14.2857 4.54076 14.2857 4.375C14.2857 4.20924 14.2105 4.05027 14.0765 3.93306C13.9426 3.81585 13.7609 3.75 13.5714 3.75H6.42857C6.23913 3.75 6.05745 3.81585 5.9235 3.93306C5.78954 4.05027 5.71429 4.20924 5.71429 4.375ZM3.57143 8.75H13.5714C13.7609 8.75 13.9426 8.68415 14.0765 8.56694C14.2105 8.44973 14.2857 8.29076 14.2857 8.125C14.2857 7.95924 14.2105 7.80027 14.0765 7.68306C13.9426 7.56585 13.7609 7.5 13.5714 7.5H3.57143C3.38199 7.5 3.20031 7.56585 3.06635 7.68306C2.9324 7.80027 2.85714 7.95924 2.85714 8.125C2.85714 8.29076 2.9324 8.44973 3.06635 8.56694C3.20031 8.68415 3.38199 8.75 3.57143 8.75ZM3.57143 11.25H13.5714C13.7609 11.25 13.9426 11.1842 14.0765 11.0669C14.2105 10.9497 14.2857 10.7908 14.2857 10.625C14.2857 10.4592 14.2105 10.3003 14.0765 10.1831C13.9426 10.0658 13.7609 10 13.5714 10H3.57143C3.38199 10 3.20031 10.0658 3.06635 10.1831C2.9324 10.3003 2.85714 10.4592 2.85714 10.625C2.85714 10.7908 2.9324 10.9497 3.06635 11.0669C3.20031 11.1842 3.38199 11.25 3.57143 11.25ZM3.57143 13.75H13.5714C13.7609 13.75 13.9426 13.6842 14.0765 13.5669C14.2105 13.4497 14.2857 13.2908 14.2857 13.125C14.2857 12.9592 14.2105 12.8003 14.0765 12.6831C13.9426 12.5658 13.7609 12.5 13.5714 12.5H3.57143C3.38199 12.5 3.20031 12.5658 3.06635 12.6831C2.9324 12.8003 2.85714 12.9592 2.85714 13.125C2.85714 13.2908 2.9324 13.4497 3.06635 13.5669C3.20031 13.6842 3.38199 13.75 3.57143 13.75Z" fill="white"/>
                                                </svg>              
                                                <span class="item-description">
                                                    Solicitação de Documentos
                                            </span>
                                        </a>
                                    <!---Icone Configurações -->
                                    </li>
                                    <li class="side-item">
                                        <a href="configuracoes.php">
                                            <svg width="25" height="25" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.9056 11.0667C18.8308 11.0233 18.7706 10.9602 18.7323 10.885C18.6939 10.8098 18.6791 10.7256 18.6894 10.6425C18.7068 10.4317 18.7164 10.2167 18.7164 10C18.7164 9.78333 18.7068 9.56833 18.6894 9.35583C18.6792 9.273 18.6941 9.1891 18.7325 9.11417C18.7708 9.03925 18.8309 8.97646 18.9056 8.93333C19.4079 8.65535 19.7745 8.19823 19.9248 7.66225C20.0751 7.12626 19.997 6.55515 19.7075 6.07417L18.4087 3.925C18.1162 3.44535 17.6366 3.09617 17.0752 2.95402C16.5137 2.81187 15.9163 2.88834 15.4137 3.16667C15.3424 3.20691 15.2605 3.22666 15.1778 3.22355C15.0951 3.22045 15.0151 3.19462 14.9474 3.14917C14.5625 2.89628 14.1571 2.67334 13.7349 2.4825C13.6584 2.44772 13.5942 2.3924 13.5501 2.32328C13.5059 2.25417 13.4838 2.17426 13.4865 2.09333C13.4858 1.53835 13.2549 1.00629 12.8444 0.613854C12.4339 0.221421 11.8774 0.000661614 11.2968 0L8.70278 0C8.12105 0.00110408 7.5636 0.223035 7.15299 0.616994C6.74238 1.01095 6.51224 1.54469 6.51316 2.10083C6.51334 2.17956 6.49018 2.25673 6.44637 2.32339C6.40255 2.39006 6.33988 2.44349 6.26561 2.4775C5.84306 2.66815 5.43729 2.89109 5.05226 3.14417C4.98345 3.18968 4.9024 3.21529 4.81878 3.21795C4.73516 3.22061 4.65251 3.2002 4.58069 3.15917C4.0778 2.88189 3.48034 2.8068 2.91958 2.9504C2.35881 3.09399 1.88061 3.44453 1.59002 3.925L0.292113 6.07417C0.00262298 6.55515 -0.0755253 7.12626 0.0748067 7.66225C0.225139 8.19823 0.591679 8.65535 1.09404 8.93333C1.16886 8.97674 1.22903 9.03982 1.26736 9.11503C1.30569 9.19025 1.32057 9.27442 1.31021 9.3575C1.29278 9.56833 1.28319 9.78333 1.28319 10C1.28319 10.2167 1.29278 10.4317 1.31021 10.6442C1.32044 10.727 1.30549 10.8109 1.26715 10.8858C1.22882 10.9608 1.16872 11.0235 1.09404 11.0667C0.591679 11.3447 0.225139 11.8018 0.0748067 12.3378C-0.0755253 12.8737 0.00262298 13.4449 0.292113 13.9258L1.59089 16.075C1.88257 16.5555 2.36182 16.9057 2.92338 17.0487C3.48494 17.1917 4.0829 17.1157 4.58592 16.8375C4.65712 16.7971 4.73904 16.7772 4.8218 16.7803C4.90455 16.7834 4.98459 16.8093 5.05226 16.855C5.4371 17.1079 5.84257 17.3308 6.26474 17.5217C6.34053 17.5562 6.40429 17.6108 6.44836 17.6791C6.49243 17.7474 6.51493 17.8264 6.51316 17.9067C6.51386 18.4617 6.74477 18.9937 7.15525 19.3861C7.56573 19.7786 8.12227 19.9993 8.70278 20H11.2968C11.8786 19.9989 12.436 19.777 12.8466 19.383C13.2572 18.989 13.4874 18.4553 13.4865 17.8992C13.4863 17.8204 13.5094 17.7433 13.5533 17.6766C13.5971 17.6099 13.6597 17.5565 13.734 17.5225C14.1566 17.3319 14.5623 17.1089 14.9474 16.8558C15.0162 16.8103 15.0972 16.7847 15.1808 16.782C15.2645 16.7794 15.3471 16.7998 15.4189 16.8408C15.922 17.1174 16.5192 17.1922 17.0798 17.0486C17.6403 16.9051 18.1185 16.555 18.4096 16.075L19.7075 13.9267C19.9973 13.4456 20.0756 12.8743 19.9252 12.3381C19.7749 11.8019 19.4082 11.3447 18.9056 11.0667ZM16.9731 10C16.9731 10.1708 16.9653 10.34 16.9513 10.5067C16.9166 10.9036 16.9998 11.3019 17.1913 11.6557C17.3828 12.0095 17.6749 12.3045 18.0339 12.5067C18.0847 12.5347 18.1292 12.5721 18.1649 12.6166C18.2006 12.6611 18.2268 12.7119 18.2419 12.766C18.257 12.8202 18.2609 12.8767 18.2531 12.9323C18.2454 12.9879 18.2263 13.0415 18.1969 13.09L16.9008 15.2383C16.8403 15.3365 16.7415 15.4077 16.6261 15.4363C16.5107 15.4649 16.3881 15.4486 16.2854 15.3908C15.9278 15.1953 15.5199 15.1 15.1083 15.1158C14.6967 15.1315 14.2981 15.2578 13.958 15.48C13.6501 15.6825 13.3257 15.8612 12.9879 16.0142C12.6147 16.1851 12.2998 16.4536 12.0795 16.7885C11.8593 17.1234 11.7426 17.5111 11.7431 17.9067C11.7431 18.0198 11.6961 18.1283 11.6124 18.2084C11.5287 18.2884 11.4152 18.3333 11.2968 18.3333H8.70278C8.64357 18.3331 8.585 18.3217 8.53044 18.2997C8.47588 18.2777 8.42642 18.2456 8.38492 18.2052C8.34342 18.1649 8.31071 18.117 8.28866 18.0645C8.26662 18.012 8.25568 17.9558 8.25649 17.8992C8.25545 17.5051 8.13798 17.1193 7.91761 16.7862C7.69723 16.4532 7.38292 16.1864 7.01088 16.0167C6.67348 15.8635 6.34936 15.6849 6.0416 15.4825C5.70044 15.2601 5.30052 15.1343 4.88787 15.1195C4.47522 15.1048 4.0666 15.2017 3.70903 15.3992C3.60646 15.4557 3.48463 15.4711 3.37025 15.4418C3.25587 15.4126 3.15827 15.3412 3.09886 15.2433L1.80619 13.0933C1.74705 12.9953 1.731 12.8788 1.76155 12.7695C1.79211 12.6601 1.86678 12.5668 1.96919 12.51C2.32822 12.3078 2.62027 12.0129 2.81179 11.6591C3.0033 11.3053 3.08649 10.907 3.05179 10.51C3.03436 10.34 3.02652 10.1708 3.02652 10C3.02652 9.82917 3.03436 9.66 3.04831 9.49333C3.083 9.09635 2.99981 8.69807 2.8083 8.34427C2.61679 7.99047 2.32473 7.69552 1.9657 7.49333C1.91491 7.46529 1.87039 7.42795 1.83471 7.38344C1.79902 7.33894 1.77286 7.28815 1.75772 7.23397C1.74258 7.17979 1.73876 7.12329 1.74648 7.0677C1.7542 7.01211 1.7733 6.95852 1.8027 6.91L3.09886 4.75917C3.12857 4.7103 3.16812 4.66755 3.21522 4.63339C3.26233 4.59923 3.31605 4.57434 3.37328 4.56015C3.43051 4.54597 3.49011 4.54278 3.54864 4.55076C3.60717 4.55875 3.66346 4.57775 3.71426 4.60667C4.07176 4.80236 4.47971 4.8978 4.89134 4.88203C5.30297 4.86626 5.70162 4.73992 6.0416 4.5175C6.34954 4.31496 6.67397 4.13634 7.01175 3.98333C7.38451 3.81253 7.69915 3.54446 7.9194 3.21005C8.13964 2.87564 8.25649 2.48851 8.25649 2.09333C8.25649 1.98017 8.30351 1.87165 8.3872 1.79163C8.4709 1.71162 8.58442 1.66667 8.70278 1.66667H11.2968C11.3561 1.66688 11.4146 1.67831 11.4692 1.7003C11.5237 1.72229 11.5732 1.7544 11.6147 1.79477C11.6562 1.83514 11.6889 1.88298 11.711 1.93551C11.733 1.98804 11.7439 2.04423 11.7431 2.10083C11.7442 2.49493 11.8616 2.88073 12.082 3.21379C12.3024 3.54685 12.6167 3.8136 12.9887 3.98333C13.3261 4.13653 13.6503 4.31514 13.958 4.5175C14.2993 4.73974 14.6992 4.86545 15.1118 4.88019C15.5244 4.89493 15.933 4.7981 16.2906 4.60083C16.3932 4.54429 16.515 4.52895 16.6294 4.55816C16.7438 4.58737 16.8414 4.65876 16.9008 4.75667L18.1934 6.90667C18.2526 7.00472 18.2686 7.1212 18.2381 7.23055C18.2075 7.3399 18.1328 7.4332 18.0304 7.49C17.6714 7.69219 17.3793 7.98714 17.1878 8.34094C16.9963 8.69473 16.9131 9.09302 16.9478 9.49C16.9653 9.66 16.9731 9.83333 16.9731 10Z" fill="white"/>
                                                <path d="M9.99991 5.8335C9.13792 5.8335 8.29529 6.07787 7.57857 6.53571C6.86185 6.99355 6.30323 7.64429 5.97336 8.40565C5.64349 9.16701 5.55718 10.0048 5.72535 10.813C5.89351 11.6213 6.3086 12.3637 6.91812 12.9464C7.52764 13.5292 8.30422 13.926 9.14965 14.0868C9.99508 14.2475 10.8714 14.165 11.6678 13.8497C12.4641 13.5343 13.1448 13.0002 13.6237 12.315C14.1026 11.6298 14.3582 10.8243 14.3582 10.0002C14.3568 8.8955 13.8972 7.83646 13.0802 7.05535C12.2631 6.27423 11.1554 5.83482 9.99991 5.8335ZM9.99991 12.5002C9.48272 12.5002 8.97714 12.3535 8.5471 12.0788C8.11707 11.8041 7.7819 11.4137 7.58398 10.9569C7.38606 10.5001 7.33427 9.99739 7.43517 9.51244C7.53607 9.02748 7.78513 8.58203 8.15084 8.2324C8.51655 7.88276 8.9825 7.64466 9.48975 7.5482C9.99701 7.45174 10.5228 7.50124 11.0006 7.69046C11.4785 7.87968 11.8869 8.20011 12.1742 8.61124C12.4615 9.02236 12.6149 9.50571 12.6149 10.0002C12.6149 10.6632 12.3394 11.2991 11.849 11.7679C11.3586 12.2368 10.6935 12.5002 9.99991 12.5002Z" fill="white"/>
                                                </svg>                                                
                                            <span class="item-description">
                                                Configurações
                                            </span>
                                        </a>
                                    </li>
                                  <!---Icone Sidebar abrir e fechar-->
                                <button id="open_btn">
                                    <i id="open_btn_icon" class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                                 <!---Icone Sair---->
                            <div id="logout">
                                <button id="logout_btn" onclick="window.location.href='../../php/login/logout.php'">
                                    <svg width="25" height="25" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.25 0C17.2446 0 18.1984 0.395088 18.9016 1.09835C19.6049 1.80161 20 2.75544 20 3.75V16.25C20 17.2446 19.6049 18.1984 18.9016 18.9016C18.1984 19.6049 17.2446 20 16.25 20H3.75C2.75544 20 1.80161 19.6049 1.09835 18.9016C0.395089 18.1984 4.98359e-07 17.2446 4.98359e-07 16.25V14.0512L1.09875 15.15C1.5 15.5512 1.98 15.8375 2.5 16.0212V16.25C2.5 16.5815 2.6317 16.8995 2.86612 17.1339C3.10054 17.3683 3.41848 17.5 3.75 17.5H16.25C16.9412 17.5 17.5 16.9412 17.5 16.25V3.75C17.5 3.41848 17.3683 3.10054 17.1339 2.86612C16.8995 2.6317 16.5815 2.5 16.25 2.5H3.75C3.06 2.5 2.5 3.06 2.5 3.75V3.9775C1.98125 4.16125 1.50125 4.44625 1.09875 4.8475L4.98359e-07 5.94625V3.75C4.98359e-07 2.75544 0.395089 1.80161 1.09835 1.09835C1.80161 0.395088 2.75544 0 3.75 0L16.25 0ZM4.22875 6.34375C4.45704 6.43852 4.65214 6.59881 4.7894 6.80437C4.92667 7.00994 4.99995 7.25157 5 7.49875V8.75H8.75C9.08152 8.75 9.39946 8.8817 9.63388 9.11612C9.8683 9.35054 10 9.66848 10 10C10 10.6912 9.44125 11.25 8.75 11.25H5V12.4987C5 13.0037 4.695 13.4613 4.22875 13.6538C4.00019 13.7478 3.74892 13.7723 3.50651 13.724C3.2641 13.6758 3.04136 13.5569 2.86625 13.3825L0.36625 10.8825C0.250021 10.7666 0.157835 10.6288 0.0949838 10.4772C0.0321325 10.3255 -0.000146284 10.1629 4.98359e-07 9.99875C4.98359e-07 9.67875 0.122501 9.35875 0.36625 9.115L2.86625 6.615C3.04121 6.44032 3.26396 6.32135 3.50643 6.27308C3.7489 6.22481 4.00023 6.2494 4.22875 6.34375Z" fill="white"/>
                                        </svg>
                                    <span class="item-description">
                                        Sair
                                    </span>
                                 </button>
                                </div>
                        </nav>
            </div>
        </aside>

                   <!---Conteúdo da página---->
                  
            <main> 
               <div class="containerbx">
                    <div class="containerpx">
                        <div class="secretaria">
                            <h2>Horário de atendimento</h2>
                            <p>Segunda-feira a sexta-feira das 9h-13h e das 15h as 20h</p>
                        </div>

                        <div class="secretaria">
                            <h2>Prazo para entrega de Documentos</h2>
                            <p>Declarações: 48hrs</p>
                            <p>Transferências: 48hrs</p>
                            <p>Históricos: 15 dias</p>
                        </div>

                        <div class="secretaria">
                            <h2>Comunicados de Rematrícula</h2>
                            <p> Prezados Pais, Responsáveis e Alunos,

                                Informamos que o período de Rematrícula para 2024 acontecerá de (data de início) a (data de término). As rematrículas podem ser feitas online por aqui ou presencialmente na secretaria da escola.
                                
                                Não deixe para a última hora! Garanta sua vaga e atualize seus dados dentro do prazo.
                                
                                Para mais informações, entre em contato pelo e-mail [e-mail da escola] ou telefone [número de contato].
                                
                                Atenciosamente,
                                [Nome da Escola]
                            </p>
                        </div>
                    </div> 
                        
                    
                    <div class="form-container">
                        <h2>Formulário de ajuda</h2>
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nome-completo">Nome Completo:</label>
                                <input type="text" id="nome-completo" name="nome-completo" class = "caixa" required>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone:</label>
                                <input type="tel" id="telefone" name="telefone" class = "caixa" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class = "caixa" required>
                            </div>
                            <div class="form-group">
                                <label for="rm">RM:</label>
                                <input type="text" id="rm" name="rm" class = "caixa" required>
                            </div>
                            <div class="form-group">
                                <label for="curso">Curso:</label>
                                <select id="curso" name="curso" class = "caixa" required>
                                    <option value="">Selecione o curso</option>
                                    <option value="curso1">Desenvolvimento de sistemas</option>
                                    <option value="curso2">Nutrição</option>
                                    <option value="curso3">Gastronomia</option>
                                    <option value="curso4">Enfermagem</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="mensagem">Mensagem:</label>
                                <textarea id="mensagem" name="mensagem" rows="4" class="textarea" required></textarea>
                            </div>
                            <div class="file-group">
                                <label for="arquivo">Envio de Arquivos:</label>
                                <input type="file" id="arquivo" name="arquivo" class="btn-upload">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn">Enviar</button>
                            </div>
                        </form>
                    </div>
            
                </div> 
            </main>

    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/home/bottomnav.js"></script>
    <script src="../../assets/js/aluno/home/menumobile.js"></script>
    <script src="../../assets/js/aluno/suporte/suporte.js"></script>
</body>
</html>