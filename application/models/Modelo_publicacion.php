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
	const COLUMNAS_SELECT = "publicacion.id_publicacion as id, publicacion.id_anio as id_anio, publicacion.nombre_publicacion as nombre, publicacion.descripcion_publicacion as descripcion, publicacion.url_publicacion as url, publicacion.imagen_publicacion as imagen, publicacion.destacada_publicacion as destacada, publicacion.fecha_publicacion as publicacion";
	const NOMBRE_TABLA = "publicacion";
	const NOMBRE_TABLA_ASOC_AUTOR = "autor_publicacion";
	const ID_TABLA_ASOC_AUTOR = "id_autor";
	const NOMBRE_TABLA_ASOC_CATEGORIA = "categoria_publicacion";
	const ID_TABLA_ASOC_CATEGORIA = "id_categoria";
	const NOMBRE_TABLA_ASOC_INSTITUCION = "institucion_publicacion";
	const ID_TABLA_ASOC_INSTITUCION = "id_institucion";

	public function __construct() {
		$this->load->model(array("Modelo_categoria", "Modelo_institucion", "Modelo_autor", "Modelo_modulo", "Modelo_anio"));
		parent::__construct();
	}

	public function select_publicaciones($nro_pagina = FALSE, $cantidad_publicaciones = FALSE, $id_institucion = FALSE, $criterio = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		if ($criterio) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_COL, "left");
			$this->db->join(Modelo_categoria::NOMBRE_TABLA, Modelo_categoria::NOMBRE_TABLA . "." . Modelo_categoria::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . Modelo_categoria::ID_COL, "left");
			$this->db->join(self::NOMBRE_TABLA_ASOC_AUTOR, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . self::ID_COL, "left");
			$this->db->join(Modelo_autor::NOMBRE_TABLA, Modelo_autor::NOMBRE_TABLA . "." . Modelo_autor::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . Modelo_autor::ID_COL, "left");
			$this->db->join(Modelo_modulo::NOMBRE_TABLA, Modelo_modulo::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA . "." . self::ID_COL, "left");
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
				$this->db->or_like(Modelo_modulo::NOMBRE_COL, $criterio);
				$this->db->or_like(self::NOMBRE_COL, $criterio);
				$this->db->or_like(self::DESCRIPCION_COL, $criterio);
			}

			$this->db->group_end();
		}

		if (!$criterio) {
			if ($nro_pagina && $cantidad_publicaciones && is_numeric($nro_pagina) && is_numeric($cantidad_publicaciones)) {
				$this->db->limit($cantidad_publicaciones, ($nro_pagina - 1) * $cantidad_publicaciones);
			}
		}

		$this->db->order_by(self::NOMBRE_TABLA . "." . self::ID_COL . " DESC, " . self::NOMBRE_TABLA . "." . self::FECHA_COL . " DESC");

		$this->db->distinct();

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

				//cargamos el anio
				if (isset($publicacion->id_anio)) {
					$anio = $this->Modelo_anio->select_anio_por_id($publicacion->id_anio);
					$publicaciones[$i]->anio = $anio->anio;
				}

				$i += 1;
			}
		}

		return $publicaciones;
	}

	public function select_publicaciones_2($nro_pagina = FALSE, $cantidad_publicaciones = FALSE, $id_anio = FALSE, $id_autor = FALSE, $id_categoria = FALSE, $id_institucion = FALSE, $criterio = FALSE, $contar = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		
		if ($id_anio) {
			$this->db->where(Modelo_anio::ID_COL, $id_anio);
		}
		
		if ($id_autor) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_AUTOR, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_AUTOR . "." . self::ID_COL, "left");
			$this->db->where(self::NOMBRE_TABLA_ASOC_AUTOR . "." . Modelo_autor::ID_COL, $id_autor);
		}
		
		if ($id_categoria) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_COL, "left");
			$this->db->where(self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . Modelo_categoria::ID_COL, $id_categoria);
		}

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . Modelo_institucion::ID_COL, $id_institucion);
		}

		if ($criterio) {
			$this->db->join(Modelo_modulo::NOMBRE_TABLA, Modelo_modulo::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA . "." . self::ID_COL, "left");

			$this->db->group_start();

			$criterios = explode(", ", $criterio);

			foreach ($criterios as $criterio) {
				$this->db->or_like(Modelo_modulo::NOMBRE_COL, $criterio);
				$this->db->or_like(Modelo_modulo::DESCRIPCION_COL, $criterio);
				$this->db->or_like(self::NOMBRE_COL, $criterio);
				$this->db->or_like(self::DESCRIPCION_COL, $criterio);
			}

			$this->db->group_end();
		}

		$this->db->order_by(self::NOMBRE_TABLA . "." . self::ID_COL . " DESC, " . self::NOMBRE_TABLA . "." . self::FECHA_COL . " DESC");

		$this->db->distinct();

		if ($contar) {
			return $this->db->count_all_results();
		} else {
			if ($nro_pagina && $cantidad_publicaciones && is_numeric($nro_pagina) && is_numeric($cantidad_publicaciones)) {
				$this->db->limit($cantidad_publicaciones, ($nro_pagina - 1) * $cantidad_publicaciones);
			}

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

					//cargamos el anio
					if (isset($publicacion->id_anio)) {
						$anio = $this->Modelo_anio->select_anio_por_id($publicacion->id_anio);
						$publicaciones[$i]->anio = $anio->anio;
					}

					$i += 1;
				}
			}

			return $publicaciones;
		}
	}

	public function select_publicaciones_con_filtro($id_categorias, $id_autor, $id_institucion) {
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

		$publicaciones = $this->return_result($query);

		if ($publicaciones) {
			$i = 0;

			foreach ($publicaciones as $publicacion) {
				$categorias = $this->Modelo_categoria->select_categoria_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicaciones[$i]->categorias = $categorias;

				$instituciones = $this->Modelo_institucion->select_institucion_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicaciones[$i]->instituciones = $instituciones;

				$autores = $this->Modelo_autor->select_autor_por_id($publicacion->id, self::NOMBRE_TABLA);
				$publicaciones[$i]->autores = $autores;

				$modulos = $this->Modelo_modulo->select_modulos($publicacion->id);
				$publicaciones[$i]->modulos = $modulos;

				if (isset($publicacion->id_anio)) {
					$anio = $this->Modelo_anio->select_anio_por_id($publicacion->id_anio);
					$publicaciones[$i]->anio = $anio->anio;
				}

				$i += 1;
			}
		}

		return $publicaciones;
	}

	public function select_publicacion_por_id($id = FALSE, $id_institucion = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID_COL, $id);

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

				//cargamos el anio
				if (isset($publicacion->id_anio)) {
					$anio = $this->Modelo_anio->select_anio_por_id($publicacion->id_anio);
					$publicacion->anio = $anio->anio;
				}
			}

			return $publicacion;
		} else {
			return FALSE;
		}
	}

	public function insert_publicacion($nombre = "", $descripcion = "", $modulos = FALSE, $descripcion_modulos = FALSE, $url = "", $imagen = "", $destacada = FALSE, $fecha = FALSE, $id_autor = FALSE, $id_categoria = FALSE, $id_institucion = FALSE, $anio = FALSE) {
		if ($nombre != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			$datos = array();

			$id_anio = FALSE;

			if ($anio) {
				$id_anio = $this->Modelo_anio->insert_anio($anio);
			}

			$datos[self::NOMBRE_COL] = $nombre;
			$datos[self::DESCRIPCION_COL] = $descripcion;
			$datos[self::URL_COL] = $url;
			$datos[self::IMAGEN_COL] = $imagen;
			$datos[self::DESTACADA_COL] = $destacada;
			if ($fecha) {
				$this->db->set(self::FECHA_COL, $fecha);
			} else {
				$this->db->set(self::FECHA_COL, "NOW()", FALSE);
			}

			if ($id_anio) {
				$this->db->set(Modelo_anio::ID_COL, $id_anio);
			}

			$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);

			if ($insertado) {
				$id_publicacion = $this->db->insert_id();

				$this->Modelo_modulo->insert_modulo($id_publicacion, $modulos, $descripcion_modulos);
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

	public function update_publicacion($id = FALSE, $nombre = "", $descripcion = "", $modulos = FALSE, $descripcion_modulos = FALSE, $url = "", $imagen = "", $destacada = FALSE, $id_autor = FALSE, $id_categoria = FALSE, $id_institucion = FALSE, $anio = FALSE) {
		if ($id && $nombre != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			if ($anio == FALSE) {
				$id_anio = NULL;
			} else {
				$id_anio = $this->Modelo_anio->insert_anio($anio);
			}

			$this->db->set(self::NOMBRE_COL, $nombre);
			$this->db->set(self::DESCRIPCION_COL, $descripcion);
			$this->db->set(self::URL_COL, $url);
			$this->db->set(self::IMAGEN_COL, $imagen);
			$this->db->set(self::DESTACADA_COL, $destacada);
			$this->db->set(Modelo_anio::ID_COL, $id_anio);

			$this->db->where(self::ID_COL, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->update_autores_de_publicacion($id, $id_autor);
			$this->update_categorias_de_publicacion($id, $id_categoria);
			$this->update_instituciones_de_publicacion($id, $id_institucion);
			$this->Modelo_modulo->update_modulos_publicacion($id, $modulos, $descripcion_modulos);

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	private function update_autores_de_publicacion($id_publicacion = FALSE, $id_autores = FALSE) {
		$this->delete_autores_de_publicacion($id_publicacion);

		if ($id_publicacion !== FALSE && $id_autores !== FALSE) {
			$actualizado = FALSE;

			$actualizado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_AUTOR, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_AUTOR, $id_autores);

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	private function update_categorias_de_publicacion($id_publicacion = FALSE, $id_categoria = FALSE) {
		$this->delete_categorias_de_publicacion($id_publicacion);

		if ($id_publicacion !== FALSE && $id_categoria !== FALSE) {
			$asociado = FALSE;
			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::ID_COL, $id_publicacion, self::ID_TABLA_ASOC_CATEGORIA, $id_categoria);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	private function update_instituciones_de_publicacion($id_publicacion = FALSE, $id_institucion = FALSE) {
		$this->delete_instituciones_de_publicacion($id_publicacion);

		if ($id_publicacion !== FALSE && $id_institucion !== FALSE) {
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

			$this->Modelo_modulo->delete_modulos_publicacion($id);
			$this->delete_autores_de_publicacion($id);
			$this->delete_categorias_de_publicacion($id);
			$this->delete_instituciones_de_publicacion($id);

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
