-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 06, 2018 at 12:19 AM
-- Server version: 5.7.20-log
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `empire_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `user_id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `photo` varchar(1024) DEFAULT NULL,
  `idattendance` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idattendance`),
  KEY `fk_attendance_staff1_idx` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`user_id`, `date_time`, `photo`, `idattendance`) VALUES
(2, '2018-01-05 18:57:13', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
CREATE TABLE IF NOT EXISTS `branch` (
  `idbranch` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `postcode` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `street` varchar(45) NOT NULL,
  `country` varchar(45) NOT NULL,
  PRIMARY KEY (`idbranch`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`idbranch`, `name`, `postcode`, `city`, `street`, `country`) VALUES
(1, 'boulevard', '0000', 'kl', 'persiwaran 19', 'malaysia'),
(2, 'JB', '', '', '', ''),
(3, 'Sing', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `idclass` int(11) NOT NULL AUTO_INCREMENT,
  `building` varchar(45) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `postcode` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idclass`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`idclass`, `building`, `level`, `code`, `postcode`, `city`, `street`, `country`) VALUES
(1, '13', 13, 'XB03', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_date`
--

DROP TABLE IF EXISTS `class_date`;
CREATE TABLE IF NOT EXISTS `class_date` (
  `idclass_date` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`idclass_date`),
  KEY `fk_class_date_student1_idx` (`student_id`),
  KEY `fk_class_date_class1_idx` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `idcourse` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `year` varchar(45) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idcourse`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`idcourse`, `name`, `description`, `year`, `code`) VALUES
(1, 'Diploma BS', NULL, NULL, NULL),
(2, 'Diploma ACC', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_module`
--

DROP TABLE IF EXISTS `course_module`;
CREATE TABLE IF NOT EXISTS `course_module` (
  `idcourse_module` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  PRIMARY KEY (`idcourse_module`),
  KEY `fk_course_module_module1_idx` (`module_id`),
  KEY `fk_course_module_course1_idx` (`course_id`),
  KEY `fk_course_module_lecturer1_idx` (`lecturer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `idemployee` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company` varchar(45) NOT NULL,
  `position` varchar(45) NOT NULL,
  `date_joined` date DEFAULT NULL,
  `date_left` date DEFAULT NULL,
  PRIMARY KEY (`idemployee`,`user_id`),
  KEY `fk_employee_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`idemployee`, `user_id`, `company`, `position`, `date_joined`, `date_left`) VALUES
(1, 3, 'd2j', 'developer', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_training`
--

DROP TABLE IF EXISTS `employee_training`;
CREATE TABLE IF NOT EXISTS `employee_training` (
  `idemployee_training` int(11) NOT NULL AUTO_INCREMENT,
  `training_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date_started` date NOT NULL,
  `date_end` date NOT NULL,
  PRIMARY KEY (`idemployee_training`),
  KEY `fk_employee_training_training1_idx` (`training_id`),
  KEY `fk_employee_training_employee1_idx` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_training_mat`
--

DROP TABLE IF EXISTS `employee_training_mat`;
CREATE TABLE IF NOT EXISTS `employee_training_mat` (
  `idemployee_training_mat` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `training_material_id` int(11) NOT NULL,
  `date_issued` date NOT NULL,
  PRIMARY KEY (`idemployee_training_mat`,`employee_id`,`training_material_id`),
  KEY `fk_employee_training_mat_employee1_idx` (`employee_id`),
  KEY `fk_employee_training_mat_training_material1_idx` (`training_material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

DROP TABLE IF EXISTS `employer`;
CREATE TABLE IF NOT EXISTS `employer` (
  `idemployer` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company` varchar(45) NOT NULL,
  `position` varchar(45) NOT NULL,
  `date_joined` date DEFAULT NULL,
  `date_left` date DEFAULT NULL,
  PRIMARY KEY (`idemployer`,`user_id`),
  KEY `fk_employer_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`idemployer`, `user_id`, `company`, `position`, `date_joined`, `date_left`) VALUES
(1, 7, 'glacon', 'manager', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employer_notification`
--

DROP TABLE IF EXISTS `employer_notification`;
CREATE TABLE IF NOT EXISTS `employer_notification` (
  `idnotification` int(11) NOT NULL AUTO_INCREMENT,
  `employer_id` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`idnotification`),
  KEY `fk_notification_employer1_idx` (`employer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employer_report`
--

DROP TABLE IF EXISTS `employer_report`;
CREATE TABLE IF NOT EXISTS `employer_report` (
  `idemployee_report` int(11) NOT NULL AUTO_INCREMENT,
  `employer_id` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`idemployee_report`,`employer_id`),
  KEY `fk_employee_report_employer1_idx` (`employer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employment_history`
--

DROP TABLE IF EXISTS `employment_history`;
CREATE TABLE IF NOT EXISTS `employment_history` (
  `idemployment_history` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`idemployment_history`,`employer_id`,`employee_id`),
  KEY `fk_employment_history_employer1_idx` (`employer_id`),
  KEY `fk_employment_history_employee1_idx` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

DROP TABLE IF EXISTS `enquiry`;
CREATE TABLE IF NOT EXISTS `enquiry` (
  `idenquiry` int(11) NOT NULL AUTO_INCREMENT,
  `enquirer` varchar(45) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`idenquiry`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `idfeedback` int(11) NOT NULL AUTO_INCREMENT,
  `employer_id` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`idfeedback`),
  KEY `fk_feedback_employer1_idx` (`employer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `interview`
--

DROP TABLE IF EXISTS `interview`;
CREATE TABLE IF NOT EXISTS `interview` (
  `idinterview` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `domain` varchar(45) NOT NULL,
  `postcode` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `street` varchar(45) NOT NULL,
  `country` varchar(45) NOT NULL,
  PRIMARY KEY (`idinterview`),
  KEY `fk_interview_staff1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `interview`
--

INSERT INTO `interview` (`idinterview`, `user_id`, `date_time`, `domain`, `postcode`, `city`, `street`, `country`) VALUES
(1, 1, '2017-09-09 12:00:00', 'customer service', '0000', 'kl', 'usj 1', 'malaysia'),
(2, 3, '2018-01-10 20:00:00', '', '', '', '', ''),
(3, 1, '2018-01-24 00:57:00', '', '47630', 'Subang Jaya', 'D 19 08 USJ 19 City Mall', 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `leave_`
--

DROP TABLE IF EXISTS `leave_`;
CREATE TABLE IF NOT EXISTS `leave_` (
  `user_id` int(11) NOT NULL,
  `idleave` int(11) NOT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `reason` varchar(250) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'pending',
  `photo` varchar(1024) NOT NULL,
  PRIMARY KEY (`idleave`),
  KEY `fk_leave_staff1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leave_`
--

INSERT INTO `leave_` (`user_id`, `idleave`, `start`, `end`, `reason`, `status`, `photo`) VALUES
(2, 1, '2018-01-17', '2018-01-19', 'medical', 'active', '');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

DROP TABLE IF EXISTS `lecturer`;
CREATE TABLE IF NOT EXISTS `lecturer` (
  `idlecturer` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(45) NOT NULL,
  `date_joined` date DEFAULT NULL,
  `date_left` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`idlecturer`,`user_id`),
  KEY `fk_lecturer_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `idmodule` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `code` varchar(45) NOT NULL,
  `semester` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(250) NOT NULL,
  `year` date NOT NULL,
  `student_module_id` int(11) NOT NULL,
  `cost` float NOT NULL,
  `modulecol` varchar(45) NOT NULL,
  PRIMARY KEY (`idmodule`),
  KEY `fk_module_class1_idx` (`class_id`),
  KEY `fk_module_student_module1_idx` (`student_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `recruit`
--

DROP TABLE IF EXISTS `recruit`;
CREATE TABLE IF NOT EXISTS `recruit` (
  `idrecruit` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `applied_for` varchar(45) DEFAULT NULL,
  `file` varchar(1024) DEFAULT NULL,
  `phone` varchar(45) NOT NULL,
  `date_applied` date DEFAULT NULL,
  PRIMARY KEY (`idrecruit`) USING BTREE,
  KEY `fk_recruit_interview1_idx` (`interview_id`),
  KEY `fk_recruit_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recruit`
--

INSERT INTO `recruit` (`idrecruit`, `interview_id`, `user_id`, `applied_for`, `file`, `phone`, `date_applied`) VALUES
(75, 1, 3, 'dfdf', '', '', '2017-12-29'),
(81, 1, 3, 'ca', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `idstaff` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '-1',
  `position` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `date_left` date DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idstaff`) USING BTREE,
  KEY `fk_staff_user1_idx` (`user_id`),
  KEY `fk_staff_branch1_idx` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`idstaff`, `user_id`, `position`, `role`, `date_joined`, `date_left`, `branch_id`) VALUES
(1, 2, 'clerical', 'hr', '2017-09-09', '2017-12-28', 1),
(2, 55, 'marketing', 'hr', '2017-12-28', '2017-12-28', -1),
(3, 56, 'Receptionist', 'Serve customer', '2017-12-28', '0000-00-00', -1),
(4, 85, 'PHP DEVELOPER ', '', '2018-01-25', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `idstudent` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `date_registered` date DEFAULT NULL,
  `date_left` date DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idstudent`),
  KEY `fk_student_courser1_idx` (`course_id`),
  KEY `fk_student_student1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`idstudent`, `user_id`, `semester`, `phone`, `date_registered`, `date_left`, `course_id`) VALUES
(8, 83, 1, '', '2018-01-24', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
CREATE TABLE IF NOT EXISTS `student_attendance` (
  `idstudent_attendance` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`idstudent_attendance`),
  KEY `fk_student_attendance_class1_idx` (`class_id`),
  KEY `fk_student_attendance_student1_idx` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_module`
--

DROP TABLE IF EXISTS `student_module`;
CREATE TABLE IF NOT EXISTS `student_module` (
  `idstudent_module` int(11) NOT NULL AUTO_INCREMENT,
  `date_enrolled` date DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idstudent_module`),
  KEY `student_mod_fk1_idx` (`module_id`),
  KEY `student_mod_fk2_idx` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_payment`
--

DROP TABLE IF EXISTS `student_payment`;
CREATE TABLE IF NOT EXISTS `student_payment` (
  `idstudent_payment` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `payment_type` varchar(45) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`idstudent_payment`,`module_id`),
  KEY `fk_student_payment_module1_idx` (`module_id`),
  KEY `fk_student_payment_module2_idx` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

DROP TABLE IF EXISTS `trainer`;
CREATE TABLE IF NOT EXISTS `trainer` (
  `idtrainer` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(45) NOT NULL,
  `date_joined` date DEFAULT NULL,
  `date_left` date DEFAULT NULL,
  `expertise` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`idtrainer`) USING BTREE,
  KEY `fk_trainer_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`idtrainer`, `phone`, `date_joined`, `date_left`, `expertise`, `user_id`) VALUES
(1, '0000', '2017-09-09', NULL, 'customer service', 4);

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

DROP TABLE IF EXISTS `training`;
CREATE TABLE IF NOT EXISTS `training` (
  `idtraining` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `trainer_id` int(11) NOT NULL,
  `postcode` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtraining`,`trainer_id`),
  KEY `fk_training_trainer1_idx` (`trainer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`idtraining`, `name`, `type`, `description`, `trainer_id`, `postcode`, `city`, `street`, `country`) VALUES
(2, 'Customer Service 101', 'customer service', 'Introduction to customer service', 1, '000', 'shah alam', 'usj', 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `training_material`
--

DROP TABLE IF EXISTS `training_material`;
CREATE TABLE IF NOT EXISTS `training_material` (
  `training_id` int(11) NOT NULL AUTO_INCREMENT,
  `idtraining_material` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idtraining_material`),
  KEY `fk_training_material_training1_idx` (`training_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(1024) DEFAULT '0',
  `type` varchar(45) NOT NULL,
  `remember_token` varchar(1024) DEFAULT '0',
  `avatar` varchar(250) DEFAULT '0',
  `postcode` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `street` varchar(45) NOT NULL,
  `country` varchar(45) NOT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `name`, `email`, `password`, `type`, `remember_token`, `avatar`, `postcode`, `city`, `street`, `country`) VALUES
(1, 'rahman', 'admin@empire.com', '$2a$12$0pgNKzLvPLdgwahoXSlbReUKPDczv6Udi3yLZsZusfMZi52rbzqTC', 'admin', NULL, NULL, '0000', 'shah alam', 'usj', 'malaysia'),
(2, 'Staff1', 'staff1@empire.com', '$2a$12$0pgNKzLvPLdgwahoXSlbReUKPDczv6Udi3yLZsZusfMZi52rbzqTC', 'Staff', NULL, NULL, '0000', 'shah alam', 'usj', 'malaysia'),
(3, 'recruit1', 'recruit1@empire.com', '$2a$12$0pgNKzLvPLdgwahoXSlbReUKPDczv6Udi3yLZsZusfMZi52rbzqTC', 'Recruit', NULL, NULL, '0000', 'shah alam', 'usj', 'malaysia'),
(4, 'trainer1', 'trainer1@empire.com', '$2a$12$0pgNKzLvPLdgwahoXSlbReUKPDczv6Udi3yLZsZusfMZi52rbzqTC', 'trainer', NULL, NULL, '0000', 'shah alam', 'usj', 'malaysia'),
(5, 'lecturer1', 'lecturer1@empire.com', '$2a$12$0pgNKzLvPLdgwahoXSlbReUKPDczv6Udi3yLZsZusfMZi52rbzqTC', 'lecturer', NULL, NULL, '0000', 'shah alam', 'usj', 'malaysia'),
(7, 'employer1', 'employer1@empire.com', '$12$0pgNKzLvPLdgwahoXSlbReUKPDczv6Udi3yLZsZusfMZi52rbzqTC', 'employer', NULL, NULL, '000', 'shah alam', 'usj', 'malaysia'),
(56, 'staff2', 'staff2@empire.com', '0', 'Staff', '0', '0', '000', 'shah alam', 'usj', 'Malaysia'),
(83, 'student1', 'student1@empire.com', '0', 'Student', '0', '0', '', '', '', ''),
(84, 'admin4', 'admin4@empire.com', '0', 'Admin', '0', '0', '', '', '', ''),
(85, 'staff5', 'staff5@empire.com', '0', 'Staff', '0', '0', '', '', '', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`iduser`);

--
-- Constraints for table `class_date`
--
ALTER TABLE `class_date`
  ADD CONSTRAINT `fk_class_date_class1` FOREIGN KEY (`class_id`) REFERENCES `class` (`idclass`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_class_date_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`idstudent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course_module`
--
ALTER TABLE `course_module`
  ADD CONSTRAINT `fk_course_module_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`idcourse`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_course_module_lecturer1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`idlecturer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_course_module_module1` FOREIGN KEY (`module_id`) REFERENCES `module` (`idmodule`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `fk_employee_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_training`
--
ALTER TABLE `employee_training`
  ADD CONSTRAINT `fk_employee_training_employee1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`idemployee`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_employee_training_training1` FOREIGN KEY (`training_id`) REFERENCES `training` (`idtraining`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_training_mat`
--
ALTER TABLE `employee_training_mat`
  ADD CONSTRAINT `fk_employee_training_mat_employee1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`idemployee`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_employee_training_mat_training_material1` FOREIGN KEY (`training_material_id`) REFERENCES `training_material` (`idtraining_material`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employer`
--
ALTER TABLE `employer`
  ADD CONSTRAINT `fk_employer_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employer_notification`
--
ALTER TABLE `employer_notification`
  ADD CONSTRAINT `fk_notification_employer1` FOREIGN KEY (`employer_id`) REFERENCES `employer` (`idemployer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employer_report`
--
ALTER TABLE `employer_report`
  ADD CONSTRAINT `fk_employee_report_employer1` FOREIGN KEY (`employer_id`) REFERENCES `employer` (`idemployer`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `employment_history`
--
ALTER TABLE `employment_history`
  ADD CONSTRAINT `fk_employment_history_employee1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`idemployee`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_employment_history_employer1` FOREIGN KEY (`employer_id`) REFERENCES `employer` (`idemployer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_employer1` FOREIGN KEY (`employer_id`) REFERENCES `employer` (`idemployer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `interview`
--
ALTER TABLE `interview`
  ADD CONSTRAINT `fk_interview_staff1` FOREIGN KEY (`user_id`) REFERENCES `staff` (`idstaff`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `leave_`
--
ALTER TABLE `leave_`
  ADD CONSTRAINT `fk_leave_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD CONSTRAINT `fk_lecturer_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `fk_module_class1` FOREIGN KEY (`class_id`) REFERENCES `class` (`idclass`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_module_student_module1` FOREIGN KEY (`student_module_id`) REFERENCES `student_module` (`idstudent_module`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recruit`
--
ALTER TABLE `recruit`
  ADD CONSTRAINT `fk_recruit_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`idcourse`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_student1` FOREIGN KEY (`user_id`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD CONSTRAINT `fk_student_attendance_class1` FOREIGN KEY (`class_id`) REFERENCES `class` (`idclass`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_attendance_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`idstudent`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_module`
--
ALTER TABLE `student_module`
  ADD CONSTRAINT `student_mod_fk1` FOREIGN KEY (`module_id`) REFERENCES `module` (`idmodule`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `student_mod_fk2` FOREIGN KEY (`student_id`) REFERENCES `student` (`idstudent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student_payment`
--
ALTER TABLE `student_payment`
  ADD CONSTRAINT `fk_student_payment_module1` FOREIGN KEY (`module_id`) REFERENCES `module` (`idmodule`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_payment_module2` FOREIGN KEY (`student_id`) REFERENCES `student` (`idstudent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `trainer`
--
ALTER TABLE `trainer`
  ADD CONSTRAINT `fk_trainer_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `training`
--
ALTER TABLE `training`
  ADD CONSTRAINT `fk_training_trainer1` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`idtrainer`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `training_material`
--
ALTER TABLE `training_material`
  ADD CONSTRAINT `fk_training_material_training1` FOREIGN KEY (`training_id`) REFERENCES `training` (`idtraining`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
