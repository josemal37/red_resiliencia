<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Feed
 *
 * @author Jose
 */
class Feed extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_publicacion", "Modelo_articulo", "Modelo_evento", "Modelo_institucion", "Modelo_categoria", "Modelo_autor"));

		$this->load->library(array("Session"));
		$this->load->library(array("imagen"));

		$this->load->helper(array("Url", "Form", "FIle", "Xml", "Text"));
		$this->load->helper(array("Array_helper"));

		$this->load->database("default");
	}

	public function index() {
		$this->rss();
	}

	public function rss() {
		$datos = array();
		
		$datos["nombre_rss"] = "Red para una cultura de resiliencia";
		$datos["codificacion_rss"] = "utf-8";
		$datos["url_rss"] = base_url();
		$datos["descripcion_rss"] = "Red para una cultura de resiliencia";
		$datos["lenguaje_rss"] = "es-mx";
		$datos["categorias"] = array(
			"resiliencia",
			"cambio climático",
			"interculturalidad",
			"género"
		);
		
		$datos["articulos"] = $this->Modelo_articulo->select_articulos(1, 3);
		$datos["publicaciones"] = $this->Modelo_publicacion->select_publicaciones(1, 3);
		$datos["eventos"] = $this->Modelo_evento->select_eventos(1, 3);
		
		header("Content-Type: application/rss+xml; charset=utf-8");
		$this->load->view("rss/rss", $datos);
	}

}
