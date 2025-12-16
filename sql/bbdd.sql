-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Formacombook
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Formacombook
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Formacombook` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
USE `Formacombook` ;

-- -----------------------------------------------------
-- Table `Formacombook`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Formacombook`.`usuarios` (
  `usuarios_id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `avatar` VARCHAR(255) NULL,
  `bio` TEXT NULL,
  `fecha_registro` DATETIME NULL DEFAULT now(),
  PRIMARY KEY (`usuarios_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Formacombook`.`fotos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Formacombook`.`fotos` (
  `fotos_id` INT NOT NULL AUTO_INCREMENT,
  `usuarios_id` INT NOT NULL,
  `titulo` VARCHAR(255) NULL,
  `descripcion` TEXT NULL,
  `ruta` VARCHAR(255) NULL,
  `fecha_subida` DATETIME NULL DEFAULT now(),
  PRIMARY KEY (`fotos_id`),
  INDEX `fk_fotos_usuarios_idx` (`usuarios_id` ASC) ,
  CONSTRAINT `fk_fotos_usuarios`
    FOREIGN KEY (`usuarios_id`)
    REFERENCES `Formacombook`.`usuarios` (`usuarios_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Formacombook`.`votos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Formacombook`.`votos` (
  `usuarios_id` INT NOT NULL,
  `fotos_id` INT NOT NULL,
  `fecha_voto` DATETIME NULL DEFAULT now(),
  PRIMARY KEY (`usuarios_id`, `fotos_id`),
  INDEX `fk_usuarios_has_fotos_fotos1_idx` (`fotos_id` ASC) ,
  INDEX `fk_usuarios_has_fotos_usuarios1_idx` (`usuarios_id` ASC) ,
  CONSTRAINT `fk_usuarios_has_fotos_usuarios1`
    FOREIGN KEY (`usuarios_id`)
    REFERENCES `Formacombook`.`usuarios` (`usuarios_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_usuarios_has_fotos_fotos1`
    FOREIGN KEY (`fotos_id`)
    REFERENCES `Formacombook`.`fotos` (`fotos_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
