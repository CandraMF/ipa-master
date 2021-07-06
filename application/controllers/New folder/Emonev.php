<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class emonev extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }

	public function kuisioner(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.e_t_kuisioner';	
			$ArrWhere=array('IDKUISIONER','UNITKEY','KDTAHAP','KDKEGUNIT','KDPRGRM');
			$arrFilterAdd=array('KDISIAN');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	public function kuisioner_alasan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.e_t_kuisioner';	
			$ArrWhere=array('IDKUISIONER','UNITKEY','KDTAHAP','KDKEGUNIT','KDPRGRM');
			$arrFilterAdd=array('KDISIAN','KDOPTION');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function emon_kegiatan_upload_foto(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_keg';	
								
			
			if(is_array($_FILES)) {
				if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
					$sourcePath = $_FILES['userImage']['tmp_name'];		
					$id=$this->uri->segment(3);		
					$fileType = $_FILES['userImage']['type'];
					$fileTypeArray = ["image/jpeg"];
					if (in_array($fileType, $fileTypeArray)){ 
						$targetPath = 'assets/img-emon/emon_'.$id.'.jpeg';
						if(move_uploaded_file($sourcePath,$targetPath)) {
							$dt_qry="UPDATE dbsipd_".$SESS_TAHUN.".`t_kegiatan_keg` SET `FOTO`='".$targetPath."' WHERE  KDRANCKEG='".$id."'";
							$this->db->query($dt_qry);
							$this->m_action->logData($dt_qry, "UPDATE", "dbsipd_".$SESS_TAHUN.".`t_kegiatan_keg`", "KDRANCKEG", $id);
							echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';	
						}
					}else{
						$targetPath = 'assets/img-emon/photo.png';
						echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
					}
				}else{
					$targetPath = 'assets/img-emon/photo.png';
					echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
				}
			}else{
				$targetPath = 'assets/img-emon/photo.png';
				echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
			}

		}else{
			$targetPath = 'assets/img-emon/photo.png';
			echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
		}

		//$this->load->view('json', array("response" => $std->status));	
	}

	public function ranckegiatan_kegiatan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_keg';	
			$ArrWhere=array('KDRANCKEG');
			$arrFilterAdd=array('KDTAHAP', 'UNITKEY', 'KDPRGRM', 'KDKEGUNIT', 'TGLVALID', 'KDSIFAT', 'KEGIATAN_PRIORITAS', 'SASARAN_KEGIATAN', 'LOKASI', 'TARGET', 'SATUAN', 'PAGU', 'PAGUN1', 'FOTO');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function ranckegiatan_kinkeg_monitoring(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_kinkeg';	
			$ArrWhere=array('KDTAHAP','UNITKEY','KDPRGRM','KDKEGUNIT','KDKINERJA');
			$arrFilterAdd=array('TGLVALID','TOLAK_UKUR','TARGET_KINERJA_N','TARGET_KINERJA_N1','PERSENTASE','KDOPTION');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function ranckegiatan_kinkeg_persentase(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_kinkeg';	
			$ArrWhere=array('KDTAHAP','UNITKEY','KDPRGRM','KDKEGUNIT','KDKINERJA');
			$arrFilterAdd=array('TGLVALID','TOLAK_UKUR','TARGET_KINERJA_N','TARGET_KINERJA_N1','HASIL_MONITORING','KDOPTION');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function program_monitoring(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_emonv_prog';	
			$ArrWhere=array('UNITKEY','KDPRGRM','KDTAHAP');
			$arrFilterAdd=array('KDOPTION','PERSENTASE');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function program_persentase(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_emonv_prog';	
			$ArrWhere=array('UNITKEY','KDPRGRM','KDTAHAP');
			$arrFilterAdd=array('KDOPTION','HASIL_MONITORING');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function emonev_e80(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.emon_80';	
			$ArrWhere=array('KDPRGRM','KDKEGUNIT','UNITKEY','KDTAHAP');
			$arrFilterAdd=array('');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);

			$this->db->query("UPDATE dbsipd_".$SESS_TAHUN.".`emon_81` SET `NMSASARAN`='".$this->input->post('NMSASARAN')."', `INDIKATOR_KINERJA`='".$this->input->post('INDIKATOR_KINERJA')."' WHERE  `KDPRGRM`='".$this->input->post('KDPRGRM')."' AND `KDKEGUNIT`='".$this->input->post('KDKEGUNIT')."' AND `UNITKEY`='".$this->input->post('UNITKEY')."' AND `KDTAHAP`='".$this->input->post('KDTAHAP')."';");
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function emonev_e81(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.emon_81';	
			$ArrWhere=array('KDPRGRM','KDKEGUNIT','UNITKEY','KDTAHAP');
			$arrFilterAdd=array('');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);

			
			$this->db->query("UPDATE dbsipd_".$SESS_TAHUN.".`emon_80` SET `NMSASARAN`='".$this->input->post('NMSASARAN')."', `INDIKATOR_KINERJA`='".$this->input->post('INDIKATOR_KINERJA')."' WHERE  `KDPRGRM`='".$this->input->post('KDPRGRM')."' AND `KDKEGUNIT`='".$this->input->post('KDKEGUNIT')."' AND `UNITKEY`='".$this->input->post('UNITKEY')."' AND `KDTAHAP`='".$this->input->post('KDTAHAP')."';");

		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

}