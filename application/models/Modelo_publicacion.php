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
	const COLUMNAS_SELECT = "id_publicacion as id, nombre_publicacion as nombre, descripcion_publicacion as descripcion, url_publicacion as url, imagen_publicacion as imagen, destacada_publicacion as destacada";
	const NOMBRE_TABLA = "publicacion";

	public function __construct() {
		$this->load->model("Modelo_categoria");
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
		
		$i = 0;

		foreach ($publicaciones as $publicacion) {

			//cargamos las categorias
			$categorias = $this->Modelo_categoria->select_categoria_por_id($publicacion->id, self::NOMBRE_TABLA);
			$publicaciones[$i]->categorias = $categorias;
			
			$i += 1;
		}

		return $publicaciones;
	}

}
