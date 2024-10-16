
function marcarPresenca(button) {
    button.parentNode.innerHTML = "<span style='color:green;'>Presente</span>";
}

function marcarAusencia(button) {
    button.parentNode.innerHTML = "<span style='color:red;'>Ausente</span>";
}

function editarStatus(button) {
    const statusCell = button.parentNode.previousElementSibling.previousElementSibling;
    statusCell.innerHTML = `
        <button onclick="marcarPresenca(this)">Presente</button>
        <button onclick="marcarAusencia(this)">Ausente</button>
    `;
}

function salvarChamada() {
    alert('Chamada salva com sucesso!');
}
