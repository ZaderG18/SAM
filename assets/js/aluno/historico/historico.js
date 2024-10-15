document.getElementById('semestre').addEventListener('change', filtrarDisciplinas);
document.getElementById('status').addEventListener('change', filtrarDisciplinas);

function filtrarDisciplinas() {
    const semestreSelecionado = document.getElementById('semestre').value;
    const statusSelecionado = document.getElementById('status').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../../php/aluno/historico.php', true); // Substitua com o caminho do arquivo PHP que processa a filtragem
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById('resultados').innerHTML = this.responseText;
        }
    };

    xhr.send('semestre=' + semestreSelecionado + '&status=' + statusSelecionado);
}
