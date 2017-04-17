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
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_autor extends My_model {

	const ID_COL = "id_autor";
	const NOMBRE_COL = "nombre_autor";
	const APELLIDO_PATERNO_COL = "apellido_paterno_autor";
	const APELLIDO_MATERNO_COL = "apellido_materno_autor";
	const COLUMNAS_SELECT = "autor.id_autor as id, autor.nombre_autor as nombre, autor.apellido_paterno_autor as apellido_paterno, autor.apellido_materno_autor as apellido_materno";
	const NOMBRE_TABLA = "autor";
	const NOMBRE_TABLA_JOIN_PUBLICACION = "autor_publicacion";
	const ID_PUBLICACION_COL = "id_publicacion";
	const NOMBRE_TABLA_JOIN_ARTICULO = "autor_articulo";
	const ID_ARTICULO_COL = "id_articulo";
	const NOMBRE_TABLA_JOIN_HERRAMIENTA = "autor_herramienta";
	const ID_HERRAMIENTA_COL = "id_herramienta";
	const NOMBRE_TABLA_ASOC_INSTITUCION = "institucion_autor";
	const ID_TABLA_ASOC_INSTITUCION = "id_institucion";

	public function __construct() {
		$this->load->model(array("Modelo_institucion"));
		parent::__construct();
	}

	public function select_autores($id_institucion = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->order_by(self::NOMBRE_COL . ", " . self::APELLIDO_PATERNO_COL. ", " . self::APELLIDO_MATERNO_COL);

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL . " = " . self::NOMBRE_TABLA . "." . self::ID_COL, "left");
			$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		$query = $this->db->get();

		$autores = $this->return_result($query);

		$i = 0;
		if ($autores) {
			foreach ($autores as $autor) {
				$instituciones = $this->Modelo_institucion->select_institucion_por_id($autor->id, "autor");
				$autores[$i]->instituciones = $instituciones;

				$autores[$i]->nombre_completo = $this->get_nombre_completo($autor);

				$i += 1;
			}
		}

		return $autores;
	}

	public function select_autor_por_id($id = FALSE, $nombre_tabla = "", $id_otra_tabla = FALSE) {
		if ($id) {
			$datos = FALSE;

			switch ($nombre_tabla) {
				case "":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->where(self::ID_COL, $id);

					$query = $this->db->get();

					$autor = $this->return_row($query);

					if ($autor) {
						$instituciones = $this->Modelo_institucion->select_institucion_por_id($autor->id, "autor");
						$autor->instituciones = $instituciones;

						$autor->nombre_completo = $this->get_nombre_completo($autor);
					}

					$datos = $autor;
					break;
				case "publicacion":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->join(self::NOMBRE_TABLA_JOIN_PUBLICACION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_JOIN_PUBLICACION . "." . self::ID_COL, "left");
					$this->db->where(self::NOMBRE_TABLA_JOIN_PUBLICACION . "." . self::ID_PUBLICACION_COL, $id);

					$query = $this->db->get();

					$autores = $this->return_result($query);

					if ($autores) {
						$i = 0;

						foreach ($autores as $autor) {
							$autores[$i]->nombre_completo = $this->get_nombre_completo($autor);

							$i += 1;
						}
					}

					$datos = $autores;
					break;
				case "articulo":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->join(self::NOMBRE_TABLA_JOIN_ARTICULO, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_JOIN_ARTICULO . "." . self::ID_COL, "left");
					$this->db->where(self::NOMBRE_TABLA_JOIN_ARTICULO . "." . self::ID_ARTICULO_COL, $id);

					$query = $this->db->get();

					$autores = $this->return_result($query);

					if ($autores) {
						$i = 0;

						foreach ($autores as $autor) {
							$autores[$i]->nombre_completo = $this->get_nombre_completo($autor);

							$i += 1;
						}
					}

					$datos = $autores;
					break;
				case "herramienta":
					$this->db->select(self::COLUMNAS_SELECT);
					$this->db->from(self::NOMBRE_TABLA);
					$this->db->join(self::NOMBRE_TABLA_JOIN_HERRAMIENTA, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_JOIN_HERRAMIENTA . "." . self::ID_COL, "left");
					$this->db->where(self::NOMBRE_TABLA_JOIN_HERRAMIENTA . "." . self::ID_HERRAMIENTA_COL, $id);

					$query = $this->db->get();

					$autores = $this->return_result($query);

					if ($autores) {
						$i = 0;

						foreach ($autores as $autor) {
							$autores[$i]->nombre_completo = $this->get_nombre_completo($autor);

							$i += 1;
						}
					}

					$datos = $autores;
					break;
				case "institucion":
					if ($id_otra_tabla) {
						$this->db->select(self::COLUMNAS_SELECT);
						$this->db->from(self::NOMBRE_TABLA);
						$this->db->where(self::NOMBRE_TABLA . "." . self::ID_COL, $id);
						$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL . " = " . self::NOMBRE_TABLA . "." . self::ID_COL, "left");
						$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_TABLA_ASOC_INSTITUCION, $id_otra_tabla);

						$query = $this->db->get();

						$autor = $this->return_row($query);

						if ($autor) {

							$instituciones = $this->Modelo_institucion->select_institucion_por_id($autor->id, "autor");
							$autor->instituciones = $instituciones;
							$autor->nombre_completo = $this->get_nombre_completo($autor);
						}

						$datos = $autor;
					} else {
						$datos = FALSE;
					}

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
			} else {
				$this->session->set_flashdata("existe", "El autor ya se encuentra registrado.");
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
					$this->delete_autor_de_instituciones($id);
					$this->insert_autor_a_institucion($id, $id_institucion);
				}
			} else {
				$this->session->set_flashdata("existe", "El autor ya se encuentra registrado.");
			}

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	public function delete_autor($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->trans_start();

			$this->delete_autor_de_instituciones($id);
			$this->delete_autor_de_articulos($id);
			$this->delete_autor_de_herramientas($id);
			$this->delete_autor_de_publicaciones($id);

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_autor_de_instituciones($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_INSTITUCION);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_autor_de_articulos($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_JOIN_ARTICULO);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_autor_de_herramientas($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_JOIN_HERRAMIENTA);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_autor_de_publicaciones($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_JOIN_PUBLICACION);

			return $eliminado;
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

		if ($autor) {
			$existe = TRUE;
		}

		return $existe;
	}

	private function get_nombre_completo($autor = FALSE) {
		if ($autor) {
			$nombre_completo = FALSE;

			if (isset($autor->nombre)) {
				$nombre_completo = $autor->nombre;
			}

			if ($autor->apellido_paterno) {
				$nombre_completo .= " " . $autor->apellido_paterno;
			}

			if ($autor->apellido_paterno) {
				$nombre_completo .= " " . $autor->apellido_materno;
			}

			return $nombre_completo;
		} else {
			return FALSE;
		}
	}

}
