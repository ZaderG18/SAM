
// Seleciona os links de navegação e as seções
const navLinks = document.querySelectorAll('.nav_link');
const sections = document.querySelectorAll('.content-section');

// Função para trocar a seção ativa
function switchSection(sectionId) {
// Remove a classe 'active' de todas as seções
sections.forEach(section => section.classList.remove('active'));
// Adiciona 'active' à seção correspondente ao link clicado
document.getElementById(sectionId).classList.add('active');
}

// Função para atualizar o link ativo na navbar
function updateActiveLink(clickedLink) {
navLinks.forEach(link => link.classList.remove('active'));
clickedLink.classList.add('active');
}

// Adiciona evento de clique aos links da navbar
navLinks.forEach(link => {
link.addEventListener('click', (event) => {
event.preventDefault(); // Evita o comportamento padrão do link
const sectionId = link.getAttribute('data-section'); // Pega o ID da seção
switchSection(sectionId); // Troca a seção ativa
updateActiveLink(link); // Atualiza o link ativo
});
});


const menuToggle = document.querySelector('.menu-toggle');
const navbarUl = document.querySelector('.navbar ul');
const navlinks = document.querySelectorAll('.nav_link');

// Função para alternar o menu
menuToggle.addEventListener('click', () => {
    navbarUl.classList.toggle('open');
});

// Fecha o menu quando um link é clicado
navlinks.forEach(link => {
    link.addEventListener('click', () => {
        navbarUl.classList.remove('open');
    });
});

const headerImg = document.querySelector('.header__img'); // Imagem do header
const profileImg = document.getElementById('profileImg'); // Imagem do perfil
const imageUpload = document.getElementById('imageUpload');

// Define a mesma imagem do header como prévia no perfil
profileImg.src = headerImg.src;

// Função para carregar nova imagem ao selecionar arquivo
imageUpload.addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            profileImg.src = e.target.result;
        };

        reader.readAsDataURL(file);
    }
});
