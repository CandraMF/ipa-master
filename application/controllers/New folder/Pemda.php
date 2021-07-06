<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pemda extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }

	public function pemda_rpjmd_program(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_rpjmd_pgrm';	
			$ArrWhere=array('KDPRGRM');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function pemda_rpjmd_kegiatan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_rpjmd_keg';	
			$ArrWhere=array('KDKEGUNIT');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	
	public function pemda_pagu_skpd(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_pagu_skpd';	
			$ArrWhere=array('KDPAGU','KDTAHAP');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function pemda_pagu_skpd_perubahan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_pagu_skpd';	
			$ArrWhere=array('KDPAGU');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
}