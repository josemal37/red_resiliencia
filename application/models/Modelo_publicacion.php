<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_Publicacion
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_publicacion extends My_model {

	const ID_COL = "id_publicacion";
	const NOMBRE_COL = "nombre_publicacion";
	const DESCRIPCION_COL = "descripcion_publicacion";
	const URL_COL = "url_publicacion";
	const IMAGEN_COL = "imagen_publicacion";
	const DESTACADA_COL = "destacada_publicacion";
	const COLUMNAS_SELECT = "publicacion.id_publicacion as id, publicacion.nombre_publicacion as nombre, publicacion.descripcion_publicacion as descripcion, publicacion.url_publicacion as url, publicacion.imagen_publicacion as imagen, publicacion.destacada_publicacion as destacada";
	const NOMBRE_TABLA = "publicacion";

	public function __construct() {
		$this->load->model(array("Modelo_categoria", "Modelo_institucion"));
		parent::__construct();
	}

	public function select_publicaciones($categorias = FALSE, $autores = FALSE, $instituciones = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		/*
		  if ($categorias) {
		  $this->db->where_in("c.id_categoria", $categorias);
		  }
		  if ($autores) {
		  $this->db->where_in("a.id_autor", $autores);
		  }
		  if ($instituciones) {
		  $this->db->where_in("i.id_institucion", $instituciones);
		  }
		 */
		$query = $this->db->get();

		$publicaciones = $this->return_result($query);

		if ($publicaciones) {
			$i = 0;

			foreach ($publicaciones as $publicacion) {
				//cargamos las categorias
				$categorias = $this->Modelo_categoria->select_categoria_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicaciones[$i]->categorias = $categorias;

				//cargamos las instituciones
				$instituciones = $this->Modelo_institucion->select_institucion_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicaciones[$i]->instituciones = $instituciones;

				//cargamos los autores
				$autores = $this->Modelo_autor->select_autor_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicaciones[$i]->autores = $autores;

				$i += 1;
			}
		}

		return $publicaciones;
	}

	public function insert_publicacion($nombre = "", $descripcion = "", $url = "", $imagen = "", $destacada = FALSE) {

		if ($nombre != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			$datos = array();
			$datos[self::NOMBRE_COL] = $nombre;
			$datos[self::DESCRIPCION_COL] = $descripcion;
			$datos[self::URL_COL] = $url;
			$datos[self::IMAGEN_COL] = $imagen;
			$datos[self::DESTACADA_COL] = $destacada;

			$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

}
