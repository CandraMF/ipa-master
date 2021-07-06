<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jenis extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }


	public function jenis_struktur_unit(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.mstruktur_unit';	
			$ArrWhere=array('KDSTUNIT');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function jenis_struktur_rekening(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.mstruktur_rekening';	
			$ArrWhere=array('KDSTREK');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	
	public function jenis_perpektif(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.mjenis_perpektif';	
			$ArrWhere=array('KDPERPEKTIF');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
		
	public function jenis_dana(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.mdana';	
			$ArrWhere=array('KDDANA');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	
	public function jenis_kinerja_kegiatan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.mkinerja_kegiatan';	
			$ArrWhere=array('KDKINERJA');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	
	public function jenis_sifat_kegiatan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.msifat_kegiatan';	
			$ArrWhere=array('KDSIFAT');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	
	public function jenis_standar(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.mjenis_standar';	
			$ArrWhere=array('KDJENIS_STANDAR');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	
}