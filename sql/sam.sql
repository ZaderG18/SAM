-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Nov-2024 às 01:46
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sam`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `academico`
--

CREATE TABLE `academico` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `curso` varchar(255) DEFAULT NULL,
  `periodo` varchar(50) DEFAULT NULL,
  `modulo_atual` int(11) DEFAULT NULL,
  `turma` varchar(50) DEFAULT NULL,
  `nome_professor` varchar(255) DEFAULT NULL,
  `bolsas_auxilios` varchar(255) DEFAULT NULL,
  `horas_complementares` int(11) DEFAULT NULL,
  `estagio_atual` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `id` int(11) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `curso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade`
--

CREATE TABLE `atividade` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `data_vencimento` date DEFAULT NULL,
  `hora_vencimento` time DEFAULT NULL,
  `arquivo` longblob DEFAULT NULL,
  `data_entrega` date NOT NULL,
  `criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('pendente','concluida') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade_extracurricular`
--

CREATE TABLE `atividade_extracurricular` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `tipo_atividade` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `carga_horaria` int(11) DEFAULT NULL,
  `certificado` longblob DEFAULT NULL,
  `criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('em_andamento','concluida','cancelada') DEFAULT 'em_andamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atualizacoes`
--

CREATE TABLE `atualizacoes` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `data_atualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `nota` decimal(3,2) NOT NULL CHECK (`nota` >= 0 and `nota` <= 10),
  `data_avaliacao` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato_emergencia`
--

CREATE TABLE `contato_emergencia` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `nome_emergencia` varchar(255) DEFAULT NULL,
  `parente_emergencia` varchar(50) DEFAULT NULL,
  `telefone_emergencia` varchar(20) DEFAULT NULL,
  `email_emergencia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coordenador`
--

CREATE TABLE `coordenador` (
  `id` int(11) NOT NULL,
  `setor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_curso` varchar(255) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `carga_horaria` int(6) NOT NULL,
  `pre_requisitos` varchar(255) DEFAULT NULL,
  `tipo_curso` varchar(50) NOT NULL,
  `nivel_curso` varchar(50) NOT NULL,
  `periodo` varchar(100) NOT NULL,
  `status_curso` varchar(50) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_termino` date NOT NULL,
  `vagas` int(6) NOT NULL,
  `modalidade` varchar(100) NOT NULL,
  `material_recurso` text DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `imagem_curso` varchar(255) NOT NULL,
  `fk_professor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `declaracao`
--

CREATE TABLE `declaracao` (
  `id` int(11) NOT NULL,
  `tipo_declaracao` varchar(50) DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `protocolo` varchar(50) DEFAULT NULL,
  `data_solicitacao` datetime DEFAULT current_timestamp(),
  `status` enum('pendente','pronto') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `diretor`
--

CREATE TABLE `diretor` (
  `id` int(11) NOT NULL,
  `nivel_acesso` enum('junior','senior','executivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `id` int(11) NOT NULL,
  `nome_disciplina` varchar(30) NOT NULL,
  `carga_horaria` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `coordenador_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
  `declaracao_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `frequencia`
--

CREATE TABLE `frequencia` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `declaracao_id` int(11) NOT NULL,
  `aulas_dadas` int(11) DEFAULT NULL,
  `faltas` int(11) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `faltas_permitidas` int(11) DEFAULT NULL,
  `frequencia_atual` decimal(5,2) DEFAULT NULL,
  `frequencia_total` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `presenca` tinyint(1) NOT NULL,
  `disciplina_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico_academico`
--

CREATE TABLE `historico_academico` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
  `declaracao_id` int(11) NOT NULL,
  `frequencia_id` int(11) NOT NULL,
  `semestre` varchar(10) NOT NULL,
  `faltas` int(11) DEFAULT 0,
  `nota` decimal(4,2) DEFAULT NULL,
  `status` enum('aprovado','reprovado','pendente') NOT NULL DEFAULT 'pendente',
  `data_conclusao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario`
--

CREATE TABLE `horario` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
  `declaracao_id` int(11) NOT NULL,
  `frequencia_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  `dia_semana` enum('Segunda','Terça','Quarta','Quinta','Sexta','Sábado') DEFAULT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `progresso` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `matricula`
--

CREATE TABLE `matricula` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
  `frequencia_id` int(11) NOT NULL,
  `historico_academico_id` int(11) NOT NULL,
  `data_matricula` date NOT NULL,
  `status` enum('ativo','inativo','concluido') DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens_chat`
--

CREATE TABLE `mensagens_chat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receptor_id` int(11) NOT NULL,
  `chat_turma` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulo`
--

CREATE TABLE `modulo` (
  `id` int(11) NOT NULL,
  `nome_modulo` varchar(255) NOT NULL,
  `descricao_modulo` text DEFAULT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `turma_id` int(11) DEFAULT NULL,
  `matricula_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `nota1` decimal(5,2) DEFAULT NULL,
  `nota2` decimal(5,2) DEFAULT NULL,
  `nota_media` decimal(5,2) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `data_avaliacao` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tipo_usuarios` enum('aluno','professor','coordenador','diretor') NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `lida` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `departamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rematricula`
--

CREATE TABLE `rematricula` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `data_rematricula` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `secretaria`
--

CREATE TABLE `secretaria` (
  `id` int(11) NOT NULL,
  `tipo` enum('horario','prazo_documentos','comunicado_rematricula','equipe','documentos_necessarios','eventos','faq','formulario_suporte') NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `prazo` int(11) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `pergunta` text DEFAULT NULL,
  `resposta` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `diretor_id` int(11) DEFAULT NULL,
  `coordenador_id` int(11) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

CREATE TABLE `turma` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `coordenador_id` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `status` enum('ativa','concluida','cancelada') DEFAULT 'ativa',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `RM` varchar(10) NOT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `nome` varchar(40) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `estado_civil` varchar(50) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `genero` enum('masculino','feminino','nao-binario','prefiro-nao-dizer') NOT NULL,
  `endereco` text DEFAULT NULL,
  `cargo` enum('aluno','professor','diretor','coordenador') NOT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `data_matricula` date DEFAULT NULL,
  `data_rematricula` date DEFAULT NULL,
  `nacionalidade` varchar(50) DEFAULT NULL,
  `data_saida` date DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `RM`, `cpf`, `foto`, `email`, `senha`, `reset_token`, `reset_expires`, `nome`, `telefone`, `estado_civil`, `data_nascimento`, `genero`, `endereco`, `cargo`, `status`, `data_matricula`, `data_rematricula`, `nacionalidade`, `data_saida`, `data_criacao`, `updated_at`) VALUES
(1, '4232', NULL, NULL, 'arthur@gmail.com', '$2y$10$I/X02y3vTxm8hYZYTT5.5.SA/olBkAQg5Oq5LxgySnnU6i2misK/.', NULL, NULL, 'Arthur Henrique Goes Rodrigues', NULL, NULL, '0000-00-00', 'masculino', NULL, 'aluno', 'ativo', NULL, NULL, NULL, NULL, '2024-11-01 23:35:09', '2024-11-01 23:35:09');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `academico`
--
ALTER TABLE `academico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD KEY `id` (`id`);

--
-- Índices para tabela `atividade`
--
ALTER TABLE `atividade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `turma_id` (`turma_id`);

--
-- Índices para tabela `atividade_extracurricular`
--
ALTER TABLE `atividade_extracurricular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices para tabela `atualizacoes`
--
ALTER TABLE `atualizacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices para tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `turma_id` (`turma_id`);

--
-- Índices para tabela `contato_emergencia`
--
ALTER TABLE `contato_emergencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Índices para tabela `coordenador`
--
ALTER TABLE `coordenador`
  ADD KEY `id` (`id`);

--
-- Índices para tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_professor_id` (`fk_professor_id`);

--
-- Índices para tabela `declaracao`
--
ALTER TABLE `declaracao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `protocolo` (`protocolo`),
  ADD KEY `turma_id` (`turma_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices para tabela `diretor`
--
ALTER TABLE `diretor`
  ADD KEY `id` (`id`);

--
-- Índices para tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `coordenador_id` (`coordenador_id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `avaliacao_id` (`avaliacao_id`),
  ADD KEY `declaracao_id` (`declaracao_id`);

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices para tabela `frequencia`
--
ALTER TABLE `frequencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disciplina_id` (`disciplina_id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `turma_id` (`turma_id`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `declaracao_id` (`declaracao_id`),
  ADD KEY `avaliacao_id` (`avaliacao_id`);

--
-- Índices para tabela `historico_academico`
--
ALTER TABLE `historico_academico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_aluno_id` (`aluno_id`),
  ADD KEY `fk_disciplina_id` (`disciplina_id`),
  ADD KEY `turma_id` (`turma_id`),
  ADD KEY `avaliacao_id` (`avaliacao_id`),
  ADD KEY `declaracao_id` (`declaracao_id`),
  ADD KEY `frequencia_id` (`frequencia_id`);

--
-- Índices para tabela `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `disciplina_id` (`disciplina_id`),
  ADD KEY `turma_id` (`turma_id`),
  ADD KEY `avaliacao_id` (`avaliacao_id`),
  ADD KEY `declaracao_id` (`declaracao_id`),
  ADD KEY `frequencia_id` (`frequencia_id`);

--
-- Índices para tabela `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `turma_id` (`turma_id`),
  ADD KEY `avaliacao_id` (`avaliacao_id`),
  ADD KEY `frequencia_id` (`frequencia_id`),
  ADD KEY `historico_academico_id` (`historico_academico_id`);

--
-- Índices para tabela `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `receptor_id` (`receptor_id`),
  ADD KEY `chat_turma` (`chat_turma`);

--
-- Índices para tabela `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `turma_id` (`turma_id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices para tabela `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `disciplina_id` (`disciplina_id`),
  ADD KEY `turma_id` (`turma_id`),
  ADD KEY `modulo_id` (`modulo_id`);

--
-- Índices para tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `professor`
--
ALTER TABLE `professor`
  ADD KEY `id` (`id`);

--
-- Índices para tabela `rematricula`
--
ALTER TABLE `rematricula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices para tabela `secretaria`
--
ALTER TABLE `secretaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diretor_id` (`diretor_id`),
  ADD KEY `coordenador_id` (`coordenador_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Índices para tabela `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `coordenador_id` (`coordenador_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `RM` (`RM`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `academico`
--
ALTER TABLE `academico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `atividade`
--
ALTER TABLE `atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `atividade_extracurricular`
--
ALTER TABLE `atividade_extracurricular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `atualizacoes`
--
ALTER TABLE `atualizacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contato_emergencia`
--
ALTER TABLE `contato_emergencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `declaracao`
--
ALTER TABLE `declaracao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `frequencia`
--
ALTER TABLE `frequencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_academico`
--
ALTER TABLE `historico_academico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `matricula`
--
ALTER TABLE `matricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rematricula`
--
ALTER TABLE `rematricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `secretaria`
--
ALTER TABLE `secretaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `turma`
--
ALTER TABLE `turma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `academico`
--
ALTER TABLE `academico`
  ADD CONSTRAINT `academico_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `atividade_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `atividade_ibfk_2` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `atividade_extracurricular`
--
ALTER TABLE `atividade_extracurricular`
  ADD CONSTRAINT `atividade_extracurricular_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `atualizacoes`
--
ALTER TABLE `atualizacoes`
  ADD CONSTRAINT `atualizacoes_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `contato_emergencia`
--
ALTER TABLE `contato_emergencia`
  ADD CONSTRAINT `contato_emergencia_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `contato_emergencia_ibfk_2` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `coordenador`
--
ALTER TABLE `coordenador`
  ADD CONSTRAINT `coordenador_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`fk_professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `declaracao`
--
ALTER TABLE `declaracao`
  ADD CONSTRAINT `declaracao_ibfk_1` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `declaracao_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `diretor`
--
ALTER TABLE `diretor`
  ADD CONSTRAINT `diretor_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD CONSTRAINT `disciplina_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disciplina_ibfk_2` FOREIGN KEY (`coordenador_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disciplina_ibfk_3` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disciplina_ibfk_4` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disciplina_ibfk_5` FOREIGN KEY (`declaracao_id`) REFERENCES `declaracao` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `frequencia`
--
ALTER TABLE `frequencia`
  ADD CONSTRAINT `frequencia_ibfk_1` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `frequencia_ibfk_2` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `frequencia_ibfk_3` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `frequencia_ibfk_4` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `frequencia_ibfk_5` FOREIGN KEY (`declaracao_id`) REFERENCES `declaracao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `frequencia_ibfk_6` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `historico_academico`
--
ALTER TABLE `historico_academico`
  ADD CONSTRAINT `fk_aluno_id` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_disciplina_id` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historico_academico_ibfk_1` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historico_academico_ibfk_2` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historico_academico_ibfk_3` FOREIGN KEY (`declaracao_id`) REFERENCES `declaracao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historico_academico_ibfk_4` FOREIGN KEY (`frequencia_id`) REFERENCES `frequencia` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `horario_ibfk_2` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `horario_ibfk_3` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `horario_ibfk_4` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `horario_ibfk_5` FOREIGN KEY (`declaracao_id`) REFERENCES `declaracao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `horario_ibfk_6` FOREIGN KEY (`frequencia_id`) REFERENCES `frequencia` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `matricula_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matricula_ibfk_2` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matricula_ibfk_3` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matricula_ibfk_4` FOREIGN KEY (`frequencia_id`) REFERENCES `frequencia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matricula_ibfk_5` FOREIGN KEY (`historico_academico_id`) REFERENCES `historico_academico` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  ADD CONSTRAINT `mensagens_chat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensagens_chat_ibfk_2` FOREIGN KEY (`receptor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensagens_chat_ibfk_3` FOREIGN KEY (`chat_turma`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `modulo_ibfk_1` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `modulo_ibfk_2` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notas_ibfk_3` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notas_ibfk_4` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `rematricula`
--
ALTER TABLE `rematricula`
  ADD CONSTRAINT `rematricula_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `secretaria`
--
ALTER TABLE `secretaria`
  ADD CONSTRAINT `secretaria_ibfk_1` FOREIGN KEY (`diretor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `secretaria_ibfk_2` FOREIGN KEY (`coordenador_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `secretaria_ibfk_3` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `turma_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `turma_ibfk_2` FOREIGN KEY (`coordenador_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
