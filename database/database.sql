/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     17/02/2017 10:25:34                          */
/*==============================================================*/

/*==============================================================*/
/* Table: ARTICULO                                              */
/*==============================================================*/
create table ARTICULO
(
   ID_ARTICULO          int not null auto_increment,
   NOMBRE_ARTICULO      varchar(1024) not null,
   DESCRIPCION_ARTICULO text,
   URL_ARTICULO         varchar(1024) not null,
   IMAGEN_ARTICULO      varchar(1024),
   DESTACADO_ARTICULO   bool,
   FECHA_ARTICULO       date,
   primary key (ID_ARTICULO)
);

/*==============================================================*/
/* Table: AUTOR                                                 */
/*==============================================================*/
create table AUTOR
(
   ID_AUTOR             int not null auto_increment,
   NOMBRE_AUTOR         varchar(1024) not null,
   APELLIDO_PATERNO_AUTOR varchar(1024),
   APELLIDO_MATERNO_AUTOR varchar(1024),
   primary key (ID_AUTOR)
);

/*==============================================================*/
/* Table: AUTOR_ARTICULO                                        */
/*==============================================================*/
create table AUTOR_ARTICULO
(
   ID_ARTICULO          int not null,
   ID_AUTOR             int not null,
   primary key (ID_ARTICULO, ID_AUTOR)
);

/*==============================================================*/
/* Table: AUTOR_PUBLICACION                                     */
/*==============================================================*/
create table AUTOR_PUBLICACION
(
   ID_PUBLICACION       int not null,
   ID_AUTOR             int not null,
   primary key (ID_PUBLICACION, ID_AUTOR)
);

/*==============================================================*/
/* Table: CATEGORIA                                             */
/*==============================================================*/
create table CATEGORIA
(
   ID_CATEGORIA         int not null auto_increment,
   NOMBRE_CATEGORIA     varchar(1024) not null,
   primary key (ID_CATEGORIA)
);

/*==============================================================*/
/* Table: CATEGORIA_ARTICULO                                    */
/*==============================================================*/
create table CATEGORIA_ARTICULO
(
   ID_ARTICULO          int not null,
   ID_CATEGORIA         int not null,
   primary key (ID_ARTICULO, ID_CATEGORIA)
);

/*==============================================================*/
/* Table: CATEGORIA_EVENTO                                      */
/*==============================================================*/
create table CATEGORIA_EVENTO
(
   ID_EVENTO            int not null,
   ID_CATEGORIA         int not null,
   primary key (ID_EVENTO, ID_CATEGORIA)
);

/*==============================================================*/
/* Table: CATEGORIA_PUBLICACION                                 */
/*==============================================================*/
create table CATEGORIA_PUBLICACION
(
   ID_PUBLICACION       int not null,
   ID_CATEGORIA         int not null,
   primary key (ID_PUBLICACION, ID_CATEGORIA)
);

/*==============================================================*/
/* Table: CIUDAD                                                */
/*==============================================================*/
create table CIUDAD
(
   ID_CIUDAD            int not null auto_increment,
   ID_PAIS              int,
   NOMBRE_CIUDAD        varchar(1024) not null,
   primary key (ID_CIUDAD)
);

/*==============================================================*/
/* Table: EVENTO                                                */
/*==============================================================*/
create table EVENTO
(
   ID_EVENTO            int not null auto_increment,
   ID_CIUDAD            int,
   NOMBRE_EVENTO        varchar(1024) not null,
   DESCRIPCION_EVENTO   varchar(1024),
   FECHA_INICIO_EVENTO  date not null,
   FECHA_FIN_EVENTO     date not null,
   DIRECCION_EVENTO     varchar(1024) not null,
   IMAGEN_EVENTO        varchar(1024),
   DESTACADO_EVENTO     bool,
   primary key (ID_EVENTO)
);

/*==============================================================*/
/* Table: INSTITUCION                                           */
/*==============================================================*/
create table INSTITUCION
(
   ID_INSTITUCION       int not null auto_increment,
   NOMBRE_INSTITUCION   varchar(1024) not null,
   SIGLA_INSTITUCION    varchar(1024),
   primary key (ID_INSTITUCION)
);

/*==============================================================*/
/* Table: INSTITUCION_ARTICULO                                  */
/*==============================================================*/
create table INSTITUCION_ARTICULO
(
   ID_ARTICULO          int not null,
   ID_INSTITUCION       int not null,
   primary key (ID_ARTICULO, ID_INSTITUCION)
);

/*==============================================================*/
/* Table: INSTITUCION_AUTOR                                     */
/*==============================================================*/
create table INSTITUCION_AUTOR
(
   ID_AUTOR             int not null,
   ID_INSTITUCION       int not null,
   primary key (ID_AUTOR, ID_INSTITUCION)
);

/*==============================================================*/
/* Table: INSTITUCION_EVENTO                                    */
/*==============================================================*/
create table INSTITUCION_EVENTO
(
   ID_EVENTO            int not null,
   ID_INSTITUCION       int not null,
   primary key (ID_EVENTO, ID_INSTITUCION)
);

/*==============================================================*/
/* Table: INSTITUCION_PUBLICACION                               */
/*==============================================================*/
create table INSTITUCION_PUBLICACION
(
   ID_PUBLICACION       int not null,
   ID_INSTITUCION       int not null,
   primary key (ID_PUBLICACION, ID_INSTITUCION)
);

/*==============================================================*/
/* Table: MODULO                                                */
/*==============================================================*/
create table MODULO
(
   ID_MODULO            int not null auto_increment,
   ID_PUBLICACION       int not null,
   NOMBRE_MODULO        varchar(1024),
   primary key (ID_MODULO)
);

/*==============================================================*/
/* Table: PAIS                                                  */
/*==============================================================*/
create table PAIS
(
   ID_PAIS              int not null auto_increment,
   NOMBRE_PAIS          varchar(1024) not null,
   primary key (ID_PAIS)
);

/*==============================================================*/
/* Table: PUBLICACION                                           */
/*==============================================================*/
create table PUBLICACION
(
   ID_PUBLICACION       int not null auto_increment,
   NOMBRE_PUBLICACION   varchar(1024) not null,
   DESCRIPCION_PUBLICACION text,
   URL_PUBLICACION      varchar(1024),
   IMAGEN_PUBLICACION   varchar(1024),
   DESTACADA_PUBLICACION bool,
   FECHA_PUBLICACION    date,
   primary key (ID_PUBLICACION)
);

/*==============================================================*/
/* Table: ROL                                                   */
/*==============================================================*/
create table ROL
(
   ID_ROL               int not null auto_increment,
   NOMBRE_ROL           varchar(1024),
   primary key (ID_ROL)
);

/*==============================================================*/
/* Table: USUARIO                                               */
/*==============================================================*/
create table USUARIO
(
   ID_USUARIO           int not null auto_increment,
   ID_INSTITUCION       int,
   ID_ROL               int not null,
   NOMBRE_USUARIO       varchar(1024),
   APELLIDO_PATERNO_USUARIO varchar(1024),
   APELLIDO_MATERNO_USUARIO varchar(1024),
   LOGIN_USUARIO        varchar(1024),
   PASSWORD_USUARIO     varchar(1024),
   primary key (ID_USUARIO)
);

alter table AUTOR_ARTICULO add constraint FK_AUTOR_ARTICULO foreign key (ID_ARTICULO)
      references ARTICULO (ID_ARTICULO) on delete cascade on update cascade;

alter table AUTOR_ARTICULO add constraint FK_AUTOR_ARTICULO2 foreign key (ID_AUTOR)
      references AUTOR (ID_AUTOR) on delete cascade on update cascade;

alter table AUTOR_PUBLICACION add constraint FK_AUTOR_PUBLICACION foreign key (ID_PUBLICACION)
      references PUBLICACION (ID_PUBLICACION) on delete cascade on update cascade;

alter table AUTOR_PUBLICACION add constraint FK_AUTOR_PUBLICACION2 foreign key (ID_AUTOR)
      references AUTOR (ID_AUTOR) on delete cascade on update cascade;

alter table CATEGORIA_ARTICULO add constraint FK_CATEGORIA_ARTICULO foreign key (ID_ARTICULO)
      references ARTICULO (ID_ARTICULO) on delete cascade on update cascade;

alter table CATEGORIA_ARTICULO add constraint FK_CATEGORIA_ARTICULO2 foreign key (ID_CATEGORIA)
      references CATEGORIA (ID_CATEGORIA) on delete cascade on update cascade;

alter table CATEGORIA_EVENTO add constraint FK_CATEGORIA_EVENTO foreign key (ID_EVENTO)
      references EVENTO (ID_EVENTO) on delete cascade on update cascade;

alter table CATEGORIA_EVENTO add constraint FK_CATEGORIA_EVENTO2 foreign key (ID_CATEGORIA)
      references CATEGORIA (ID_CATEGORIA) on delete cascade on update cascade;

alter table CATEGORIA_PUBLICACION add constraint FK_CATEGORIA_PUBLICACION foreign key (ID_PUBLICACION)
      references PUBLICACION (ID_PUBLICACION) on delete cascade on update cascade;

alter table CATEGORIA_PUBLICACION add constraint FK_CATEGORIA_PUBLICACION2 foreign key (ID_CATEGORIA)
      references CATEGORIA (ID_CATEGORIA) on delete cascade on update cascade;

alter table CIUDAD add constraint FK_PAIS_CIUDAD foreign key (ID_PAIS)
      references PAIS (ID_PAIS) on delete restrict on update restrict;

alter table EVENTO add constraint FK_CIUDAD_EVENTO foreign key (ID_CIUDAD)
      references CIUDAD (ID_CIUDAD) on delete restrict on update restrict;

alter table INSTITUCION_ARTICULO add constraint FK_INSTITUCION_ARTICULO foreign key (ID_ARTICULO)
      references ARTICULO (ID_ARTICULO) on delete cascade on update cascade;

alter table INSTITUCION_ARTICULO add constraint FK_INSTITUCION_ARTICULO2 foreign key (ID_INSTITUCION)
      references INSTITUCION (ID_INSTITUCION) on delete cascade on update cascade;

alter table INSTITUCION_AUTOR add constraint FK_INSTITUCION_AUTOR foreign key (ID_AUTOR)
      references AUTOR (ID_AUTOR) on delete cascade on update cascade;

alter table INSTITUCION_AUTOR add constraint FK_INSTITUCION_AUTOR2 foreign key (ID_INSTITUCION)
      references INSTITUCION (ID_INSTITUCION) on delete cascade on update cascade;

alter table INSTITUCION_EVENTO add constraint FK_INSTITUCION_EVENTO foreign key (ID_EVENTO)
      references EVENTO (ID_EVENTO) on delete cascade on update cascade;

alter table INSTITUCION_EVENTO add constraint FK_INSTITUCION_EVENTO2 foreign key (ID_INSTITUCION)
      references INSTITUCION (ID_INSTITUCION) on delete cascade on update cascade;

alter table INSTITUCION_PUBLICACION add constraint FK_INSTITUCION_PUBLICACION foreign key (ID_PUBLICACION)
      references PUBLICACION (ID_PUBLICACION) on delete cascade on update cascade;

alter table INSTITUCION_PUBLICACION add constraint FK_INSTITUCION_PUBLICACION2 foreign key (ID_INSTITUCION)
      references INSTITUCION (ID_INSTITUCION) on delete cascade on update cascade;

alter table MODULO add constraint FK_MODULO_PUBLICACION foreign key (ID_PUBLICACION)
      references PUBLICACION (ID_PUBLICACION) on delete cascade on update cascade;

alter table USUARIO add constraint FK_ROL_USUARIO foreign key (ID_ROL)
      references ROL (ID_ROL) on delete restrict on update restrict;

alter table USUARIO add constraint FK_USUARIO_INSTITUCION foreign key (ID_INSTITUCION)
      references INSTITUCION (ID_INSTITUCION) on delete restrict on update restrict;

