<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_pais
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_pais extends My_model {
	
	const ID_COL = "id_pais";
	const NOMBRE_COL = "nombre_pais";
	
	const COLUMNAS_SELECT = "id_pais as id, nombre_pais as nombre";
	
	const NOMBRE_TABLA = "pais";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function select_pais($id = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID_COL, $id);
			
			$query = $this->db->get();
			
			$pais = $this->return_row($query);
			
			return $pais;
		} else {
			return FALSE;
		}
	}
	
	public function select_paises() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->order_by(self::NOMBRE_COL);
		
		$query = $this->db->get();
		
		$paises = $this->return_result($query);
		
		return $paises;
	}
}
