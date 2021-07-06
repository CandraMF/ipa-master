<?php
class api_sirenda extends CI_Controller{
    function __construct(){
        parent::__construct();
		$this->load->model('m_action','m_action');	
    }
	
	function data(){
		header('Access-Control-Allow-Origin: *');
		//$id_qvmenu=((base64_decode($this->uri->segment(4))*3)/100);		
		$id_qvmenu=str_replace("-api-json","",$this->uri->segment(3));		
		
		$query = $this->db->query("select QRY as qry_vqmenu from api_qry where IDQRY='".$id_qvmenu."'");
		$row = $query->row();	
		
		$this->m_action->getDataJson($row->qry_vqmenu);
	}	

}
