// Função para alternar a exibição do conteúdo extra de confirmação
function toggleInfoExtra(type) {
    const infoExtraAlerta = document.getElementById('infoExtraAlerta');
    const infoExtraChat = document.getElementById('infoExtraChat');

    if (type === 'alerta') {
        // Se o conteúdo extra do alerta estiver oculto, exiba-o e oculte o do chat
        if (infoExtraAlerta.style.display === 'block') {
            infoExtraAlerta.style.display = 'none'; // Fecha se já estiver aberto
        } else {
            infoExtraAlerta.style.display = 'block'; // Abre o alerta
            infoExtraChat.style.display = 'none'; // Fecha o chat
        }
    } else if (type === 'chat') {
        // Se o conteúdo extra do chat estiver oculto, exiba-o e oculte o do alerta
        if (infoExtraChat.style.display === 'block') {
            infoExtraChat.style.display = 'none'; // Fecha se já estiver aberto
        } else {
            infoExtraChat.style.display = 'block'; // Abre o chat
            infoExtraAlerta.style.display = 'none'; // Fecha o alerta
        }
    }
}

// Função para pré-visualizar a imagem selecionada
function previewImage(event) {
    const imagePreview = document.getElementById('imagePreview');
    const cancelButton = document.querySelector('.cancel-image');
    
    imagePreview.src = URL.createObjectURL(event.target.files[0]);
    imagePreview.style.display = 'block';
    cancelButton.style.display = 'inline-block'; // Exibe o botão de cancelar imagem
}

// Função para cancelar a imagem selecionada
function cancelImage() {
    const imagePreview = document.getElementById('imagePreview');
    const imageInput = document.getElementById('imagem');
    const cancelButton = document.querySelector('.cancel-image');

    imagePreview.src = ''; // Remove a imagem da pré-visualização
    imagePreview.style.display = 'none'; // Oculta a pré-visualização
    imageInput.value = ''; // Limpa o input de arquivo
    cancelButton.style.display = 'none'; // Oculta o botão de cancelar imagem
}
  
// Script principal para gerenciar a navegação entre etapas
document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.step');
    let currentStep = 0;

    // Mostra a primeira etapa ao carregar
    steps[currentStep].classList.add('active');

    // Adiciona eventos de clique aos rótulos de Alerta e Chat para exibir o conteúdo extra
    document.querySelector('label[for="alerta"]').addEventListener('click', function() {
        toggleInfoExtra('alerta');
    });
    document.querySelector('label[for="chat"]').addEventListener('click', function() {
        toggleInfoExtra('chat');
    });

    // Avançar para a próxima etapa
    document.querySelectorAll('.next').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                steps[currentStep].classList.remove('active');
                currentStep++;
                steps[currentStep].classList.add('active');
            }
        });
    });

    // Voltar para a etapa anterior
    document.querySelectorAll('.prev').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 0) {
                steps[currentStep].classList.remove('active');
                currentStep--;
                steps[currentStep].classList.add('active');
            }
        });
    });

    // Submissão do formulário
    document.getElementById('comunicadoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Comunicado publicado com sucesso!');
    });
});
