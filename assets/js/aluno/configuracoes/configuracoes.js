// Variáveis para armazenar as informações pessoais
let personalInfo = {
    nome: '',
    telefone: '',
    email: '',
    genero: '',
    dataNascimento: '',
    endereco: '',
    rm: '',
    curso: ''
};

// Função para atualizar a imagem de perfil
document.getElementById('upload').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('profile-pic').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Função para alternar o estado dos toggles
const toggleIcons = document.querySelectorAll('.toggle-icon');
toggleIcons.forEach(icon => {
    icon.addEventListener('click', function () {
        icon.classList.toggle('bxs-toggle-left');
        icon.classList.toggle('bxs-toggle-right'); // Troque a classe dependendo do estado
    });
});

// Função para o botão "Salvar" nas notificações
const saveNotificationButton = document.querySelector('.notifications .btn-padrao');
saveNotificationButton.addEventListener('click', function () {
    const emailNotification = document.querySelector('.notifications select:nth-of-type(1)').value;
    const phoneNotification = document.querySelector('.notifications select:nth-of-type(2)').value;
    
    alert(`Notificações salvas!\nEmail: ${emailNotification}\nTelefone: ${phoneNotification}`);
});

// Função para o botão "Editar" nas informações pessoais
const editPersonalInfoButton = document.querySelector('.personal-info .btn-padrao:first-of-type');
editPersonalInfoButton.addEventListener('click', function () {
    // Preencher os campos do formulário com as informações pessoais
    document.querySelector('.personal-info input[type="text"]').value = personalInfo.nome;
    document.querySelector('.personal-info input[type="tel"]').value = personalInfo.telefone;
    document.querySelector('.personal-info input[type="email"]').value = personalInfo.email;
    document.querySelector('.personal-info select').value = personalInfo.genero;
    document.querySelector('.personal-info input[type="date"]').value = personalInfo.dataNascimento;
    document.querySelector('.personal-info input[type="text"]:nth-of-type(2)').value = personalInfo.endereco; // Para o endereço
    document.querySelector('.personal-info input[type="text"]:nth-of-type(3)').value = personalInfo.rm; // Para o RM
    document.querySelector('.personal-info select:nth-of-type(2)').value = personalInfo.curso; // Para o curso
});

// Função para o botão "Salvar" no formulário de informações pessoais
const personalInfoForm = document.querySelector('.personal-info form');
personalInfoForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita o envio do formulário para fins de demonstração

    // Atualizar as informações pessoais com os dados do formulário
    personalInfo.nome = document.querySelector('.personal-info input[type="text"]').value;
    personalInfo.telefone = document.querySelector('.personal-info input[type="tel"]').value;
    personalInfo.email = document.querySelector('.personal-info input[type="email"]').value;
    personalInfo.genero = document.querySelector('.personal-info select').value;
    personalInfo.dataNascimento = document.querySelector('.personal-info input[type="date"]').value;
    personalInfo.endereco = document.querySelector('.personal-info input[type="text"]:nth-of-type(2)').value; // Para o endereço
    personalInfo.rm = document.querySelector('.personal-info input[type="text"]:nth-of-type(3)').value; // Para o RM
    personalInfo.curso = document.querySelector('.personal-info select:nth-of-type(2)').value; // Para o curso

    alert(`Informações pessoais salvas:\n${JSON.stringify(personalInfo, null, 2)}`);
});

// Função para o botão "Salvar" no formulário de atualização de senha
const passwordUpdateForm = document.querySelector('.password-update form');
passwordUpdateForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita o envio do formulário para fins de demonstração

    const currentPassword = document.querySelector('.password-update input[type="password"]:nth-of-type(1)').value;
    const newPassword = document.querySelector('.password-update input[type="password"]:nth-of-type(2)').value;
    const confirmNewPassword = document.querySelector('.password-update input[type="password"]:nth-of-type(3)').value;

    if (newPassword !== confirmNewPassword) {
        alert('As senhas não correspondem!');
        return;
    }

    // Aqui você pode adicionar a lógica para atualizar a senha no backend ou no armazenamento
    alert('Senha atualizada com sucesso!');
});
