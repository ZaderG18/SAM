//nav menu mobile

const showMenu = (toggleId, navId) =>{
    const toggle = document.getElementById(toggleId),
          nav = document.getElementById(navId)
 
    toggle.addEventListener('click', () =>{
        // Add show-menu class to nav menu
        nav.classList.toggle('show-menu')
 
        // Add show-icon to show and hide the menu icon
        toggle.classList.toggle('show-icon')
    })
 }
 showMenu('nav-toggle','nav-menu')


    // Alternar entre ícones de notificação
    function toggleNotification() {
        const noAlertIcon = document.getElementById('notificationNoAlert');
        const alertIcon = document.getElementById('notificationWithAlert');
        
        // Alterna entre os ícones
        noAlertIcon.classList.toggle('hidden');
        alertIcon.classList.toggle('hidden');
    }

    // Exibe o dropdown de notificações e remove o alerta ao abrir
    function toggleNotificationDropdown() {
        const dropdown = document.getElementById("notificationDropdown");
        dropdown.classList.toggle("show");

        // Remove o ícone de alerta ao abrir as notificações
        if (dropdown.classList.contains("show")) {
            toggleNotification();
        }

    }

    // Exibe o dropdown de perfil
    function toggleProfileDropdown() {
        const profileDropdown = document.getElementById("profileDropdown");
        profileDropdown.classList.toggle("show");
    }
        // Remove o ícone de alerta ao abrir as notificações
        if (dropdown.classList.contains("show")) {
            toggleNotification();
        }


    // Marcar todas como lidas (simulação)
    function markAllAsRead() {
        const unreadItems = document.querySelectorAll('.notification-item.unread');
        unreadItems.forEach(item => {
            item.classList.remove('unread');
            // Remove o fundo azul e deixa o texto normal ao marcar como lido
            item.style.fontWeight = "normal";
            item.style.backgroundColor = "#fff"; // Cor de fundo padrão (branco)
        });
    }

    // Fechar dropdowns ao clicar fora deles
    window.onclick = function(event) {
        if (!event.target.matches('.notification-icon') && !event.target.matches('.user-avatar')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }