-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2023 m. Lap 21 d. 13:54
-- Server version: 5.6.38
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akademines_sistema`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'PI22A'),
(2, 'PI22B'),
(3, 'PI22S');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `marks`
--

INSERT INTO `marks` (`id`, `student_id`, `mark`, `subject_id`) VALUES
(5, 10, 10, 1),
(6, 13, 2, 1),
(7, 16, 2, 1),
(17, 10, 2, 5),
(18, 13, 2, 5),
(19, 16, 2, 5);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `teacher_id`) VALUES
(1, 'Skaitiniai ir optimizavimo metodai', 4),
(2, 'DuomenÅ³ baziÅ³ projektavimas', 7),
(3, 'Informacijos sistemos', 8),
(4, 'Vadyba', 6),
(5, 'Objektinis programavimas', 5),
(6, 'TeisÄ—', 9);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `subjects_in_group`
--

CREATE TABLE `subjects_in_group` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `subjects_in_group`
--

INSERT INTO `subjects_in_group` (`id`, `subject_id`, `group_id`) VALUES
(7, 1, 2),
(8, 2, 2),
(9, 3, 2),
(10, 4, 2),
(11, 5, 2),
(12, 6, 2),
(13, 1, 3),
(14, 2, 3),
(15, 3, 3),
(16, 4, 3),
(17, 5, 3),
(18, 6, 3),
(43, 1, 1),
(44, 2, 1),
(45, 3, 1),
(46, 4, 1),
(47, 5, 1),
(48, 6, 1);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `role` tinyint(4) DEFAULT NULL,
  `group` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `username`, `password`, `role`, `group`) VALUES
(1, 'Admin', 'Admin', 'admin.admin', '$2y$10$z.X1o0yi6k1UUF8cH4Gw2eK2/qck8tJTJNZACGWAFTOO9ZNcWk.gm', 1, NULL),
(4, 'Loreta', 'Savulioniene', 'Loreta.Savulioniene', '$2y$10$o/0vzuez5n60zYsaH2jzj.j8ExBGU8CyWGjiaDrYFuV.3cHvqns7S', 2, NULL),
(5, 'Igor', 'Katin', 'Igor.Katin', '$2y$10$Wacs81pBmsQ9e233fQRTsuV3/QVpWciXJ7dlvLFrzLYXtHeoUF5di', 2, NULL),
(6, 'Anzelika', 'Slimanaviciene', 'Anzelika.Slimanaviciene', '$2y$10$AC6Kv3Ns6cZjokRRQJOeX.yQvqZ6b.MqTGxzwWBblsmD5vV1I1E.6', 2, NULL),
(7, 'Dainius', 'Savulionis', 'Dainius.Savulionis', '$2y$10$F0NrFEgxsVcZs/DnMLetsumc0XahGdsMNtKCvYgcEohwIs3jOtBSy', 2, NULL),
(8, 'Tatjana', 'Liogiene', 'Tatjana.Liogiene', '$2y$10$.ad0K270R.ebW0fxdAy2IOW0Yy.m3Vm5RNpAiYKx8cB2Vqf9oRY7m', 2, NULL),
(9, 'Ramune', 'Mikoniene', 'Ramune.Mikoniene', '$2y$10$E2/7CswatP3gc0E213pSjuycrREiFxAipN4n.t13rrvLVbCSA3Q/u', 2, NULL),
(10, 'Juliana', 'Andrukonis', 'Juliana.Andrukonis', '$2y$10$ugQ71T/8JORyvdgCoOcPOed5PtpUPnahB.nmV06C5p8Z66F2dqTNK', NULL, 1),
(11, 'Meda', 'Kynaite', 'Meda.Kynaite', '$2y$10$MhlAtD0QXuqJHSKLv101MetgPkpS8d1p1P1Azu8pk9HUgAdy6qF7q', NULL, 1),
(12, 'Marija', 'Semionova', 'Marija.Semionova', '$2y$10$UKWd6315l.MT5m9UOZ0TzumW18haHg0bxff90UvVN1M2b7HYDHCU2', NULL, 3),
(13, 'Ivan', 'Savochkin', 'Ivan.Savochkin', '$2y$10$RzBAs/vH8TVpjATcFX5Vsu8OXJkCbEhUKfi86e8aJ7zQo0BCN/.ju', NULL, 1),
(14, 'Arnas', 'Silaikis', 'Arnas.Silaikis', '$2y$10$ZF34UsPiVhJRz5ZGU9ekG.GKE/SSqPZyFh8Kd.XNmoOnr54HASspS', NULL, 2),
(15, 'Mazvydas', 'Bernotas', 'Mazvydas.Bernotas', '$2y$10$Ust/ro9qH1VpnBsLllpvguMel/4OoWsKQP0DVHPdzgXkKHG/OaBEq', NULL, 3),
(16, 'Dainius', 'Genzuras', 'Dainius.Genzuras', '$2y$10$ME3NIl.YUSwzX.9SUY0OaOprYHGO/I6TwjXL5HMnvQZZQjaJ4cW1y', NULL, 1),
(17, 'Nikita', 'Salunovas', 'Nikita.Salunovas', '$2y$10$zwgTwXwu2AMbNZlXQezFo.GW9qXbZetSyuAI9yv154RAtbHML1cn.', NULL, 2),
(18, 'Aidas', 'Kaupas', 'Aidas.Kaupas', '$2y$10$JoS.MZWldj6ZPUgu2SWrdu0Buuw/BKzetRmomOaiV8LT1Cz0FaQ52', NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `subjects_in_group`
--
ALTER TABLE `subjects_in_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subjects_in_group`
--
ALTER TABLE `subjects_in_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
