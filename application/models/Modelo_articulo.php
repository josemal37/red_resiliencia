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
	const COLUMNAS_SELECT = "articulo.id_articulo as id, articulo.nombre_articulo as nombre, articulo.descripcion_articulo as descripcion, articulo.url_articulo as url, articulo.imagen_articulo as imagen, articulo.destacado_articulo as destacado, articulo.fecha_articulo as fecha";
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

	public function select_articulos($nro_pagina = FALSE, $cantidad_publicaciones = FALSE, $id_institucion = FALSE, $criterio = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->order_by(self::NOMBRE_TABLA . "." . self::FECHA_COL, "DESC");

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		if ($criterio) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_AUTOR, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . self::ID_COL, "left");
			$this->db->join(Modelo_autor::NOMBRE_TABLA, Modelo_autor::NOMBRE_TABLA . "." . Modelo_autor::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . Modelo_autor::ID_COL, "left");
			$this->db->join(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_COL, "left");
			$this->db->join(Modelo_categoria::NOMBRE_TABLA, Modelo_categoria::NOMBRE_TABLA . "." . Modelo_categoria::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . Modelo_categoria::ID_COL, "left");
			if (!$id_institucion) {
				$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL, "left");
				$this->db->join(Modelo_institucion::NOMBRE_TABLA, Modelo_institucion::NOMBRE_TABLA . "." . Modelo_institucion::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . Modelo_institucion::ID_COL, "left");
			}

			$this->db->group_start();

			$criterios = explode(", ", $criterio);

			foreach ($criterios as $criterio) {
				$this->db->or_like(Modelo_autor::NOMBRE_COL, $criterio);
				$this->db->or_like(Modelo_autor::APELLIDO_PATERNO_COL, $criterio);
				$this->db->or_like(Modelo_autor::APELLIDO_MATERNO_COL, $criterio);
				$this->db->or_like(Modelo_categoria::NOMBRE_COL, $criterio);
				if (!$id_institucion) {
					$this->db->or_like(Modelo_institucion::NOMBRE_COL, $criterio);
					$this->db->or_like(Modelo_institucion::SIGLA_COL, $criterio);
				}
				$this->db->or_like(self::NOMBRE_COL, $criterio);
				$this->db->or_like(self::DESCRIPCION_COL, $criterio);
				$this->db->or_like(self::FECHA_COL, $criterio);
			}

			$this->db->group_end();
		}

		if (!$criterio) {
			if ($nro_pagina && $cantidad_publicaciones && is_numeric($nro_pagina) && is_numeric($cantidad_publicaciones)) {
				$this->db->limit($cantidad_publicaciones, ($nro_pagina - 1) * $cantidad_publicaciones);
			}
		}

		$this->db->distinct();

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

	public function select_articulos_2($nro_pagina = FALSE, $cantidad_publicaciones = FALSE, $id_institucion = FALSE, $criterio = FALSE, $contar = FALSE) {
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->order_by(self::NOMBRE_TABLA . "." . self::FECHA_COL, "DESC");

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		if ($criterio) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_AUTOR, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . self::ID_COL, "left");
			$this->db->join(Modelo_autor::NOMBRE_TABLA, Modelo_autor::NOMBRE_TABLA . "." . Modelo_autor::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . Modelo_autor::ID_COL, "left");
			$this->db->join(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_COL, "left");
			$this->db->join(Modelo_categoria::NOMBRE_TABLA, Modelo_categoria::NOMBRE_TABLA . "." . Modelo_categoria::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . Modelo_categoria::ID_COL, "left");
			if (!$id_institucion) {
				$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL, "left");
				$this->db->join(Modelo_institucion::NOMBRE_TABLA, Modelo_institucion::NOMBRE_TABLA . "." . Modelo_institucion::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . Modelo_institucion::ID_COL, "left");
			}

			$this->db->group_start();

			$criterios = explode(", ", $criterio);

			foreach ($criterios as $criterio) {
				$this->db->or_like(Modelo_autor::NOMBRE_COL, $criterio);
				$this->db->or_like(Modelo_autor::APELLIDO_PATERNO_COL, $criterio);
				$this->db->or_like(Modelo_autor::APELLIDO_MATERNO_COL, $criterio);
				$this->db->or_like(Modelo_categoria::NOMBRE_COL, $criterio);
				if (!$id_institucion) {
					$this->db->or_like(Modelo_institucion::NOMBRE_COL, $criterio);
					$this->db->or_like(Modelo_institucion::SIGLA_COL, $criterio);
				}
				$this->db->or_like(self::NOMBRE_COL, $criterio);
				$this->db->or_like(self::DESCRIPCION_COL, $criterio);
				$this->db->or_like(self::FECHA_COL, $criterio);
			}

			$this->db->group_end();
		}

		$this->db->distinct();

		if ($contar) {
			$this->db->select(self::COLUMNAS_SELECT);
			return $this->db->count_all_results();
		} else {
			$this->db->select(self::COLUMNAS_SELECT);

			if ($nro_pagina && $cantidad_publicaciones && is_numeric($nro_pagina) && is_numeric($cantidad_publicaciones)) {
				$this->db->limit($cantidad_publicaciones, ($nro_pagina - 1) * $cantidad_publicaciones);
			}

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
	}

	public function select_articulos_con_filtro($id_categorias, $id_autor, $id_institucion) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		if ($id_autor) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_AUTOR, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . self::ID_COL);
			$this->db->where(self::NOMBRE_TABLA_ASOC_AUTOR . "." . self::ID_TABLA_ASOC_AUTOR, $id_autor);
		}

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		if ($id_categorias) {
			$this->db->where(
					"NOT EXISTS (
						SELECT
						" . Modelo_categoria::NOMBRE_TABLA . "." . Modelo_categoria::ID_COL . "
						FROM
						" . Modelo_categoria::NOMBRE_TABLA . "
						WHERE
						" . Modelo_categoria::NOMBRE_TABLA . "." . Modelo_categoria::ID_COL . " IN (" . implode(", ", $id_categorias) . ") AND
						NOT EXISTS (
							SELECT
							" . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_TABLA_ASOC_CATEGORIA . ", " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_COL . "
							FROM
							" . self::NOMBRE_TABLA_ASOC_CATEGORIA . "
							WHERE
							" . self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_COL . " AND
							" . Modelo_categoria::NOMBRE_TABLA . "." . Modelo_categoria::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . Modelo_categoria::ID_COL . "
						)
					)"
					, NULL, FALSE);
		}

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

	public function select_articulo_por_id($id = FALSE, $id_institucion = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID_COL, $id);

			if ($id_institucion) {
				$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
				$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
			}

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

	public function select_count_articulos($id_institucion = FALSE) {
		if ($id_institucion) {
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
			return $this->db->count_all_results();
		} else {
			return $this->db->count_all(self::NOMBRE_TABLA);
		}
	}

	public function select_count_nro_paginas($cantidad_articulos_por_pagina = FALSE, $id_institucion = FALSE) {
		if ($cantidad_articulos_por_pagina) {
			$nro_paginas = 0;

			$nro_articulos = $this->select_count_articulos($id_institucion);

			if ($nro_articulos % $cantidad_articulos_por_pagina == 0) {
				$nro_paginas = (integer) ($nro_articulos / $cantidad_articulos_por_pagina);
			} else {
				$nro_paginas = (integer) ($nro_articulos / $cantidad_articulos_por_pagina) + 1;
			}

			return $nro_paginas;
		} else {
			return 0;
		}
	}

}
