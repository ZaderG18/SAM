// Função para validar o login
async function validarLogin() {
    var email = document.getElementById('email').value;
    var senha = document.getElementById('senha').value;

    // Regex para validar a senha
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    // Verifica se a senha atende aos critérios
    if (!passwordPattern.test(senha)) {
        alert('A senha deve ter no mínimo 8 caracteres, incluindo letras, números e um caractere especial.');
        return; // Interrompe se a senha não atender
    }

    // Faz a requisição para o servidor
    try {
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, senha }), // Envia os dados
        });

        const result = await response.json();

        if (result.success) {
            alert('Sucesso!'); // Mensagem de sucesso
            window.location.href = result.redirect; // Redireciona para a página home
        } else {
            alert('Usuário ou senha incorretos!'); // Mensagem de erro
        }
    } catch (error) {
        console.error('Erro ao fazer login:', error);
        alert('Ocorreu um erro, tente novamente.'); // Tratamento de erro
    }
}

// Função para manipular o checkbox "Lembrar de mim"
document.addEventListener('DOMContentLoaded', function () {
    const lembrarCheckbox = document.querySelector('input[type="checkbox"]');

    // Verifica o estado "Lembrar de mim"
    const lembrar = localStorage.getItem('lembrarDeMim');
    lembrarCheckbox.checked = lembrar === 'true';

    lembrarCheckbox.addEventListener('change', function () {
        localStorage.setItem('lembrarDeMim', this.checked); // Salva o estado
    });
});

// Função para mostrar a senha do input de senha
function mostrarSenha() {
    var inputPass = document.getElementById('senha');
    var btnShowPass = document.getElementById('btn-senha');

    // Alterna entre mostrar e esconder a senha
    if (inputPass.type === 'password') {
        inputPass.setAttribute('type', 'text');
        btnShowPass.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        inputPass.setAttribute('type', 'password');
        btnShowPass.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
