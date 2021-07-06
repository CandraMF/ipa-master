<?php

class m_action extends CI_Model{
    function __construct(){
        parent::__construct();
    }

	function getRefJson($data)
	{		
		$query=$this->db->query($data);$var="";
		foreach ($query->list_fields() as $field){$var.="st_dt->".$field." = st_Isi['".$field."'];";}
		foreach ($query->result_array() as $Isi){$dt = new stdClass();eval(str_replace("st_","$",$var));$series[] = $dt;}		
		return $series;
	}
	public function getDataJson($Qry){
		
		$Qry=str_replace("&#039;","'",htmlspecialchars_decode($Qry));	
	
		$query = $this->db->query($Qry);
		$result["total"]  = $query->num_rows();

		$Query1 =$this->db->query($Qry);
		$items = array();
	
		$i=1;	
	
		$val="";
	
		foreach ($Query1->list_fields() as $Field){
			$val.="
			af (is_numeric([|]row['{$Field}'])){
				[|]data->{$Field}=@number_format([|]row['{$Field}'],0,',','.');
			}alse{
				[|]data->{$Field}=[|]row['{$Field}'];
			}";
		}
		
		$string=str_replace('[|]','$',$val);
		$string=str_replace('af','if',$string);
		$string=str_replace('alse','else',$string);
		
		$rs = $this->db->query($Qry);
		foreach ($rs->result_array() as $row){
			$data = new stdClass();					
			eval("$string");
			array_push($items, $data);
			
			$i++;
		}
	
		$result["rows"] = $items;
		echo str_replace('[]"},{','",',json_encode($result));
	}

	function ambilData($query)
	{
		$std = new stdClass();	
		$Query=$this->db->query($query);
		$Hasil=$Query->row();		
		$Query1 = $this->db->query($query);	
		foreach ($Query1->list_fields() as $Field)
		{
			$NmField = $Field;
			global $$NmField;
			$std->$NmField = @$Hasil->$NmField!='0'?@$Hasil->$NmField:"";
		}
		return $std;
	}

	function KosongkanData($tbl)
	{
		$std = new stdClass();		
		$Query1 = $this->db->query("select * from ".$tbl." limit 1");	
		foreach ($Query1->list_fields() as $Field)
		{
			$NmField = $Field;
			global $$NmField;
			$std->$NmField = "";
		}
		return $std;
	}

	function getData($table, $where){		
		
		$query = $this->db->query("select * from ".$table." where ".$where);	
		$response = new stdClass();
		if($query->num_rows()>0){
			$response->QryCek=true;
		}else{
			$response->QryCek=false;	
		}
		return $response;		
	}



	function insertData($table, $field, $value, $field_data, $iddata){		
		$sUserId=$this->session->userdata("SESS_USERNAME");
		$dt_qry="insert into ".$table." (".$field.", `created_by`, `created_date`) values (".$value.", '".$sUserId."', now()) ";
	
		$query = $this->db->query($dt_qry);	
		
		///////////// LOG
		$this->logData($dt_qry, "INSERT", $table, $field_data, $iddata);

		if($query){
			$status='success';
		}else{
			$status='failed';	
		}
		return $status;			
	}

	function updateData($table, $update, $where, $field_data, $iddata){		
		$sUserId=$this->session->userdata("SESS_USERNAME");
		$dt_qry="update ".$table." set ".$update.", `updated_by`='{$sUserId}', `updated_date`=now() where ".$where;
	
		$query = $this->db->query($dt_qry);	

		///////////// LOG
		$this->logData($dt_qry, "UPDATE", $table, $field_data, $iddata);

		if($query){
			$status='success';
		}else{
			$status='failed';	
		}
	
		return $status;		
	}

	function destroyData($table, $where, $field_data, $iddata){		
		
		$dt_qry="delete from ".$table." where ".$where;
		$query = $this->db->query($dt_qry);	
		
		///////////// LOG
		$this->logData($dt_qry, "DELETE", $table, $field_data, $iddata);

		if($query){
			$status='success';
		}else{
			$status='failed';	
		}
		return $status;	
	}

	function logData($dt_qry="", $Action="", $Table="", $field_data="", $iddata=""){
		$SESS_USERNAME=$this->session->userdata("SESS_USERNAME");
		$SESS_TAHUN = $this->session->userdata('SESS_TAHUN');
		$IPADDRESS=$this->andri->get_client_ip();
		$this->db->query("INSERT INTO `dbipa_".$SESS_TAHUN."`.`__log_aktifitas` (`username`, `query`, `action`, `data`, `waktu`, `field_data`, `iddata`, `ipaddress`) VALUES ('".$SESS_USERNAME."', '".$this->htmlval($dt_qry)."', '".$Action."', '".$Table."', now(), '".$field_data."', '".$iddata."', '".$IPADDRESS."');");	
	}
	
	function htmlval($dt_qry=""){
		return htmlentities($dt_qry, ENT_QUOTES,"UTF-8");
	}

	function actionData($Aksi, $table, $data , $arrwhere, $arrFilterAdd=""){		
		
		if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
		/////////////////////////// Get Data Primary Key From Table

		$arrFilterAdd=!empty($arrFilterAdd)?$arrFilterAdd:array();		
		$arrwhere=!empty($arrwhere)?$arrwhere:array();
		$i=1;$where="";$field_data="";$iddata="";
		while(count($arrwhere)>=$i){ 
			$where.="`".$arrwhere[$i-1]."`='".$$arrwhere[$i-1]."' and "; 
			$field_data.="`".$arrwhere[$i-1]."`, ";
			$iddata.=$$arrwhere[$i-1].", ";
			$i++; 
		}
		$where=substr($where,0,-5);
		$field_data=substr($field_data,0,-2);
		$iddata=substr($iddata,0,-2);

		/////////////////////////// Get Data Field & Value From Table
		$fields = $this->db->list_fields($table);
		$datafield="";$datavalue="";$dataupdate="";
		$arrNotIn=array('CREATED_BY','CREATED_DATE','UPDATED_BY','UPDATED_DATE');
	

		foreach ($fields as $field){
		   if(!in_array($field, $arrNotIn)){
		      if(!in_array($field, $arrFilterAdd)){
				if($field=='password'){
					$datafield.="`".$field."`, ";
					$datavalue.="'".md5(trim($this->htmlval(@$$field)))."', ";
					$dataupdate.="`".$field."`='".md5(trim($this->htmlval(@$$field)))."', ";
				}else{
					$datafield.="`".$field."`, ";
					$datavalue.="'".$this->htmlval(@$$field)."', ";
					$dataupdate.="`".$field."`='".$this->htmlval(@$$field)."', ";
				}
			  }
		   }
		   
		} 
		 $datafield=substr($datafield,0,-2);
		 $datavalue=substr($datavalue,0,-2);
		 $dataupdate=substr($dataupdate,0,-2);

		$std = new stdClass();	
		switch($Aksi){
			case "simpan":
				$response = new stdClass();
				$response = $this->getData($table, $where);		
				if($response->QryCek){
					$std->status=$this->updateData($table, $dataupdate, $where, $field_data, $iddata);
				}else{
					$std->status=$this->InsertData($table, $datafield, $datavalue, $field_data, $iddata);
				}
			
			break;
			case "destroy":
				 $std->status=$this->destroyData($table, $where, $field_data, $iddata);
			break;
			default:
				$std->status='failed';
		}

		return $std->status;
	}
	
	function actionDataRegister($Aksi, $table, $data , $arrwhere, $arrFilterAdd=""){		
		
		if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
		/////////////////////////// Get Data Primary Key From Table

		$arrFilterAdd=!empty($arrFilterAdd)?$arrFilterAdd:array();		
		$arrwhere=!empty($arrwhere)?$arrwhere:array();
		$i=1;$where="";$field_data="";$iddata="";
		while(count($arrwhere)>=$i){ 
			$where.="`".$arrwhere[$i-1]."`='".$$arrwhere[$i-1]."' and "; 
			$field_data.="`".$arrwhere[$i-1]."`, ";
			$iddata.=$$arrwhere[$i-1].", ";
			$i++; 
		}
		$where=substr($where,0,-5);
		$field_data=substr($field_data,0,-2);
		$iddata=substr($iddata,0,-2);

		/////////////////////////// Get Data Field & Value From Table
		$fields = $this->db->list_fields($table);
		$datafield="";$datavalue="";$dataupdate="";
		$arrNotIn=array('CREATED_BY','CREATED_DATE','UPDATED_BY','UPDATED_DATE');
	

		foreach ($fields as $field){
		   if(!in_array($field, $arrNotIn)){
		      if(!in_array($field, $arrFilterAdd)){
				if($field=='password'){
					$datafield.="`".$field."`, ";
					$datavalue.="'".md5(trim($this->htmlval(@$$field)))."', ";
					$dataupdate.="`".$field."`='".md5(trim($this->htmlval(@$$field)))."', ";
				}else{
					$datafield.="`".$field."`, ";
					$datavalue.="'".$this->htmlval(@$$field)."', ";
					$dataupdate.="`".$field."`='".$this->htmlval(@$$field)."', ";
				}
				
			  }
		   }
		   
		} 
		 $datafield=substr($datafield,0,-2);
		 $datavalue=substr($datavalue,0,-2);
		 $dataupdate=substr($dataupdate,0,-2);

		$std = new stdClass();	
		switch($Aksi){
			case "simpan":
				$response = new stdClass();
				$response = $this->getData($table, $where);		
				if($response->QryCek){
					$std->status=$this->updateData($table, $dataupdate, $where, $field_data, $iddata);
				}else{
					$std->status=$this->InsertData($table, $datafield, $datavalue, $field_data, $iddata);
				}
			break;
			case "destroy":
				 $std->status=$this->destroyData($table, $where, $field_data, $iddata);
			break;
			default:
				$std->status='failed';
		}

		return $std;
	}
	function actionDataSelect($Aksi, $table, $query, $data , $arrwhere){		
		if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
		/////////////////////////// Get Data Primary Key From Table
				
		$arrwhere=!empty($arrwhere)?$arrwhere:array();
		$i=1;$where="";
		while(count($arrwhere)>=$i){  
			$where.="`".$arrwhere[$i-1]."`='".$$arrwhere[$i-1]."' and "; 
			
			$i++;
		}
		$where=substr($where,0,-5);

		/////////////////////////// Get Data Field & Value From Table
		
		$datafield="";$datavalue="";$dataupdate="";
		$Query1 = $this->db->query($query);	
		foreach ($Query1->list_fields() as $field){			
		   $datafield.="`".$field."`, ";
		   $datavalue.="'".@$$field."', ";
		   $dataupdate.="`".$field."`='".@$$field."', ";
		} 
		 $datafield=substr($datafield,0,-2);
		 $datavalue=substr($datavalue,0,-2);
		 $dataupdate=substr($dataupdate,0,-2);

		$std = new stdClass();	
		switch($Aksi){
			case "simpan":
				$response = new stdClass();
				$response = $this->getData($table, $where);		
				if($response->QryCek){
					$std->status=$this->updateData($table, $dataupdate, $where);
				}else{
					$std->status=$this->InsertData($table, $datafield, $datavalue);
				}
			break;
			case "destroy":
				 $std->status=$this->destroyData($table, $where);
			break;
			default:
				$std->status='failed';
		}

		return $std;
	}

	

}

?>