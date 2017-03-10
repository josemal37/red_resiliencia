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
	
	protected $jquery_validate = array(
		"id" => array(
			"required" => true,
			"number" => true
		),
		"nombre" => array(
			"required" => true,
			"minlength" => 1
		),
		"apellido_paterno" => array(
			"minlength" => 1
		),
		"apellido_materno" => array(
			"minlength" => 1
		),
		"institucion" => array(
			"required" => true,
			"number" => true
		),
		"rol" => array(
			"required" => true,
			"number" => true
		),
		"login"=>array(
			"required"=>true,
			"minlength"=>5
		),
		"password"=>array(
			"required"=>true,
			"minlength"=>5
		),
		"confirmacion"=>array(
			"required"=>true,
			"minlength"=>5,
			"equalTo"=>"#password"
		)
	);
	
	protected $mensajes = array(
		"id" => array(
			"required" => "Hay un error con la identificación del archivo.",
			"number" => "Hay un error con la identificación del archivo."
		),
		"nombre" => array(
			"required" => "Introduzca el nombre del usuario.",
			"minlength" => "El nombre del usuario debe tener al menos 1 caracter."
		),
		"apellido_paterno" => array(
			"minlength" => "El apellido paterno del usuario debe tener al menos 1 caracter."
		),
		"apellido_materno" => array(
			"minlength" => "El apellido materno del usuario debe tener al menos 1 caracter."
		),
		"institucion" => array(
			"required" => "Seleccione la institución del usuario.",
			"number" => "Hay un error con la institución seleccionada."
		),
		"rol" => array(
			"required" => "Seleccione el rol del usuario.",
			"number" => "Hay un error con el rol seleccionado."
		),
		"login"=>array(
			"required"=>"Introduzca el login del usuario.",
			"minlength"=>"El login del usuario debe tener al menos 5 caracteres."
		),
		"password"=>array(
			"required"=>"Introduzca el password del usuario.",
			"minlength"=>"El password del usuario debe tener al menos 5 caracteres."
		),
		"confirmacion"=>array(
			"required"=>"Confirme el password introducido.",
			"minlength"=>"La confirmación del password debe tener al menos 5 caracteres.",
			"equalTo"=>"La confirmación no es igual al password introducido."
		)
	);

}
