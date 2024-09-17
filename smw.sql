-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 17. sep 2024 ob 10.05
-- Različica strežnika: 10.4.32-MariaDB
-- Različica PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `smw`
--

-- --------------------------------------------------------

--
-- Struktura tabele `assignments`
--

CREATE TABLE `assignments` (
  `AssignmentID` int(11) NOT NULL,
  `SubjectID` int(11) DEFAULT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `assignments`
--

INSERT INTO `assignments` (`AssignmentID`, `SubjectID`, `Title`, `Description`, `DueDate`, `CreatedAt`) VALUES
(1, 1, 'Algebra Homework', 'Solve 20 algebra problems', '2024-09-20', '2024-09-17 07:21:59'),
(2, 2, 'Physics Lab Report', 'Write a report on the optics experiment', '2024-09-22', '2024-09-17 07:21:59'),
(3, 3, 'Chemical Reactions Essay', 'Describe types of chemical reactions', '2024-09-25', '2024-09-17 07:21:59'),
(4, 4, 'Biology Field Trip Report', 'Document findings from the field trip', '2024-09-27', '2024-09-17 07:21:59'),
(5, 5, 'World War II Research', 'Research on key events of WWII', '2024-09-30', '2024-09-17 07:21:59'),
(6, 6, 'Map Study', 'Analyze world political maps', '2024-10-01', '2024-09-17 07:21:59'),
(7, 7, 'Essay on Shakespeare', 'Write an essay on Shakespeare’s Hamlet', '2024-10-03', '2024-09-17 07:21:59'),
(8, 8, 'Art Portfolio', 'Submit a portfolio of 5 artworks', '2024-10-05', '2024-09-17 07:21:59'),
(9, 9, 'Music Composition', 'Create a short musical composition', '2024-10-07', '2024-09-17 07:21:59'),
(10, 10, 'Philosophical Debate', 'Prepare a debate on ethics', '2024-10-10', '2024-09-17 07:21:59'),
(11, 11, 'Social Behavior Survey', 'Conduct a survey on social behavior', '2024-10-12', '2024-09-17 07:21:59'),
(12, 12, 'Psychological Analysis', 'Analyze a case study in psychology', '2024-10-14', '2024-09-17 07:21:59'),
(13, 13, 'Economics Essay', 'Write an essay on market structures', '2024-10-16', '2024-09-17 07:21:59'),
(14, 14, 'Political Systems', 'Compare political systems of two countries', '2024-10-18', '2024-09-17 07:21:59'),
(15, 15, 'Algorithm Design', 'Design an algorithm for sorting data', '2024-10-20', '2024-09-17 07:21:59'),
(16, 16, 'Bridge Design', 'Design a bridge using CAD software', '2024-10-22', '2024-09-17 07:21:59'),
(17, 17, 'Medical Case Study', 'Analyze a medical case study', '2024-10-25', '2024-09-17 07:21:59'),
(18, 18, 'Legal Research Paper', 'Write a paper on a legal case', '2024-10-27', '2024-09-17 07:21:59'),
(19, 19, 'Lesson Plan Design', 'Create a lesson plan for a high school class', '2024-10-29', '2024-09-17 07:21:59'),
(20, 20, 'Climate Change Report', 'Write a report on climate change effects', '2024-10-31', '2024-09-17 07:21:59');

-- --------------------------------------------------------

--
-- Struktura tabele `assignments_submissions`
--

CREATE TABLE `assignments_submissions` (
  `SubmissionID` int(11) NOT NULL,
  `AssignmentID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `SubmissionDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `SubmissionContent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `assignments_submissions`
--

INSERT INTO `assignments_submissions` (`SubmissionID`, `AssignmentID`, `UserID`, `SubmissionDate`, `SubmissionContent`) VALUES
(1, 1, 1, '2024-09-17 07:24:28', 'Solved all problems correctly'),
(2, 2, 1, '2024-09-17 07:24:28', 'Completed the lab report'),
(3, 3, 2, '2024-09-17 07:24:28', 'Explained types of reactions'),
(4, 4, 2, '2024-09-17 07:24:28', 'Field trip report submitted'),
(5, 5, 3, '2024-09-17 07:24:28', 'Research on WWII completed'),
(6, 6, 3, '2024-09-17 07:24:28', 'Map analysis submitted'),
(7, 7, 4, '2024-09-17 07:24:28', 'Essay on Hamlet completed'),
(8, 8, 4, '2024-09-17 07:24:28', 'Portfolio of artworks submitted'),
(9, 9, 5, '2024-09-17 07:24:28', 'Music composition created'),
(10, 10, 5, '2024-09-17 07:24:28', 'Debate preparation done'),
(11, 11, 6, '2024-09-17 07:24:28', 'Survey on social behavior submitted'),
(12, 12, 6, '2024-09-17 07:24:28', 'Case study analysis completed'),
(13, 13, 7, '2024-09-17 07:24:28', 'Essay on market structures done'),
(14, 14, 7, '2024-09-17 07:24:28', 'Comparison of political systems submitted'),
(15, 15, 8, '2024-09-17 07:24:28', 'Algorithm design submitted'),
(16, 16, 8, '2024-09-17 07:24:28', 'Bridge design completed'),
(17, 17, 9, '2024-09-17 07:24:28', 'Medical case study analyzed'),
(18, 18, 9, '2024-09-17 07:24:28', 'Legal research paper submitted'),
(19, 19, 10, '2024-09-17 07:24:28', 'Lesson plan designed'),
(20, 20, 10, '2024-09-17 07:24:28', 'Climate change report submitted');

-- --------------------------------------------------------

--
-- Struktura tabele `student_subjects`
--

CREATE TABLE `student_subjects` (
  `UserID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `student_subjects`
--

INSERT INTO `student_subjects` (`UserID`, `SubjectID`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(5, 9),
(5, 10),
(6, 11),
(6, 12),
(7, 13),
(7, 14),
(8, 15),
(8, 16),
(9, 17),
(9, 18),
(10, 19),
(10, 20);

-- --------------------------------------------------------

--
-- Struktura tabele `subjects`
--

CREATE TABLE `subjects` (
  `SubjectID` int(11) NOT NULL,
  `SubjectName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `subjects`
--

INSERT INTO `subjects` (`SubjectID`, `SubjectName`, `Description`) VALUES
(1, 'Mathematics', 'Study of numbers and shapes'),
(2, 'Physics', 'Study of matter and energy'),
(3, 'Chemistry', 'Study of substances and their reactions'),
(4, 'Biology', 'Study of living organisms'),
(5, 'History', 'Study of past events'),
(6, 'Geography', 'Study of places and environments'),
(7, 'English', 'Study of language and literature'),
(8, 'Art', 'Study of creative expression'),
(9, 'Music', 'Study of sound and music theory'),
(10, 'Philosophy', 'Study of fundamental questions about existence'),
(11, 'Sociology', 'Study of society and social behavior'),
(12, 'Psychology', 'Study of the human mind and behavior'),
(13, 'Economics', 'Study of production and consumption of goods'),
(14, 'Political Science', 'Study of politics and government systems'),
(15, 'Computer Science', 'Study of computers and algorithmic processes'),
(16, 'Engineering', 'Study of design and construction of systems'),
(17, 'Medicine', 'Study of health and diseases'),
(18, 'Law', 'Study of legal systems and regulations'),
(19, 'Education', 'Study of teaching and learning processes'),
(20, 'Environmental Science', 'Study of the environment and its preservation');

-- --------------------------------------------------------

--
-- Struktura tabele `teacher_subjects`
--

CREATE TABLE `teacher_subjects` (
  `UserID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `teacher_subjects`
--

INSERT INTO `teacher_subjects` (`UserID`, `SubjectID`) VALUES
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(12, 5),
(12, 6),
(12, 7),
(12, 8),
(13, 9),
(13, 10),
(13, 11),
(13, 12),
(14, 13),
(14, 14),
(14, 15),
(14, 16),
(15, 17),
(15, 18),
(15, 19),
(15, 20);

-- --------------------------------------------------------

--
-- Struktura tabele `uporabnik`
--

CREATE TABLE `uporabnik` (
  `UserID` int(11) NOT NULL,
  `ime_uporabnika` varchar(255) NOT NULL,
  `priimek_uporabnika` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `uporabnik`
--

INSERT INTO `uporabnik` (`UserID`, `ime_uporabnika`, `priimek_uporabnika`, `Username`, `password`, `Email`) VALUES
(1, 'Nejc', 'Mlakar', 'nejc', '$2y$10$khgPBm/q0aK6OnWvfUyxrOLpOb97ajIobJ27NTKFjQU05OjY/0KAy', 'nejc@gmail.com'),
(2, 'nejc', 'nejc', '1', '$2y$10$g8yOGWoA2Balmm0hYpgZQuWsnt/vD0GfwWIc18Bb1Z2gN8//P7NnG', '1@gmail.com'),
(3, 'anze', 'anze', 'anze', '$2y$10$7iFnjgtjCPm2pMq4wa6cJ.aq/1qG7As5WHg99HH14hwtcwm.syuFq', 'anze@gmail.com'),
(4, '2', '2', '2', '2', '2@gmail.com'),
(5, '2', '2', '2', '2', '2@gmail.com'),
(6, '2', '2', '2', '2', '2@gmail.com'),
(7, '2', '2', '2', '2', '2@gmail.com'),
(8, '2', '2', '2', '2', '2@gmail.com'),
(9, '2', '2', '2', '2', '2@gmail.com'),
(10, '2', '2', '2', '2', '2@gmail.com'),
(11, '2', '2', '2', '2', '2@gmail.com'),
(12, '2', '2', '2', '2', '2@gmail.com'),
(13, '2', '2', '2', '2', '2@gmail.com'),
(14, '2', '2', '2', '2', '2@gmail.com'),
(15, '2', '2', '2', '2', '2@gmail.com'),
(16, '2', '2', '2', '2', '2@gmail.com'),
(17, '2', '2', '2', '2', '2@gmail.com'),
(18, '2', '2', '2', '2', '2@gmail.com');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`AssignmentID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indeksi tabele `assignments_submissions`
--
ALTER TABLE `assignments_submissions`
  ADD PRIMARY KEY (`SubmissionID`),
  ADD KEY `AssignmentID` (`AssignmentID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indeksi tabele `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`UserID`,`SubjectID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indeksi tabele `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SubjectID`);

--
-- Indeksi tabele `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`UserID`,`SubjectID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indeksi tabele `uporabnik`
--
ALTER TABLE `uporabnik`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `assignments`
--
ALTER TABLE `assignments`
  MODIFY `AssignmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT tabele `assignments_submissions`
--
ALTER TABLE `assignments_submissions`
  MODIFY `SubmissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT tabele `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT tabele `uporabnik`
--
ALTER TABLE `uporabnik`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `assignments_submissions`
--
ALTER TABLE `assignments_submissions`
  ADD CONSTRAINT `assignments_submissions_ibfk_1` FOREIGN KEY (`AssignmentID`) REFERENCES `assignments` (`AssignmentID`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_submissions_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `uporabnik` (`UserID`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD CONSTRAINT `student_subjects_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `uporabnik` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD CONSTRAINT `teacher_subjects_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `uporabnik` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_subjects_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
