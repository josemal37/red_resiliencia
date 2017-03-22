<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Evento_validacion
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class Evento_validacion extends Base {

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
		"id_ciudad" => array(
			"field" => "id_ciudad",
			"label" => "ciudad",
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
		"fecha_inicio" => array(
			"field" => "fecha_inicio",
			"label" => "fecha de inicio",
			"rules" => array(
				"required",
				"date"
			)
		),
		"fecha_fin" => array(
			"field" => "fecha_fin",
			"label" => "fecha de fin",
			"rules" => array(
				"required",
				"date"
			)
		),
		"direccion" => array(
			"field" => "direccion",
			"label" => "dirección",
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
		"url" => array(
			"field" => "url",
			"label" => "sitio web",
			"rules" => array (
				"valid_url"
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
		)
	);
	protected $jquery_validate = array(
		"id" => array(
			"required" => true,
			"number" => true
		),
		"id_pais" => array(
			"required" => true,
			"number" => true
		),
		"id_ciudad" => array(
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
		"fecha_inicio" => array(
			"required" => true,
			"date" => true
		),
		"fecha_fin" => array(
			"required" => true,
			"date" => true
		),
		"direccion" => array(
			"required" => true,
			"minlength" => 1
		),
		"imagen" => array(
			"required" => true
		),
		"url" => array(
			"url" => true
		),
		"id_categoria[]" => array(
			"required" => true,
			"number" => true
		),
		"id_institucion" => array(
			"required" => true,
			"number" => true
		)
	);
	protected $mensajes = array(
		"id" => array(
			"required" => "Hay un error con la identificación del archivo.",
			"number" => "Hay un error con la identificación del archivo."
		),
		"id_pais" => array(
			"required" => "Seleccione un pais para el evento.",
			"number" => "Hay un error con el pais seleccionado."
		),
		"id_ciudad" => array(
			"required" => "Seleccione una ciudad para el evento.",
			"number" => "Hay un error con la ciudad seleccionada."
		),
		"nombre" => array(
			"required" => "Introduzca un nombre para el evento.",
			"minlength" => "El nombre del evento debe contener al menos 1 caracter."
		),
		"descripcion" => array(
			"minlength" => "La descripción debe tener al menos 1 caracter."
		),
		"fecha_inicio" => array(
			"required" => "Introduzca una fecha de inicio para el evento (yyyy-mm-dd).",
			"date" => "Introduzca una fecha de inicio valida para el evento (yyyy-mm-dd)."
		),
		"fecha_fin" => array(
			"required" => "Introduzca una fecha de fin para el evento (yyyy-mm-dd).",
			"date" => "Introduzca una fecha de fin valida para el evento (yyyy-mm-dd)."
		),
		"direccion" => array(
			"required" => "Introduzca la dirección del evento.",
			"minlength" => "La dirección del evento debe tener al menos 1 caracter."
		),
		"imagen" => array(
			"required" => "Seleccione una imagen para el evento."
		),
		"url" => array(
			"url" => "Introduzca un sitio web válido."
		),
		"id_categoria[]" => array(
			"required" => "Hay un error en la categoria seleccionada.",
			"number" => "Hay un error en la categoria seleccionada."
		),
		"id_institucion" => array(
			"required" => "Hay un error en la categoria seleccionada.",
			"number" => "Hay un error en la categoria seleccionada."
		)
	);

}
