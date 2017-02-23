<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Publicacion
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicacion extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_categoria", "Modelo_autor", "Modelo_institucion", "Modelo_publicacion"));

		$this->load->library(array("Session", "Form_validation", "Upload"));
		$this->load->library(array("Publicacion_validacion"));
		$this->load->library(array("Imagen", "Documento"));

		$this->load->helper(array("Url", "Form"));
		$this->load->helper(array("array_helper"));

		$this->load->database("default");
	}

	public function index() {
		$this->publicaciones();
	}

	public function publicaciones($nro_pagina = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			$cantidad_publicaciones = 3;
			$datos = array();
			$datos["titulo"] = "Publicaciones";
			$datos["path_publicaciones"] = $this->imagen->get_path_valido("publicacion");
			if (!$nro_pagina) {
				$nro_pagina = 1;
			}
			$datos["nro_pagina"] = $nro_pagina;
			switch ($rol) {
				case "administrador":
					$datos["publicaciones"] = $this->Modelo_publicacion->select_publicaciones($nro_pagina, $cantidad_publicaciones);
					$datos["nro_paginas"] = $this->Modelo_publicacion->select_count_nro_paginas($cantidad_publicaciones);
					break;
				case "usuario":
					$id_institucion = $this->session->userdata("id_institucion");
					$datos["publicaciones"] = $this->Modelo_publicacion->select_publicaciones($nro_pagina, $cantidad_publicaciones, $id_institucion);
					$datos["nro_paginas"] = $this->Modelo_publicacion->select_count_nro_paginas($cantidad_publicaciones, $id_institucion);
					break;
			}

			$this->load->view("publicacion/publicaciones", $datos);
		} else {
			redirect(base_url());
		}
	}

	public function registrar_publicacion() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if (isset($_POST["submit"])) {
				$this->registrar_publicacion_bd();
			} else {
				$rol = $this->session->userdata("rol");
				$datos = array();
				$datos["titulo"] = "Registrar publicación";
				$datos["accion"] = "registrar";
				$datos["autores"] = $this->Modelo_autor->select_autores();
				$datos["categorias"] = $this->Modelo_categoria->select_categorias();
				$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

				if ($rol == "usuario") {
					$datos["institucion_usuario"] = new stdClass();
					$datos["institucion_usuario"]->id = $this->session->userdata("id_institucion");
					$datos["institucion_usuario"]->nombre = $this->session->userdata("nombre_institucion");
					eliminar_elementos_array($datos["instituciones"], array($datos["institucion_usuario"]), "id");
				} else {
					$datos["institucion_usuario"] = FALSE;
				}

				$this->load->view("publicacion/formulario_publicacion", $datos);
			}
		} else {
			redirect(base_url());
		}
	}

	private function registrar_publicacion_bd() {
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$con_modulos = $this->input->post("con_modulos") == "on" ? TRUE : FALSE;
		$modulos = $con_modulos === TRUE ? $this->input->post("modulos") : FALSE;
		$id_autor = $this->input->post("id_autor");
		$id_categoria = $this->input->post("id_categoria");
		$id_institucion = $this->input->post("id_institucion");

		$array_validacion = array("nombre", "descripcion", "id_autor", "id_categoria", "id_institucion");

		if ($con_modulos) {
			$array_validacion[] = "modulos";
		}

		if ($this->publicacion_validacion->validar($array_validacion)) {
			$path = FALSE;

			//si se subio una imagen o documento obtenemos un path para subir los archivos
			if (isset($_FILES["imagen"]) || isset($_FILES["url"])) {
				$path = $this->imagen->get_path_valido("publicacion");
			}

			//si no hay errores al obtener el path
			if ($path) {
				//subimos los archivos
				$imagen = $this->imagen->subir_archivo("imagen", $path);
				$documento = $this->documento->subir_archivo("url", $path);

				//si no hubo problemas al subir los archivos
				if (!$imagen["error"] && !$documento["error"]) {
					//recuperamos la direccion de los archivos
					$direccion_imagen = "";
					$direccion_documento = "";
					if ($imagen["datos"]) {
						$direccion_imagen = $imagen["datos"]["file_name"];
					}
					if ($documento["datos"]) {
						$direccion_documento = $documento["datos"]["file_name"];
					}

					if ($this->Modelo_publicacion->insert_publicacion($nombre, $descripcion, $modulos, $direccion_documento, $direccion_imagen, NULL, date('Y-m-d'), $id_autor, $id_categoria, $id_institucion)) {
						redirect(base_url("publicacion/publicaciones"));
					} else {
						$this->session->set_flashdata("error", "Ocurrió un error al registrar la publicación.");
						redirect(base_url("publicacion/registrar_publicacion"));
					}
				} else {
					$error = "";
					if ($imagen["error"]) {
						$error = $imagen["datos"];
					} else if ($documento["error"]) {
						$error = $documento["datos"];
					}
					$this->session->set_flashdata("error", $error);
					redirect(base_url("publicacion/registrar_publicacion"));
				}
			} else {
				$this->session->set_flashdata("error", "Ocurrió un error al guardar los archivos.");
				redirect(base_url("publicacion/registrar_publicacion"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_publicacion();
		}
	}

	public function modificar_publicacion($id) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_publicacion_bd();
				} else {
					$datos = array();

					switch ($rol) {
						case "administrador":
							$datos["publicacion"] = $this->Modelo_publicacion->select_publicacion_por_id($id);
							break;
						case "usuario":
							$id_institucion = $this->session->userdata("id_institucion");
							$datos["publicacion"] = $this->Modelo_publicacion->select_publicacion_por_id($id, $id_institucion);
							break;
					}

					if ($datos["publicacion"]) {
						$datos["titulo"] = "Modificar publicación";
						$datos["accion"] = "modificar";
						$datos["path_publicaciones"] = $this->imagen->get_path_valido("publicacion");
						$datos["autores"] = $this->Modelo_autor->select_autores();
						$datos["categorias"] = $this->Modelo_categoria->select_categorias();
						$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

						eliminar_elementos_array($datos["autores"], $datos["publicacion"]->autores, "id");
						eliminar_elementos_array($datos["categorias"], $datos["publicacion"]->categorias, "id");
						eliminar_elementos_array($datos["instituciones"], $datos["publicacion"]->instituciones, "id");

						$this->load->view("publicacion/formulario_publicacion", $datos);
					} else {
						$this->session->set_flashdata("error", "La publicación seleccionada no existe.");
						redirect(base_url("publicacion/publicaciones"));
					}
				}
			} else {
				redirect(base_url("publicacion/publicaciones"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_publicacion_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$con_modulos = $this->input->post("con_modulos") == "on" ? TRUE : FALSE;
		$modulos = $con_modulos === TRUE ? $this->input->post("modulos") : FALSE;
		$id_autor = $this->input->post("id_autor");
		$id_categoria = $this->input->post("id_categoria");
		$id_institucion = $this->input->post("id_institucion");
		$imagen_antiguo = $this->input->post("imagen_antiguo");
		$documento_antiguo = $this->input->post("url_antiguo");

		$array_validacion = array("nombre", "descripcion", "id_autor", "id_categoria", "id_institucion");

		if ($con_modulos) {
			$array_validacion[] = "modulos";
		}

		if ($this->publicacion_validacion->validar($array_validacion)) {
			$path = FALSE;

			//si se subio una imagen o documento obtenemos un path para subir los archivos
			if (isset($_FILES["imagen"]) || isset($_FILES["url"])) {
				$path = $this->imagen->get_path_valido("publicacion");
			}

			//si no hay errores al obtener el path
			if ($path) {
				//subimos los archivos
				if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {
					$this->imagen->eliminar_archivo($path . $imagen_antiguo);
				}
				$imagen = $this->imagen->subir_archivo("imagen", $path);
				if (isset($_FILES["url"]) && $_FILES["url"]["name"] != "") {
					$this->documento->eliminar_archivo($path . $documento_antiguo);
				}
				$documento = $this->documento->subir_archivo("url", $path);

				//si no hubo problemas al subir los archivos
				if (!$imagen["error"] && !$documento["error"]) {
					//recuperamos la direccion de los archivos
					$direccion_imagen = "";
					$direccion_documento = "";
					if ($imagen["datos"]) {
						$direccion_imagen = $imagen["datos"]["file_name"];
					} else {
						$direccion_imagen = $imagen_antiguo;
					}
					if ($documento["datos"]) {
						$direccion_documento = $documento["datos"]["file_name"];
					} else {
						$direccion_documento = $documento_antiguo;
					}

					if ($this->Modelo_publicacion->update_publicacion($id, $nombre, $descripcion, $modulos, $direccion_documento, $direccion_imagen, NULL, $id_autor, $id_categoria, $id_institucion)) {
						redirect(base_url("publicacion/publicaciones"));
					} else {
						$this->session->set_flashdata("error", "Ocurrió un error al modificar la publicación.");
						redirect(base_url("publicacion/modificar_publicacion/" . $id));
					}
				} else {
					$error = "";
					if ($imagen["error"]) {
						$error = $imagen["datos"];
					} else if ($documento["error"]) {
						$error = $documento["datos"];
					}
					$this->session->set_flashdata("error", $error);
					redirect(base_url("publicacion/modificar_publicacion/" . $id));
				}
			} else {
				$this->session->set_flashdata("error", "Ocurrió un error al guardar los archivos.");
				redirect(base_url("publicacion/modificar_publicacion/" . $id));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_publicacion();
		}
	}

	public function eliminar_publicacion($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if ($id) {
				$publicacion = $this->Modelo_publicacion->select_publicacion_por_id($id);

				if ($publicacion) {
					if ($this->Modelo_publicacion->delete_publicacion($id)) {
						$path = $this->documento->get_path_valido("publicacion");
						if (isset($publicacion->imagen) && $publicacion->imagen != "") {
							$this->imagen->eliminar_archivo($path . $publicacion->imagen);
						} if (isset($publicacion->url) && $publicacion->url != "") {
							$this->documento->eliminar_archivo($path . $publicacion->url);
						}

						redirect(base_url("publicacion/publicaciones"));
					} else {
						//error al borrar
						redirect(base_url("publicacion/publicaciones"));
					}
				} else {
					//error no existe publicacion
					redirect(base_url("publicacion/publicaciones"));
				}
			} else {
				//error de id
				redirect(base_url("publicacion/publicaciones"));
			}
		} else {
			redirect(base_url());
		}
	}

}
