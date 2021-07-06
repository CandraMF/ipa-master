<?php
	$row = new stdClass();	
	$row=$this->m_action->ambilData("select tahapan, nama_lengkap from dbsipd_".$_tahun.".__t_users where username='".$sUserId."'");
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
				  <label class="control-label">Tahun :</label>
				  <div class="controls">	
					<input type="text"  placeholder="Tahun"  value='<?=@$_tahun?>' readonly/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">	
					<input type="text"  placeholder="nama_lengkap"  value='<?=@$row->nama_lengkap?>' readonly/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Username :</label>
				  <div class="controls">	
					<input type="text"  placeholder="Username" name="username" id="username" value='<?=@$sUserId?>' readonly/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Tahapan :</label>
				  <div class="controls">	
					<?=$this->m_auth->cmbQuery('tahapan',@$row->tahapan,"select tahapan as '0', nmtahapan as '1' from dbsipd_".$_tahun.".__tahapan")?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					
				  </div>
				</div>
				<input type="hidden" name="username" value="<?=$sUserId?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var username=$('input[name^=username]').val();
			var tahapan=$('select[name^=tahapan]').val();
			  
			var dataPost={username:username, tahapan:tahapan};
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