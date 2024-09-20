document.getElementById('search').addEventListener('input', function() {
    const query = this.value;
    if (query.length > 2) {
        fetch('../../php/search.php?q=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            const results = document.querySelector('.filtro-tabela');
            results.innerHTML = ''; // Limpar os resultados anteriores

            data.forEach(item => {
                // Criação do elemento row
                const row = document.createElement('div');
                row.classList.add('tabela-item'); // Adiciona a classe CSS ao div

                // Adicionar o conteúdo HTML dentro do row
                row.innerHTML = `
                    <div class="tabela-item">
                        <h5> Nome:</h5>
                        <span>${item.nome}</span> <!-- Nome do professor -->
                    </div>
                    <div class="box-foto">
                        <img src="../../assets/imagens/persona/${item.foto}" alt="Foto do Professor">
                    </div>
                    <div class="box-info-geral">
                        <div class="flex-info">
                            <h5>CPF:</h5>
                            <span>${item.cpf}</span>
                        </div>
                        <div class="flex-info">
                            <h5>Setor:</h5>
                            <span>${item.disciplina}</span>
                        </div>
                    </div>
                    <div class="box-RM">
                        <span>${item.rm}</span>
                    </div>
                `;

                // Adicionar o row ao container de resultados
                results.appendChild(row);
            });
        });
    }
});
