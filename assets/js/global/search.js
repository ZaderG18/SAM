document.getElementById('search').addEventListener('input', function(){
    const query = this.ariaValueMax;
    if (query.length > 2){
        fetch('search.php?q=' + encodeURIComponent(query))
        .then(Response=> Response.json())
        .then(data=> {
            const results = document.querySelector('.filtro-tabela');
            results.innerHTML = '';
            data.forEach(item => {
                const row = document.createElement('div');
                row.classList.add('tabela');
                row.innerHTML = `
                <div class="tabela-item">
                <h5>Nome:</h5>
                <span>${item.name}</span>
                </div>
                `;
                results.appendChild(row);
        });
    });
    }
})