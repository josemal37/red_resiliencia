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
	const COLUMNAS_SELECT = "id_institucion as id, nombre_institucion as nombre, sigla_institucion as sigla";
	const NOMBRE_TABLA = "institucion";

	public function __construct() {
		parent::__construct();
	}

	public function select_instituciones() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		$query = $this->db->get();

		return $this->return_result($query);
	}

	public function select_institucion_por_id($id = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where(self::ID_COL, $id);

		$query = $this->db->get();

		return $this->return_row($query);
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
			
			$existe = $this->existe($nombre, $sigla);
			
			if(!$existe) {
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

}
