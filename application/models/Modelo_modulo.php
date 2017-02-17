<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_modulo
 *
 * @author Jose
 */
class Modelo_modulo extends My_model {

	const ID_COL = "id_modulo";
	const ID_PUBLICACION_COL = "id_publicacion";
	const NOMBRE_COL = "nombre_modulo";
	const COLUMNAS_SELECT = "modulo.id_modulo as id, modulo.id_publicacion as id_publicacion, modulo.nombre_modulo as nombre";
	const NOMBRE_TABLA = "modulo";

	public function __construct() {
		parent::__construct();
	}

	public function select_modulos($id_publicacion = FALSE) {
		if ($id_publicacion) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID_PUBLICACION_COL, $id_publicacion);

			$query = $this->db->get();

			return $this->return_result($query);
		} else {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);

			$query = $this->db->get();

			return $this->return_result($query);
		}
	}

	public function insert_modulo($id_publicacion = FALSE, $nombre = "") {
		if ($id_publicacion && $nombre != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			$datos = array();

			if (is_array($nombre)) {
				foreach ($nombre as $n) {
					$actual = array();
					$actual[self::ID_PUBLICACION_COL] = $id_publicacion;
					$actual[self::NOMBRE_COL] = $n;

					$datos[] = $actual;
				}

				$insertado = $this->db->insert_batch(self::NOMBRE_TABLA, $datos);
			} else {
				$datos[self::ID_PUBLICACION_COL] = $id_publicacion;
				$datos[self::NOMBRE_COL] = $nombre;

				$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	public function update_modulo($id = FALSE, $id_publicacion = FALSE, $nombre = "") {
		if ($id && $id_publicacion && $nombre != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			$datos = array();
			$datos[self::NOMBRE_COL] = $nombre;
			$datos[self::ID_PUBLICACION_COL] = $id_publicacion;

			$this->db->set($datos);
			$this->db->where(self::ID_COL, $id);
			$this->db->update(self::NOMBRE_TABLA);

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	public function update_modulos_publicacion($id_publicacion = FALSE, $modulos = FALSE) {
		$this->delete_modulos_publicacion($id_publicacion);

		if ($id_publicacion && $modulos) {
			$actualizado = FALSE;

			$datos = array();

			if (is_array($modulos)) {
				foreach ($modulos as $modulo) {
					$actual = array();
					$actual[self::ID_PUBLICACION_COL] = $id_publicacion;
					$actual[self::NOMBRE_COL] = $modulo;

					$datos[] = $actual;
				}

				$actualizado = $this->db->insert_batch(self::NOMBRE_TABLA, $datos);
			} else {
				$datos[self::ID_PUBLICACION_COL] = $id_publicacion;
				$datos[self::NOMBRE_COL] = $modulos;

				$actualizado = $this->db->insert(self::NOMBRE_TABLA, $datos);
			}

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	public function delete_modulos_publicacion($id_publicacion = FALSE) {
		if ($id_publicacion) {
			$eliminado = FALSE;

			$this->db->where(self::ID_PUBLICACION_COL, $id_publicacion);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

}
