// Seleciona os elementos dos dropdowns
const notificationToggle = document.getElementById('notification-toggle');
const notificationContent = document.getElementById('notification-content');

const profileToggle = document.getElementById('profile-toggle');
const profileContent = document.getElementById('profile-content');

const settingsToggle = document.getElementById('settings-toggle');
const settingsContent = document.getElementById('settings-content');

const locationToggle = document.getElementById('location-toggle');
const locationContent = document.getElementById('location-content');

// Função para alternar a visibilidade dos dropdowns
function toggleDropdown(currentDropdown) {
    // Fecha todos os dropdowns
    document.querySelectorAll('.dropdown-content').forEach((dropdown) => {
        dropdown.classList.remove('show');
    });
    // Abre o dropdown atual
    currentDropdown.classList.toggle('show');
}

// Função para alternar sub-dropdowns
function toggleSubDropdown(currentSubDropdown) {
    const isOpen = currentSubDropdown.classList.contains('show');
    // Fecha todos os sub-dropdowns
    document.querySelectorAll('.sub-dropdown').forEach((subDropdown) => {
        subDropdown.classList.remove('show');
    });
    // Abre o sub-dropdown apenas se não estava aberto
    if (!isOpen) {
        currentSubDropdown.classList.add('show');
    }
}

// Abrir/fechar o dropdown de notificações
notificationToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleDropdown(notificationContent);
});

// Abrir/fechar o dropdown de perfil
profileToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleDropdown(profileContent);
});

// Abrir/fechar o sub-dropdown de Configurações
settingsToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleSubDropdown(settingsContent);
});

// Abrir/fechar o sub-dropdown de Localização
locationToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleSubDropdown(locationContent);
});

// Fecha todos os dropdowns ao clicar fora
document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-content').forEach((dropdown) => {
        dropdown.classList.remove('show');
    });
    document.querySelectorAll('.sub-dropdown').forEach((subDropdown) => {
        subDropdown.classList.remove('show');
    });
});
