// Função para exibir o modal pop-up
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.style.display = 'block';
}

// Função para fechar o modal pop-up
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.style.display = 'none';
}

document.getElementById("module-select").addEventListener("change", function() {
    var selectedModule = this.value; // Obtemos o valor do módulo selecionado

    // Esconde todas as tabelas
    var tables = document.querySelectorAll(".module-table");
    tables.forEach(function(table) {
        table.style.display = "none";
    });

    // Exibe a tabela correspondente ao módulo selecionado
    fetch(`../../php/aluno/boletim.php?modulo=${selectedModule}`)
        .then(response => response.text())
        .then(data => {
            // Atualiza o conteúdo da tabela do módulo selecionado
            document.getElementById(`modulo${selectedModule}`).innerHTML = data;
            document.getElementById(`modulo${selectedModule}`).style.display = "block"; // Exibe a tabela do módulo selecionado
        })
        .catch(error => {
            console.error('Erro ao carregar as notas:', error);
            alert('Ocorreu um erro ao carregar as notas. Tente novamente mais tarde.'); // Mensagem amigável ao usuário
        });
});

// Inicializar o primeiro módulo
document.getElementById("modulo1").style.display = "block"; // Mostra a tabela do primeiro módulo por padrão

// Função para baixar o boletim em PDF
document.getElementById('downloadbtn').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const moduleSelect = document.getElementById('module-select');
    const selectedModule = moduleSelect.options[moduleSelect.selectedIndex].text; // Texto do módulo selecionado
    const table = document.querySelector(`#modulo${moduleSelect.value} .module-table tbody`);

    if (!table) {
        alert('Tabela não encontrada para o módulo selecionado.');
        return;
    }

    let content = `Boletim - ${selectedModule}\n\n`;
    content += 'Disciplinas\tFaltas\tNota 1\tNota 2\tNota 3\tNota 4\tCritérios\tObservações\n';

    // Itera pelas linhas da tabela e adiciona os dados ao conteúdo do PDF
    table.querySelectorAll('tr').forEach(row => {
        row.querySelectorAll('td').forEach((cell, index) => {
            content += `${cell.innerText}\t`;
            if (index === row.querySelectorAll('td').length - 1) {
                content += '\n'; // Adiciona uma nova linha após cada linha de células
            }
        });
    });

    doc.text(content, 10, 10);
    doc.save(`Boletim_${selectedModule}.pdf`);
});
