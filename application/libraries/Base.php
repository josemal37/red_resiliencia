<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base
 *
 * @author Jose
 */
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Base {
	
	protected $ci;
	protected $reglas_validacion;
	
	public function __construct() {
		$this->ci = & get_instance();
	}

	public function validar($campos = NULL) {
		if ($campos != NULL) {
			$this->establecer_reglas($campos);
			if ($this->ci->form_validation->run() == FALSE) {
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}

	private function establecer_reglas($campos) {
		//campos para validar
		$para_validar = $this->get_reglas($campos);

		$this->ci->form_validation->set_rules($para_validar);
	}
	
	public function get_reglas($campos) {
		$reglas = array();
		
		if (is_array($campos)) {
			foreach ($campos as $campo) {
				if (isset($this->reglas_validacion[$campo])) {
					$reglas[] = $this->reglas_validacion[$campo];
				}
			}
		} else if (is_string($campos)) {
			if (isset($this->reglas_validacion[$campos])) {
				$reglas[] = $this->reglas_validacion[$campos];
			}
		}
		
		return $reglas;
	}
	
	public function get_reglas_cliente($campos) {
		return $this->get_reglas_jquery_validate($campos);
	}
	
	private function get_reglas_jquery_validate($campos) {
		$reglas = "";
		
		if (is_array($campos)) {
			$seleccion = array();
			foreach ($campos as $campo) {
				if (isset($this->jquery_validate[$campo])) {
					$seleccion[$campo] = $this->jquery_validate[$campo];
				}
			}
			
			$seleccion_mensajes = array();
			foreach ($campos as $campo) {
				if (isset($this->mensajes[$campo])) {
					$seleccion_mensajes[$campo] = $this->mensajes[$campo];
				}
			}
			
			$reglas = json_encode(array("rules" => $seleccion, "messages" => $seleccion_mensajes));
		} else if (is_string($campos)) {
			if (isset($this->jquery_validate[$campos])) {
				$reglas = json_encode(array($campos => $this->jquery_validate[$campos]));
			}
		}
		
		return $reglas;
	}
	
}
