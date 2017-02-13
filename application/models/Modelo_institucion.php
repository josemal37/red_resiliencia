<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_institucion
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_institucion extends My_model {

	const ID_COL = "id_institucion";
	const NOMBRE_COL = "nombre_institucion";
	const SIGLA_COL = "sigla_institucion";
	
	const COLUMNAS_SELECT = "institucion.id_institucion as id, institucion.nombre_institucion as nombre, institucion.sigla_institucion as sigla";
	
	const NOMBRE_TABLA = "institucion";
	
	const NOMBRE_TABLA_JOIN_PUBLICACION = "institucion_publicacion";
	const ID_PUBLICACION_COL = "id_publicacion";
	
	const NOMBRE_TABLA_JOIN_AUTOR = "institucion_autor";
	const ID_AUTOR_COL = "id_autor";

	public function __construct() {
		parent::__construct();
	}

	public function select_instituciones() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		$query = $this->db->get();

		return $this->return_result($query);
	}

	public function select_institucion_por_id($id = FALSE, $nombre_tabla = "") {
		if ($id) {
			$datos  = FALSE;
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
				case "autor":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->join(self::NOMBRE_TABLA_JOIN_AUTOR, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_JOIN_AUTOR . "." . self::ID_COL, "left");
					$this->db->where(self::NOMBRE_TABLA_JOIN_AUTOR . "." . self::ID_AUTOR_COL, $id);

					$query = $this->db->get();

					$datos = $this->return_result($query);
					break;
			}
			return $datos;
		} else {
			return FALSE;
		}
	}

	public function select_institucion_por_nombre($nombre = "") {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where(self::NOMBRE_COL, $nombre);

		$query = $this->db->get();

		return $this->return_row($query);
	}

	public function select_institucion_por_nombre_y_sigla($nombre = "", $sigla = "") {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where(self::NOMBRE_COL, $nombre);
		$this->db->where(self::SIGLA_COL, $sigla);

		$query = $this->db->get();

		return $this->return_row($query);
	}

	public function select_institucion_por_sigla($sigla = "") {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where(self::SIGLA_COL, $sigla);

		$query = $this->db->get();

		return $this->return_row($query);
	}

	public function insert_institucion($nombre = "", $sigla = "") {
		if ($nombre != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			$existe = $this->existe($nombre, $sigla);

			if (!$existe) {
				$datos = array();
				$datos[self::NOMBRE_COL] = $nombre;
				$datos[self::SIGLA_COL] = $sigla;

				$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	public function update_institucion($id = FALSE, $nombre = "", $sigla = "") {
		if ($id && $nombre != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			$existe = $this->existe_diferente_id($id, $nombre, $sigla);

			if (!$existe) {
				$datos = array();
				$datos[self::NOMBRE_COL] = $nombre;
				$datos[self::SIGLA_COL] = $sigla;

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

	public function existe($nombre = "", $sigla = "") {
		$existe = FALSE;

		$institucion = $this->select_institucion_por_nombre_y_sigla($nombre, $sigla);

		if ($institucion) {
			$existe = TRUE;
		}

		return $existe;
	}
	
	public function existe_diferente_id($id = FALSE, $nombre = "", $sigla = "") {
		$existe = FALSE;
		
		$datos = array();
		$datos[self::ID_COL . "!="] = $id;
		$datos[self::NOMBRE_COL] = $nombre;
		$datos[self::SIGLA_COL] = $sigla;
		
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where($datos);
		
		$query = $this->db->get();
		$autor = $this->return_row($query);
		
		if($autor) {
			$existe = TRUE;
		}
		
		return $existe;
	}

}
