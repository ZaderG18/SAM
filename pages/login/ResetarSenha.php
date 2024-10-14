<?php
// Verifica se o token está presente na URL
if (!isset($_GET['token'])) {
    die('Token não fornecido.');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/scss/login/ResetarSenha.scss">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- Link para o CDN dos ícones Bootstrap -->
    <title>Reset de Senha</title>
    <link rel="icon" href="../../assets/img/Group 4.png" type="image/png"> <!-- Ícone da aba do navegador -->
    <script>
        // Função para mostrar ou esconder a senha
        function mostrarSenha() {
            const senhaInput = document.getElementById("senha");
            const senhaIcon = document.getElementById("btn-senha");
            senhaInput.type = senhaInput.type === "password" ? "text" : "password";
            senhaIcon.classList.toggle("bi-eye");
            senhaIcon.classList.toggle("bi-eye-slash");
        }

        // Função para mostrar ou esconder a confirmação da senha
        function mostrarSenhaConfirm() {
            const senhaConfirmInput = document.getElementById("senha-confirmada");
            const senhaConfirmIcon = document.getElementById("btn-senha-confirm");
            senhaConfirmInput.type = senhaConfirmInput.type === "password" ? "text" : "password";
            senhaConfirmIcon.classList.toggle("bi-eye");
            senhaConfirmIcon.classList.toggle("bi-eye-slash");
        }
    </script>
</head>
<body>
    <main>
        <div class="container">
            <div class="flex-elements">
                <div class="left-img"></div>
                <div class="right-reset">
                    <form action="../../php/login/recuperarSenha.php" method="post">

                        <div class="headerbx">
                            <h2>Resetar Senha</h2>
                            <p>Escolha uma nova senha para sua conta</p>
                        </div>
                        <!-- Campo de entrada para a nova senha -->
                         <div class="box-input">
                            <span>Nova senha</span>
                            <div class="inputbx">
                                <input type="password" name="new_password" id="senha" placeholder="Mínimo 8 caracteres" required> <!-- Campo para nova senha -->
                                <i class="bi bi-eye" id="btn-senha" onclick="mostrarSenha()"></i> <!-- Ícone para exibir/ocultar senha -->
                            </div>
                         </div>

                         <!-- Campo para confirmar a nova senha -->
                         <div class="box-input">
                            <span>Confirmação nova senha</span>
                            <div class="inputbx">
                                <input type="password" name="new_password_confirm" id="senha-confirmada" placeholder="Mínimo 8 caracteres" required> <!-- Confirmação -->
                                <i class="bi bi-eye" id="btn-senha-confirm" onclick="mostrarSenhaConfirm()"></i> <!-- Ícone para exibir/ocultar senha -->
                            </div>
                         </div>

                         <!-- Campo oculto para o token de redefinição -->
                         <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">

                        <!-- Botão de envio -->
                        <div class="inputbx">
                            <input type="submit" value="Resetar Senha" id="reset">
                        </div>

                        <!-- Botão de voltar -->
                        <div class="inputbx" style="margin-top: 30px;">
                            <input type="button" value="Voltar" id="voltar" onclick="window.location.href='../../index.html'"> 
                        </div>
                    </form> <!-- Fim do formulário -->
                </div><!-- caixa da direita, onde ficam os inputs de reset de senha -->
            </div>
        </div>
    </main>
</body>
</html>
