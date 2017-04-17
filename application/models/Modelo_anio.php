<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_anio
 *
 * @author Jose
 */
class Modelo_anio extends My_model {

	const ID_COL = "id_anio";
	const ANIO_COL = "valor_anio";
	const COLUMNAS_SELECT = "anio.id_anio as id, anio.valor_anio as anio";
	const NOMBRE_TABLA = "anio";

	public function __construct() {
		parent::__construct();
	}

	public function select_anios() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->distinct();
		$this->db->order_by(self::ANIO_COL, "ASC");

		$query = $this->db->get();

		$anios = $this->return_result($query);

		return $anios;
	}

	public function select_anio_por_id($id = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID_COL, $id);

			$query = $this->db->get();

			$anio = $this->return_row($query);

			return $anio;
		} else {
			return FALSE;
		}
	}

	public function select_anio_por_valor($anio = FALSE) {
		if ($anio) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ANIO_COL, $anio);

			$query = $this->db->get();

			$anio = $this->return_row($query);

			return $anio;
		} else {
			return FALSE;
		}
	}

	public function insert_anio($anio = FALSE) {
		if ($anio) {
			$insertado = FALSE;

			$anio_reg = $this->select_anio_por_valor($anio);

			if ($anio_reg) {
				$insertado = $anio_reg->id;
			} else {
				$datos = array(
					self::ANIO_COL => $anio
				);
				$this->db->set($datos);
				$insertado = $this->db->insert(self::NOMBRE_TABLA);

				if ($insertado) {
					$insertado = $this->db->insert_id();
				}
			}

			return $insertado;
		} else {
			return FALSE;
		}
	}

}
