<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class Usuario_validacion extends Base {

	public function __construct() {
		parent::__construct();
	}

	protected $reglas_validacion = array(
		"id" => array(
			"field" => "id",
			"label" => "id",
			"rules" => array(
				"required",
				"numeric",
				"is_natural"
			)
		),
		"nombre" => array(
			"field" => "nombre",
			"label" => "nombre",
			"rules" => array(
				"required",
				"min_length[1]"
			)
		),
		"apellido_paterno" => array(
			"field" => "apellido_paterno",
			"label" => "apellido paterno",
			"rules" => array(
				"min_length[1]"
			)
		),
		"apellido_materno" => array(
			"field" => "apellido_materno",
			"label" => "apellido materno",
			"rules" => array(
				"min_length[1]"
			)
		),
		"institucion" => array(
			"field" => "institucion",
			"label" => "institución",
			"rules" => array(
				"required",
				"numeric",
				"is_natural"
			)
		),
		"rol" => array(
			"field" => "rol",
			"label" => "rol",
			"rules" => array(
				"required",
				"numeric",
				"is_natural"
			)
		),
		"login" => array(
			"field" => "login",
			"label" => "login",
			"rules" => array(
				"required",
				"min_length[5]"
			)
		),
		"password" => array(
			"field" => "password",
			"label" => "password",
			"rules" => array(
				"required",
				"min_length[5]"
			)
		),
		"confirmacion" => array(
			"field" => "confirmacion",
			"label" => "confirmacion",
			"rules" => array(
				"required",
				"min_length[5]",
				"matches[password]"
			)
		)
	);

}
