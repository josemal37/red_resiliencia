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
		$this->db->join(self::NOMBRE_TABLA_ROL, self::NOMBRE_TABLA . "." . self::ID_ROL_COL . " = " . self::NOMBRE_TABLA_ROL . "." . self::ID_ROL_COL, "left");

		$query = $this->db->get();

		$usuarios = $this->return_result($query);

		if ($usuarios) {
			$i = 0;
			foreach ($usuarios as $usuario) {
				$usuarios[$i]->nombre_completo = $this->get_nombre_completo($usuario);
				$i += 1;
			}
		}

		return $usuarios;
	}

	public function select_usuario_por_id($id = FALSE) {
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT . ", " . self::COLUMNAS_SELECT_ROL);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->join(self::NOMBRE_TABLA_ROL, self::NOMBRE_TABLA . "." . self::ID_ROL_COL . " = " . self::NOMBRE_TABLA_ROL . "." . self::ID_ROL_COL);
			$this->db->where(self::ID_COL, $id);

			$query = $this->db->get();

			$usuario = $this->return_row($query);

			if ($usuario) {
				$usuario->nombre_completo = $this->get_nombre_completo($usuario);
			}

			return $usuario;
		} else {
			return FALSE;
		}
	}

	public function select_usuario_por_login($login = "", $no_id = FALSE) {
		if ($login != "") {
			$this->db->select(self::COLUMNAS_SELECT . ", " . self::COLUMNAS_SELECT_ROL);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->join(self::NOMBRE_TABLA_ROL, self::NOMBRE_TABLA . "." . self::ID_ROL_COL . " = " . self::NOMBRE_TABLA_ROL . "." . self::ID_ROL_COL);
			$this->db->where(self::LOGIN_COL, $login);
			if ($no_id) {
				$this->db->where(self::ID_COL . " != ", $no_id);
			}

			$query = $this->db->get();

			$usuario = $this->return_row($query);

			if ($usuario) {
				$usuario->nombre_completo = $this->get_nombre_completo($usuario);
			}

			return $usuario;
		} else {
			return FALSE;
		}
	}

	public function select_usuario_por_login_password($login = "", $password = "") {
		if ($login != "" && $password != "") {
			$this->db->select(self::COLUMNAS_SELECT . ", " . self::COLUMNAS_SELECT_ROL);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->join(self::NOMBRE_TABLA_ROL, self::NOMBRE_TABLA . "." . self::ID_ROL_COL . " = " . self::NOMBRE_TABLA_ROL . "." . self::ID_ROL_COL);
			$this->db->where(self::LOGIN_COL, $login);
			$this->db->where(self::PASSWORD_COL, $password);

			$query = $this->db->get();

			$usuario = $this->return_row($query);

			if ($usuario) {
				$usuario->nombre_completo = $this->get_nombre_completo($usuario);
			}

			return $usuario;
		} else {
			return FALSE;
		}
	}

	public function insert_usuario($nombre = "", $apellido_paterno = "", $apellido_materno = "", $institucion = FALSE, $rol = FALSE, $login = "", $password = "") {
		if ($nombre != "" && $institucion && $rol && $login != "" && $password != "") {
			$insertado = FALSE;

			$this->db->trans_start();

			if (!$this->existe_login($login)) {
				$datos = array(
					self::NOMBRE_COL => $nombre,
					self::APELLIDO_PATERNO_COL => $apellido_paterno,
					self::APELLIDO_MATERNO_COL => $apellido_materno,
					self::ID_INSTITUCION_COL => $institucion,
					self::ID_ROL_COL => $rol,
					self::LOGIN_COL => $login,
					self::PASSWORD_COL => sha1($password)
				);

				$insertado = $this->db->insert(self::NOMBRE_TABLA, $datos);
			} else {
				$this->session->set_flashdata("existe", "El login ya se encuentra registrado.");
			}

			$this->db->trans_complete();

			return $insertado;
		} else {
			return FALSE;
		}
	}

	public function update_usuario($id = FALSE, $nombre = "", $apellido_paterno = "", $apellido_materno = "", $institucion = FALSE, $rol = FALSE, $login = "") {
		if ($id && $nombre != "" && $rol && $login != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			if (!$this->existe_login($login, $id)) {
				$datos = array(
					self::NOMBRE_COL => $nombre,
					self::APELLIDO_PATERNO_COL => $apellido_paterno,
					self::APELLIDO_MATERNO_COL => $apellido_materno,
					self::ID_INSTITUCION_COL => $institucion,
					self::ID_ROL_COL => $rol,
					self::LOGIN_COL => $login
				);

				$this->db->set($datos);
				$this->db->where(self::ID_COL, $id);
				$actualizado = $this->db->update(self::NOMBRE_TABLA);
			} else {
				$this->session->set_flashdata("existe", "El login ya se encuentra registrado.");
			}
			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	public function update_password_usuario($id = FALSE, $password = "") {
		if ($id && $password != "") {
			$actualizado = FALSE;

			$this->db->trans_start();

			$datos = array(
				self::PASSWORD_COL => sha1($password)
			);

			$this->db->set($datos);
			$this->db->where(self::ID_COL, $id);
			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->db->trans_complete();

			return $actualizado;
		} else {
			return FALSE;
		}
	}

	public function delete_usuario($id = FALSE) {
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

	private function get_nombre_completo($usuario = FALSE) {
		if ($usuario) {
			$nombre_completo = FALSE;

			if (isset($usuario->nombre)) {
				$nombre_completo = $usuario->nombre;
			}

			if ($usuario->apellido_paterno) {
				$nombre_completo .= " " . $usuario->apellido_paterno;
			}

			if ($usuario->apellido_paterno) {
				$nombre_completo .= " " . $usuario->apellido_materno;
			}

			return $nombre_completo;
		} else {
			return FALSE;
		}
	}

	public function existe_login($login = "", $no_id = FALSE) {
		$usuario = $this->select_usuario_por_login($login, $no_id);

		if ($usuario) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}
