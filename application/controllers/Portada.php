<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Portada
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Portada extends CI_Controller {

	public function __construct() {

		parent::__construct();

		$this->load->model(array("Modelo_Publicacion", "Modelo_autor", "Modelo_categoria"));
		$this->load->library(array("Session", "Form_Validation"));
		$this->load->library(array("Imagen"));
		$this->load->helper(array("Url", "Form"));
		$this->load->database("default");
	}

	public function index() {
		$datos = array();
		$datos["titulo"] = "Red universitaria para una cultura de resiliencia";
		$datos["path_publicaciones"] = $this->imagen->get_path_valido("publicacion");
		$datos["publicaciones"] = $this->Modelo_Publicacion->select_publicaciones(1, 3);
		$this->load->view("portada/portada", $datos);
	}

}
