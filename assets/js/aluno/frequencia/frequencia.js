// Função para buscar dados de frequência do back-end e exibi-los na tabela
function fetchFrequenciaData(moduloId) {
    fetch('../../../php/aluno/frequencia.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `modulo=${moduloId}`
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById("frequencia-table-body");
        tableBody.innerHTML = ""; // Limpa a tabela para nova exibição

        data.forEach(row => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${row.disciplina}</td>
                <td>${row.frequencia}%</td>
            `;
            tableBody.appendChild(tr);
        });
    })
    .catch(error => console.error("Erro ao buscar dados de frequência:", error));
}

// Chama a função `fetchFrequenciaData` sempre que o módulo é alterado
function handleModuleChange() {
    const selectedModule = document.getElementById("module-select").value;
    fetchFrequenciaData(selectedModule);
}

// Configura a inicialização e o evento de mudança no módulo
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("module-select").addEventListener("change", handleModuleChange);
    handleModuleChange(); // Chama a função para exibir o primeiro módulo por padrão
});
// Adiciona um evento de clique para cada linha da tabela, exibindo um modal com detalhes adicionais
document.getElementById("frequencia-table-body").addEventListener("click", function(event) {
    if (event.target.tagName === "TR") {
        const rowData = event.target.querySelectorAll("td");
        const disciplina = rowData[0].textContent;
        const frequencia = rowData[1].textContent;

        // Preenche o modal com os dados da linha clicada
        document.getElementById("modal-disciplina").textContent = disciplina;
        document.getElementById("modal-frequencia").textContent = frequencia;

        // Exibe o modal
        $("#frequenciaModal").modal("show");
    }
});
