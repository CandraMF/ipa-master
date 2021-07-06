<?php
class setting_query_console extends CI_Controller{
    function __construct(){
        parent::__construct();
		
    }

    function index(){
		$data="";
		$login = $this->session->userdata('SESS_LOGIN');
		if ($login){
			$this->load->view('pages/setting_query_console',$data);
		}else{
			echo "<script>parent.location='".base_url()."';</script>";
		}
	}
		
}
