document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Previne o envio do formulário para validação

        // Capturando os campos
        const nomeCompleto = document.getElementById('nome-completo').value.trim();
        const telefone = document.getElementById('telefone').value.trim();
        const email = document.getElementById('email').value.trim();
        const id = document.getElementById('id').value.trim();
        const curso = document.getElementById('curso').value;
        const mensagem = document.getElementById('mensagem').value.trim();
        const arquivo = document.getElementById('arquivo').files[0];

        // Validação
        if (!nomeCompleto || !telefone || !email || !rm || !curso || !mensagem) {
            alert('Por favor, preencha todos os campos obrigatórios.');
            return;
        }

        if (!validateEmail(email)) {
            alert('Por favor, insira um email válido.');
            return;
        }

        if (!validateTelefone(telefone)) {
            alert('Por favor, insira um número de telefone válido.');
            return;
        }

        if (arquivo && !validateArquivo(arquivo)) {
            alert('O arquivo enviado deve ser uma imagem (jpg, jpeg, png) ou PDF e ter até 2MB.');
            return;
        }

        // Exibe uma mensagem de sucesso (aqui você pode fazer o envio real ou uma simulação)
        alert('Formulário enviado com sucesso!');
        form.reset(); // Reseta o formulário após o envio
    });

    // Função para validar email
    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
    }

    // Função para validar telefone (formato simples)
    function validateTelefone(telefone) {
        const re = /^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/; // Aceita formatos (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
        return re.test(telefone);
    }

    // Função para validar o arquivo (apenas jpg, jpeg, png, pdf e até 2MB)
    function validateArquivo(arquivo) {
        const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        const fileSize = 2 * 1024 * 1024; // Limite de 2MB
        const fileExtension = arquivo.name.split('.').pop().toLowerCase();

        return allowedExtensions.includes(fileExtension) && arquivo.size <= fileSize;
    }
});
