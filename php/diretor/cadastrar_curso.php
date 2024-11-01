<?php

$conn = new mysqli("localhost", "root", "", "sam");

// Verifique se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}; // Inclui o arquivo de conexão ao banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturando os dados do formulário
    $nome_curso = $_POST['nome_curso']; // Nome do curso
    $codigo = $_POST['codigo']; // Código do curso
    $departamento = $_POST['departamento']; // Departamento responsável
    $carga_horaria = $_POST['carga_horaria']; // Carga horária do curso
    $tipo_curso = $_POST['tipo_curso']; // Tipo do curso (presencial, online, etc.)
    $nivel_curso = $_POST['nivel_curso']; // Nível do curso (básico, intermediário, avançado)
    $periodo = $_POST['periodo']; // Período em que o curso será oferecido
    $descricao = $_POST['descricao']; // Descrição do curso
    $metodologia = $_POST['metodologia']; // Metodologia a ser utilizada
    $objetivos_curso = $_POST['objetivos_curso']; // Objetivos do curso
    $pre_requisitos = $_POST['pre_requisitos']; // Pré-requisitos para o curso
    $criterios_avaliacao = $_POST['criterios_avaliacao']; // Critérios de avaliação
    $material_recurso = $_POST['material_recurso']; // Material e recursos do curso
    $modalidade = $_POST['modalidade']; // Modalidade do curso
    $vagas = $_POST['vagas']; // Número de vagas disponíveis
    $data_inicio = $_POST['data_inicio']; // Data de início do curso
    $data_termino = $_POST['data_termino']; // Data de término do curso
    $status_curso = $_POST['status_curso']; // Status do curso (ativo, inativo)
    $observacoes = $_POST['observacoes']; // Observações adicionais sobre o curso
    $professor_id = $_POST['professor']; // ID do professor associado ao curso
    
    // Lógica de upload da imagem
    $nome_imagem = ''; // Inicializa a variável que armazenará o nome da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $pasta_upload = 'uploads/'; // Pasta para salvar as imagens
        $nome_imagem = basename($_FILES['imagem']['name']); // Obtém o nome do arquivo de imagem
        $caminho_arquivo = $pasta_upload . $nome_imagem; // Define o caminho completo para o arquivo

        // Verifica se a pasta de upload existe, caso contrário, cria a pasta
        if (!is_dir($pasta_upload)) {
            mkdir($pasta_upload, 0777, true); // Cria a pasta com permissões adequadas
        }

        // Verifica se o arquivo foi movido para a pasta de uploads com sucesso
        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_arquivo)) {
            die('Erro ao fazer upload da imagem.'); // Termina a execução com uma mensagem de erro se o upload falhar
        }
    }

    // Insere o nome do arquivo no banco de dados
    $stmt = $conn->prepare("INSERT INTO cursos 
        (nome_curso, codigo, descricao, departamento, carga_horaria, pre_requisitos, tipo_curso, nivel_curso, periodo, status_curso, data_inicio, data_termino, vagas, modalidade, material_recurso, observacoes, imagem_curso, fk_professor_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verifica se houve erro na preparação da instrução SQL
    if ($stmt === false) {
        die('Erro na preparação: ' . $conn->error); // Termina a execução com uma mensagem de erro
    }

    // Associa os valores capturados às variáveis no comando SQL
    $stmt->bind_param("ssssissssssssissss", 
        $nome_curso, 
        $codigo, 
        $descricao, 
        $departamento, 
        $carga_horaria, 
        $pre_requisitos, 
        $tipo_curso, 
        $nivel_curso, 
        $periodo, 
        $status_curso, 
        $data_inicio, 
        $data_termino, 
        $vagas, 
        $modalidade, 
        $material_recurso, 
        $observacoes,
        $nome_imagem,
        $professor_id
    );

    // Executa a instrução SQL
    if ($stmt->execute()) {
        echo "<script>alert('Curso cadastrado com sucesso!');</script>"; // Exibe um alerta de sucesso
    } else {
        echo "Erro ao cadastrar o curso: " . $stmt->error; // Exibe uma mensagem de erro se a execução falhar
    }

    $stmt->close(); // Fecha a instrução preparada
    $conn->close(); // Fecha a conexão com o banco de dados
}
?>
