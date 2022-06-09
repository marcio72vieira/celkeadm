-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 09-Jun-2022 às 12:06
-- Versão do servidor: 8.0.23
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `celkeadm`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_colors`
--

CREATE TABLE `adms_colors` (
  `id` int NOT NULL,
  `name` varchar(44) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(44) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `adms_colors`
--

INSERT INTO `adms_colors` (`id`, `name`, `color`, `created`, `modified`) VALUES
(1, 'Azul', '#0275d8', '2022-06-09 11:26:32', NULL),
(2, 'Cinza', '#868e96', '2022-06-09 11:22:33', NULL),
(3, 'Verde', '#c5b85c', '2022-06-09 11:22:33', NULL),
(4, 'Vermelho', '#d9534f', '2022-06-09 11:22:33', NULL),
(5, 'Laranja', '#f0ad4e', '2022-06-09 11:22:33', NULL),
(6, 'Azul Claro', '#17a2b8', '2022-06-09 11:22:33', NULL),
(7, 'Cinza Claro', '#343a40', '2022-06-09 11:22:33', NULL),
(8, 'Branco', '#f8f9fa', '2022-06-09 11:22:33', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_confs_emails`
--

CREATE TABLE `adms_confs_emails` (
  `id` int NOT NULL,
  `title` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtpsecure` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` int NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `adms_confs_emails`
--

INSERT INTO `adms_confs_emails` (`id`, `title`, `name`, `email`, `host`, `username`, `password`, `smtpsecure`, `port`, `created`, `modified`) VALUES
(1, 'Atendimento', 'Atendimento da Empresa xxx', 'atendimento@celke.com.br', 'smtp.mailtrap.io', '4af9b091ce1883', '56a73081d75e25', 'PHPMailer::ENCRYPTION_STARTTLS', 587, '2022-06-08 09:17:59', NULL),
(2, 'Suporte', 'Suporte da Empresa xxx', 'suporte@celke.com.br', 'smtp.mailtrap.io', '4af9b091ce1883', '56a73081d75e25', 'PHPMailer::ENCRYPTION_STARTTLS', 587, '2022-06-08 09:17:59', NULL),
(3, 'Não Responder', 'Não Responder da empresa xxx', 'naoresponder@celke.com.br', 'smtp.mailtrap.io', '4af9b091ce1883', '56a73081d75e25', 'PHPMailer::ENCRYPTION_STARTTLS', 587, '2022-06-08 09:27:11', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_users`
--

CREATE TABLE `adms_sits_users` (
  `id` int NOT NULL,
  `name` varchar(44) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adms_color_id` int NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_users`
--

INSERT INTO `adms_sits_users` (`id`, `name`, `adms_color_id`, `created`, `modified`) VALUES
(1, 'Ativo', 3, '2022-06-09 11:29:30', NULL),
(2, 'Inativo', 5, '2022-06-09 11:29:30', NULL),
(3, 'Aguardando Confirmação', 1, '2022-06-09 11:29:30', NULL),
(4, 'Spam', 4, '2022-06-09 11:29:30', NULL),
(5, 'Descadastrado', 4, '2022-06-09 11:30:54', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_users`
--

CREATE TABLE `adms_users` (
  `id` int NOT NULL,
  `name` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(44) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `recover_password` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conf_email` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adms_sits_user_id` int NOT NULL DEFAULT '3',
  `image` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `adms_users`
--

INSERT INTO `adms_users` (`id`, `name`, `nickname`, `email`, `username`, `password`, `recover_password`, `conf_email`, `adms_sits_user_id`, `image`, `created`, `modified`) VALUES
(1, 'Cesar Szpak', NULL, 'cesar@celke.com.br', 'cesar@celke.com.br', '$2y$10$SEhSmEeV5aqnnJbbqWos8.k8AYOFwwrZhHpvphe0z.37aG4tQTFDa', NULL, NULL, 1, NULL, '2022-06-08 15:42:54', NULL),
(2, 'Cesar 1', NULL, 'cesar1@celke.com.br', 'cesar1@celke.com.br', '$2y$10$ZgJWvB7k5EtYDSOS1SRgmOJishBsva3JTyKuff3pi3KPugVURN.zm', NULL, NULL, 5, NULL, '2022-06-08 15:47:19', NULL),
(3, 'Cesar2', NULL, 'cesar2@celke.com.br', 'cesar2@celke.com.br', '$2y$10$XMEh02l23wsG6LjaNMdqg.98A9myvvUiodRbaBWMDqeT/oqCbZ4Ky', NULL, NULL, 3, NULL, '2022-06-08 15:50:20', NULL),
(4, 'Cesar3', NULL, 'cesar3@celke.com.br', 'cesar3@celke.com.br', '$2y$10$WltGJXjIsXy2TlvtWImreeZ7OcQDHVDXVBgaV/jhedIpf.iwRebeu', NULL, NULL, 3, NULL, '2022-06-09 08:17:44', NULL),
(5, 'Cesar4', NULL, 'cesar4@celke.com.br', 'cesar4@celke.com.br', '$2y$10$nz8/tN35.9VyTt3CTAt.Oekz8BThoM7qctPyYo6LKVxD35ZemipGO', NULL, '$2y$10$NrdUEXlcDE4ztxDaIBecLeG45qdElmvfxQ9w7QwS0j4uqxQbKdtv6', 3, NULL, '2022-06-09 08:22:00', NULL),
(7, 'Cesar5', NULL, 'cesar5@celke.com.br', 'cesar5@celke.com.br', '$2y$10$5TXBClDpXhg04fJdQYn9SOYfDRsW.lgcrXczN2jdsLKfTfWJtQv.W', NULL, '$2y$10$1f8e1r/EueXsKdaZj8aynOElwcwncYKnm1gRJzoH7gXRtIgc71sXu', 3, NULL, '2022-06-09 08:27:47', NULL),
(8, 'Cesar6', NULL, 'cesar6@celke.com.br', 'cesar6@celke.com.br', '$2y$10$yT1xVyyt5yzymVF.z.3j/uMo7D356XTcjdbiUKJ.zPlCpwvKz1JwG', NULL, '$2y$10$Z0DhEKhYgpWeFyfm1VyWGuZipbMp9JOU6D8KiGpxHXlNTsKgmGjMu', 3, NULL, '2022-06-09 08:53:40', NULL),
(9, 'Cesar7', NULL, 'cesar7@celke.com.br', 'cesar7@celke.com.br', '$2y$10$jSYOJ8UYLOSQKWYtBYScOO5etGSSL670h38iQ7sHXx2uhxMOa.kQm', NULL, '$2y$10$.r6wdKObujx0OaS89VStfuuKXOvRH2bK6zmQ8NlNRd6tGAMa/Dvmi', 3, NULL, '2022-06-09 11:36:50', NULL),
(10, 'Marcio Vieira', NULL, 'marcio@email.com.br', 'marcio', '$2y$10$NEoEQkhZxeQqzyaLT40gzO9L3sqEAR8nlJY3lf2oxFOPN9PTlBj8e', NULL, '$2y$10$TntRyCbizUIk.pZRtJ0zHuvbIRMhR352zEiU7SRG1B5SQHlnsvXpu', 2, NULL, '2022-06-09 11:56:02', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `adms_colors`
--
ALTER TABLE `adms_colors`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `adms_confs_emails`
--
ALTER TABLE `adms_confs_emails`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `adms_sits_users`
--
ALTER TABLE `adms_sits_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `adms_users`
--
ALTER TABLE `adms_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conf_email` (`conf_email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adms_colors`
--
ALTER TABLE `adms_colors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `adms_confs_emails`
--
ALTER TABLE `adms_confs_emails`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `adms_sits_users`
--
ALTER TABLE `adms_sits_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `adms_users`
--
ALTER TABLE `adms_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
