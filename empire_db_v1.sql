-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema empire
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `empire` ;

-- -----------------------------------------------------
-- Schema empire
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `empire` DEFAULT CHARACTER SET utf8 ;
USE `empire` ;

-- -----------------------------------------------------
-- Table `empire`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`user` ;

CREATE TABLE IF NOT EXISTS `empire`.`user` (
  `iduser` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(1024) NULL,
  `type` VARCHAR(45) NULL,
  `remember_token` VARCHAR(1024) NULL,
  `avatar` VARCHAR(250) NULL,
  PRIMARY KEY (`iduser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`branch_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`branch_address` ;

CREATE TABLE IF NOT EXISTS `empire`.`branch_address` (
  `idbranch_address` INT NOT NULL,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idbranch_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`branch`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`branch` ;

CREATE TABLE IF NOT EXISTS `empire`.`branch` (
  `idbranch` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `branch_address_id` INT NOT NULL,
  PRIMARY KEY (`idbranch`, `branch_address_id`),
  INDEX `fk_branch_branch_address1_idx` (`branch_address_id` ASC),
  CONSTRAINT `fk_branch_branch_address1`
    FOREIGN KEY (`branch_address_id`)
    REFERENCES `empire`.`branch_address` (`idbranch_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`staff_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`staff_address` ;

CREATE TABLE IF NOT EXISTS `empire`.`staff_address` (
  `idstaff_address` INT NOT NULL,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idstaff_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`staff`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`staff` ;

CREATE TABLE IF NOT EXISTS `empire`.`staff` (
  `idstaff` INT NOT NULL,
  `user_id` INT NOT NULL,
  `position` VARCHAR(45) NULL,
  `role` VARCHAR(45) NULL,
  `date_joined` DATE NULL,
  `date_left` DATE NULL,
  `branch_id` INT NOT NULL,
  `staff_address_id` INT NOT NULL,
  PRIMARY KEY (`idstaff`, `user_id`),
  INDEX `fk_staff_user1_idx` (`user_id` ASC),
  INDEX `fk_staff_branch1_idx` (`branch_id` ASC),
  INDEX `fk_staff_staff_address1_idx` (`staff_address_id` ASC),
  CONSTRAINT `fk_staff_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `empire`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_branch1`
    FOREIGN KEY (`branch_id`)
    REFERENCES `empire`.`branch` (`idbranch`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_staff_address1`
    FOREIGN KEY (`staff_address_id`)
    REFERENCES `empire`.`staff_address` (`idstaff_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`enquiry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`enquiry` ;

CREATE TABLE IF NOT EXISTS `empire`.`enquiry` (
  `idenquiry` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  `description` VARCHAR(250) NULL,
  PRIMARY KEY (`idenquiry`),
  INDEX `fk_enquiry_staff_idx` (`staff_id` ASC),
  CONSTRAINT `fk_enquiry_staff`
    FOREIGN KEY (`staff_id`)
    REFERENCES `empire`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`attendance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`attendance` ;

CREATE TABLE IF NOT EXISTS `empire`.`attendance` (
  `staff_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  `photo` VARCHAR(1024) NULL,
  `id_attendance` INT NOT NULL,
  INDEX `fk_attendance_staff1_idx` (`staff_id` ASC),
  PRIMARY KEY (`id_attendance`),
  CONSTRAINT `fk_attendance_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `empire`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`leave`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`leave` ;

CREATE TABLE IF NOT EXISTS `empire`.`leave` (
  `staff_id` INT NOT NULL,
  `id_leave` INT NOT NULL,
  `start` DATE NULL,
  `end` DATE NULL,
  `reason` VARCHAR(250) NULL,
  INDEX `fk_leave_staff1_idx` (`staff_id` ASC),
  PRIMARY KEY (`id_leave`),
  CONSTRAINT `fk_leave_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `empire`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`interview_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`interview_address` ;

CREATE TABLE IF NOT EXISTS `empire`.`interview_address` (
  `idinterview_address` INT NOT NULL,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idinterview_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`interview`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`interview` ;

CREATE TABLE IF NOT EXISTS `empire`.`interview` (
  `idinterview` INT NOT NULL,
  `staff_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  `domain` VARCHAR(45) NULL,
  `interview_address_id` INT NOT NULL,
  PRIMARY KEY (`idinterview`, `interview_address_id`),
  INDEX `fk_interview_staff1_idx` (`staff_id` ASC),
  INDEX `fk_interview_interview_address1_idx` (`interview_address_id` ASC),
  CONSTRAINT `fk_interview_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `empire`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_interview_interview_address1`
    FOREIGN KEY (`interview_address_id`)
    REFERENCES `empire`.`interview_address` (`idinterview_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`recruit_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`recruit_address` ;

CREATE TABLE IF NOT EXISTS `empire`.`recruit_address` (
  `idrecruit_address` INT NOT NULL,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idrecruit_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`recruit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`recruit` ;

CREATE TABLE IF NOT EXISTS `empire`.`recruit` (
  `idrecruit` INT NOT NULL,
  `interview_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `applied_for` VARCHAR(45) NULL,
  `file` VARCHAR(1024) NULL,
  `date_applied` DATE NULL,
  `recruit_address_id` INT NOT NULL,
  PRIMARY KEY (`idrecruit`, `user_id`),
  INDEX `fk_recruit_interview1_idx` (`interview_id` ASC),
  INDEX `fk_recruit_user1_idx` (`user_id` ASC),
  INDEX `fk_recruit_recruit_address1_idx` (`recruit_address_id` ASC),
  CONSTRAINT `fk_recruit_interview1`
    FOREIGN KEY (`interview_id`)
    REFERENCES `empire`.`interview` (`idinterview`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recruit_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `empire`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recruit_recruit_address1`
    FOREIGN KEY (`recruit_address_id`)
    REFERENCES `empire`.`recruit_address` (`idrecruit_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`course`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`course` ;

CREATE TABLE IF NOT EXISTS `empire`.`course` (
  `idcourse` INT NOT NULL,
  `recruit_id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(250) NULL,
  `year` DATE NULL,
  PRIMARY KEY (`idcourse`),
  INDEX `fk_course_recruit1_idx` (`recruit_id` ASC),
  CONSTRAINT `fk_course_recruit1`
    FOREIGN KEY (`recruit_id`)
    REFERENCES `empire`.`recruit` (`idrecruit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`class` ;

CREATE TABLE IF NOT EXISTS `empire`.`class` (
  `idclass` INT NOT NULL,
  `building` VARCHAR(45) NULL,
  `level` INT NULL,
  PRIMARY KEY (`idclass`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`student_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`student_address` ;

CREATE TABLE IF NOT EXISTS `empire`.`student_address` (
  `idstudent_address` INT NOT NULL,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idstudent_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`student`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`student` ;

CREATE TABLE IF NOT EXISTS `empire`.`student` (
  `idstudent` INT NOT NULL,
  `user_iduser` INT NOT NULL,
  `semester` INT NULL,
  `phone` VARCHAR(45) NULL,
  `date_registered` DATE NULL,
  `date_left` DATE NULL,
  `student_address_id` INT NOT NULL,
  PRIMARY KEY (`idstudent`, `user_iduser`),
  INDEX `fk_student_user1_idx` (`user_iduser` ASC),
  INDEX `fk_student_student_address1_idx` (`student_address_id` ASC),
  CONSTRAINT `fk_student_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `empire`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_student_address1`
    FOREIGN KEY (`student_address_id`)
    REFERENCES `empire`.`student_address` (`idstudent_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`student_module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`student_module` ;

CREATE TABLE IF NOT EXISTS `empire`.`student_module` (
  `idstudent_module` INT NOT NULL,
  `date_enrolled` DATE NULL,
  `student_id` INT NOT NULL,
  `student_user_id` INT NOT NULL,
  PRIMARY KEY (`idstudent_module`),
  INDEX `fk_student_module_student1_idx` (`student_id` ASC, `student_user_id` ASC),
  CONSTRAINT `fk_student_module_student1`
    FOREIGN KEY (`student_id` , `student_user_id`)
    REFERENCES `empire`.`student` (`idstudent` , `user_iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`module` ;

CREATE TABLE IF NOT EXISTS `empire`.`module` (
  `idmodule` INT NOT NULL,
  `class_id` INT NOT NULL,
  `code` VARCHAR(45) NULL,
  `semester` INT NULL,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(250) NULL,
  `year` DATE NULL,
  `student_module_id` INT NOT NULL,
  PRIMARY KEY (`idmodule`),
  INDEX `fk_module_class1_idx` (`class_id` ASC),
  INDEX `fk_module_student_module1_idx` (`student_module_id` ASC),
  CONSTRAINT `fk_module_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `empire`.`class` (`idclass`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_module_student_module1`
    FOREIGN KEY (`student_module_id`)
    REFERENCES `empire`.`student_module` (`idstudent_module`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`lecturer_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`lecturer_address` ;

CREATE TABLE IF NOT EXISTS `empire`.`lecturer_address` (
  `idlecturer_address` INT NOT NULL,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idlecturer_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`lecturer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`lecturer` ;

CREATE TABLE IF NOT EXISTS `empire`.`lecturer` (
  `idlecturer` INT NOT NULL,
  `phone` VARCHAR(45) NULL,
  `date_joined` DATE NULL,
  `date_left` DATE NULL,
  `lecturer_address_id` INT NOT NULL,
  PRIMARY KEY (`idlecturer`),
  INDEX `fk_lecturer_lecturer_address1_idx` (`lecturer_address_id` ASC),
  CONSTRAINT `fk_lecturer_lecturer_address1`
    FOREIGN KEY (`lecturer_address_id`)
    REFERENCES `empire`.`lecturer_address` (`idlecturer_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`course_module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`course_module` ;

CREATE TABLE IF NOT EXISTS `empire`.`course_module` (
  `idcourse_module` INT NOT NULL,
  `module_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `lecturer_id` INT NOT NULL,
  PRIMARY KEY (`idcourse_module`),
  INDEX `fk_course_module_module1_idx` (`module_id` ASC),
  INDEX `fk_course_module_course1_idx` (`course_id` ASC),
  INDEX `fk_course_module_lecturer1_idx` (`lecturer_id` ASC),
  CONSTRAINT `fk_course_module_module1`
    FOREIGN KEY (`module_id`)
    REFERENCES `empire`.`module` (`idmodule`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_module_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `empire`.`course` (`idcourse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_module_lecturer1`
    FOREIGN KEY (`lecturer_id`)
    REFERENCES `empire`.`lecturer` (`idlecturer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`module_cost`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`module_cost` ;

CREATE TABLE IF NOT EXISTS `empire`.`module_cost` (
  `idmodule_cost` INT NOT NULL,
  `cost` FLOAT NULL,
  PRIMARY KEY (`idmodule_cost`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`student_payment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`student_payment` ;

CREATE TABLE IF NOT EXISTS `empire`.`student_payment` (
  `idstudent_payment` INT NOT NULL,
  `student_id` INT NOT NULL,
  `module_cost_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  `payment_type` VARCHAR(45) NULL,
  PRIMARY KEY (`idstudent_payment`),
  INDEX `fk_student_payment_student1_idx` (`student_id` ASC),
  INDEX `fk_student_payment_module_cost1_idx` (`module_cost_id` ASC),
  CONSTRAINT `fk_student_payment_student1`
    FOREIGN KEY (`student_id`)
    REFERENCES `empire`.`student` (`idstudent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_payment_module_cost1`
    FOREIGN KEY (`module_cost_id`)
    REFERENCES `empire`.`module_cost` (`idmodule_cost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`class_date`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`class_date` ;

CREATE TABLE IF NOT EXISTS `empire`.`class_date` (
  `idclass_date` INT NOT NULL,
  `student_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  PRIMARY KEY (`idclass_date`),
  INDEX `fk_class_date_student1_idx` (`student_id` ASC),
  INDEX `fk_class_date_class1_idx` (`class_id` ASC),
  CONSTRAINT `fk_class_date_student1`
    FOREIGN KEY (`student_id`)
    REFERENCES `empire`.`student` (`idstudent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_class_date_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `empire`.`class` (`idclass`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`student_attendance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`student_attendance` ;

CREATE TABLE IF NOT EXISTS `empire`.`student_attendance` (
  `idstudent_attendance` INT NOT NULL,
  `class_id` INT NOT NULL,
  `student_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  PRIMARY KEY (`idstudent_attendance`),
  INDEX `fk_student_attendance_class1_idx` (`class_id` ASC),
  INDEX `fk_student_attendance_student1_idx` (`student_id` ASC),
  CONSTRAINT `fk_student_attendance_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `empire`.`class` (`idclass`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_attendance_student1`
    FOREIGN KEY (`student_id`)
    REFERENCES `empire`.`student` (`idstudent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`employer_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`employer_address` ;

CREATE TABLE IF NOT EXISTS `empire`.`employer_address` (
  `idemployer_address` INT NOT NULL,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idemployer_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`employer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`employer` ;

CREATE TABLE IF NOT EXISTS `empire`.`employer` (
  `idemployer` INT NOT NULL,
  `user_id` INT NOT NULL,
  `company` VARCHAR(45) NULL,
  `position` VARCHAR(45) NULL,
  `date_joined` DATE NULL,
  `date_left` DATE NULL,
  `employer_address_id` INT NOT NULL,
  PRIMARY KEY (`idemployer`, `user_id`, `employer_address_id`),
  INDEX `fk_employer_user1_idx` (`user_id` ASC),
  INDEX `fk_employer_employer_address1_idx` (`employer_address_id` ASC),
  CONSTRAINT `fk_employer_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `empire`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_employer_employer_address1`
    FOREIGN KEY (`employer_address_id`)
    REFERENCES `empire`.`employer_address` (`idemployer_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`employer_notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`employer_notification` ;

CREATE TABLE IF NOT EXISTS `empire`.`employer_notification` (
  `idnotification` INT NOT NULL,
  `employer_id` INT NOT NULL,
  `description` VARCHAR(250) NULL,
  `date_time` DATETIME NULL,
  PRIMARY KEY (`idnotification`),
  INDEX `fk_notification_employer1_idx` (`employer_id` ASC),
  CONSTRAINT `fk_notification_employer1`
    FOREIGN KEY (`employer_id`)
    REFERENCES `empire`.`employer` (`idemployer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`feedback`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`feedback` ;

CREATE TABLE IF NOT EXISTS `empire`.`feedback` (
  `idfeedback` INT NOT NULL,
  `employer_id` INT NOT NULL,
  `description` VARCHAR(250) NULL,
  `date` DATE NULL,
  `time` DATETIME NULL,
  PRIMARY KEY (`idfeedback`),
  INDEX `fk_feedback_employer1_idx` (`employer_id` ASC),
  CONSTRAINT `fk_feedback_employer1`
    FOREIGN KEY (`employer_id`)
    REFERENCES `empire`.`employer` (`idemployer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`employer_report`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`employer_report` ;

CREATE TABLE IF NOT EXISTS `empire`.`employer_report` (
  `idemployee_report` INT NOT NULL,
  `employer_id` INT NOT NULL,
  `description` VARCHAR(250) NULL,
  `date` DATE NULL,
  PRIMARY KEY (`idemployee_report`, `employer_id`),
  INDEX `fk_employee_report_employer1_idx` (`employer_id` ASC),
  CONSTRAINT `fk_employee_report_employer1`
    FOREIGN KEY (`employer_id`)
    REFERENCES `empire`.`employer` (`idemployer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`employee`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`employee` ;

CREATE TABLE IF NOT EXISTS `empire`.`employee` (
  `idemployee` INT NOT NULL,
  `user_id` INT NOT NULL,
  `company` VARCHAR(45) NULL,
  `position` VARCHAR(45) NULL,
  `date_joined` DATE NULL,
  `date_left` DATE NULL,
  `user_iduser` INT NOT NULL,
  PRIMARY KEY (`idemployee`, `user_id`, `user_iduser`),
  INDEX `fk_employee_user1_idx` (`user_id` ASC),
  INDEX `fk_employee_user2_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_employee_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `empire`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_employee_user2`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `empire`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`trainer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`trainer` ;

CREATE TABLE IF NOT EXISTS `empire`.`trainer` (
  `idtrainer` INT NOT NULL,
  `phone` VARCHAR(45) NULL,
  `date_joined` DATE NULL,
  `date_left` DATE NULL,
  `expertise` VARCHAR(45) NULL,
  `user_iduser` INT NOT NULL,
  PRIMARY KEY (`idtrainer`, `user_iduser`),
  INDEX `fk_trainer_user1_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_trainer_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `empire`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`training`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`training` ;

CREATE TABLE IF NOT EXISTS `empire`.`training` (
  `idtraining` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `type` VARCHAR(45) NULL,
  `description` VARCHAR(250) NULL,
  `trainer_id` INT NOT NULL,
  PRIMARY KEY (`idtraining`, `trainer_id`),
  INDEX `fk_training_trainer1_idx` (`trainer_id` ASC),
  CONSTRAINT `fk_training_trainer1`
    FOREIGN KEY (`trainer_id`)
    REFERENCES `empire`.`trainer` (`idtrainer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`employee_training`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`employee_training` ;

CREATE TABLE IF NOT EXISTS `empire`.`employee_training` (
  `idemployee_training` INT NOT NULL,
  `training_id` INT NOT NULL,
  `employee_id` INT NOT NULL,
  `date_started` DATE NULL,
  `date_end` DATE NULL,
  PRIMARY KEY (`idemployee_training`),
  INDEX `fk_employee_training_training1_idx` (`training_id` ASC),
  INDEX `fk_employee_training_employee1_idx` (`employee_id` ASC),
  CONSTRAINT `fk_employee_training_training1`
    FOREIGN KEY (`training_id`)
    REFERENCES `empire`.`training` (`idtraining`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_employee_training_employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `empire`.`employee` (`idemployee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`training_material`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`training_material` ;

CREATE TABLE IF NOT EXISTS `empire`.`training_material` (
  `training_id` INT NOT NULL,
  `idtraining_material` INT NOT NULL,
  `type` VARCHAR(45) NULL,
  `date_created` DATE NULL,
  `name` VARCHAR(45) NULL,
  INDEX `fk_training_material_training1_idx` (`training_id` ASC),
  PRIMARY KEY (`idtraining_material`),
  CONSTRAINT `fk_training_material_training1`
    FOREIGN KEY (`training_id`)
    REFERENCES `empire`.`training` (`idtraining`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`employee_training_mat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`employee_training_mat` ;

CREATE TABLE IF NOT EXISTS `empire`.`employee_training_mat` (
  `idemployee_training_mat` INT NOT NULL,
  `employee_id` INT NOT NULL,
  `training_material_id` INT NOT NULL,
  `date_issued` DATE NULL,
  PRIMARY KEY (`idemployee_training_mat`, `employee_id`, `training_material_id`),
  INDEX `fk_employee_training_mat_employee1_idx` (`employee_id` ASC),
  INDEX `fk_employee_training_mat_training_material1_idx` (`training_material_id` ASC),
  CONSTRAINT `fk_employee_training_mat_employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `empire`.`employee` (`idemployee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_employee_training_mat_training_material1`
    FOREIGN KEY (`training_material_id`)
    REFERENCES `empire`.`training_material` (`idtraining_material`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`training_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`training_address` ;

CREATE TABLE IF NOT EXISTS `empire`.`training_address` (
  `idtraining_address` INT NOT NULL,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `training_id` INT NOT NULL,
  PRIMARY KEY (`idtraining_address`, `training_id`),
  INDEX `fk_training_address_training1_idx` (`training_id` ASC),
  CONSTRAINT `fk_training_address_training1`
    FOREIGN KEY (`training_id`)
    REFERENCES `empire`.`training` (`idtraining`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire`.`trainer_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire`.`trainer_address` ;

CREATE TABLE IF NOT EXISTS `empire`.`trainer_address` (
  `idtrainer_address` INT NOT NULL,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `trainer_idtrainer` INT NOT NULL,
  PRIMARY KEY (`idtrainer_address`),
  INDEX `fk_trainer_address_trainer1_idx` (`trainer_idtrainer` ASC),
  CONSTRAINT `fk_trainer_address_trainer1`
    FOREIGN KEY (`trainer_idtrainer`)
    REFERENCES `empire`.`trainer` (`idtrainer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
