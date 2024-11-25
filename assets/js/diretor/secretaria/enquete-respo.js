// script.js

document.addEventListener("DOMContentLoaded", function () {
    // Exemplo de enquetes para demonstração, você pode substituir por dados reais vindos de um backend
    const enquetes = [
        {
            titulo: "Qual sua opinião sobre a qualidade das aulas?",
            descricao: "Queremos saber sua opinião sobre as aulas online.",
            opcoes: [
                { texto: "Muito bom", votos: 15, usuarios: ["Usuário A", "Usuário B", "Usuário C"] },
                { texto: "Bom", votos: 8, usuarios: ["Usuário D", "Usuário E"] },
                { texto: "Regular", votos: 4, usuarios: ["Usuário F"] },
                { texto: "Ruim", votos: 2, usuarios: ["Usuário G"] }
            ],
            comentarios: [
                { usuario: "Usuário A", texto: "Achei as aulas excelentes, mas poderiam ser mais interativas." },
                { usuario: "Usuário D", texto: "Boa, mas tive problemas técnicos às vezes." },
                { usuario: "Usuário G", texto: "Não gostei muito do formato." }
            ]
        },
        // Adicionar mais enquetes conforme necessário
    ];

    const enquetesContainer = document.querySelector(".enquetes-respondidas");

    enquetes.forEach(enquete => {
        const enqueteDiv = document.createElement("div");
        enqueteDiv.classList.add("enquete");

        enqueteDiv.innerHTML = `
            <h2>Enquete: ${enquete.titulo}</h2>
            <p><strong>Descrição:</strong> ${enquete.descricao}</p>
            <div class="respostas-opcoes">
                ${enquete.opcoes.map(opcao => `
                    <div class="opcao">
                        <span><strong>${opcao.texto}:</strong> ${opcao.votos} votos</span>
                        <ul>
                            ${opcao.usuarios.map(usuario => `<li>${usuario}</li>`).join("")}
                        </ul>
                    </div>
                `).join("")}
            </div>
            <div class="comentarios">
                <h3>Comentários:</h3>
                <ul>
                    ${enquete.comentarios.map(comentario => `
                        <li><strong>${comentario.usuario}:</strong> ${comentario.texto}</li>
                    `).join("")}
                </ul>
            </div>
        `;

        enquetesContainer.appendChild(enqueteDiv);
    });
});
