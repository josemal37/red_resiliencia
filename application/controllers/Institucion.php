<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Institucion
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Institucion extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_institucion"));

		$this->load->library(array("Session", "Form_validation"));
		$this->load->library(array("Institucion_validacion"));

		$this->load->helper(array("Url", "Form"));

		$this->load->database("default");
	}

	public function index() {
		$this->instituciones();
	}

	public function instituciones() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			$datos = array();
			$datos["titulo"] = "Instituciones";
			$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

			$this->load->view("institucion/instituciones", $datos);
		} else {
			redirect(base_url());
		}
	}

	public function registrar_institucion() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if (isset($_POST["submit"])) {
				$this->registrar_institucion_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Registrar institución";
				$datos["accion"] = "registrar";

				$this->load->view("institucion/formulario_institucion", $datos);
			}
		} else {
			redirect(base_url());
		}
	}

	private function registrar_institucion_bd() {
		$nombre = $this->input->post("nombre");
		$sigla = $this->input->post("sigla");

		if ($this->institucion_validacion->validar(array("nombre", "sigla"))) {
			if ($this->Modelo_institucion->insert_institucion($nombre, $sigla)) {
				redirect(base_url("institucion/instituciones"));
			} else {
				redirect(base_url("institucion/registrar_institucion"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_institucion();
		}
	}

	public function modificar_institucion($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_institucion_bd();
				} else {
					$datos = array();
					$datos["titulo"] = "Modificar institución";
					$datos["accion"] = "modificar";
					$datos["institucion"] = $this->Modelo_institucion->select_institucion_por_id($id);

					if ($datos["institucion"]) {
						$this->load->view("institucion/formulario_institucion", $datos);
					} else {
						$this->session->set_flashdata("no_existe", "La institucion seleccionada no existe.");
						redirect(base_url("institucion/instituciones"), "refresh");
					}
				}
			} else {
				redirect(base_url("institucion/instituciones"));
			}
		} else {
			redirect(base_url());
		}
	}

	public function modificar_institucion_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$sigla = $this->input->post("sigla");

		if ($this->institucion_validacion->validar(array("id", "nombre", "sigla"))) {
			if ($this->Modelo_institucion->update_institucion($id, $nombre, $sigla)) {
				redirect(base_url("institucion/instituciones"));
			} else {
				redirect(base_url("institucion/modificar_institucion/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_institucion($id);
		}
	}

	public function eliminar_institucion($id = FALSE) {
		if ($id) {
			if ($this->Modelo_institucion->delete_institucion($id)) {
				redirect(base_url("institucion/instituciones"));
			} else {
				redirect(base_url("institucion/instituciones"));
			}
		} else {
			redirect(base_url("institucion/instituciones"));
		}
	}

}
