<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class register extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }

	public function index()
	{
		$_tahun=date('Y');
		$dataPages['_tahun']=$_tahun;
		$dataPages['_title']='Register';
		$row = new stdClass();	
		
		$dataPages['Pr']='setting_pengguna';
		$dataPages['sUserId']='admin';
		$this->load->view('pages/mod_setting_pengguna/register',$dataPages);
	}

	public function setting_pengguna(){				
		$std = new stdClass();
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$tahun=$this->input->post('tahun');
		$nama_lengkap=$this->input->post('nama_lengkap');
		if (!empty($username)&& !empty($password)&& !empty($nama_lengkap)){
			$table='dbsipd_'.$tahun.'.__t_users';	
			$ArrWhere=array('username');
			
			$katasandi=$this->input->post('password');
			$pwd=empty($katasandi)?"password":"";
			$arrFilterAdd=array('id_session',$pwd);
			
			$action=$this->uri->segment(3);			
			$qry=$this->db->query("select * from ".$table." where username='".$this->input->post('username')."'");
			if($qry->num_rows()>0){
				$std->status="Username, sudah di gunakan";
			}else{
				$this->m_action->actionDataRegister($action, $table, $this->input->post(),$ArrWhere, $arrFilterAdd);
				$std->status="Data Berhasil disimpan";
				
			}
		}else{
			$std->status='Username / password / nama_lengkap tidak boleh kosong';
		}	
		$this->load->view('json_reg', array("response" => $std->status));
		
		
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}