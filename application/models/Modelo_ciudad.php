<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_ciudad
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_ciudad extends My_model {

	const ID_COL = "id_ciudad";
	const ID_PAIS_COL = "id_pais";
	const NOMBRE_COL = "nombre_ciudad";
	const COLUMNAS_SELECT = "id_ciudad as id, id_pais as id_pais, nombre_ciudad as nombre";
	const NOMBRE_TABLA = "ciudad";

	public function __construct() {
		parent::__construct();
	}

	public function select_ciudad($id = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID_COL, $id);

			$query = $this->db->get();

			$ciudad = $this->return_row($query);

			return $ciudad;
		} else {
			return FALSE;
		}
	}

	public function select_ciudades($id_pais = FALSE) {
		$ciudades = FALSE;

		if ($id_pais) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID_PAIS_COL, $id_pais);
			$this->db->order_by(self::NOMBRE_COL);

			$query = $this->db->get();

			$ciudades = $this->return_result($query);
		} else {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->order_by(self::NOMBRE_COL);

			$query = $this->db->get();

			$ciudades = $this->return_result($query);
		}

		return $ciudades;
	}

}
