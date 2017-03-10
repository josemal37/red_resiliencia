<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Institucion
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class Institucion_validacion extends Base {

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
		"sigla" => array(
			"field" => "sigla",
			"label" => "sigla",
			"rules" => array(
				"required",
				"min_length[1]"
			)
		)
	);
	
	protected $jquery_validate = array(
		"id" => array(
			"required" => true,
			"number" => true
		),
		"nombre" => array(
			"required" => true,
			"minlength" => 1
		),
		"sigla" => array(
			"required" => true,
			"minlength" => 1
		)
	);
	
	protected $mensajes = array(
		"id" => array(
			"required" => "Hay un error con la identificación del archivo.",
			"number" => "Hay un error con la identificación del archivo."
		),
		"nombre" => array(
			"required" => "Introduzca el nombre de la institución.",
			"minlength" => "El nombre de la institución debe tener al menos 1 caracter."
		),
		"sigla" => array(
			"required" => "Introduzca la sigla de la institución",
			"minlength" => "La sigla de la institución debe tener al menos 1 caracter."
		)
	);

}
