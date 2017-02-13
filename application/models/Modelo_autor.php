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
	const COLUMNAS_SELECT = "autor.id_autor as id, autor.nombre_autor as nombre, autor.apellido_paterno_autor as apellido_paterno, autor.apellido_materno_autor as apellido_materno";
	const NOMBRE_TABLA = "autor";
	const NOMBRE_TABLA_JOIN_PUBLICACION = "autor_publicacion";
	const ID_PUBLICACION_COL = "id_publicacion";
	const NOMBRE_TABLA_ASOC_INSTITUCION = "institucion_autor";
	const ID_TABLA_ASOC_INSTITUCION = "id_institucion";

	public function __construct() {
		$this->load->model(array("Modelo_institucion"));
		parent::__construct();
	}

	public function select_autores() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		$query = $this->db->get();

		$autores = $this->return_result($query);

		$i = 0;
		if ($autores) {
			foreach ($autores as $autor) {
				$instituciones = $this->Modelo_institucion->select_institucion_por_id($autor->id, "autor");
				$autores[$i]->instituciones = $instituciones;

				$i += 1;
			}
		}

		return $autores;
	}

	public function select_autor_por_id($id = FALSE, $nombre_tabla = "") {
		if ($id) {
			$datos = FALSE;

			switch ($nombre_tabla) {
				case "":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->where(self::ID_COL, $id);

					$query = $this->db->get();

					$datos = $this->return_row($query);

					if ($datos) {
						$instituciones = $this->Modelo_institucion->select_institucion_por_id($datos->id, "autor");
						$datos->instituciones = $instituciones;
					}
					break;
				case "publicacion":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->join(self::NOMBRE_TABLA_JOIN_PUBLICACION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_JOIN_PUBLICACION . "." . self::ID_COL, "left");
					$this->db->where(self::NOMBRE_TABLA_JOIN_PUBLICACION . "." . self::ID_PUBLICACION_COL, $id);

					$query = $this->db->get();

					$datos = $this->return_result($query);
					break;
			}

			return $datos;
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

	public function insert_autor($nombre = "", $apellido_paterno = "", $apellido_materno = "", $id_institucion = FALSE) {
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

				if ($insertado) {
					$id_autor = $this->db->insert_id();

					$this->insert_autor_a_institucion($id_autor, $id_institucion);
				}
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	private function insert_autor_a_institucion($id_autor = FALSE, $id_institucion = FALSE) {
		if ($id_autor && $id_institucion) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::ID_COL, $id_autor, self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);

			return $asociado;
		} else {
			return FALSE;
		}
	}
	
	private function delete_instituciones_de_autor($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;
			
			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_INSTITUCION);
			
			return $eliminado;
		} else {
			return FALSE;
		}
	}

	public function update_autor($id = FALSE, $nombre = "", $apellido_paterno = "", $apellido_materno = "", $id_institucion = FALSE) {
		if ($id && $nombre != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			//verificamos si existe
			$existe = $this->existe_diferente_id($id, $nombre, $apellido_paterno, $apellido_materno);

			if (!$existe) {
				$datos = array();
				$datos[self::NOMBRE_COL] = $nombre;
				$datos[self::APELLIDO_PATERNO_COL] = $apellido_paterno;
				$datos[self::APELLIDO_MATERNO_COL] = $apellido_materno;
				$this->db->set($datos);
				$this->db->where(self::ID_COL, $id);

				$actualizado = $this->db->update(self::NOMBRE_TABLA);
				
				if ($actualizado) {
					$this->delete_instituciones_de_autor($id);
					$this->insert_autor_a_institucion($id, $id_institucion);
				}
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
	
	public function existe_diferente_id($id = FALSE, $nombre = "", $apellido_paterno = "", $apellido_materno = "") {
		$existe = FALSE;
		
		$datos = array();
		$datos[self::ID_COL . "!="] = $id;
		$datos[self::NOMBRE_COL] = $nombre;
		$datos[self::APELLIDO_PATERNO_COL] = $apellido_paterno;
		$datos[self::APELLIDO_MATERNO_COL] = $apellido_materno;
		
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
