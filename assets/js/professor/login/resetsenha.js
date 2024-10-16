document.addEventListener('DOMContentLoaded', function() {
    // Captura o evento de submissão do formulário
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Previne o envio automático do formulário

        // Captura os valores dos campos de senha
        const newPassword = document.getElementById('senha').value;
        const confirmPassword = document.getElementById('senha-confirm').value;

        // Regex para garantir que a senha tenha pelo menos uma letra, um número e um caractere especial
        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        // Verificar se a nova senha cumpre os critérios
        if (!passwordPattern.test(newPassword)) {
            alert('A senha deve ter no mínimo 8 caracteres, incluindo letras, números e um caractere especial.');
            return; // Interrompe a execução se a validação falhar
        }

        // Verificar se as senhas coincidem
        if (newPassword !== confirmPassword) {
            alert('As senhas não coincidem.');
            return; // Interrompe a execução se as senhas não coincidirem
        }

        // Se todas as validações passarem, prosseguir
        alert('Senha alterada com sucesso!');
        window.location.href = 'checkpass.html'; // Redireciona para a página de confirmação
    });
});

/*
    * Função para mostrar a senha do input de senha
*/
function mostrarSenha() {
    var inputPass = document.getElementById('senha');
    var btnShowPass = document.getElementById('btn-senha');

    if (inputPass.type === 'password') {
        inputPass.setAttribute('type', 'text');
        btnShowPass.classList.replace('bi-eye', 'bi-eye-slash');
    }else{
        inputPass.setAttribute('type', 'password');
        btnShowPass.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function mostrarSenhaConfirm() {
    var inputPass = document.getElementById('senha-confirm');
    var btnShowPass = document.getElementById('btn-senha-confirm');

    if (inputPass.type === 'password') {
        inputPass.setAttribute('type', 'text');
        btnShowPass.classList.replace('bi-eye', 'bi-eye-slash');
    }else{
        inputPass.setAttribute('type', 'password');
        btnShowPass.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
