<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Administrador
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array("Modelo_categoria", "Modelo_autor", "Modelo_institucion", "Modelo_publicacion"));
		$this->load->library(array("Session", "Form_validation", "Upload"));
		$this->load->library(array("Categoria", "Autor", "Institucion", "Publicacion"));
		$this->load->library(array("Imagen", "Documento"));
		$this->load->helper(array("Url", "Form"));
		$this->load->helper(array("array_helper"));
		$this->load->database("default");
	}

	public function index() {
		$this->categorias();
	}

	public function categorias() {
		//datos
		$datos = array();
		$datos["titulo"] = "Categorias";
		$datos["categorias"] = $this->Modelo_categoria->select_categorias();

		//cargamos la vista
		$this->load->view("administrador/categorias", $datos);
	}

	public function registrar_categoria() {
		if (isset($_POST["submit"]) && isset($_POST["nombre"])) {
			//registramos los datos
			$this->registrar_categoria_bd();
		} else {
			//datos
			$datos = array();
			$datos["titulo"] = "Registrar categoria";
			$datos["accion"] = "registrar";

			//cargamos la vista
			$this->load->view("administrador/formulario_categoria", $datos);
		}
	}

	private function registrar_categoria_bd() {
		//validamos los campos
		if ($this->categoria->validar(array("nombre"))) {
			//recuperamos los datos
			$nombre = $this->input->post("nombre");

			//si se inserta la categoria
			if ($this->Modelo_categoria->insert_categoria($nombre)) {
				redirect(base_url("administrador/categorias"));
			} else {
				unset($_POST["submit"]);
				$this->registrar_categoria();
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_categoria();
		}
	}

	public function modificar_categoria($id = FALSE) {
		if ($id) {
			if (isset($_POST["submit"]) && isset($_POST["id"]) && isset($_POST["nombre"])) {
				//actualizamos los datos
				$this->modificar_categoria_bd();
			} else {
				//datos
				$datos = array();
				$datos["titulo"] = "Modificar categoria";
				$datos["accion"] = "modificar";
				$datos["categoria"] = $this->Modelo_categoria->select_categoria_por_id($id);

				//cargamos la vista
				$this->load->view("administrador/formulario_categoria", $datos);
			}
		} else {
			redirect(base_url("administrador/categorias"));
		}
	}

	private function modificar_categoria_bd() {
		//recuperamos los datos
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");

		//validamos los campos
		if ($this->categoria->validar(array("id", "nombre"))) {

			//si se actualiza la categoria
			if ($this->Modelo_categoria->update_categoria($id, $nombre)) {
				redirect(base_url("administrador/categorias"));
			} else {
				unset($_POST["submit"]);
				$this->modificar_categoria($id);
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_categoria($id);
		}
	}

	public function autores() {
		//datos
		$datos = array();
		$datos["titulo"] = "Autores";
		$datos["autores"] = $this->Modelo_autor->select_autores();

		//cargamos la vista
		$this->load->view("administrador/autores", $datos);
	}

	public function registrar_autor() {
		if (isset($_POST["submit"]) && isset($_POST["nombre"]) && isset($_POST["apellido_paterno"]) && isset($_POST["apellido_materno"])) {
			//registramos los datos
			$this->registrar_autor_bd();
		} else {
			//datos
			$datos = array();
			$datos["titulo"] = "Registrar autor";
			$datos["accion"] = "registrar";
			$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

			//cargamos la vista
			$this->load->view("administrador/formulario_autor", $datos);
		}
	}

	private function registrar_autor_bd() {
		//recuperamos los datos
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$id_institucion = $this->input->post("id_institucion");

		//si los datos son validos
		if ($this->autor->validar(array("nombre", "apellido_paterno", "apellido_materno", "id_institucion"))) {
			//si se inserta el autor
			if ($this->Modelo_autor->insert_autor($nombre, $apellido_paterno, $apellido_materno, $id_institucion)) {
				redirect(base_url("administrador/autores"));
			} else {
				unset($_POST["submit"]);
				$this->registrar_autor();
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_autor();
		}
	}

	public function modificar_autor($id = FALSE) {
		if ($id) {
			if (isset($_POST["submit"]) && isset($_POST["id"]) && isset($_POST["nombre"]) && isset($_POST["apellido_paterno"]) && isset($_POST["apellido_materno"])) {
				$this->modificar_autor_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Modificar autor";
				$datos["accion"] = "modificar";
				$datos["autor"] = $this->Modelo_autor->select_autor_por_id($id);
				$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();
				
				if ($datos["autor"]->instituciones && $datos["instituciones"]) {
					foreach ($datos["autor"]->instituciones as $institucion) {
						$i = search_object_in_array_by_key($institucion, $datos["instituciones"], "id");
						if ($i !== FALSE) {
							unset($datos["instituciones"][$i]);
						}
					}
				}

				$this->load->view("administrador/formulario_autor", $datos);
			}
		} else {
			redirect(base_url("administrador/autores"));
		}
	}

	private function modificar_autor_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$id_institucion = $this->input->post("id_institucion");

		if ($this->autor->validar(array("id", "nombre", "apellido_paterno", "apellido_materno", "id_institucion"))) {
			if ($this->Modelo_autor->update_autor($id, $nombre, $apellido_paterno, $apellido_materno, $id_institucion)) {
				redirect(base_url("administrador/autores"));
			} else {
				unset($_POST["submit"]);
				$this->modificar_autor($id);
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_autor($id);
		}
	}

	public function instituciones() {
		$datos = array();
		$datos["titulo"] = "Instituciones";
		$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

		$this->load->view("administrador/instituciones", $datos);
	}

	public function registrar_institucion() {
		if (isset($_POST["submit"]) && isset($_POST["nombre"]) && isset($_POST["sigla"])) {
			$this->registrar_institucion_bd();
		} else {
			$datos = array();
			$datos["titulo"] = "Registrar institución";
			$datos["accion"] = "registrar";

			$this->load->view("administrador/formulario_institucion", $datos);
		}
	}

	private function registrar_institucion_bd() {
		$nombre = $this->input->post("nombre");
		$sigla = $this->input->post("sigla");

		if ($this->institucion->validar(array("nombre", "sigla"))) {
			if ($this->Modelo_institucion->insert_institucion($nombre, $sigla)) {
				redirect(base_url("administrador/instituciones"));
			} else {
				unset($_POST["submit"]);
				$this->registrar_institucion();
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_institucion();
		}
	}

	public function modificar_institucion($id = FALSE) {
		if ($id) {
			if (isset($_POST["submit"]) && isset($_POST["id"]) && isset($_POST["nombre"]) && isset($_POST["sigla"])) {
				$this->modificar_institucion_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Modificar institución";
				$datos["accion"] = "modificar";
				$datos["institucion"] = $this->Modelo_institucion->select_institucion_por_id($id);

				$this->load->view("administrador/formulario_institucion", $datos);
			}
		} else {
			redirect(base_url("administrador/instituciones"));
		}
	}

	public function modificar_institucion_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$sigla = $this->input->post("sigla");

		if ($this->institucion->validar(array("id", "nombre", "sigla"))) {
			if ($this->Modelo_institucion->update_institucion($id, $nombre, $sigla)) {
				redirect(base_url("administrador/instituciones"));
			} else {
				unset($_POST["submit"]);
				$this->modificar_institucion($id);
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_institucion($id);
		}
	}

	public function publicaciones() {
		$datos = array();
		$datos["titulo"] = "Publicaciones";
		$datos["publicaciones"] = $this->Modelo_publicacion->select_publicaciones();

		$this->load->view("administrador/publicaciones", $datos);
	}

	public function registrar_publicacion() {

		if (isset($_POST["submit"]) && isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_FILES["imagen"])) {
			$this->registrar_publicacion_bd();
		} else {
			$datos = array();
			$datos["titulo"] = "Registrar publicación";
			$datos["accion"] = "registrar";
			$datos["autores"] = $this->Modelo_autor->select_autores();
			$datos["categorias"] = $this->Modelo_categoria->select_categorias();
			$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();

			$this->load->view("administrador/formulario_publicacion", $datos);
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

		if ($this->publicacion->validar($array_validacion)) {
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
						$direccion_imagen = base_url($path . $imagen["datos"]["file_name"]);
					}
					if ($documento["datos"]) {
						$direccion_documento = base_url($path . $documento["datos"]["file_name"]);
					}

					if ($this->Modelo_publicacion->insert_publicacion($nombre, $descripcion, $modulos, $direccion_documento, $direccion_imagen, NULL, $id_autor, $id_categoria, $id_institucion)) {
						redirect(base_url("administrador/publicaciones"));
					} else {
						//error al insertar publicacion
						unset($_POST["submit"]);
						$this->registrar_publicacion();
					}
				} else {
					//error al subir archivos
					unset($_POST["submit"]);
					$this->registrar_publicacion();
				}
			} else {
				//error de path
				unset($_POST["submit"]);
				$this->registrar_publicacion();
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_publicacion();
		}

		//$path = $this->imagen->get_path_valido("publicacion");
	}

}
