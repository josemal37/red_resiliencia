<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Autor
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class Autor_validacion extends Base {
	
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
		"id_institucion" => array(
			"field" => "id_institucion",
			"label" => "instituciones",
			"rules" => array(
				"numeric",
				"is_natural"
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
		"id_institucion[]" => array(
			"number" => true
		)
	);
	
	protected $mensajes = array(
		"id" => array(
			"required" => "Hay un error con la identificación del archivo.",
			"number" => "Hay un error con la identificación del archivo."
		),
		"nombre" => array(
			"required" => "Introduzca el nombre del autor.",
			"minlength" => "El nombre del autor debe tener al menos 1 caracter."
		),
		"apellido_paterno" => array(
			"minlength" => "El apellido paterno del autor debe tener al menos 1 caracter."
		),
		"apellido_materno" => array(
			"minlength" => "El apellido materno del autor debe tener al menos 1 caracter."
		),
		"id_institucion[]" => array(
			"number" => "Hay un error en la categoria seleccionada."
		)
	);
}
