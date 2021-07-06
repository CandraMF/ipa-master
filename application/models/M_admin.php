<?php

class m_admin extends CI_Model{
    function __construct(){
        parent::__construct();
    }
	function getSelect($table,$where){		
		$query = $this->db->query("select * from ".$table." where ".$where);	
		$response = new stdClass();
		if($query->num_rows()>0){
			$response->QryCek=true;
		}else{
			$response->QryCek=false;	
		}
		return $response;		
	}

	function Insert($table,$insert){		
		$query = $this->db->query("insert into ".$table." (".$insert.") values (".$insert.") ");	
		$response = new stdClass();		
		if($query){
			$response->status='success';
		}else{
			$response->status='failed';	
		}
		return $response;		
	}

	function update($table, $update, $where){		
		$query = $this->db->query("update ".$table." set ".$update." where ".$where);	
		$response = new stdClass();		
		if($query){
			$response->status='success';
		}else{
			$response->status='failed';
		}
		return $response;	
	}

	function destroy($table, $where){		
		$query = $this->db->query("delete from ".$table." where ".$where;);	
		$response = new stdClass();		
		if($query){
			$response->status='success';
		}else{
			$response->status='failed'
		}
		return $response;	
	}

}

?>