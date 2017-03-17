<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_evento
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_evento extends My_model {

	const ID_COL = "id_evento";
	const ID_CIUDAD_COL = "id_ciudad";
	const NOMBRE_COL = "nombre_evento";
	const DESCRIPCION_COL = "descripcion_evento";
	const FECHA_INICIO_COL = "fecha_inicio_evento";
	const FECHA_FIN_COL = "fecha_fin_evento";
	const DIRECCION_COL = "direccion_evento";
	const IMAGEN_COL = "imagen_evento";
	const DESTACADO_COL = "destacado_evento";
	const COLUMNAS_SELECT = "evento.id_evento as id, evento.id_ciudad as id_ciudad, evento.nombre_evento as nombre, evento.descripcion_evento as descripcion, evento.fecha_inicio_evento as fecha_inicio, evento.fecha_fin_evento as fecha_fin, evento.direccion_evento as direccion, evento.imagen_evento as imagen, evento.destacado_evento as destacado";
	const NOMBRE_TABLA = "evento";
	const NOMBRE_TABLA_ASOC_CATEGORIA = "categoria_evento";
	const ID_TABLA_ASOC_CATEGORIA = "id_categoria";
	const NOMBRE_TABLA_ASOC_INSTITUCION = "institucion_evento";
	const ID_TABLA_ASOC_INSTITUCION = "id_institucion";

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_categoria", "Modelo_institucion", "Modelo_ciudad", "Modelo_pais"));
	}

	public function select_eventos($nro_pagina = FALSE, $cantidad_publicaciones = FALSE, $id_institucion = FALSE, $criterio = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->order_by(self::FECHA_INICIO_COL, "desc");

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		if ($criterio) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . self::ID_COL, "left");
			$this->db->join(Modelo_categoria::NOMBRE_TABLA, Modelo_categoria::NOMBRE_TABLA . "." . Modelo_categoria::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_CATEGORIA . "." . Modelo_categoria::ID_COL, "left");
			if (!$id_institucion) {
				$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL, "left");
				$this->db->join(Modelo_institucion::NOMBRE_TABLA, Modelo_institucion::NOMBRE_TABLA . "." . Modelo_institucion::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . Modelo_institucion::ID_COL, "left");
			}
			$this->db->join(Modelo_ciudad::NOMBRE_TABLA, self::NOMBRE_TABLA . "." . Modelo_ciudad::ID_COL . " = " . Modelo_ciudad::NOMBRE_TABLA . "." . Modelo_ciudad::ID_COL, "left");
			$this->db->join(Modelo_pais::NOMBRE_TABLA, Modelo_pais::NOMBRE_TABLA . "." . Modelo_pais::ID_COL . " = " . Modelo_ciudad::NOMBRE_TABLA . "." . Modelo_pais::ID_COL, "left");

			$this->db->group_start();

			$criterios = explode(", ", $criterio);

			foreach ($criterios as $criterio) {
				$this->db->like(Modelo_categoria::NOMBRE_COL, $criterio);
				if (!$id_institucion) {
					$this->db->or_like(Modelo_institucion::NOMBRE_COL, $criterio);
					$this->db->or_like(Modelo_institucion::SIGLA_COL, $criterio);
				}
				$this->db->or_like(self::NOMBRE_COL, $criterio);
				$this->db->or_like(self::DESCRIPCION_COL, $criterio);
				$this->db->or_like(self::FECHA_INICIO_COL, $criterio);
				$this->db->or_like(self::FECHA_FIN_COL, $criterio);
				$this->db->or_like(self::DIRECCION_COL, $criterio);
				$this->db->or_like(Modelo_ciudad::NOMBRE_COL, $criterio);
				$this->db->or_like(Modelo_pais::NOMBRE_COL, $criterio);
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

		$eventos = $this->return_result($query);

		if ($eventos) {
			$i = 0;
			foreach ($eventos as $evento) {
				$ciudad = $this->Modelo_ciudad->select_ciudad($evento->id_ciudad);
				if ($ciudad) {
					$pais = $this->Modelo_pais->select_pais($ciudad->id_pais);
				}
				$eventos[$i]->ciudad = $ciudad;
				$eventos[$i]->pais = $pais;
				$eventos[$i]->instituciones = $this->Modelo_institucion->select_institucion_por_id($evento->id, "evento");
				$eventos[$i]->categorias = $this->Modelo_categoria->select_categoria_por_id($evento->id, "evento");

				$i += 1;
			}
		}

		return $eventos;
	}

	public function select_eventos_proximos($cantidad = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where(self::FECHA_INICIO_COL . " > NOW()");
		$this->db->order_by(self::NOMBRE_TABLA . "." . self::FECHA_INICIO_COL, "ASC");

		if ($cantidad) {
			$this->db->limit($cantidad);
		}

		$query = $this->db->get();

		$eventos = $this->return_result($query);

		if ($eventos) {
			$i = 0;
			foreach ($eventos as $evento) {
				$ciudad = $this->Modelo_ciudad->select_ciudad($evento->id_ciudad);
				if ($ciudad) {
					$pais = $this->Modelo_pais->select_pais($ciudad->id_pais);
				}
				$eventos[$i]->ciudad = $ciudad;
				$eventos[$i]->pais = $pais;
				$eventos[$i]->instituciones = $this->Modelo_institucion->select_institucion_por_id($evento->id, "evento");
				$eventos[$i]->categorias = $this->Modelo_categoria->select_categoria_por_id($evento->id, "evento");

				$i += 1;
			}
		}

		return $eventos;
	}

	public function select_eventos_con_filtro($id_categorias, $id_institucion, $id_pais, $id_ciudad, $fecha) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		if ($id_institucion) {
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
		}

		if ($id_ciudad) {
			$this->db->join(Modelo_ciudad::NOMBRE_TABLA, self::NOMBRE_TABLA . "." . Modelo_ciudad::ID_COL . " = " . Modelo_ciudad::NOMBRE_TABLA . "." . Modelo_ciudad::ID_COL, "left");
			$this->db->where(Modelo_ciudad::NOMBRE_TABLA . "." . Modelo_ciudad::ID_COL, $id_ciudad);
		} else {
			if ($id_pais) {
				$this->db->join(Modelo_ciudad::NOMBRE_TABLA, self::NOMBRE_TABLA . "." . Modelo_ciudad::ID_COL . " = " . Modelo_ciudad::NOMBRE_TABLA . "." . Modelo_ciudad::ID_COL, "left");
				$this->db->join(Modelo_pais::NOMBRE_TABLA, Modelo_pais::NOMBRE_TABLA . "." . Modelo_pais::ID_COL . " = " . Modelo_ciudad::NOMBRE_TABLA . "." . Modelo_pais::ID_COL, "left");
				$this->db->where(Modelo_pais::NOMBRE_TABLA . "." . Modelo_pais::ID_COL, $id_pais);
			}
		}
		
		if ($fecha == "proximos") {
			$this->db->where(self::FECHA_INICIO_COL . " > NOW()");
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
		
		$this->db->order_by(self::NOMBRE_TABLA . "." . self::FECHA_INICIO_COL, "ASC");

		$query = $this->db->get();

		$eventos = $this->return_result($query);

		if ($eventos) {
			$i = 0;
			foreach ($eventos as $evento) {
				$ciudad = $this->Modelo_ciudad->select_ciudad($evento->id_ciudad);
				if ($ciudad) {
					$pais = $this->Modelo_pais->select_pais($ciudad->id_pais);
				}
				$eventos[$i]->ciudad = $ciudad;
				$eventos[$i]->pais = $pais;
				$eventos[$i]->instituciones = $this->Modelo_institucion->select_institucion_por_id($evento->id, "evento");
				$eventos[$i]->categorias = $this->Modelo_categoria->select_categoria_por_id($evento->id, "evento");

				$i += 1;
			}
		}

		return $eventos;
	}

	public function select_evento_por_id($id = FALSE, $id_institucion = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID_COL, $id);

			if ($id_institucion) {
				$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
				$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
			}

			$query = $this->db->get();

			$evento = $this->return_row($query);

			if ($evento) {
				$ciudad = $this->Modelo_ciudad->select_ciudad($evento->id_ciudad);
				if ($ciudad) {
					$pais = $this->Modelo_pais->select_pais($ciudad->id_pais);
				}
				$evento->ciudad = $ciudad;
				$evento->pais = $pais;
				$evento->instituciones = $this->Modelo_institucion->select_institucion_por_id($evento->id, "evento");
				$evento->categorias = $this->Modelo_categoria->select_categoria_por_id($evento->id, "evento");
			}

			return $evento;
		} else {
			return FALSE;
		}
	}

	public function insert_evento($id_ciudad = FALSE, $nombre = "", $descripcion = "", $fecha_inicio = "", $fecha_fin = "", $direccion = "", $imagen = "", $destacado = FALSE, $id_categoria = FALSE, $id_institucion = FALSE) {
		if ($id_ciudad && $nombre != "" && $fecha_inicio != "" && $fecha_fin != "" && $direccion != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			$datos = array(
				self::ID_CIUDAD_COL => $id_ciudad,
				self::NOMBRE_COL => $nombre,
				self::DESCRIPCION_COL => $descripcion,
				self::FECHA_INICIO_COL => $fecha_inicio,
				self::FECHA_FIN_COL => $fecha_fin,
				self::DIRECCION_COL => $direccion,
				self::IMAGEN_COL => $imagen,
				self::DESTACADO_COL => $destacado
			);

			$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);

			if ($insertado) {
				$id_evento = $this->db->insert_id();

				$this->insert_categoria_a_evento($id_evento, $id_categoria);
				$this->insert_institucion_a_evento($id_evento, $id_institucion);
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	private function insert_categoria_a_evento($id_evento = FALSE, $id_categoria = FALSE) {
		if ($id_evento && $id_categoria) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_CATEGORIA, self::ID_COL, $id_evento, self::ID_TABLA_ASOC_CATEGORIA, $id_categoria);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	private function insert_institucion_a_evento($id_evento = FALSE, $id_institucion = FALSE) {
		if ($id_evento && $id_institucion) {
			$asociado = FALSE;

			$asociado = $this->insert_many_to_many(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::ID_COL, $id_evento, self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);

			return $asociado;
		} else {
			return FALSE;
		}
	}

	public function update_evento($id = FALSE, $id_ciudad = FALSE, $nombre = "", $descripcion = "", $fecha_inicio = "", $fecha_fin = "", $direccion = "", $imagen = "", $destacado = FALSE, $id_categoria = FALSE, $id_institucion = FALSE) {
		if ($id && $id_ciudad && $nombre != "" && $fecha_inicio != "" && $fecha_fin != "" && $direccion != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			$datos = array(
				self::ID_CIUDAD_COL => $id_ciudad,
				self::NOMBRE_COL => $nombre,
				self::DESCRIPCION_COL => $descripcion,
				self::FECHA_INICIO_COL => $fecha_inicio,
				self::FECHA_FIN_COL => $fecha_fin,
				self::DIRECCION_COL => $direccion,
				self::IMAGEN_COL => $imagen,
				self::DESTACADO_COL => $destacado
			);

			$this->db->set($datos);

			$this->db->where(self::ID_COL, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->update_categoria_de_evento($id, $id_categoria);
			$this->update_institucion_de_evento($id, $id_institucion);

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	private function update_categoria_de_evento($id_evento = FALSE, $id_categoria = FALSE) {
		$actualizado = FALSE;

		if ($id_evento !== FALSE && $id_categoria !== FALSE) {
			if ($this->delete_categoria_de_evento($id_evento)) {
				$actualizado = $this->insert_categoria_a_evento($id_evento, $id_categoria);
			}
		}

		return $actualizado;
	}

	private function update_institucion_de_evento($id_evento = FALSE, $id_institucion = FALSE) {
		$actualizado = FALSE;

		if ($id_evento !== FALSE && $id_institucion !== FALSE) {
			if ($this->delete_institucion_de_evento($id_evento)) {
				$actualizado = $this->insert_institucion_a_evento($id_evento, $id_institucion);
			}
		}

		return $actualizado;
	}

	public function delete_evento($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->trans_start();

			$this->delete_categoria_de_evento($id);
			$this->delete_institucion_de_evento($id);

			$this->db->where(self::ID_COL, $id);
			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_categoria_de_evento($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_CATEGORIA);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	private function delete_institucion_de_evento($id = FALSE) {
		if ($id) {
			$eliminado = FALSE;

			$this->db->where(self::ID_COL, $id);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA_ASOC_INSTITUCION);

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	public function select_count_eventos($id_institucion = FALSE) {
		if ($id_institucion) {
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->join(self::NOMBRE_TABLA_ASOC_INSTITUCION, self::NOMBRE_TABLA . "." . self::ID_COL . " = " . self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_COL);
			$this->db->where(self::NOMBRE_TABLA_ASOC_INSTITUCION . "." . self::ID_TABLA_ASOC_INSTITUCION, $id_institucion);
			return $this->db->count_all_results();
		} else {
			return $this->db->count_all(self::NOMBRE_TABLA);
		}
	}

	public function select_count_nro_paginas($cantidad_eventos_por_pagina = FALSE, $id_institucion = FALSE) {
		if ($cantidad_eventos_por_pagina) {
			$nro_paginas = 0;

			$nro_eventos = $this->select_count_eventos($id_institucion);

			if ($nro_eventos % $cantidad_eventos_por_pagina == 0) {
				$nro_paginas = (integer) ($nro_eventos / $cantidad_eventos_por_pagina);
			} else {
				$nro_paginas = (integer) ($nro_eventos / $cantidad_eventos_por_pagina) + 1;
			}

			return $nro_paginas;
		} else {
			return 0;
		}
	}

}
