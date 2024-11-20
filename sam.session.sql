-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/11/2024 às 00:30
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

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
-- Estrutura para tabela `academico`
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
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `id` int(11) NOT NULL,
  `matricula` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividade`
--

CREATE TABLE `atividade` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `professor_id` int(11) NOT NULL,
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
-- Estrutura para tabela `atividade_extracurricular`
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
-- Estrutura para tabela `atualizacoes`
--

CREATE TABLE `atualizacoes` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
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
-- Estrutura para tabela `contato_emergencia`
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
-- Estrutura para tabela `coordenador`
--

CREATE TABLE `coordenador` (
  `id` int(11) NOT NULL,
  `setor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cronograma`
--

CREATE TABLE `cronograma` (
  `id` int(11) NOT NULL,
  `horario` varchar(20) NOT NULL,
  `dia` varchar(10) NOT NULL,
  `disciplina` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso`
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
-- Estrutura para tabela `declaracao`
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
-- Estrutura para tabela `diretor`
--

CREATE TABLE `diretor` (
  `id` int(11) NOT NULL,
  `nivel_acesso` enum('junior','senior','executivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `id` int(11) NOT NULL,
  `nome_disciplina` varchar(30) NOT NULL,
  `carga_horaria` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `coordenador_id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
  `declaracao_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `enquetes`
--

CREATE TABLE `enquetes` (
  `id` int(11) NOT NULL,
  `pergunta` varchar(255) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `resposta` varchar(255) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `enquete_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enquetes`
--

INSERT INTO `enquetes` (`id`, `pergunta`, `tipo`, `resposta`, `comentario`, `enquete_id`) VALUES
(1, 'Como você avalia a participação dos alunos nas aulas online?', NULL, NULL, NULL, NULL),
(2, 'Qual matéria você considera mais desafiadora para ensinar?', NULL, NULL, NULL, NULL),
(3, 'Qual aluno você acha mais participativo?', NULL, NULL, NULL, NULL),
(4, 'Você está satisfeito com o suporte da secretaria acadêmica?', NULL, NULL, NULL, NULL),
(5, 'Como você avalia o desempenho geral dos alunos no curso?', NULL, NULL, NULL, NULL),
(6, 'Qual a sua opinião sobre a infraestrutura da escola?', NULL, NULL, NULL, NULL),
(7, NULL, NULL, 'Muito boa', NULL, 1),
(8, NULL, NULL, 'Boa', NULL, 1),
(9, NULL, NULL, 'Regular', NULL, 1),
(10, NULL, NULL, 'Ruim', NULL, 1),
(11, NULL, NULL, 'Análises de Projetos', NULL, 2),
(12, NULL, NULL, 'Programação Mobile', NULL, 2),
(13, NULL, NULL, 'Desenvolvimento Web', NULL, 2),
(14, NULL, NULL, 'Programação', NULL, 2),
(15, NULL, NULL, 'Aluno A', NULL, 3),
(16, NULL, NULL, 'Aluno B', NULL, 3),
(17, NULL, NULL, 'Aluno C', NULL, 3),
(18, NULL, NULL, 'Aluno D', NULL, 3),
(19, NULL, NULL, 'Sim', NULL, 4),
(20, NULL, NULL, 'Não', NULL, 4),
(21, NULL, NULL, 'Excelente', NULL, 5),
(22, NULL, NULL, 'Bom', NULL, 5),
(23, NULL, NULL, 'Regular', NULL, 5),
(24, NULL, NULL, 'Ruim', NULL, 5),
(25, NULL, NULL, 'Excelente', NULL, 6),
(26, NULL, NULL, 'Boa', NULL, 6),
(27, NULL, NULL, 'Regular', NULL, 6),
(28, NULL, NULL, 'Ruim', NULL, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
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
-- Estrutura para tabela `frequencia`
--

CREATE TABLE `frequencia` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
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
-- Estrutura para tabela `historico_academico`
--

CREATE TABLE `historico_academico` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
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
-- Estrutura para tabela `horario`
--

CREATE TABLE `horario` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
  `declaracao_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `frequencia_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  `dia_semana` enum('Segunda','Terça','Quarta','Quinta','Sexta','Sábado') DEFAULT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `progresso` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `matricula`
--

CREATE TABLE `matricula` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
  `frequencia_id` int(11) NOT NULL,
  `historico_academico_id` int(11) NOT NULL,
  `data_matricula` date NOT NULL,
  `status` enum('ativo','inativo','concluido') DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens_chat`
--

CREATE TABLE `mensagens_chat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receptor_id` int(11) NOT NULL,
  `tipo_chat` enum('privado','grupo') DEFAULT 'privado',
  `chat_turma` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `modulo`
--

CREATE TABLE `modulo` (
  `id` int(11) NOT NULL,
  `nome_modulo` varchar(255) NOT NULL,
  `descricao_modulo` text DEFAULT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `turma_id` int(11) DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `matricula_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `nota1` decimal(5,2) DEFAULT NULL,
  `nota2` decimal(5,2) DEFAULT NULL,
  `nota_media` decimal(5,2) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `data_avaliacao` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
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
-- Estrutura para tabela `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `departamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `rematricula`
--

CREATE TABLE `rematricula` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `data_rematricula` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `secretaria`
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
-- Estrutura para tabela `turma`
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
-- Estrutura para tabela `usuarios`
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
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `RM`, `cpf`, `foto`, `email`, `senha`, `reset_token`, `reset_expires`, `nome`, `telefone`, `estado_civil`, `data_nascimento`, `genero`, `endereco`, `cargo`, `status`, `data_matricula`, `data_rematricula`, `nacionalidade`, `data_saida`, `data_criacao`, `updated_at`) VALUES
(1, '3584', NULL, NULL, 'alencar@gmail.com', '$2y$10$VSmI5r3ty4DBNc9iplMHE.kKkfAmdVkdmbn9qXCagxVbiGgsFK.4C', NULL, NULL, 'alencar moreira', NULL, NULL, '0000-00-00', 'masculino', NULL, 'professor', 'ativo', NULL, NULL, NULL, NULL, '2024-11-19 22:29:25', '2024-11-19 22:29:25');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `academico`
--
ALTER TABLE `academico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_academico_aluno` (`aluno_id`);

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD KEY `fk_aluno_usuarios` (`id`);

--
-- Índices de tabela `atividade`
--
ALTER TABLE `atividade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atividade_turma` (`turma_id`),
  ADD KEY `fk_atividade_aluno` (`aluno_id`),
  ADD KEY `fk_atividade_id` (`professor_id`);

--
-- Índices de tabela `atividade_extracurricular`
--
ALTER TABLE `atividade_extracurricular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ati_extra_usuarios` (`aluno_id`);

--
-- Índices de tabela `atualizacoes`
--
ALTER TABLE `atualizacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atualizacao_aluno` (`aluno_id`),
  ADD KEY `fk_atualizacoes_professor` (`professor_id`);

--
-- Índices de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_avaliacao_aluno` (`aluno_id`),
  ADD KEY `fk_avaliacao_turma` (`turma_id`);

--
-- Índices de tabela `contato_emergencia`
--
ALTER TABLE `contato_emergencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contato_aluno` (`aluno_id`),
  ADD KEY `fk_contato_professor` (`professor_id`);

--
-- Índices de tabela `coordenador`
--
ALTER TABLE `coordenador`
  ADD KEY `fk_coordenador` (`id`);

--
-- Índices de tabela `cronograma`
--
ALTER TABLE `cronograma`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso_professor` (`fk_professor_id`);

--
-- Índices de tabela `declaracao`
--
ALTER TABLE `declaracao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `protocolo` (`protocolo`),
  ADD KEY `fk_declaracao_turma` (`turma_id`),
  ADD KEY `fk_declaracao_usuarios` (`usuario_id`);

--
-- Índices de tabela `diretor`
--
ALTER TABLE `diretor`
  ADD KEY `fk_diretor` (`id`);

--
-- Índices de tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_disciplina_avaliacao` (`avaliacao_id`),
  ADD KEY `fk_disciplina_professor` (`professor_id`),
  ADD KEY `fk_disciplina_aluno` (`aluno_id`),
  ADD KEY `fk_disciplina_coordenador` (`coordenador_id`);

--
-- Índices de tabela `enquetes`
--
ALTER TABLE `enquetes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_enquetes` (`enquete_id`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_eventos_aluno` (`aluno_id`);

--
-- Índices de tabela `frequencia`
--
ALTER TABLE `frequencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_frequencia_disciplina` (`disciplina_id`),
  ADD KEY `fk_frequencia_aluno` (`aluno_id`),
  ADD KEY `fk_frequencia_turma` (`turma_id`),
  ADD KEY `fk_frequencia_professor` (`professor_id`),
  ADD KEY `fk_frequencia_declaracao` (`declaracao_id`),
  ADD KEY `fk_frequencia_avaliacao` (`avaliacao_id`);

--
-- Índices de tabela `historico_academico`
--
ALTER TABLE `historico_academico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_historico_aluno_id` (`aluno_id`),
  ADD KEY `fk_historico_disciplina_id` (`disciplina_id`),
  ADD KEY `fk_historico_turma` (`turma_id`),
  ADD KEY `fk_historico_avaliacao` (`avaliacao_id`),
  ADD KEY `fk_historico_declaracao` (`declaracao_id`),
  ADD KEY `fk_historico_frequencia` (`frequencia_id`);

--
-- Índices de tabela `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_horario_aluno` (`aluno_id`),
  ADD KEY `fk_professor_horario` (`professor_id`),
  ADD KEY `fk_horario_disciplina` (`disciplina_id`),
  ADD KEY `fk_horario_turma` (`turma_id`),
  ADD KEY `fk_horario_avaliacao` (`avaliacao_id`),
  ADD KEY `fk_horario_declaracao` (`declaracao_id`),
  ADD KEY `fk_horario_frequencia` (`frequencia_id`);

--
-- Índices de tabela `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_matricula_aluno` (`aluno_id`),
  ADD KEY `fk_matricula_turma` (`turma_id`),
  ADD KEY `fk_matricula_historico` (`historico_academico_id`),
  ADD KEY `fk_matricula_avaliacao` (`avaliacao_id`),
  ADD KEY `fk_matricula_frequencia` (`frequencia_id`);

--
-- Índices de tabela `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_receptor_id` (`receptor_id`),
  ADD KEY `fk_mensagem_turma` (`chat_turma`);

--
-- Índices de tabela `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_modulo_turma` (`turma_id`),
  ADD KEY `fk_modulo_matricula` (`matricula_id`),
  ADD KEY `fk_modulo_aluno` (`aluno_id`);

--
-- Índices de tabela `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notas_aluno` (`aluno_id`),
  ADD KEY `fk_notas_disciplina` (`disciplina_id`),
  ADD KEY `fk_notas_turma` (`turma_id`),
  ADD KEY `fk_notas_modulo` (`modulo_id`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notificacoes_user` (`user_id`);

--
-- Índices de tabela `professor`
--
ALTER TABLE `professor`
  ADD KEY `fk_usuarios` (`id`);

--
-- Índices de tabela `rematricula`
--
ALTER TABLE `rematricula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rematricula_aluno` (`aluno_id`);

--
-- Índices de tabela `secretaria`
--
ALTER TABLE `secretaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_secretaria_diretor` (`diretor_id`),
  ADD KEY `fk_secretaria_coordendor` (`coordenador_id`),
  ADD KEY `fk_secretaria_professor` (`professor_id`);

--
-- Índices de tabela `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_turma_disciplina` (`disciplina_id`),
  ADD KEY `fk_turma_professor` (`professor_id`),
  ADD KEY `fk_turma_coordenador` (`coordenador_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `RM` (`RM`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
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
-- AUTO_INCREMENT de tabela `cronograma`
--
ALTER TABLE `cronograma`
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
-- AUTO_INCREMENT de tabela `enquetes`
--
ALTER TABLE `enquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `academico`
--
ALTER TABLE `academico`
  ADD CONSTRAINT `fk_academico_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_aluno_usuarios` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `fk_atividade_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_atividade_id` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_atividade_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `atividade_extracurricular`
--
ALTER TABLE `atividade_extracurricular`
  ADD CONSTRAINT `fk_ati_extra_usuarios` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `atualizacoes`
--
ALTER TABLE `atualizacoes`
  ADD CONSTRAINT `fk_atualizacao_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_atualizacoes_professor` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `fk_avaliacao_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_avaliacao_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `contato_emergencia`
--
ALTER TABLE `contato_emergencia`
  ADD CONSTRAINT `fk_contato_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_contato_professor` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `coordenador`
--
ALTER TABLE `coordenador`
  ADD CONSTRAINT `fk_coordenador` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_curso_professor` FOREIGN KEY (`fk_professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `declaracao`
--
ALTER TABLE `declaracao`
  ADD CONSTRAINT `fk_declaracao_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_declaracao_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `diretor`
--
ALTER TABLE `diretor`
  ADD CONSTRAINT `fk_diretor` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `disciplina`
--
ALTER TABLE `disciplina`
  ADD CONSTRAINT `fk_disciplina_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_disciplina_avaliacao` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_disciplina_coordenador` FOREIGN KEY (`coordenador_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_disciplina_professor` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `enquetes`
--
ALTER TABLE `enquetes`
  ADD CONSTRAINT `fk_enquetes` FOREIGN KEY (`enquete_id`) REFERENCES `enquetes` (`id`);

--
-- Restrições para tabelas `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_eventos_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `frequencia`
--
ALTER TABLE `frequencia`
  ADD CONSTRAINT `fk_frequencia_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_frequencia_avaliacao` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_frequencia_declaracao` FOREIGN KEY (`declaracao_id`) REFERENCES `declaracao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_frequencia_disciplina` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_frequencia_professor` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_frequencia_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `historico_academico`
--
ALTER TABLE `historico_academico`
  ADD CONSTRAINT `fk_historico_aluno_id` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_historico_avaliacao` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_historico_declaracao` FOREIGN KEY (`declaracao_id`) REFERENCES `declaracao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_historico_disciplina_id` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_historico_frequencia` FOREIGN KEY (`frequencia_id`) REFERENCES `frequencia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_historico_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `fk_horario_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_horario_avaliacao` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_horario_declaracao` FOREIGN KEY (`declaracao_id`) REFERENCES `declaracao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_horario_disciplina` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_horario_frequencia` FOREIGN KEY (`frequencia_id`) REFERENCES `frequencia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_horario_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_professor_horario` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `fk_matricula_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_matricula_avaliacao` FOREIGN KEY (`avaliacao_id`) REFERENCES `avaliacao` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_matricula_frequencia` FOREIGN KEY (`frequencia_id`) REFERENCES `frequencia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_matricula_historico` FOREIGN KEY (`historico_academico_id`) REFERENCES `historico_academico` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_matricula_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `mensagens_chat`
--
ALTER TABLE `mensagens_chat`
  ADD CONSTRAINT `fk_mensagem_turma` FOREIGN KEY (`chat_turma`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_receptor_id` FOREIGN KEY (`receptor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `fk_modulo_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_modulo_matricula` FOREIGN KEY (`matricula_id`) REFERENCES `matricula` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_modulo_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `fk_notas_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_notas_disciplina` FOREIGN KEY (`disciplina_id`) REFERENCES `disciplina` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_notas_modulo` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_notas_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `fk_notificacoes_user` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `fk_usuarios` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `rematricula`
--
ALTER TABLE `rematricula`
  ADD CONSTRAINT `fk_rematricula_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `secretaria`
--
ALTER TABLE `secretaria`
  ADD CONSTRAINT `fk_secretaria_coordendor` FOREIGN KEY (`coordenador_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_secretaria_diretor` FOREIGN KEY (`diretor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_secretaria_professor` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `fk_turma_coordenador` FOREIGN KEY (`coordenador_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_turma_disciplina` FOREIGN KEY (`disciplina_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_turma_professor` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
