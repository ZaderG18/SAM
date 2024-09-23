// Função para validar o login
function validarLogin() {
    // Obtém os valores dos campos de email e senha
    var email = document.getElementById('email').value;
    var senha = document.getElementById('senha').value;

    // Regex para validar a senha (mínimo 8 caracteres, incluindo letras, números e um caractere especial)
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    // Carrega os usuários cadastrados do localStorage
    var usuariosCadastrados = JSON.parse(localStorage.getItem('usuariosCadastrados')) || [];

    // Verifica se o email e a senha correspondem a um usuário cadastrado
    var usuarioEncontrado = usuariosCadastrados.find(function(usuario) {
        return usuario.email === email && usuario.senha === senha;
    });

    // Verifica se a senha atende aos critérios
    if (!passwordPattern.test(senha)) {
        alert('A senha deve ter no mínimo 8 caracteres, incluindo letras, números e um caractere especial.');
        return; // Interrompe a execução se a senha não atender aos critérios
    }

    if (usuarioEncontrado) {
        alert('Sucesso!'); // Mensagem de sucesso
        window.location.href = "../home/home.html"; // Redireciona para a página home
    } else {
        alert('Usuário ou senha incorretos!'); // Mensagem de erro
    }
}

// Função para manipular o checkbox "Lembrar de mim"
document.addEventListener('DOMContentLoaded', function () {
    const lembrarCheckbox = document.querySelector('input[type="checkbox"]');

    // Verifica se o estado "Lembrar de mim" está salvo no localStorage
    const lembrar = localStorage.getItem('lembrarDeMim');
    if (lembrar === 'true') {
        lembrarCheckbox.checked = true;
        console.log('Lembrar de mim já estava ativado');
    } else {
        lembrarCheckbox.checked = false;
        console.log('Lembrar de mim desativado por padrão');
    }

    lembrarCheckbox.addEventListener('change', function () {
        if (this.checked) {
            console.log('Lembrar de mim ativado');
            localStorage.setItem('lembrarDeMim', 'true');
        } else {
            console.log('Lembrar de mim desativado');
            localStorage.setItem('lembrarDeMim', 'false');
        }
    });
});

// Função para mostrar a senha do input de senha
function mostrarSenha() {
    var inputPass = document.getElementById('senha'); // Pega o input de senha
    var btnShowPass = document.getElementById('btn-senha'); // Pega o botão de mostrar senha

    // Se o tipo do input for password, ele muda para text e troca o ícone do botão
    if (inputPass.type === 'password') {
        inputPass.setAttribute('type', 'text');
        btnShowPass.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        inputPass.setAttribute('type', 'password');
        btnShowPass.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
