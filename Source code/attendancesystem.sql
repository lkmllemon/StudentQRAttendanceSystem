CREATE TABLE `students` (
  `studentID` varchar(100) PRIMARY KEY NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE classes (
    `class_code` varchar(100) PRIMARY KEY
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `classes` (`class_code`) VALUES
('CST301'),
('CST302'),
('CST303'),
('CST304'),
('CST305'),
('CST306');

CREATE TABLE attendance (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `studentID` varchar(100) NOT NULL,
    `class_code` VARCHAR(100) NOT NULL,
    `DATE` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `scan_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (studentID) REFERENCES students(studentID),
    FOREIGN KEY (class_code) REFERENCES classes(class_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE users (
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(100),
    `password_hash` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;