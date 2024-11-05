-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 05, 2024 at 10:11 AM
-- Server version: 8.0.39-0ubuntu0.20.04.1
-- PHP Version: 7.4.3-4ubuntu2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smw`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `AssignmentID` int NOT NULL,
  `SubjectID` int DEFAULT NULL,
  `Title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Description` text COLLATE utf8mb4_general_ci,
  `DueDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`AssignmentID`, `SubjectID`, `Title`, `Description`, `DueDate`) VALUES
(129, 25, 'naloga', '122', '2222-02-22 22:22:00'),
(130, 26, 'prva', '1', '2222-02-22 22:22:00'),
(138, 38, 'dadadsa', 'dadsad', '2222-02-22 22:22:00'),
(139, 38, 'adsasdadsadsa', 'asdasdas', '2222-02-22 22:22:00'),
(140, 38, 'asdsadsada', 'dasdasd', '2222-02-22 22:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `assignments_submissions`
--

CREATE TABLE `assignments_submissions` (
  `SubmissionID` int NOT NULL,
  `AssignmentID` int DEFAULT NULL,
  `UserID` int DEFAULT NULL,
  `SubmissionDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SubmissionContent` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments_submissions`
--

INSERT INTO `assignments_submissions` (`SubmissionID`, `AssignmentID`, `UserID`, `SubmissionDate`, `SubmissionContent`) VALUES
(50, 129, 2, '2024-11-02 19:26:33', 'ucenec ucenec - naloga - 129.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `student_assignments`
--

CREATE TABLE `student_assignments` (
  `UserID` int NOT NULL,
  `AssignmentID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_assignments`
--

INSERT INTO `student_assignments` (`UserID`, `AssignmentID`) VALUES
(2, 138),
(133, 138),
(2, 139),
(133, 139),
(2, 140),
(133, 140);

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `UserID` int NOT NULL,
  `SubjectID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_subjects`
--

INSERT INTO `student_subjects` (`UserID`, `SubjectID`) VALUES
(12, 29),
(133, 37),
(2, 38),
(133, 38);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `SubjectID` int NOT NULL,
  `SubjectName` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Description` text COLLATE utf8mb4_general_ci,
  `razredi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `geslo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`SubjectID`, `SubjectName`, `Description`, `razredi`, `geslo`) VALUES
(8, 'NRP1', 'objektno programiranje1', 'a:6:{i:0;s:0:\"\";i:1;s:3:\"R4B\";i:2;s:2:\"\r\n\";i:3;s:3:\"R4A\";i:4;s:2:\"\r\n\";i:5;s:3:\"R1B\";}', '0'),
(9, 'ROB', 'multimedija', 'a:6:{i:0;s:0:\"\";i:1;s:3:\"R4B\";i:2;s:2:\"\r\n\";i:3;s:3:\"R4A\";i:4;s:2:\"\r\n\";i:5;s:3:\"R1B\";}', '0'),
(25, 'testni predmet', '1', NULL, '1'),
(26, 'test', 'test', NULL, '1'),
(29, 'VVO', '12', NULL, '1'),
(31, 'Matematika', '1', NULL, '1'),
(32, 'Slovenščine', 'Slo', NULL, '1'),
(33, 'VVO', 'omrežje', NULL, '1'),
(34, 'RPR', 'slemi', NULL, '1'),
(35, 'Biologija', 'bio', NULL, '1'),
(36, 'NPP', 'db', NULL, '1'),
(37, 'Kemija', 'Kemija', NULL, '1'),
(38, 'Fizika', '1', NULL, '1'),
(39, 'Naravoslovje', 'naravoslovje', NULL, '1'),
(40, 'Osnove matematične analize', '\r\nmatematične funkcije', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `task_files`
--

CREATE TABLE `task_files` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `task_id` int DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_files`
--

INSERT INTO `task_files` (`id`, `file_name`, `task_id`, `type`) VALUES
('6729dd8f4d2c3.docx', '01_Od_nepostavljenega_racunalnika_do_spletne_aplikacije_2021-22.docx', 138, 'ucitelj'),
('6729ddc973f2d.docx', '01_Od_nepostavljenega_racunalnika_do_spletne_aplikacije_2021-22.docx', 139, 'ucitelj'),
('6729de2385990.docx', '01_Od_nepostavljenega_racunalnika_do_spletne_aplikacije_2021-22.docx', 140, 'ucitelj');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subjects`
--

CREATE TABLE `teacher_subjects` (
  `UserID` int NOT NULL,
  `SubjectID` int NOT NULL,
  `ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_subjects`
--

INSERT INTO `teacher_subjects` (`UserID`, `SubjectID`, `ID`) VALUES
(7, 26, 21),
(1, 29, 24),
(132, 31, 27),
(132, 32, 28),
(132, 33, 29),
(132, 34, 30),
(132, 35, 31),
(1, 36, 32),
(1, 37, 33),
(1, 38, 34),
(1, 39, 35),
(7, 40, 36),
(1, 40, 37),
(6, 40, 38);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int NOT NULL,
  `ime_uporabnika` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `priimek_uporbnika` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `UserType` enum('ucenec','ucitelj','admin') COLLATE utf8mb4_general_ci NOT NULL,
  `razred` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `ime_uporabnika`, `priimek_uporbnika`, `Username`, `password`, `Email`, `UserType`, `razred`) VALUES
(1, 'Nejc', 'Mlakar', 'nejcm', '$2y$10$30mzsWyw5FEjJGHOqsRiJupVXVCGG74aAB/OmvY9dRDMkSxgJTn3C', 'nejcmlakar11@gmail.com', 'ucitelj', NULL),
(2, 'ucenec11', 'ucenec', 'ucenec', '$2y$10$FT79aFJn2nSoC/JTkVo2y.TAPjUR/9KfxuozrKH2Rfm4q0hCVsoxS', 'test@gmail.com', 'ucenec', 'R4B'),
(3, 'Borut1', 'Selmi', 'SlemiKralj', '$2y$10$xvF34DnIzckqqS7yhhZU4eMetKnliofyif3UkRgkpjA2gK9CWjh/m', '1', 'ucenec', NULL),
(6, 'Bostjan', 'Fidler', 'Fidi', '1', 'mail', 'ucitelj', NULL),
(7, 'admin', 'admin', 'admin', '$2y$10$B4IcXq6YGlZQyFll2Rwnhee2qSHSQaQy3Csl2Z0ybWJ2ISHYOJ9au', 'admin@gmail.com', 'admin', NULL),
(10, 'anze', 'znidar', 'znajdar', '$2y$10$BFr7D/6Rml.OUGrlZwgQze4Kqnh/OjmsDgxClnaQlsf7WqQip/752', 'znidar@gmail.com', 'ucenec', NULL),
(11, 'ucitelj', 'ucitelj', 'ucitelj', '$2y$10$OJYyX9QtIBJ6d3vMS2thau/ZwkARldgB4cC7O8lG/L7lYBVHpb.C2', 'ucitelj@gmail.com', 'ucenec', NULL),
(12, 'Leon', 'Kotnik', 'KotaKing', '$2y$10$yO4ViK/NHxfJjxrG9RaDJewkI2OPXxhoeVJ9wU6v9y3AHPQ3s7jEG', 'lkotnik@gmail.com', 'ucenec', NULL),
(13, 'Laila', 'Daniel\n', 'LailaDaniel\n', '$2y$10$Ms3qWL8CrMI08SW./WyvG.BF11Jzb1BvpTaLTq5g3fL61L0SfeX.S', 'LailaDaniel\n@gmail.com', 'ucitelj', NULL),
(14, 'Grady', 'Calderon\n', 'GradyCalderon\n', '$2y$10$nNdDiMaND0c4PfW6m4Rjkuj4O5Lg9caXEkP6Sr6eVsL0Q6FpsDy9O', 'GradyCalderon\n@gmail.com', 'ucitelj', NULL),
(15, 'Serena', 'Armstrong\n', 'SerenaArmstrong\n', '$2y$10$p7peIzOjtVPPwg7Fu.1n7.qD.HPjAjZi01ZsD4D8Ew2MTAt8FBv0G', 'SerenaArmstrong\n@gmail.com', 'ucitelj', NULL),
(16, 'Grant', 'Jefferson\n', 'GrantJefferson\n', '$2y$10$OsGiH4Lo6NozofVW4aMaFO3SRbh5uugB60/GgOYhzzl0pRrPdKVn6', 'GrantJefferson\n@gmail.com', 'ucitelj', NULL),
(17, 'Julieta', 'Gillespie\n', 'JulietaGillespie\n', '$2y$10$0vpbgpN3pwixt83t5F40uu.Q0WPh8aEs5kP8ucrqosBbZhVaeSava', 'JulietaGillespie\n@gmail.com', 'ucitelj', NULL),
(18, 'Forest', 'Warner\n', 'ForestWarner\n', '$2y$10$7.BPgoDRw1yFSzIsw/kQc.oTYXtytv3uw1JFbuPxVhdT2yY8b9ZE.', 'ForestWarner\n@gmail.com', 'ucitelj', NULL),
(19, 'Wynter', 'Giles\n', 'WynterGiles\n', '$2y$10$WEXLidqhxGS6PzA/vvUE.uxNsyYRsnXzxsyTZ0YxYvOgDJzvwNd0y', 'WynterGiles\n@gmail.com', 'ucitelj', NULL),
(20, 'Kole', 'Bullock\n', 'KoleBullock\n', '$2y$10$36vklmcVyHndnd.B/itiEeAQ8EzePQgyR2QIdd0WoSLFuPR3c0Va6', 'KoleBullock\n@gmail.com', 'ucitelj', NULL),
(21, 'Winnie', 'Golden\n', 'WinnieGolden\n', '$2y$10$tiwVunffynZf6ZQi4l4D1.b4vt0JE6pSNPjOcbChTAo623zwcUmwC', 'WinnieGolden\n@gmail.com', 'ucitelj', NULL),
(22, 'Amias', 'Townsend\n', 'AmiasTownsend\n', '$2y$10$8RPxAYjO9N0mAKYDtOaSnO9Kb72I4RlUIrKwAqHlnLRFFl5Eo5MIq', 'AmiasTownsend\n@gmail.com', 'ucitelj', NULL),
(23, 'Azalea', 'Cannon\n', 'AzaleaCannon\n', '$2y$10$9wPrJL29GHWGAMl02oGAMuGGAzAskvBJre.EVQoPeC83SwSz3a7iS', 'AzaleaCannon\n@gmail.com', 'ucitelj', NULL),
(24, 'Archie', 'Alexander\n', 'ArchieAlexander\n', '$2y$10$JU2tkUb8HTj6pE5GKifW1.VSO70g6TbYI6kLIza1rw8DjGXPjM8yq', 'ArchieAlexander\n@gmail.com', 'ucitelj', NULL),
(25, 'Lyla', 'Thomas\n', 'LylaThomas\n', '$2y$10$uYRuJS39FmQekmRVUsIyV.v0hSiHo45kTzDC8Kuff69oFKe2JyGZ.', 'LylaThomas\n@gmail.com', 'ucitelj', NULL),
(26, 'Logan', 'Aguirre\n', 'LoganAguirre\n', '$2y$10$wz4ehLSwKoQCB49wb7PgaeosAjwKJXcL25ABCNbsuCJCOdOJ62dvG', 'LoganAguirre\n@gmail.com', 'ucitelj', NULL),
(27, 'Ariah', 'Michael\n', 'AriahMichael\n', '$2y$10$ZF4X8OBYJGa8SO0tfCYEhudCREb8egl3fY7HB8O/P0rN1Qck/DRsK', 'AriahMichael\n@gmail.com', 'ucitelj', NULL),
(28, 'Bronson', 'Wall\n', 'BronsonWall\n', '$2y$10$DwwVi5PhwWIkqb8THSS2DOCgT28dqevUml9MGNbfgucz04B7Umgiy', 'BronsonWall\n@gmail.com', 'ucitelj', NULL),
(29, 'Jayda', 'Villarreal\n', 'JaydaVillarreal\n', '$2y$10$pvTQ56ASxaolEXV20T4AmeZXmQPb5ZOqz7V/bJWg58dBDJkHg.nDe', 'JaydaVillarreal\n@gmail.com', 'ucitelj', NULL),
(30, 'Nikolai', 'Page\n', 'NikolaiPage\n', '$2y$10$jnlfAlmQQpuAIyWDZMNrKOrK.X37zMdg6.XZpBgUy.CFb7aYvQcCS', 'NikolaiPage\n@gmail.com', 'ucitelj', NULL),
(31, 'Cataleya', 'Crosby\n', 'CataleyaCrosby\n', '$2y$10$WB0BsIkNMSP5vt8USvuhkeMSHvTQs5ZsZhgcqlA3Mw6AUxqo5Fuja', 'CataleyaCrosby\n@gmail.com', 'ucitelj', NULL),
(32, 'Tristen', 'O’Donnell\n', 'TristenO’Donnell\n', '$2y$10$AMQ/tQtTVpREralGIIBJH.r2pjz7wIGcqlevWnpz9WnlcEo1Yg6n2', 'TristenO’Donnell\n@gmail.com', 'ucitelj', NULL),
(33, 'Bellamy', 'Shah\n', 'BellamyShah\n', '$2y$10$6YWyPDeF8x0SgPLFHSuoNeOjsadKZzYDx6nPTze11PFIVRPUN6332', 'BellamyShah\n@gmail.com', 'ucitelj', NULL),
(34, 'Zain', 'Zimmerman\n', 'ZainZimmerman\n', '$2y$10$U66cRngiokJxxNYC1ORhhOa1M/.qWx1g43/ZSPrKH6zEVon7ch6Qy', 'ZainZimmerman\n@gmail.com', 'ucitelj', NULL),
(35, 'Ariyah', 'Person\n', 'AriyahPerson\n', '$2y$10$N8B4uVVjqSUh7rLc8rXz7e/5QkxmFa9xn1W4oZxrzML3257.Wkt3O', 'AriyahPerson\n@gmail.com', 'ucitelj', NULL),
(36, 'Moses', 'Horn\n', 'MosesHorn\n', '$2y$10$M.IkpupPsDCdYxTk3ZN5BOLmlHLPo6hL3.nIcCkvexOI16v8XpcOW', 'MosesHorn\n@gmail.com', 'ucitelj', NULL),
(37, 'Avah', 'Gill\n', 'AvahGill\n', '$2y$10$9mU.lWrL.Nlu6wXLEonyYeGGF3ZNXEAxzivd8nmxgf3zdMyQEdfFy', 'AvahGill\n@gmail.com', 'ucitelj', NULL),
(38, 'Matthias', 'Nolan\n', 'MatthiasNolan\n', '$2y$10$63kHPS7IQjjOHN8gKtEvI.4HTFn33gZvRdWTfkm/30u9MBTRoVePG', 'MatthiasNolan\n@gmail.com', 'ucitelj', NULL),
(39, 'Itzayana', 'Foley\n', 'ItzayanaFoley\n', '$2y$10$zJGruz8q5JG6AMCtzuaqlOzaObz1/BjhfC4FRINKBOO0kd8wyNmnu', 'ItzayanaFoley\n@gmail.com', 'ucitelj', NULL),
(40, 'Mohammad', 'Galvan\n', 'MohammadGalvan\n', '$2y$10$8lpAen5n8bfP0XvWd6.ix.M/qzM0O92O1.ue64Yel7Puhm5ulHnnm', 'MohammadGalvan\n@gmail.com', 'ucitelj', NULL),
(41, 'Dallas', 'Yoder\n', 'DallasYoder\n', '$2y$10$/J5ofjhe7kx1N4yvnwzD1egifPr5RpM89mirhMKnlIE4Fyzt6Z0oC', 'DallasYoder\n@gmail.com', 'ucitelj', NULL),
(42, 'Johan', 'Serrano\n', 'JohanSerrano\n', '$2y$10$j3WKL6dQakNsItbMxwr/WOpffHPBQV0z/yFnfNSYqcVP7TX44JtVW', 'JohanSerrano\n@gmail.com', 'ucitelj', NULL),
(43, 'Allie', 'Robles\n', 'AllieRobles\n', '$2y$10$k0uutHLZU2MFZhlChuxdmeP4oyrPTvaU0cg4Z9zm1km.ZYFJpKPCO', 'AllieRobles\n@gmail.com', 'ucitelj', NULL),
(44, 'Otto', 'Griffith\n', 'OttoGriffith\n', '$2y$10$lpIIRBeUo7VljG/naZOeFu1ScJykC.N/gmsmvSYbSu.qq3cSpwGxW', 'OttoGriffith\n@gmail.com', 'ucitelj', NULL),
(45, 'Alicia', 'Allison\n', 'AliciaAllison\n', '$2y$10$xC3zDuWpVDe1DUR.o8ecxOoHeLGBPeEBBxsclRUzZ7VFEgL0N94am', 'AliciaAllison\n@gmail.com', 'ucitelj', NULL),
(46, 'Dennis', 'Norman\n', 'DennisNorman\n', '$2y$10$7Gx8MIiHaO352GkBSN4xAuvw7hvGRLRmNUdH05Gz/C0/nIGJ9sogK', 'DennisNorman\n@gmail.com', 'ucitelj', NULL),
(47, 'Malani', 'Hicks\n', 'MalaniHicks\n', '$2y$10$.4/yECnI9L61Li7m425w5.vokkyblROEHB6BNE4KOm8mzW8IlZEhq', 'MalaniHicks\n@gmail.com', 'ucitelj', NULL),
(48, 'Maddox', 'Nava\n', 'MaddoxNava\n', '$2y$10$I.5qqg9NHTTPVrTU4jILbe6Xn2L.aSQawqIOTgSB5fdz5RwWq.w6K', 'MaddoxNava\n@gmail.com', 'ucitelj', NULL),
(49, 'Scout', 'Velasquez\n', 'ScoutVelasquez\n', '$2y$10$wWqqUkHi/bs91Jw.y2Okp.NacvHnr.XCbTOBQdacG8RVlDVQHwA5a', 'ScoutVelasquez\n@gmail.com', 'ucitelj', NULL),
(50, 'Sullivan', 'Hawkins\n', 'SullivanHawkins\n', '$2y$10$nUM28JVigliypANa34z6/uw.8WH2swD9do1oEEt83kmLL8LeKkI0.', 'SullivanHawkins\n@gmail.com', 'ucitelj', NULL),
(51, 'Ariel', 'Cook\n', 'ArielCook\n', '$2y$10$JEWVBDTtZh3XHb4d29fFHOgTST5MDUJeWUoAW9RJlUxdITrokO59e', 'ArielCook\n@gmail.com', 'ucitelj', NULL),
(52, 'Ezekiel', 'Coffey\n', 'EzekielCoffey\n', '$2y$10$j.peVNdM1.bRI/IRgOV8Keb5pMZyOdmswPRWHDHkAFxqY.ksnUeR6', 'EzekielCoffey\n@gmail.com', 'ucitelj', NULL),
(53, 'Paola', 'Owen\n', 'PaolaOwen\n', '$2y$10$A3rsPtdMUji5s3jHZtW9SOsPEU1jVTspKGHVgc9Y2JfPvhIzLKes6', 'PaolaOwen\n@gmail.com', 'ucitelj', NULL),
(54, 'Cannon', 'Porter\n', 'CannonPorter\n', '$2y$10$Pv6Ecfeam.hHNmEUhc0PkOvw2sK0J6uBdzJrkZyumfcP447i6ROXe', 'CannonPorter\n@gmail.com', 'ucitelj', NULL),
(55, 'Ryleigh', 'Truong\n', 'RyleighTruong\n', '$2y$10$J9.P2ZrDqmF7G56KBK1.5u5nZMSJDy4QnoaLfxUs70Bn6fK0yCfIG', 'RyleighTruong\n@gmail.com', 'ucitelj', NULL),
(56, 'Ayan', 'Woodward\n', 'AyanWoodward\n', '$2y$10$xZgl901df/8Mgo87yE.7g.TZIyBJJXI/UpF9FRM4ZNcc.TnH0ZVQW', 'AyanWoodward\n@gmail.com', 'ucitelj', NULL),
(57, 'Drew', 'Pearson\n', 'DrewPearson\n', '$2y$10$rrj2vXXUVF0fUXc8lLfvDOhiyYPHOafI0HcwIk28PDorwZyshYS9q', 'DrewPearson\n@gmail.com', 'ucitelj', NULL),
(58, 'Gunner', 'Parks\n', 'GunnerParks\n', '$2y$10$6xP4Xe8NkuG33eKtDMwAy.Hn2SJ6S1zoWZrkwBI6BVCUoRXyh9G1K', 'GunnerParks\n@gmail.com', 'ucitelj', NULL),
(59, 'Ainsley', 'Ochoa\n', 'AinsleyOchoa\n', '$2y$10$N0zco6RYkscGfdBCXb6V7ebb.HkkHIIIKadsXBMUDX5I3WzVIVyyG', 'AinsleyOchoa\n@gmail.com', 'ucitelj', NULL),
(60, 'Winston', 'Hunt\n', 'WinstonHunt\n', '$2y$10$ORj40WHgtdXbqwuAhDmbaOrOWMTWWkh9Y5uET.2ickjUHikbtLU/K', 'WinstonHunt\n@gmail.com', 'ucitelj', NULL),
(61, 'Genevieve', 'Quintero\n', 'GenevieveQuintero\n', '$2y$10$5eyLFBBzfRwkhDeGCLX55.1NeYstRHU3hyzPbtO4uha6cu7jJw8uS', 'GenevieveQuintero\n@gmail.com', 'ucitelj', NULL),
(62, 'Thatcher', 'Zhang\n', 'ThatcherZhang\n', '$2y$10$yvu1HkbPRMTyzFjFVdorbuhHKIhGeGWFwM2bYMwccJzCXkbRm6CCK', 'ThatcherZhang\n@gmail.com', 'ucitelj', NULL),
(63, 'Sarai', 'Ray\n', 'SaraiRay\n', '$2y$10$7hUXK6rxl/f05/cknH6KUejwEhWBRYiH59f279LsV9CvQ1dIAoImq', 'SaraiRay\n@gmail.com', 'ucitelj', NULL),
(64, 'Arlo', 'Kelley\n', 'ArloKelley\n', '$2y$10$JsKEK3RsxiqTA0vsfSJlhO/OM6thcEjBsRJ1J7ZMO8c9Rjsn/B3AS', 'ArloKelley\n@gmail.com', 'ucitelj', NULL),
(65, 'Rosalie', 'Garcia\n', 'RosalieGarcia\n', '$2y$10$d9p1FvLJg/FDK8EyVqlJp..Az3YrpK0bUhNAYV5RMRDoYHWbIrACS', 'RosalieGarcia\n@gmail.com', 'ucitelj', NULL),
(66, 'James', 'Pennington\n', 'JamesPennington\n', '$2y$10$OpRNSnVx6O0sMXUYg/KTGutj3A5lZRlcx734AqjwJ8VD5IGUeepV2', 'JamesPennington\n@gmail.com', 'ucitelj', NULL),
(67, 'Yareli', 'Baker\n', 'YareliBaker\n', '$2y$10$upRlzbp3buhr1YzIGD9Z0.MlDUn9ntDOYjFcV/WDUrBkkNXREyp9m', 'YareliBaker\n@gmail.com', 'ucitelj', NULL),
(68, 'Ezra', 'Mullins\n', 'EzraMullins\n', '$2y$10$pMZenMbPWQ99lScTqmVpZOz2KyySfgz77D6NF5tKvr3S5dT2rgD4.', 'EzraMullins\n@gmail.com', 'ucitelj', NULL),
(69, 'Maliyah', 'Harmon\n', 'MaliyahHarmon\n', '$2y$10$LLdogzK0h5qDJhRRHxETeODPuZ7VGu/p2GcfNEK4eYE5PS/mAlEDu', 'MaliyahHarmon\n@gmail.com', 'ucitelj', NULL),
(70, 'Roberto', 'Faulkner\n', 'RobertoFaulkner\n', '$2y$10$pP8pHIAnlYBuKzMfNPeQD.arCIbmYq8jkgHxKDYUF1yqhSbneyBYi', 'RobertoFaulkner\n@gmail.com', 'ucitelj', NULL),
(71, 'Ansley', 'Singleton\n', 'AnsleySingleton\n', '$2y$10$EdFsJ7sgRl0umOLZdadJKeQFUX25xS7qx6gFI7HXYiWf.hxcA.Dw.', 'AnsleySingleton\n@gmail.com', 'ucitelj', NULL),
(72, 'Landyn', 'Norris\n', 'LandynNorris\n', '$2y$10$O8WHohSgyeGbb/5k48.mEuhlZRsre1kgOV4hhQW3.hOqSsmaMF8IS', 'LandynNorris\n@gmail.com', 'ucitelj', NULL),
(73, 'Arielle', 'Berry\n', 'ArielleBerry\n', '$2y$10$wgYPJiG8X3iLZHfTUCN62ezlmbGZQ6GGUQEMOxu7n0cjg.7SoDaVS', 'ArielleBerry\n@gmail.com', 'ucitelj', NULL),
(74, 'Adonis', 'Stevens\n', 'AdonisStevens\n', '$2y$10$xm1AXZg/dZscp9pE.GBzqeKSSjlCjdmWQrliGOgi8g4R8O4vCuu0W', 'AdonisStevens\n@gmail.com', 'ucitelj', NULL),
(75, 'Katherine', 'Boyer\n', 'KatherineBoyer\n', '$2y$10$kK6DLJyMEFgaDTEyF3de/uwZBqBpVdES0ctDLdHgLeUSzXr7gkXoK', 'KatherineBoyer\n@gmail.com', 'ucitelj', NULL),
(76, 'Zeke', 'Byrd\n', 'ZekeByrd\n', '$2y$10$nySbfoxYB6kbTDfIzGEMCubP0AgxJRU5aOvi9.as1MaH2J6gWV/sq', 'ZekeByrd\n@gmail.com', 'ucitelj', NULL),
(77, 'Giselle', 'Sweeney\n', 'GiselleSweeney\n', '$2y$10$lK6sLD/mnM11ufqU6XbHn.94mGyzY3NsBcRqooV7KMTVqab5fV7ey', 'GiselleSweeney\n@gmail.com', 'ucitelj', NULL),
(78, 'Nixon', 'Daniel\n', 'NixonDaniel\n', '$2y$10$Bvphqw3X6FIQKWQ3aJlMSud/gaSIfeXqowzviw/8aPyjulm/IvUaG', 'NixonDaniel\n@gmail.com', 'ucitelj', NULL),
(79, 'Joy', 'Boyle\n', 'JoyBoyle\n', '$2y$10$UUp5SMAwtAKD7cDoHN818um2NJMBKDgX9ngHhEqSAu6XB4rbUVqD6', 'JoyBoyle\n@gmail.com', 'ucitelj', NULL),
(80, 'Robin', 'Montgomery\n', 'RobinMontgomery\n', '$2y$10$iWHKTs36H/pV8MbJe3jW5uS4s3TlXlNDRK2ehSSYWgcItO4FeddV.', 'RobinMontgomery\n@gmail.com', 'ucitelj', NULL),
(81, 'Evangeline', 'McCarty\n', 'EvangelineMcCarty\n', '$2y$10$jKQFlP1lFya94VWHgcABqerTklgzGfqbY6LSEiwhZbVBf7FVPKg0a', 'EvangelineMcCarty\n@gmail.com', 'ucitelj', NULL),
(82, 'Blaise', 'McKinney\n', 'BlaiseMcKinney\n', '$2y$10$iNGCe8o12Al2lIGcLmDuYes.Wxl3BY1vEJClDaELqV7EDfZXiHtu.', 'BlaiseMcKinney\n@gmail.com', 'ucitelj', NULL),
(83, 'Gwendolyn', 'Golden\n', 'GwendolynGolden\n', '$2y$10$hm66q4h7fqLPt11O2h2iu./yYst0OWHRL6Pn12G3QTXCFq3Sihvha', 'GwendolynGolden\n@gmail.com', 'ucitelj', NULL),
(84, 'Amias', 'McGuire\n', 'AmiasMcGuire\n', '$2y$10$f9eSNGgOB4mceeIHBzHdDukF6txshPz7ughupkbRgdY68mFeFmWue', 'AmiasMcGuire\n@gmail.com', 'ucitelj', NULL),
(85, 'April', 'Olsen\n', 'AprilOlsen\n', '$2y$10$AQkzrXcJ/3nysUVLieSTN.r3VP/31faBMddWDEWNB7tYa8eiwjI2K', 'AprilOlsen\n@gmail.com', 'ucitelj', NULL),
(86, 'Skyler', 'Potts\n', 'SkylerPotts\n', '$2y$10$q7jRlVl5eNYlWAOme/PaOeIn6W759o52w3C6Z0D0MoizxNqV6Tmni', 'SkylerPotts\n@gmail.com', 'ucitelj', NULL),
(87, 'Ellison', 'Keith\n', 'EllisonKeith\n', '$2y$10$g4Arm6XslWQ6lFyLQTJt8.yEI1SW3VfU3Mcye93jD6gwK8qFKoCFC', 'EllisonKeith\n@gmail.com', 'ucitelj', NULL),
(88, 'Jagger', 'Owen\n', 'JaggerOwen\n', '$2y$10$9XAPWsBlGZ0KuJCikNq.U.j1cu7HHhSZlou9a/987EfJX51RNBi/2', 'JaggerOwen\n@gmail.com', 'ucitelj', NULL),
(89, 'Mikayla', 'Cannon\n', 'MikaylaCannon\n', '$2y$10$iGf0stHkbpX7yg19vTQMO.M1kb.diIBsVjH2iyp6TC6MwcRNr2Ta2', 'MikaylaCannon\n@gmail.com', 'ucitelj', NULL),
(90, 'Archie', 'Underwood\n', 'ArchieUnderwood\n', '$2y$10$/032sUEF358w2aWUY9zqC.3lyvSrGJKZQWXMFkhpn9g26A8UClV.W', 'ArchieUnderwood\n@gmail.com', 'ucitelj', NULL),
(91, 'Ensley', 'Hardin\n', 'EnsleyHardin\n', '$2y$10$CQjoBHuqd3imjO/l3La8WuernJcYDuCuW1tZX4ux60.EHr4WRNL9e', 'EnsleyHardin\n@gmail.com', 'ucitelj', NULL),
(92, 'Hassan', 'Murphy\n', 'HassanMurphy\n', '$2y$10$KXdFX1Oea1NINXPckNip9OKuIzDsp.zBOueoggn0xU4PnJL/jAP3m', 'HassanMurphy\n@gmail.com', 'ucitelj', NULL),
(93, 'Bella', 'Romero\n', 'BellaRomero\n', '$2y$10$Kk/9has1YJ80ObfiEGm/bOw0WmTgNSF7LzaW0wft2mduPYCEzdjd6', 'BellaRomero\n@gmail.com', 'ucitelj', NULL),
(94, 'Bryson', 'Stanton\n', 'BrysonStanton\n', '$2y$10$1PbiHZr1IXdMG6s6QAZuOe/JYKLqkn.AAi3sQ7c.HRh5XiQli50my', 'BrysonStanton\n@gmail.com', 'ucitelj', NULL),
(95, 'Jaycee', 'Carrillo\n', 'JayceeCarrillo\n', '$2y$10$CRMcHMW1L9v/v9qN.VydHOOEWOSz3rmB8F3xmW88Ye3ct8PbMxVxu', 'JayceeCarrillo\n@gmail.com', 'ucitelj', NULL),
(96, 'Wade', 'Fields\n', 'WadeFields\n', '$2y$10$.oiQnq2e9PWo1sM3nS7dpOxmirzibQzgh1dcYvsGfyoSbzOrNHo3W', 'WadeFields\n@gmail.com', 'ucitelj', NULL),
(97, 'Annie', 'Armstrong\n', 'AnnieArmstrong\n', '$2y$10$vvW4iadZliORuKfa8J5Q4ubYw8hdelXmjsn02OX5TtL7lxxr2qfU.', 'AnnieArmstrong\n@gmail.com', 'ucitelj', NULL),
(98, 'Grant', 'Prince\n', 'GrantPrince\n', '$2y$10$ggeUmjns6se4XNqVEd9zp.D6z3iMVByA.s2PyGy40HP5RdP6oDtZG', 'GrantPrince\n@gmail.com', 'ucitelj', NULL),
(99, 'Greta', 'Reid\n', 'GretaReid\n', '$2y$10$ooST44Is6fGzwbX6Dq6UFucrWkyTxr/tLbQJUQNPk3VBnAE2jiXTC', 'GretaReid\n@gmail.com', 'ucitelj', NULL),
(100, 'Josue', 'English\n', 'JosueEnglish\n', '$2y$10$78tneLISYj7ms7954wWWxOeNuaaSYTZKKjKatpmFzSl8eXu.RNcde', 'JosueEnglish\n@gmail.com', 'ucitelj', NULL),
(101, 'Kelly', 'Duffy\n', 'KellyDuffy\n', '$2y$10$utQIirJfzimGFRxwBGFyK.jiSdJag4zRlvWgdDDMDg2E8xSBRAZHu', 'KellyDuffy\n@gmail.com', 'ucitelj', NULL),
(102, 'Kyng', 'Crane\n', 'KyngCrane\n', '$2y$10$3kinOE73sCoQvijAqp3OouSFQocZAWQe/lrapBqmrOxY6sCDtX77y', 'KyngCrane\n@gmail.com', 'ucitelj', NULL),
(103, 'Della', 'Douglas\n', 'DellaDouglas\n', '$2y$10$Y.2EWU.EFCRjk.BWWLGXJO/2BRFqd9/z9XMBAvY6JK7peLbF8xAj.', 'DellaDouglas\n@gmail.com', 'ucitelj', NULL),
(104, 'Derek', 'Vega\n', 'DerekVega\n', '$2y$10$MMt0oEc1QqRpj4mo1kD5Zel70ZfzLQ2gkiJ/teFEBNKrXYGBKM1oC', 'DerekVega\n@gmail.com', 'ucitelj', NULL),
(105, 'Dakota', 'Wiley\n', 'DakotaWiley\n', '$2y$10$rIifhI9pFIdiGOdtrR1VdujYmIWEbBjPBPB9radwD1mUywKq8mtQy', 'DakotaWiley\n@gmail.com', 'ucitelj', NULL),
(106, 'Mathew', 'Hunter\n', 'MathewHunter\n', '$2y$10$8FRoT/bwJadu62umKJyMvOqrcqrE9PpLl6M9Gty3ykF4gwWnq/SBy', 'MathewHunter\n@gmail.com', 'ucitelj', NULL),
(107, 'Khloe', 'Sierra\n', 'KhloeSierra\n', '$2y$10$iBDYcxdaBPGe2FuIAJF0buWyJ19Oupq4PEbze3wMwLGV4MwvkAbJW', 'KhloeSierra\n@gmail.com', 'ucitelj', NULL),
(108, 'Dayton', 'Velez\n', 'DaytonVelez\n', '$2y$10$WQbWuxQ8ruOUEjNkTnuFb.5AJv9ag6ZMP/9bsIUjCUSI6yLfdT36O', 'DaytonVelez\n@gmail.com', 'ucitelj', NULL),
(109, 'Megan', 'Greene\n', 'MeganGreene\n', '$2y$10$UXsPU7HHa8YKHDV5qgX65elpEP6xR/JZ3jVXbcl0kEBQs2QIBsF3a', 'MeganGreene\n@gmail.com', 'ucitelj', NULL),
(110, 'Griffin', 'Novak\n', 'GriffinNovak\n', '$2y$10$PQZlaccoJW1Kwr9/7ASuKOptJsPRkMbEyCu5Q/7VjYWegcWjVTGjm', 'GriffinNovak\n@gmail.com', 'ucitelj', NULL),
(111, 'Kaiya', 'Richards\n', 'KaiyaRichards\n', '$2y$10$HpEuZOVMUvHpQDFvBsTLMO.cAp5INnHJsddRYU6nYDysb9as1da8G', 'KaiyaRichards\n@gmail.com', 'ucitelj', NULL),
(112, 'Holden', 'Burke', 'HoldenBurke', '$2y$10$Io1PC.amwPnzv5gbbr7Kc.Jue8OtVmdMz7MDZfbz.Ko8qDYIuP0O6', 'HoldenBurke@gmail.com', 'ucitelj', NULL),
(113, 'Hattie', 'Spencer\n', 'HattieSpencer\n', '$2y$10$jY2CqhgYfTqLkmgZBi.GbuAREsLX537uZ8wdRwmprtghKI64dfDNK', 'HattieSpencer\n@gmail.com', 'ucitelj', NULL),
(114, 'Ace', 'Sherman\n', 'AceSherman\n', '$2y$10$fPO2UJygveKJnt5lD3KQfu/1ns8Y/Ur116IfTg4SER3ikqLGy0E9m', 'AceSherman\n@gmail.com', 'ucitelj', NULL),
(115, 'Addilyn', 'Callahan\n', 'AddilynCallahan\n', '$2y$10$uvIdy8bTPqVXXmH335quQOtT115gM8AEcJCkFXFob4CvLrDXcLO4C', 'AddilynCallahan\n@gmail.com', 'ucitelj', NULL),
(116, 'Quinton', 'Franco\n', 'QuintonFranco\n', '$2y$10$7.RYQy3X/U.e.ftxSpue6.MGRQBc0Ok4cy66BpY0wqI/POP9QAMcS', 'QuintonFranco\n@gmail.com', 'ucitelj', NULL),
(117, 'Charleigh', 'Pace\n', 'CharleighPace\n', '$2y$10$cYa3d0yPLKdNhpMVX1Q.MeWO4vTmU4k5Tgb8vGVhfMSOXJLCQIGGC', 'CharleighPace\n@gmail.com', 'ucitelj', NULL),
(118, 'Dior', 'Parsons\n', 'DiorParsons\n', '$2y$10$gKzr0mCbG.MPLoFs7gckIehxEpFoMcbUPlPV5E1XMsF88aof5XkRS', 'DiorParsons\n@gmail.com', 'ucitelj', NULL),
(119, 'Maia', 'Welch\n', 'MaiaWelch\n', '$2y$10$VZCtunYbX0O50p9uxaq5C.jDNqPX7m.tpMfUGTuf1CC1db75d.VCy', 'MaiaWelch\n@gmail.com', 'ucitelj', NULL),
(120, 'Hendrix', 'Reilly\n', 'HendrixReilly\n', '$2y$10$Pgw8snosXf97PTuWKnkLa.6FYZlWmyjzf40.xU.JtltegfyqopNwG', 'HendrixReilly\n@gmail.com', 'ucitelj', NULL),
(121, 'Tori', 'Nava\n', 'ToriNava\n', '$2y$10$FhhJ/4voG3qZn0MdRjP5cumwdQrGTGiW5ItFR3xp5KQRZu9men4gS', 'ToriNava\n@gmail.com', 'ucitelj', NULL),
(122, 'Stefan', 'Wade\n', 'StefanWade\n', '$2y$10$l7H8V.3zebovK4WcUVSjB.hwm3MEeMoRHjW8eLQWxaH4tsm3SWmxm', 'StefanWade\n@gmail.com', 'ucitelj', NULL),
(123, 'Evie', 'Pena\n', 'EviePena\n', '$2y$10$/55Bhi7ORJjqwdtFR.7S2.zY54j501bwnTnQOljj5Lc.deldksxVi', 'EviePena\n@gmail.com', 'ucitelj', NULL),
(124, 'Marcus', 'Baxter\n', 'MarcusBaxter\n', '$2y$10$5nCTx3LmYz.a/.I8wqHJe.WZ0KoALnQ2gc0C4OXvFVbgIbJa27trK', 'MarcusBaxter\n@gmail.com', 'ucitelj', NULL),
(125, 'Lara', 'Cole\n', 'LaraCole\n', '$2y$10$nJiOteIQLnugYF5JyrHCtuEZ6l.5ZD4JRlajrW2LcAANdplWbNez6', 'LaraCole\n@gmail.com', 'ucitelj', NULL),
(126, 'Nathaniel', 'Marquez\n', 'NathanielMarquez\n', '$2y$10$vsIeheNC0qG9w1/Ken/KSOyq.Y6axGDBuJJep.reCQAHewUypED6i', 'NathanielMarquez\n@gmail.com', 'ucitelj', NULL),
(127, 'Milani', 'Le\n', 'MilaniLe\n', '$2y$10$uVpCS/QgA3YpPY0j2dzBLe24/ms64tn3YvQFYKTH1LM82IQEgUGOW', 'MilaniLe\n@gmail.com', 'ucitelj', NULL),
(128, 'Damien', 'Livingston\n', 'DamienLivingston\n', '$2y$10$QznDA7YnJd41jpnOI/AihOAdFK6YfnlwFj7FLy8p8RzfH1amVLhIO', 'DamienLivingston\n@gmail.com', 'ucitelj', NULL),
(129, 'Milena', 'Donaldson\n', 'MilenaDonaldson\n', '$2y$10$DHjAmjFKZ59f1QAGC3eBLegA9Qz9Np0E6zuodtfDbHyX4ruF3KEP.', 'MilenaDonaldson\n@gmail.com', 'ucitelj', NULL),
(130, 'Canaan', 'Carter\n', 'CanaanCarter\n', '$2y$10$zzTcP0/nhK886xZqhtlXIOaeGf2qX6RUWTdzbuUkANj8ojiHuqASO', 'CanaanCarter\n@gmail.com', 'ucitelj', NULL),
(131, 'Lucy', 'Mann\n', 'LucyMann\n', '$2y$10$1EGjpMHtAFr6fiJKAQhReOILqIlBMfLQ.RImor3quZMDfwHZ1KoRG', 'LucyMann\n@gmail.com', 'ucitelj', NULL),
(132, 'Nehemiah', 'Franklin', 'Frank', '$2y$10$VyMpKw/gUWisSShd.GUqVeP31sGjsIZZErFqajEStHJ8MEU.ZYIC2', 'NehemiahFranklin@gmail.com', 'ucitelj', NULL),
(133, 'Skibiddy', 'Toilette', 'Toiletman', '$2y$10$ByB.UdPhyLTAif7noDuPueG3kDIcmFMR2L1YuVrtmV/rh/XqVp6hu', 'skibidi@gmail.com', 'ucenec', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`AssignmentID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indexes for table `assignments_submissions`
--
ALTER TABLE `assignments_submissions`
  ADD PRIMARY KEY (`SubmissionID`),
  ADD KEY `AssignmentID` (`AssignmentID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `student_assignments`
--
ALTER TABLE `student_assignments`
  ADD PRIMARY KEY (`UserID`,`AssignmentID`),
  ADD KEY `AssignmentID` (`AssignmentID`);

--
-- Indexes for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`UserID`,`SubjectID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SubjectID`);

--
-- Indexes for table `task_files`
--
ALTER TABLE `task_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `AssignmentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `assignments_submissions`
--
ALTER TABLE `assignments_submissions`
  MODIFY `SubmissionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SubjectID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`);

--
-- Constraints for table `assignments_submissions`
--
ALTER TABLE `assignments_submissions`
  ADD CONSTRAINT `assignments_submissions_ibfk_1` FOREIGN KEY (`AssignmentID`) REFERENCES `assignments` (`AssignmentID`),
  ADD CONSTRAINT `assignments_submissions_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `student_assignments`
--
ALTER TABLE `student_assignments`
  ADD CONSTRAINT `student_assignments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_assignments_ibfk_2` FOREIGN KEY (`AssignmentID`) REFERENCES `assignments` (`AssignmentID`) ON DELETE CASCADE;

--
-- Constraints for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD CONSTRAINT `student_subjects_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `student_subjects_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`);

--
-- Constraints for table `task_files`
--
ALTER TABLE `task_files`
  ADD CONSTRAINT `task_files_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `assignments` (`AssignmentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
