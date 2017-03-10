<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Autor
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Autor extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_autor", "Modelo_institucion"));

		$this->load->library(array("Session", "Form_validation"));
		$this->load->library(array("Autor_validacion"));

		$this->load->helper(array("Url", "Form"));
		$this->load->helper(array("array_helper"));

		$this->load->database("default");
	}

	public function index() {
		$this->autores();
	}

	public function autores() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			$datos = array();
			$datos["titulo"] = "Autores";
			$datos["autores"] = $this->Modelo_autor->select_autores();

			$this->load->view("autor/autores", $datos);
		} else {
			redirect(base_url());
		}
	}

	public function registrar_autor() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if (isset($_POST["submit"])) {
				$this->registrar_autor_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Registrar autor";
				$datos["accion"] = "registrar";
				$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

				$datos["reglas_validacion"] = $this->autor_validacion->get_reglas_cliente(array("nombre", "apellido_paterno", "apellido_materno"));
				
				$this->load->view("autor/formulario_autor", $datos);
			}
		} else {
			redirect(base_url());
		}
	}

	private function registrar_autor_bd() {
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$id_institucion = $this->input->post("id_institucion");

		if ($this->autor_validacion->validar(array("nombre", "apellido_paterno", "apellido_materno", "id_institucion"))) {
			if ($this->Modelo_autor->insert_autor($nombre, $apellido_paterno, $apellido_materno, $id_institucion)) {
				redirect(base_url("autor/autores"));
			} else {
				redirect(base_url("autor/registrar_autor"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_autor();
		}
	}

	public function modificar_autor($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_autor_bd();
				} else {
					$datos = array();
					$datos["titulo"] = "Modificar autor";
					$datos["accion"] = "modificar";
					$datos["autor"] = $this->Modelo_autor->select_autor_por_id($id);
					$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();
					eliminar_elementos_array($datos["instituciones"], $datos["autor"]->instituciones, "id");
					if ($datos["autor"]) {
						$datos["reglas_validacion"] = $this->autor_validacion->get_reglas_cliente(array("nombre", "apellido_paterno", "apellido_materno"));
						
						$this->load->view("autor/formulario_autor", $datos);
					} else {
						$this->session->set_flashdata("no_existe", "El autor seleccionado no existe.");
						redirect(base_url("autor/autores"));
					}
				}
			} else {
				redirect(base_url("autor/autores"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_autor_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$id_institucion = $this->input->post("id_institucion");

		if ($this->autor_validacion->validar(array("id", "nombre", "apellido_paterno", "apellido_materno", "id_institucion"))) {
			if ($this->Modelo_autor->update_autor($id, $nombre, $apellido_paterno, $apellido_materno, $id_institucion)) {
				redirect(base_url("autor/autores"));
			} else {
				redirect(base_url("autor/modificar_autor/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_autor($id);
		}
	}

	public function eliminar_autor($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if ($id) {
				if ($this->Modelo_autor->delete_autor($id)) {
					redirect(base_url("autor/autores"));
				} else {
					redirect(base_url("autor/autores"));
				}
			} else {
				redirect(base_url("autor/autores"));
			}
		} else {
			redirect(base_url());
		}
	}

}
