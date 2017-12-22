-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema empire_portal
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema empire_portal
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `empire_portal` DEFAULT CHARACTER SET utf8 ;
USE `empire_portal` ;

-- -----------------------------------------------------
-- Table `empire_portal`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`user` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`user` (
  `iduser` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(1024) NULL,
  `type` VARCHAR(45) NULL,
  `remember_token` VARCHAR(1024) NULL,
  `image` VARCHAR(1024) NULL,
  PRIMARY KEY (`iduser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`branch_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`branch_address` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`branch_address` (
  `idbranch_address` INT NOT NULL AUTO_INCREMENT,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idbranch_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`branch`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`branch` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`branch` (
  `idbranch` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `branch_address_id` INT NOT NULL,
  PRIMARY KEY (`idbranch`, `branch_address_id`),
  INDEX `fk_branch_branch_address1_idx` (`branch_address_id` ASC),
  CONSTRAINT `fk_branch_branch_address1`
    FOREIGN KEY (`branch_address_id`)
    REFERENCES `empire_portal`.`branch_address` (`idbranch_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`staff_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`staff_address` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`staff_address` (
  `idstaff_address` INT NOT NULL AUTO_INCREMENT,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idstaff_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`staff`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`staff` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`staff` (
  `idstaff` INT NOT NULL AUTO_INCREMENT,
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
    REFERENCES `empire_portal`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_branch1`
    FOREIGN KEY (`branch_id`)
    REFERENCES `empire_portal`.`branch` (`idbranch`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_staff_address1`
    FOREIGN KEY (`staff_address_id`)
    REFERENCES `empire_portal`.`staff_address` (`idstaff_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`enquiry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`enquiry` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`enquiry` (
  `idenquiry` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  `description` VARCHAR(250) NULL,
  PRIMARY KEY (`idenquiry`),
  INDEX `fk_enquiry_staff_idx` (`staff_id` ASC),
  CONSTRAINT `fk_enquiry_staff`
    FOREIGN KEY (`staff_id`)
    REFERENCES `empire_portal`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`attendance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`attendance` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`attendance` (
  `staff_id` INT NOT NULL AUTO_INCREMENT,
  `date_time` DATETIME NULL,
  `photo` VARCHAR(1024) NULL,
  `id_attendance` INT NOT NULL,
  INDEX `fk_attendance_staff1_idx` (`staff_id` ASC),
  PRIMARY KEY (`id_attendance`),
  CONSTRAINT `fk_attendance_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `empire_portal`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`leave`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`leave` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`leave` (
  `staff_id` INT NOT NULL,
  `id_leave` INT NOT NULL,
  `start` DATE NULL,
  `end` DATE NULL,
  `reason` VARCHAR(250) NULL,
  INDEX `fk_leave_staff1_idx` (`staff_id` ASC),
  PRIMARY KEY (`id_leave`),
  CONSTRAINT `fk_leave_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `empire_portal`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`interview_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`interview_address` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`interview_address` (
  `idinterview_address` INT NOT NULL AUTO_INCREMENT,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idinterview_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`interview`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`interview` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`interview` (
  `idinterview` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  `domain` VARCHAR(45) NULL,
  `interview_address_id` INT NOT NULL,
  PRIMARY KEY (`idinterview`, `interview_address_id`),
  INDEX `fk_interview_staff1_idx` (`staff_id` ASC),
  INDEX `fk_interview_interview_address1_idx` (`interview_address_id` ASC),
  CONSTRAINT `fk_interview_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `empire_portal`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_interview_interview_address1`
    FOREIGN KEY (`interview_address_id`)
    REFERENCES `empire_portal`.`interview_address` (`idinterview_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`recruit_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`recruit_address` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`recruit_address` (
  `idrecruit_address` INT NOT NULL AUTO_INCREMENT,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idrecruit_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`employee`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`employee` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`employee` (
  `idemployee` INT NOT NULL,
  `user_id` INT NOT NULL,
  `company` VARCHAR(45) NULL,
  `position` VARCHAR(45) NULL,
  `user_iduser` INT NOT NULL,
  PRIMARY KEY (`idemployee`, `user_id`, `user_iduser`),
  INDEX `fk_employee_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_employee_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `empire_portal`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`recruit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`recruit` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`recruit` (
  `idrecruit` INT NOT NULL AUTO_INCREMENT,
  `interview_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `applied_for` VARCHAR(45) NULL,
  `file` VARCHAR(1024) NULL,
  `date_applied` DATE NULL,
  `recruit_address_id` INT NOT NULL,
  `employee_id` INT NOT NULL,
  PRIMARY KEY (`idrecruit`, `user_id`),
  INDEX `fk_recruit_interview1_idx` (`interview_id` ASC),
  INDEX `fk_recruit_user1_idx` (`user_id` ASC),
  INDEX `fk_recruit_recruit_address1_idx` (`recruit_address_id` ASC),
  INDEX `fk_recruit_employee1_idx` (`employee_id` ASC),
  CONSTRAINT `fk_recruit_interview1`
    FOREIGN KEY (`interview_id`)
    REFERENCES `empire_portal`.`interview` (`idinterview`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recruit_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `empire_portal`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recruit_recruit_address1`
    FOREIGN KEY (`recruit_address_id`)
    REFERENCES `empire_portal`.`recruit_address` (`idrecruit_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_recruit_employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `empire_portal`.`employee` (`idemployee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`course`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`course` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`course` (
  `idcourse` INT NOT NULL AUTO_INCREMENT,
  `recruit_id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(250) NULL,
  `year` DATE NULL,
  PRIMARY KEY (`idcourse`),
  INDEX `fk_course_recruit1_idx` (`recruit_id` ASC),
  CONSTRAINT `fk_course_recruit1`
    FOREIGN KEY (`recruit_id`)
    REFERENCES `empire_portal`.`recruit` (`idrecruit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`class` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`class` (
  `idclass` INT NOT NULL AUTO_INCREMENT,
  `building` VARCHAR(45) NULL,
  `level` INT NULL,
  PRIMARY KEY (`idclass`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`student_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`student_address` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`student_address` (
  `idstudent_address` INT NOT NULL AUTO_INCREMENT,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idstudent_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`student`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`student` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`student` (
  `idstudent` INT NOT NULL AUTO_INCREMENT,
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
    REFERENCES `empire_portal`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_student_address1`
    FOREIGN KEY (`student_address_id`)
    REFERENCES `empire_portal`.`student_address` (`idstudent_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`student_module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`student_module` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`student_module` (
  `idstudent_module` INT NOT NULL AUTO_INCREMENT,
  `date_enrolled` DATE NULL,
  `student_id` INT NOT NULL,
  `student_user_id` INT NOT NULL,
  PRIMARY KEY (`idstudent_module`),
  INDEX `fk_student_module_student1_idx` (`student_id` ASC, `student_user_id` ASC),
  CONSTRAINT `fk_student_module_student1`
    FOREIGN KEY (`student_id` , `student_user_id`)
    REFERENCES `empire_portal`.`student` (`idstudent` , `user_iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`module` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`module` (
  `idmodule` INT NOT NULL AUTO_INCREMENT,
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
    REFERENCES `empire_portal`.`class` (`idclass`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_module_student_module1`
    FOREIGN KEY (`student_module_id`)
    REFERENCES `empire_portal`.`student_module` (`idstudent_module`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`lecturer_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`lecturer_address` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`lecturer_address` (
  `idlecturer_address` INT NOT NULL AUTO_INCREMENT,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idlecturer_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`lecturer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`lecturer` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`lecturer` (
  `idlecturer` INT NOT NULL AUTO_INCREMENT,
  `phone` VARCHAR(45) NULL,
  `date_joined` DATE NULL,
  `date_left` DATE NULL,
  `lecturer_address_id` INT NOT NULL,
  `user_iduser` INT NOT NULL,
  PRIMARY KEY (`idlecturer`, `user_iduser`),
  INDEX `fk_lecturer_lecturer_address1_idx` (`lecturer_address_id` ASC),
  INDEX `fk_lecturer_user1_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_lecturer_lecturer_address1`
    FOREIGN KEY (`lecturer_address_id`)
    REFERENCES `empire_portal`.`lecturer_address` (`idlecturer_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lecturer_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `empire_portal`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`course_module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`course_module` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`course_module` (
  `idcourse_module` INT NOT NULL AUTO_INCREMENT,
  `module_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `lecturer_id` INT NOT NULL,
  PRIMARY KEY (`idcourse_module`),
  INDEX `fk_course_module_module1_idx` (`module_id` ASC),
  INDEX `fk_course_module_course1_idx` (`course_id` ASC),
  INDEX `fk_course_module_lecturer1_idx` (`lecturer_id` ASC),
  CONSTRAINT `fk_course_module_module1`
    FOREIGN KEY (`module_id`)
    REFERENCES `empire_portal`.`module` (`idmodule`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_module_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `empire_portal`.`course` (`idcourse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_module_lecturer1`
    FOREIGN KEY (`lecturer_id`)
    REFERENCES `empire_portal`.`lecturer` (`idlecturer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`module_cost`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`module_cost` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`module_cost` (
  `idmodule_cost` INT NOT NULL AUTO_INCREMENT,
  `cost` FLOAT NULL,
  PRIMARY KEY (`idmodule_cost`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`student_payment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`student_payment` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`student_payment` (
  `idstudent_payment` INT NOT NULL AUTO_INCREMENT,
  `student_id` INT NOT NULL,
  `module_cost_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  `payment_type` VARCHAR(45) NULL,
  PRIMARY KEY (`idstudent_payment`),
  INDEX `fk_student_payment_student1_idx` (`student_id` ASC),
  INDEX `fk_student_payment_module_cost1_idx` (`module_cost_id` ASC),
  CONSTRAINT `fk_student_payment_student1`
    FOREIGN KEY (`student_id`)
    REFERENCES `empire_portal`.`student` (`idstudent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_payment_module_cost1`
    FOREIGN KEY (`module_cost_id`)
    REFERENCES `empire_portal`.`module_cost` (`idmodule_cost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`class_date`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`class_date` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`class_date` (
  `idclass_date` INT NOT NULL AUTO_INCREMENT,
  `student_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  PRIMARY KEY (`idclass_date`),
  INDEX `fk_class_date_student1_idx` (`student_id` ASC),
  INDEX `fk_class_date_class1_idx` (`class_id` ASC),
  CONSTRAINT `fk_class_date_student1`
    FOREIGN KEY (`student_id`)
    REFERENCES `empire_portal`.`student` (`idstudent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_class_date_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `empire_portal`.`class` (`idclass`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`student_attendance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`student_attendance` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`student_attendance` (
  `idstudent_attendance` INT NOT NULL AUTO_INCREMENT,
  `class_id` INT NOT NULL,
  `student_id` INT NOT NULL,
  `date_time` DATETIME NULL,
  PRIMARY KEY (`idstudent_attendance`),
  INDEX `fk_student_attendance_class1_idx` (`class_id` ASC),
  INDEX `fk_student_attendance_student1_idx` (`student_id` ASC),
  CONSTRAINT `fk_student_attendance_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `empire_portal`.`class` (`idclass`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_attendance_student1`
    FOREIGN KEY (`student_id`)
    REFERENCES `empire_portal`.`student` (`idstudent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`employer_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`employer_address` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`employer_address` (
  `idemployer_address` INT NOT NULL AUTO_INCREMENT,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  PRIMARY KEY (`idemployer_address`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`employer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`employer` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`employer` (
  `idemployer` INT NOT NULL AUTO_INCREMENT,
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
    REFERENCES `empire_portal`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_employer_employer_address1`
    FOREIGN KEY (`employer_address_id`)
    REFERENCES `empire_portal`.`employer_address` (`idemployer_address`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`employer_notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`employer_notification` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`employer_notification` (
  `idnotification` INT NOT NULL AUTO_INCREMENT,
  `employer_id` INT NOT NULL,
  `description` VARCHAR(250) NULL,
  `date_time` DATETIME NULL,
  PRIMARY KEY (`idnotification`),
  INDEX `fk_notification_employer1_idx` (`employer_id` ASC),
  CONSTRAINT `fk_notification_employer1`
    FOREIGN KEY (`employer_id`)
    REFERENCES `empire_portal`.`employer` (`idemployer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`feedback`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`feedback` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`feedback` (
  `idfeedback` INT NOT NULL AUTO_INCREMENT,
  `employer_id` INT NOT NULL,
  `description` VARCHAR(250) NULL,
  `date` DATE NULL,
  `time` DATETIME NULL,
  PRIMARY KEY (`idfeedback`),
  INDEX `fk_feedback_employer1_idx` (`employer_id` ASC),
  CONSTRAINT `fk_feedback_employer1`
    FOREIGN KEY (`employer_id`)
    REFERENCES `empire_portal`.`employer` (`idemployer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`employer_report`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`employer_report` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`employer_report` (
  `idemployee_report` INT NOT NULL AUTO_INCREMENT,
  `employer_id` INT NOT NULL,
  `description` VARCHAR(250) NULL,
  `date` DATE NULL,
  PRIMARY KEY (`idemployee_report`, `employer_id`),
  INDEX `fk_employee_report_employer1_idx` (`employer_id` ASC),
  CONSTRAINT `fk_employee_report_employer1`
    FOREIGN KEY (`employer_id`)
    REFERENCES `empire_portal`.`employer` (`idemployer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`trainer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`trainer` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`trainer` (
  `idtrainer` INT NOT NULL AUTO_INCREMENT,
  `phone` VARCHAR(45) NULL,
  `date_joined` DATE NULL,
  `date_left` DATE NULL,
  `expertise` VARCHAR(45) NULL,
  `user_iduser` INT NOT NULL,
  PRIMARY KEY (`idtrainer`, `user_iduser`),
  INDEX `fk_trainer_user1_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_trainer_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `empire_portal`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`training`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`training` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`training` (
  `idtraining` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `type` VARCHAR(45) NULL,
  `description` VARCHAR(250) NULL,
  `trainer_id` INT NOT NULL,
  PRIMARY KEY (`idtraining`, `trainer_id`),
  INDEX `fk_training_trainer1_idx` (`trainer_id` ASC),
  CONSTRAINT `fk_training_trainer1`
    FOREIGN KEY (`trainer_id`)
    REFERENCES `empire_portal`.`trainer` (`idtrainer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`employee_training`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`employee_training` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`employee_training` (
  `idemployee_training` INT NOT NULL AUTO_INCREMENT,
  `training_id` INT NOT NULL,
  `employee_id` INT NOT NULL,
  `date_started` DATE NULL,
  `date_end` DATE NULL,
  PRIMARY KEY (`idemployee_training`),
  INDEX `fk_employee_training_training1_idx` (`training_id` ASC),
  INDEX `fk_employee_training_employee1_idx` (`employee_id` ASC),
  CONSTRAINT `fk_employee_training_training1`
    FOREIGN KEY (`training_id`)
    REFERENCES `empire_portal`.`training` (`idtraining`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_employee_training_employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `empire_portal`.`employee` (`idemployee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`training_material`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`training_material` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`training_material` (
  `training_id` INT NOT NULL AUTO_INCREMENT,
  `idtraining_material` INT NOT NULL,
  `type` VARCHAR(45) NULL,
  `date_created` DATE NULL,
  `name` VARCHAR(45) NULL,
  INDEX `fk_training_material_training1_idx` (`training_id` ASC),
  PRIMARY KEY (`idtraining_material`),
  CONSTRAINT `fk_training_material_training1`
    FOREIGN KEY (`training_id`)
    REFERENCES `empire_portal`.`training` (`idtraining`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`employee_training_mat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`employee_training_mat` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`employee_training_mat` (
  `idemployee_training_mat` INT NOT NULL AUTO_INCREMENT,
  `employee_id` INT NOT NULL,
  `training_material_id` INT NOT NULL,
  `date_issued` DATE NULL,
  PRIMARY KEY (`idemployee_training_mat`, `employee_id`, `training_material_id`),
  INDEX `fk_employee_training_mat_employee1_idx` (`employee_id` ASC),
  INDEX `fk_employee_training_mat_training_material1_idx` (`training_material_id` ASC),
  CONSTRAINT `fk_employee_training_mat_employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `empire_portal`.`employee` (`idemployee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_employee_training_mat_training_material1`
    FOREIGN KEY (`training_material_id`)
    REFERENCES `empire_portal`.`training_material` (`idtraining_material`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`training_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`training_address` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`training_address` (
  `idtraining_address` INT NOT NULL AUTO_INCREMENT,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `training_id` INT NOT NULL,
  PRIMARY KEY (`idtraining_address`, `training_id`),
  INDEX `fk_training_address_training1_idx` (`training_id` ASC),
  CONSTRAINT `fk_training_address_training1`
    FOREIGN KEY (`training_id`)
    REFERENCES `empire_portal`.`training` (`idtraining`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`trainer_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`trainer_address` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`trainer_address` (
  `idtrainer_address` INT NOT NULL AUTO_INCREMENT,
  `postcode` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `trainer_idtrainer` INT NOT NULL,
  PRIMARY KEY (`idtrainer_address`),
  INDEX `fk_trainer_address_trainer1_idx` (`trainer_idtrainer` ASC),
  CONSTRAINT `fk_trainer_address_trainer1`
    FOREIGN KEY (`trainer_idtrainer`)
    REFERENCES `empire_portal`.`trainer` (`idtrainer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `empire_portal`.`employment_history`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `empire_portal`.`employment_history` ;

CREATE TABLE IF NOT EXISTS `empire_portal`.`employment_history` (
  `idemployment_history` INT NOT NULL AUTO_INCREMENT,
  `status` VARCHAR(45) NULL,
  `employer_id` INT NOT NULL,
  `employee_id` INT NOT NULL,
  `date_joined` DATE NULL,
  `date_left` DATE NULL,
  PRIMARY KEY (`idemployment_history`),
  INDEX `fk_employment_history_employer1_idx` (`employer_id` ASC),
  INDEX `fk_employment_history_employee1_idx` (`employee_id` ASC),
  CONSTRAINT `fk_employment_history_employer1`
    FOREIGN KEY (`employer_id`)
    REFERENCES `empire_portal`.`employer` (`idemployer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_employment_history_employee1`
    FOREIGN KEY (`employee_id`)
    REFERENCES `empire_portal`.`employee` (`idemployee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO `user` (`iduser`, `name`, `email`, `password`, `type`, `remember_token`, `image`) VALUES ('1', 'Rahman', 'admin@empire.com', '$2a$12$7UxAwve2XBy8Or567CcTPeygiMLUHuu7xx.j8N.LH.4ki0tjaaKz6', NULL, NULL, NULL);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
