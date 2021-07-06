<?php	
	$UNITKEY=$this->uri->segment(5);	
	$id=$this->uri->segment(6);	
	$qry="update  dbsipd_".$_tahun.".t_kegiatan_cpcl set TGLVERIFIKASI=curdate() where KDCPCL='".$id."'";	
	$this->db->query($qry);		
	//echo"<script>parent.location='".base_url("login/pages/".$Pr."/list/Aksi/".$JENIS_CPCL."/".$KDKEGUNIT."/".$UNITKEY_KEC."/".$UNITKEY)."';</script>";
?>