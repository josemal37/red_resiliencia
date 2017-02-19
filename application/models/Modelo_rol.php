<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_rol
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_rol extends My_model {
	
	const ID_COL = "id_rol";
	const NOMBRE_COL = "nombre_rol";
	const COLUMNAS_SELECT = "rol.id_rol as id, rol.nombre_rol as nombre_rol";
	const NOMBRE_TABLA = "rol";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function select_roles() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		
		$query = $this->db->get();
		
		$roles = $this->return_result($query);
		
		return $roles;
	}
}
