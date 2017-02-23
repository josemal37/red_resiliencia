<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_Publicacion
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_publicacion extends My_model {

	const ID_COL = "id_publicacion";
	const NOMBRE_COL = "nombre_publicacion";
	const DESCRIPCION_COL = "descripcion_publicacion";
	const URL_COL = "url_publicacion";
	const IMAGEN_COL = "imagen_publicacion";
	const DESTACADA_COL = "destacada_publicacion";
	const FECHA_COL = "fecha_publicacion";
	const COLUMNAS_SELECT = "publicacion.id_publicacion as id, publicacion.nombre_publicacion as nombre, publicacion.descripcion_publicacion as descripcion, publicacion.url_publicacion as url, publicacion.imagen_publicacion as imagen, publicacion.destacada_publicacion as destacada, publicacion.fecha_publicacion as publicacion";
	const NOMBRE_TABLA = "publicacion";
	const NOMBRE_TABLA_ASOC_AUTOR = "autor_publicacion";
	const ID_TABLA_ASOC_AUTOR = "id_autor";
	const NOMBRE_TABLA_ASOC_CATEGORIA = "categoria_publicacion";
	const ID_TABLA_ASOC_CATEGORIA = "id_categoria";
	const NOMBRE_TABLA_ASOC_INSTITUCION = "institucion_publicacion";
	const ID_TABLA_ASOC_INSTITUCION = "id_institucion";

	public function __construct() {
		$this->load->model(array("Modelo_categoria", "Modelo_institucion", "Modelo_modulo"));
		parent::__construct();
	}

	public function select_publicaciones($nro_pagina = FALSE, $cantidad_publicaciones = FALSE, $id_institucion = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		if ($nro_pagina && $cantidad_publicaciones && is_numeric($nro_pagina) && is_numeric($cantidad_publicaciones)) {
			$this->db->limit($cantidad_publicaciones, ($nro_pagina - 1) * $cantidad_publicaciones);
		}

		$this->db->order_by(self::NOMBRE_TABLA . "." . self::ID_COL . " DESC, " . self::NOMBRE_TABLA . "." . self::FECHA_COL . " DESC");

		$query = $this->db->get();

		$publicaciones = $this->return_result($query);

		if ($publicaciones) {
			$i = 0;

			foreach ($publicaciones as $publicacion) {
				//cargamos las categorias
				$categorias = $this->Modelo_categoria->select_categoria_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicaciones[$i]->categorias = $categorias;

				//cargamos las instituciones
				$instituciones = $this->Modelo_institucion->select_institucion_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicaciones[$i]->instituciones = $instituciones;

				//cargamos los autores
				$autores = $this->Modelo_autor->select_autor_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicaciones[$i]->autores = $autores;

				//cargamos los modulos
				$modulos = $this->Modelo_modulo->select_modulos($publicacion->id);
				$publicaciones[$i]->modulos = $modulos;

				$i += 1;
			}
		}

		return $publicaciones;
	}

	public function select_publicacion_por_id($id = FALSE, $id_institucion = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA. "." . self::ID_COL, $id);

			if ($id_institucion) {
				$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
				$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
			}

			$query = $this->db->get();

			$publicacion = $this->return_row($query);

			if ($publicacion) {
				$categorias = $this->Modelo_categoria->select_categoria_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicacion->categorias = $categorias;

				//cargamos las instituciones
				$instituciones = $this->Modelo_institucion->select_institucion_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicacion->instituciones = $instituciones;

				//cargamos los autores
				$autores = $this->Modelo_autor->select_autor_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicacion->autores = $autores;

				//cargamos los modulos
				$modulos = $this->Modelo_modulo->select_modulos($publicacion->id);
				$publicacion->modulos = $modulos;
			}

			return $publicacion;
		} else {
			return FALSE;
		}
	}

	public function insert_publicacion($nombre = "", $descripcion = "", $modulos = FALSE, $url = "", $imagen = "", $destacada = FALSE, $fecha = FALSE, $id_autor = FALSE, $id_categoria = FALSE, $id_institucion = FALSE) {
		if ($nombre != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			$datos = array();
			$datos[self::NOMBRE_COL] = $nombre;
			$datos[self::DESCRIPCION_COL] = $descripcion;
			$datos[self::URL_COL] = $url;
			$datos[self::IMAGEN_COL] = $imagen;
			$datos[self::DESTACADA_COL] = $destacada;
			$this->db->set(self::FECHA_COL, $fecha);

			$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);

			if ($insertado) {
				$id_publicacion = $this->db->insert_id();

				$this->Modelo_modulo->insert_modulo($id_publicacion, $modulos);
				$this->insert_categoria_a_publicacion($id_publicacion, $id_categoria);
				$this->insert_autor_a_publicacion($id_publicacion, $id_autor);
				$this->insert_institucion_a_publicacion($id_publicacion, $id_institucion);
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	private function insert_autor_a_publicacion($id_publicacion = FALSE, $id_autor = FALSE) {
		if ($id_publicacion && $id_autor) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_AUTOR, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_AUTOR, $id_autor);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	private function insert_categoria_a_publicacion($id_publicacion = FALSE, $id_categoria = FALSE) {
		if ($id_publicacion && $id_categoria) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_CATEGORIA, $id_categoria);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	private function insert_institucion_a_publicacion($id_publicacion = FALSE, $id_institucion = FALSE) {
		if ($id_publicacion && $id_institucion) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	public function update_publicacion($id = FALSE, $nombre = "", $descripcion = "", $modulos = FALSE, $url = "", $imagen = "", $destacada = FALSE, $id_autor = FALSE, $id_categoria = FALSE, $id_institucion = FALSE) {
		if ($id && $nombre != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			$this->db->set(self::NOMBRE_COL, $nombre);
			$this->db->set(self::DESCRIPCION_COL, $descripcion);
			$this->db->set(self::URL_COL, $url);
			$this->db->set(self::IMAGEN_COL, $imagen);
			$this->db->set(self::DESTACADA_COL, $destacada);

			$this->db->where(self::ID_COL, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->update_autores_de_publicacion($id, $id_autor);
			$this->update_categorias_de_publicacion($id, $id_categoria);
			$this->update_instituciones_de_publicacion($id, $id_institucion);
			$this->Modelo_modulo->update_modulos_publicacion($id, $modulos);

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	private function update_autores_de_publicacion($id_publicacion = FALSE, $id_autores = FALSE) {
		$this->delete_autores_de_publicacion($id_publicacion);

		if ($id_publicacion && $id_autores) {
			$actualizado = FALSE;

			$actualizado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_AUTOR, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_AUTOR, $id_autores);

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	private function update_categorias_de_publicacion($id_publicacion = FALSE, $id_categoria = FALSE) {
		$this->delete_categorias_de_publicacion($id_publicacion);

		if ($id_publicacion && $id_categoria) {
			$asociado = FALSE;
			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_CATEGORIA, $id_categoria);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	private function update_instituciones_de_publicacion($id_publicacion = FALSE, $id_institucion = FALSE) {
		$this->delete_instituciones_de_publicacion($id_publicacion);

		if ($id_publicacion && $id_institucion) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	public function delete_publicacion($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->trans_start();

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_autores_de_publicacion($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_AUTOR);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_categorias_de_publicacion($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_CATEGORIA);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_instituciones_de_publicacion($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_INSTITUCION);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	public function select_count_publicaciones($id_institucion = FALSE) {
		if ($id_institucion) {
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
			return $this->db->count_all_results();
		} else {
			return $this->db->count_all(self::NOMBRE_TABLA);
		}
	}

	public function select_count_nro_paginas($cantidad_publicaciones_por_pagina = FALSE, $id_institucion = FALSE) {
		if ($cantidad_publicaciones_por_pagina) {
			$nro_paginas = 0;

			$nro_publicaciones = $this->select_count_publicaciones($id_institucion);

			if ($nro_publicaciones % $cantidad_publicaciones_por_pagina == 0) {
				$nro_paginas = (integer) ($nro_publicaciones / $cantidad_publicaciones_por_pagina);
			} else {
				$nro_paginas = (integer) ($nro_publicaciones / $cantidad_publicaciones_por_pagina) + 1;
			}

			return $nro_paginas;
		} else {
			return 0;
		}
	}

}
