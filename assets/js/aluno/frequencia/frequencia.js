// Funções para exibir e fechar o modal
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Função para exibir o módulo de boletim correspondente ao selecionado
function handleModuleChange() {
    const selectedModule = document.getElementById("module-select").value; // Pega o valor do módulo selecionado
    const tables = document.querySelectorAll(".module-table"); // Todas as tabelas de módulos

    tables.forEach((table) => {
        table.style.display = "none"; // Oculta todas as tabelas
    });

    const selectedTable = document.getElementById(selectedModule);
    if (selectedTable) {
        selectedTable.style.display = "block"; // Exibe a tabela selecionada
    }
}

// Função para inicializar a exibição padrão e adicionar o evento de seleção de módulo
function init() {
    document.getElementById("module-select").addEventListener("change", handleModuleChange);

    // Exibe a tabela do primeiro módulo por padrão, se existir
    const defaultTable = document.getElementById("modulo1");
    if (defaultTable) {
        defaultTable.style.display = "block";
    }
}

// Inicializa as funções assim que o conteúdo da página for carregado
document.addEventListener("DOMContentLoaded", init);
