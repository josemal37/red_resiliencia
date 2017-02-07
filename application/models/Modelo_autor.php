<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_Autor
 *
 * @author Jose
 */
class Modelo_autor extends My_model {

	const ID_COL = "id_autor";
	const NOMBRE_COL = "nombre_autor";
	const APELLIDO_PATERNO_COL = "apellido_paterno_autor";
	const APELLIDO_MATERNO_COL = "apellido_materno_autor";
	const COLUMNAS_SELECT = "id_autor as id, nombre_autor as nombre, apellido_paterno_autor as apellido_paterno, apellido_materno_autor as apellido_materno";
	const NOMBRE_TABLA = "autor";

	public function __construct() {
		parent::__construct();
	}

	public function select_autores() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		$query = $this->db->get();

		return $this->return_result($query);
	}

	public function select_autor_por_id($id = FALSE) {
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

	public function select_autor_por_nombre($nombre = "", $apellido_paterno = "", $apellido_materno = "") {
		if ($nombre != "") {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_COL, $nombre);
			$this->db->where(self::APELLIDO_PATERNO_COL, $apellido_paterno);
			$this->db->where(self::APELLIDO_MATERNO_COL, $apellido_materno);

			$query = $this->db->get();

			return $this->return_row($query);
		} else {
			return FALSE;
		}
	}

	public function insert_autor($nombre = "", $apellido_paterno = "", $apellido_materno = "") {
		if ($nombre != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			//verificamos si existe
			$existe = $this->existe($nombre, $apellido_paterno, $apellido_materno);

			//si no existe
			if (!$existe) {
				$datos = array();
				$datos[self::NOMBRE_COL] = $nombre;
				$datos[self::APELLIDO_PATERNO_COL] = $apellido_paterno;
				$datos[self::APELLIDO_MATERNO_COL] = $apellido_materno;

				$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	public function update_autor($id = FALSE, $nombre = "", $apellido_paterno = "", $apellido_materno = "") {
		if ($id && $nombre != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			//verificamos si existe
			$existe = $this->existe($nombre, $apellido_paterno, $apellido_materno);

			if (!$existe) {
				$datos = array();
				$datos[self::NOMBRE_COL] = $nombre;
				$datos[self::APELLIDO_PATERNO_COL] = $apellido_paterno;
				$datos[self::APELLIDO_MATERNO_COL] = $apellido_materno;
				$this->db->set($datos);
				$this->db->where(self::ID_COL, $id);

				$actualizado = $this->db->update(self::NOMBRE_TABLA);
			}

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	public function existe($nombre = "", $apellido_paterno = "", $apellido_materno = "") {
		$existe = FALSE;

		//seleccionamos por nombre
		$autor = $this->select_autor_por_nombre($nombre, $apellido_paterno, $apellido_materno);

		//si existe el autor
		if ($autor) {
			$existe = TRUE;
		}

		return $existe;
	}

}
