drop categorias if exists;
create table categorias(id int(40) PRIMARY KEY NOT NULL AUTO_INCREMENT,
nombre varchar(120) NOT NULL, 
creador varchar(120) NOT NULL,
creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
actualizado TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL);

drop articulos if exists;
create table articulos(id int(40) PRIMARY KEY NOT NULL AUTO_INCREMENT,
titulo varchar(120) NOT NULL, 
creador varchar(120) NOT NULL,
imagen varchar(200),
contenido varchar (12000) NOT NULL,
categoria int(40) NOT NULL,
creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
actualizado TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
FOREIGN KEY (categoria) REFERENCES categorias(id));


CREATE VIEW productosycategorias AS SELECT a.id AS id,a.titulo AS titulo,a.creador AS creador,a.imagen AS imagen,a.contenido AS contenido,a.creado AS creado, a.actualizado AS actualizado, c.nombre AS categoria from articulos a join categorias c where c.id = a.categoria;

drop comentarios if exists;
CREATE TABLE comentarios (id int(200) PRIMARY KEY NOT NULL AUTO_INCREMENT,
nombre varchar(20) NOT NULL,
email varchar(20) NOT NULL,
comentario varchar(500) NOT NULL,
fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
status varchar(11) NOT NULL DEFAULT 'desactivado',
verificador varchar(50) NOT NULL,
articulo int(40) NOT NULL,
INDEX articuloblog(articulo),
FOREIGN KEY (articulo) REFERENCES articulos(id) ON DELETE CASCADE);

drop usuarios if exists;
CREATE TABLE usuarios (id int(200) PRIMARY KEY NOT NULL AUTO_INCREMENT,
username varchar(50) NOT NULL,
email varchar(50) NOT NULL,
password varchar(1000) NOT NULL,
alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
status varchar(3) NOT NULL DEFAULT 'OFF'); 

use cms;