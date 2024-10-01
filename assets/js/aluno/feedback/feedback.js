// Simulando um feedback do professor e o nome do arquivo enviado
const feedbackProfessor = "Seu trabalho foi muito bom! Considere melhorar a gramática.";
const nomeArquivo = "Redação_Juliana_Santos";

// Atualiza o campo do nome do arquivo e o feedback
document.getElementById('file-name').value = nomeArquivo;
document.getElementById('feedback-text').textContent = feedbackProfessor;
