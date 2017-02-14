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
	const FECHA_COL = "fecha_publicacion";
	
	const COLUMNAS_SELECT = "publicacion.id_publicacion as id, publicacion.nombre_publicacion as nombre, publicacion.descripcion_publicacion as descripcion, publicacion.url_publicacion as url, publicacion.imagen_publicacion as imagen, publicacion.destacada_publicacion as destacada, publicacion.fecha_publicacion as publicacion";
	
	const NOMBRE_TABLA = "publicacion";
	
	const NOMBRE_TABLA_ASOC_AUTOR = "autor_publicacion";
	const ID_TABLA_ASOC_AUTOR = "id_autor";
	const NOMBRE_TABLA_ASOC_CATEGORIA = "categoria_publicacion";
	const ID_TABLA_ASOC_CATEGORIA = "id_categoria";
	const NOMBRE_TABLA_ASOC_INSTITUCION = "institucion_publicacion";
	const ID_TABLA_ASOC_INSTITUCION = "id_institucion";

	public function __construct() {
		$this->load->model(array("Modelo_categoria", "Modelo_institucion", "Modelo_modulo"));
		parent::__construct();
	}

	public function select_publicaciones($categorias = FALSE, $autores = FALSE, $instituciones = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		
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
				
				//cargamos los modulos
				$modulos = $this->Modelo_modulo->select_modulos($publicacion->id);
				$publicaciones[$i]->modulos = $modulos;

				$i += 1;
			}
		}

		return $publicaciones;
	}

	public function insert_publicacion($nombre = "", $descripcion = "", $modulos = FALSE, $url = "", $imagen = "", $destacada = FALSE, $id_autor = FALSE, $id_categoria = FALSE, $id_institucion = FALSE) {

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

			if ($insertado) {
				$id_publicacion = $this->db->insert_id();

				$this->Modelo_modulo->insert_modulo($id_publicacion, $modulos);
				$this->insert_categoria_a_publicacion($id_publicacion, $id_categoria);
				$this->insert_autor_a_publicacion($id_publicacion, $id_autor);
				$this->insert_institucion_a_publicacion($id_publicacion, $id_institucion);
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	private function insert_autor_a_publicacion($id_publicacion = FALSE, $id_autor = FALSE) {
		if ($id_publicacion && $id_autor) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_AUTOR, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_AUTOR, $id_autor);
			
			return $asociado;
		} else {
			return FALSE;
		}
	}

	private function insert_categoria_a_publicacion($id_publicacion = FALSE, $id_categoria = FALSE) {
		if ($id_publicacion && $id_categoria) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_CATEGORIA, $id_categoria);
			
			return $asociado;
		} else {
			return FALSE;
		}
	}

	private function insert_institucion_a_publicacion($id_publicacion = FALSE, $id_institucion = FALSE) {
		if ($id_publicacion && $id_institucion) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
			
			return $asociado;
		} else {
			return FALSE;
		}
	}

}
