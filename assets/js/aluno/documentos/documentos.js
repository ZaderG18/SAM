// Função para enviar a rematrícula via AJAX
document.querySelector(".right-column form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir o envio padrão do formulário

    const nome = document.getElementById("nome").value;
    const matricula = document.getElementById("matricula").value;

    if (nome === "" || matricula === "") {
        alert("Por favor, preencha todos os campos.");
        return;
    }

    fetch('../../php/aluno/documentos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'action': 'rematricula',
            'nome': nome,
            'matricula': matricula
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert("Erro ao realizar a rematrícula.");
        console.error("Erro:", error);
    });
});

// Função para gerar declaração via AJAX
function gerarDeclaracao() {
    const tipoDeclaracao = document.getElementById("tipo-declaracao").value;
    const motivo = document.getElementById("motivo").value;

    if (tipoDeclaracao === "" || motivo === "") {
        alert("Por favor, preencha todos os campos.");
        return;
    }

    fetch('../../php/aluno/documentos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'action': 'declaracao',
            'tipo_declaracao': tipoDeclaracao,
            'motivo': motivo
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message + " Protocolo: " + data.protocolo);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert("Erro ao solicitar a declaração.");
        console.error("Erro:", error);
    });
}
