<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!--link href="https://fonts.googleapis.com/icon?family=Material+Icons+O+Symbols+Outlined"
      rel="stylesheet"-->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="shortcut icon" href="../../assets/imagens/icone_logo 1.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/scss/diretor/dashboard/dashboard.css">
</head>
<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <!-- <img src="../../assets/img/logo.jpg" alt="Logo"> -->
                    <h2>SA<span class="primary">M</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-symbols-outlined">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="#">
                    <span class="material-symbols-outlined">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="home_diretor.php" class="active">
                    <span class="material-symbols-outlined">person</span>
                    <h3>Home</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">
                        receipt_long
                        </span>
                    <h3>Pedidos</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">insights</span>
                    <h3>Métricas</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">mail_outline</span>
                    <h3>Mensagens</h3>
                    <span class="message-count">26</span>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">inventory</span>
                    <h3>Produtos</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">report_gmailerrorred</span>
                    <h3>Relatórios</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">settings</span>
                    <h3>Configurações</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">add</span>
                    <h3>Adicionar Produto</h3>
                </a>
                <a href="../../php/logout.php">
                    <span class="material-symbols-outlined">logout</span>
                    <h3>Sair</h3>
                </a>
            </div>
        </aside>

        <main>
            <h1>Dashboard</h1>

            <div class="date">
                <input type="date">
            </div>

            <div class="insights">
                <!-- Vendas -->
                <div class="sales">
                    <span class="material-symbols-outlined">
                        analytics
                        </span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total de Vendas</h3>
                                <h1>R$25.024</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="36"></circle>
                                </svg>
                                <div class="number">
                                    <p>81%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">Últimas 24 horas</small>
                </div>
                <!-- Despesas -->
                <div class="expenses">
                    <span class="material-symbols-outlined">
                        bar_chart
                        </span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total de Despesas</h3>
                                <h1>R$14.376</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="36"></circle>
                                </svg>
                                <div class="number">
                                    <p>62%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">Últimas 24 horas</small>
                </div>
                <!-- Renda -->
                <div class="income">
                    <span class="material-symbols-outlined">
                        stacked_line_chart
                        </span>
                        <div class="middle">
                            <div class="left">
                                <h3>Renda Total</h3>
                                <h1>R$10.864</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy="38" r="36"></circle>
                                </svg>
                                <div class="number">
                                    <p>44%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">Últimas 24 horas</small>
                </div>
            </div>
            <div class="recent-orders">
                <h2>Pedidos Recentes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome do Produto</th>
                            <th>Número do Produto</th>
                            <th>Pagamento</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 
                        <tr>
                            <td>Mini Drone Dobrável</td>
                            <td>85631</td>
                            <td>Vencido</td>
                            <td class="warning">Pendente</td>
                            <td class="primary">Detalhes</td>
                        </tr>
                        <tr>
                            <td>Mini Drone Dobrável</td>
                            <td>85631</td>
                            <td>Vencido</td>
                            <td class="warning">Pendente</td>
                            <td class="primary">Detalhes</td>
                        </tr>
                        <tr>
                            <td>Mini Drone Dobrável</td>
                            <td>85631</td>
                            <td>Vencido</td>
                            <td class="warning">Pendente</td>
                            <td class="primary">Detalhes</td>
                        </tr>
                        <tr>
                            <td>Mini Drone Dobrável</td>
                            <td>85631</td>
                            <td>Vencido</td>
                            <td class="warning">Pendente</td>
                            <td class="primary">Detalhes</td>
                        </tr>
                        <tr>
                            <td>Mini Drone Dobrável</td>
                            <td>85631</td>
                            <td>Vencido</td>
                            <td class="warning">Pendente</td>
                            <td class="primary">Detalhes</td>
                        </tr> 
                    -->
                    </tbody>
                </table>
            </div>
        </main>

        <!--Direita -->
        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class="material-symbols-outlined active">
                        light_mode
                        </span>
                    <span class="material-symbols-outlined">
                        dark_mode
                        </span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Olá, <b>Sandra</b></p>
                        <small class="text-muted">Administrador</small>
                    </div>
                    <div class="profile-photo">
                        <img src="../../assets/imagens/persona/coqui-chang-COP.jpg" alt="Imagem de Perfil">
                    </div>
                </div>
            </div>
            <div class="recent-updates">
                <h2>Atualizações Recentes</h2>
                <div class="updates">
                    <div class="update">
                        <div class="profile-photo">
                            <img src="../../assets/imagens/persona/christina-wocintechchat-com-0Zx1bDv5BNY-unsplash.jpg" alt="Imagem de Profile da Atualização">
                        </div>
                        <div class="message">
                            <p><b>Fulano</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <small class="text-muted">há 2 minutos</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile-photo">
                            <img src="../../assets/imagens/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="Imagem de Profile da Atualização">
                        </div>
                        <div class="message">
                            <p><b>Fulano</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <small class="text-muted">há 4 minutos</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile-photo">
                            <img src="../../assets/imagens/persona/jurica-koletic-7YVZYZeITc8-unsplash.jpg" alt="Imagem de Profile da Atualização">
                        </div>
                        <div class="message">
                            <p><b>Fulano</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <small class="text-muted">há 5 minutos</small>
                        </div>
                    </div>

                    <div class="update">
                        <div class="profile-photo">
                            <img src="../../assets/imagens/persona/linkedin-sales-solutions-pAtA8xe_iVM-unsplash.jpg" alt="Imagem de Profile da Atualização">
                        </div>
                        <div class="message">
                            <p><b>Fulano</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <small class="text-muted">há 7 minutos</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sales-analytics">
                <h2>Métricas</h2>
                <div class="item online">
                    <div class="icon">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>Pedidos Online</h3>
                            <small class="text-muted">últimas 24 horas</small>
                        </div>
                        <h5 class="success">+39%</h5>
                        <h3>3849</h3>
                    </div>
                </div>

                <div class="item offline">
                    <div class="icon">
                        <span class="material-symbols-outlined">local_mall</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>Pedidos Offline</h3>
                            <small class="text-muted">últimas 24 horas</small>
                        </div>
                        <h5 class="danger">-17%</h5>
                        <h3>1100</h3>
                    </div>
                </div>

                <div class="item customers">
                    <div class="icon">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>Novos Clientes</h3>
                            <small class="text-muted">últimas 24 horas</small>
                        </div>
                        <h5 class="success">+25%</h5>
                        <h3>849</h3>
                    </div>
                </div>
                <div class="item add-product">
                    <div>
                        <span class="material-symbols-outlined">add</span> 
                        <h3>Adicionar Produto</h3>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <script src="../../assets/js/dashboard/orders.js"></script>
    <script src="../../assets/js/dashboard/index.js"></script>
</body>
</html>