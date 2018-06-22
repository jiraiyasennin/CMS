#Script para crear la base de datos y la tabla categorías
DROP DATABASE IF EXISTS cms;
CREATE DATABASE cms;
USE cms;

create table categorias(id int(40) PRIMARY KEY NOT NULL AUTO_INCREMENT,
nombre varchar(120) NOT NULL, creador varchar(120) NOT NULL,
creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
actualizado TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL);
