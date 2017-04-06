/*==============================================================*/
/* DBMS name:      MySQL 5.0 modificado                         */
/* Created on:     03/04/2017 11:38:19                          */
/*==============================================================*/

/*==============================================================*/
/* Table: articulo                                              */
/*==============================================================*/
create table `articulo`
(
   `id_articulo` int not null auto_increment,
   `nombre_articulo` varchar(1024) not null,
   `descripcion_articulo` text,
   `url_articulo` varchar(1024) not null,
   `imagen_articulo` varchar(1024),
   `destacado_articulo` bool,
   `fecha_articulo` datetime,
   primary key (`id_articulo`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: autor                                                 */
/*==============================================================*/
create table `autor`
(
   `id_autor` int not null auto_increment,
   `nombre_autor` varchar(1024) not null,
   `apellido_paterno_autor` varchar(1024),
   `apellido_materno_autor` varchar(1024),
   `correo_autor` varchar(1024),
   `foto_autor` varchar(1024),
   primary key (`id_autor`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: autor_articulo                                        */
/*==============================================================*/
create table `autor_articulo`
(
   `id_articulo` int not null,
   `id_autor` int not null,
   primary key (`id_articulo`, `id_autor`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: autor_herramienta                                     */
/*==============================================================*/
create table `autor_herramienta`
(
   `id_herramienta` int not null,
   `id_autor` int not null,
   primary key (`id_herramienta`, `id_autor`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: autor_publicacion                                     */
/*==============================================================*/
create table `autor_publicacion`
(
   `id_publicacion` int not null,
   `id_autor` int not null,
   primary key (`id_publicacion`, `id_autor`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: categoria                                             */
/*==============================================================*/
create table `categoria`
(
   `id_categoria` int not null auto_increment,
   `nombre_categoria` varchar(1024) not null,
   primary key (`id_categoria`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: categoria_articulo                                    */
/*==============================================================*/
create table `categoria_articulo`
(
   `id_articulo` int not null,
   `id_categoria` int not null,
   primary key (`id_articulo`, `id_categoria`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: categoria_evento                                      */
/*==============================================================*/
create table `categoria_evento`
(
   `id_evento` int not null,
   `id_categoria` int not null,
   primary key (`id_evento`, `id_categoria`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: categoria_herramienta                                 */
/*==============================================================*/
create table `categoria_herramienta`
(
   `id_categoria` int not null,
   `id_herramienta` int not null,
   primary key (`id_categoria`, `id_herramienta`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: categoria_publicacion                                 */
/*==============================================================*/
create table `categoria_publicacion`
(
   `id_publicacion` int not null,
   `id_categoria` int not null,
   primary key (`id_publicacion`, `id_categoria`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: ciudad                                                */
/*==============================================================*/
create table `ciudad`
(
   `id_ciudad` int not null auto_increment,
   `id_pais` int,
   `nombre_ciudad` varchar(1024) not null,
   primary key (`id_ciudad`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: evento                                                */
/*==============================================================*/
create table `evento`
(
   `id_evento` int not null auto_increment,
   `id_ciudad` int,
   `nombre_evento` varchar(1024) not null,
   `descripcion_evento` varchar(1024),
   `fecha_inicio_evento` date not null,
   `fecha_fin_evento` date not null,
   `direccion_evento` varchar(1024) not null,
   `imagen_evento` varchar(1024),
   `destacado_evento` bool,
   `url_evento` varchar(1024),
   `fecha_evento` datetime,
   primary key (`id_evento`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: herramienta                                           */
/*==============================================================*/
create table `herramienta`
(
   `id_herramienta` int not null auto_increment,
   `nombre_herramienta` varchar(1024),
   `descripcion_herramienta` text,
   `imagen_herramienta` varchar(1024),
   `video_herramienta` varchar(1024),
   `url_herramienta` varchar(1024)
   primary key (`id_herramienta`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: institucion                                           */
/*==============================================================*/
create table `institucion`
(
   `id_institucion` int not null auto_increment,
   `nombre_institucion` varchar(1024) not null,
   `sigla_institucion` varchar(1024),
   `logo_institucion` varchar(1024),
   primary key (`id_institucion`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: institucion_articulo                                  */
/*==============================================================*/
create table `institucion_articulo`
(
   `id_articulo` int not null,
   `id_institucion` int not null,
   primary key (`id_articulo`, `id_institucion`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: institucion_autor                                     */
/*==============================================================*/
create table `institucion_autor`
(
   `id_autor` int not null,
   `id_institucion` int not null,
   primary key (`id_autor`, `id_institucion`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: institucion_evento                                    */
/*==============================================================*/
create table `institucion_evento`
(
   `id_evento` int not null,
   `id_institucion` int not null,
   primary key (`id_evento`, `id_institucion`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: institucion_herramienta                               */
/*==============================================================*/
create table `institucion_herramienta`
(
   `id_herramienta` int not null,
   `id_institucion` int not null,
   primary key (`id_herramienta`, `id_institucion`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: institucion_publicacion                               */
/*==============================================================*/
create table `institucion_publicacion`
(
   `id_publicacion` int not null,
   `id_institucion` int not null,
   primary key (`id_publicacion`, `id_institucion`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: modulo                                                */
/*==============================================================*/
create table `modulo`
(
   `id_modulo` int not null auto_increment,
   `id_publicacion` int not null,
   `nombre_modulo` varchar(1024),
   `descripcion_modulo` text,
   primary key (`id_modulo`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: pais                                                  */
/*==============================================================*/
create table `pais`
(
   `id_pais` int not null auto_increment,
   `nombre_pais` varchar(1024) not null,
   primary key (`id_pais`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: publicacion                                           */
/*==============================================================*/
create table `publicacion`
(
   `id_publicacion` int not null auto_increment,
   `nombre_publicacion` varchar(1024) not null,
   `descripcion_publicacion` text,
   `url_publicacion` varchar(1024),
   `imagen_publicacion` varchar(1024),
   `destacada_publicacion` bool,
   `fecha_publicacion` datetime,
   primary key (`id_publicacion`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: rol                                                   */
/*==============================================================*/
create table `rol`
(
   `id_rol` int not null auto_increment,
   `nombre_rol` varchar(1024),
   primary key (`id_rol`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: usuario                                               */
/*==============================================================*/
create table `usuario`
(
   `id_usuario` int not null auto_increment,
   `id_institucion` int,
   `id_rol` int not null,
   `nombre_usuario` varchar(1024),
   `apellido_paterno_usuario` varchar(1024),
   `apellido_materno_usuario` varchar(1024),
   `login_usuario` varchar(1024),
   `password_usuario` varchar(1024),
   `correo_usuario` varchar(1024),
   `telefono_usuario` varchar(1024),
   primary key (`id_usuario`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: visita_articulo                                       */
/*==============================================================*/
create table `visita_articulo`
(
   `id_visita_articulo` int not null auto_increment,
   `id_articulo` int not null,
   `ip_visita_articulo` varchar(1024),
   `fecha_visita_articulo` date,
   primary key (`id_visita_articulo`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: visita_evento                                         */
/*==============================================================*/
create table `visita_evento`
(
   `id_visita_evento` int not null auto_increment,
   `id_evento` int not null,
   `ip_visita_evento` varchar(1024),
   `fecha_visita_evento` date,
   primary key (`id_visita_evento`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

/*==============================================================*/
/* Table: visita_publicacion                                    */
/*==============================================================*/
create table `visita_publicacion`
(
   `id_visita_publicacion` int not null auto_increment,
   `id_publicacion` int not null,
   `ip_visita_publicacion` varchar(1024),
   `fecha_visita_publicacion` date,
   primary key (`id_visita_publicacion`)
)


engine = innodb
default character set = utf8
collate = utf8_general_ci;

alter table `autor_articulo` add constraint `fk_autor_articulo` foreign key (`id_articulo`)
      references `articulo` (`id_articulo`) on delete restrict on update restrict;

alter table `autor_articulo` add constraint `fk_autor_articulo2` foreign key (`id_autor`)
      references `autor` (`id_autor`) on delete restrict on update restrict;

alter table `autor_herramienta` add constraint `fk_autor_herramienta` foreign key (`id_herramienta`)
      references `herramienta` (`id_herramienta`) on delete restrict on update restrict;

alter table `autor_herramienta` add constraint `fk_autor_herramienta2` foreign key (`id_autor`)
      references `autor` (`id_autor`) on delete restrict on update restrict;

alter table `autor_publicacion` add constraint `fk_autor_publicacion` foreign key (`id_publicacion`)
      references `publicacion` (`id_publicacion`) on delete restrict on update restrict;

alter table `autor_publicacion` add constraint `fk_autor_publicacion2` foreign key (`id_autor`)
      references `autor` (`id_autor`) on delete restrict on update restrict;

alter table `categoria_articulo` add constraint `fk_categoria_articulo` foreign key (`id_articulo`)
      references `articulo` (`id_articulo`) on delete restrict on update restrict;

alter table `categoria_articulo` add constraint `fk_categoria_articulo2` foreign key (`id_categoria`)
      references `categoria` (`id_categoria`) on delete restrict on update restrict;

alter table `categoria_evento` add constraint `fk_categoria_evento` foreign key (`id_evento`)
      references `evento` (`id_evento`) on delete restrict on update restrict;

alter table `categoria_evento` add constraint `fk_categoria_evento2` foreign key (`id_categoria`)
      references `categoria` (`id_categoria`) on delete restrict on update restrict;

alter table `categoria_herramienta` add constraint `fk_categoria_herramienta` foreign key (`id_categoria`)
      references `categoria` (`id_categoria`) on delete restrict on update restrict;

alter table `categoria_herramienta` add constraint `fk_categoria_herramienta2` foreign key (`id_herramienta`)
      references `herramienta` (`id_herramienta`) on delete restrict on update restrict;

alter table `categoria_publicacion` add constraint `fk_categoria_publicacion` foreign key (`id_publicacion`)
      references `publicacion` (`id_publicacion`) on delete restrict on update restrict;

alter table `categoria_publicacion` add constraint `fk_categoria_publicacion2` foreign key (`id_categoria`)
      references `categoria` (`id_categoria`) on delete restrict on update restrict;

alter table `ciudad` add constraint `fk_pais_ciudad` foreign key (`id_pais`)
      references `pais` (`id_pais`) on delete restrict on update restrict;

alter table `evento` add constraint `fk_ciudad_evento` foreign key (`id_ciudad`)
      references `ciudad` (`id_ciudad`) on delete restrict on update restrict;

alter table `institucion_articulo` add constraint `fk_institucion_articulo` foreign key (`id_articulo`)
      references `articulo` (`id_articulo`) on delete restrict on update restrict;

alter table `institucion_articulo` add constraint `fk_institucion_articulo2` foreign key (`id_institucion`)
      references `institucion` (`id_institucion`) on delete restrict on update restrict;

alter table `institucion_autor` add constraint `fk_institucion_autor` foreign key (`id_autor`)
      references `autor` (`id_autor`) on delete restrict on update restrict;

alter table `institucion_autor` add constraint `fk_institucion_autor2` foreign key (`id_institucion`)
      references `institucion` (`id_institucion`) on delete restrict on update restrict;

alter table `institucion_evento` add constraint `fk_institucion_evento` foreign key (`id_evento`)
      references `evento` (`id_evento`) on delete restrict on update restrict;

alter table `institucion_evento` add constraint `fk_institucion_evento2` foreign key (`id_institucion`)
      references `institucion` (`id_institucion`) on delete restrict on update restrict;

alter table `institucion_herramienta` add constraint `fk_institucion_herramienta` foreign key (`id_herramienta`)
      references `herramienta` (`id_herramienta`) on delete restrict on update restrict;

alter table `institucion_herramienta` add constraint `fk_institucion_herramienta2` foreign key (`id_institucion`)
      references `institucion` (`id_institucion`) on delete restrict on update restrict;

alter table `institucion_publicacion` add constraint `fk_institucion_publicacion` foreign key (`id_publicacion`)
      references `publicacion` (`id_publicacion`) on delete restrict on update restrict;

alter table `institucion_publicacion` add constraint `fk_institucion_publicacion2` foreign key (`id_institucion`)
      references `institucion` (`id_institucion`) on delete restrict on update restrict;

alter table `modulo` add constraint `fk_modulo_publicacion` foreign key (`id_publicacion`)
      references `publicacion` (`id_publicacion`) on delete restrict on update restrict;

alter table `usuario` add constraint `fk_rol_usuario` foreign key (`id_rol`)
      references `rol` (`id_rol`) on delete restrict on update restrict;

alter table `usuario` add constraint `fk_usuario_institucion` foreign key (`id_institucion`)
      references `institucion` (`id_institucion`) on delete restrict on update restrict;

alter table `visita_articulo` add constraint `fk_a_tiene_v` foreign key (`id_articulo`)
      references `articulo` (`id_articulo`) on delete restrict on update restrict;

alter table `visita_evento` add constraint `fk_e_tiene_v` foreign key (`id_evento`)
      references `evento` (`id_evento`) on delete restrict on update restrict;

alter table `visita_publicacion` add constraint `fk_p_tiene_v` foreign key (`id_publicacion`)
      references `publicacion` (`id_publicacion`) on delete restrict on update restrict;


/*==============================================================*/
/* Datos                                                        */
/*==============================================================*/

INSERT INTO `pais` (`id_pais`, `nombre_pais`) VALUES
(1, 'Bolivia');

INSERT INTO `ciudad` (`id_ciudad`, `id_pais`, `nombre_ciudad`) VALUES
(1, 1, 'Chuquisaca'),
(2, 1, 'Cochabamba'),
(3, 1, 'Beni'),
(4, 1, 'La Paz'),
(5, 1, 'Oruro'),
(6, 1, 'Pando'),
(7, 1, 'Potosí'),
(8, 1, 'Santa Cruz'),
(9, 1, 'Tarija');

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES (1, 'administrador'), (2, 'usuario');

INSERT INTO `institucion` (`id_institucion`, `nombre_institucion`, `sigla_institucion`) VALUES (1, 'Fundación Atica', 'ATICA');

INSERT INTO `usuario` (`id_usuario`, `id_institucion`, `id_rol`, `nombre_usuario`, `login_usuario`, `password_usuario`) VALUES (1, 1, 1, 'admin', 'admin', SHA1('admin'));