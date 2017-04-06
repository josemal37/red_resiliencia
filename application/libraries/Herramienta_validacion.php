<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Herramienta_validacion
 *
 * @author Jose
 */
require_once 'Base.php';

class Herramienta_validacion extends Base {

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
			"rules" => array(
				"valid_url"
			)
		),
		"video" => array(
			"field" => "video",
			"label" => "video",
			"rules" => array(
				"valid_url",
				"youtube_url"
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
		"nombre" => array(
			"required" => true,
			"minlength" => 1
		),
		"descripcion" => array(
			"minlength" => 1
		),
		"imagen" => array(
			
		),
		"url" => array(
			"url" => true
		),
		"video" => array(
			"youtubeUrl" => true
		),
		"id_autor[]" => array(
			"required" => true,
			"number" => true
		),
		"id_categoria[]" => array(
			"required" => true,
			"number" => true
		),
		"id_institucion[]" => array(
			"required" => true,
			"number" => true
		)
	);
	protected $mensajes = array(
		"id" => array(
			"required" => "Hay un error con la identificación del archivo.",
			"number" => "Hay un error con la identificación del archivo."
		),
		"nombre" => array(
			"required" => "Introduzca un nombre para la herramienta.",
			"minlength" => "El nombre de la herramienta debe contener al menos 1 caracter."
		),
		"descripcion" => array(
			"minlength" => "La descripción debe tener al menos 1 caracter."
		),
		"imagen" => array(
			"required" => "Seleccione una imagen para la herramienta."
		),
		"url" => array(
			"url" => "Introduzca un sitio web válido."
		),
		"video" => array(
			"url" => "Introduzca un sitio web válido.",
			"youtubeUrl" => "Debe ser un video de YouTube."
		),
		"id_autor[]" => array(
			"required" => "Hay un error en el autor seleccionado.",
			"number" => "Hay un error en el autor seleccionado."
		),
		"id_categoria[]" => array(
			"required" => "Hay un error en la categoria seleccionada.",
			"number" => "Hay un error en la categoria seleccionada."
		),
		"id_institucion[]" => array(
			"required" => "Hay un error en la categoria seleccionada.",
			"number" => "Hay un error en la categoria seleccionada."
		)
	);

}
