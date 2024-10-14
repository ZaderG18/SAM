// Função para buscar o protocolo baseado no número fornecido
function buscarProtocolo() {
    const protocolo = document.getElementById("protocolo").value;
    
    if (protocolo === "") {
        alert("Por favor, insira o número do protocolo.");
    } else {
        // Simula uma busca de protocolo (pode ser substituída por uma chamada AJAX para o backend)
        const protocoloEncontrado = Math.random() > 0.5; // Simulação de sucesso ou falha na busca

        if (protocoloEncontrado) {
            alert("Protocolo " + protocolo + " encontrado! Retirada disponível em até 2 dias úteis.");
        } else {
            alert("Protocolo " + protocolo + " não encontrado. Por favor, verifique o número e tente novamente.");
        }
    }
}

// Função para gerar uma declaração baseada na seleção do usuário
function gerarDeclaracao() {
    const tipoDeclaracao = document.getElementById("tipo-declaracao").value;

    if (tipoDeclaracao === "") {
        alert("Por favor, selecione o tipo de declaração.");
    } else {
        // Simula a geração de uma declaração (pode ser substituída por uma chamada AJAX para gerar o documento no backend)
        alert("Declaração de " + tipoDeclaracao + " gerada com sucesso!");
    }
}

// Função para enviar o formulário de rematrícula
document.querySelector(".right-column form").addEventListener("submit", function(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    const nome = document.getElementById("nome").value;
    const matricula = document.getElementById("matricula").value;

    if (nome === "" || matricula === "") {
        alert("Por favor, preencha todos os campos.");
    } else {
        // Simula o envio da rematrícula (pode ser substituído por uma chamada AJAX)
        alert("Rematrícula enviada com sucesso! Nome: " + nome + ", Matrícula: " + matricula);
    }
});
