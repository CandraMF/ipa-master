<?php
	$data=$this->input->post();
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	$id=!empty($id)?$id:"1";
	$JENIS_VALIDASI=!empty($JENIS_VALIDASI)?$JENIS_VALIDASI:$id;
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:$this->uri->segment(7);	
	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:$this->uri->segment(8);	
?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>
<input type="hidden" name="TGLVALID" id='TGLVALID' value='<?=date('Y-m-d')?>'>
<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
		 <!-- Data List Program -->
	  <div class="widget-content form-horizontal">		
		
		<div class="control-group">
		  <label class="control-label">Jenis Verifikasi</label>
		  <div class="controls">
				<?=$this->andri->cmb2D('JENIS_VALIDASI',@$JENIS_VALIDASI,array(array(1,'Rancangan Awal'),array(2,'Musrenbang Kecamatan'),array(3,'Pokpir Dewan BL'),array(4,'Pokpir Dewan BTL')),"onchange=\"Fm.KDKEGUNIT.value='';Fm.UNITKEY.value='';Fm.submit();\"")?>					
		  </div>
		</div>		
		
	  </div>
	  <div class="widget-content form-horizontal">		
		 <?php
			switch($JENIS_VALIDASI){
				
				case "4":
					$dt['JENIS_VALIDASI']=$JENIS_VALIDASI;
					$dt['MTGKEY']=$this->uri->segment(7);
					$dt['JENIS_CPCL']=$JENIS_CPCL;
					$this->load->view('pages/mod_'.$Pr.'/pokpir_btl',$dt);
				break;
				case "3":
					$dt['JENIS_VALIDASI']=$JENIS_VALIDASI;
					$dt['UNITKEY']=$UNITKEY;
					$dt['JENIS_CPCL']=$JENIS_CPCL;
					$this->load->view('pages/mod_'.$Pr.'/pokpir_bl',$dt);
				break;
				case "2":
					$dt['JENIS_VALIDASI']=$JENIS_VALIDASI;
					$dt['UNITKEY']=$UNITKEY;
					$dt['JENIS_CPCL']=$JENIS_CPCL;
					$this->load->view('pages/mod_'.$Pr.'/musren_kecamatan',$dt);				
				break;
				default:				
					$this->load->view('pages/mod_'.$Pr.'/ranwal');				
			}			
		 ?>
	   </div>
</div>
		
</form>