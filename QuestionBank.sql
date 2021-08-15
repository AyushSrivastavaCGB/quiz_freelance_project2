-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 15, 2021 at 08:34 PM
-- Server version: 8.0.26-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `QuestionBank`
--

CREATE TABLE `QuestionBank` (
  `id` int NOT NULL,
  `question` text NOT NULL,
  `ans` tinytext NOT NULL,
  `options` text NOT NULL,
  `heading` tinytext NOT NULL,
  `exercise` tinytext NOT NULL,
  `type` tinyint NOT NULL DEFAULT '0',
  `difficulty` tinyint DEFAULT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `QuestionBank`
--

INSERT INTO `QuestionBank` (`id`, `question`, `ans`, `options`, `heading`, `exercise`, `type`, `difficulty`, `feedback`) VALUES
(1, 'this is a demo question', 'option1', 'option2 / option3 / option 4', 'This is a demo for testing', 'test', 1, 1, 'test feed back here'),
(2, 'this is a demo question 1', 'option2', 'option21 / option3 / option 4', 'This is a demo for testing 1', 'test', 1, 1, 'test feed back here 1'),
(3, 'this is a demo question 34', 'option15', 'option2 / option3 / option 44', 'This is a demo for testing123', 'test', 1, 0, 'test feed back here123'),
(4, 'this is a demo question 1123', 'option256', 'option21 / option3 / option 41', 'This is a demo for testing 112', 'test', 1, 0, 'test feed back here 112'),
(5, 'image1.png', 'test', 'option1/option2/option3', 'image heading this is', 'demo', 0, NULL, 'this s a dummy feed back'),
(6, 'dummy/fcfs.png', 'test1', 'option1/option2/option3/option5', 'this is another image question', 'test', 0, NULL, 'this s a dummy feed back'),
(7, '(Soplar) una brisa fresca.', 'soplaba', 'option1/option2/option3', 'Given a sentence, conjugate the verb in parenthesis to the indicative imperfect tense.', 'test1', 1, 2, 'Add the 3rd person singular ending for -ar verbs (-aba) to the regular stem of the verb \"soplar\" (sopl-) to get \"soplaba.\"'),
(8, 'Siempre (ella - soñar) con conseguir un trabajo nuevo.', 'soñaba', 'option1/option2/option3', 'Given a sentence, conjugate the verb in parenthesis to the indicative imperfect tense.', 'test1', 1, 2, 'Add the 3rd person singular ending for -ar verbs (-aba) to the regular stem of the verb \"soñar\" (soñ-) to get \"soñaba.\"'),
(9, 'Casi siempre, mi familia y yo (ver) la televisión por las noches.', 'veíamos', 'option1/option2/option3', 'Given a sentence, conjugate the verb in parenthesis to the indicative imperfect tense.', 'test1', 1, 0, 'The \"nosotros\" form of the irregular verb \"ver\" is \"veíamos\".'),
(10, 'El piso (estar) muy sucio.', 'estaba', 'option1/option2/option3', 'Given a sentence, conjugate the verb in parenthesis to the indicative imperfect tense.', 'test1', 1, 0, 'Add the 3rd person singular ending for -ar verbs (-aba) to the regular stem of the verb \"estar\" (est-) to get \"estaba.\"');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `QuestionBank`
--
ALTER TABLE `QuestionBank`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `QuestionBank`
--
ALTER TABLE `QuestionBank`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
