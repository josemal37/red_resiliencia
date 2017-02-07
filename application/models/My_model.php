<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of My_model
 *
 * @author Jose
 */
class My_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	protected function return_result($query) {
		if (!$query) {
			return FALSE;
		} else if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->result();
		}
	}

	protected function return_row($query) {
		if (!$query) {
			return FALSE;
		} else if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->row();
		}
	}

}
