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

		$this->load->model(array("Modelo_Publicacion"));
		$this->load->library(array("Session", "Form_Validation"));
		$this->load->helper(array("Url", "Form"));
		$this->load->database("default");
	}

	public function index() {
		$datos = array();
		$datos["titulo"] = "Red universitaria para una cultura de resiliencia";
		$datos["publicaciones"] = $this->Modelo_Publicacion->select_publicaciones();
		$this->load->view("portada/vista_portada", $datos);
	}

}
