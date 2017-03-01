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
	const COLUMNAS_SELECT = "categoria.id_categoria as id, categoria.nombre_categoria as nombre";
	const NOMBRE_TABLA = "categoria";
	const NOMBRE_TABLA_JOIN_PUBLICACION = "categoria_publicacion";
	const ID_PUBLICACION_COL = "id_publicacion";
	const NOMBRE_TABLA_JOIN_EVENTO = "categoria_evento";
	const ID_EVENTO_COL = "id_evento";

	public function __construct() {
		parent::__construct();
	}

	public function select_categorias() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		$query = $this->db->get();

		return $this->return_result($query);
	}

	public function select_categoria_por_id($id = FALSE, $nombre_tabla = "") {
		if ($id) {
			$datos = FALSE;
			switch ($nombre_tabla) {
				case "":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->where(self::ID_COL, $id);

					$query = $this->db->get();

					$datos = $this->return_row($query);
					break;
				case "publicacion":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->join(self::NOMBRE_TABLA_JOIN_PUBLICACION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_JOIN_PUBLICACION . "." . self::ID_COL, "left");
					$this->db->where(self::NOMBRE_TABLA_JOIN_PUBLICACION . "." . self::ID_PUBLICACION_COL, $id);

					$query = $this->db->get();

					$datos = $this->return_result($query);
					break;
				case "evento":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->join(self::NOMBRE_TABLA_JOIN_EVENTO, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_JOIN_EVENTO . "." . self::ID_COL, "left");
					$this->db->where(self::NOMBRE_TABLA_JOIN_EVENTO . "." . self::ID_EVENTO_COL, $id);

					$query = $this->db->get();

					$datos = $this->return_result($query);
					break;
			}
			return $datos;
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
			} else {
				$this->session->set_flashdata("existe", "La categoria ya se encuentra registrada.");
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
			$existe = $this->existe_diferente_id($id, $nombre);

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
			} else {
				$this->session->set_flashdata("existe", "La categoria ya se encuentra registrada.");
			}

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	public function delete_categoria($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->trans_start();

			$this->db->where(self::ID_COL, $id);
			$this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();

			return $eliminado;
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

	public function existe_diferente_id($id = FALSE, $nombre = "") {
		$existe = FALSE;

		$datos = array();
		$datos[self::ID_COL . "!="] = $id;
		$datos[self::NOMBRE_COL] = $nombre;

		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where($datos);

		$query = $this->db->get();
		$autor = $this->return_row($query);

		if ($autor) {
			$existe = TRUE;
		}

		return $existe;
	}

}
