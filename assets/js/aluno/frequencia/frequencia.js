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

function carregarFrequencia(modulo) {
    if (modulo !== "") {
        $.ajax({
            url: '../../../php/aluno/frequencia.php', // Arquivo PHP que vai retornar os dados
            method: 'POST',
            data: { modulo: modulo },
            dataType: 'json',
            success: function(response) {
                var tableBody = $("#frequenciaTable tbody");
                tableBody.empty(); // Limpa a tabela antes de inserir os novos dados

                if (response.length > 0) {
                    // Preenche a tabela com os dados retornados
                    $.each(response, function(index, item) {
                        tableBody.append("<tr><td>" + item.disciplina + "</td><td>" + item.frequencia + "</td></tr>");
                    });
                } else {
                    tableBody.append("<tr><td colspan='2'>Nenhuma frequência encontrada</td></tr>");
                }
            },
            error: function() {
                alert("Erro ao buscar as frequências.");
            }
        });
    }
}

// Detecta mudanças no select de módulos
$('#modulo').on('change', function() {
    var moduloSelecionado = $(this).val();
    carregarFrequencia(moduloSelecionado);
});