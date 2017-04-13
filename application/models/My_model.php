<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of My_model
 *
 * @author Jose
 */
class My_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	protected function return_result($query) {
		if (!$query) {
			return FALSE;
		} else if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->result();
		}
	}

	protected function return_row($query) {
		if (!$query) {
			return FALSE;
		} else if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->row();
		}
	}
	
	protected function is_id_array($array) {
		$valido = TRUE;
		
		if(is_array($array)) {
			foreach ($array as $id) {
				if(!is_numeric($id)) {
					$valido = FALSE;
					break;
				}
			}
		} else {
			$valido = FALSE;
		}
		
		return $valido;
	}
	
	protected function one_to_many($column_one = "", $one = FALSE, $column_many = "", $many = FALSE) {
		if($one && $many) {
			$datos = array();
			
			if(is_array($many)) {
				foreach ($many as $other) {
					$row = array(
						$column_one => $one,
						$column_many => $other
					);
					
					$datos[] = $row;
				}
			} else {
				$datos = FALSE;
			}
			
			return $datos;
		} else {
			return FALSE;
		}
	}
	
	protected function insert_many_to_many($tabla_intermedia = "", $id_tabla_1 = "", $dato_tabla_1 = FALSE, $id_tabla_2 = "", $datos_tabla_2 = FALSE) {
		if ($tabla_intermedia != "" &&$dato_tabla_1 && $datos_tabla_2 && $id_tabla_1 != "" && $id_tabla_2 != "") {
			$insertado = FALSE;

			$datos = array();

			if ($this->is_id_array($datos_tabla_2)) {
				$datos = $this->one_to_many($id_tabla_1, $dato_tabla_1, $id_tabla_2, $datos_tabla_2);

				$insertado = $this->db->insert_batch($tabla_intermedia, $datos);
			} else {
				$datos[$id_tabla_1] = $dato_tabla_1;
				$datos[$id_tabla_2] = $datos_tabla_2;

				$insertado = $this->db->insert($tabla_intermedia, $datos);
			}

			return $insertado;
		} else {
			return FALSE;
		}
	}
	
	public function nro_paginas($total_items = 0, $items_por_pagina = 1) {
		if ($items_por_pagina > 0) {
			$nro_paginas = 1;
			
			if ($total_items % $items_por_pagina == 0) {
				$nro_paginas = (integer) ($total_items / $items_por_pagina);
			} else {
				$nro_paginas = (integer) ($total_items / $items_por_pagina) + 1;
			}

			return $nro_paginas;
		} else {
			return 1;
		}
	}

}
