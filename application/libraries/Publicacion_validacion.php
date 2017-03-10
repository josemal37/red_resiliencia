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

class Publicacion_validacion extends Base {

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
		"descripcion" => array(
			"field" => "descripcion",
			"label" => "descripción",
			"rules" => array(
				"min_length[1]"
			)
		),
		"id_categoria" => array(
			"field" => "id_categoria",
			"label" => "categorias",
			"rules" => array(
				"numeric",
				"is_natural"
			)
		),
		"id_institucion" => array(
			"field" => "id_institucion",
			"label" => "instituciones",
			"rules" => array(
				"numeric",
				"is_natural"
			)
		),
		"id_autor" => array(
			"field" => "id_autor",
			"label" => "autores",
			"rules" => array(
				"numeric",
				"is_natural"
			)
		),
		"modulos" => array(
			"field" => "modulos",
			"label" => "modulos",
			"rules" => array(
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
		"descripcion" => array(
			"minlength" => 1
		),
		"imagen" => array(
			"required" => true
		),
		"id_categoria[]" => array(
			"number" => true
		),
		"id_institucion[]" => array(
			"number" => true
		),
		"id_autor[]" => array(
			"number" => true
		),
		"modulos[]" => array(
			"minlength" => 1
		)
	);
	protected $mensajes = array(
		"id" => array(
			"required" => "Hay un error con la identificación del archivo.",
			"number" => "Hay un error con la identificación del archivo."
		),
		"nombre" => array(
			"required" => "Introduzca el nombre de la publicación.",
			"minlength" => "El nombre de la publicación debe tener al menos 1 caracter."
		),
		"descripcion" => array(
			"minlength" => "La descripción de la publicación debe tener al menos 1 caracter."
		),
		"imagen" => array(
			"required" => "Seleccione una imagen para la publicación."
		),
		"id_categoria[]" => array(
			"number" => "El formato de las categorias no es correcto."
		),
		"id_institucion[]" => array(
			"number" => "El formato de las instituciones no es correcto."
		),
		"id_autor[]" => array(
			"number" => "El formato de los autores no es correcto."
		),
		"modulos[]" => array(
			"minlength" => "El modulo debe tener al menos 1 caracter."
		)
	);

}
