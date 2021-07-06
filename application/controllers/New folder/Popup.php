<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class popup extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }

	public function skpd(){				
			$this->load->view('popup/skpd');	
	}	
}