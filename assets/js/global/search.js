    // Lista de páginas
    const pages = [
        "home",
        "atividade",
        "boletim",
        "chat",
        "configurações",
        "cronograma",
        "documentos",
        "enquete",
        "faq",
        "feedback",
        "frequência",
        "histórico",
        "materiais",
        "perfil",
        "secretaria",
        "suporte"
    ];

    function showSuggestions() {
        const query = document.getElementById("searchInput").value.toLowerCase().trim();
        const suggestionsDiv = document.getElementById("suggestions");

        // Limpa as sugestões anteriores
        suggestionsDiv.innerHTML = '';

        if (query.length > 0) {
            // Filtra as páginas que começam com o que o usuário digitou
            const filteredPages = pages.filter(page => page.startsWith(query));

            // Exibe as sugestões
            filteredPages.forEach(page => {
                const suggestionItem = document.createElement("div");
                suggestionItem.className = "suggestion-item";
                suggestionItem.innerText = page;
                suggestionItem.onclick = () => {
                    // Preenche o input com a sugestão clicada e redireciona
                    document.getElementById("searchInput").value = page;
                    redirectToPage();
                };
                suggestionsDiv.appendChild(suggestionItem);
            });
        }
    }

    function redirectToPage() {
        const query = document.getElementById("searchInput").value.toLowerCase().trim();

        // Mapeia as palavras-chave para URLs
        const pageMap = {
            "home": "home_aluno.php",
            "atividade": "atividade.php",
            "boletim": "boletim.php",
            "chat": "chat.php",
            "configurações": "configuracoes.php",
            "cronograma": "cronograma.php",
            "documentos": "documentos.php",
            "enquete": "enquete.php",
            "faq": "faq.php",
            "feedback": "feedback.php",
            "frequência": "frequencia.php",
            "histórico": "historico.php",
            "materiais": "materiais.php",
            "perfil": "perfil.php",
            "secretaria": "secretaria.php",
            "suporte": "suporte.php"
        };

        // Verifica e redireciona
        if (pageMap[query]) {
            window.location.href = pageMap[query];
        } else {
            alert("Página não encontrada. Tente outra busca.");
        }
    }