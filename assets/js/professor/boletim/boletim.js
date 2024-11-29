function calcularMedia(id) {
    const nota1 = parseFloat(document.getElementById(`nota1-${id}`).value) || 0;
    const nota2 = parseFloat(document.getElementById(`nota2-${id}`).value) || 0;
    const recuperacao = parseFloat(document.getElementById(`recuperacao-${id}`).value) || 0;

    const media = (nota1 + nota2) / 2;
    document.getElementById(`media-${id}`).value = media.toFixed(2);

    // Sincronizar valor com campo oculto
    document.getElementById(`media-hidden-${id}`).value = media.toFixed(2);

    let mediaFinal = media;
    if (recuperacao > 0) {
        mediaFinal = (media + recuperacao) / 2;
    }

    document.getElementById(`media-rec-${id}`).value = mediaFinal.toFixed(2);
    document.getElementById(`media-rec-hidden-${id}`).value = mediaFinal.toFixed(2);
}
