<?php

class m_auth extends CI_Model{
    function __construct(){
        parent::__construct();
    }
	function getJson($qry, $data , $arrwhere)
	{	
		if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
		/////////////////////////// Get Data Primary Key From Table
		$where="";
		if(!empty($arrwhere)){				
			$arrwhere=!empty($arrwhere)?$arrwhere:array();
			$i=1;$where="";
			while(count($arrwhere)>=$i){ $where.="`".$arrwhere[$i-1]."`='".$$arrwhere[$i-1]."' and "; $i++; }
			$where=" where ".substr($where,0,-5);
		}
	
		$query=$this->db->query($qry.$where);$var="";
		foreach ($query->list_fields() as $field)
		{$var.="st_dt->".$field." = st_Isi['".$field."'];";}
		foreach ($query->result_array() as $Isi)
		{$dt = new stdClass();eval(str_replace("st_","$",$var));$series[] = $dt;}		
		return $series;
	}
	function NaviPage($Qry="", $PageName="", $PageVal="", $onchange=""){
		$dt = new stdClass();
		$PageVal=!empty($PageVal)?$PageVal:1;
		$JQry = $this->db->query($Qry);
		$JmlData=$JQry->num_rows();	
		$Limit=5;
		$Hal=($PageVal*$Limit)-$Limit;
		$MaxPage=ceil($JmlData/$Limit);	
		$i=1; while($MaxPage>=$i){ $ArrPage[$i-1]=$i; $i++; }
		$query = $this->db->query($Qry." limit ".$Hal.",".$Limit);
		
		////////////////////FormPage
		$FormPage="
			<table>
			<tr>
				<td>Pages :</td>
				<td width='80'>".$this->andri->cmbUmum(@$PageName,@$PageVal,@$ArrPage,@$onchange)."</td>
			</tr>
			</table>
		";
		$dt->query=$query;
		$dt->FormPage=$FormPage;
		return $dt;
	}
	function cmbQuery($name='txtField',$value='',$query='',$param='',$Atas='Pilih',$vAtas=""){
		if($Atas=='Pilih'){
			$Input = "<option value='$vAtas'>$Atas</option>";		
		}else{$Input = "";}
		
		$query=$this->db->query($query);
		foreach ($query->result_array() as $row)
		{
			$Sel = $row['0']==trim($value)?"selected":"";
			$Input .= "<option $Sel value=\"{$row['0']}\">{$row['1']}";
		}
		$Input  = "<select $param name=\"$name\" id=\"$name\" class='select2-container'>$Input</select>";
		return $Input;
	}
	function getTable($Qry,$tdadd, $arrnotdata){
		////var
		$td="";$tr="";$align="";$i=1;
		$arrnotdata=!empty($arrnotdata)?$arrnotdata:array();
		$qry=$this->db->query($Qry);				
		/// field
		foreach ($qry->list_fields() as $field){ 
			if (!in_array($field, $arrnotdata)) {				
				$td.="<td>[!>]this->andri->cektipedata([|][/]row->".$field."[\][|])[<!]</td>"; 
			}
		}

		/// add field
		$td.=!empty($tdadd)?$tdadd:"";
		
		/// replace td
		$td=str_replace('[/]','{$',$td);
		$td=str_replace('[\]','}',$td);
				
		
		/// data
		foreach ($qry->result() as $row){ 
			@eval("\$rowdata = \"$td\";");
			$rowdata=str_replace('[+]',"'",$rowdata);
			$rowdata=str_replace('[|]','"',$rowdata);
			$rowdata=str_replace('[!>]','".$',$rowdata);
			$rowdata=str_replace('[<!]','."',$rowdata);
			@eval("\$rowdata = \"$rowdata\";");
			$tr.="<tr class='gradeX'>{$rowdata}</tr>"; 
		}	
		return $tr;
	}
	function cekLogin($data){
		if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
		$response					= new stdClass();		
	
		$query	= $this->db->query("select * from dbipa_".$tahun.".__t_users where username='{$username}' and blokir='N'");	
		$qdta	= $query->row();
		
		
		$response->result			= $query->row();
		$response->skpd				= "";		
		$response->bidangbappeda	= "";		
		$response->tahunanggaran	= $tahun;		
		$response->count			= $query->num_rows();
		
		return $response;
	}
	
	function getMainMenu($username){		

		

		$query = $this->db->query("select e.id_main, e.nama_menu, e.link from dbipa_".$this->session->userdata("SESS_TAHUN").".__t_users as a 
		inner join dbipa_".$this->session->userdata("SESS_TAHUN").".__t_group_akses as b on a.idgroupakses=b.idgroupakses
		inner join dbipa_".$this->session->userdata("SESS_TAHUN").".__t_hak_akses as c on c.idgroupakses=a.idgroupakses		
		inner join dbipa_".$this->session->userdata("SESS_TAHUN").".__t_mainmenu as e on c.id_main=e.id_main
		where a.username='{$username}' and e.aktif='Y' group by e.id_main, e.nama_menu, e.link order by e.urutan");
		
		return $query->result();
	}

	function getSubMenu($username, $id_main){		
		
		
		$query = $this->db->query("select distinct e.id_main, d.id_sub, e.nama_menu, d.nama_sub, d.link_sub,  d.id_submain from dbipa_".$this->session->userdata("SESS_TAHUN").".__t_users as a 
		inner join dbipa_".$this->session->userdata("SESS_TAHUN").".__t_group_akses as b on a.idgroupakses=b.idgroupakses
		inner join dbipa_".$this->session->userdata("SESS_TAHUN").".__t_hak_akses as c on c.idgroupakses=a.idgroupakses
		inner join dbipa_".$this->session->userdata("SESS_TAHUN").".__t_submenu as d on c.id_sub=d.id_sub
		inner join dbipa_".$this->session->userdata("SESS_TAHUN").".__t_mainmenu as e on d.id_main=e.id_main
		where a.username='{$username}' and e.id_main='{$id_main}' and d.aktif='Y' and d.id_submain=0   order by e.urutan, d.urutan_submenu");
		$response = new stdClass();
		$response->result = $query->result();
		$response->count = $query->num_rows();		
		return $response;
	}

	

	function getMenuList($data){
		$arMenu = $this->getMainMenu($data);		
		$menu = new stdClass();
		$i=1;$ListMenu="";
		// class='active'
		$MainMenu="";
		$SubMenu="";
		foreach($arMenu as $row){
			$arSubMenu=$this->getSubMenu($data, $row->id_main);
			$DropDownMenu="";
			if($arSubMenu->count > 0){
				$i=1;
				foreach($arSubMenu->result as $rowSub){
					if($rowSub->link_sub=="setting_query_console"){
						$DropDownMenu.="<li><a href='".base_url($rowSub->link_sub)."' target='_blank'>{$rowSub->nama_sub}</a></li>";	
					}else{
						$DropDownMenu.="<li><a href='".base_url("login/pages/".$rowSub->link_sub)."'>{$rowSub->nama_sub}</a></li>";	
					}
					
					$i++;
				}
				$DropDownMenu="<ul >{$DropDownMenu}</ul>";				
				$classli="class='submenu'";
				$spanli="<span class='label label-important'>".($i-1)."</span>";
			}else{
				$classli="";$spanli="";
			}
			$ListMenu.="
				<li ".$classli.">
					
					<a href='".base_url("login/pages/".$row->link)."' >
						<i class='icon icon-th-list'></i> 
						<span>{$row->nama_menu}</span>
						{$spanli}
					</a>					
					{$DropDownMenu}
				</li>";
			$i++;	
		}
		$ListMenu="
			<ul>
				<!-- Logout -->			
				{$ListMenu}						
			</ul>
		";
		return $ListMenu;
	}

			
	function getCekMenu($username, $link_sub){		
		$query = $this->db->query("select e.id_main, d.id_sub, e.nama_menu, d.nama_sub, d.link_sub,  d.id_submain from __t_users as a 
		inner join __t_group_akses as b on a.idgroupakses=b.idgroupakses
		inner join __t_hak_akses as c on c.idgroupakses=a.idgroupakses
		inner join __t_submenu as d on c.id_sub=d.id_sub
		inner join __t_mainmenu as e on d.id_main=e.id_main
		where a.username='{$username}' and d.link_sub='{$link_sub}' and d.aktif='Y' and d.id_submain=0 order by e.id_main, d.id_sub");		
		$response = new stdClass();
		if($query->num_rows()>0){
			$dt=$query->row();
			$response->cekmenu=true;
			$response->title=$dt->nama_menu." <img src='".base_url("assets/backend/img/breadcrumb.png")."' style='margin-left:7px;margin-right:7px;'> ".$dt->nama_sub;
			
		}else{
			$qry = $this->db->query("select e.id_main, e.nama_menu, e.link from __t_users as a 
			inner join __t_group_akses as b on a.idgroupakses=b.idgroupakses
			inner join __t_hak_akses as c on c.idgroupakses=a.idgroupakses		
			inner join __t_mainmenu as e on c.id_main=e.id_main
			where a.username='{$username}' and e.link='{$link_sub}' and e.aktif='Y' group by e.id_main, e.nama_menu, e.link");
			if($qry->num_rows()>0){
				$dt=$qry->row();
				$response->title=$dt->nama_menu;				
				$response->cekmenu=true;	
			}else{
				$response->title="";				
				$response->cekmenu=false;	
			}
			
		}
		
		return $response;
	}



}

?>