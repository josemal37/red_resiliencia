<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	protected $CI;

	function __construct() {
		parent::__construct();
		$this->CI = & get_instance();
	}

	function youtube_url($url) {
		$this->CI->form_validation->set_message('youtube_url', 'La url no es válida.');
		return youtube_url($url);
	}

}