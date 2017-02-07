<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_Categoria
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_categoria extends My_model {

	const ID_COL = "id_categoria";
	const NOMBRE_COL = "nombre_categoria";
	const COLUMNAS_SELECT = "id_categoria as id, nombre_categoria as nombre";
	const NOMBRE_TABLA = "categoria";

	public function __construct() {
		parent::__construct();
	}

	public function select_categorias() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		$query = $this->db->get();

		return $this->return_result($query);
	}

	public function select_categoria_por_id($id = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID_COL, $id);

			$query = $this->db->get();

			return $this->return_row($query);
		} else {
			return FALSE;
		}
	}

	public function select_categoria_por_nombre($nombre = "") {
		if ($nombre != "") {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_COL, $nombre);

			$query = $this->db->get();

			return $this->return_row($query);
		} else {
			return FALSE;
		}
	}

	public function insert_categoria($nombre = "") {
		if ($nombre != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			//verificamos si la categoria existe
			$existe = $this->existe($nombre);

			//si no existe
			if (!$existe) {
				//establecemos los datos
				$datos = array();
				$datos[self::NOMBRE_COL] = $nombre;

				//insertamos la nueva categoria
				$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	public function update_categoria($id = FALSE, $nombre = "") {
		if ($id && $nombre != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			//verificamos si la categoria existe
			$existe = $this->existe($nombre);

			//si no existe
			if (!$existe) {
				//establecemos los datos
				$datos = array();
				$datos[self::NOMBRE_COL] = $nombre;
				$this->db->set($datos);
				//establecemos las condiciones
				$cond = array();
				$cond[self::ID_COL] = $id;
				$this->db->where($cond);
				//actualizamos los datos
				$actualizado = $this->db->update(self::NOMBRE_TABLA);
			}

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	public function existe($nombre = "") {
		$existe = FALSE;

		//seleccionamos por nombre
		$categoria = $this->select_categoria_por_nombre($nombre);

		//si existe la categoria
		if ($categoria) {
			$existe = TRUE;
		}

		return $existe;
	}

}
