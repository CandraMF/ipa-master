<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pengaturan extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }

	public function setting_tahapan(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.__t_users';	
			$ArrWhere=array('username');
			$arrFilterAdd=array('username','nama_lengkap','idopd','id_bidang','tahun','password','idgroupakses','blokir','id_session');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	public function setting_register(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.__register_on_off';	
			$ArrWhere=array('kdregreg');
			$arrFilterAdd=array('kdregreg');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
	public function setting_kelompok_pengguna(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.__t_group_akses';	
			$ArrWhere=array('idgroupakses');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function setting_hak_akses_kelompok(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$data=$this->input->post();
			if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
			$Aksi=$this->uri->segment(3);					
			$valdata=explode("|",$valdata);
			$id_main=$valdata[0];
			$id_sub=$valdata[1];
			$idviewdata=!empty($valdata[2])?$valdata[2]:0;
			$std->idviewdata=$idviewdata;
			
			switch($Aksi){
				case "viewdata":
					$query=$this->db->query("select * from dbsipd_".$SESS_TAHUN.".__t_hak_akses where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."'");
					if($query->num_rows()>0){
					
						$this->db->query("delete from dbsipd_".$SESS_TAHUN.".__t_hak_akses where idgroupakses='".@$idgroupakses."'  and id_sub='".$id_sub."'");	
						$std->status='success';
					}else{
						$this->db->query("INSERT INTO `dbsipd_".$SESS_TAHUN."`.`__t_hak_akses` (`idgroupakses`, `id_main`, `id_sub`, `pinsert`, `pupdate`, `pdelete`) VALUES ('".@$idgroupakses."', '".@$id_main."', '".$id_sub."', 'N', 'N', 'N');");	
						$std->status='success';
					}
				break;
				case "insertdata":
					$query=$this->db->query("select * from dbsipd_".$SESS_TAHUN.".__t_hak_akses where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."'");
					if($query->num_rows()>0){
						////////// cek data value
						$QCek=$this->db->query("select * from dbsipd_".$SESS_TAHUN.".__t_hak_akses where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."' and `pinsert`='N'");						
						$dataCek=$QCek->num_rows()>0?"Y":"N";
						////////// update data 
						$this->db->query("update dbsipd_".$SESS_TAHUN.".__t_hak_akses set `pinsert`='".$dataCek."' where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."'");	
						$std->status='success';
					}else{
						$this->db->query("INSERT INTO `dbsipd_".$SESS_TAHUN."`.`__t_hak_akses` (`idgroupakses`, `id_main`, `id_sub`, `pinsert`, `pupdate`, `pdelete`) VALUES ('".@$idgroupakses."', '".@$id_main."', '".$id_sub."', 'Y', 'N', 'N');");	
						$std->status='success';
					}
				break;
				case "updatedata":
					$query=$this->db->query("select * from dbsipd_".$SESS_TAHUN.".__t_hak_akses where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."'");
					if($query->num_rows()>0){
						////////// cek data value
						$QCek=$this->db->query("select * from dbsipd_".$SESS_TAHUN.".__t_hak_akses where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."' and `pupdate`='N'");						
						$dataCek=$QCek->num_rows()>0?"Y":"N";
						////////// update data 
						$this->db->query("update dbsipd_".$SESS_TAHUN.".__t_hak_akses set `pupdate`='".$dataCek."' where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."'");	
						$std->status='success';
					}else{
						$this->db->query("INSERT INTO `dbsipd_".$SESS_TAHUN."`.`__t_hak_akses` (`idgroupakses`, `id_main`, `id_sub`, `pinsert`, `pupdate`, `pdelete`) VALUES ('".@$idgroupakses."', '".@$id_main."', '".$id_sub."', 'N', 'Y', 'N');");	
						$std->status='success';
					}
				break;
				case "deletedata":
					$query=$this->db->query("select * from dbsipd_".$SESS_TAHUN.".__t_hak_akses where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."'");
					if($query->num_rows()>0){
						////////// cek data value
						$QCek=$this->db->query("select * from dbsipd_".$SESS_TAHUN.".__t_hak_akses where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."' and `pdelete`='N'");						
						$dataCek=$QCek->num_rows()>0?"Y":"N";
						////////// update data 
						$this->db->query("update dbsipd_".$SESS_TAHUN.".__t_hak_akses set `pdelete`='".$dataCek."' where idgroupakses='".@$idgroupakses."' and id_main='".@$id_main."' and id_sub='".$id_sub."'");	
						$std->status='success';
					}else{
						$this->db->query("INSERT INTO `dbsipd_".$SESS_TAHUN."`.`__t_hak_akses` (`idgroupakses`, `id_main`, `id_sub`, `pinsert`, `pupdate`, `pdelete`) VALUES ('".@$idgroupakses."', '".@$id_main."', '".$id_sub."', 'N', 'N', 'Y');");	
						$std->status='success';
					}
				break;
			}			


		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));
	}

	public function setting_pengguna(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.__t_users';	
			$ArrWhere=array('username');
			
			$katasandi=$this->input->post('password');
			$pwd=empty($katasandi)?"password":"";
			$arrFilterAdd=array('id_session',$pwd);
			
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}

	public function setting_ganti_password(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.__t_users';	
			$ArrWhere=array('username');
			
			$data=$this->input->post();
			if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
			
		
			$query=$this->db->query("select * from ".$table." where `username`='".trim($username)."' and `password`=md5('".$pwd_lama."')");
			if($query->num_rows()>0){
				$this->db->query("update ".$table." set `password`=md5('".trim($pwd_baru)."') where `username`='".trim($username)."' and `password`=md5('".$pwd_lama."')");
				$std->status='Password Berhasil Diubah';		
			}else{
				$std->status='Maaf, Password lama tidak ditemukan...!!!';
			}
			
		}else{
			$std->status='Login, failed...!!!';
		}
		$this->load->view('json', array("response" => $std));	
	}

	public function setting_register_api(){				
		$std = new stdClass();
		$login = $this->session->userdata('SESS_LOGIN');
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		if ($login){
			$table='dbsipd_'.$SESS_TAHUN.'.api_qry';	
			$ArrWhere=array('IDQRY');
			$action=$this->uri->segment(3);					
			$std->status=$this->m_action->actionData($action, $table, $this->input->post(),$ArrWhere);
		}else{
			$std->status='failed';
		}
		$this->load->view('json', array("response" => $std->status));	
	}
}