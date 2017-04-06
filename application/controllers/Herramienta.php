<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Herramienta
 *
 * @author Jose
 */
class Herramienta extends CI_Controller {

	const NRO_REGISTROS = 4;

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_herramienta", "Modelo_autor", "Modelo_categoria", "Modelo_institucion"));

		$this->load->library(array("Session", "Form_validation", "Upload"));
		$this->load->library(array("Herramienta_validacion"));
		$this->load->library(array("Imagen"));

		$this->load->helper(array("Url", "Form"));
		$this->load->helper(array("array_helper", "youtube_helper"));

		$this->load->database("default");
	}

	public function index() {
		$this->herramientas();
	}

	public function herramientas() {
		$rol = $this->session->userdata("rol");

		$datos = array();
		$datos["titulo"] = "Herramientas";
		$datos["path_herramientas"] = $this->imagen->get_path_valido("herramienta");

		if (isset($_GET["criterio"])) {
			$criterio = $this->input->get("criterio");
		} else {
			$criterio = FALSE;
		}
		$datos["criterio"] = $criterio;

		if ($rol == "usuario") {
			$id_institucion = $this->session->userdata("id_institucion");
		} else {
			$id_institucion = FALSE;
		}

		$datos["herramientas"] = $this->Modelo_herramienta->select_herramientas(1, self::NRO_REGISTROS, $id_institucion, $criterio);

		$this->load->view("herramienta/herramientas", $datos);
	}

	public function ver_herramienta($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($id) {
			if ($rol == "usuario") {
				$id_institucion = $this->session->userdata("id_institucion");
			} else {
				$id_institucion = FALSE;
			}

			$datos = array();
			$datos["herramienta"] = $this->Modelo_herramienta->select_herramienta($id, $id_institucion);
			if ($datos["herramienta"]) {
				$datos["titulo"] = $datos["herramienta"]->nombre;
				$datos["path_herramientas"] = $this->imagen->get_path_valido("herramienta");
				$this->load->view("herramienta/herramienta", $datos);
			} else {
				$this->session->set_flashdata("error", "La herramienta seleccionada no existe.");
				redirect(base_url("herramienta/herramientas"), "refresh");
			}
		} else {
			redirect(base_url("herramienta/herramientas"));
		}
	}

	public function registrar_herramienta() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if (isset($_POST["submit"])) {
				$this->registrar_herramienta_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Registrar herramienta";
				$datos["accion"] = "registrar";
				$datos["autores"] = $this->Modelo_autor->select_autores();
				$datos["categorias"] = $this->Modelo_categoria->select_categorias();
				$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();
				$datos["reglas_validacion"] = $this->herramienta_validacion->get_reglas_cliente(array("nombre", "descripcion", "imagen", "url", "video"));

				if ($rol == "usuario") {
					$institucion = $this->Modelo_institucion->select_institucion_por_id($this->session->userdata("id_institucion"));
					$datos["institucion_usuario"] = $institucion;

					eliminar_elementos_array($datos["instituciones"], array($institucion), "id");
				}

				$this->load->view("herramienta/formulario_herramienta", $datos);
			}
		} else {
			redirect(base_url());
		}
	}

	private function registrar_herramienta_bd() {
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$url_video = $this->input->post("video");
		$url_herramienta = $this->input->post("url");
		$id_autor = $this->input->post("id_autor");
		$id_categoria = $this->input->post("id_categoria");
		$id_institucion = $this->input->post("id_institucion");

		if ($this->herramienta_validacion->validar(array("nombre", "descripcion", "video", "url"))) {
			$direccion_imagen = $this->subir_imagen();

			if ($this->Modelo_herramienta->insert_herramienta($nombre, $descripcion, $direccion_imagen, $url_video, $url_herramienta, $id_autor, $id_categoria, $id_institucion)) {
				redirect(base_url("herramienta/herramientas"));
			} else {
				redirect(base_url("herramienta/registrar_herramienta"));
			}
		}
	}

	public function modificar_herramienta($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if (isset($_POST["submit"])) {
				$this->modificar_herramienta_bd();
			} else {
				if ($id) {
					if ($rol == "usuario") {
						$id_institucion = $this->session->userdata("id_institucion");
					} else {
						$id_institucion = FALSE;
					}
					$herramienta = $this->Modelo_herramienta->select_herramienta($id, $id_institucion);

					if ($herramienta) {
						$datos = array();
						$datos["titulo"] = "Modificar herramienta";
						$datos["accion"] = "modificar";
						$datos["path_herramientas"] = $this->imagen->get_path_valido("herramienta");
						$datos["herramienta"] = $herramienta;
						$datos["autores"] = $this->Modelo_autor->select_autores();
						$datos["categorias"] = $this->Modelo_categoria->select_categorias();
						$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();
						$datos["reglas_validacion"] = $this->herramienta_validacion->get_reglas_cliente(array("nombre", "descripcion", "imagen", "url", "video"));

						eliminar_elementos_array($datos["autores"], $herramienta->autores, "id");
						eliminar_elementos_array($datos["categorias"], $herramienta->categorias, "id");
						eliminar_elementos_array($datos["instituciones"], $herramienta->instituciones, "id");

						$this->load->view("herramienta/formulario_herramienta", $datos);
					} else {
						$this->session->set_flashdata("error", "La herramienta seleccionada no existe.");
						redirect(base_url("herramienta/herramientas"), "refresh");
					}
				} else {
					redirect(base_url("herramienta/herramientas"));
				}
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_herramienta_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$url_video = $this->input->post("video");
		$url_herramienta = $this->input->post("url");
		$id_autor = $this->input->post("id_autor");
		$id_categoria = $this->input->post("id_categoria");
		$id_institucion = $this->input->post("id_institucion");
		$imagen_antiguo = $this->input->post("imagen_antiguo");

		if ($this->herramienta_validacion->validar(array("nombre", "descripcion", "video", "url"))) {
			if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {
				$path = $this->imagen->get_path_valido("herramienta");
				$this->imagen->eliminar_archivo($path . $imagen_antiguo);
				$direccion_imagen = $this->subir_imagen("modificar_herramienta/" . $id);
			} else {
				$direccion_imagen = $imagen_antiguo;
			}

			if ($this->Modelo_herramienta->update_herramienta($id, $nombre, $descripcion, $direccion_imagen, $url_video, $url_herramienta, $id_autor, $id_categoria, $id_institucion)) {
				redirect(base_url("herramienta/herramientas"));
			} else {
				$this->session->set_userdata("error", "Ocurrió un error al modificar los datos de la herramienta.");
				redirect(base_url("herramienta/modificar_herramienta/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_herramienta($id);
		}
	}

	public function eliminar_herramienta($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if ($rol == "usuario") {
				$id_institucion = $this->session->userdata("id_institucion");
			} else {
				$id_institucion = FALSE;
			}

			$herramienta = $this->Modelo_herramienta->select_herramienta($id, $id_institucion);

			if ($herramienta) {
				if ($this->Modelo_herramienta->delete_herramienta($id)) {
					$path_herramientas = $this->imagen->get_path_valido("herramienta");
					unlink($path_herramientas . $herramienta->imagen);
					redirect(base_url("herramienta/herramientas"));
				} else {
					$this->session->set_flashdata("error", "Ocurrió un error al eliminar la herramienta.");
					redirect(base_url("herramienta/herramientas"));
				}
			} else {
				$this->session->set_flashdata("error", "La herramienta seleccionada no existe.");
				redirect(base_url("herramienta/herramientas"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function subir_imagen($accion = "registrar_herramienta") {
		$direccion_imagen = FALSE;

		$path = $this->imagen->get_path_valido("herramienta");

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
			redirect(base_url("herramienta/" . $accion));
		}
	}

}
