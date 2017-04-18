<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_herramienta
 *
 * @author Jose
 */
require_once 'My_model.php';

class Modelo_herramienta extends My_model {

	const ID_COL = "id_herramienta";
	const NOMBRE_COL = "nombre_herramienta";
	const DESCRIPCION_COL = "descripcion_herramienta";
	const IMAGEN_COL = "imagen_herramienta";
	const VIDEO_COL = "video_herramienta";
	const URL_COL = "url_herramienta";
	const FECHA_COL = "fecha_herramienta";
	const COLUMNAS_SELECT = "herramienta.id_herramienta as id, herramienta.nombre_herramienta as nombre, herramienta.descripcion_herramienta as descripcion, herramienta.imagen_herramienta as imagen, herramienta.video_herramienta as video, herramienta.url_herramienta as url";
	const NOMBRE_TABLA = "herramienta";
	const NOMBRE_TABLA_ASOC_AUTOR = "autor_herramienta";
	const ID_TABLA_ASOC_AUTOR = "id_autor";
	const NOMBRE_TABLA_ASOC_CATEGORIA = "categoria_herramienta";
	const ID_TABLA_ASOC_CATEGORIA = "id_categoria";
	const NOMBRE_TABLA_ASOC_INSTITUCION = "institucion_herramienta";
	const ID_TABLA_ASOC_INSTITUCION = "id_institucion";

	public function __construct() {
		parent::__construct();
	}

	public function select_herramientas($nro_pagina = FALSE, $cantidad_registros = FALSE, $id_institucion = FALSE, $criterio = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL . " = " . self::NOMBRE_TABLA . "." . self::ID_COL);
			$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		if ($criterio) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_COL, "left");
			$this->db->join(Modelo_categoria::NOMBRE_TABLA, Modelo_categoria::NOMBRE_TABLA . "." . Modelo_categoria::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . Modelo_categoria::ID_COL, "left");
			$this->db->join(self::NOMBRE_TABLA_ASOC_AUTOR, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . self::ID_COL, "left");
			$this->db->join(Modelo_autor::NOMBRE_TABLA, Modelo_autor::NOMBRE_TABLA . "." . Modelo_autor::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . Modelo_autor::ID_COL, "left");
			if (!$id_institucion) {
				$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL, "left");
				$this->db->join(Modelo_institucion::NOMBRE_TABLA, Modelo_institucion::NOMBRE_TABLA . "." . Modelo_institucion::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . Modelo_institucion::ID_COL, "left");
			}

			$this->db->group_start();

			$criterios = explode(", ", $criterio);

			foreach ($criterios as $criterio) {
				$this->db->like(Modelo_categoria::NOMBRE_COL, $criterio);
				$this->db->or_like(Modelo_autor::NOMBRE_COL, $criterio);
				$this->db->or_like(Modelo_autor::APELLIDO_PATERNO_COL, $criterio);
				$this->db->or_like(Modelo_autor::APELLIDO_MATERNO_COL, $criterio);
				if (!$id_institucion) {
					$this->db->or_like(Modelo_institucion::NOMBRE_COL, $criterio);
					$this->db->or_like(Modelo_institucion::SIGLA_COL, $criterio);
				}
				$this->db->or_like(self::NOMBRE_COL, $criterio);
				$this->db->or_like(self::DESCRIPCION_COL, $criterio);
			}

			$this->db->group_end();
		}

		$this->db->distinct();

		if ($nro_pagina && $cantidad_registros) {
			$this->db->limit($cantidad_registros, ($nro_pagina - 1) * $cantidad_registros);
		}

		$this->db->order_by(self::FECHA_COL, "desc");

		$query = $this->db->get();

		$herramientas = $this->return_result($query);

		if ($herramientas) {
			foreach ($herramientas as $herramienta) {
				$this->cargar_datos_adicionales($herramienta);
			}
		}

		return $herramientas;
	}

	public function select_herramientas_2($nro_pagina = FALSE, $cantidad_registros = FALSE, $id_autor = FALSE, $id_categoria = FALSE, $id_institucion = FALSE, $criterio = FALSE, $contar = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		if ($id_autor) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_AUTOR, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . self::ID_COL, "left");
			$this->db->where(Modelo_autor::ID_COL, $id_autor);
		}
		
		if ($id_categoria) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_COL, "left");
			$this->db->where(Modelo_categoria::ID_COL, $id_categoria);
		}

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL . " = " . self::NOMBRE_TABLA . "." . self::ID_COL);
			$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		if ($criterio) {
			$this->db->group_start();

			$criterios = explode(", ", $criterio);

			foreach ($criterios as $criterio) {
				$this->db->or_like(self::NOMBRE_COL, $criterio);
				$this->db->or_like(self::DESCRIPCION_COL, $criterio);
			}

			$this->db->group_end();
		}

		$this->db->distinct();

		$this->db->order_by(self::FECHA_COL, "desc");

		if ($contar) {
			return $this->db->count_all_results();
		} else {
			if ($nro_pagina && $cantidad_registros) {
				$this->db->limit($cantidad_registros, ($nro_pagina - 1) * $cantidad_registros);
			}

			$query = $this->db->get();

			$herramientas = $this->return_result($query);

			if ($herramientas) {
				foreach ($herramientas as $herramienta) {
					$this->cargar_datos_adicionales($herramienta);
				}
			}

			return $herramientas;
		}
	}

	public function select_count_herramientas($id_institucion = FALSE) {
		$this->db->from(self::NOMBRE_TABLA);

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL . " = " . self::NOMBRE_TABLA . "." . self::ID_COL);
			$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		$cantidad = $this->db->count_all_results();

		return $cantidad;
	}

	public function select_herramientas_con_filtro($id_categorias, $id_autor, $id_institucion) {
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

		$herramientas = $this->return_result($query);

		if ($herramientas) {
			$i = 0;

			foreach ($herramientas as $herramienta) {
				$categorias = $this->Modelo_categoria->select_categoria_por_id($herramienta->id, self::NOMBRE_TABLA);
				$herramientas[$i]->categorias = $categorias;

				$instituciones = $this->Modelo_institucion->select_institucion_por_id($herramienta->id, self::NOMBRE_TABLA);
				$herramientas[$i]->instituciones = $instituciones;

				$autores = $this->Modelo_autor->select_autor_por_id($herramienta->id, self::NOMBRE_TABLA);
				$herramientas[$i]->autores = $autores;

				$i += 1;
			}
		}

		return $herramientas;
	}

	public function select_herramienta($id = FALSE, $id_institucion = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID_COL, $id);

			if ($id_institucion) {
				$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL . " = " . self::NOMBRE_TABLA . "." . self::ID_COL);
				$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
			}

			$query = $this->db->get();

			$herramienta = $this->return_row($query);

			if ($herramienta) {
				$this->cargar_datos_adicionales($herramienta);
			}

			return $herramienta;
		} else {
			return FALSE;
		}
	}

	private function cargar_datos_adicionales(&$herramienta = FALSE) {
		if ($herramienta) {
			$id_herramienta = $herramienta->id;
			$herramienta->autores = $this->Modelo_autor->select_autor_por_id($id_herramienta, "herramienta");
			$herramienta->categorias = $this->Modelo_categoria->select_categoria_por_id($id_herramienta, "herramienta");
			$herramienta->instituciones = $this->Modelo_institucion->select_institucion_por_id($id_herramienta, "herramienta");
		}
	}

	public function insert_herramienta($nombre = "", $descripcion = "", $imagen = "", $video = "", $url = "", $id_autores = FALSE, $id_categorias = FALSE, $id_instituciones = FALSE) {
		if ($nombre != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			$datos = array(
				self::NOMBRE_COL => $nombre,
				self::DESCRIPCION_COL => $descripcion,
				self::IMAGEN_COL => $imagen,
				self::VIDEO_COL => $video,
				self::URL_COL => $url
			);

			$this->db->set(self::FECHA_COL, "NOW()", FALSE);

			$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);

			if ($insertado) {
				$id_herramienta = $this->db->insert_id();

				$this->insert_autor_a_herramienta($id_herramienta, $id_autores);
				$this->insert_categoria_a_herramienta($id_herramienta, $id_categorias);
				$this->insert_institucion_a_herramienta($id_herramienta, $id_instituciones);
			}

			$this->db->trans_complete();

			return $insertado;
		}
	}

	private function insert_autor_a_herramienta($id_herramienta = FALSE, $id_autores = FALSE) {
		if ($id_herramienta && $id_autores) {
			$insertado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_AUTOR, self::ID_COL, $id_herramienta, self::ID_TABLA_ASOC_AUTOR, $id_autores);

			return $insertado;
		} else {
			return FALSE;
		}
	}

	private function insert_categoria_a_herramienta($id_herramienta = FALSE, $id_categorias = FALSE) {
		if ($id_herramienta && $id_categorias) {
			$insertado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::ID_COL, $id_herramienta, self::ID_TABLA_ASOC_CATEGORIA, $id_categorias);

			return $insertado;
		} else {
			return FALSE;
		}
	}

	private function insert_institucion_a_herramienta($id_herramienta = FALSE, $id_instituciones = FALSE) {
		if ($id_herramienta && $id_instituciones) {
			$insertado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::ID_COL, $id_herramienta, self::ID_TABLA_ASOC_INSTITUCION, $id_instituciones);

			return $insertado;
		} else {
			return FALSE;
		}
	}

	public function update_herramienta($id = FALSE, $nombre = "", $descripcion = "", $imagen = "", $video = "", $url = "", $id_autores = FALSE, $id_categorias = FALSE, $id_instituciones = FALSE) {
		if ($id && $nombre != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			$datos = array(
				self::NOMBRE_COL => $nombre,
				self::DESCRIPCION_COL => $descripcion,
				self::IMAGEN_COL => $imagen,
				self::VIDEO_COL => $video,
				self::URL_COL => $url
			);

			$this->db->set($datos);

			$this->db->where(self::ID_COL, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->update_autores_de_herramienta($id, $id_autores);
			$this->update_categorias_de_herramientas($id, $id_categorias);
			$this->update_instituciones_de_herramientas($id, $id_instituciones);

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	private function update_autores_de_herramienta($id_herramienta, $id_autores) {
		$this->delete_autores_de_herramienta($id_herramienta);
		$this->insert_autor_a_herramienta($id_herramienta, $id_autores);
	}

	private function update_categorias_de_herramientas($id_herramienta, $id_categorias) {
		$this->delete_categorias_de_herramienta($id_herramienta);
		$this->insert_categoria_a_herramienta($id_herramienta, $id_categorias);
	}

	private function update_instituciones_de_herramientas($id_herramienta, $id_instituciones) {
		$this->delete_instituciones_de_herramienta($id_herramienta);
		$this->insert_institucion_a_herramienta($id_herramienta, $id_instituciones);
	}

	public function delete_herramienta($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->trans_start();

			$this->delete_autores_de_herramienta($id);
			$this->delete_categorias_de_herramienta($id);
			$this->delete_instituciones_de_herramienta($id);

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_autores_de_herramienta($id_herramienta = FALSE) {
		if ($id_herramienta) {
			$this->db->where(self::ID_COL, $id_herramienta);
			return $this->db->delete(self::NOMBRE_TABLA_ASOC_AUTOR);
		} else {
			return FALSE;
		}
	}

	private function delete_categorias_de_herramienta($id_herramienta = FALSE) {
		if ($id_herramienta) {
			$this->db->where(self::ID_COL, $id_herramienta);
			return $this->db->delete(self::NOMBRE_TABLA_ASOC_CATEGORIA);
		} else {
			return FALSE;
		}
	}

	private function delete_instituciones_de_herramienta($id_herramienta = FALSE) {
		if ($id_herramienta) {
			$this->db->where(self::ID_COL, $id_herramienta);
			return $this->db->delete(self::NOMBRE_TABLA_ASOC_INSTITUCION);
		} else {
			return FALSE;
		}
	}

	public function select_count_nro_paginas($cantidad_items = FALSE, $id_institucion = FALSE) {
		if ($cantidad_items) {
			$nro_paginas = 0;

			$nro_herramientas = $this->select_count_herramientas($id_institucion);

			if ($nro_herramientas % $cantidad_items == 0) {
				$nro_paginas = (integer) ($nro_herramientas / $cantidad_items);
			} else {
				$nro_paginas = (integer) ($nro_herramientas / $cantidad_items) + 1;
			}

			return $nro_paginas;
		} else {
			return 0;
		}
	}

}
