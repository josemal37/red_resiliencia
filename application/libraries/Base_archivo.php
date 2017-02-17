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
		}

		//verificamos si existe el directorio
		if ($path != FALSE && (!file_exists($path) || !is_dir($path))) {
			//si no existe creamos el directorio
			if (!$this->crear_dorectorio($path)) {
				$path = FALSE;
			}
		}

		return $path;
	}

	public function crear_dorectorio($path) {
		$creado = FALSE;

		if (!file_exists($path)) {
			$creado = mkdir($path, 0777);
		} else if (!is_dir($path)) {
			$creado = mkdir($path, 0777);
		}

		return $creado;
	}

}
