-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 08-Jun-2022 às 15:53
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
  `image` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `adms_users`
--

INSERT INTO `adms_users` (`id`, `name`, `nickname`, `email`, `username`, `password`, `recover_password`, `image`, `created`, `modified`) VALUES
(1, 'Cesar Szpak', NULL, 'cesar@celke.com.br', 'cesar@celke.com.br', '$2y$10$SEhSmEeV5aqnnJbbqWos8.k8AYOFwwrZhHpvphe0z.37aG4tQTFDa', NULL, NULL, '2022-06-08 15:42:54', NULL),
(2, 'Cesar 1', NULL, 'cesar1@celke.com.br', 'cesar1@celke.com.br', '$2y$10$ZgJWvB7k5EtYDSOS1SRgmOJishBsva3JTyKuff3pi3KPugVURN.zm', NULL, NULL, '2022-06-08 15:47:19', NULL),
(3, 'Cesar2', NULL, 'cesar2@celke.com.br', 'cesar2@celke.com.br', '$2y$10$XMEh02l23wsG6LjaNMdqg.98A9myvvUiodRbaBWMDqeT/oqCbZ4Ky', NULL, NULL, '2022-06-08 15:50:20', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `adms_confs_emails`
--
ALTER TABLE `adms_confs_emails`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `adms_users`
--
ALTER TABLE `adms_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adms_confs_emails`
--
ALTER TABLE `adms_confs_emails`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `adms_users`
--
ALTER TABLE `adms_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
