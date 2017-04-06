<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base_subir_archivo
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

abstract class Base_archivo {

	const PATH_PUBLICACIONES = "publicaciones/";
	const PATH_EVENTOS = "eventos/";
	const PATH_ARTICULO = "articulos/";
	const PATH_HERRAMIENTA = "herramientas/";

	protected $ci;
	protected $config = array();

	public function __construct() {
		$this->ci = & get_instance();
	}

	public function subir_archivo($archivo, $path_valido) {
		$res = array();
		$res["datos"] = FALSE;
		$res["error"] = FALSE;

		//verificamos que el archivo existe
		if (isset($_FILES[$archivo]) && $_FILES[$archivo]["size"] != 0) {
			//cofiguramos la libreria de archivos
			$configuraciones = $this->config;
			
			$configuraciones["upload_path"] = $path_valido;

			$nombre_limpio = $this->sanitizar_cadena($_FILES[$archivo]["name"]);
			$configuraciones["file_name"] = $nombre_limpio;
			
			$this->ci->upload->initialize($configuraciones);

			if (!$this->ci->upload->do_upload($archivo)) {
				$res["datos"] = $this->ci->upload->display_errors();
				$res["error"] = TRUE;
			} else {
				$res["datos"] = $this->ci->upload->data();
				$res["error"] = FALSE;
			}
		}

		return $res;
	}

	public function eliminar_archivo($archivo = FALSE) {
		if ($archivo) {
			$eliminado = FALSE;

			if (file_exists($archivo)) {
				$eliminado = unlink($archivo);
			}

			return $eliminado;
		} else {
			return FALSE;
		}
	}

	public function get_path_valido($nombre) {
		$path = FALSE;

		//seleccionamos el path segun el tipo de archivo
		switch ($nombre) {
			case "publicacion":
				$path = self::PATH_PUBLICACIONES;
				break;
			case "evento":
				$path = self::PATH_EVENTOS;
				break;
			case "articulo":
				$path = self::PATH_ARTICULO;
				break;
			case "herramienta":
				$path = self::PATH_HERRAMIENTA;
				break;
		}

		//verificamos si existe el directorio
		if ($path != FALSE && (!file_exists($path) || !is_dir($path))) {
			//si no existe creamos el directorio
			if (!$this->crear_directorio($path)) {
				$path = FALSE;
			}
		}

		return $path;
	}

	public function crear_directorio($path) {
		$creado = FALSE;

		if (!file_exists($path)) {
			$creado = mkdir($path, 0777);
		} else if (!is_dir($path)) {
			$creado = mkdir($path, 0777);
		}

		return $creado;
	}

	public function sanitizar_cadena($cadena) {
		$cadena = str_replace(array('á', 'à', 'â', 'ã', 'ª', 'ä'), "a", $cadena);
		$cadena = str_replace(array('Á', 'À', 'Â', 'Ã', 'Ä'), "A", $cadena);
		$cadena = str_replace(array('Í', 'Ì', 'Î', 'Ï'), "I", $cadena);
		$cadena = str_replace(array('í', 'ì', 'î', 'ï'), "i", $cadena);
		$cadena = str_replace(array('é', 'è', 'ê', 'ë'), "e", $cadena);
		$cadena = str_replace(array('É', 'È', 'Ê', 'Ë'), "E", $cadena);
		$cadena = str_replace(array('ó', 'ò', 'ô', 'õ', 'ö', 'º'), "o", $cadena);
		$cadena = str_replace(array('Ó', 'Ò', 'Ô', 'Õ', 'Ö'), "O", $cadena);
		$cadena = str_replace(array('ú', 'ù', 'û', 'ü'), "u", $cadena);
		$cadena = str_replace(array('Ú', 'Ù', 'Û', 'Ü'), "U", $cadena);
		$cadena = str_replace(array('[', '^', '´', '`', '¨', '~', ']', ',', '+', '=', '&'), "", $cadena);
		$cadena = str_replace("ç", "c", $cadena);
		$cadena = str_replace("Ç", "C", $cadena);
		$cadena = str_replace("ñ", "n", $cadena);
		$cadena = str_replace("Ñ", "N", $cadena);
		$cadena = str_replace("Ý", "Y", $cadena);
		$cadena = str_replace("ý", "y", $cadena);
		return $cadena;
	}

}
