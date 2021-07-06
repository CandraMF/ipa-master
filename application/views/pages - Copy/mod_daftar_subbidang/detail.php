<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDSUBBIDANG, KDBIDANG, NMSUBBIDANG from dbsipd_".$_tahun.".mbidang_sub where KDSUBBIDANG='".$id."'");	
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".mbidang_sub where KDSUBBIDANG='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".mbidang_sub","KDSUBBIDANG", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".mbidang_sub");		
			}
	}
	
?>
<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ FORM ]</h5>		
	  </div>
	  <div class="widget-content">
		<div class="control-group form-horizontal">	
			<form name=Fm id=Fm method=post action="#">
				<div class="control-group">
				  <label class="control-label">Kode :</label>
				  <div class="controls">				
					<input type="text"  name="KDSUBBIDANG" id="KDSUBBIDANG" value="<?=@$row->KDSUBBIDANG?>"  class='span8' <?=$readonly?>/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Bidang :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('KDBIDANG',@$row->KDBIDANG,"select KDBIDANG as '0',NMBIDANG as '1' from dbsipd_".$_tahun.".mbidang")?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama Sub Bidang :</label>
				  <div class="controls">
					<input type="text"  name="NMSUBBIDANG" id="NMSUBBIDANG" value="<?=@$row->NMSUBBIDANG?>"  class='span8'/>
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var KDBIDANG=$('#KDBIDANG').val();
			var KDSUBBIDANG=$('input[name^=KDSUBBIDANG]').val();
			var NMSUBBIDANG=$('input[name^=NMSUBBIDANG]').val();
			  
			var dataPost={KDSUBBIDANG:KDSUBBIDANG, KDBIDANG:KDBIDANG, NMSUBBIDANG:NMSUBBIDANG};
			$.post("<?=base_url('daftar/'.$Pr.'/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr)?>"; }, 1000);
			});
		});
	});	
</script>