<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Evento
 *
 * @author Jose
 */
class Evento extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_evento", "Modelo_ciudad", "Modelo_pais", "Modelo_categoria", "Modelo_institucion"));

		$this->load->library(array("Session", "Form_validation", "Upload"));
		$this->load->library(array("Evento_validacion"));
		$this->load->library(array("Imagen"));

		$this->load->helper(array("Url", "Form"));
		$this->load->helper(array("array_helper"));

		$this->load->database("default");
	}

	public function index() {
		$this->eventos();
	}

	public function eventos() {
		$datos = array();
		$datos["titulo"] = "Eventos";
		$datos["path_evento"] = $this->imagen->get_path_valido("evento");
		$datos["eventos"] = $this->Modelo_evento->select_eventos();

		$this->load->view("evento/eventos", $datos);
	}

	public function registrar_evento() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if (isset($_POST["submit"])) {
				$this->registrar_evento_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Registrar evento";
				$datos["accion"] = "registrar";
				$datos["paises"] = $this->Modelo_pais->select_paises();
				if ($datos["paises"]) {
					$datos["ciudades"] = $this->Modelo_ciudad->select_ciudades($datos["paises"][0]->id);
				} else {
					$datos["ciudades"] = FALSE;
				}
				$datos["categorias"] = $this->Modelo_categoria->select_categorias();
				$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

				$this->load->view("evento/formulario_evento", $datos);
			}
		} else {
			redirect(base_url());
		}
	}

	private function registrar_evento_bd() {
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$imagen = $this->input->post("imagen");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_fin = $this->input->post("fecha_fin");
		$pais = $this->input->post("pais");
		$ciudad = $this->input->post("ciudad");
		$direccion = $this->input->post("direccion");
		$id_categoria = $this->input->post("id_categoria");
		$id_institucion = $this->input->post("id_institucion");

		if ($this->evento_validacion->validar(array("nombre", "descripcion", "fecha_inicio", "fecha_fin", "ciudad", "direccion", "id_categoria", "id_institucion"))) {
			$path = $this->imagen->get_path_valido("evento");

			if ($path) {
				$imagen = $this->imagen->subir_archivo("imagen", $path);

				if (!$imagen["error"]) {
					$direccion_imagen = "";

					if ($imagen["datos"]) {
						$direccion_imagen = $imagen["datos"]["file_name"];
					}

					if ($this->Modelo_evento->insert_evento($ciudad, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $direccion, $direccion_imagen, NULL, $id_categoria, $id_institucion)) {
						redirect(base_url("evento/eventos"));
					} else {
						$this->session->set_flashdata("error", "Ocurrió un error al registrar el evento.");
						redirect(base_url("evento/registrar_evento"));
					}
				} else {
					$error = "";
					if ($imagen["error"]) {
						$error = $imagen["datos"];
					}

					$this->session->set_flashdata("error", $error);
					redirect(base_url("evento/registrar_evento"));
				}
			} else {
				$this->session->set_flashdata("error", "Ocurrió un error al guardar los archivos.");
				redirect(base_url("evento/registrar_evento"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_evento();
		}
	}

	public function get_ciudades_ajax() {
		if ($this->input->is_ajax_request() && isset($_POST["id_pais"])) {
			$id_pais = $this->input->post("id_pais");

			$ciudades = $this->Modelo_ciudad->select_ciudades($id_pais);

			echo (json_encode($ciudades));
		} else {
			echo("false");
		}
	}

}
