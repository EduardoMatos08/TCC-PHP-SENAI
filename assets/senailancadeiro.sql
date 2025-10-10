-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 10-Out-2025 às 13:51
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `senailancadeiro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `nome_curso` varchar(100) NOT NULL,
  `sigla_curso` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_curso` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`nome_curso`, `sigla_curso`, `id_curso`) VALUES
('Teste', 'TST', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso_materias`
--

DROP TABLE IF EXISTS `curso_materias`;
CREATE TABLE IF NOT EXISTS `curso_materias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_curso` int NOT NULL,
  `id_materia` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_curso` (`id_curso`),
  KEY `id_materia` (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `materias`
--

DROP TABLE IF EXISTS `materias`;
CREATE TABLE IF NOT EXISTS `materias` (
  `nome_materia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sigla` varchar(100) NOT NULL,
  `carga_horaria` int NOT NULL,
  `id_materia` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `materias`
--

INSERT INTO `materias` (`nome_materia`, `sigla`, `carga_horaria`, `id_materia`) VALUES
('Análise de Eduardos em Banheiras', 'ANAL-EB', 1200, 8),
('Cobre', 'CU', 1, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `professores`
--

DROP TABLE IF EXISTS `professores`;
CREATE TABLE IF NOT EXISTS `professores` (
  `id_professor` int NOT NULL AUTO_INCREMENT,
  `nome_professor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `cpf` varchar(100) NOT NULL,
  `horarios` varchar(100) NOT NULL,
  `materias` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_professor`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `professores`
--

INSERT INTO `professores` (`id_professor`, `nome_professor`, `email`, `senha`, `admin`, `cpf`, `horarios`, `materias`) VALUES
(0, 'Administrador', 'admin@gmail.com', '$2y$10$9oDpF9dqdLI04iwAie/3A.aoD9Y/l2o8Nvx8UVaXPhMW4tdaa.5DC', 1, '000.000.000-00', '', ''),
(1, 'Eduardo Sexo', 'eduardo@gmail.com', '$2y$10$sE0eSahfkBF5tv43X9Dc/uhQy0n372zl.HXAr.7x07JFupQPm65IO', 0, '000.000.000-00', 'sabado-noite', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor_materia`
--

DROP TABLE IF EXISTS `professor_materia`;
CREATE TABLE IF NOT EXISTS `professor_materia` (
  `id_professor` int NOT NULL,
  `id_materia` int NOT NULL,
  PRIMARY KEY (`id_professor`,`id_materia`),
  KEY `fk_materia` (`id_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Adicionar tabela de notas após a tabela professor_materia
CREATE TABLE IF NOT EXISTS `professor_curso_materia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_professor` int NOT NULL,
  `id_curso` int NOT NULL,
  `id_materia` int NOT NULL,
  `tipo_nota` ENUM('n1', 'n2', 'n3') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prof_curso_mat_professor` (`id_professor`),
  KEY `fk_prof_curso_mat_curso` (`id_curso`),
  KEY `fk_prof_curso_mat_materia` (`id_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `professor_materia`
--
ALTER TABLE `professor_materia`
  ADD CONSTRAINT `fk_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_professor` FOREIGN KEY (`id_professor`) REFERENCES `professores` (`id_professor`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Adicionar constraints
ALTER TABLE `professor_curso_materia`
  ADD CONSTRAINT `fk_prof_curso_mat_professor` FOREIGN KEY (`id_professor`) REFERENCES `professores` (`id_professor`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_prof_curso_mat_curso` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_prof_curso_mat_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
