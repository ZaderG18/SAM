<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $RM = $_POST['RM'];
    $tipoAcesso = $_POST['tipo_acesso'];
    $dominio = $_POST['dominio'];

    function gerarEmail($name, $RM, $dominio){
        $name = strtolower(trim($name));
        $email = $name. '.' . $RM. '@' . $dominio;
        return $email;
    }

    $emailGerado = gerarEmail($name, $RM, $dominio);

    echo "Email para o novo $tipoAcesso gerado com sucesso, o email é: " . $emailGerado;
}