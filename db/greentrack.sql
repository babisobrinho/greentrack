-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2025 at 03:50 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greentrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `acoes_sustentaveis`
--

CREATE TABLE `acoes_sustentaveis` (
  `id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `impacto` decimal(10,2) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `utilizador_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `acoes_sustentaveis`
--

INSERT INTO `acoes_sustentaveis` (`id`, `nome`, `impacto`, `categoria`, `data_registro`, `utilizador_id`) VALUES
(1, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-01-01 08:15:00', 3),
(2, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-01-02 07:45:00', 4),
(3, 'Usou transporte público', '1.80', 'Mobilidade', '2025-01-03 09:00:00', 5),
(4, 'Carona com colegas', '1.50', 'Mobilidade', '2025-01-04 18:30:00', 3),
(5, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-01-05 10:00:00', 4),
(6, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-01-06 08:15:00', 5),
(7, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-01-07 07:30:00', 3),
(8, 'Usou transporte público', '1.80', 'Mobilidade', '2025-01-08 09:15:00', 4),
(9, 'Carona com colegas', '1.50', 'Mobilidade', '2025-01-09 18:45:00', 5),
(10, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-01-10 10:30:00', 3),
(11, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-01-11 08:20:00', 4),
(12, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-01-12 07:50:00', 5),
(13, 'Usou transporte público', '1.80', 'Mobilidade', '2025-01-13 09:05:00', 3),
(14, 'Carona com colegas', '1.50', 'Mobilidade', '2025-01-14 18:35:00', 4),
(15, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-01-15 10:05:00', 5),
(16, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-01-16 08:25:00', 3),
(17, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-01-17 07:40:00', 4),
(18, 'Usou transporte público', '1.80', 'Mobilidade', '2025-01-18 09:10:00', 5),
(19, 'Carona com colegas', '1.50', 'Mobilidade', '2025-01-19 18:40:00', 3),
(20, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-01-20 10:10:00', 4),
(21, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-01-21 08:30:00', 5),
(22, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-01-22 07:35:00', 3),
(23, 'Usou transporte público', '1.80', 'Mobilidade', '2025-01-23 09:20:00', 4),
(24, 'Carona com colegas', '1.50', 'Mobilidade', '2025-01-24 18:50:00', 5),
(25, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-01-25 10:15:00', 3),
(26, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-01-26 08:35:00', 4),
(27, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-01-27 07:55:00', 5),
(28, 'Usou transporte público', '1.80', 'Mobilidade', '2025-01-28 09:25:00', 3),
(29, 'Carona com colegas', '1.50', 'Mobilidade', '2025-01-29 18:55:00', 4),
(30, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-01-30 10:20:00', 5),
(31, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-01-31 08:40:00', 3),
(32, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-02-01 07:25:00', 4),
(33, 'Usou transporte público', '1.80', 'Mobilidade', '2025-02-02 09:30:00', 5),
(34, 'Carona com colegas', '1.50', 'Mobilidade', '2025-02-03 19:00:00', 3),
(35, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-02-04 10:25:00', 4),
(36, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-02-05 08:45:00', 5),
(37, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-02-06 07:20:00', 3),
(38, 'Usou transporte público', '1.80', 'Mobilidade', '2025-02-07 09:35:00', 4),
(39, 'Carona com colegas', '1.50', 'Mobilidade', '2025-02-08 19:05:00', 5),
(40, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-02-09 10:30:00', 3),
(41, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-02-10 08:50:00', 4),
(42, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-02-11 07:15:00', 5),
(43, 'Usou transporte público', '1.80', 'Mobilidade', '2025-02-12 09:40:00', 3),
(44, 'Carona com colegas', '1.50', 'Mobilidade', '2025-02-13 19:10:00', 4),
(45, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-02-14 10:35:00', 5),
(46, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-02-15 08:55:00', 3),
(47, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-02-16 07:10:00', 4),
(48, 'Usou transporte público', '1.80', 'Mobilidade', '2025-02-17 09:45:00', 5),
(49, 'Carona com colegas', '1.50', 'Mobilidade', '2025-02-18 19:15:00', 3),
(50, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-02-19 10:40:00', 4),
(51, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-02-20 09:00:00', 5),
(52, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-02-21 07:05:00', 3),
(53, 'Usou transporte público', '1.80', 'Mobilidade', '2025-02-22 09:50:00', 4),
(54, 'Carona com colegas', '1.50', 'Mobilidade', '2025-02-23 19:20:00', 5),
(55, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-02-24 10:45:00', 3),
(56, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-02-25 09:05:00', 4),
(57, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-02-26 07:00:00', 5),
(58, 'Usou transporte público', '1.80', 'Mobilidade', '2025-02-27 09:55:00', 3),
(59, 'Carona com colegas', '1.50', 'Mobilidade', '2025-02-28 19:25:00', 4),
(60, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-03-01 10:50:00', 5),
(61, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-03-02 09:10:00', 3),
(62, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-03-03 06:55:00', 4),
(63, 'Usou transporte público', '1.80', 'Mobilidade', '2025-03-04 10:00:00', 5),
(64, 'Carona com colegas', '1.50', 'Mobilidade', '2025-03-05 19:30:00', 3),
(65, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-03-06 11:00:00', 4),
(66, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-03-07 09:15:00', 5),
(67, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-03-08 06:50:00', 3),
(68, 'Usou transporte público', '1.80', 'Mobilidade', '2025-03-09 10:05:00', 4),
(69, 'Carona com colegas', '1.50', 'Mobilidade', '2025-03-10 19:35:00', 5),
(70, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-03-11 11:05:00', 3),
(71, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-03-12 09:20:00', 4),
(72, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-03-13 06:45:00', 5),
(73, 'Usou transporte público', '1.80', 'Mobilidade', '2025-03-14 10:10:00', 3),
(74, 'Carona com colegas', '1.50', 'Mobilidade', '2025-03-15 19:40:00', 4),
(75, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-03-16 11:10:00', 5),
(76, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-03-17 09:25:00', 3),
(77, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-03-18 06:40:00', 4),
(78, 'Usou transporte público', '1.80', 'Mobilidade', '2025-03-19 10:15:00', 5),
(79, 'Carona com colegas', '1.50', 'Mobilidade', '2025-03-20 19:45:00', 3),
(80, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-03-21 11:15:00', 4),
(81, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-03-22 09:30:00', 5),
(82, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-03-23 06:35:00', 3),
(83, 'Usou transporte público', '1.80', 'Mobilidade', '2025-03-24 10:20:00', 4),
(84, 'Carona com colegas', '1.50', 'Mobilidade', '2025-03-25 19:50:00', 5),
(85, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-03-26 11:20:00', 3),
(86, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-03-27 09:35:00', 4),
(87, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-03-28 06:30:00', 5),
(88, 'Usou transporte público', '1.80', 'Mobilidade', '2025-03-29 10:25:00', 3),
(89, 'Carona com colegas', '1.50', 'Mobilidade', '2025-03-30 19:55:00', 4),
(90, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-03-31 11:25:00', 5),
(91, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-04-01 09:40:00', 3),
(92, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-04-02 06:25:00', 4),
(93, 'Usou transporte público', '1.80', 'Mobilidade', '2025-04-03 10:30:00', 5),
(94, 'Carona com colegas', '1.50', 'Mobilidade', '2025-04-04 20:00:00', 3),
(95, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-04-05 11:30:00', 4),
(96, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-04-06 09:45:00', 5),
(97, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-04-07 06:20:00', 3),
(98, 'Usou transporte público', '1.80', 'Mobilidade', '2025-04-08 10:35:00', 4),
(99, 'Carona com colegas', '1.50', 'Mobilidade', '2025-04-09 20:05:00', 5),
(100, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-04-10 11:35:00', 3),
(101, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-04-11 09:50:00', 4),
(102, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-04-12 06:15:00', 5),
(103, 'Usou transporte público', '1.80', 'Mobilidade', '2025-04-13 10:40:00', 3),
(104, 'Carona com colegas', '1.50', 'Mobilidade', '2025-04-14 20:10:00', 4),
(105, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-04-15 11:40:00', 5),
(106, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-04-16 09:55:00', 3),
(107, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-04-17 06:10:00', 4),
(108, 'Usou transporte público', '1.80', 'Mobilidade', '2025-04-18 10:45:00', 5),
(109, 'Carona com colegas', '1.50', 'Mobilidade', '2025-04-19 20:15:00', 3),
(110, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-04-20 11:45:00', 4),
(111, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-04-21 10:00:00', 5),
(112, 'Caminhou para o trabalho', '2.00', 'Mobilidade', '2025-04-22 06:05:00', 3),
(113, 'Usou transporte público', '1.80', 'Mobilidade', '2025-04-23 10:50:00', 4),
(114, 'Carona com colegas', '1.50', 'Mobilidade', '2025-04-24 20:20:00', 5),
(115, 'Trabalhou remotamente (evitou deslocamento)', '3.00', 'Mobilidade', '2025-04-25 11:50:00', 3),
(116, 'Usou bicicleta para ir trabalhar', '2.50', 'Mobilidade', '2025-04-26 10:05:00', 4),
(117, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-01-01 08:00:00', 3),
(118, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-01-02 09:15:00', 4),
(119, 'Usou energia solar em casa', '4.50', 'Energia', '2025-01-03 10:30:00', 5),
(120, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-01-04 14:45:00', 3),
(121, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-01-05 18:00:00', 4),
(122, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-01-06 07:20:00', 5),
(123, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-01-07 08:35:00', 3),
(124, 'Usou energia solar em casa', '4.50', 'Energia', '2025-01-08 09:50:00', 4),
(125, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-01-09 13:05:00', 5),
(126, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-01-10 17:20:00', 3),
(127, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-01-11 07:40:00', 4),
(128, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-01-12 08:55:00', 5),
(129, 'Usou energia solar em casa', '4.50', 'Energia', '2025-01-13 10:10:00', 3),
(130, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-01-14 14:25:00', 4),
(131, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-01-15 17:40:00', 5),
(132, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-01-16 07:00:00', 3),
(133, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-01-17 08:15:00', 4),
(134, 'Usou energia solar em casa', '4.50', 'Energia', '2025-01-18 09:30:00', 5),
(135, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-01-19 13:45:00', 3),
(136, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-01-20 18:00:00', 4),
(137, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-01-21 07:10:00', 5),
(138, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-01-22 08:25:00', 3),
(139, 'Usou energia solar em casa', '4.50', 'Energia', '2025-01-23 09:40:00', 4),
(140, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-01-24 14:55:00', 5),
(141, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-01-25 18:10:00', 3),
(142, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-01-26 07:30:00', 4),
(143, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-01-27 08:45:00', 5),
(144, 'Usou energia solar em casa', '4.50', 'Energia', '2025-01-28 10:00:00', 3),
(145, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-01-29 14:15:00', 4),
(146, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-01-30 17:30:00', 5),
(147, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-01-31 07:50:00', 3),
(148, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-02-01 09:05:00', 4),
(149, 'Usou energia solar em casa', '4.50', 'Energia', '2025-02-02 10:20:00', 5),
(150, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-02-03 14:35:00', 3),
(151, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-02-04 17:50:00', 4),
(152, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-02-05 07:10:00', 5),
(153, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-02-06 08:25:00', 3),
(154, 'Usou energia solar em casa', '4.50', 'Energia', '2025-02-07 09:40:00', 4),
(155, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-02-08 14:55:00', 5),
(156, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-02-09 18:10:00', 3),
(157, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-02-10 07:30:00', 4),
(158, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-02-11 08:45:00', 5),
(159, 'Usou energia solar em casa', '4.50', 'Energia', '2025-02-12 10:00:00', 3),
(160, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-02-13 14:15:00', 4),
(161, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-02-14 17:30:00', 5),
(162, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-02-15 07:50:00', 3),
(163, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-02-16 09:05:00', 4),
(164, 'Usou energia solar em casa', '4.50', 'Energia', '2025-02-17 10:20:00', 5),
(165, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-02-18 14:35:00', 3),
(166, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-02-19 17:50:00', 4),
(167, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-02-20 07:10:00', 5),
(168, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-02-21 08:25:00', 3),
(169, 'Usou energia solar em casa', '4.50', 'Energia', '2025-02-22 09:40:00', 4),
(170, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-02-23 14:55:00', 5),
(171, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-02-24 18:10:00', 3),
(172, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-02-25 07:30:00', 4),
(173, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-02-26 08:45:00', 5),
(174, 'Usou energia solar em casa', '4.50', 'Energia', '2025-02-27 10:00:00', 3),
(175, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-02-28 14:15:00', 4),
(176, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-03-01 17:30:00', 5),
(177, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-03-02 07:50:00', 3),
(178, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-03-03 09:05:00', 4),
(179, 'Usou energia solar em casa', '4.50', 'Energia', '2025-03-04 10:20:00', 5),
(180, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-03-05 14:35:00', 3),
(181, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-03-06 17:50:00', 4),
(182, 'Instalou lâmpadas LED', '3.00', 'Energia', '2025-03-07 07:10:00', 5),
(183, 'Desligou aparelhos eletrônicos em standby', '2.20', 'Energia', '2025-03-08 08:25:00', 3),
(184, 'Usou energia solar em casa', '4.50', 'Energia', '2025-03-09 09:40:00', 4),
(185, 'Reduziu o uso do ar condicionado', '1.80', 'Energia', '2025-03-10 14:55:00', 5),
(186, 'Optou por eletrodomésticos eficientes', '3.50', 'Energia', '2025-03-11 18:10:00', 3),
(187, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-01-01 08:00:00', 11),
(188, 'Consertou vazamento em casa', '3.50', 'Água', '2025-01-02 09:15:00', 23),
(189, 'Reutilizou água da chuva', '4.20', 'Água', '2025-01-03 10:30:00', 37),
(190, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-01-04 14:45:00', 48),
(191, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-01-05 18:00:00', 52),
(192, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-01-06 07:20:00', 11),
(193, 'Consertou vazamento em casa', '3.50', 'Água', '2025-01-07 08:35:00', 23),
(194, 'Reutilizou água da chuva', '4.20', 'Água', '2025-01-08 09:50:00', 37),
(195, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-01-09 13:05:00', 48),
(196, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-01-10 17:20:00', 52),
(197, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-01-11 07:40:00', 23),
(198, 'Consertou vazamento em casa', '3.50', 'Água', '2025-01-12 08:55:00', 37),
(199, 'Reutilizou água da chuva', '4.20', 'Água', '2025-01-13 10:10:00', 48),
(200, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-01-14 14:25:00', 52),
(201, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-01-15 17:40:00', 11),
(202, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-01-16 07:00:00', 23),
(203, 'Consertou vazamento em casa', '3.50', 'Água', '2025-01-17 08:15:00', 37),
(204, 'Reutilizou água da chuva', '4.20', 'Água', '2025-01-18 09:30:00', 48),
(205, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-01-19 13:45:00', 52),
(206, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-01-20 18:00:00', 11),
(207, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-01-21 07:10:00', 37),
(208, 'Consertou vazamento em casa', '3.50', 'Água', '2025-01-22 08:25:00', 48),
(209, 'Reutilizou água da chuva', '4.20', 'Água', '2025-01-23 09:40:00', 52),
(210, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-01-24 14:55:00', 11),
(211, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-01-25 18:10:00', 23),
(212, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-01-26 07:30:00', 37),
(213, 'Consertou vazamento em casa', '3.50', 'Água', '2025-01-27 08:45:00', 48),
(214, 'Reutilizou água da chuva', '4.20', 'Água', '2025-01-28 10:00:00', 52),
(215, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-01-29 14:15:00', 11),
(216, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-01-30 17:30:00', 23),
(217, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-01-31 07:50:00', 48),
(218, 'Consertou vazamento em casa', '3.50', 'Água', '2025-02-01 09:05:00', 52),
(219, 'Reutilizou água da chuva', '4.20', 'Água', '2025-02-02 10:20:00', 11),
(220, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-02-03 14:35:00', 23),
(221, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-02-04 17:50:00', 37),
(222, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-02-05 07:10:00', 48),
(223, 'Consertou vazamento em casa', '3.50', 'Água', '2025-02-06 08:25:00', 52),
(224, 'Reutilizou água da chuva', '4.20', 'Água', '2025-02-07 09:40:00', 11),
(225, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-02-08 14:55:00', 23),
(226, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-02-09 18:10:00', 37),
(227, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-02-10 07:30:00', 52),
(228, 'Consertou vazamento em casa', '3.50', 'Água', '2025-02-11 08:45:00', 11),
(229, 'Reutilizou água da chuva', '4.20', 'Água', '2025-02-12 10:00:00', 23),
(230, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-02-13 14:15:00', 37),
(231, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-02-14 17:30:00', 48),
(232, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-02-15 07:50:00', 52),
(233, 'Consertou vazamento em casa', '3.50', 'Água', '2025-02-16 09:05:00', 11),
(234, 'Reutilizou água da chuva', '4.20', 'Água', '2025-02-17 10:20:00', 23),
(235, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-02-18 14:35:00', 37),
(236, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-02-19 17:50:00', 48),
(237, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-02-20 07:10:00', 11),
(238, 'Consertou vazamento em casa', '3.50', 'Água', '2025-02-21 08:25:00', 23),
(239, 'Reutilizou água da chuva', '4.20', 'Água', '2025-02-22 09:40:00', 37),
(240, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-02-23 14:55:00', 48),
(241, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-02-24 18:10:00', 52),
(242, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-02-25 07:30:00', 11),
(243, 'Consertou vazamento em casa', '3.50', 'Água', '2025-02-26 08:45:00', 23),
(244, 'Reutilizou água da chuva', '4.20', 'Água', '2025-02-27 10:00:00', 37),
(245, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-02-28 14:15:00', 48),
(246, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-03-01 17:30:00', 52),
(247, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-03-02 07:50:00', 23),
(248, 'Consertou vazamento em casa', '3.50', 'Água', '2025-03-03 09:05:00', 37),
(249, 'Reutilizou água da chuva', '4.20', 'Água', '2025-03-04 10:20:00', 48),
(250, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-03-05 14:35:00', 52),
(251, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-03-06 17:50:00', 11),
(252, 'Reduziu o tempo do banho', '2.80', 'Água', '2025-03-07 07:10:00', 23),
(253, 'Consertou vazamento em casa', '3.50', 'Água', '2025-03-08 08:25:00', 37),
(254, 'Reutilizou água da chuva', '4.20', 'Água', '2025-03-09 09:40:00', 48),
(255, 'Fechou torneira ao escovar os dentes', '1.90', 'Água', '2025-03-10 14:55:00', 52),
(256, 'Usou vaso sanitário com descarga dupla', '3.00', 'Água', '2025-03-11 18:10:00', 11),
(257, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-01-01 08:00:00', 29),
(258, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-01-02 09:15:00', 70),
(259, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-01-03 10:30:00', 63),
(260, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-01-04 14:45:00', 42),
(261, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-01-05 18:00:00', 12),
(262, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-01-06 07:20:00', 29),
(263, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-01-07 08:35:00', 70),
(264, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-01-08 09:50:00', 63),
(265, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-01-09 13:05:00', 42),
(266, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-01-10 17:20:00', 12),
(267, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-01-11 07:40:00', 70),
(268, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-01-12 08:55:00', 63),
(269, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-01-13 10:10:00', 42),
(270, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-01-14 14:25:00', 12),
(271, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-01-15 17:40:00', 29),
(272, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-01-16 07:00:00', 70),
(273, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-01-17 08:15:00', 63),
(274, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-01-18 09:30:00', 42),
(275, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-01-19 13:45:00', 12),
(276, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-01-20 18:00:00', 29),
(277, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-01-21 07:10:00', 63),
(278, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-01-22 08:25:00', 42),
(279, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-01-23 09:40:00', 12),
(280, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-01-24 14:55:00', 29),
(281, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-01-25 18:10:00', 70),
(282, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-01-26 07:30:00', 63),
(283, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-01-27 08:45:00', 42),
(284, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-01-28 10:00:00', 12),
(285, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-01-29 14:15:00', 29),
(286, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-01-30 17:30:00', 70),
(287, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-01-31 07:50:00', 42),
(288, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-02-01 09:05:00', 12),
(289, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-02-02 10:20:00', 29),
(290, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-02-03 14:35:00', 70),
(291, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-02-04 17:50:00', 63),
(292, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-02-05 07:10:00', 42),
(293, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-02-06 08:25:00', 12),
(294, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-02-07 09:40:00', 29),
(295, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-02-08 14:55:00', 70),
(296, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-02-09 18:10:00', 63),
(297, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-02-10 07:30:00', 12),
(298, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-02-11 08:45:00', 29),
(299, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-02-12 10:00:00', 70),
(300, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-02-13 14:15:00', 63),
(301, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-02-14 17:30:00', 42),
(302, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-02-15 07:50:00', 12),
(303, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-02-16 09:05:00', 29),
(304, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-02-17 10:20:00', 70),
(305, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-02-18 14:35:00', 63),
(306, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-02-19 17:50:00', 42),
(307, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-02-20 07:10:00', 29),
(308, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-02-21 08:25:00', 70),
(309, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-02-22 09:40:00', 63),
(310, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-02-23 14:55:00', 42),
(311, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-02-24 18:10:00', 12),
(312, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-02-25 07:30:00', 29),
(313, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-02-26 08:45:00', 70),
(314, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-02-27 10:00:00', 63),
(315, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-02-28 14:15:00', 42),
(316, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-03-01 17:30:00', 12),
(317, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-03-02 07:50:00', 70),
(318, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-03-03 09:05:00', 63),
(319, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-03-04 10:20:00', 42),
(320, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-03-05 14:35:00', 12),
(321, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-03-06 17:50:00', 29),
(322, 'Reciclagem de plástico', '3.10', 'Resíduos', '2025-03-07 07:10:00', 70),
(323, 'Compostagem de restos orgânicos', '4.00', 'Resíduos', '2025-03-08 08:25:00', 63),
(324, 'Reduziu uso de sacos plásticos', '2.50', 'Resíduos', '2025-03-09 09:40:00', 42),
(325, 'Reutilizou embalagens', '3.20', 'Resíduos', '2025-03-10 14:55:00', 12),
(326, 'Separou lixo eletrônico', '4.50', 'Resíduos', '2025-03-11 18:10:00', 29),
(327, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-01-01 08:00:00', 29),
(328, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-01-02 09:15:00', 70),
(329, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-01-03 10:30:00', 63),
(330, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-01-04 14:45:00', 42),
(331, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-01-05 18:00:00', 12),
(332, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-01-06 07:20:00', 29),
(333, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-01-07 08:35:00', 70),
(334, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-01-08 09:50:00', 63),
(335, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-01-09 13:05:00', 42),
(336, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-01-10 17:20:00', 12),
(337, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-01-11 07:40:00', 70),
(338, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-01-12 08:55:00', 63),
(339, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-01-13 10:10:00', 42),
(340, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-01-14 14:25:00', 12),
(341, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-01-15 17:40:00', 29),
(342, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-01-16 07:00:00', 70),
(343, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-01-17 08:15:00', 63),
(344, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-01-18 09:30:00', 42),
(345, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-01-19 13:45:00', 12),
(346, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-01-20 18:00:00', 29),
(347, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-01-21 07:10:00', 63),
(348, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-01-22 08:25:00', 42),
(349, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-01-23 09:40:00', 12),
(350, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-01-24 14:55:00', 29),
(351, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-01-25 18:10:00', 70),
(352, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-01-26 07:30:00', 63),
(353, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-01-27 08:45:00', 42),
(354, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-01-28 10:00:00', 12),
(355, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-01-29 14:15:00', 29),
(356, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-01-30 17:30:00', 70),
(357, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-01-31 07:50:00', 42),
(358, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-02-01 09:05:00', 12),
(359, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-02-02 10:20:00', 29),
(360, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-02-03 14:35:00', 70),
(361, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-02-04 17:50:00', 63),
(362, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-02-05 07:10:00', 42),
(363, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-02-06 08:25:00', 12),
(364, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-02-07 09:40:00', 29),
(365, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-02-08 14:55:00', 70),
(366, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-02-09 18:10:00', 63),
(367, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-02-10 07:30:00', 12),
(368, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-02-11 08:45:00', 29),
(369, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-02-12 10:00:00', 70),
(370, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-02-13 14:15:00', 63),
(371, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-02-14 17:30:00', 42),
(372, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-02-15 07:50:00', 12),
(373, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-02-16 09:05:00', 29),
(374, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-02-17 10:20:00', 70),
(375, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-02-18 14:35:00', 63),
(376, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-02-19 17:50:00', 42),
(377, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-02-20 07:10:00', 29),
(378, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-02-21 08:25:00', 70),
(379, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-02-22 09:40:00', 63),
(380, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-02-23 14:55:00', 42),
(381, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-02-24 18:10:00', 12),
(382, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-02-25 07:30:00', 29),
(383, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-02-26 08:45:00', 70),
(384, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-02-27 10:00:00', 63),
(385, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-02-28 14:15:00', 42),
(386, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-03-01 17:30:00', 12),
(387, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-03-02 07:50:00', 70),
(388, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-03-03 09:05:00', 63),
(389, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-03-04 10:20:00', 42),
(390, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-03-05 14:35:00', 12),
(391, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-03-06 17:50:00', 29),
(392, 'Comprou produtos locais', '3.50', 'Consumo Sustentável', '2025-03-07 07:10:00', 70),
(393, 'Evitar embalagens descartáveis', '4.20', 'Consumo Sustentável', '2025-03-08 08:25:00', 63),
(394, 'Optou por produtos reciclados', '3.00', 'Consumo Sustentável', '2025-03-09 09:40:00', 42),
(395, 'Comprou em lojas sustentáveis', '2.80', 'Consumo Sustentável', '2025-03-10 14:55:00', 12),
(396, 'Reduziu o consumo de plástico', '3.70', 'Consumo Sustentável', '2025-03-11 18:10:00', 29),
(397, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-01-01 08:00:00', 17),
(398, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-01-02 09:15:00', 25),
(399, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-01-03 10:30:00', 31),
(400, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-01-04 14:45:00', 40),
(401, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-01-05 18:00:00', 75),
(402, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-01-06 07:20:00', 17),
(403, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-01-07 08:35:00', 25),
(404, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-01-08 09:50:00', 31),
(405, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-01-09 13:05:00', 40),
(406, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-01-10 17:20:00', 75),
(407, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-01-11 07:40:00', 25),
(408, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-01-12 08:55:00', 31),
(409, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-01-13 10:10:00', 40),
(410, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-01-14 14:25:00', 75),
(411, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-01-15 17:40:00', 17),
(412, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-01-16 07:00:00', 25),
(413, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-01-17 08:15:00', 31),
(414, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-01-18 09:30:00', 40),
(415, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-01-19 13:45:00', 75),
(416, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-01-20 18:00:00', 17),
(417, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-01-21 07:10:00', 31),
(418, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-01-22 08:25:00', 40),
(419, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-01-23 09:40:00', 75),
(420, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-01-24 14:55:00', 17),
(421, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-01-25 18:10:00', 25),
(422, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-01-26 07:30:00', 31),
(423, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-01-27 08:45:00', 40),
(424, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-01-28 10:00:00', 75),
(425, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-01-29 14:15:00', 17),
(426, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-01-30 17:30:00', 25),
(427, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-01-31 07:50:00', 40),
(428, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-02-01 09:05:00', 75),
(429, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-02-02 10:20:00', 17),
(430, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-02-03 14:35:00', 25),
(431, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-02-04 17:50:00', 31),
(432, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-02-05 07:10:00', 40),
(433, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-02-06 08:25:00', 75),
(434, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-02-07 09:40:00', 17),
(435, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-02-08 14:55:00', 25),
(436, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-02-09 18:10:00', 31),
(437, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-02-10 07:30:00', 75),
(438, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-02-11 08:45:00', 17),
(439, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-02-12 10:00:00', 25),
(440, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-02-13 14:15:00', 31),
(441, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-02-14 17:30:00', 40),
(442, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-02-15 07:50:00', 75),
(443, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-02-16 09:05:00', 17),
(444, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-02-17 10:20:00', 25),
(445, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-02-18 14:35:00', 31),
(446, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-02-19 17:50:00', 40),
(447, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-02-20 07:10:00', 17),
(448, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-02-21 08:25:00', 25),
(449, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-02-22 09:40:00', 31),
(450, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-02-23 14:55:00', 40),
(451, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-02-24 18:10:00', 75),
(452, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-02-25 07:30:00', 17),
(453, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-02-26 08:45:00', 25),
(454, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-02-27 10:00:00', 31),
(455, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-02-28 14:15:00', 40),
(456, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-03-01 17:30:00', 75),
(457, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-03-02 07:50:00', 25),
(458, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-03-03 09:05:00', 31),
(459, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-03-04 10:20:00', 40),
(460, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-03-05 14:35:00', 75),
(461, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-03-06 17:50:00', 17),
(462, 'Plantou árvore nativa', '5.00', 'Florestas e Natureza', '2025-03-07 07:10:00', 25),
(463, 'Participou em limpeza de parque', '4.50', 'Florestas e Natureza', '2025-03-08 08:25:00', 31),
(464, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-03-09 09:40:00', 40),
(465, 'Promoveu área verde na comunidade', '4.20', 'Florestas e Natureza', '2025-03-10 14:55:00', 75),
(466, 'Adotou espaço natural para preservação', '4.00', 'Florestas e Natureza', '2025-03-11 18:10:00', 17),
(467, 'Evitar uso de pesticidas', '3.80', 'Florestas e Natureza', '2025-06-09 16:46:52', 3);

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `icone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `descricao`, `icone`) VALUES
(1, 'Mobilidade', 'Ações relacionadas a transporte e locomoção', 'fa-car'),
(2, 'Energia', 'Ações relacionadas ao consumo de energia', 'fa-bolt'),
(3, 'Água', 'Ações relacionadas ao consumo de água', 'fa-tint'),
(4, 'Resíduos', 'Ações relacionadas a gestão de resíduos', 'fa-trash'),
(5, 'Consumo Sustentável', 'Ações relacionadas a hábitos de consumo', 'fa-shopping-bag'),
(6, 'Alimentação', 'Ações relacionadas a hábitos alimentares', 'fa-utensils'),
(7, 'Florestas e Natureza', 'Ações relacionadas a preservação ambiental', 'fa-tree');

-- --------------------------------------------------------

--
-- Table structure for table `conteudos`
--

CREATE TABLE `conteudos` (
  `id` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `data_publicacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `utilizador_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `conteudos`
--

INSERT INTO `conteudos` (`id`, `titulo`, `conteudo`, `data_publicacao`, `utilizador_id`) VALUES
(1, 'Tecnologias Verdes para o Futuro', 'As inovações tecnológicas que estão ajudando a preservar o planeta...', '2025-01-01 14:00:00', 1),
(2, 'Guia Completo de Compostagem Doméstica', 'Aprenda como transformar seus resíduos orgânicos em adubo de qualidade com este guia passo-a-passo...', '2025-01-15 14:30:00', 7),
(3, 'Transporte Sustentável nas Cidades', 'Descubra alternativas ecológicas para se locomover na cidade...', '2025-01-01 16:20:00', 1),
(4, 'Microplásticos: O Inimigo Invisível e Como Evitá-lo', 'Descubra onde os microplásticos estão escondidos no seu dia a dia e estratégias para reduzir sua exposição...', '2025-01-18 11:25:00', 19),
(5, 'Agricultura Sintrópica: Cultivando como a Floresta', 'Técnica inovadora que imita os processos naturais para criar sistemas agrícolas regenerativos...', '2025-01-28 16:50:00', 43),
(6, 'Alimentação Sustentável: Por Onde Começar', 'Como fazer escolhas alimentares que beneficiam sua saúde e o planeta...', '2025-02-05 10:10:00', 1),
(7, 'Energias Renováveis: O Futuro Sustentável', 'Descubra as últimas inovações em energias renováveis e como elas estão moldando um futuro mais verde...', '2025-02-05 11:20:00', 19),
(8, 'Permacultura: Princípios para um Estilo de Vida Sustentável', 'Conheça os fundamentos da permacultura e como aplicá-los em sua casa e comunidade...', '2025-02-08 14:15:00', 7),
(9, 'Descarbonização: O Que Sua Empresa Pode Fazer', 'Passos concretos para reduzir a pegada de carbono em negócios de todos os portes...', '2025-02-14 09:30:00', 31),
(10, 'Produtos de Limpeza Ecológicos', 'Receitas caseiras para produtos de limpeza que não agridem o meio ambiente...', '2025-02-14 15:30:00', 1),
(11, 'Mobilidade Elétrica: Vantagens e Desafios', 'O futuro dos transportes movidos a energia limpa...', '2025-02-15 14:15:00', 1),
(12, 'Empresas com Práticas Sustentáveis', 'Conheça empresas que estão fazendo a diferença com suas políticas ambientais...', '2025-02-16 11:40:00', 1),
(13, 'A Revolução dos Painéis Solares Acessíveis', 'Como os avanços tecnológicos estão tornando a energia solar uma opção viável para mais pessoas...', '2025-02-22 10:40:00', 43),
(14, 'Como Criar uma Horta Urbana em Pequenos Espaços', 'Mesmo em apartamentos é possível cultivar alimentos frescos. Confira nossas dicas para começar...', '2025-02-28 16:45:00', 31),
(15, 'Banheiro Sustentável: Reduzindo o Impacto no Dia a Dia', 'Alternativas ecológicas para produtos de higiene pessoal e redução do consumo de água...', '2025-03-08 14:40:00', 7),
(16, 'Plástico: Como Reduzir o Consumo', 'Alternativas ao plástico descartável para o dia a dia...', '2025-03-08 16:30:00', 1),
(17, 'Conservação dos Oceanos', 'Como nossas ações diárias impactam os mares e o que podemos fazer...', '2025-03-08 16:00:00', 1),
(18, 'Agricultura Orgânica vs Convencional', 'Comparativo entre os dois métodos e seus impactos ambientais...', '2025-03-09 10:25:00', 1),
(19, 'Desafio Zero Waste: 30 Dias Sem Produzir Lixo', 'Relato de quem aceitou o desafio de viver sem produzir resíduos...', '2025-03-09 13:50:00', 1),
(20, 'O Impacto dos Plásticos nos Oceanos e Como Ajudar', 'Entenda a gravidade da poluição por plásticos e descubra ações práticas para reduzir seu impacto...', '2025-03-10 10:15:00', 7),
(21, 'Reduzir, Reutilizar, Reciclar: Guia Completo', 'Os 3 Rs da sustentabilidade explicados de forma prática...', '2025-03-10 13:25:00', 1),
(22, 'Cidades Verdes: O Poder das Áreas Arborizadas', 'Estudo mostra como os espaços verdes urbanos melhoram a qualidade de vida e reduzem ilhas de calor...', '2025-03-12 16:30:00', 31),
(23, 'Energia Eólica Doméstica: Vale a Pena?', 'Análise dos prós e contras de pequenos aerogeradores para residências...', '2025-03-20 11:55:00', 19),
(24, 'Sustentabilidade na Moda: Roupas com Menor Impacto Ambiental', 'Conheça marcas e práticas que estão revolucionando a indústria da moda com foco ecológico...', '2025-03-25 15:30:00', 19),
(25, 'Slow Fashion: Menos Consumo, Mais Consciência', 'O movimento que desafia a moda rápida e propõe uma relação mais saudável com nossas roupas...', '2025-03-28 09:50:00', 7),
(26, 'Educação Ambiental para Crianças', 'Atividades para ensinar os pequenos a cuidar do planeta...', '2025-03-30 09:30:00', 1),
(27, 'Hidroponia Caseira: Cultivo sem Solo para Iniciantes', 'Guia prático para montar seu primeiro sistema hidropônico em pequenos espaços...', '2025-04-05 13:20:00', 19),
(28, 'Moda Sustentável: O Que É e Como Adotar', 'Entenda o impacto da indústria da moda e como consumir de forma consciente...', '2025-04-10 09:45:00', 1),
(29, 'Comunidades Sustentáveis: Vivendo em Ecovilas', 'O dia a dia de quem escolheu morar em comunidades com baixo impacto ambiental...', '2025-04-10 15:20:00', 43),
(30, 'Turismo Sustentável: Viajar com Consciência', 'Como ser um viajante mais responsável e ecológico...', '2025-04-11 15:10:00', 1),
(31, 'Alimentação Sustentável: Da Produção ao Consumo', 'Como nossas escolhas alimentares impactam o planeta e o que podemos fazer para comer de forma mais consciente...', '2025-04-12 09:50:00', 43),
(32, 'O Dilema das Embalagens: Soluções Inovadoras', 'Novos materiais e sistemas que podem revolucionar a forma como embalamos produtos...', '2025-04-18 15:45:00', 43),
(33, 'Tecnologias Verdes para Casas Inteligentes', 'Explore dispositivos e sistemas que tornam sua casa mais eficiente energeticamente e sustentável...', '2025-04-20 13:25:00', 31),
(34, 'Upcycling: Transformando Lixo em Design', 'Ideias criativas para dar nova vida a objetos que seriam descartados...', '2025-04-25 10:05:00', 31),
(35, '10 Dicas para Reduzir o Consumo de Água', 'Neste artigo exploramos 10 formas simples de reduzir o consumo de água no dia a dia...', '2025-05-01 09:15:00', 1),
(36, 'Energia Solar: Benefícios para o Planeta', 'A energia solar é uma das formas mais limpas de produzir eletricidade...', '2025-05-02 11:30:00', 1),
(37, 'Restauração de Ecossistemas: Projetos que Inspiram', 'Casos reais de recuperação de áreas degradadas ao redor do mundo e como replicar esses esforços...', '2025-05-03 11:10:00', 31),
(38, 'Como Fazer Compostagem em Casa', 'Aprenda a transformar seus resíduos orgânicos em adubo de qualidade...', '2025-05-03 14:45:00', 1),
(39, 'Desafio Zero Waste: Reduzindo seu Lixo em 30 Dias', 'Aceite este desafio e aprenda a reduzir drasticamente a quantidade de lixo que produz...', '2025-05-05 17:10:00', 7),
(40, 'Paisagismo Comestível: Beleza que Alimenta', 'Como integrar plantas alimentícias em jardins ornamentais urbanos...', '2025-05-08 13:35:00', 7),
(41, 'Guia do Consumidor Consciente: Rótulos que Enganam', 'Aprenda a decifrar as embalagens e identificar greenwashing nas prateleiras...', '2025-05-14 14:25:00', 7),
(42, 'Biodiversidade: Por Que Precisamos Protegê-la?', 'Entenda a importância da diversidade biológica e o que está em jogo com as mudanças climáticas...', '2025-05-18 08:45:00', 43),
(43, 'Logística Reversa: O Caminho de Volta das Embalagens', 'Como funciona e quais os benefícios dos sistemas de retorno de materiais pós-consumo...', '2025-05-20 16:15:00', 19),
(44, 'Bicicletas Elétricas: Mobilidade Sustentável nas Cidades', 'Como as e-bikes estão transformando o transporte urbano e reduzindo emissões...', '2025-05-25 10:15:00', 19),
(45, 'Transporte Sustentável: Alternativas aos Carros Convencionais', 'Conheça opções de mobilidade urbana que reduzem emissões e melhoram a qualidade do ar...', '2025-05-30 14:00:00', 19),
(46, 'Agricultura Regenerativa: Curando o Solo', 'A agricultura regenerativa surge como um modelo revolucionário que vai além da sustentabilidade, buscando ativamente reparar ecossistemas degradados. Seus pilares incluem o plantio direto (que evita a aração do solo), a rotação de culturas e a integração entre agricultura e pecuária. Essas práticas não só recuperam a saúde do solo, aumentando sua matéria orgânica, mas também sequestram carbono da atmosfera - estudos indicam que solos regenerativos podem armazenar até 10 vezes mais carbono que métodos convencionais. Fazendas como a da família Brown no Dakota do Norte, EUA, comprovam que é possível triplicar a produtividade enquanto regenera a terra.\r\n\r\nA biodiversidade é peça-chave nesse processo. Técnicas como agroflorestas, que combinam árvores, cultivos e às vezes animais, criam sistemas resilientes que imitam a natureza. O uso de adubos verdes (como leguminosas que fixam nitrogênio) e compostagem enriquece o solo sem químicos sintéticos. No Brasil, iniciativas como o projeto Reflorestar-MG mostram que áreas antes improdutivas podem voltar a ser férteis em poucos anos, com aumento de 30% na retenção de água e surgimento espontâneo de espécies nativas.\r\n\r\nO impacto potencial é enorme: se aplicada em 20% das terras agrícolas globais, a agricultura regenerativa poderia sequestrar até 20% das emissões anuais de CO₂. Além dos benefícios ambientais, os alimentos produzidos são mais nutritivos - estudos mostram níveis até 30% mais altos de vitaminas e antioxidantes. À medida que consumidores valorizam produtos regenerativos e políticas públicas começam a incentivar essas práticas (como o Plano ABC+ no Brasil), cresce a esperança de transformar a agricultura de vilã climática em protagonista da solução.', '2025-06-05 11:30:00', 7),
(47, 'Economia de Energia em Casa', 'Reduzir o consumo de energia elétrica não só alivia o bolso no final do mês, mas também contribui para a sustentabilidade do planeta. Comece trocando lâmpadas incandescentes por modelos LED, que consomem até 80% menos energia e duram muito mais. Aproveite ao máximo a iluminação natural durante o dia e adote o hábito de apagar luzes em cômodos vazios. Eletrodomésticos com selo Procel A também fazem diferença, pois são projetados para maior eficiência energética.\r\n\r\nOutra medida eficaz é ficar atento ao uso do chuveiro elétrico, responsável por até 25% do consumo residencial. Reduzir o tempo no banho e manter a temperatura no modo \"verão\" já traz economia significativa. No inverno, vale investir em isolamento térmico de janelas e cortinas grossas para reter calor, diminuindo a necessidade de aquecedores. Na cozinha, panelas com tampas e tamanho adequado ao fogão aceleram o cozimento, enquanto a manutenção regular da geladeira (como verificar a borracha de vedação) garante melhor desempenho.\r\n\r\nTecnologia também pode ser aliada: temporizadores em tomadas evitam o standby de aparelhos, e sistemas de automação residencial permitem programar o funcionamento de luzes e equipamentos. Pequenas mudanças, como secar roupas no varal em vez de usar a secadora e priorizar ventiladores em vez de ar-condicionado, somam grandes resultados. Com essas práticas, cada casa se torna parte ativa na redução da demanda energética e na construção de um futuro mais sustentável.', '2025-06-08 10:20:00', 67),
(48, 'Economia Circular: Redefinindo Nosso Modelo de Consumo', 'Enquanto o modelo linear tradicional segue a lógica \"extrair, produzir, descartar\", a economia circular propõe um sistema regenerativo, em que os recursos são mantidos em uso pelo maior tempo possível. Seus princípios incluem a redução de desperdícios, o reaproveitamento de materiais e a regeneração de ecossistemas naturais. Empresas como a Patagônia exemplificam essa abordagem, com programas de reparo e reciclagem de roupas, transformando resíduos têxteis em novas peças e reduzindo a demanda por matéria-prima virgem.\r\n\r\nA economia circular também valoriza o design inteligente, com produtos pensados para serem desmontados, reparados ou reciclados ao final de sua vida útil. Um caso emblemático é o da Fairphone, que produz smartphones modulares, facilitando a troca de peças e prolongando sua durabilidade. Além disso, setores como a construção civil estão adotando práticas circulares, como a reutilização de materiais de demolição e a criação de edifícios com estruturas adaptáveis a novos usos.\r\n\r\nNo âmbito individual, os consumidores podem contribuir adotando hábitos como compra de produtos duráveis, compartilhamento de bens e participação em sistemas de logística reversa. Cidades como Amsterdã e Lisboa já implementam políticas públicas que incentivam a circularidade, desde compostagem comunitária até hubs de economia colaborativa. Ao repensar nosso consumo, a economia circular não só minimiza impactos ambientais, mas também cria oportunidades econômicas e sociais mais justas e resilientes.', '2025-06-08 16:20:00', 31),
(49, 'Produtos de Limpeza Ecológicos que Você Pode Fazer em Casa', 'Substituir produtos químicos agressivos por alternativas naturais é mais simples do que parece, e os resultados podem ser igualmente eficazes. Um ótimo exemplo é o multiuso ecológico, feito com vinagre branco, água e cascas de frutas cítricas (como limão ou laranja). O vinagre possui propriedades desinfetantes e antigordurosas, enquanto as cascas cítricas deixam um aroma fresco e potencializam a ação limpante. Basta misturar os ingredientes em um borrifador e deixar a solução descansar por alguns dias antes de usar.\r\n\r\nPara limpar vidros e espelhos sem deixar manchas ou resíduos químicos, uma receita infalível é a solução de álcool e água, combinada com uma colher de sopa de amido de milho (maisena). O álcool ajuda a evaporar rapidamente, evitando riscos, enquanto a maisena remove marcas de dedos e poeira com facilidade. Outra opção é o desinfetante natural à base de óleos essenciais, como tea tree ou lavanda, que possuem propriedades antibacterianas e antifúngicas. Misture algumas gotas com água e bicarbonato de sódio para um produto seguro e aromático.\r\n\r\nNa limpeza pesada, como banheiros e pisos, o bicarbonato de sódio é um aliado poderoso. Ele pode ser usado puro como um esfoliante natural para remover sujeira incrustada ou combinado com vinagre para desentupir ralos (reação efervescente que dissolve resíduos). Para um sabão em pó ecológico, rale uma barra de sabão de coco, misture com bicarbonato e carbonato de sódio, e use pequenas quantidades por lavagem. Essas receitas não só economizam dinheiro, mas também protegem a saúde da família e reduzem o impacto ambiental.', '2025-06-09 10:40:00', 43),
(50, 'Arquitetura Sustentável: Princípios e Casos de Sucesso', 'A arquitetura sustentável busca equilibrar funcionalidade, estética e baixo impacto ambiental, utilizando estratégias como eficiência energética, materiais ecológicos e integração com o entorno. Princípios como ventilação natural, iluminação solar passiva e telhados verdes reduzem o consumo de energia e melhoram o conforto térmico. Um exemplo emblemático é o Bosco Verticale, em Milão, que incorpora milhares de árvores e plantas em suas fachadas, absorvendo CO₂, filtrando poluentes e criando microclimas urbanos mais frescos.\r\n\r\nAlém disso, a escolha de materiais sustentáveis, como madeira certificada, bambu e concreto reciclado, tem ganhado destaque em projetos ao redor do mundo. O Edge, em Amsterdã, considerado um dos prédios mais verdes do planeta, utiliza painéis solares, sistemas de reúso de água e sensores inteligentes para minimizar desperdícios. Essas soluções mostram que a inovação tecnológica, aliada a um design consciente, pode reduzir significativamente a pegada ambiental das construções.\r\n\r\nCasos como o Pearl River Tower, na China, e o Bullitt Center, em Seattle, comprovam que é possível alcançar autossuficiência energética e neutralidade em carbono na arquitetura. O primeiro emprega turbinas eólicas integradas e fachadas fotovoltaicas, enquanto o segundo opera com energia 100% renovável e sistemas de captação de água da chuva. Esses projetos inspiradores demonstram que, quando a sustentabilidade é priorizada desde a concepção, a arquitetura não só preserva o planeta, mas também eleva a qualidade de vida de seus ocupantes.', '2025-06-09 15:15:00', 19),
(51, 'O Papel das Cidades no Combate às Mudanças Climáticas', 'As cidades desempenham um papel crucial no combate às mudanças climáticas, já que concentram mais de 50% da população global e são responsáveis por cerca de 70% das emissões de gases de efeito estufa. Para reduzir esse impacto, muitas metrópoles estão adotando iniciativas inovadoras, como a expansão de redes de transporte público sustentável, a promoção de energias renováveis e a criação de zonas de baixa emissão. Um exemplo notável é Copenhague, que pretende se tornar a primeira capital carbono neutro até 2025, investindo em ciclovias, energia eólica e sistemas de aquecimento urbano eficientes.\r\n\r\nAlém disso, políticas de planejamento urbano sustentável estão ganhando força, com cidades como Curitiba e Bogotá implementando corredores verdes, parques urbanos e sistemas de captação de água da chuva para reduzir inundações e ilhas de calor. A vegetação urbana não apenas absorve CO₂, mas também melhora a qualidade do ar e o bem-estar da população. Nova York, por exemplo, lançou o programa Cool Neighborhoods, que amplia áreas arborizadas em bairros vulneráveis, combatendo desigualdades climáticas e reduzindo o consumo de energia com refrigeração.\r\n\r\nOutra frente de atuação é a economia circular, com cidades como Amsterdã e São Francisco incentivando a reciclagem, a compostagem e o consumo consciente por meio de políticas públicas e parcerias com a iniciativa privada. A adoção de construções verdes, com certificações como LEED e BREEAM, também tem crescido, reduzindo o desperdício de recursos e as emissões do setor imobiliário. Essas medidas demonstram que, embora os desafios sejam grandes, as cidades têm o potencial de liderar a transição para um futuro mais sustentável, inspirando nações e comunidades a seguirem o mesmo caminho.', '2025-06-10 09:30:00', 7),
(52, 'Biodiversidade e Porque É Importante', 'Entenda a importância da diversidade biológica para o equilíbrio do planeta...', '2025-05-13 12:45:00', 67),
(53, 'Educação Ambiental para Crianças: Como Ensinar de Forma Divertida', 'Atividades e recursos para conscientizar os pequenos sobre sustentabilidade desde cedo...', '2025-04-08 14:50:00', 31),
(54, 'Finanças Verdes: Investindo com Consciência Ecológica', 'Como alinhar seus investimentos com seus valores ambientais e ainda obter bons retornos...', '2025-05-15 11:10:00', 43),
(55, 'Turismo Sustentável: Viajar sem Deixar Pegadas', 'Viajar de forma sustentável começa com escolhas conscientes ainda no planejamento da viagem. Optar por destinos menos massificados, como vilarejos rurais ou reservas ecológicas, ajuda a reduzir a pressão sobre pontos turísticos superlotados e distribui melhor os benefícios econômicos. Priorize hospedagens com certificações ambientais (como o selo LEED ou Rainforest Alliance) que utilizam energia renovável, gestão de resíduos e valorizam a mão-de-obra local. No deslocamento, sempre que possível, prefira trens a aviões para trajetos curtos – um voo de 500 km emite até 10 vezes mais CO₂ por passageiro do que a mesma viagem de trem.\r\n\r\nDurante a estadia, pequenas atitudes fazem grande diferença: recuse plásticos descartáveis levando seu kit reutilizável (canudo de metal, copo dobrável e sacola ecológica), economize água e energia como faria em casa, e respeite os ecossistemas locais mantendo distância segura de animais selvagens e seguindo trilhas demarcadas. Dê preferência a restaurantes que servem pratos típicos com ingredientes regionais e sazonais – isso reduz a pegada de carbono do transporte de alimentos e fortalece produtores locais. Em cidades, explore a pé ou de bicicleta, descobrindo detalhes que passariam despercebidos de carro.\r\n\r\nO turismo comunitário é uma das formas mais ricas de viajar sustentavelmente, conectando-se diretamente com a cultura local. Projetos como as pousadas geridas por indígenas no Brasil ou as eco-vilas na Costa Rica oferecem experiências autênticas enquanto reinvestem os recursos na comunidade. Ao comprar artesanato, negocie com respeito e prefira itens feitos com materiais naturais da região. Lembre-se: o melhor souvenir é a memória de uma viagem que enriqueceu tanto você quanto o destino visitado – sem explorar pessoas ou recursos, mas criando laços positivos que incentivam a preservação do local para futuros viajantes.', '2025-06-02 13:45:00', 7),
(56, 'Têxteis Sustentáveis: Do Campo ao Guarda-Roupa', 'A indústria têxtil, tradicionalmente uma das mais poluentes do mundo, está passando por uma revolução sustentável com o desenvolvimento de materiais inovadores e processos menos agressivos ao meio ambiente. Fibras naturais como o algodão orgânico (cultivado sem pesticidas e com menor consumo de água) e o linho (que requer poucos insumos) ganham espaço, enquanto alternativas surpreendentes emergem: o piñatex, feito de fibras de abacaxi, e os tecidos à base de algas ou cogumelos oferecem opções biodegradáveis e de baixo impacto. Marcas como a Patagônia e a Stella McCartney já incorporam esses materiais em suas coleções, provando que é possível unir moda e sustentabilidade.\r\n\r\nAlém das matérias-primas, o processo de produção também está se transformando. Técnicas como a coloração natural (com pigmentos de plantas e minerais) e a reciclagem de fibras têxteis reduzem drasticamente o uso de água e químicos nocivos. A empresa holandesa DyeCoo, por exemplo, desenvolveu um método de tingimento que utiliza CO₂ supercrítico em vez de água, eliminando completamente os resíduos líquidos. Já iniciativas como a da Retold Recycling nos EUA mostram que até roupas velhas e retalhos podem ser transformados em novos fios, fechando o ciclo da moda circular.\r\n\r\nO consumidor final tem papel crucial nessa cadeia, seja optando por peças duráveis e atemporais, seja participando de programas de logística reversa oferecidos por diversas marcas. Lavar menos as roupas (e sempre com água fria), consertar em vez de descartar e comprar de brechós são hábitos que amplificam o impacto positivo. À medida que tecnologia e conscientização avançam, o guarda-roupa sustentável deixa de ser utopia para se tornar uma realidade acessível – onde cada escolha vestível é também um voto pelo planeta.', '2025-06-03 09:45:00', 43),
(57, 'Hortas Urbanas: Cultive em Pequenos Espaços', 'Ter uma horta em casa é possível mesmo com espaço limitado – basta criatividade e as técnicas certas. Em varandas e sacadas, os vasos autoirrigáveis são ideais para quem tem rotina corrida, pois mantêm a umidade por mais tempo. Comece com ervas como manjericão, hortelã e alecrim, que são resistentes e úteis no dia a dia. Para otimizar o espaço vertical, use estruturas como pallets, treliças ou jardineiras de parede, que permitem cultivar morangos, tomates-cereja e até folhas verdes em pequenas áreas. A chave é posicionar os vasos em locais que recebam pelo menos 4 horas de sol diárias.\r\n\r\nEm apartamentos sem varanda, as hortas internas também prosperam com iluminação adequada. Luzes de cultivo LED, específicas para plantas, podem substituir a luz solar em ambientes pouco iluminados. Opções como microgreens (broto de vegetais como rabanete e couve) e temperos como cebolinha e salsa crescem bem nesse sistema e estão prontos para colher em poucas semanas. Outra solução são os jardins de ervas em recipientes reaproveitados, como latas e potes de vidro, que além de funcionais, trazem um toque decorativo à cozinha.\r\n\r\nPara quem quer ir além, sistemas de hidroponia caseira permitem cultivar hortaliças sem solo, usando apenas água enriquecida com nutrientes. Kits compactos e fáceis de montar são perfeitos para alfaces, rúculas e espinafres. Além de garantir alimentos frescos e livres de agrotóxicos, as hortas urbanas melhoram a qualidade do ar e trazem benefícios terapêuticos. Seja em um pequeno vaso ou em uma estrutura vertical, cada planta cultivada é um passo em direção a uma vida mais sustentável e conectada com a natureza – mesmo no coração da cidade.', '2025-06-03 11:15:00', 67),
(58, 'Voluntariado Ambiental: Como Fazer a Diferença', 'O voluntariado ambiental oferece diversas formas de contribuir ativamente para a preservação do planeta, desde ações locais até projetos globais. Uma das oportunidades mais acessíveis é participar de mutirões de limpeza em praias, parques e rios, organizados por ONGs e grupos comunitários. Além de remover resíduos poluentes, essas iniciativas ajudam a conscientizar a população sobre o descarte adequado do lixo. Outra opção é engajar-se em projetos de reflorestamento, como os do Instituto Terra ou SOS Mata Atlântica, que recuperam áreas degradadas e protegem a biodiversidade.\r\n\r\nPara quem prefere atuar na educação ambiental, há espaços em escolas, museus e centros comunitários que precisam de voluntários para ministrar oficinas e palestras sobre temas como reciclagem, compostagem e consumo consciente. Organizações como o Greenpeace e WWF também oferecem programas de formação para multiplicadores ambientais. Além disso, plataformas digitais permitem contribuir remotamente, seja mapeando áreas desmatadas via satélite (como no projeto MapBiomas) ou participando de campanhas de conscientização nas redes sociais.\r\n\r\nQuem possui habilidades específicas pode colocá-las a serviço da causa ambiental: biólogos podem auxiliar em pesquisas de campo, designers criar materiais educativos, e fotógrafos documentar espécies ameaçadas. Até mesmo em casa é possível fazer a diferença, adotando práticas sustentáveis e inspirando amigos e familiares. O voluntariado ambiental prova que, quando unimos forças, pequenas ações coletivas têm o poder de transformar realidades e garantir um futuro mais verde para as próximas gerações.', '2025-06-07 14:10:00', 31);

-- --------------------------------------------------------

--
-- Table structure for table `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `palavra_passe` varchar(255) NOT NULL,
  `tipo` enum('admin','regular') DEFAULT 'regular',
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilizadores`
--

INSERT INTO `utilizadores` (`id`, `nome`, `email`, `data_nascimento`, `palavra_passe`, `tipo`, `data_registro`, `data_atualizacao`) VALUES
(1, 'Administrador', 'admin@greentrack.pt', '1998-12-02', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'admin', '2025-06-09 15:25:00', '2025-06-09 15:25:00'),
(2, 'João Silva', 'joao.silva1@email.com', '1985-05-15', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-02 09:15:22', '2025-06-09 15:25:54'),
(3, 'Maria Santos', 'maria.santos1@email.com', '1990-08-21', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-03 10:30:45', '2025-06-09 15:25:54'),
(4, 'António Ferreira', 'antonio.ferreira1@email.com', '1982-11-30', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-05 14:22:10', '2025-06-09 15:25:54'),
(5, 'Ana Oliveira', 'ana.oliveira1@email.com', '1995-03-12', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-07 16:45:33', '2025-06-09 15:25:54'),
(6, 'Carlos Costa', 'carlos.costa1@email.com', '1978-07-25', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-08 11:20:18', '2025-06-09 15:25:54'),
(7, 'Sofia Rodrigues', 'sofia.rodrigues1@email.com', '1992-09-08', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'admin', '2025-01-10 13:10:55', '2025-06-09 15:25:54'),
(8, 'Pedro Martins', 'pedro.martins1@email.com', '1989-12-05', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-12 15:30:40', '2025-06-09 15:25:54'),
(9, 'Inês Almeida', 'ines.almeida1@email.com', '1998-04-18', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-14 17:25:12', '2025-06-09 15:25:54'),
(10, 'Miguel Pereira', 'miguel.pereira1@email.com', '1980-06-22', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-16 10:15:30', '2025-06-09 15:25:54'),
(11, 'Beatriz Gomes', 'beatriz.gomes1@email.com', '1993-01-28', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-18 14:40:20', '2025-06-09 15:25:54'),
(12, 'Rui Fernandes', 'rui.fernandes1@email.com', '1975-10-14', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-20 09:50:45', '2025-06-09 15:25:54'),
(13, 'Teresa Lopes', 'teresa.lopes1@email.com', '1987-02-17', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-22 12:30:15', '2025-06-09 15:25:54'),
(14, 'Francisco Marques', 'francisco.marques1@email.com', '1996-08-03', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-24 16:20:50', '2025-06-09 15:25:54'),
(15, 'Laura Teixeira', 'laura.teixeira1@email.com', '1984-05-19', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-26 11:10:25', '2025-06-09 15:25:54'),
(16, 'Hugo Ribeiro', 'hugo.ribeiro1@email.com', '1991-07-11', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-28 14:45:35', '2025-06-09 15:25:54'),
(17, 'Catarina Pinto', 'catarina.pinto1@email.com', '1979-12-24', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-01-30 10:30:40', '2025-06-09 15:25:54'),
(18, 'Luís Carvalho', 'luis.carvalho1@email.com', '1994-03-07', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-01 15:20:10', '2025-06-09 15:25:54'),
(19, 'Margarida Mendes', 'margarida.mendes1@email.com', '1986-09-30', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'admin', '2025-02-03 09:40:55', '2025-06-09 15:25:54'),
(20, 'Ricardo Nunes', 'ricardo.nunes1@email.com', '1997-11-12', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-05 13:15:30', '2025-06-09 15:25:54'),
(21, 'Diana Soares', 'diana.soares1@email.com', '1983-04-25', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-07 17:10:20', '2025-06-09 15:25:54'),
(22, 'Bruno Matos', 'bruno.matos1@email.com', '1999-01-08', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-09 11:45:40', '2025-06-09 15:25:54'),
(23, 'Patrícia Fonseca', 'patricia.fonseca1@email.com', '1977-06-13', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-11 14:30:15', '2025-06-09 15:25:54'),
(24, 'André Machado', 'andre.machado1@email.com', '1990-08-27', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-13 10:20:50', '2025-06-09 15:25:54'),
(25, 'Helena Barros', 'helena.barros1@email.com', '1988-02-14', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-15 16:15:25', '2025-06-09 15:25:54'),
(26, 'Gonçalo Baptista', 'goncalo.baptista1@email.com', '1995-05-06', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-17 12:40:35', '2025-06-09 15:25:54'),
(27, 'Cláudia Simões', 'claudia.simoes1@email.com', '1981-10-09', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-19 09:30:45', '2025-06-09 15:25:54'),
(28, 'Vítor Moreira', 'vitor.moreira1@email.com', '1993-07-22', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-21 15:10:20', '2025-06-09 15:25:54'),
(29, 'Mafalda Antunes', 'mafalda.antunes1@email.com', '1989-12-15', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-23 11:25:30', '2025-06-09 15:25:54'),
(30, 'Paulo Domingues', 'paulo.domingues1@email.com', '1976-03-28', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-02-25 14:50:40', '2025-06-09 15:25:54'),
(31, 'Sara Andrade', 'sara.andrade1@email.com', '1998-09-01', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'admin', '2025-02-27 10:15:55', '2025-06-09 15:25:54'),
(32, 'Tiago Campos', 'tiago.campos1@email.com', '1984-11-24', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-01 16:30:25', '2025-06-09 15:25:54'),
(33, 'Leonor Dinis', 'leonor.dinis1@email.com', '1991-04-07', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-03 12:45:35', '2025-06-09 15:25:54'),
(34, 'Filipe Vicente', 'filipe.vicente1@email.com', '1987-08-19', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-05 09:20:45', '2025-06-09 15:25:54'),
(35, 'Irina Neves', 'irina.neves1@email.com', '1996-01-12', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-07 14:10:50', '2025-06-09 15:25:54'),
(36, 'Daniel Lourenço', 'daniel.lourenco1@email.com', '1979-05-25', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-09 11:35:20', '2025-06-09 15:25:54'),
(37, 'Carina Abreu', 'carina.abreu1@email.com', '1994-10-08', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-11 17:25:30', '2025-06-09 15:25:54'),
(38, 'Jorge Brito', 'jorge.brito1@email.com', '1982-02-21', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-13 13:40:40', '2025-06-09 15:25:54'),
(39, 'Filipa Pinho', 'filipa.pinho1@email.com', '1997-07-14', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-15 10:55:15', '2025-06-09 15:25:54'),
(40, 'Alexandre Tavares', 'alexandre.tavares1@email.com', '1985-12-27', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-17 15:30:25', '2025-06-09 15:25:54'),
(41, 'Raquel Ventura', 'raquel.ventura1@email.com', '1990-03-10', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-19 12:45:35', '2025-06-09 15:25:54'),
(42, 'Nuno Sequeira', 'nuno.sequeira1@email.com', '1988-09-23', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-21 09:20:45', '2025-06-09 15:25:54'),
(43, 'Bárbara Paiva', 'barbara.paiva1@email.com', '1995-04-06', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'admin', '2025-03-23 14:10:50', '2025-06-09 15:25:54'),
(44, 'Rafael Leal', 'rafael.leal1@email.com', '1981-11-19', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-25 11:35:20', '2025-06-09 15:25:54'),
(45, 'Débora Faria', 'debora.faria1@email.com', '1993-08-02', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-27 17:25:30', '2025-06-09 15:25:54'),
(46, 'Artur Magalhães', 'artur.magalhaes1@email.com', '1977-01-15', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-29 13:40:40', '2025-06-09 15:25:54'),
(47, 'Liliana Azevedo', 'liliana.azevedo1@email.com', '1999-05-28', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-03-31 10:55:15', '2025-06-09 15:25:54'),
(48, 'Eduardo Pimenta', 'eduardo.pimenta1@email.com', '1984-10-11', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-02 15:30:25', '2025-06-09 15:25:54'),
(49, 'Verónica Veloso', 'veronica.veloso1@email.com', '1991-02-24', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-04 12:45:35', '2025-06-09 15:25:54'),
(50, 'Samuel Brandão', 'samuel.brandao1@email.com', '1989-07-07', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-06 09:20:45', '2025-06-09 15:25:54'),
(51, 'Cristina Resende', 'cristina.resende1@email.com', '1996-12-20', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-08 14:10:50', '2025-06-09 15:25:54'),
(52, 'Mário Pacheco', 'mario.pacheco1@email.com', '1980-03-03', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-10 11:35:20', '2025-06-09 15:25:54'),
(53, 'Vera Quintas', 'vera.quintas1@email.com', '1994-09-16', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-12 17:25:30', '2025-06-09 15:25:54'),
(54, 'Renato Miranda', 'renato.miranda1@email.com', '1982-04-29', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-14 13:40:40', '2025-06-09 15:25:54'),
(55, 'Sónia Valente', 'sonia.valente1@email.com', '1997-11-12', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-16 10:55:15', '2025-06-09 15:25:54'),
(56, 'Hélder Rosado', 'helder.rosado1@email.com', '1985-06-25', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-18 15:30:25', '2025-06-09 15:25:54'),
(57, 'Adriana Frade', 'adriana.frade1@email.com', '1990-01-08', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-20 12:45:35', '2025-06-09 15:25:54'),
(58, 'Bernardo Peixoto', 'bernardo.peixoto1@email.com', '1988-08-21', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-22 09:20:45', '2025-06-09 15:25:54'),
(59, 'Lúcia Cordeiro', 'lucia.cordeiro1@email.com', '1995-03-04', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-24 14:10:50', '2025-06-09 15:25:54'),
(60, 'Gilberto Guerreiro', 'gilberto.guerreiro1@email.com', '1981-10-17', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-26 11:35:20', '2025-06-09 15:25:54'),
(61, 'Marta Bento', 'marta.bento1@email.com', '1993-05-30', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-28 17:25:30', '2025-06-09 15:25:54'),
(62, 'Alexandra Faustino', 'alexandra.faustino1@email.com', '1977-12-13', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-04-30 13:40:40', '2025-06-09 15:25:54'),
(63, 'Rúben Fialho', 'ruben.fialho1@email.com', '1999-07-26', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-02 10:55:15', '2025-06-09 15:25:54'),
(64, 'Júlia Galvão', 'julia.galvao1@email.com', '1984-02-09', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-04 15:30:25', '2025-06-09 15:25:54'),
(65, 'Marcelo Figueiredo', 'marcelo.figueiredo1@email.com', '1991-09-22', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-06 12:45:35', '2025-06-09 15:25:54'),
(66, 'Tânia Mota', 'tania.mota1@email.com', '1989-04-05', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-08 09:20:45', '2025-06-09 15:25:54'),
(67, 'Xavier Alves', 'xavier.alves1@email.com', '1996-11-18', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'admin', '2025-05-10 14:10:50', '2025-06-09 15:25:54'),
(68, 'Olívia Varela', 'olivia.varela1@email.com', '1980-06-01', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-12 11:35:20', '2025-06-09 15:25:54'),
(69, 'Ivo Bessa', 'ivo.bessa1@email.com', '1994-01-14', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-14 17:25:30', '2025-06-09 15:25:54'),
(70, 'Eva Matias', 'eva.matias1@email.com', '1982-08-27', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-16 13:40:40', '2025-06-09 15:25:54'),
(71, 'Salomé Pires', 'salome.pires1@email.com', '1997-03-10', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-18 10:55:15', '2025-06-09 15:25:54'),
(72, 'Tomás Rego', 'tomas.rego1@email.com', '1985-12-23', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-20 15:30:25', '2025-06-09 15:25:54'),
(73, 'Alice Couto', 'alice.couto1@email.com', '1990-07-06', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-22 12:45:35', '2025-06-09 15:25:54'),
(74, 'David Raposo', 'david.raposo1@email.com', '1988-02-19', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-24 09:20:45', '2025-06-09 15:25:54'),
(75, 'Clara Godinho', 'clara.godinho1@email.com', '1995-09-02', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-26 14:10:50', '2025-06-09 15:25:54'),
(76, 'Vasco Borges', 'vasco.borges1@email.com', '1981-04-15', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-28 11:35:20', '2025-06-09 15:25:54'),
(77, 'Rosa Amaral', 'rosa.amaral1@email.com', '1993-11-28', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-05-30 17:25:30', '2025-06-09 15:25:54'),
(78, 'Jaime Furtado', 'jaime.furtado1@email.com', '1977-06-11', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-06-01 13:40:40', '2025-06-09 15:25:54'),
(79, 'Lara Barroso', 'lara.barroso1@email.com', '1999-01-24', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-06-03 10:55:15', '2025-06-09 15:25:54'),
(80, 'Frederico Morais', 'frederico.morais1@email.com', '1984-08-07', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-06-05 15:30:25', '2025-06-09 15:25:54'),
(81, 'Gabriela Teles', 'gabriela.teles1@email.com', '1991-03-20', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-06-07 12:45:35', '2025-06-09 15:25:54'),
(82, 'Duarte Medeiros', 'duarte.medeiros1@email.com', '1989-10-03', '$2y$10$636X8UKTVjj9W7SIyocYFOUSimdP/mnXgiZPAjeTdOS/8bGU1Dsx2', 'regular', '2025-06-09 09:20:45', '2025-06-09 15:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `votos`
--

CREATE TABLE `votos` (
  `id` int NOT NULL,
  `tipo` enum('like','dislike') NOT NULL,
  `conteudo_id` int DEFAULT NULL,
  `utilizador_id` int DEFAULT NULL,
  `data_voto` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `votos`
--

INSERT INTO `votos` (`id`, `tipo`, `conteudo_id`, `utilizador_id`, `data_voto`) VALUES
(1, 'like', 1, 2, '2025-01-02 10:30:00'),
(2, 'like', 2, 12, '2025-01-03 11:00:00'),
(3, 'dislike', 3, 17, '2025-01-04 12:15:00'),
(4, 'like', 4, 25, '2025-01-05 13:45:00'),
(5, 'like', 5, 31, '2025-01-06 14:20:00'),
(6, 'dislike', 6, 40, '2025-01-07 15:10:00'),
(7, 'like', 7, 42, '2025-01-08 16:30:00'),
(8, 'like', 8, 63, '2025-01-09 17:45:00'),
(9, 'dislike', 9, 70, '2025-01-10 18:05:00'),
(10, 'like', 10, 75, '2025-01-11 09:25:00'),
(11, 'like', 11, 2, '2025-02-12 10:10:00'),
(12, 'dislike', 12, 12, '2025-02-13 11:40:00'),
(13, 'like', 13, 17, '2025-02-14 12:30:00'),
(14, 'like', 14, 25, '2025-02-15 13:50:00'),
(15, 'dislike', 15, 31, '2025-02-16 14:55:00'),
(16, 'like', 16, 40, '2025-02-17 15:05:00'),
(17, 'like', 17, 42, '2025-02-18 16:45:00'),
(18, 'dislike', 18, 63, '2025-02-19 17:15:00'),
(19, 'like', 19, 70, '2025-02-20 18:20:00'),
(20, 'dislike', 20, 75, '2025-02-21 09:30:00'),
(21, 'like', 21, 2, '2025-03-22 10:05:00'),
(22, 'like', 22, 12, '2025-03-23 11:35:00'),
(23, 'dislike', 23, 17, '2025-03-24 12:25:00'),
(24, 'like', 24, 25, '2025-03-25 13:55:00'),
(25, 'dislike', 25, 31, '2025-03-26 14:50:00'),
(26, 'like', 26, 40, '2025-03-27 15:00:00'),
(27, 'dislike', 27, 42, '2025-03-28 16:40:00'),
(28, 'like', 28, 63, '2025-03-29 17:10:00'),
(29, 'dislike', 29, 70, '2025-03-30 18:15:00'),
(30, 'like', 30, 75, '2025-03-31 09:25:00'),
(147, 'like', 8, 2, '2025-05-08 08:00:00'),
(148, 'like', 8, 3, '2025-05-08 11:15:00'),
(149, 'dislike', 8, 4, '2025-05-09 09:30:00'),
(150, 'like', 8, 5, '2025-05-09 13:45:00'),
(151, 'like', 8, 7, '2025-05-10 08:00:00'),
(152, 'dislike', 8, 8, '2025-05-11 09:30:00'),
(153, 'like', 8, 9, '2025-05-11 15:45:00'),
(154, 'like', 8, 10, '2025-05-12 10:00:00'),
(155, 'like', 8, 11, '2025-05-12 16:15:00'),
(156, 'like', 8, 12, '2025-05-13 11:30:00'),
(202, 'like', 50, 3, '2025-06-09 16:45:47'),
(203, 'like', 49, 3, '2025-06-09 16:45:48'),
(204, 'like', 51, 3, '2025-06-09 16:45:49'),
(205, 'like', 48, 3, '2025-06-09 16:45:51'),
(206, 'like', 47, 3, '2025-06-09 16:45:51'),
(207, 'dislike', 58, 3, '2025-06-09 16:45:52'),
(208, 'like', 22, 3, '2025-06-09 16:45:56'),
(209, 'like', 21, 3, '2025-06-09 16:45:56'),
(210, 'dislike', 20, 3, '2025-06-09 16:45:57'),
(211, 'like', 19, 3, '2025-06-09 16:45:59'),
(212, 'like', 18, 3, '2025-06-09 16:45:59'),
(213, 'like', 16, 3, '2025-06-09 16:46:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acoes_sustentaveis`
--
ALTER TABLE `acoes_sustentaveis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilizador_id` (`utilizador_id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `conteudos`
--
ALTER TABLE `conteudos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilizador_id` (`utilizador_id`);

--
-- Indexes for table `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conteudo_id` (`conteudo_id`,`utilizador_id`),
  ADD KEY `utilizador_id` (`utilizador_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acoes_sustentaveis`
--
ALTER TABLE `acoes_sustentaveis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=468;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `conteudos`
--
ALTER TABLE `conteudos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acoes_sustentaveis`
--
ALTER TABLE `acoes_sustentaveis`
  ADD CONSTRAINT `acoes_sustentaveis_ibfk_1` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`);

--
-- Constraints for table `conteudos`
--
ALTER TABLE `conteudos`
  ADD CONSTRAINT `conteudos_ibfk_1` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`);

--
-- Constraints for table `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`conteudo_id`) REFERENCES `conteudos` (`id`),
  ADD CONSTRAINT `votos_ibfk_2` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
