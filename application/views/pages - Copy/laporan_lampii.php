<?php
	$data=$this->input->post();
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	$KDTAHAP=$_tahap;
	$JVERIFIKASI=!empty($JVERIFIKASI)?$JVERIFIKASI:1;
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
		  <label class="control-label">Bidang</label>
		  <div class="controls">
				<?=$this->m_auth->cmbQuery('KDBIDANG',@$KDBIDANG,"select KDBIDANG as '0', NMBIDANG as '1' from dbsipd_".$_tahun.".mbidang ","onchange=\"Fm.submit();\"")?>			
		  </div>
		</div>
		<div class="control-group" style='display:none;'>
		  <label class="control-label">Sub Bidang</label>
		  <div class="controls">
				<?=$this->m_auth->cmbQuery('KDSUBBIDANG',@$KDSUBBIDANG,"select KDSUBBIDANG as '0', NMSUBBIDANG as '1' from dbsipd_".$_tahun.".mbidang_sub where NMSUBBIDANG!='' and KDBIDANG='".@$KDBIDANG."' ","onchange=\"Fm.submit();\"")?>			
		  </div>
		</div>
		<div class="control-group">
		  <label class="control-label">Jenis Verifikasi</label>
		  <div class="controls">
				<?=$this->andri->cmb2D('JVERIFIKASI',@$JVERIFIKASI,array(array('1','Sudah Verifikasi'),array('2','Belum Verifikasi')),"onchange=\"Fm.submit();\"")?>			
		  </div>
		</div>
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls">			
				<a href="<?=base_url("login/cetak/".$Pr."/".@$JVERIFIKASI."/".@$KDBIDANG)?>" target='_blank'><button type="button" class="btn btn-primary">Cetak</button></a>
			</div>
		</div>
	  </div>	
</div>		
</form>