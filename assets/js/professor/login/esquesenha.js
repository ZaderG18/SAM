// Adiciona um ouvinte de evento ao botão com o id 'enviar'
// Quando o botão é clicado, a função associada é executada
document.getElementById('enviar').addEventListener('click', function(e) {
    // Previne o comportamento padrão do botão (envio de formulário)
    e.preventDefault();
    
    // Obtém o valor do campo de entrada de email
    const email = document.getElementById('email').value;
    
    // Verifica se o email é válido usando a função validateEmail
    if (validateEmail(email)) {
        // Se o email for válido, mostra um alerta e redireciona para a página de verificação de email
        alert('Email de recuperação enviado!');
        window.location.href = 'verificaremail.html';
    } else {
        // Se o email não for válido, mostra um alerta pedindo um email válido
        alert('Por favor, insira um email válido.');
    }
});

// Função para validar o formato do email
function validateEmail(email) {
    // Expressão regular para verificar se o email possui um formato básico de email
    const re = /\S+@\S+\.\S+/;
    // Testa o email contra a expressão regular e retorna verdadeiro ou falso
    return re.test(email);
}
