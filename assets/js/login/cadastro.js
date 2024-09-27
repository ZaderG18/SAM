// Carrega os usuários cadastrados do localStorage ao carregar a página
let usuariosCadastrados = JSON.parse(localStorage.getItem('usuariosCadastrados')) || [];
console.log('Usuários cadastrados:', usuariosCadastrados); // Verifica se os usuários estão carregando

// Função para verificar se o email já foi cadastrado
function emailExiste(email) {
    return usuariosCadastrados.some(usuario => usuario.email === email);
}

// Função para validar o formato do email
function validarEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

// Função para validar a senha
function validarSenha(senha) {
    // Valida senha com pelo menos 8 caracteres, incluindo letras, números e caracteres especiais
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return passwordPattern.test(senha);
}

// Função para cadastrar um novo usuário
// function cadastrarUsuario(event) {
    // event.preventDefault(); // Previne o envio do formulário

    // // Captura os dados do formulário
    // const nome = document.getElementById('nome').value;
    // const tipoAcesso = document.getElementById('cargo').value;
    // const email = document.getElementById('email').value;
    // const senha = document.getElementById('senha').value;
    // const lembrarDeMim = document.querySelector('.box-check input').checked;

    // console.log('Dados do formulário:', { nome, tipoAcesso, email, senha, lembrarDeMim });

    // // Verifica se o email já está cadastrado
    // if (emailExiste(email)) {
//         alert('O e-mail já está cadastrado.');
//         return;
//     }

//     // Verifica se o formato do email é válido
//     if (!validarEmail(email)) {
//         alert('Por favor, insira um e-mail válido.');
//         return;
//     }

//     // Verifica se todos os campos estão preenchidos e se a senha é válida
//     if (nome && tipoAcesso && email && senha.length >= 8 && validarSenha(senha)) {
//         // Monta os dados para enviar ao PHP
//         const formData = new FormData();
//         formData.append('nome', nome);
//         formData.append('cargo', tipoAcesso);
//         formData.append('email', email);
//         formData.append('senha', senha);
//         formData.append('lembrarDeMim', lembrarDeMim);

//         // Faz a requisição para o PHP usando fetch
//         fetch('../../php/processamento.php', {
//             method: 'POST',
//             body: formData,
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 alert('Cadastrado com sucesso!');
//                 window.location.href = '../../index.html';
//             } else {
//                 alert('Erro ao cadastrar: ' + data.message);
//             }
//         })
//         .catch(error => {
//             console.error('Erro na requisição:', error);
//             alert('Erro no servidor.');
//         });
//     } else {
//         alert('Por favor, preencha todos os campos corretamente. A senha deve ter pelo menos 8 caracteres, incluindo letras, números e um caractere especial.');
//     }
// }

// // Adiciona o evento de submit ao formulário de cadastro
// document.getElementById('cadastrar').addEventListener('click', cadastrarUsuario);

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
