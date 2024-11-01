
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `assignments` (
  `AssignmentID` int(11) NOT NULL,
  `SubjectID` int(11) DEFAULT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `DueDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `assignments` (`AssignmentID`, `SubjectID`, `Title`, `Description`, `DueDate`) VALUES
(101, 20, 'test', '123', '2222-02-22 22:22:00'),
(106, 21, 'Prva naloga', 'Dodaj datoteko', '2222-02-22 22:22:00'),
(107, 21, 'Druga naloga', 'ja sija', '2222-02-22 22:22:00'),
(108, 21, 'potekla', '12212', '2024-09-11 23:04:00');


CREATE TABLE `assignments_submissions` (
  `SubmissionID` int(11) NOT NULL,
  `AssignmentID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `SubmissionDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `SubmissionContent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `assignments_submissions` (`SubmissionID`, `AssignmentID`, `UserID`, `SubmissionDate`, `SubmissionContent`) VALUES
(34, 107, 2, '2024-11-01 22:03:12', 'ucenec ucenec - Druga naloga - 107.docx'),
(35, 107, 10, '2024-11-01 22:03:54', 'znidar anze - Druga naloga - 107.docx'),
(36, 108, 2, '2024-11-01 22:05:07', 'ucenec ucenec - potekla - 108.docx');



CREATE TABLE `student_assignments` (
  `UserID` int(11) NOT NULL,
  `AssignmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `student_assignments` (`UserID`, `AssignmentID`) VALUES
(2, 101),
(2, 106),
(2, 107),
(2, 108),
(10, 106),
(10, 107),
(10, 108);


CREATE TABLE `student_subjects` (
  `UserID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `student_subjects` (`UserID`, `SubjectID`) VALUES
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(10, 21);


CREATE TABLE `subjects` (
  `SubjectID` int(11) NOT NULL,
  `SubjectName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `razredi` varchar(255) DEFAULT NULL,
  `geslo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `subjects` (`SubjectID`, `SubjectName`, `Description`, `razredi`, `geslo`) VALUES
(8, 'NRP1', 'objektno programiranje1', 'a:6:{i:0;s:0:\"\";i:1;s:3:\"R4B\";i:2;s:2:\"\r\n\";i:3;s:3:\"R4A\";i:4;s:2:\"\r\n\";i:5;s:3:\"R1B\";}', '0'),
(9, 'ROB', 'multimedija', 'a:6:{i:0;s:0:\"\";i:1;s:3:\"R4B\";i:2;s:2:\"\r\n\";i:3;s:3:\"R4A\";i:4;s:2:\"\r\n\";i:5;s:3:\"R1B\";}', '0'),
(17, 'se en', '1', NULL, '0'),
(18, 'test', '123', NULL, '123'),
(19, 'se en predmet', '123', NULL, '321'),
(20, 'test slemi', 'opis', NULL, '1'),
(21, 'ROB', 'multimedija', NULL, 'ROB');


CREATE TABLE `task_files` (
  `id` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `teacher_subjects` (
  `UserID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `teacher_subjects` (`UserID`, `SubjectID`, `ID`) VALUES
(3, 17, 4),
(1, 18, 13),
(1, 19, 14),
(3, 20, 15),
(1, 21, 16);


CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `ime_uporabnika` varchar(50) NOT NULL,
  `priimek_uporbnika` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `UserType` enum('ucenec','ucitelj','admin') NOT NULL,
  `razred` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `users` (`UserID`, `ime_uporabnika`, `priimek_uporbnika`, `Username`, `password`, `Email`, `UserType`, `razred`) VALUES
(1, 'Nejc', 'Mlakar', 'nejcm', '$2y$10$t9M6cnzy2DzYOQF5I.r.seSwvxe3VcGAWiT9vmFQG5eu9FnUqQEjK', 'nejcmlakar11@gmail.com', 'ucitelj', NULL),
(2, 'ucenec', 'ucenec', 'ucenec', '$2y$10$D2DYwb0Yb9li5rrSK9JNgeK6wfdTp7D14AywE8q1Nm0JwI0.YC8bO', 'test@gmail.com', 'ucenec', 'R4B'),
(3, 'Borut', 'Selmi', 'SlemiKralj', '$2y$10$xvF34DnIzckqqS7yhhZU4eMetKnliofyif3UkRgkpjA2gK9CWjh/m', '1', 'ucitelj', NULL),
(6, 'Bostjan', 'Fidler', 'Fidi', '1', 'mail', 'ucitelj', NULL),
(7, 'admin', 'admin', 'admin', '$2y$10$B4IcXq6YGlZQyFll2Rwnhee2qSHSQaQy3Csl2Z0ybWJ2ISHYOJ9au', 'admin@gmail.com', 'admin', NULL),
(8, 'ucenec1', 'ucenec1', 'ucenec1', '$2y$10$69.15OazPwzSQ0G3wsbGRO5geNxLA0ih8N7kU9FTnyj6WC8I2EAu2', 'asdad@gmail.com', 'ucenec', 'R4A'),
(10, 'anze', 'znidar', 'znajdar', '$2y$10$BFr7D/6Rml.OUGrlZwgQze4Kqnh/OjmsDgxClnaQlsf7WqQip/752', 'znidar@gmail.com', 'ucenec', NULL);


ALTER TABLE `assignments`
  ADD PRIMARY KEY (`AssignmentID`),
  ADD KEY `SubjectID` (`SubjectID`);


ALTER TABLE `assignments_submissions`
  ADD PRIMARY KEY (`SubmissionID`),
  ADD KEY `AssignmentID` (`AssignmentID`),
  ADD KEY `UserID` (`UserID`);

ALTER TABLE `student_assignments`
  ADD PRIMARY KEY (`UserID`,`AssignmentID`),
  ADD KEY `AssignmentID` (`AssignmentID`);

ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`UserID`,`SubjectID`),
  ADD KEY `SubjectID` (`SubjectID`);

ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SubjectID`);

ALTER TABLE `task_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SubjectID` (`SubjectID`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

ALTER TABLE `assignments`
  MODIFY `AssignmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

ALTER TABLE `assignments_submissions`
  MODIFY `SubmissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `subjects`
  MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `teacher_subjects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`);


ALTER TABLE `assignments_submissions`
  ADD CONSTRAINT `assignments_submissions_ibfk_1` FOREIGN KEY (`AssignmentID`) REFERENCES `assignments` (`AssignmentID`),
  ADD CONSTRAINT `assignments_submissions_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);


ALTER TABLE `student_assignments`
  ADD CONSTRAINT `student_assignments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_assignments_ibfk_2` FOREIGN KEY (`AssignmentID`) REFERENCES `assignments` (`AssignmentID`) ON DELETE CASCADE;


ALTER TABLE `student_subjects`
  ADD CONSTRAINT `student_subjects_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `student_subjects_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`);

ALTER TABLE `task_files`
  ADD CONSTRAINT `task_files_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `assignments` (`AssignmentID`);
COMMIT;

