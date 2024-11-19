document.querySelector(".right-column form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir o envio padrão do formulário

    const nome = document.getElementById("nome").value;
    const matricula = document.getElementById("matricula").value;

    if (nome === "" || matricula === "") {
        alert("Por favor, preencha todos os campos.");
        return;
    }

    fetch('../../../../php/aluno/documentos.php', {
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

            // Gerar o PDF com jsPDF
            const { jsPDF } = window.jspdf;

            const doc = new jsPDF();
            doc.setFontSize(12);
            doc.text("Rematrícula Realizada com Sucesso!", 20, 30);
            doc.text("Nome do Aluno: " + nome, 20, 40);
            doc.text("Matrícula: " + matricula, 20, 50);
            doc.text("Protocolo: " + data.protocolo, 20, 60);
            doc.save('rematricula.pdf'); // Gera o PDF e baixa
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert("Erro ao realizar a rematrícula.");
        console.error("Erro:", error);
    });
});

async function gerarDeclaracaoPDF() {
    const tipoDeclaracao = document.getElementById("tipo-declaracao").value;
    const motivo = document.getElementById("motivo").value;

    if (tipoDeclaracao === "" || motivo === "") {
        alert("Por favor, preencha todos os campos.");
        return;
    }

    try {
        // Envia dados para o back-end via fetch
        const response = await fetch('../../../../php/aluno/documentos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'action': 'declaracao',
                'tipo_declaracao': tipoDeclaracao,
                'motivo': motivo
            })
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message + " Protocolo: " + data.protocolo);

            // Gerar o PDF com jsPDF
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(16);
            doc.text("Declaração de " + tipoDeclaracao, 20, 30);
            doc.text("Motivo: " + motivo, 20, 40);
            doc.text("Protocolo: " + data.protocolo, 20, 50);
            doc.save('declaracao.pdf'); // Gera o PDF e baixa
        } else {
            alert(data.message);
        }
    } catch (error) {
        alert("Erro ao gerar a declaração.");
        console.error("Erro:", error);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const { jsPDF } = window.jspdf;

    // Evento de clique para gerar a declaração em PDF
    const gerarButton = document.querySelector("button[type='button']");
    if (gerarButton) {
        gerarButton.onclick = gerarDeclaracaoPDF;
    }
});
