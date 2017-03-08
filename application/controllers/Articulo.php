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
		$this->load->helper(array("Array_helper"));

		$this->load->database("default");
	}

	public function index() {
		$this->articulos();
	}

	public function articulos($nro_pagina = FALSE) {
		$rol = $this->session->userdata("rol");
		
		$cantidad_articulos = 3;
		if (!$nro_pagina) {
			$nro_pagina = 1;
		}

		if (isset($_GET["criterio"])) {
			$criterio = $this->input->get("criterio");
		} else {
			$criterio = FALSE;
		}
		
		if ($rol == "usuario") {
			$id_institucion = $this->session->userdata("id_institucion");
		} else {
			$id_institucion = FALSE;
		}

		$datos = array();

		$datos["titulo"] = "Articulos";
		$datos["criterio"] = $criterio;
		$datos["nro_pagina"] = $nro_pagina;
		$datos["nro_paginas"] = $this->Modelo_articulo->select_count_nro_paginas($cantidad_articulos, $id_institucion);
		$datos["articulos"] = $this->Modelo_articulo->select_articulos($nro_pagina, $cantidad_articulos, $id_institucion);
		$datos["path_articulos"] = $this->imagen->get_path_valido("articulo");

		$this->load->view("articulo/articulos", $datos);
	}

	public function ver_articulo($id = FALSE) {
		if ($id) {
			$datos = array();
			$datos["articulo"] = $this->Modelo_articulo->select_articulo_por_id($id);

			if ($datos["articulo"]) {
				$datos["titulo"] = $datos["articulo"]->nombre;
				$datos["path_articulos"] = $this->imagen->get_path_valido("articulo");

				$this->load->view("articulo/articulo", $datos);
			} else {
				redirect(base_url("articulo/articulos"));
			}
		} else {
			redirect(base_url("articulo/articulos"));
		}
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
				redirect(base_url("articulo/registrar_articulo"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_articulo();
		}
	}

	private function subir_imagen($accion = "registrar_articulo") {
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
			redirect(base_url("articulo/" . $accion));
		}
	}

	private function guardar_html($contenido = FALSE) {
		if ($contenido) {
			$url = FALSE;

			$path = $this->imagen->get_path_valido("articulo");

			$nombre = tempnam($path, "art");

			if ($nombre) {
				$contenido = str_replace('src="..', 'src="' . base_url(), $contenido);

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

	public function modificar_articulo($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_articulo_bd();
				} else {
					$datos = array();
					$datos["articulo"] = $this->Modelo_articulo->select_articulo_por_id($id);

					if ($datos["articulo"]) {
						$datos["titulo"] = "Modificar articulo";
						$datos["accion"] = "modificar";
						$datos["path_articulo"] = $this->imagen->get_path_valido("articulo");
						$datos["autores"] = $this->Modelo_autor->select_autores();
						$datos["categorias"] = $this->Modelo_categoria->select_categorias();
						$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

						eliminar_elementos_array($datos["autores"], $datos["articulo"]->autores, "id");
						eliminar_elementos_array($datos["categorias"], $datos["articulo"]->categorias, "id");
						eliminar_elementos_array($datos["instituciones"], $datos["articulo"]->instituciones, "id");

						$this->load->view("articulo/formulario_articulo", $datos);
					} else {
						$this->session->set_flashdata("error", "El articulo seleccionado no existe.");
						redirect(base_url("ariculo/articulos"));
					}
				}
			} else {
				return FALSE;
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_articulo_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$imagen_antiguo = $this->input->post("imagen_antiguo");
		$fecha = $this->input->post("fecha");
		$contenido = $this->input->post("contenido");
		$id_contenido = $this->input->post("id_contenido");
		$id_autor = $this->input->post("id_autor");
		$id_categoria = $this->input->post("id_categoria") ? $this->input->post("id_categoria") : array();
		$id_institucion = $this->input->post("id_institucion");

		if ($this->articulo_validacion->validar(array("id", "nombre", "descripcion", "contenido", "fecha", "id_categoria", "id_institucion", "id_autor"))) {
			if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {
				$path = $this->imagen->get_path_valido("articulo");
				$this->imagen->eliminar_archivo($path . $imagen_antiguo);
				$direccion_imagen = $this->subir_imagen("modificar_articulo/" . $id);
			} else {
				$direccion_imagen = $imagen_antiguo;
			}
			$this->modificar_contenido($id_contenido, $contenido);

			if ($this->Modelo_articulo->update_articulo($id, $nombre, $descripcion, $direccion_imagen, $fecha, $id_autor, $id_categoria, $id_institucion)) {
				redirect(base_url("articulo/articulos"));
			} else {
				$this->session->set_flashdata("error", "Ocurrió un error al modificar el articulo.");
				redirect(base_url("articulo/modificar_articulo/" . $id));
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_articulo($id);
		}
	}

	private function modificar_contenido($id_contenido, $contenido) {
		if ($id_contenido && $contenido) {
			$url = FALSE;

			$path = $this->imagen->get_path_valido("articulo");

			$contenido = str_replace('src="..', 'src="' . base_url(), $contenido);

			$guardado = write_file($path . $id_contenido, $contenido);

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

	public function eliminar_articulo($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			$articulo = $this->Modelo_articulo->select_articulo_por_id($id);

			if ($articulo) {
				$path = $this->imagen->get_path_valido("articulo");

				if ($this->Modelo_articulo->delete_articulo($id)) {
					unlink($path . $articulo->url);
					unlink($path . $articulo->imagen);

					redirect(base_url("articulo/articulos"));
				} else {
					$this->session->set_flashdata("error", "Ocurrió un problema al eliminar el articulo.");
					redirect(base_url("articulo/articulos"));
				}
			} else {
				redirect(base_url("articulo/articulos"));
			}
		} else {
			redirect(base_url());
		}
	}

}
