<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_articulo
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_articulo extends My_model {

	const ID_COL = "id_articulo";
	const NOMBRE_COL = "nombre_articulo";
	const DESCRIPCION_COL = "descripcion_articulo";
	const URL_COL = "url_articulo";
	const IMAGEN_COL = "imagen_articulo";
	const DESTACADO_COL = "destacado_articulo";
	const FECHA_COL = "fecha_articulo";
	const COLUMNAS_SELECT = "id_articulo as id, nombre_articulo as nombre, descripcion_articulo as descripcion, url_articulo as url, imagen_articulo as imagen, destacado_articulo as destacado, fecha_articulo as fecha";
	const NOMBRE_TABLA = "articulo";
	const NOMBRE_TABLA_ASOC_AUTOR = "autor_articulo";
	const ID_TABLA_ASOC_AUTOR = "id_autor";
	const NOMBRE_TABLA_ASOC_CATEGORIA = "categoria_articulo";
	const ID_TABLA_ASOC_CATEGORIA = "id_categoria";
	const NOMBRE_TABLA_ASOC_INSTITUCION = "institucion_articulo";
	const ID_TABLA_ASOC_INSTITUCION = "id_institucion";

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_categoria", "Modelo_institucion", "Modelo_modulo"));
	}

	public function select_articulos() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->order_by(self::NOMBRE_TABLA . "." . self::FECHA_COL);

		$query = $this->db->get();

		$articulos = $this->return_result($query);

		if ($articulos) {
			$i = 0;

			foreach ($articulos as $articulo) {
				$categorias = $this->Modelo_categoria->select_categoria_por_id($articulo->id, self::NOMBRE_TABLA);
				$articulos[$i]->categorias = $categorias;

				$instituciones = $this->Modelo_institucion->select_institucion_por_id($articulo->id, self::NOMBRE_TABLA);
				$articulos[$i]->instituciones = $instituciones;

				$autores = $this->Modelo_autor->select_autor_por_id($articulo->id, self::NOMBRE_TABLA);
				$articulos[$i]->autores = $autores;

				$i += 1;
			}
		}

		return $articulos;
	}

	public function select_articulo_por_id($id = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID_COL, $id);

			$query = $this->db->get();

			$articulo = $this->return_row($query);

			if ($articulo) {
				$categorias = $this->Modelo_categoria->select_categoria_por_id($articulo->id, self::NOMBRE_TABLA);
				$articulo->categorias = $categorias;

				$instituciones = $this->Modelo_institucion->select_institucion_por_id($articulo->id, self::NOMBRE_TABLA);
				$articulo->instituciones = $instituciones;

				$autores = $this->Modelo_autor->select_autor_por_id($articulo->id, self::NOMBRE_TABLA);
				$articulo->autores = $autores;
			}

			return $articulo;
		} else {
			return FALSE;
		}
	}

	public function insert_articulo($nombre = "", $descripcion = "", $url = "", $imagen = "", $fecha = "", $id_autor = FALSE, $id_categoria = FALSE, $id_institucion = FALSE) {
		if ($nombre != "" && $url != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			$datos = array(
				self::NOMBRE_COL => $nombre,
				self::DESCRIPCION_COL => $descripcion,
				self::URL_COL => $url,
				self::IMAGEN_COL => $imagen
			);
			if ($fecha != "") {
				$datos[self::FECHA_COL] = $fecha;
			} else {
				$this->db->set(self::FECHA_COL, "NOW()", FALSE);
			}
			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			if ($insertado) {
				$id_articulo = $this->db->insert_id();

				$this->insert_categoria_a_articulo($id_articulo, $id_categoria);
				$this->insert_autor_a_articulo($id_articulo, $id_autor);
				$this->insert_institucion_a_articulo($id_articulo, $id_institucion);
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	private function insert_autor_a_articulo($id_articulo = FALSE, $id_autor = FALSE) {
		if ($id_articulo && $id_autor) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_AUTOR, self::ID_COL, $id_articulo, self::ID_TABLA_ASOC_AUTOR, $id_autor);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	private function insert_categoria_a_articulo($id_articulo = FALSE, $id_categoria = FALSE) {
		if ($id_articulo && $id_categoria) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::ID_COL, $id_articulo, self::ID_TABLA_ASOC_CATEGORIA, $id_categoria);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	private function insert_institucion_a_articulo($id_articulo = FALSE, $id_institucion = FALSE) {
		if ($id_articulo && $id_institucion) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::ID_COL, $id_articulo, self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);

			return $asociado;
		} else {
			return FALSE;
		}
	}
	
	public function update_articulo($id = FALSE, $nombre = "", $descripcion = "", $imagen = "", $fecha = "", $id_autor = FALSE, $id_categoria = FALSE, $id_institucion = FALSE) {
		if ($id && $nombre != "") {
			$actualizado = FALSE;
			
			$this->db->trans_start();
			
			$datos = array(
				self::NOMBRE_COL => $nombre,
				self::DESCRIPCION_COL => $descripcion,
				self::IMAGEN_COL => $imagen
			);
			if ($fecha != "") {
				$datos[self::FECHA_COL] = $fecha;
			} else {
				$this->db->set(self::FECHA_COL, "NOW()", FALSE);
			}
			
			$this->db->set($datos);
			
			$this->db->where(self::ID_COL, $id);
			
			$actualizado = $this->db->update(self::NOMBRE_TABLA);
			
			$this->update_autores_de_articulo($id, $id_autor);
			$this->update_categorias_de_articulo($id, $id_categoria);
			$this->update_instituciones_de_articulo($id, $id_institucion);
			
			$this->db->trans_complete();
			
			return $actualizado;
		} else {
			return FALSE;
		}
	}
	
	private function update_autores_de_articulo($id_articulo = FALSE, $id_autores = FALSE) {
		$actualizado = FALSE;
		
		if ($id_articulo !== FALSE && $id_autores !== FALSE) {
			if ($this->delete_autores_de_articulo($id_articulo)) {
				$actualizado = $this->insert_autor_a_articulo($id_articulo, $id_autores);
			}
		}
		
		return $actualizado;
	}
	
	private function update_categorias_de_articulo($id_articulo = FALSE, $id_categorias = FALSE) {
		$actualizado = FALSE;
		
		if ($id_articulo !== FALSE && $id_categorias !== FALSE) {
			if ($this->delete_categorias_de_articulo($id_articulo)) {
				$actualizado = $this->insert_categoria_a_articulo($id_articulo, $id_categorias);
			}
		}
		
		return $actualizado;
	}
	
	private function update_instituciones_de_articulo($id_articulo = FALSE, $id_instituciones = FALSE) {
		$actualizado = FALSE;
		
		if ($id_articulo !== FALSE && $id_instituciones !== FALSE) {
			if ($this->delete_instituciones_de_articulo($id_articulo)) {
				$actualizado = $this->insert_institucion_a_articulo($id_articulo, $id_instituciones);
			}
		}
		
		return $actualizado;
	}
	
	public function delete_articulo($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;
			
			$this->db->trans_start();
			
			$this->delete_autores_de_articulo($id);
			$this->delete_categorias_de_articulo($id);
			$this->delete_instituciones_de_articulo($id);
			
			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA);
			
			$this->db->trans_complete();
			
			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_autores_de_articulo($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_AUTOR);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_categorias_de_articulo($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_CATEGORIA);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_instituciones_de_articulo($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_INSTITUCION);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

}
