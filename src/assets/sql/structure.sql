-- MySQL Script generated by MySQL Workbench
-- Mon Oct  7 23:21:15 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';


-- -----------------------------------------------------
-- Table `cm_settings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `value` TEXT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_colleges`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_colleges` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `en_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

INSERT INTO `cm_colleges` (`id`, `name`, `en_name`) VALUES ('1', '致新书院', 'ZhiXin College');

-- -----------------------------------------------------
-- Table `cm_privileges`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_privileges` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `secretary` INT NOT NULL DEFAULT 0,
  `teaching_affairs_department` INT NOT NULL DEFAULT 0,
  `mentor` INT NOT NULL DEFAULT 0,
  `student` INT NOT NULL DEFAULT 0,
  `visitor` INT NOT NULL DEFAULT 0,
  `system_configs` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

INSERT INTO `cm_privileges` (`id`, `name`, `secretary`, `teaching_affairs_department`, `mentor`, `student`, `visitor`, `system_configs`) VALUES ('1', 'admin_8c6fc01', '20', '20', '20', '20', '20', '20');
INSERT INTO `cm_privileges` (`id`, `name`, `secretary`, `teaching_affairs_department`, `mentor`, `student`, `visitor`, `system_configs`) VALUES ('2', 'secretary_75bcd15', '20', '0', '0', '0', '20', '0');
INSERT INTO `cm_privileges` (`id`, `name`, `secretary`, `teaching_affairs_department`, `mentor`, `student`, `visitor`, `system_configs`) VALUES ('3', 'student_3ade68b1', '0', '0', '0', '20', '20', '0');

-- -----------------------------------------------------
-- Table `cm_majors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_majors` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `en_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

INSERT INTO `cm_majors` (`id`, `name`, `en_name`) VALUES ('1', '计算机科学', 'Computer Science');

-- -----------------------------------------------------
-- Table `cm_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  `cas_hash_id` VARCHAR(45) NULL,
  `cas_sid` VARCHAR(45) NULL,
  `id_colleges` INT NOT NULL,
  `id_privileges` INT NOT NULL,
  `id_majors` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cm_users_cm_colleges_idx` (`id_colleges` ASC),
  INDEX `fk_cm_users_cm_privileges_copy11_idx` (`id_privileges` ASC),
  INDEX `fk_cm_users_cm_majors_idx` (`id_majors` ASC),
  CONSTRAINT `fk_cm_users_cm_colleges`
    FOREIGN KEY (`id_colleges`)
    REFERENCES `cm_colleges` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_users_cm_privileges_copy11`
    FOREIGN KEY (`id_privileges`)
    REFERENCES `cm_privileges` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_users_cm_majors_idx`
    FOREIGN KEY (`id_majors`)
    REFERENCES `cm_majors` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `cm_user_settings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_user_settings` (
  `id_users` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `language` VARCHAR(45) NOT NULL DEFAULT 'english',
  PRIMARY KEY (`id_users`),
  INDEX `fk_cm_users_cm_user_settings_idx` (`id_users` ASC),
  CONSTRAINT `fk_cm_users_cm_user_settings_idx`
    FOREIGN KEY (`id_users`)
    REFERENCES `cm_users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_departments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_departments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `en_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_courses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `en_name` VARCHAR(45) NOT NULL,
  `code` VARCHAR(45) NOT NULL,
  `id_departments` INT NOT NULL,
  `credit` FLOAT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `course_code_UNIQUE` (`code` ASC),
  INDEX `fk_cm_courses_cm_departments1_idx` (`id_departments` ASC),
  CONSTRAINT `fk_cm_courses_cm_departments1`
    FOREIGN KEY (`id_departments`)
    REFERENCES `cm_departments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_users_departments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_users_departments` (
  `id_departments` INT NOT NULL,
  `id_users` INT NOT NULL,
  INDEX `fk_cm_user_department_cm_departments1_idx` (`id_departments` ASC),
  INDEX `fk_cm_user_department_cm_users1_idx` (`id_users` ASC),
  PRIMARY KEY (`id_departments`, `id_users`),
  CONSTRAINT `fk_cm_user_department_cm_departments1`
    FOREIGN KEY (`id_departments`)
    REFERENCES `cm_departments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_user_department_cm_users1`
    FOREIGN KEY (`id_users`)
    REFERENCES `cm_users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_users_majors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_users_majors` (
  `id_majors` INT NOT NULL,
  `id_user` INT NOT NULL,
  INDEX `fk_cm_user_major_cm_majors1_idx` (`id_majors` ASC),
  INDEX `fk_cm_user_major_cm_users1_idx` (`id_user` ASC),
  PRIMARY KEY (`id_majors`, `id_user`),
  CONSTRAINT `fk_cm_user_major_cm_majors1`
    FOREIGN KEY (`id_majors`)
    REFERENCES `cm_majors` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_user_major_cm_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `cm_users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_prerequisites`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_prerequisites` (
  `id_main_course` INT NOT NULL,
  `id_pre_course` INT NOT NULL,
  `type` INT NOT NULL,
  INDEX `fk_cm_prerequisites_cm_courses1_idx` (`id_main_course` ASC),
  INDEX `fk_cm_prerequisites_cm_courses2_idx` (`id_pre_course` ASC),
  PRIMARY KEY (`id_main_course`, `id_pre_course`),
  CONSTRAINT `fk_cm_prerequisites_cm_courses1`
    FOREIGN KEY (`id_main_course`)
    REFERENCES `cm_courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_prerequisites_cm_courses2`
    FOREIGN KEY (`id_pre_course`)
    REFERENCES `cm_courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_courschemas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_courschemas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `en_name` VARCHAR(45) NOT NULL,
  `hash_id` VARCHAR(45) NOT NULL,
  `description` VARCHAR(45) NULL,
  `id_majors` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cm_courschemas_cm_majors1_idx` (`id_majors` ASC),
  CONSTRAINT `fk_cm_courschemas_cm_majors1`
    FOREIGN KEY (`id_majors`)
    REFERENCES `cm_majors` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `hash_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_types` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_courschemas_groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_courschemas_groups` (
  `id_groups` INT NOT NULL,
  `id_courschemas` INT NOT NULL,
  `id_types` INT NOT NULL,
  INDEX `fk_cm_courschemas_groups_cm_groups1_idx` (`id_groups` ASC),
  INDEX `fk_cm_courschemas_groups_cm_courschemas1_idx` (`id_courschemas` ASC),
  PRIMARY KEY (`id_groups`, `id_courschemas`),
  INDEX `fk_cm_courschemas_groups_cm_types1_idx` (`id_types` ASC),
  CONSTRAINT `fk_cm_courschemas_groups_cm_groups1`
    FOREIGN KEY (`id_groups`)
    REFERENCES `cm_groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_courschemas_groups_cm_courschemas1`
    FOREIGN KEY (`id_courschemas`)
    REFERENCES `cm_courschemas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_courschemas_groups_cm_types1`
    FOREIGN KEY (`id_types`)
    REFERENCES `cm_types` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_groups_courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_groups_courses` (
  `id_groups` INT NOT NULL,
  `id_courses` INT NOT NULL,
  INDEX `fk_cm_groups_courses_cm_groups1_idx` (`id_groups` ASC),
  INDEX `fk_cm_groups_courses_cm_courses1_idx` (`id_courses` ASC),
  PRIMARY KEY (`id_groups`, `id_courses`),
  CONSTRAINT `fk_cm_groups_courses_cm_groups1`
    FOREIGN KEY (`id_groups`)
    REFERENCES `cm_groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_groups_courses_cm_courses1`
    FOREIGN KEY (`id_courses`)
    REFERENCES `cm_courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_plans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_plans` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_plans_couses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_plans_couses` (
  `id_plans` INT NOT NULL,
  `id_courses` INT NOT NULL,
  INDEX `fk_cm_plans_couses_cm_plans1_idx` (`id_plans` ASC),
  INDEX `fk_cm_plans_couses_cm_courses1_idx` (`id_courses` ASC),
  PRIMARY KEY (`id_plans`, `id_courses`),
  CONSTRAINT `fk_cm_plans_couses_cm_plans1`
    FOREIGN KEY (`id_plans`)
    REFERENCES `cm_plans` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_plans_couses_cm_courses1`
    FOREIGN KEY (`id_courses`)
    REFERENCES `cm_courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cm_users_plans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cm_users_plans` (
  `id_plans` INT NOT NULL,
  `id_colleges` INT NOT NULL,
  INDEX `fk_cm_users_plans_cm_plans1_idx` (`id_plans` ASC),
  INDEX `fk_cm_users_plans_cm_colleges1_idx` (`id_colleges` ASC),
  PRIMARY KEY (`id_plans`, `id_colleges`),
  CONSTRAINT `fk_cm_users_plans_cm_plans1`
    FOREIGN KEY (`id_plans`)
    REFERENCES `cm_plans` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cm_users_plans_cm_colleges1`
    FOREIGN KEY (`id_colleges`)
    REFERENCES `cm_colleges` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
