<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_usuario", "Modelo_rol", "Modelo_institucion"));

		$this->load->library(array("Session", "Form_validation"));
		$this->load->library(array("Usuario_validacion"));

		$this->load->helper(array("Url", "Form"));

		$this->load->database("default");
	}

	public function index() {
		$this->usuarios();
	}

	public function usuarios() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			$datos = array();
			$datos["titulo"] = "Usuarios";
			$datos["usuarios"] = $this->Modelo_usuario->select_usuarios();

			$this->load->view("usuario/usuarios", $datos);
		} else {
			redirect(base_url());
		}
	}

	public function registrar_usuario() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if (isset($_POST["submit"])) {
				$this->registrar_usuario_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Registrar usuario";
				$datos["accion"] = "registrar";
				$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();
				$datos["roles"] = $this->Modelo_rol->select_roles();

				$datos["reglas_validacion"] = $this->usuario_validacion->get_reglas_cliente(array("nombre", "apellido_paterno", "apellido_materno", "institucion", "rol", "login", "password", "confirmacion"));

				$this->load->view("usuario/formulario_usuario", $datos);
			}
		} else {
			redirect(base_url());
		}
	}

	private function registrar_usuario_bd() {
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$institucion = $this->input->post("institucion");
		$rol = $this->input->post("rol");
		$login = $this->input->post("login");
		$password = $this->input->post("password");
		if ($this->usuario_validacion->validar(array("nombre", "apellido_paterno", "apellido_materno", "institucion", "rol", "login", "password", "confirmacion"))) {
			if ($this->Modelo_usuario->insert_usuario($nombre, $apellido_paterno, $apellido_materno, $institucion, $rol, $login, $password)) {
				redirect(base_url("usuario/usuarios"));
			} else {
				redirect(base_url("usuario/registrar_usuario"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_usuario();
		}
	}

	public function modificar_usuario($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_usuario_bd();
				} else {
					$datos = array();
					$datos["titulo"] = "Modificar usuario";
					$datos["accion"] = "modificar";
					$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();
					$datos["roles"] = $this->Modelo_rol->select_roles();
					$datos["usuario"] = $this->Modelo_usuario->select_usuario_por_id($id);
					if ($datos["usuario"]) {
						$datos["reglas_validacion"] = $this->usuario_validacion->get_reglas_cliente(array("nombre", "apellido_paterno", "apellido_materno", "institucion", "rol", "login"));

						$this->load->view("usuario/formulario_usuario", $datos);
					} else {
						$this->session->set_flashdata("no_existe", "El usuario seleccionado no existe.");
						redirect(base_url("usuario/usuarios"), "refresh");
					}
				}
			} else {
				redirect(base_url("usuario/usuarios"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_usuario_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$institucion = $this->input->post("institucion");
		$rol = $this->input->post("rol");
		$login = $this->input->post("login");
		if ($this->usuario_validacion->validar(array("id", "nombre", "apellido_paterno", "apellido_materno", "institucion", "rol", "login"))) {
			if ($this->Modelo_usuario->update_usuario($id, $nombre, $apellido_paterno, $apellido_materno, $institucion, $rol, $login)) {
				redirect(base_url("usuario/usuarios"));
			} else {
				redirect(base_url("usuario/modificar_usuario/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_usuario($id);
		}
	}

	public function modificar_password_usuario($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_password_usuario_bd();
				} else {
					$datos = array();
					$datos["titulo"] = "Modificar password";
					$datos["accion"] = "modificar_password_usuario";
					$datos["usuario"] = $this->Modelo_usuario->select_usuario_por_id($id);

					if ($datos["usuario"]) {
						$datos["reglas_validacion"] = $this->usuario_validacion->get_reglas_cliente(array("password", "confirmacion"));

						$this->load->view("usuario/formulario_usuario", $datos);
					} else {
						$this->session->set_flashdata("no_existe", "El usuario seleccionado no existe.");
						redirect(base_url("usuario/usuarios"), "refresh");
					}
				}
			} else {
				redirect(base_url("usuario/usuarios"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_password_usuario_bd() {
		$id = $this->input->post("id");
		$password = $this->input->post("password");
		if ($this->usuario_validacion->validar(array("id", "password", "confirmacion"))) {
			if ($this->Modelo_usuario->update_password_usuario($id, $password)) {
				redirect(base_url("usuario/usuarios"));
			} else {
				$this->session->set_flashdata("error", "Ocurrió un error al modificar el password del usuario.");
				redirect(base_url("usuario/modificar_password_usuario/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_password_usuario($id);
		}
	}

	public function modificar_password($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_password_bd();
				} else {
					$datos = array();
					$datos["titulo"] = "Modificar password";
					$datos["accion"] = "modificar_password";
					$datos["usuario"] = $this->Modelo_usuario->select_usuario_por_id($id);

					if ($datos["usuario"]) {
						$datos["reglas_validacion"] = $this->usuario_validacion->get_reglas_cliente(array("password", "confirmacion", "password_anterior"));

						$this->load->view("usuario/formulario_usuario", $datos);
					} else {
						redirect(base_url(), "refresh");
					}
				}
			} else {
				redirect(base_url(), "refresh");
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_password_bd() {
		$id = $this->input->post("id");
		$password = $this->input->post("password");
		$password_anterior = $this->input->post("password_anterior");
		if ($this->usuario_validacion->validar(array("id", "password", "confirmacion", "password_anterior"))) {
			$usuario = $id == $this->session->userdata("id_usuario") ? $this->Modelo_usuario->select_usuario_por_id($id) : FALSE;
			
			if ($usuario && $usuario->password == sha1($password_anterior)) {
				if ($this->Modelo_usuario->update_password_usuario($id, $password)) {
					redirect(base_url());
				} else {
					$this->session->set_flashdata("error", "Ocurrió un error al modificar el password.");
					redirect(base_url("usuario/modificar_password/" . $id), "refresh");
				}
			} else {
				$this->session->set_flashdata("error", "El password anterior no coincide.");
				redirect(base_url("usuario/modificar_password/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_password($id);
		}
	}

	public function eliminar_usuario($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if ($id) {
				if ($this->Modelo_usuario->delete_usuario($id)) {
					redirect(base_url("usuario/usuarios"));
				} else {
					redirect(base_url("usuario/usuarios"));
				}
			} else {
				redirect(base_url("usuario/usuarios"));
			}
		} else {
			redirect(base_url());
		}
	}

}
