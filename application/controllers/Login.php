<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('m_auth','m_auth');		
		$this->load->model('m_action','m_action');		
    }

	public function index()
	{
		$response = new stdClass();
		$response = $this->m_auth->cekLogin($this->input->post());		
		$ret = new stdClass();
		$ret->login = false;

		$ret->msg = ""; 
		if ($response->count > 0){
			if (md5($this->input->post("password")) == $response->result->password){
				$session = array(			
					'SESS_USERNAME'  => $response->result->username,
					'SESS_LOGIN'     => TRUE,
					'SESS_NAMA'		 => $response->result->nama_lengkap,
					'SESS_TAHUN'	 => $this->input->post('tahun'),
					'SESS_GROUP'	 => $response->result->idgroupakses
				);
				
				//LANGSUNGLOGIN//
				$this->session->set_userdata($session); 
				
				echo "
					<script>
						parent.location='".base_url('login/pages')."';
					</script>
				";
			}else{
				echo "
					<script>
					alert('Username anda tidak teridentifikasi...!!!');
					parent.location='".base_url('home')."';
				</script>
				";
			}
			
		}else{
			echo "
				<script>
					alert('Username anda tidak teridentifikasi...!!!');
					parent.location='".base_url('home')."';
				</script>
			";
		}
	}

	public function pages()
	{				
		$login = $this->session->userdata('SESS_LOGIN');
		if ($login){
			
			$Pr=$this->uri->segment(3);				
			$Sb=$this->uri->segment(4);				
			$Aksi=$this->uri->segment(5);				
			$id=$this->uri->segment(6);				
			$SESS_USERNAME=$this->session->userdata("SESS_USERNAME");			
			$dt=$this->m_auth->getCekMenu($SESS_USERNAME, $Pr);
			
			$Pr=!empty($Pr)?$Pr:"beranda";
			$FilePages=$dt->cekmenu?$Pr:"beranda";			
			


			

			$dataHeader["_menu"] = $this->m_auth->getMenuList($SESS_USERNAME);	
				
			$dataHeader["_title"]		= !empty($dt->title)?$dt->title:"Beranda";	
			$dataHeader["Pr"]			= $Pr;
			$dataHeader["sUserId"]		= $SESS_USERNAME;	
			$dataHeader["_tahun"]		= $this->session->userdata("SESS_TAHUN");
			///////////////// DATA PAGES
			$ThnAwal=2020; $ThnAkhir=date('Y')+2;$i=1; while($ThnAkhir>=$ThnAwal){ $ArrThn[$i-1]=$ThnAwal; $ThnAwal++; $i++;}
			$dataPages["ArrThn"] = $ArrThn;
			$datapost=$this->input->post();
			if (!empty($datapost)){foreach($datapost as $key => $value){$dataPages[$key] = $this->andri->clean($value);}}
			
			$dtm = new stdClass();	
			$dtm=$this->m_action->ambilData("SELECT a.pinsert, a.pupdate, a.pdelete FROM dbipa_".$this->session->userdata("SESS_TAHUN").".__t_hak_akses AS a INNER JOIN __t_submenu AS b ON a.id_sub=b.id_sub INNER JOIN dbipa_".$this->session->userdata("SESS_TAHUN").".__t_users AS c ON a.idgroupakses=c.idgroupakses WHERE c.username='".$SESS_USERNAME."' AND b.link_sub='".@$Pr."'");
			$SESS_TAHUN=$this->session->userdata("SESS_TAHUN");	
			$SESS_GROUP=$this->session->userdata("SESS_GROUP");	
			
			$dataPages["_tahun"]		= $this->session->userdata("SESS_TAHUN");				 
			$dataPages["Pr"]			= $Pr;	 	
			$dataPages["Sb"]			= $Sb;	

			$POST_TA					= $this->input->post('thn_anggaran');
		

			$dataPages["thn_anggaran"]	= !empty($POST_TA)?$POST_TA:$SESS_TAHUN;
			$dataPages["sUserId"]		= $SESS_USERNAME;	
			$dataPages["sGroup"]		= $SESS_GROUP;	
			$dataPages["Aksi"]			= $Aksi;	
			$dataPages["id"]			= $id;	
			$dataPages["_pinsert"]		= $dtm->pinsert!='Y'?"style='display:none;'":"";	
			$dataPages["_pupdate"]		= $dtm->pupdate!='Y'?"style='display:none;'":"";	
			$dataPages["_pdelete"]		= $dtm->pdelete!='Y'?"style='display:none;'":"";	

		

			//////////////// FILTER OPD			
			$FilterOPD=array('3','4','8','9');
			if (in_array($SESS_GROUP, $FilterOPD)) {
				if($SESS_IDOPD>0){
					$qryopd=" IN (SELECT UNITKEY FROM dbipa_".$SESS_TAHUN.".mskpd WHERE UNITKEY='".$SESS_IDOPD."')";
					$dataPages["_qryopd"]		= $qryopd;	
				}

				if($SESS_KDBIDANG>0){
					$qryopd=" IN (SELECT UNITKEY FROM dbipa_".$SESS_TAHUN.".mbidang_skpd WHERE KDBIDANG='".$SESS_KDBIDANG."')";
					$dataPages["_qryopd"]		= $qryopd;	
				}
				
				if($SESS_KDSUBBIDANG>0){
					$qryopd=" IN (SELECT UNITKEY FROM dbipa_".$SESS_TAHUN.".mbidang_skpd WHERE KDSUBBIDANG='".$SESS_KDSUBBIDANG."')";
					$dataPages["_qryopd"]		= $qryopd;	
				}			
			}else{
				$qryopd=" NOT IN ('')";
				$dataPages["_qryopd"]		= $qryopd;	
			}
			
			//////////////// FILTER KECAMATAeN		
			$FilterOPD=array('5');
			
			if (in_array($SESS_GROUP, $FilterOPD)) {

				if($SESS_IDOPD>0){
					$qryopd=" IN (SELECT UNITKEY FROM dbipa_".$SESS_TAHUN.".mskpd WHERE UNITKEY='".$SESS_IDKEC."')";
					$dataPages["_qrykec"]		= $qryopd;	
				}else{
					$qryopd=" IN (SELECT UNITKEY FROM dbipa_".$SESS_TAHUN.".mskpd WHERE UNITKEY='".$SESS_IDKEC."')";
					$dataPages["_qrykec"]		= $qryopd;	
				}
				
			}else{
				$qryopd=" NOT IN ('')";
				$dataPages["_qrykec"]		= $qryopd;	
			}
			

			//////////////// FILTER DEWAN
			$FilterOPD=array('2');
			if ($SESS_GROUP==2) {
					$qryopd=" IN (SELECT KDDEWAN FROM dbipa_".$SESS_TAHUN.".mdprd WHERE KDDEWAN='".$SESS_KDDEWAN."')";
					$dataPages["_qrydewan"]		= $qryopd;	
				
			}else{
				$qryopd=" NOT IN ('')";
				$dataPages["_qrydewan"]		= $qryopd;	
			}


			$dataPages["_title"]		= $dt->title;
			
			
			$ipaddress=$this->andri->get_client_ip();
			$link_url=base_url("login/page/".$Pr."/".$Sb."/".$Aksi."/".$id);
			$link_url=str_replace("///","",$link_url);
			$link_url=str_replace("//","",$link_url);
			$link_url=str_replace("http:","http://",$link_url);
			if($Pr!='setting_log_aktifitas'){
				$this->db->query("INSERT INTO `dbipa_".$this->session->userdata("SESS_TAHUN")."`.`__log_server` (`ipaddress`, `username`, `link_url`, `link_sub`, `waktu`) VALUES ('".$ipaddress."', '".$SESS_USERNAME."', '".$link_url."', '".$Pr."',now());");
			}
			


			$dataPages["_ipaddress"] = $ipaddress;
			$this->load->view('header',$dataHeader);
			if(!empty($Sb)){
				if($Sb=='list'){
					$this->load->view('pages/'.$Pr,$dataPages);
				}else{
					$this->load->view('pages/mod_'.$Pr.'/'.$Sb,$dataPages);
				}
				
			}else{
				$this->load->view('pages/'.$Pr,$dataPages);
			}
				
			
			$dataFooter["Pr"]			= $Pr;	 	
			$dataFooter["_tahun"]			= $this->session->userdata("SESS_TAHUN");	 	
			$this->load->view('footer',$dataFooter);
		}else{
			echo "<script>parent.location='".base_url('home')."';</script>";
		}
	}	

	public function cetak()
	{				
		$login = $this->session->userdata('SESS_LOGIN');
		if ($login){
			
			$Pr=$this->uri->segment(3);				
					
			$SESS_USERNAME=$this->session->userdata("SESS_USERNAME");			
			$dt=$this->m_auth->getCekMenu($SESS_USERNAME, $Pr);
			
			$Pr=!empty($Pr)?$Pr:"beranda";
			$FilePages=$dt->cekmenu?$Pr:"beranda";			
			
			$Pr=$this->uri->segment(3);			
						
			
			

			$dataHeader["_menu"] = $this->m_auth->getMenuList($SESS_USERNAME);	
				
			$dataHeader["_title"]		= !empty($dt->title)?$dt->title:"Beranda";	
			$dataHeader["Pr"]			= $Pr;
			$dataHeader["sUserId"]		= $SESS_USERNAME;	
			$dataHeader["_tahun"]		= $this->session->userdata("SESS_TAHUN");
			///////////////// DATA PAGES
			$ThnAwal=2014; $ThnAkhir=date('Y')+2;$i=1; while($ThnAkhir>=$ThnAwal){ $ArrThn[$i-1]=$ThnAwal; $ThnAwal++; $i++;}
			$dataPages["ArrThn"] = $ArrThn;
			$datapost=$this->input->post();
			if (!empty($datapost)){foreach($datapost as $key => $value){$dataPages[$key] = $this->andri->clean($value);}}
			
			$dtm = new stdClass();	
			$dtm=$this->m_action->ambilData("SELECT a.pinsert, a.pupdate, a.pdelete FROM dbipa_".$this->session->userdata("SESS_TAHUN").".__t_hak_akses AS a INNER JOIN __t_submenu AS b ON a.id_sub=b.id_sub INNER JOIN dbipa_".$this->session->userdata("SESS_TAHUN").".__t_users AS c ON a.idgroupakses=c.idgroupakses WHERE c.username='".$SESS_USERNAME."' AND b.link_sub='".@$Pr."'");

			$query = $this->db->query("select tahapan from `dbipa_".$this->session->userdata("SESS_TAHUN")."`.`__t_users` where username='".$SESS_USERNAME."'");			
			$row=$query->row();
			$dataPages["_tahap"]		= $row->tahapan;				
			$dataPages["_tahun"]		= $this->session->userdata("SESS_TAHUN");				
			$dataPages["_skpd"]			= $this->session->userdata("SESS_SKPD");		
			$dataPages["_idopd"]		= $this->session->userdata("SESS_IDOPD");	
			$dataPages["_id_bidang"]	= $this->session->userdata("SESS_IDBIDANG");			 
			$dataPages["_bidangbappeda"]= $this->session->userdata("SESS_BIDANGBAPPEDA");			 
			$dataPages["_bidangbappeda"]= $this->session->userdata("SESS_BIDANGBAPPEDA");			 
			$dataPages["Pr"]			= $Pr;	 	

			$POST_TA					= $this->input->post('thn_anggaran');
			$SESS_TAHUN					= $this->session->userdata("SESS_TAHUN");	
			$SESS_IDOPD					= $this->session->userdata("SESS_IDOPD");	
			$SESS_IDKEC					= $this->session->userdata("SESS_IDKEC");	
			$SESS_KDBIDANG				= $this->session->userdata("SESS_KDBIDANG");	
			$SESS_KDSUBBIDANG			= $this->session->userdata("SESS_KDSUBBIDANG");	
			$SESS_KDDEWAN				= $this->session->userdata("SESS_KDDEWAN");
			$SESS_GROUP					= $this->session->userdata("SESS_GROUP");

			$dataPages["thn_anggaran"]	= !empty($POST_TA)?$POST_TA:$SESS_TAHUN;
			$dataPages["sUserId"]		= $SESS_USERNAME;	
			
			$dataPages["_pinsert"]		= $dtm->pinsert!='Y'?"style='display:none;'":"";	
			$dataPages["_pupdate"]		= $dtm->pupdate!='Y'?"style='display:none;'":"";	
			$dataPages["_pdelete"]		= $dtm->pdelete!='Y'?"style='display:none;'":"";	

			$dataPages["_idopd"]		= $SESS_IDOPD;	
			$dataPages["_idkec"]		= $SESS_IDKEC;	
			$dataPages["_kdbidang"]		= $SESS_KDBIDANG;	
			$dataPages["_kdsubbidang"]	= $SESS_KDSUBBIDANG;	
			$dataPages["_kddewan"]		= $SESS_KDDEWAN;	

			//////////////// FILTER OPD			
			$FilterOPD=array('3','4','8');
			if (in_array($SESS_GROUP, $FilterOPD)) {
				if($SESS_IDOPD>0){
					$qryopd=" IN (SELECT UNITKEY FROM dbipa_".$SESS_TAHUN.".mskpd WHERE UNITKEY='".$SESS_IDOPD."')";
					$dataPages["_qryopd"]		= $qryopd;	
				}

				if($SESS_KDBIDANG>0){
					$qryopd=" IN (SELECT UNITKEY FROM dbipa_".$SESS_TAHUN.".mbidang_skpd WHERE KDBIDANG='".$SESS_KDBIDANG."')";
					$dataPages["_qryopd"]		= $qryopd;	
				}
				
				if($SESS_KDSUBBIDANG>0){
					$qryopd=" IN (SELECT UNITKEY FROM dbipa_".$SESS_TAHUN.".mbidang_skpd WHERE KDSUBBIDANG='".$SESS_KDSUBBIDANG."')";
					$dataPages["_qryopd"]		= $qryopd;	
				}			
			}else{
				$qryopd=" NOT IN ('')";
				$dataPages["_qryopd"]		= $qryopd;	
			}
			
			//////////////// FILTER KECAMATAN		
			$FilterOPD=array('5');
			if (in_array($SESS_GROUP, $FilterOPD)) {
				if($SESS_IDOPD>0){
					$qryopd=" IN (SELECT UNITKEY FROM dbipa_".$SESS_TAHUN.".mskpd WHERE UNITKEY='".$SESS_IDKEC."')";
					$dataPages["_qrykec"]		= $qryopd;	
				}
				
			}else{
				$qryopd=" NOT IN ('')";
				$dataPages["_qrykec"]		= $qryopd;	
			}

			//////////////// FILTER DEWAN
			$FilterOPD=array('2');
			if (in_array($SESS_GROUP, $FilterOPD)) {
				if($SESS_IDOPD>0){
					$qryopd=" IN (SELECT KDDEWAN FROM dbipa_".$SESS_TAHUN.".mdprd WHERE KDDEWAN='".$SESS_KDDEWAN."')";
					$dataPages["_qrydewan"]		= $qryopd;	
				}
				
			}else{
				$qryopd=" NOT IN ('')";
				$dataPages["_qrydewan"]		= $qryopd;	
			}


			$dataPages["_title"]		= $dt->title;
			
			
			$ipaddress=$this->andri->get_client_ip();
			
			


			$dataPages["_ipaddress"] = $ipaddress;
			$this->load->view('cheader',$dataHeader);

			$this->load->view('print/'.$Pr,$dataPages);
				
			
			$dataFooter["Pr"]			= $Pr;	 	
			$dataFooter["_tahun"]			= $this->session->userdata("SESS_TAHUN");	 	
			$this->load->view('cfooter',$dataFooter);
		}else{
			echo "<script>parent.location='".base_url('home')."';</script>";
		}
	}	
	public function test(){
		echo '<script src="<?=base_url("assets/backend/js/select2.min.js")?>"></script>';
		echo $this->m_auth->cmbQuery('idgroupakses',@$idgroupakses,"select idgroupakses as '0', nmgroupakses as '1' from rkpd.__t_group_akses");
	}
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}