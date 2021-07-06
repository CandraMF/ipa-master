<?php
	$row = new stdClass();	
	$row=$this->m_action->ambilData("select idgroupakses from dbsipd_".$_tahun.".__register_on_off where kdregreg='1'");
?>

<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ FORM ]</h5>		
	  </div>
	  <div class="widget-content">
		<div class="control-group form-horizontal">
			<form name=Fm id=Fm method=post action="#" class="form-horizontal">
				<div class="control-group">
				  <label class="control-label">Hak Akses :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('idgroupakses',@$row->idgroupakses,"select idgroupakses as '0', nmgroupakses as '1' from dbsipd_".$_tahun.".__t_group_akses","onchange=\"Fm.Aksi.value='BknSimpan';Fm.submit();\"")?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					
				  </div>
				</div>
				<input type="hidden" name="kdregreg" id='kdregreg' value="1">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var kdregreg=$('#kdregreg').val();
			var idgroupakses=$('#idgroupakses').val();
			  
			var dataPost={kdregreg:kdregreg, idgroupakses:idgroupakses};
			$.post("<?=base_url('pengaturan/'.$Pr.'/simpan')?>",dataPost,
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