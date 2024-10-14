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