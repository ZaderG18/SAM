


document.addEventListener('DOMContentLoaded', () => {
    const optionsList = document.getElementById('options-list');
    const addOptionButton = document.getElementById('add-option');

    // Adicionar nova opção de resposta
    addOptionButton.addEventListener('click', () => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `
            <input type="text" class="option-input" placeholder="Digite uma opção" required>
            <button type="button" class="btn-remove">Remover</button>
        `;
        optionsList.appendChild(listItem);

        // Adicionar funcionalidade ao botão de remover
        addRemoveEvent(listItem.querySelector('.btn-remove'));
    });

    // Adicionar funcionalidade de remover à lista inicial
    const addRemoveEvent = (button) => {
        button.addEventListener('click', (event) => {
            const listItem = event.target.parentElement;
            listItem.remove(); // Remove o item clicado
        });
    };

    // Inicializar funcionalidade de remover nos botões já existentes
    document.querySelectorAll('.btn-remove').forEach(addRemoveEvent);
});
