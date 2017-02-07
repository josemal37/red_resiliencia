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

	public function __construct() {
		parent::__construct();
	}

	public function select_publicaciones($categorias = FALSE, $autores = FALSE, $instituciones = FALSE) {
		$this->db->select(""
				. "p.id_publicacion as id,"
				. "p.nombre_publicacion as nombre,"
				. "p.descripcion_publicacion as descripcion,"
				. "p.url_publicacion as url,"
				. "p.imagen_publicacion as imagen,"
				. "p.destacada_publicacion as destacada,"
				. "c.id_categoria,"
				. "c.nombre_categoria");
		$this->db->from("publicacion p");
		$this->db->join("categoria_publicacion cp", "cp.id_publicacion = p.id_publicacion", "left");
		$this->db->join("categoria c", "c.id_categoria = cp.id_categoria", "left");
		$this->db->join("autor_publicacion ap", "ap.id_publicacion = p.id_publicacion", "left");
		$this->db->join("autor a", "a.id_autor = ap.id_autor", "left");
		$this->db->join("institucion_publicacion ip", "ip.id_publicacion = p.id_publicacion", "left");
		$this->db->join("institucion i", "i.id_institucion = ip.id_institucion", "left");

		if ($categorias) {
			$this->db->where_in("c.id_categoria", $categorias);
		}
		if ($autores) {
			$this->db->where_in("a.id_autor", $autores);
		}
		if ($instituciones) {
			$this->db->where_in("i.id_institucion", $instituciones);
		}

		$query = $this->db->get();

		return $this->return_result($query);
	}

}
