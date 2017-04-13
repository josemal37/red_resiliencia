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
		$this->load->helper(array("Array_helper", "Social_helper"));

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

		$datos["titulo"] = "Artículos";
		$datos["criterio"] = $criterio;
		$datos["nro_pagina"] = $nro_pagina;
		/*
		$datos["nro_paginas"] = $this->Modelo_articulo->select_count_nro_paginas($cantidad_articulos, $id_institucion);
		$datos["articulos"] = $this->Modelo_articulo->select_articulos($nro_pagina, $cantidad_articulos, $id_institucion, $criterio);
		*/
		$datos["total_articulos"] = $this->Modelo_articulo->select_articulos_2($nro_pagina, $cantidad_articulos, $id_institucion, $criterio, TRUE);
		$datos["nro_paginas"] = $this->Modelo_articulo->nro_paginas($datos["total_articulos"], $cantidad_articulos);
		$datos["articulos"] = $this->Modelo_articulo->select_articulos_2($nro_pagina, $cantidad_articulos, $id_institucion, $criterio);
		$datos["path_articulos"] = $this->imagen->get_path_valido("articulo");

		$this->load->view("articulo/articulos", $datos);
	}

	public function ver_articulo($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($id) {
			if ($rol == "usuario") {
				$id_institucion = $this->session->userdata("id_institucion");
			} else {
				$id_institucion = FALSE;
			}

			$datos = array();
			$datos["articulo"] = $this->Modelo_articulo->select_articulo_por_id($id, $id_institucion);

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

		if ($rol == "administrador" || $rol == "usuario") {
			if (isset($_POST["submit"])) {
				$this->registrar_articulo_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Registrar articulo";
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

				$datos["reglas_validacion"] = $this->articulo_validacion->get_reglas_cliente(array("nombre", "descripcion", "imagen"));

				$this->load->view("articulo/formulario_articulo", $datos);
			}
		} else {
			redirect(base_url());
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
				$url = basename($nuevo_nombre);
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
					if ($rol == "usuario") {
						$id_institucion = $this->session->userdata("id_institucion");
					} else {
						$id_institucion = FALSE;
					}

					$datos = array();
					$datos["articulo"] = $this->Modelo_articulo->select_articulo_por_id($id, $id_institucion);

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

						$datos["reglas_validacion"] = $this->articulo_validacion->get_reglas_cliente(array("nombre", "descripcion"));

						$this->load->view("articulo/formulario_articulo", $datos);
					} else {
						$this->session->set_flashdata("error", "El articulo seleccionado no existe.");
						redirect(base_url("articulo/articulos"));
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
			if ($rol == "usuario") {
				$id_institucion = $this->session->userdata("id_institucion");
			} else {
				$id_institucion = FALSE;
			}

			$articulo = $this->Modelo_articulo->select_articulo_por_id($id, $id_institucion);

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

	public function busqueda_avanzada() {
		$datos = array();

		$datos["titulo"] = "Busqueda avanzada";
		$datos["fuente"] = "articulo";
		$datos["categorias"] = $this->Modelo_categoria->select_categorias();
		$datos["autores"] = $this->Modelo_autor->select_autores();
		$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

		if (isset($_POST["submit"])) {
			$con_categorias = $this->input->post("con_categorias") == "on" ? TRUE : FALSE;
			$categorias = $con_categorias ? $this->input->post("id_categoria") : FALSE;
			$con_autor = $this->input->post("con_autor") == "on" ? TRUE : FALSE;
			$id_autor = $con_autor ? $this->input->post("id_autor") : FALSE;
			$con_institucion = $this->input->post("con_institucion") == "on" ? TRUE : FALSE;
			$id_institucion = $con_institucion ? $this->input->post("id_institucion") : FALSE;

			$datos["id_autor"] = $id_autor;
			$datos["id_institucion"] = $id_institucion;

			if ($categorias) {
				$datos["categorias_seleccionadas"] = $datos["categorias"];
				$ids_categorias = array();
				foreach ($categorias as $categoria) {
					$obj_categoria = new stdClass();
					$obj_categoria->id = $categoria;
					$ids_categorias[] = $obj_categoria;
				}
				eliminar_elementos_array($datos["categorias"], $ids_categorias, "id");
				eliminar_elementos_array($datos["categorias_seleccionadas"], $datos["categorias"], "id");
			} else {
				$datos["categorias_seleccionadas"] = FALSE;
			}

			$datos["articulos"] = $this->Modelo_articulo->select_articulos_con_filtro($categorias, $id_autor, $id_institucion);
			$datos["submit"] = TRUE;

			$datos["path_articulos"] = $this->imagen->get_path_valido("articulo");
		} else {
			$datos["articulos"] = FALSE;
			$datos["submit"] = FALSE;
		}

		$this->load->view("base/busqueda_avanzada", $datos);
	}

}
