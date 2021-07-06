<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class opd extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }

	public function tahapan()
	{				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='rkpd.__t_users';	
			$query="select tahapan from ".$table." where username='".$this->input->post('username')."'";
			$ArrWhere=array('username');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionDataSelect($action, $table, $query, $this->input->post() , $ArrWhere);			
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	
}