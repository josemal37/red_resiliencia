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
		$this->load->model(array("Modelo_categoria", "Modelo_autor", "Modelo_institucion", "Modelo_publicacion", "Modelo_usuario", "Modelo_rol"));
		$this->load->library(array("Session", "Form_validation", "Upload"));
		$this->load->library(array("Categoria", "Autor", "Institucion", "Publicacion", "Usuario"));
		$this->load->library(array("Imagen", "Documento"));
		$this->load->helper(array("Url", "Form"));
		$this->load->helper(array("array_helper"));
		$this->load->database("default");
	}

	public function index() {
		$this->categorias();
	}

	public function usuarios() {
		$datos = array();
		$datos["titulo"] = "Usuarios";
		$datos["usuarios"] = $this->Modelo_usuario->select_usuarios();

		$this->load->view("administrador/usuarios", $datos);
	}

	public function registrar_usuario() {
		if (isset($_POST["submit"])) {
			$this->registrar_usuario_bd();
		} else {
			$datos = array();
			$datos["titulo"] = "Registrar usuario";
			$datos["accion"] = "registrar";
			$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();
			$datos["roles"] = $this->Modelo_rol->select_roles();

			$this->load->view("administrador/formulario_usuario", $datos);
		}
	}

	private function registrar_usuario_bd() {
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$institucion = $this->input->post("institucion");
		$rol = $this->input->post("rol");
		$login = $this->input->post("login");
		$password = $this->input->post("password");
		if ($this->usuario->validar(array("nombre", "apellido_paterno", "apellido_materno", "institucion", "rol", "login", "password", "confirmacion"))) {
			if ($this->Modelo_usuario->insert_usuario($nombre, $apellido_paterno, $apellido_materno, $institucion, $rol, $login, $password)) {
				redirect(base_url("administrador/usuarios"));
			} else {
				unset($_POST["submit"]);
				$this->registrar_usuario();
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_usuario();
		}
	}

	public function modificar_usuario($id = FALSE) {
		if ($id) {
			if (isset($_POST["submit"])) {
				$this->modificar_usuario_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Modificar usuario";
				$datos["accion"] = "modificar";
				$datos["instituciones"] = $this->Modelo_institucion->select_instituciones();
				$datos["roles"] = $this->Modelo_rol->select_roles();
				$datos["usuario"] = $this->Modelo_usuario->select_usuario($id);

				$this->load->view("administrador/formulario_usuario", $datos);
			}
		} else {
			redirect(base_url("administrador/usuarios"));
		}
	}

	public function modificar_usuario_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$institucion = $this->input->post("institucion");
		$rol = $this->input->post("rol");
		$login = $this->input->post("login");
		if ($this->usuario->validar(array("id", "nombre", "apellido_paterno", "apellido_materno", "institucion", "rol", "login"))) {
			if ($this->Modelo_usuario->update_usuario($id, $nombre, $apellido_paterno, $apellido_materno, $institucion, $rol, $login)) {
				redirect(base_url("administrador/usuarios"));
			} else {
				unset($_POST["submit"]);
				$this->modificar_usuario($id);
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_usuario($id);
		}
	}

	public function modificar_password_usuario($id = FALSE) {
		if ($id) {
			if (isset($_POST["submit"])) {
				$this->modificar_password_usuario_bd();
			} else {
				$datos = array();
				$datos["titulo"] = "Modificar usuario";
				$datos["accion"] = "modificar_password";
				$datos["usuario"] = $this->Modelo_usuario->select_usuario($id);

				$this->load->view("administrador/formulario_usuario", $datos);
			}
		} else {
			redirect(base_url("administrador/usuarios"));
		}
	}

	public function modificar_password_usuario_bd() {
		$id = $this->input->post("id");
		$password = $this->input->post("password");
		if ($this->usuario->validar(array("id", "password", "confirmacion"))) {
			if ($this->Modelo_usuario->update_password_usuario($id, $password)) {
				redirect(base_url("administrador/usuarios"));
			} else {
				unset($_POST["submit"]);
				$this->modificar_password_usuario($id);
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_password_usuario($id);
		}
	}

	public function eliminar_usuario($id = FALSE) {
		if ($id) {
			if ($this->Modelo_usuario->delete_usuario($id)) {
				redirect(base_url("administrador/usuarios"));
			} else {
				redirect(base_url("administrador/usuarios"));
			}
		} else {
			redirect(base_url("administrador/usuarios"));
		}
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

	public function eliminar_categoria($id = FALSE) {
		if ($id) {
			if ($this->Modelo_categoria->delete_categoria($id)) {
				redirect(base_url("administrador/categorias"));
			} else {
				redirect(base_url("administrador/categorias"));
			}
		} else {
			redirect(base_url("administrador/categorias"));
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
				eliminar_elementos_array($datos["instituciones"], $datos["autor"]->instituciones, "id");

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

	public function eliminar_autor($id = FALSE) {
		if ($id) {
			if ($this->Modelo_autor->delete_autor($id)) {
				redirect(base_url("administrador/autores"));
			} else {
				redirect(base_url("administrador/autores"));
			}
		} else {
			redirect(base_url("administrador/autores"));
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

	public function eliminar_institucion($id = FALSE) {
		if ($id) {
			if ($this->Modelo_institucion->delete_institucion($id)) {
				redirect(base_url("administrador/instituciones"));
			} else {
				redirect(base_url("administrador/instituciones"));
			}
		} else {
			redirect(base_url("administrador/instituciones"));
		}
	}

	public function publicaciones() {
		$datos = array();
		$datos["titulo"] = "Publicaciones";
		$datos["path_publicaciones"] = $this->imagen->get_path_valido("publicacion");
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
						$direccion_imagen = $imagen["datos"]["file_name"];
					}
					if ($documento["datos"]) {
						$direccion_documento = $documento["datos"]["file_name"];
					}

					if ($this->Modelo_publicacion->insert_publicacion($nombre, $descripcion, $modulos, $direccion_documento, $direccion_imagen, NULL, date('Y-m-d'), $id_autor, $id_categoria, $id_institucion)) {
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
	}

	public function modificar_publicacion($id) {
		if ($id) {
			if (isset($_POST["submit"]) && isset($_POST["nombre"])) {
				$this->modificar_publicacion_bd();
			} else {
				$datos = array();

				$datos["publicacion"] = $this->Modelo_publicacion->select_publicacion_por_id($id);

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

					$this->load->view("administrador/formulario_publicacion", $datos);
				} else {
					redirect(base_url("administrador/publicaciones"));
				}
			}
		} else {
			redirect(base_url("administrador/publicaciones"));
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

		if ($this->publicacion->validar($array_validacion)) {
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
	}

	public function eliminar_publicacion($id = FALSE) {
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

					redirect(base_url("administrador/publicaciones"));
				} else {
					//error al borrar
					redirect(base_url("administrador/publicaciones"));
				}
			} else {
				//error no existe publicacion
				redirect(base_url("administrador/publicaciones"));
			}
		} else {
			//error de id
			redirect(base_url("administrador/publicaciones"));
		}
	}

}
