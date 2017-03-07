<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Articulo_validacion
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class Articulo_validacion extends Base {

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
		"contenido" => array(
			"field" => "contenido",
			"label" => "contenido",
			"rules" => array(
				"required",
				"min_length[1]"
			)
		),
		"imagen" => array(
			"field" => "imagen",
			"label" => "imagen",
			"rules" => array(
				"required"
			)
		),
		"fecha" => array(
			"field" => "fecha",
			"label" => "fecha",
			"rules" => array(
				"date"
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
		)
	);

}
