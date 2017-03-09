<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Jose
 */
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("Modelo_usuario");
		$this->load->library(array("session", "form_validation"));
		$this->load->library(array("Login_validacion"));
		$this->load->helper(array("url", "form"));
		$this->load->database("default");
		$this->clear_cache();
	}

	public function index() {
		$rol = $this->session->userdata("rol");

		switch ($rol) {
			case "":
				$data["token"] = $this->token();
				$data["titulo"] = "Inicio de sesión";
				$this->load->view("login/login", $data);
				break;
			case "administrador":
				redirect(base_url("administrador"));
				break;
			case "usuario":
				redirect(base_url("usuario_administrador"));
				break;
			default:
				$data["token"] = $this->token();
				$data["titulo"] = "Inicio de sesión";
				$this->load->view("login/login", $data);
				break;
		}
	}

	public function iniciar_sesion() {
		if (isset($_POST["submit"]) && isset($_POST["token"]) && $this->input->post("token") == $this->session->userdata("token")) {
			if ($this->login_validacion->validar(array("login", "password"))) {
				$login = $this->input->post("login");
				$password = sha1($this->input->post("password"));

				$usuario = $this->Modelo_usuario->select_usuario_por_login_password($login, $password);

				if ($usuario) {
					$datos = array(
						"nombre_completo" => $usuario->nombre_completo,
						"rol" => $usuario->nombre_rol,
						"id_institucion" => $usuario->id_institucion,
						"nombre_institucion" => $usuario->nombre_institucion
					);
					$this->session->set_userdata($datos);

					$this->index();
				} else {
					$this->session->set_flashdata("error", "Datos Incorrectos.");
					redirect(base_url("login"), "refresh");
				}
			} else {
				$this->index();
			}
		} else {
			redirect(base_url("login"));
		}
	}

	public function cerrar_sesion() {
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function token() {
		$token = md5(uniqid(rand(), true));
		$this->session->set_userdata('token', $token);
		return $token;
	}

	private function clear_cache() {
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}

}
