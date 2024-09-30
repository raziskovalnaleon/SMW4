-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 22. sep 2024 ob 18.58
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
  `DueDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `assignments`
--

INSERT INTO `assignments` (`AssignmentID`, `SubjectID`, `Title`, `Description`, `DueDate`) VALUES
(1, 4, 'NASLOV NALOGE VVO', 'OPIS NALOGE VVO', '2024-09-28');

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

-- --------------------------------------------------------

--
-- Struktura tabele `student_assignments`
--

CREATE TABLE `student_assignments` (
  `UserID` int(11) NOT NULL,
  `AssignmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `student_assignments`
--

INSERT INTO `student_assignments` (`UserID`, `AssignmentID`) VALUES
(2, 1);

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
(2, 1),
(2, 4),
(2, 5);

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
(1, 'NPP', 'Opis'),
(4, 'VVO', 'VVO'),
(5, 'LOTANJE', 'kapibara');

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
(3, 4),
(6, 1),
(6, 5);

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `ime_uporabnika` varchar(50) NOT NULL,
  `priimek_uporbnika` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `UserType` enum('ucenec','ucitelj','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `users`
--

INSERT INTO `users` (`UserID`, `ime_uporabnika`, `priimek_uporbnika`, `Username`, `password`, `Email`, `UserType`) VALUES
(1, 'Nejc', 'Mlakar', 'nejcm', '$2y$10$t9M6cnzy2DzYOQF5I.r.seSwvxe3VcGAWiT9vmFQG5eu9FnUqQEjK', 'nejcmlakar11@gmail.com', 'ucitelj'),
(2, 'ucenec', 'ucenec', 'ucenec', '$2y$10$D2DYwb0Yb9li5rrSK9JNgeK6wfdTp7D14AywE8q1Nm0JwI0.YC8bO', 'test@gmail.com', 'ucenec'),
(3, 'Borut', 'Selmi', 'SlemiKralj', '1', '1', 'ucitelj'),
(6, 'Bostjan', 'Fidler', 'Fidi', '1', 'mail', 'ucitelj');

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
-- Indeksi tabele `student_assignments`
--
ALTER TABLE `student_assignments`
  ADD PRIMARY KEY (`UserID`,`AssignmentID`),
  ADD KEY `AssignmentID` (`AssignmentID`);

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
-- Indeksi tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `assignments`
--
ALTER TABLE `assignments`
  MODIFY `AssignmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT tabele `assignments_submissions`
--
ALTER TABLE `assignments_submissions`
  MODIFY `SubmissionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT tabele `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT tabele `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`);

--
-- Omejitve za tabelo `assignments_submissions`
--
ALTER TABLE `assignments_submissions`
  ADD CONSTRAINT `assignments_submissions_ibfk_1` FOREIGN KEY (`AssignmentID`) REFERENCES `assignments` (`AssignmentID`),
  ADD CONSTRAINT `assignments_submissions_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Omejitve za tabelo `student_assignments`
--
ALTER TABLE `student_assignments`
  ADD CONSTRAINT `student_assignments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_assignments_ibfk_2` FOREIGN KEY (`AssignmentID`) REFERENCES `assignments` (`AssignmentID`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD CONSTRAINT `student_subjects_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `student_subjects_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`);

--
-- Omejitve za tabelo `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD CONSTRAINT `teacher_subjects_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `teacher_subjects_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
