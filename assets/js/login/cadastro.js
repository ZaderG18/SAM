// Carrega os usuários cadastrados do localStorage ao carregar a página
let usuariosCadastrados = JSON.parse(localStorage.getItem('usuariosCadastrados')) || [];
console.log('Usuários cadastrados:', usuariosCadastrados); // Verifica se os usuários estão carregando

// Função para verificar se o email já foi cadastrado
function emailExiste(email) {
    return usuariosCadastrados.some(usuario => usuario.email === email);
}

// Função para validar a senha
function validarSenha(senha) {
    // Valida senha com pelo menos 8 caracteres, incluindo letras, números e caracteres especiais
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return passwordPattern.test(senha);
}

// Função para cadastrar um novo usuário
function cadastrarUsuario(event) {
    event.preventDefault(); // Previne o envio do formulário

    // Captura os dados do formulário
    const nome = document.getElementById('nome').value;
    const tipoAcesso = document.getElementById('cars').value;
    const email = document.getElementById('password').value;
    const senha = document.getElementById('senha').value;
    const lembrarDeMim = document.querySelector('.box-check input').checked;

    console.log('Dados do formulário:', { nome, tipoAcesso, email, senha, lembrarDeMim });

    // Verifica se todos os campos estão preenchidos e se a senha é válida
    if (nome && tipoAcesso && email && senha.length >= 8 && validarSenha(senha)) {
        // Verifica se o email já está cadastrado
        if (emailExiste(email)) {
            alert('Este email já está cadastrado.');
            return;
        }

        // Cria um novo objeto de usuário
        const novoUsuario = { nome, tipoAcesso, email, senha, lembrarDeMim };

        // Adiciona o novo usuário ao array de usuários cadastrados
        usuariosCadastrados.push(novoUsuario);

        // Armazena o array atualizado no localStorage
        localStorage.setItem('usuariosCadastrados', JSON.stringify(usuariosCadastrados));

        // Armazena os dados no console para visualização
        console.log('Usuário cadastrado com sucesso:', novoUsuario);

        // Redireciona para a tela de login após o cadastro
        setTimeout(() => {
            window.location.href = 'login.html';
            alert('Cadastrado com Sucesso!'); // Mensagem de sucesso
        }, 1000); // Tempo para visualização do console
    } else {
        alert('Por favor, preencha todos os campos corretamente. A senha deve ter pelo menos 8 caracteres, incluindo letras, números e um caractere especial.');
    }
}

// Adiciona o evento de submit ao formulário de cadastro
document.getElementById('cadastrar').addEventListener('click', cadastrarUsuario);

// Função para mostrar a senha do input de senha
function mostrarSenha() {
    var inputPass = document.getElementById('senha');
    var btnShowPass = document.getElementById('btn-senha');

    if (inputPass.type === 'password') {
        inputPass.setAttribute('type', 'text');
        btnShowPass.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        inputPass.setAttribute('type', 'password');
        btnShowPass.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
