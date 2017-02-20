<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class Login_validacion extends Base {

	public function __construct() {
		parent::__construct();
	}

	protected $reglas_validacion = array(
		"login" => array(
			"field" => "login",
			"label" => "login",
			"rules" => array(
				"required"
			)
		),
		"password" => array(
			"field" => "password",
			"label" => "password",
			"rules" => array(
				"required"
			)
		)
	);

}
