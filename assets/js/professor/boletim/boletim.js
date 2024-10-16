
    function calcularMedia(id) {
        // Calcula a média das notas 1 e 2
        const nota1 = parseFloat(document.getElementById(`nota1-${id}`).value) || 0;
        const nota2 = parseFloat(document.getElementById(`nota2-${id}`).value) || 0;
        const recuperacao = parseFloat(document.getElementById(`recuperacao-${id}`).value) || 0;

        const media = (nota1 + nota2) / 2;
        document.getElementById(`media-${id}`).value = media.toFixed(2);

        // Se houver nota de recuperação, recalcula a média
        if (recuperacao > 0) {
            const mediaFinal = (media + recuperacao) / 2;
            document.getElementById(`media-rec-${id}`).value = mediaFinal.toFixed(2);
        } else {
            document.getElementById(`media-rec-${id}`).value = media.toFixed(2);
        }
    }

    function salvarNotas() {
        alert('Notas salvas com sucesso!');
        // Aqui você pode enviar os dados via API ou AJAX para um backend que trate o salvamento no banco de dados
    }

    function editarNota(id) {
        alert(`Edição da nota do aluno ${id}`);
        // Aqui você pode abrir um modal ou fazer com que os campos se tornem editáveis para edição posterior
    }

    function enviarParaCoordenacao() {
        alert('Notas enviadas para Coordenação/Diretoria com sucesso!');
        // Simule o envio dos dados via uma API ou sistema que gerencie a submissão
    }
