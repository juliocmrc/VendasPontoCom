-- MySQL Script generated by MySQL Workbench
-- Wed Jun 22 11:13:06 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema VendasPontoCom
-- -----------------------------------------------------
-- Bando de dados do sistema de vendas na web.

-- -----------------------------------------------------
-- Schema VendasPontoCom
--
-- Bando de dados do sistema de vendas na web.
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `VendasPontoCom` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `VendasPontoCom` ;

-- -----------------------------------------------------
-- Table `VendasPontoCom`.`Produtos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VendasPontoCom`.`Produtos` ;

CREATE TABLE IF NOT EXISTS `VendasPontoCom`.`Produtos` (
  `prodId` INT NOT NULL AUTO_INCREMENT,
  `prodNome` VARCHAR(45) NOT NULL,
  `prodDescricao` VARCHAR(500) NOT NULL,
  `prodValor` FLOAT NOT NULL,
  `prodQtdeEmEstoque` INT NOT NULL,
  PRIMARY KEY (`prodId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `VendasPontoCom`.`Clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VendasPontoCom`.`Clientes` ;

CREATE TABLE IF NOT EXISTS `VendasPontoCom`.`Clientes` (
  `clieCPF` VARCHAR(11) NOT NULL,
  `clieNome` VARCHAR(45) NOT NULL,
  `clieEndereco` VARCHAR(100) NOT NULL,
  `clieComplementoDoEndereco` VARCHAR(30) NULL,
  `clieUF` VARCHAR(2) NOT NULL,
  `clieCidade` VARCHAR(45) NOT NULL,
  `clieCEP` VARCHAR(8) NOT NULL,
  `clieFone` VARCHAR(15) NOT NULL,
  `clieDataDeNascimento` DATE NOT NULL,
  `clieEmail` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`clieCPF`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `VendasPontoCom`.`CarrinhoDeCompras`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VendasPontoCom`.`CarrinhoDeCompras` ;

CREATE TABLE IF NOT EXISTS `VendasPontoCom`.`CarrinhoDeCompras` (
  `carrClieCPF` VARCHAR(11) NOT NULL,
  `carrProdId` INT NOT NULL,
  `carrQtdeProduto` INT NOT NULL,
  `carrData` DATETIME NOT NULL,
  PRIMARY KEY (`carrClieCPF`, `carrProdId`),
--  INDEX `fk_Clientes_has_Produtos_Produtos2_idx` (`carrProdId` ASC) VISIBLE,
--  INDEX `fk_Clientes_has_Produtos_Clientes1_idx` (`carrClieCPF` ASC) VISIBLE,
  CONSTRAINT `fk_Clientes_has_Produtos_Clientes1`
    FOREIGN KEY (`carrClieCPF`)
    REFERENCES `VendasPontoCom`.`Clientes` (`clieCPF`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Clientes_has_Produtos_Produtos2`
    FOREIGN KEY (`carrProdId`)
    REFERENCES `VendasPontoCom`.`Produtos` (`prodId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `VendasPontoCom`.`Administradores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VendasPontoCom`.`Administradores` ;

CREATE TABLE IF NOT EXISTS `VendasPontoCom`.`Administradores` (
  `admiMatricula` INT NOT NULL,
  `admiNome` VARCHAR(45) NOT NULL,
  `admiEmail` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`admiMatricula`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;