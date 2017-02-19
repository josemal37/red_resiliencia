<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_usuario
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'My_model.php';

class Modelo_usuario extends My_model {

	const ID_COL = "id_usuario";
	const ID_INSTITUCION_COL = "id_institucion";
	const ID_ROL_COL = "id_rol";
	const NOMBRE_COL = "nombre_usuario";
	const APELLIDO_PATERNO_COL = "apellido_paterno_usuario";
	const APELLIDO_MATERNO_COL = "apellido_materno_usuario";
	const LOGIN_COL = "login_usuario";
	const PASSWORD_COL = "password_usuario";
	const NOMBRE_ROL_COL = "nombre_rol";
	const COLUMNAS_SELECT = "usuario.id_usuario as id, usuario.id_institucion as id_institucion, usuario.id_rol as id_rol, usuario.nombre_usuario as nombre, usuario.apellido_paterno_usuario as apellido_paterno, usuario.apellido_materno_usuario as apellido_materno, usuario.login_usuario as login, usuario.password_usuario as password";
	const COLUMNAS_SELECT_ROL = "rol.nombre_rol as nombre_rol";
	const NOMBRE_TABLA = "usuario";
	const NOMBRE_TABLA_ROL = "rol";

	public function __construct() {
		parent::__construct();
	}

	public function select_usuarios() {
		$this->db->select(self::COLUMNAS_SELECT . ", " . self::COLUMNAS_SELECT_ROL);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->join(self::NOMBRE_TABLA_ROL, self::NOMBRE_TABLA . "." . self::ID_ROL_COL . " = " . self::NOMBRE_TABLA_ROL . "." . self::ID_ROL_COL);

		$query = $this->db->get();

		$usuarios = $this->return_result($query);

		return $usuarios;
	}

	public function insert_usuario($nombre = "", $apellido_paterno = "", $apellido_materno = "", $institucion = FALSE, $rol = FALSE, $login = "", $password = "") {
		if ($nombre != "" && $institucion && $rol && $login != "" && $password != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			$datos = array(
				self::NOMBRE_COL => $nombre,
				self::APELLIDO_PATERNO_COL => $apellido_paterno,
				self::APELLIDO_MATERNO_COL => $apellido_materno,
				self::ID_INSTITUCION_COL => $institucion,
				self::ID_ROL_COL => $rol,
				self::LOGIN_COL => $login,
				self::PASSWORD_COL => $password
			);
			
			$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

}
