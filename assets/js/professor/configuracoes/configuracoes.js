let personalInfo = {
    nome: '',
    cpf: '',
    rg: '',
    telefone: '',
    email: '',
    genero: '',
    estadoCivil: '',
    dataNascimento: '',
    nacionalidade: '',
    endereco: '',
    ID: '',
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
    document.querySelector('.personal-info input[name="nome"]').value = personalInfo.nome;
    document.querySelector('.personal-info input[name="cpf"]').value = personalInfo.cpf;
    document.querySelector('.personal-info input[name="rg"]').value = personalInfo.rg;
    document.querySelector('.personal-info input[name="telefone"]').value = personalInfo.telefone;
    document.querySelector('.personal-info input[name="email"]').value = personalInfo.email;
    document.querySelector('.personal-info select[name="genero"]').value = personalInfo.genero;
    document.querySelector('.personal-info input[name="dataNascimento"]').value = personalInfo.dataNascimento;
    document.querySelector('.personal-info input[name="endereco"]').value = personalInfo.endereco;
    document.querySelector('.personal-info input[name="ID"]').value = personalInfo.ID;
    document.querySelector('.personal-info select[name="curso"]').value = personalInfo.curso;
    document.querySelector('.personal-info select[name="estadoCivil"]').value = personalInfo.estadoCivil;
    document.querySelector('.personal-info input[name="nacionalidade"]').value = personalInfo.nacionalidade;
});

// Função para o botão "Salvar" no formulário de informações pessoais
const personalInfoForm = document.querySelector('.personal-info form');
personalInfoForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita o envio do formulário para fins de demonstração

    // Atualizar as informações pessoais com os dados do formulário
    personalInfo.nome = document.querySelector('.personal-info input[name="nome"]').value;
    personalInfo.cpf = document.querySelector('.personal-info input[name="cpf"]').value;
    personalInfo.rg = document.querySelector('.personal-info input[name="rg"]').value;
    personalInfo.telefone = document.querySelector('.personal-info input[name="telefone"]').value;
    personalInfo.email = document.querySelector('.personal-info input[name="email"]').value;
    personalInfo.genero = document.querySelector('.personal-info select[name="genero"]').value;
    personalInfo.dataNascimento = document.querySelector('.personal-info input[name="dataNascimento"]').value;
    personalInfo.endereco = document.querySelector('.personal-info input[name="endereco"]').value;
    personalInfo.ID = document.querySelector('.personal-info input[name="ID"]').value;
    personalInfo.curso = document.querySelector('.personal-info select[name="curso"]').value;
    personalInfo.estadoCivil = document.querySelector('.personal-info select[name="estadoCivil"]').value;
    personalInfo.nacionalidade = document.querySelector('.personal-info input[name="nacionalidade"]').value;

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