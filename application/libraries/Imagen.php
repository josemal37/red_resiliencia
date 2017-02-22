<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Subir_imagen
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_archivo.php';

class Imagen extends Base_archivo {

	public function __construct() {
		parent::__construct();
	}

	protected $config = array(
		"allowed_types" => "gif|jpg|png",
		"max_size" => "2048"
	);

}
