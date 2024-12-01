-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/12/2024 às 00:38
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

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

--
-- Despejando dados para a tabela `academico`
--

INSERT INTO `academico` (`id`, `aluno_id`, `curso`, `periodo`, `modulo_atual`, `turma`, `nome_professor`, `bolsas_auxilios`, `horas_complementares`, `estagio_atual`) VALUES
(1, 1, 'Sistemas de Informação', 'Noturno', 3, 'Turma A', 'Prof. Carlos', 'Nenhuma', 20, 'Desenvolvimento Web');

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `id` int(11) NOT NULL,
  `matricula` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`id`, `matricula`) VALUES
(1, '2023012345');

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
  `status` enum('pendente','concluida') DEFAULT 'pendente',
  `titulo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `atividade`
--

INSERT INTO `atividade` (`id`, `aluno_id`, `turma_id`, `descricao`, `professor_id`, `data_vencimento`, `hora_vencimento`, `arquivo`, `data_entrega`, `criacao`, `atualizacao`, `status`, `titulo`) VALUES
(1, 1, 1, 'Trabalho de Pesquisa', 1, '2024-11-10', '23:59:00', NULL, '2024-11-09', '2024-11-14 16:41:45', '2024-11-14 16:41:45', 'pendente', NULL),
(2, 1, 1, 'Trabalho de Pesquisa', 2, '2024-11-10', '23:59:00', NULL, '2024-11-09', '2024-11-14 17:03:45', '2024-11-14 17:03:45', 'pendente', NULL),
(3, 1, 1, 'Trabalho de Pesquisa', 2, '2024-11-10', '23:59:00', NULL, '2024-11-09', '2024-11-14 17:04:56', '2024-11-14 17:04:56', 'pendente', NULL);

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

--
-- Despejando dados para a tabela `atividade_extracurricular`
--

INSERT INTO `atividade_extracurricular` (`id`, `aluno_id`, `tipo_atividade`, `descricao`, `data_inicio`, `data_fim`, `carga_horaria`, `certificado`, `criacao`, `atualizacao`, `status`) VALUES
(1, 1, 'Projeto de Extensão', 'Participação em evento', '2024-05-01', '2024-05-15', 40, NULL, '2024-11-14 16:30:18', '2024-11-14 16:30:18', 'em_andamento');

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

--
-- Despejando dados para a tabela `atualizacoes`
--

INSERT INTO `atualizacoes` (`id`, `aluno_id`, `descricao`, `data_atualizacao`, `professor_id`) VALUES
(1, 1, 'Atualização do cronograma de atividades', '2024-04-20 00:00:00', 1);

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

--
-- Despejando dados para a tabela `avaliacao`
--

INSERT INTO `avaliacao` (`id`, `aluno_id`, `turma_id`, `nota`, `data_avaliacao`) VALUES
(1, 1, 1, 8.50, '2024-04-10'),
(2, 1, 1, 8.50, '2024-04-10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `comunicado`
--

CREATE TABLE `comunicado` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `data` datetime NOT NULL
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

--
-- Despejando dados para a tabela `contato_emergencia`
--

INSERT INTO `contato_emergencia` (`id`, `aluno_id`, `professor_id`, `nome_emergencia`, `parente_emergencia`, `telefone_emergencia`, `email_emergencia`) VALUES
(1, 1, 2, 'Ana Silva', 'Mãe', '11999999999', 'ana@example.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `coordenador`
--

CREATE TABLE `coordenador` (
  `id` int(11) NOT NULL,
  `setor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `coordenador`
--

INSERT INTO `coordenador` (`id`, `setor`) VALUES
(1, 'Tecnologia da Informação');

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

--
-- Despejando dados para a tabela `cronograma`
--

INSERT INTO `cronograma` (`id`, `horario`, `dia`, `disciplina`) VALUES
(1, '08:00 - 09:30', 'Segunda', 'Matemática'),
(2, '10:00 - 11:30', 'Terça', 'História');

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

--
-- Despejando dados para a tabela `declaracao`
--

INSERT INTO `declaracao` (`id`, `tipo_declaracao`, `motivo`, `usuario_id`, `turma_id`, `protocolo`, `data_solicitacao`, `status`) VALUES
(1, 'Conclusão de Curso', 'Solicitação para fins de emprego', 1, 1, 'PRT20240001', '2024-11-14 13:40:28', 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `desempenho_alunos`
--

CREATE TABLE `desempenho_alunos` (
  `id` int(11) NOT NULL,
  `nome_disciplina` varchar(255) DEFAULT NULL,
  `turma` varchar(10) DEFAULT NULL,
  `desempenho` decimal(5,2) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `turma_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `desempenho_turmas`
--

CREATE TABLE `desempenho_turmas` (
  `id` int(11) NOT NULL,
  `nome_turma` varchar(255) NOT NULL,
  `media_notas` decimal(5,2) NOT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `nota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `desempenho_turmas`
--

INSERT INTO `desempenho_turmas` (`id`, `nome_turma`, `media_notas`, `professor_id`, `nota`) VALUES
(1, 'Turma A', 85.00, 1, NULL),
(2, 'Turma B', 78.50, 2, NULL),
(3, 'Turma C', 92.00, 3, NULL),
(4, 'Turma D', 65.00, 4, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `diretor`
--

CREATE TABLE `diretor` (
  `id` int(11) NOT NULL,
  `nivel_acesso` enum('junior','senior','executivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `diretor`
--

INSERT INTO `diretor` (`id`, `nivel_acesso`) VALUES
(1, 'executivo'),
(1, 'executivo');

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

--
-- Despejando dados para a tabela `disciplina`
--

INSERT INTO `disciplina` (`id`, `nome_disciplina`, `carga_horaria`, `semestre`, `ano`, `professor_id`, `coordenador_id`, `aluno_id`, `avaliacao_id`, `declaracao_id`) VALUES
(5, 'matematica', 3600, 3, 2024, 2, 3, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `enquetes`
--

CREATE TABLE `enquetes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enquetes`
--

INSERT INTO `enquetes` (`id`, `titulo`, `descricao`, `data_criacao`) VALUES
(1, 'Arthur é macho', 'sim ou claro?', '2024-11-22 20:34:00'),
(2, 'Arthur é macho', 'sim ou claro?', '2024-11-22 20:35:14'),
(3, 'aaaaaaaaaaa', 'aaaaaaaaaa', '2024-11-22 20:38:42'),
(4, 'aaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaa', '2024-11-22 20:41:27'),
(5, 'sasasa', 'sasas', '2024-11-22 20:42:59'),
(6, 'sasasa', 'sasas', '2024-11-22 20:43:21'),
(7, 'paulo', 'paulo', '2024-11-23 06:47:25'),
(8, 'paulo', 'paulo', '2024-11-23 06:48:16'),
(9, 'paulo', 'dssad', '2024-11-23 06:52:44'),
(10, 'paulo', 'asa', '2024-11-23 06:53:23'),
(11, 'paulo', 'paulo05', '2024-11-23 06:54:28'),
(12, 'paulo', 'paulo05', '2024-11-23 06:54:49'),
(13, 'sas', 'asa', '2024-11-23 07:22:38'),
(14, 'paulo', '007', '2024-11-23 07:24:01'),
(15, 'paulo', '007', '2024-11-23 07:25:32'),
(16, 'df', 'dfsd', '2024-11-23 07:29:21'),
(17, 'dfs', 'dfsdsad', '2024-11-23 07:30:15'),
(18, 'paulo', 'paulo', '2024-11-23 07:31:12'),
(19, 'sd', 'sadsad', '2024-11-23 07:50:25'),
(20, 'sad', 'sadsa', '2024-11-23 07:51:49'),
(21, 'paulo', 'asds', '2024-11-23 07:55:10'),
(22, 'Questionário da conciencia negra!', 'NEGRA', '2024-11-23 08:00:47'),
(23, 'Questionário da conciencia negra!', 'NEGRA', '2024-11-23 08:01:45'),
(24, 'Questionário da conciencia negra!', 'NEGRA', '2024-11-23 08:02:14'),
(25, 'Questionário da conciencia negra!', 'NEGRA', '2024-11-23 08:02:30'),
(26, 'Questionário da conciencia negra!', 'NEGRA', '2024-11-23 08:02:56'),
(27, 'Questionário da conciencia negra!', 'NEGRA', '2024-11-23 08:04:58'),
(28, 'sasa', 'assa', '2024-11-23 08:06:46'),
(29, 'sda', 'sadsa', '2024-11-23 08:07:26'),
(30, 'as', 'as', '2024-11-23 08:07:50'),
(31, 'Flamengo', 'Big of Rio', '2024-11-23 08:10:32'),
(32, 'paulo', 'sa', '2024-11-23 08:13:02'),
(33, 's', 'ssssss', '2024-11-23 08:14:05'),
(34, 'sssssss', 'ssssssssss', '2024-11-23 08:18:08'),
(35, 'ssss', 'sssssss', '2024-11-23 08:22:11'),
(36, 'ssss', 'sssssss', '2024-11-23 08:22:35'),
(37, 'Escola Pau Dias', 'Pau', '2024-11-23 08:25:56'),
(38, 'FLAEMGNO', 'ASA', '2024-11-23 22:00:52'),
(39, 'Governo Bolsonario', 'VOTE VOTE E CONFRIMA\r\nVOTE VOTE BOLSONARO 22', '2024-11-23 23:56:46');

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

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id`, `aluno_id`, `data`, `titulo`, `descricao`) VALUES
(1, 1, '2024-11-05', 'Semana Acadêmica', 'Palestras e workshops'),
(2, 1, '2024-11-05', 'Semana Acadêmica', 'Palestras e workshops');

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

--
-- Despejando dados para a tabela `frequencia`
--

INSERT INTO `frequencia` (`id`, `aluno_id`, `turma_id`, `status`, `avaliacao_id`, `declaracao_id`, `aulas_dadas`, `faltas`, `professor_id`, `faltas_permitidas`, `frequencia_atual`, `frequencia_total`, `data`, `presenca`, `disciplina_id`) VALUES
(4, 1, 2, 'concluida', 1, 1, 55, 5, 2, 20, 90.00, 98, '2024-11-15', 100, NULL);

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
  `frequencia_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  `dia_semana` enum('Segunda','Terça','Quarta','Quinta','Sexta','Sábado') DEFAULT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `professor_id` int(11) DEFAULT NULL
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

--
-- Despejando dados para a tabela `materias`
--

INSERT INTO `materias` (`id`, `descricao`, `progresso`) VALUES
(1, 'Matemática Aplicada', 75),
(2, 'Programação em PHP', 50);

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
  `chat_turma` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  `tipo_chat` enum('privado','grupo') DEFAULT 'privado'
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
  `matricula_id` int(11) DEFAULT NULL,
  `criterio` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `modulo`
--

INSERT INTO `modulo` (`id`, `nome_modulo`, `descricao_modulo`, `aluno_id`, `turma_id`, `curso_id`, `matricula_id`, `criterio`) VALUES
(1, 'Introdução à Programação', 'Módulo básico', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `disciplina_id` int(11) DEFAULT NULL,
  `turma_id` int(11) NOT NULL,
  `modulo_id` int(11) DEFAULT NULL,
  `recuperacao` decimal(5,2) DEFAULT NULL,
  `media_rec` decimal(5,2) DEFAULT NULL,
  `nota1` decimal(5,2) DEFAULT NULL,
  `nota2` decimal(5,2) DEFAULT NULL,
  `nota_media` decimal(5,2) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `data_avaliacao` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notas`
--

INSERT INTO `notas` (`id`, `aluno_id`, `disciplina_id`, `turma_id`, `modulo_id`, `recuperacao`, `media_rec`, `nota1`, `nota2`, `nota_media`, `observacoes`, `data_avaliacao`) VALUES
(1, 1, NULL, 0, NULL, 0.00, 0.00, 10.00, 10.00, 0.00, '', '2024-11-28'),
(2, 3, NULL, 0, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2024-11-28'),
(3, 1, NULL, 0, NULL, 0.00, 0.00, 10.00, 10.00, 0.00, '', '2024-11-28'),
(4, 3, NULL, 0, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2024-11-28'),
(5, 1, NULL, 0, NULL, 5.00, 5.00, 5.00, 7.00, 6.00, 'incrivel', '2024-11-28'),
(6, 3, NULL, 0, NULL, 6.00, 7.00, 7.00, 9.00, 8.00, 'exemplar', '2024-11-28'),
(7, 1, NULL, 0, NULL, 5.00, 6.00, 9.00, 6.00, 7.00, 'continue tentando', '2024-11-28'),
(8, 3, NULL, 0, NULL, 5.00, 5.00, 5.00, 6.00, 5.00, 'ruinzinho hein', '2024-11-28');

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

--
-- Despejando dados para a tabela `notificacoes`
--

INSERT INTO `notificacoes` (`id`, `user_id`, `tipo_usuarios`, `titulo`, `mensagem`, `imagem`, `link`, `data_criacao`, `lida`) VALUES
(1, 1, 'aluno', 'Aviso de Férias', 'As férias começam em 20 de dezembro.', NULL, NULL, '2024-11-14 16:24:49', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `opcoes`
--

CREATE TABLE `opcoes` (
  `id` int(11) NOT NULL,
  `pergunta_id` int(11) NOT NULL,
  `texto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `opcoes`
--

INSERT INTO `opcoes` (`id`, `pergunta_id`, `texto`) VALUES
(1, 2, 'sim '),
(2, 2, 'nao'),
(3, 2, 'talvez'),
(4, 4, 'sim'),
(5, 4, 'nao'),
(6, 4, 'talvez'),
(7, 6, 'aaaaaaaaaa'),
(8, 6, 'aaaaaaaaaaa'),
(9, 6, 'aaaaaaaaaaaa'),
(10, 8, 'aaaaaaaaa'),
(11, 8, 'aaaaaaaaaaaaaaaaa'),
(12, 11, 'ççççççççççççç'),
(13, 11, 'ççççççççççççç'),
(14, 14, 'paulo01'),
(15, 14, 'paulo01.1'),
(16, 19, 'paulo05'),
(17, 23, '007'),
(18, 23, '007'),
(19, 24, '008'),
(20, 24, '008'),
(21, 25, 'dsds'),
(22, 25, 'sds'),
(23, 26, 'sdsa'),
(24, 26, 'sdasd'),
(25, 27, 'sdaas'),
(26, 28, 'sdds'),
(27, 29, 'sdds'),
(28, 30, 'dsaasd'),
(29, 31, 'paulo01'),
(30, 31, 'paulo01'),
(31, 32, 'paulo02'),
(32, 32, 'paulo02'),
(33, 33, 'paulo03'),
(34, 33, 'paulo03'),
(35, 34, 'sadsad'),
(36, 35, 'asdsda'),
(37, 36, 'sim'),
(38, 36, 'claro'),
(39, 36, 'talvez'),
(40, 36, 'nao'),
(41, 37, 'sim'),
(42, 37, 'claro'),
(43, 38, 'sim'),
(44, 38, 'claro'),
(45, 39, 's'),
(46, 40, 's'),
(47, 41, 'e'),
(48, 42, 's'),
(49, 43, 'a'),
(50, 44, 'Maracanã'),
(51, 44, 'Engenhão'),
(52, 44, 'São Januário'),
(53, 45, 'Zico'),
(54, 45, 'Gabriel Barbosa (Gabigol)'),
(55, 45, 'Bebeto'),
(56, 46, 'Vasco da Gama'),
(57, 46, 'Fluminense'),
(58, 46, 'Botafogo'),
(59, 47, 'as'),
(60, 48, 'ssssss'),
(61, 49, 'sssssssss'),
(62, 50, 'sssss'),
(63, 51, 'ssssss'),
(64, 52, 'sssssssssssss'),
(65, 53, 'Matemática'),
(66, 53, 'Português'),
(67, 53, 'Ciências'),
(68, 53, 'História'),
(69, 53, 'Geografia'),
(70, 53, 'Educação Física'),
(71, 53, 'Artes'),
(72, 54, 'Excelente'),
(73, 54, 'Boa'),
(74, 54, 'Regular'),
(75, 54, 'Ruim'),
(76, 54, 'Muito ruim'),
(77, 55, 'GGG'),
(78, 55, 'GG'),
(79, 55, 'GG'),
(80, 55, 'GG'),
(81, 56, 'HHH'),
(82, 56, 'HH'),
(83, 56, 'H'),
(84, 57, 'claro'),
(85, 57, 'tenho certeza'),
(86, 57, 'vaaaaaaaaaaaaaiiiiiiiiii corithias'),
(87, 57, 'nao'),
(88, 58, 'sim'),
(89, 58, 'concerteza'),
(90, 58, 'lógico'),
(91, 58, 'AI PAI PARA !'),
(1, 2, 'sim '),
(2, 2, 'nao'),
(3, 2, 'talvez'),
(4, 4, 'sim'),
(5, 4, 'nao'),
(6, 4, 'talvez'),
(7, 6, 'aaaaaaaaaa'),
(8, 6, 'aaaaaaaaaaa'),
(9, 6, 'aaaaaaaaaaaa'),
(10, 8, 'aaaaaaaaa'),
(11, 8, 'aaaaaaaaaaaaaaaaa'),
(12, 11, 'ççççççççççççç'),
(13, 11, 'ççççççççççççç'),
(14, 14, 'paulo01'),
(15, 14, 'paulo01.1'),
(16, 19, 'paulo05'),
(17, 23, '007'),
(18, 23, '007'),
(19, 24, '008'),
(20, 24, '008'),
(21, 25, 'dsds'),
(22, 25, 'sds'),
(23, 26, 'sdsa'),
(24, 26, 'sdasd'),
(25, 27, 'sdaas'),
(26, 28, 'sdds'),
(27, 29, 'sdds'),
(28, 30, 'dsaasd'),
(29, 31, 'paulo01'),
(30, 31, 'paulo01'),
(31, 32, 'paulo02'),
(32, 32, 'paulo02'),
(33, 33, 'paulo03'),
(34, 33, 'paulo03'),
(35, 34, 'sadsad'),
(36, 35, 'asdsda'),
(37, 36, 'sim'),
(38, 36, 'claro'),
(39, 36, 'talvez'),
(40, 36, 'nao'),
(41, 37, 'sim'),
(42, 37, 'claro'),
(43, 38, 'sim'),
(44, 38, 'claro'),
(45, 39, 's'),
(46, 40, 's'),
(47, 41, 'e'),
(48, 42, 's'),
(49, 43, 'a'),
(50, 44, 'Maracanã'),
(51, 44, 'Engenhão'),
(52, 44, 'São Januário'),
(53, 45, 'Zico'),
(54, 45, 'Gabriel Barbosa (Gabigol)'),
(55, 45, 'Bebeto'),
(56, 46, 'Vasco da Gama'),
(57, 46, 'Fluminense'),
(58, 46, 'Botafogo'),
(59, 47, 'as'),
(60, 48, 'ssssss'),
(61, 49, 'sssssssss'),
(62, 50, 'sssss'),
(63, 51, 'ssssss'),
(64, 52, 'sssssssssssss'),
(65, 53, 'Matemática'),
(66, 53, 'Português'),
(67, 53, 'Ciências'),
(68, 53, 'História'),
(69, 53, 'Geografia'),
(70, 53, 'Educação Física'),
(71, 53, 'Artes'),
(72, 54, 'Excelente'),
(73, 54, 'Boa'),
(74, 54, 'Regular'),
(75, 54, 'Ruim'),
(76, 54, 'Muito ruim'),
(77, 55, 'GGG'),
(78, 55, 'GG'),
(79, 55, 'GG'),
(80, 55, 'GG'),
(81, 56, 'HHH'),
(82, 56, 'HH'),
(83, 56, 'H'),
(84, 57, 'claro'),
(85, 57, 'tenho certeza'),
(86, 57, 'vaaaaaaaaaaaaaiiiiiiiiii corithias'),
(87, 57, 'nao'),
(88, 58, 'sim'),
(89, 58, 'concerteza'),
(90, 58, 'lógico'),
(91, 58, 'AI PAI PARA !');

-- --------------------------------------------------------

--
-- Estrutura para tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id` int(11) NOT NULL,
  `enquete_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perguntas`
--

INSERT INTO `perguntas` (`id`, `enquete_id`, `titulo`) VALUES
(1, 1, 'David é preto ?'),
(2, 1, 'Fernanda e Naie são as unicas realmente descentes desse grupo ?'),
(3, 2, 'David é preto ?'),
(4, 2, 'ferandanda'),
(5, 3, 'aaaaaaaaa'),
(6, 3, 'bbbbbbbbbbbbbbbbb'),
(7, 4, 'aaaaaaaaaaaaaaaa'),
(8, 4, 'vvvvvvvvvvvvvv'),
(9, 5, 'çççççççççççççç'),
(10, 6, 'çççççççççççççç'),
(11, 6, 'ççççççççççç'),
(12, 7, 'paulo01'),
(13, 8, 'paulo01'),
(14, 8, 'paulo02'),
(15, 9, 'paulo03'),
(16, 10, 'paulo04'),
(17, 11, 'paulo05'),
(18, 12, 'paulo05'),
(19, 12, 'paulo04'),
(20, 13, 'dsadsa'),
(21, 14, '007'),
(22, 15, '007'),
(23, 15, '008'),
(24, 15, '009'),
(25, 16, 'dfsd'),
(26, 17, 'sadsa'),
(27, 17, 'asdsa'),
(28, 17, 'dsd'),
(29, 17, 'dsds'),
(30, 17, 'sdasd'),
(31, 18, 'paulo01'),
(32, 18, 'paulo02'),
(33, 18, 'paulo03'),
(34, 20, 'asd'),
(35, 21, 'sdaas'),
(36, 22, 'Espanha é racista ?'),
(37, 23, 'Espanha é racista ?'),
(38, 23, 'Vini merecia bola do meu ouro'),
(39, 25, 'Balon Dor ?'),
(40, 26, 'Balon´´Dor ?'),
(41, 28, 'e'),
(42, 29, 'Mr&#039;s'),
(43, 30, 'meu&#039;pau'),
(44, 31, 'Qual é o estádio do Flamengo?'),
(45, 31, 'Quem é o maior artilheiro da história do Flamengo?'),
(46, 31, 'Qual é o principal rival do Flamengo no futebol carioca?'),
(47, 32, 'as'),
(48, 33, 'sssss'),
(49, 34, 'ssssssss'),
(50, 34, 'sssss'),
(51, 35, 'ssssss'),
(52, 36, 'ssssss'),
(53, 37, 'Qual a sua matéria favorita?'),
(54, 37, 'Como você avalia a qualidade do ensino da sua escola?'),
(55, 38, 'GGGGGGG'),
(56, 38, 'HHHHHHHHH'),
(57, 39, 'Governo foi ruim ?'),
(58, 39, 'Bolsonaro tem um caso com  Dilma?'),
(1, 1, 'David é preto ?'),
(2, 1, 'Fernanda e Naie são as unicas realmente descentes desse grupo ?'),
(3, 2, 'David é preto ?'),
(4, 2, 'ferandanda'),
(5, 3, 'aaaaaaaaa'),
(6, 3, 'bbbbbbbbbbbbbbbbb'),
(7, 4, 'aaaaaaaaaaaaaaaa'),
(8, 4, 'vvvvvvvvvvvvvv'),
(9, 5, 'çççççççççççççç'),
(10, 6, 'çççççççççççççç'),
(11, 6, 'ççççççççççç'),
(12, 7, 'paulo01'),
(13, 8, 'paulo01'),
(14, 8, 'paulo02'),
(15, 9, 'paulo03'),
(16, 10, 'paulo04'),
(17, 11, 'paulo05'),
(18, 12, 'paulo05'),
(19, 12, 'paulo04'),
(20, 13, 'dsadsa'),
(21, 14, '007'),
(22, 15, '007'),
(23, 15, '008'),
(24, 15, '009'),
(25, 16, 'dfsd'),
(26, 17, 'sadsa'),
(27, 17, 'asdsa'),
(28, 17, 'dsd'),
(29, 17, 'dsds'),
(30, 17, 'sdasd'),
(31, 18, 'paulo01'),
(32, 18, 'paulo02'),
(33, 18, 'paulo03'),
(34, 20, 'asd'),
(35, 21, 'sdaas'),
(36, 22, 'Espanha é racista ?'),
(37, 23, 'Espanha é racista ?'),
(38, 23, 'Vini merecia bola do meu ouro'),
(39, 25, 'Balon Dor ?'),
(40, 26, 'Balon´´Dor ?'),
(41, 28, 'e'),
(42, 29, 'Mr&#039;s'),
(43, 30, 'meu&#039;pau'),
(44, 31, 'Qual é o estádio do Flamengo?'),
(45, 31, 'Quem é o maior artilheiro da história do Flamengo?'),
(46, 31, 'Qual é o principal rival do Flamengo no futebol carioca?'),
(47, 32, 'as'),
(48, 33, 'sssss'),
(49, 34, 'ssssssss'),
(50, 34, 'sssss'),
(51, 35, 'ssssss'),
(52, 36, 'ssssss'),
(53, 37, 'Qual a sua matéria favorita?'),
(54, 37, 'Como você avalia a qualidade do ensino da sua escola?'),
(55, 38, 'GGGGGGG'),
(56, 38, 'HHHHHHHHH'),
(57, 39, 'Governo foi ruim ?'),
(58, 39, 'Bolsonaro tem um caso com  Dilma?');

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
-- Estrutura para tabela `progresso_academico`
--

CREATE TABLE `progresso_academico` (
  `id` int(11) NOT NULL,
  `nome_disciplina` varchar(255) NOT NULL,
  `progresso` int(11) NOT NULL,
  `aluno_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `progresso_academico`
--

INSERT INTO `progresso_academico` (`id`, `nome_disciplina`, `progresso`, `aluno_id`) VALUES
(1, 'Matemática', 85, 1),
(2, 'História', 72, 1),
(3, 'Física', 90, 2),
(4, 'Química', 60, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `propostas_cursos`
--

CREATE TABLE `propostas_cursos` (
  `id` int(11) NOT NULL,
  `nome_curso` varchar(255) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL,
  `departamento` varchar(255) DEFAULT NULL,
  `carga_horaria` int(11) DEFAULT NULL,
  `pre_requisitos` text DEFAULT NULL,
  `tipo_curso` varchar(50) DEFAULT NULL,
  `nivel_curso` varchar(50) DEFAULT NULL,
  `periodo` varchar(50) DEFAULT NULL,
  `status_proposta` enum('pendente','aprovado','rejeitado') DEFAULT 'pendente',
  `data_inicio` date DEFAULT NULL,
  `data_termino` date DEFAULT NULL,
  `vagas` int(11) DEFAULT NULL,
  `modalidade` varchar(50) DEFAULT NULL,
  `material_recurso` text DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `imagem_curso` varchar(255) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `aprovado_por` int(11) DEFAULT NULL,
  `data_aprovacao` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `propostas_cursos`
--

INSERT INTO `propostas_cursos` (`id`, `nome_curso`, `codigo`, `descricao`, `departamento`, `carga_horaria`, `pre_requisitos`, `tipo_curso`, `nivel_curso`, `periodo`, `status_proposta`, `data_inicio`, `data_termino`, `vagas`, `modalidade`, `material_recurso`, `observacoes`, `imagem_curso`, `professor_id`, `aprovado_por`, `data_aprovacao`) VALUES
(6, 'opoopopopo', '99', 'opopop', 'popopop', 99, NULL, 'Presencial', 'Básico', 'opopop', 'aprovado', '1111-11-11', '2222-02-22', 9, NULL, 'opop', NULL, '673a6cc3a65f5-rg_verso.jpeg', 1, 1, '2024-11-17 22:23:31'),
(7, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'aprovado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6d3858b29-rg_verso.jpeg', 1, 1, '2024-11-17 22:25:03'),
(8, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'rejeitado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6d49d980c-rg_verso.jpeg', 1, 1, '2024-11-17 22:25:18'),
(9, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'aprovado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6d638a895-rg_verso.jpeg', 1, 1, '2024-11-17 22:33:16'),
(10, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'aprovado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6f6972ee7-rg_verso.jpeg', 1, 1, '2024-11-17 22:34:20'),
(11, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'aprovado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6fc81c6a6-rg_verso.jpeg', 1, 1, '2024-11-17 22:35:54'),
(12, 'sasas', 'sssasa', 'asas', 'as', 112, NULL, 'Presencial', 'Básico', 'assa', 'rejeitado', '1111-11-11', '2222-02-22', 122, NULL, 'dsas', NULL, '673a7106dfbff-rg_verso.jpeg', 1, 1, '2024-11-17 22:41:21'),
(6, 'opoopopopo', '99', 'opopop', 'popopop', 99, NULL, 'Presencial', 'Básico', 'opopop', 'aprovado', '1111-11-11', '2222-02-22', 9, NULL, 'opop', NULL, '673a6cc3a65f5-rg_verso.jpeg', 1, 1, '2024-11-17 22:23:31'),
(7, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'aprovado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6d3858b29-rg_verso.jpeg', 1, 1, '2024-11-17 22:25:03'),
(8, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'rejeitado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6d49d980c-rg_verso.jpeg', 1, 1, '2024-11-17 22:25:18'),
(9, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'aprovado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6d638a895-rg_verso.jpeg', 1, 1, '2024-11-17 22:33:16'),
(10, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'aprovado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6f6972ee7-rg_verso.jpeg', 1, 1, '2024-11-17 22:34:20'),
(11, 'asas', '12', 'assas', 'assa', 12, NULL, 'Presencial', 'Básico', 'saddsa', 'aprovado', '1111-11-11', '2222-02-22', 2, NULL, 'sads', NULL, '673a6fc81c6a6-rg_verso.jpeg', 1, 1, '2024-11-17 22:35:54'),
(12, 'sasas', 'sssasa', 'asas', 'as', 112, NULL, 'Presencial', 'Básico', 'assa', 'rejeitado', '1111-11-11', '2222-02-22', 122, NULL, 'dsas', NULL, '673a7106dfbff-rg_verso.jpeg', 1, 1, '2024-11-17 22:41:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `relatorio`
--

CREATE TABLE `relatorio` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `data_criacao` datetime DEFAULT current_timestamp(),
  `status` enum('pendente','concluido') DEFAULT 'pendente'
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
-- Estrutura para tabela `resposta`
--

CREATE TABLE `resposta` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pergunta_id` int(11) NOT NULL,
  `opcao_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `resposta`
--

INSERT INTO `resposta` (`id`, `usuario_id`, `pergunta_id`, `opcao_id`) VALUES
(1, 2, 53, 65),
(2, 2, 54, 73),
(1, 2, 53, 65),
(2, 2, 54, 73);

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `enquete_id` int(11) NOT NULL,
  `pergunta_id` int(11) NOT NULL,
  `opcao_id` int(11) NOT NULL,
  `data_resposta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas`
--

INSERT INTO `respostas` (`id`, `enquete_id`, `pergunta_id`, `opcao_id`, `data_resposta`) VALUES
(1, 37, 53, 65, '2024-11-23 20:14:46'),
(2, 37, 54, 73, '2024-11-23 20:14:46'),
(3, 37, 53, 70, '2024-11-23 21:25:56'),
(4, 37, 54, 76, '2024-11-23 21:25:56'),
(5, 37, 53, 65, '2024-11-23 21:47:06'),
(6, 37, 54, 72, '2024-11-23 21:47:06'),
(7, 31, 44, 50, '2024-11-23 21:58:11'),
(8, 31, 45, 53, '2024-11-23 21:58:11'),
(9, 31, 46, 56, '2024-11-23 21:58:11'),
(10, 38, 55, 77, '2024-11-23 22:01:04'),
(11, 38, 56, 82, '2024-11-23 22:01:04'),
(12, 39, 57, 85, '2024-11-23 23:57:56'),
(13, 39, 58, 91, '2024-11-23 23:57:56'),
(1, 37, 53, 65, '2024-11-23 20:14:46'),
(2, 37, 54, 73, '2024-11-23 20:14:46'),
(3, 37, 53, 70, '2024-11-23 21:25:56'),
(4, 37, 54, 76, '2024-11-23 21:25:56'),
(5, 37, 53, 65, '2024-11-23 21:47:06'),
(6, 37, 54, 72, '2024-11-23 21:47:06'),
(7, 31, 44, 50, '2024-11-23 21:58:11'),
(8, 31, 45, 53, '2024-11-23 21:58:11'),
(9, 31, 46, 56, '2024-11-23 21:58:11'),
(10, 38, 55, 77, '2024-11-23 22:01:04'),
(11, 38, 56, 82, '2024-11-23 22:01:04'),
(12, 39, 57, 85, '2024-11-23 23:57:56'),
(13, 39, 58, 91, '2024-11-23 23:57:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_usuarios`
--

CREATE TABLE `respostas_usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `enquete_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `respostas_usuarios`
--

INSERT INTO `respostas_usuarios` (`id`, `nome`, `email`, `enquete_id`) VALUES
(1, 'Sergio Henrique ', 'sh2440518@gmail.com', 37),
(2, 'Sergio Henrique ', 'sergioegabriel14@gmail.com', 37),
(1, 'Sergio Henrique ', 'sh2440518@gmail.com', 37),
(2, 'Sergio Henrique ', 'sergioegabriel14@gmail.com', 37);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reuniao`
--

CREATE TABLE `reuniao` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `data` datetime NOT NULL
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
-- Estrutura para tabela `solicitacoes`
--

CREATE TABLE `solicitacoes` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_usuario` varchar(20) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
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
  `status` enum('ativo','pendente','risco','concluido') DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `turno` enum('manha','tarde','noite') DEFAULT NULL,
  `periodo` enum('1bim','2bim','3bim','4bim') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turma`
--

INSERT INTO `turma` (`id`, `nome`, `disciplina_id`, `professor_id`, `coordenador_id`, `data_inicio`, `data_fim`, `status`, `data_criacao`, `turno`, `periodo`) VALUES
(1, 'Turma A', 1, 2, 1, '2024-02-01', '2024-12-01', '', '2024-11-14 16:29:57', NULL, NULL),
(2, 'banco de dados', 2, 2, 3, '2024-08-05', '2025-12-08', '', '2024-11-15 17:54:09', 'tarde', '1bim');

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
(1, '4232', NULL, NULL, 'arthurhenriquegr818@gmail.com', '$2y$10$.OW4CDR0gz0f5QF9siZAe.pWrq/RveXAU9guyyMkbxufVOsa6ABna', NULL, NULL, 'Arthur Henrique Goes Rodrigues', NULL, NULL, '0000-00-00', 'masculino', NULL, 'aluno', 'ativo', NULL, NULL, NULL, NULL, '2024-11-10 16:05:01', '2024-11-10 16:05:01'),
(2, '2526', NULL, NULL, 'tramontino@gmail.com', '$2y$10$Rm3G6xsbYPb6N09ecoh4PO8hjjW6ue.LqLxdkdmrTo0oCUhsQ3Rli', NULL, NULL, 'tramontino da silva', NULL, NULL, '0000-00-00', 'masculino', NULL, 'professor', 'ativo', NULL, NULL, NULL, NULL, '2024-11-14 13:32:09', '2024-11-14 13:32:09'),
(3, '123456789', '12345678910', 'foto1.jpg', 'usuario1@example.com', 'senha1', NULL, NULL, 'João Silva', '11999999999', 'solteiro', '2000-01-01', 'masculino', 'Rua A, 123', 'aluno', 'ativo', '2022-02-01', '2023-02-01', 'Brasileiro', NULL, '2024-11-14 16:27:04', '2024-11-14 16:27:04'),
(4, '987654321', '10987654321', 'foto2.jpg', 'usuario2@example.com', 'senha2', NULL, NULL, 'Maria Souza', '11988888888', 'casado', '1995-05-15', 'feminino', 'Avenida B, 456', 'professor', 'ativo', '2020-03-05', NULL, 'Brasileira', NULL, '2024-11-14 16:27:04', '2024-11-14 16:27:04'),
(5, '4132', NULL, NULL, 'eli-tutu@hotmail.com', '$2y$10$ez9oP0VLzFmOTsuEy91be.cJyOGU8Wc0HRQkC17g8tnDqNQBncn1.', NULL, NULL, 'Eliane Alves Goes Rodrigues', NULL, NULL, '0000-00-00', 'masculino', NULL, 'diretor', 'ativo', NULL, NULL, NULL, NULL, '2024-11-26 14:44:06', '2024-11-26 14:45:10');

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
-- Índices de tabela `comunicado`
--
ALTER TABLE `comunicado`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `fk_professor_usuarios` (`fk_professor_id`);

--
-- Índices de tabela `declaracao`
--
ALTER TABLE `declaracao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `protocolo` (`protocolo`),
  ADD KEY `fk_declaracao_turma` (`turma_id`),
  ADD KEY `fk_declaracao_usuarios` (`usuario_id`);

--
-- Índices de tabela `desempenho_alunos`
--
ALTER TABLE `desempenho_alunos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_desempenho_turma` (`turma_id`);

--
-- Índices de tabela `desempenho_turmas`
--
ALTER TABLE `desempenho_turmas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`);

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
  ADD KEY `fk_disciplina_aluno` (`aluno_id`),
  ADD KEY `fk_disciplina_coordenador` (`coordenador_id`),
  ADD KEY `fk_professor_disciplina` (`professor_id`);

--
-- Índices de tabela `enquetes`
--
ALTER TABLE `enquetes`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `fk_horario_disciplina` (`disciplina_id`),
  ADD KEY `fk_horario_turma` (`turma_id`),
  ADD KEY `fk_horario_avaliacao` (`avaliacao_id`),
  ADD KEY `fk_horario_declaracao` (`declaracao_id`),
  ADD KEY `fk_horario_frequencia` (`frequencia_id`),
  ADD KEY `fk_professor_horario` (`professor_id`);

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
  ADD PRIMARY KEY (`id`);

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
-- Índices de tabela `progresso_academico`
--
ALTER TABLE `progresso_academico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- Índices de tabela `relatorio`
--
ALTER TABLE `relatorio`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `rematricula`
--
ALTER TABLE `rematricula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rematricula_aluno` (`aluno_id`);

--
-- Índices de tabela `reuniao`
--
ALTER TABLE `reuniao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `secretaria`
--
ALTER TABLE `secretaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_secretaria_diretor` (`diretor_id`),
  ADD KEY `fk_secretaria_coordendor` (`coordenador_id`),
  ADD KEY `fk_secretaria_professor` (`professor_id`);

--
-- Índices de tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `atividade`
--
ALTER TABLE `atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `atividade_extracurricular`
--
ALTER TABLE `atividade_extracurricular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `atualizacoes`
--
ALTER TABLE `atualizacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `comunicado`
--
ALTER TABLE `comunicado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contato_emergencia`
--
ALTER TABLE `contato_emergencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cronograma`
--
ALTER TABLE `cronograma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `declaracao`
--
ALTER TABLE `declaracao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `desempenho_alunos`
--
ALTER TABLE `desempenho_alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `desempenho_turmas`
--
ALTER TABLE `desempenho_turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `frequencia`
--
ALTER TABLE `frequencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `historico_academico`
--
ALTER TABLE `historico_academico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `progresso_academico`
--
ALTER TABLE `progresso_academico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `relatorio`
--
ALTER TABLE `relatorio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rematricula`
--
ALTER TABLE `rematricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reuniao`
--
ALTER TABLE `reuniao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `secretaria`
--
ALTER TABLE `secretaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `turma`
--
ALTER TABLE `turma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `fk_curso_professor` FOREIGN KEY (`fk_professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_professor_usuarios` FOREIGN KEY (`fk_professor_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `declaracao`
--
ALTER TABLE `declaracao`
  ADD CONSTRAINT `fk_declaracao_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_declaracao_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `desempenho_alunos`
--
ALTER TABLE `desempenho_alunos`
  ADD CONSTRAINT `fk_desempenho_turma` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `desempenho_turmas`
--
ALTER TABLE `desempenho_turmas`
  ADD CONSTRAINT `desempenho_turmas_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`);

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
  ADD CONSTRAINT `fk_disciplina_professor` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_professor_disciplina` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id`);

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
-- Restrições para tabelas `progresso_academico`
--
ALTER TABLE `progresso_academico`
  ADD CONSTRAINT `progresso_academico_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id`);

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
