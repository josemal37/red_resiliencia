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
		$this->load->helper(array("array_helper", "social_helper"));

		$this->load->database("default");
	}

	public function index() {
		$this->eventos();
	}

	public function eventos($nro_pagina = FALSE) {
		$rol = $this->session->userdata("rol");

		$datos = array();

		$cantidad_eventos = 4;
		if (!$nro_pagina) {
			$nro_pagina = 1;
		}

		$datos["titulo"] = "Eventos";
		$datos["path_evento"] = $this->imagen->get_path_valido("evento");
		$datos["nro_pagina"] = $nro_pagina;

		$criterio = $this->input->get("criterio");
		$id_categoria = $this->input->get("categoria");
		$id_institucion = $this->input->get("institucion");
		$id_pais = $this->input->get("pais");
		$id_ciudad = $this->input->get("ciudad");
		$fecha = $this->input->get("fecha");

		if ($rol == "usuario") {
			$id_institucion = $this->session->userdata("id_institucion");
		}

		$datos["criterio"] = $criterio;
		$datos["id_categoria"] = $id_categoria;
		$datos["id_institucion"] = $id_institucion;
		$datos["id_pais"] = $id_pais;
		$datos["id_ciudad"] = $id_ciudad;
		$datos["fecha"] = $fecha;
		$datos["submit"] = $this->input->get("submit");

		/*
		  switch ($rol) {
		  case "administrador":
		  $datos["eventos"] = $this->Modelo_evento->select_eventos($nro_pagina, $cantidad_eventos, NULL, $criterio);
		  $datos["nro_paginas"] = $this->Modelo_evento->select_count_nro_paginas($cantidad_eventos);
		  break;
		  case "usuario":
		  $id_institucion = $this->session->userdata("id_institucion");
		  $datos["eventos"] = $this->Modelo_evento->select_eventos($nro_pagina, $cantidad_eventos, $id_institucion, $criterio);
		  $datos["nro_paginas"] = $this->Modelo_evento->select_count_nro_paginas($cantidad_eventos, $id_institucion);
		  break;
		  default:
		  $datos["eventos"] = $this->Modelo_evento->select_eventos($nro_pagina, $cantidad_eventos, NULL, $criterio);
		  $datos["nro_paginas"] = $this->Modelo_evento->select_count_nro_paginas($cantidad_eventos);
		  break;
		  }
		 */

		$datos["eventos"] = $this->Modelo_evento->select_eventos_2($nro_pagina, $cantidad_eventos, $id_categoria, $id_institucion, $id_pais, $id_ciudad, $fecha, $criterio);
		$datos["total_eventos"] = $this->Modelo_evento->select_eventos_2($nro_pagina, $cantidad_eventos, $id_categoria, $id_institucion, $id_pais, $id_ciudad, $fecha, $criterio, TRUE);
		$datos["nro_paginas"] = $this->Modelo_evento->nro_paginas($datos["total_eventos"], $cantidad_eventos);

		$datos["categorias"] = $this->Modelo_categoria->select_categorias();
		$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();
		$datos["paises"] = $this->Modelo_pais->select_paises();
		
		if ($id_pais) {
			$datos["ciudades"] = $this->Modelo_ciudad->select_ciudades($id_pais);
		}
		
		$this->load->view("evento/eventos", $datos);
	}

	public function ver_evento($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($id) {
			$datos = array();
			switch ($rol) {
				case "administrador":
					$datos["evento"] = $this->Modelo_evento->select_evento_por_id($id);
					break;
				case "usuario":
					$id_institucion = $this->session->userdata("id_institucion");
					$datos["evento"] = $this->Modelo_evento->select_evento_por_id($id, $id_institucion);
					break;
				default:
					$datos["evento"] = $this->Modelo_evento->select_evento_por_id($id);
					break;
			}

			if ($datos["evento"]) {
				$datos["titulo"] = $datos["evento"]->nombre;
				$datos["path_evento"] = $this->imagen->get_path_valido("evento");

				$this->load->view("evento/evento", $datos);
			} else {
				redirect(base_url("evento/eventos"));
			}
		} else {
			redirect(base_url("evento/eventos"));
		}
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

				if ($rol == "usuario") {
					$datos["institucion_usuario"] = new stdClass();
					$datos["institucion_usuario"]->id = $this->session->userdata("id_institucion");
					$datos["institucion_usuario"]->nombre = $this->session->userdata("nombre_institucion");
					eliminar_elementos_array($datos["instituciones"], array($datos["institucion_usuario"]), "id");
				} else {
					$datos["institucion_usuario"] = FALSE;
				}

				$datos["reglas_validacion"] = $this->evento_validacion->get_reglas_cliente(array("nombre", "descripcion", "imagen", "fecha_inicio", "fecha_fin", "pais", "ciudad", "direccion", "url"));

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
		$url = $this->input->post("url");

		if ($this->evento_validacion->validar(array("nombre", "descripcion", "fecha_inicio", "fecha_fin", "ciudad", "direccion", "id_categoria", "id_institucion", "url"))) {
			$path = $this->imagen->get_path_valido("evento");

			if ($path) {
				$imagen = $this->imagen->subir_archivo("imagen", $path);

				if (!$imagen["error"]) {
					$direccion_imagen = "";

					if ($imagen["datos"]) {
						$direccion_imagen = $imagen["datos"]["file_name"];
					}

					if ($this->Modelo_evento->insert_evento($ciudad, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $direccion, $direccion_imagen, NULL, $id_categoria, $id_institucion, $url)) {
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

	public function modificar_evento($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_evento_bd();
				} else {
					$datos = array();

					switch ($rol) {
						case "administrador":
							$datos["evento"] = $this->Modelo_evento->select_evento_por_id($id);
							break;
						case "usuario":
							$id_institucion = $this->session->userdata("id_institucion");
							$datos["evento"] = $this->Modelo_evento->select_evento_por_id($id, $id_institucion);
							break;
					}

					if ($datos["evento"]) {
						$datos["titulo"] = "Modificar evento";
						$datos["accion"] = "modificar";
						$datos["path_eventos"] = $this->imagen->get_path_valido("evento");
						$datos["paises"] = $this->Modelo_pais->select_paises();
						if ($datos["paises"]) {
							$datos["ciudades"] = $this->Modelo_ciudad->select_ciudades($datos["evento"]->pais->id);
						} else {
							$datos["ciudades"] = FALSE;
						}
						$datos["categorias"] = $this->Modelo_categoria->select_categorias();
						$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

						eliminar_elementos_array($datos["categorias"], $datos["evento"]->categorias, "id");
						eliminar_elementos_array($datos["instituciones"], $datos["evento"]->instituciones, "id");

						if ($rol == "usuario") {
							$datos["institucion_usuario"] = new stdClass();
							$datos["institucion_usuario"]->id = $this->session->userdata("id_institucion");
							$datos["institucion_usuario"]->nombre = $this->session->userdata("nombre_institucion");
							eliminar_elementos_array($datos["instituciones"], array($datos["institucion_usuario"]), "id");
						} else {
							$datos["institucion_usuario"] = FALSE;
						}

						$datos["reglas_validacion"] = $this->evento_validacion->get_reglas_cliente(array("nombre", "descripcion", "fecha_inicio", "fecha_fin", "pais", "ciudad", "direccion", "url"));

						$this->load->view("evento/formulario_evento", $datos);
					} else {
						$this->session->set_flashdata("error", "El evento seleccionado no existe.");
						redirect(base_url("evento/eventos"));
					}
				}
			} else {
				redirect(base_url("evento/eventos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_evento_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$imagen_antiguo = $this->input->post("imagen_antiguo");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_fin = $this->input->post("fecha_fin");
		$pais = $this->input->post("pais");
		$ciudad = $this->input->post("ciudad");
		$direccion = $this->input->post("direccion");
		$id_categoria = $this->input->post("id_categoria");
		$id_institucion = $this->input->post("id_institucion");
		$url = $this->input->post("url");

		if ($this->evento_validacion->validar(array("id", "nombre", "descripcion", "fecha_inicio", "fecha_fin", "ciudad", "direccion", "id_categoria", "id_institucion", "url"))) {
			$direccion_imagen = "";
			if ($_FILES["imagen"]["name"] != "") {
				$path = $this->imagen->get_path_valido("evento");

				if ($path) {
					$this->imagen->eliminar_archivo($path . $imagen_antiguo);
					$imagen = $this->imagen->subir_archivo("imagen", $path);

					if (!$imagen["error"]) {
						$direccion_imagen = "";

						if ($imagen["datos"]) {
							$direccion_imagen = $imagen["datos"]["file_name"];
						}
					} else {
						$error = "";
						if ($imagen["error"]) {
							$error = $imagen["datos"];
						}

						$this->session->set_flashdata("error", $error);
						redirect(base_url("evento/modificar_evento/" . $id));
					}
				} else {
					$this->session->set_flashdata("error", "Ocurrió un error al guardar los archivos.");
					redirect(base_url("evento/modificar_evento/" . $id));
				}
			} else {
				$direccion_imagen = $imagen_antiguo;
			}

			if ($this->Modelo_evento->update_evento($id, $ciudad, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $direccion, $direccion_imagen, NULL, $id_categoria, $id_institucion, $url)) {
				redirect(base_url("evento/eventos"));
			} else {
				$this->session->set_flashdata("error", "Ocurrió un error al modificar el evento.");
				redirect(base_url("evento/modificar_evento/" . $id));
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_evento($id);
		}
	}

	public function eliminar_evento($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "usuario") {
			if ($id) {
				switch ($rol) {
					case "administrador":
						$evento = $this->Modelo_evento->select_evento_por_id($id);
						break;
					case "usuario":
						$id_institucion = $this->session->userdata("id_institucion");
						$evento = $this->Modelo_evento->select_evento_por_id($id, $id_institucion);
						break;
				}

				if ($evento) {
					if ($this->Modelo_evento->delete_evento($id)) {
						$path = $this->imagen->get_path_valido("evento");
						if (isset($evento->imagen) && $evento->imagen != "") {
							$this->imagen->eliminar_archivo($path . $evento->imagen);
						}

						redirect(base_url("evento/eventos"));
					} else {
						redirect(base_url("evento/eventos"));
					}
				} else {
					redirect(base_url("evento/eventos"));
				}
			} else {
				redirect(base_url("evento/eventos"));
			}
		} else {
			redirect(base_url());
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

	public function busqueda_avanzada() {
		$datos = array();

		$datos["titulo"] = "Busqueda avanzada";
		$datos["fuente"] = "evento";
		$datos["categorias"] = $this->Modelo_categoria->select_categorias();
		$datos["paises"] = $this->Modelo_pais->select_paises();
		if ($datos["paises"]) {
			$datos["ciudades"] = $this->Modelo_ciudad->select_ciudades($datos["paises"][0]->id);
		} else {
			$datos["ciudades"] = FALSE;
		}
		$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

		if (isset($_POST["submit"])) {

			$con_categorias = $this->input->post("con_categorias") == "on" ? TRUE : FALSE;
			$categorias = $con_categorias ? $this->input->post("id_categoria") : FALSE;
			$con_institucion = $this->input->post("con_institucion") == "on" ? TRUE : FALSE;
			$id_institucion = $con_institucion ? $this->input->post("id_institucion") : FALSE;
			$con_pais = $this->input->post("con_pais") == "on" ? TRUE : FALSE;
			$id_pais = $con_pais ? $this->input->post("pais") : FALSE;
			$con_ciudad = $con_pais && $this->input->post("con_ciudad") == "on" ? TRUE : FALSE;
			$id_ciudad = $con_ciudad ? $this->input->post("ciudad") : FALSE;
			$con_fecha = $this->input->post("con_fecha") == "on" ? TRUE : FALSE;
			$id_fecha = $con_fecha ? $this->input->post("fecha") : FALSE;

			$datos["id_institucion"] = $id_institucion;
			$datos["id_pais"] = $id_pais;
			$datos["id_ciudad"] = $id_ciudad;
			$datos["id_fecha"] = $id_fecha;
			$datos["ciudades"] = $this->Modelo_ciudad->select_ciudades($id_pais);

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

			$datos["eventos"] = $this->Modelo_evento->select_eventos_con_filtro($categorias, $id_institucion, $id_pais, $id_ciudad, $id_fecha);
			$datos["submit"] = TRUE;

			$datos["path_evento"] = $this->imagen->get_path_valido("evento");
		} else {
			$datos["articulos"] = FALSE;
			$datos["submit"] = FALSE;
		}

		$this->load->view("base/busqueda_avanzada", $datos);
	}

}
