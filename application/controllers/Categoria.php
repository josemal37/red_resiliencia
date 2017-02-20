<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Categoria
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_categoria"));

		$this->load->library(array("Session", "Form_validation"));
		$this->load->library(array("Categoria_validacion"));

		$this->load->helper(array("Url", "Form"));

		$this->load->database("default");
	}

	public function index() {
		$this->categorias();
	}

	public function categorias() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			$datos = array();
			$datos["titulo"] = "Categorias";
			$datos["categorias"] = $this->Modelo_categoria->select_categorias();

			$this->load->view("categoria/categorias", $datos);
		} else {
			redirect(base_url());
		}
	}

	public function registrar_categoria() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if (isset($_POST["submit"])) {
				$this->registrar_categoria_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Registrar categoria";
				$datos["accion"] = "registrar";

				$this->load->view("categoria/formulario_categoria", $datos);
			}
		} else {
			redirect(base_url());
		}
	}

	private function registrar_categoria_bd() {
		if ($this->categoria_validacion->validar(array("nombre"))) {
			$nombre = $this->input->post("nombre");

			if ($this->Modelo_categoria->insert_categoria($nombre)) {
				redirect(base_url("categoria/categorias"));
			} else {
				redirect(base_url("categoria/registrar_categoria"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_categoria();
		}
	}

	public function modificar_categoria($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_categoria_bd();
				} else {
					$datos = array();
					$datos["titulo"] = "Modificar categoria";
					$datos["accion"] = "modificar";
					$datos["categoria"] = $this->Modelo_categoria->select_categoria_por_id($id);

					if ($datos["categoria"]) {
						$this->load->view("categoria/formulario_categoria", $datos);
					} else {
						$this->session->set_flashdata("no_existe", "La categoria seleccionada no existe.");
						redirect(base_url("categoria/categorias"), "refresh");
					}
				}
			} else {
				redirect(base_url("categoria/categorias"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_categoria_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");

		if ($this->categoria->validar(array("id", "nombre"))) {

			if ($this->Modelo_categoria->update_categoria($id, $nombre)) {
				redirect(base_url("categoria/categorias"));
			} else {
				redirect(base_url("categoria/modificar_categoria/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_categoria($id);
		}
	}

	public function eliminar_categoria($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if ($id) {
				if ($this->Modelo_categoria->delete_categoria($id)) {
					redirect(base_url("categoria/categorias"));
				} else {
					redirect(base_url("categoria/categorias"));
				}
			} else {
				redirect(base_url("categoria/categorias"));
			}
		} else {
			redirect(base_url());
		}
	}

}
