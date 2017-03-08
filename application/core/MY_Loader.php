<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Loader
 *
 * @author Jose
 */
class MY_Loader extends CI_Loader {

	function ext_view($folder, $view, $vars = array(), $return = FALSE) {
		$this->_ci_view_paths = array_merge($this->_ci_view_paths, array(FCPATH . $folder . '/' => TRUE));
		return $this->_ci_load(array(
					'_ci_view' => $view,
					'_ci_vars' => $this->_ci_object_to_array($vars),
					'_ci_return' => $return
		));
	}

}
