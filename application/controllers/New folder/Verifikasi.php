<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class verifikasi extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }

	public function verifikasi_renstra_program(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_renstra_pgrm';	
			$ArrWhere=array('KDRENPROG');
			$arrFilterAdd=array('KDRENPROG','UNITKEY','KDPRGRM','KDPRIORITAS','KDSASARAN','BENEFIT_TOLOK_UKUR','BENEFIT_TARGET','OUTCOME_TOLOK_UKUR','OUTCOME_TARGET');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	
	public function verifikasi_renstra_kegiatan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){			
			$action=$this->uri->segment(3);		
			//// VERIFIKASI PROGRAM 
			$TGLVALID=$this->input->post('TGLVALID');
			if($TGLVALID!='0000-00-00'){
				$table='dbsipd_'.$SESS_TAHUN.'.t_renstra_pgrm';	
				$ArrWhere=array('KDRENPROG');
				$arrFilterAdd=array('KDRENPROG','UNITKEY','KDPRGRM','KDPRIORITAS','KDSASARAN','BENEFIT_TOLOK_UKUR','BENEFIT_TARGET','OUTCOME_TOLOK_UKUR','OUTCOME_TARGET');
				$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
			}
			
			//// VERIFIKASI KEGIATAN
			$table='dbsipd_'.$SESS_TAHUN.'.t_renstra_keg';	
			$ArrWhere=array('KDRENSKEG');
			$arrFilterAdd=array('KDRENSKEG','KDRENPROG','UNITKEY','KDPRGRM','KDKEGUNIT','OUTPUT_TOLOK_UKUR','OUTPUT_TARGET','TARGET_5THN','DANA_5THN','KETERANGAN');
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
			/// VERIFIKASI DANA
			$table='dbsipd_'.$SESS_TAHUN.'.t_renstra_dana';	
			$arrFilterAdd=array('KDRENDANA', 'KDRENPROG', 'UNITKEY', 'KDPRGRM', 'KDKEGUNIT', 'TAHUN', 'PERSEN', 'PAGU','KUANTITAS', 'SATUAN', 'KETERANGAN');
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	
	public function verifikasi_ranwal_kegiatan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){			
			$action=$this->uri->segment(3);		
			
			//// VERIFIKASI KEGIATAN
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_keg';	
			$ArrWhere=array('KDTAHAP', 'UNITKEY', 'KDPRGRM', 'KDKEGUNIT');
			$arrFilterAdd=array('KDRANCKEG', 'KDTAHAP', 'UNITKEY', 'KDPRGRM', 'KDKEGUNIT', 'KDSIFAT', 'KEGIATAN_PRIORITAS', 'SASARAN_KEGIATAN', 'LOKASI', 'TARGET', 'SATUAN', 'PAGU', 'PAGUN1', 'FOTO', 'LAT', 'LONGI');
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
			/// VERIFIKASI DANA
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_dana';	
			$arrFilterAdd=array('KDTAHAP', 'UNITKEY', 'KDPRGRM', 'KDKEGUNIT', 'KDDANA', 'NILAIN', 'NILAIN1', 'KETERANGAN');
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
			/// VERIFIKASI KINKEG
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_kinkeg';	
			$arrFilterAdd=array('KDTAHAP', 'UNITKEY', 'KDPRGRM', 'KDKEGUNIT', 'KDKINERJA', 'TOLAK_UKUR', 'TARGET_KINERJA_N', 'TARGET_KINERJA_N1');
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}



	public function verifikasi_ranc_renja_bl(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_cpcl';	
			$ArrWhere=array('KDCPCL');
			$arrFilterAdd=array('KDCPCL', 'JENIS_CPCL', 'KDTAHAP','UNITKEY_KEC', 'UNITKEY', 'KDPRGRM', 'KDKEGUNIT', 'KDDEWAN', 'KDSIFAT', 'KDPRIORITAS', 'KDSASARAN', 'KEGIATAN_PRIORITAS', 'SASARAN_KEGIATAN', 'IDKEC', 'IDDESA', 'LOKASI', 'TARGET', 'SATUAN', 'DESKRIPSI', 'PAGU', 'FOTO', 'PENANGGUNG_JAWAB', 'LAT', 'LONGI');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	
	public function verifikasi_ranc_renja_btl(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_btl_cpcl';	
			$ArrWhere=array('KDCPCL');
			$arrFilterAdd=array('KDCPCL', 'JENIS_CPCL', 'KDTAHAP', 'UNITKEY_KEC', 'UNITKEY', 'KDPRGRM', 'MTGKEY', 'KDDEWAN', 'KDSIFAT', 'KDPRIORITAS', 'KDSASARAN', 'KEGIATAN_PRIORITAS', 'SASARAN_KEGIATAN', 'IDKEC', 'IDDESA', 'LOKASI', 'TARGET', 'SATUAN', 'DESKRIPSI', 'PAGU', 'FOTO', 'PENANGGUNG_JAWAB', 'LAT', 'LONGI');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
}