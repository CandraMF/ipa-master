<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class skpd extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }
	
	public function andri(){
		$std = new stdClass();
		$std->status='success';
		$this->load->view('json', array("response" => $std->status));	
	}
	public function skpd_renstra_program(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_renstra_pgrm';	
			$ArrWhere=array('KDRENPROG');
			$arrFilterAdd=array('TGLVALID');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	
	public function skpd_renstra_kegiatan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_renstra_keg';	
			$ArrWhere=array('KDRENSKEG');
			$arrFilterAdd=array('TGLVALID');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function skpd_renstra_dana(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_renstra_dana';	
			$ArrWhere=array('KDRENDANA');
			$arrFilterAdd=array('TGLVALID');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);

			///////// update
			$data=$this->input->post();
			if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
			$wh=" and UNITKEY='{$UNITKEY}' and KDPRGRM='{$KDPRGRM}' and KDKEGUNIT='{$KDKEGUNIT}'";
			$row=$this->m_action->ambilData("select KDRENSKEG, KDRENPROG from dbsipd_".$SESS_TAHUN.".t_renstra_keg where KDRENSKEG!='' ".$wh);
			$this->db->query("update ".$table." set KDRENSKEG='".$row->KDRENSKEG."', KDRENPROG='".$row->KDRENPROG."' where KDRENSKEG=0  and TAHUN='{$TAHUN}'");

		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	/////////////////// RANCANGAN KEGIATAN CONTROLER

	
	public function ranckegiatan_kegiatan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_keg';	
			$ArrWhere=array('KDRANCKEG');
			$arrFilterAdd=array('TGLVALID','HASIL_MONITORING');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	
	public function ranckegiatan_kinkeg(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_kinkeg';	
			$ArrWhere=array('KDTAHAP','UNITKEY','KDPRGRM','KDKEGUNIT','KDKINERJA');
			$arrFilterAdd=array('TGLVALID','HASIL_MONITORING','PERSENTASE');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
			
			

		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function ranckegiatan_dana(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_dana';	
			$ArrWhere=array('KDTAHAP','UNITKEY','KDPRGRM','KDKEGUNIT','KDDANA');
			$arrFilterAdd=array('TGLVALID');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere,$arrFilterAdd);
			

		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	////////////// CPCL
	public function skpd_musren_kecamatan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_cpcl';	
			$ArrWhere=array('KDCPCL');
			$arrFilterAdd=array('FOTO','TGLVALID');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function skpd_musren_kecamatan_upload_foto(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_cpcl';	
								
			
			if(is_array($_FILES)) {
				if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
					$sourcePath = $_FILES['userImage']['tmp_name'];		
					$id=$this->uri->segment(3);		
					$fileType = $_FILES['userImage']['type'];
					$fileTypeArray = ["image/jpeg"];
					if (in_array($fileType, $fileTypeArray)){ 
						$targetPath = 'assets/img-cpcl/musren_'.$id.'.jpeg';
						if(move_uploaded_file($sourcePath,$targetPath)) {
							$dt_qry="UPDATE dbsipd_".$SESS_TAHUN.".`t_kegiatan_cpcl` SET `FOTO`='".$targetPath."' WHERE  KDCPCL='".$id."'";
							$this->db->query($dt_qry);
							$this->m_action->logData($dt_qry, "UPDATE", "dbsipd_".$SESS_TAHUN.".`t_kegiatan_cpcl`", "KDCPCL", $id);
							echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';	
						}
					}else{
						$targetPath = 'assets/img-cpcl/photo.png';
						echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
					}
				}else{
					$targetPath = 'assets/img-cpcl/photo.png';
					echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
				}
			}else{
				$targetPath = 'assets/img-cpcl/photo.png';
				echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
			}

		}else{
			$targetPath = 'assets/img-cpcl/photo.png';
			echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
		}

		//$this->load->view('json', array("response" => $std->status));	
	}


	public function skpd_musren_dewan_bl(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_cpcl';	
			$ArrWhere=array('KDCPCL');
			$arrFilterAdd=array('FOTO','TGLVALID');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function skpd_musren_dewan_bl_upload_foto(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_kegiatan_cpcl';	
								
			
			if(is_array($_FILES)) {
				if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
					$sourcePath = $_FILES['userImage']['tmp_name'];		
					$id=$this->uri->segment(3);		
					$fileType = $_FILES['userImage']['type'];
					$fileTypeArray = ["image/jpeg"];
					if (in_array($fileType, $fileTypeArray)){ 
						$targetPath = 'assets/img-cpcl/dewan_bl_'.$id.'.jpeg';
						if(move_uploaded_file($sourcePath,$targetPath)) {
							$dt_qry="UPDATE dbsipd_".$SESS_TAHUN.".`t_kegiatan_cpcl` SET `FOTO`='".$targetPath."' WHERE  KDCPCL='".$id."'";
							$this->db->query($dt_qry);
							$this->m_action->logData($dt_qry, "UPDATE", "dbsipd_".$SESS_TAHUN.".`t_kegiatan_cpcl`", "KDCPCL", $id);
							echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';	
						}
					}else{
						$targetPath = 'assets/img-cpcl/photo.png';
						echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
					}
				}else{
					$targetPath = 'assets/img-cpcl/photo.png';
					echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
				}
			}else{
				$targetPath = 'assets/img-cpcl/photo.png';
				echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
			}

		}else{
			$targetPath = 'assets/img-cpcl/photo.png';
			echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
		}

		//$this->load->view('json', array("response" => $std->status));	
	}

	public function skpd_musren_dewan_btl(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_btl_cpcl';	
			$ArrWhere=array('KDCPCL');
			$arrFilterAdd=array('FOTO','TGLVALID');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function skpd_musren_dewan_btl_upload_foto(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.t_btl_cpcl';	
								
			
			if(is_array($_FILES)) {
				if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
					$sourcePath = $_FILES['userImage']['tmp_name'];		
					$id=$this->uri->segment(3);		
					$fileType = $_FILES['userImage']['type'];
					$fileTypeArray = ["image/jpeg"];
					if (in_array($fileType, $fileTypeArray)){ 
						$targetPath = 'assets/img-cpcl/dewan_btl_'.$id.'.jpeg';
						if(move_uploaded_file($sourcePath,$targetPath)) {
							$dt_qry="UPDATE dbsipd_".$SESS_TAHUN.".t_btl_cpcl SET `FOTO`='".$targetPath."' WHERE  KDCPCL='".$id."'";
							$this->db->query($dt_qry);
							$this->m_action->logData($dt_qry, "UPDATE", "dbsipd_".$SESS_TAHUN.".t_btl_cpcl", "KDCPCL", $id);
							echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';	
						}
					}else{
						$targetPath = 'assets/img-cpcl/photo.png';
						echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
					}
				}else{
					$targetPath = 'assets/img-cpcl/photo.png';
					echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
				}
			}else{
				$targetPath = 'assets/img-cpcl/photo.png';
				echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
			}

		}else{
			$targetPath = 'assets/img-cpcl/photo.png';
			echo '<img src="'.base_url($targetPath).'" width="200px" height="200px" class="upload-preview" />';
		}

		//$this->load->view('json', array("response" => $std->status));	
	}
}