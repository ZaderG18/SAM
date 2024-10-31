const navLinks = document.querySelectorAll('.nav_link');

navLinks.forEach(link => {
    link.addEventListener('click', function () {
        // Remove 'active' de todos os links
        navLinks.forEach(nav => nav.classList.remove('active'));
        // Adiciona 'active' ao link clicado
        this.classList.add('active');
    });
});


// Seleciona os links de navegação e o menu

const menuToggle = document.querySelector('.menu-toggle');
const navbarUl = document.querySelector('.navbar ul');

// Função para alternar o menu no modo responsivo
menuToggle.addEventListener('click', () => {
    navbarUl.classList.toggle('open');
});

// Fecha o menu quando um link é clicado (modo responsivo)
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        navbarUl.classList.remove('open');
        updateActiveLink(link); // Mantém o link ativo no modo responsivo
    });
});

// Função para atualizar o link ativo
function updateActiveLink(clickedLink) {
    navLinks.forEach(link => link.classList.remove('active'));
    clickedLink.classList.add('active');
}

// Configura o primeiro link como ativo por padrão (se necessário)
if (navLinks.length > 0) {
    updateActiveLink(navLinks[0]);
}
