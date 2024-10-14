// modal pop up
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Selecionar o modulo de boletim

   // Função para exibir a tabela correspondente ao módulo selecionado
   document.getElementById("module-select").addEventListener("change", function() {
    var selectedModule = this.value; // Pega o valor do módulo selecionado

    // Esconde todas as tabelas
    var tables = document.querySelectorAll(".module-table");
    tables.forEach(function(table) {
        table.style.display = "none";
    });

    // Exibe apenas a tabela correspondente ao módulo selecionado
    document.getElementById(selectedModule).style.display = "block";
});

// Exibe a tabela do primeiro módulo por padrão
document.getElementById("modulo1").style.display = "block";

// Botão baixar boletim 

document.getElementById('downloadbtn').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const moduleSelect = document.getElementById('module-select');
    const selectedModule = moduleSelect.options[moduleSelect.selectedIndex].text;
    const table = document.querySelector(`#${moduleSelect.value} .module-table`);

    if (!table) {
        alert('Tabela não encontrada para o módulo selecionado.');
        return;
    }

    let content = `Boletim - ${selectedModule}\n\n`;
    content += 'Disciplinas\tFaltas\tNota 1\tNota 2\tNota 3\tNota 4\tCritérios\tObservações\n';

    table.querySelectorAll('tbody tr').forEach(row => {
        row.querySelectorAll('td').forEach(cell => {
            content += `${cell.innerText}\t`;
        });
        content += '\n';
    });

    doc.text(content, 10, 10);
    doc.save(`Boletim_${selectedModule}.pdf`);
});