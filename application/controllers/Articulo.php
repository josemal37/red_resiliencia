<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Articulo
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Articulo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array("Modelo_articulo", "Modelo_institucion", "Modelo_categoria", "Modelo_autor"));

		$this->load->library(array("Session", "Form_validation", "Upload"));
		$this->load->library(array("Articulo_validacion"));
		$this->load->library(array("imagen"));

		$this->load->helper(array("Url", "Form", "FIle"));

		$this->load->database("default");
	}

	public function index() {
		$this->articulos();
	}

	public function articulos() {
		$datos = array();

		$datos["titulo"] = "Articulos";
		$datos["articulos"] = $this->Modelo_articulo->select_articulos();
		$datos["path_articulos"] = $this->imagen->get_path_valido("articulo");

		$this->load->view("articulo/articulos", $datos);
	}

	public function registrar_articulo() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol = "usuario") {
			if (isset($_POST["submit"])) {
				$this->registrar_articulo_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Registrar articulo";
				$datos["accion"] = "registrar";
				$datos["autores"] = $this->Modelo_autor->select_autores();
				$datos["categorias"] = $this->Modelo_categoria->select_categorias();
				$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

				$this->load->view("articulo/formulario_articulo", $datos);
			}
		}
	}

	private function registrar_articulo_bd() {
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$contenido = $this->input->post("contenido");
		$fecha = $this->input->post("fecha");
		$id_categoria = $this->input->post("id_categoria");
		$id_institucion = $this->input->post("id_institucion");
		$id_autor = $this->input->post("id_autor");

		if ($this->articulo_validacion->validar(array("nombre", "descripcion", "contenido", "fecha", "id_categoria", "id_institucion", "id_autor"))) {
			$direccion_imagen = $this->subir_imagen();
			$url = $this->guardar_html($contenido);
			
			if ($this->Modelo_articulo->insert_articulo($nombre, $descripcion, $url, $direccion_imagen, $fecha, $id_autor, $id_categoria, $id_institucion)) {
				redirect(base_url("articulo/articulos"));
			} else {
				$this->session->set_flashdata("error", "Ocurrió un error al registrar el articulo.");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_articulo();
		}
	}

	private function subir_imagen() {
		$direccion_imagen = FALSE;

		$path = $this->imagen->get_path_valido("articulo");

		if ($path) {
			$imagen = $this->imagen->subir_archivo("imagen", $path);

			if (!$imagen["error"]) {
				if ($imagen["datos"]) {
					$direccion_imagen = $imagen["datos"]["file_name"];
				}
			} else {
				$error = "";
				if ($imagen["error"]) {
					$error = $imagen["datos"];
				}

				$this->session->set_flashdata("error", $error);
			}
		} else {
			$this->session->set_flashdata("error", "Ocurrió un error al guardar los archivos.");
		}

		if ($direccion_imagen) {
			return $direccion_imagen;
		} else {
			redirect(base_url("articulo/registrar_articulo"));
		}
	}
	
	private function guardar_html($contenido = FALSE) {
		if ($contenido) {
			$url = FALSE;
			
			$path = $this->imagen->get_path_valido("articulo");
			
			$nombre = tempnam($path, "art");
			
			if ($nombre) {
				$guardado = write_file($nombre, $contenido);
			} else {
				$guardado = FALSE;
				$this->session->set_flashdata("error", "Ocurrió un error al guardar el contenido del articulo.");
			}
			
			if ($guardado) {
				$nombre_y_extension = explode(".", $nombre);
				$nuevo_nombre = $nombre_y_extension[0] . ".html";
				rename($nombre, $nuevo_nombre);
				$nombres = explode("\\", $nuevo_nombre);
				$url = $nombres[sizeof($nombres) - 1];
				return $url;
			} else {
				redirect(base_url("articulo/registrar_articulo"));
			}
		} else {
			return FALSE;
		}
	}

}
