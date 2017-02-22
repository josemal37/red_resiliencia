<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario_administrador
 *
 * @author Jose
 */
class Usuario_administrador extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array("Session"));
		$this->load->helper(array("Url", "Form"));
	}

	public function index() {
		$this->bienvenida();
	}

	public function bienvenida() {
		$datos = array();
		$datos["titulo"] = "Bienvenido usuario";

		$this->load->view("administrador/bienvenida", $datos);
	}

}
