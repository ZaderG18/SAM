<?php
function obterNotificacoes($conn, $userId, $apenasNaoLidas = false) {
    $sql = "SELECT id, titulo, mensagem, data_criacao, lida, imagem, link 
            FROM notificacoes 
            WHERE user_id = ?";
    
    // Se for para exibir apenas as notificações não lidas
    if ($apenasNaoLidas) {
        $sql .= " AND lida = 0";
    }
    
    $sql .= " ORDER BY data_criacao DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $notificacoes = [];
    while ($row = $result->fetch_assoc()) {
        $notificacoes[] = $row;
    }
    
    $stmt->close();
    return $notificacoes;
}
?>
