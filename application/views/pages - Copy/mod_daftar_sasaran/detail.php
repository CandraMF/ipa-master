<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDSASARAN, NMSASARAN_DAERAH, KDBIDANG from dbsipd_".$_tahun.".msasaran_derah where KDSASARAN='".$id."'");	
			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".msasaran_derah where KDSASARAN='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".msasaran_derah","KDSASARAN", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".msasaran_derah");		
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
					<input type="text"  name="KDSASARAN" id="KDSASARAN" value="<?=@$row->KDSASARAN?>"  class='span8' <?=$readonly?>/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">
					<input type="text"  name="NMSASARAN_DAERAH" id="NMSASARAN_DAERAH" value="<?=@$row->NMSASARAN_DAERAH?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Bidang :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('KDBIDANG',@$row->KDBIDANG,"select KDBIDANG as '0', NMBIDANG as '1' from dbsipd_".$_tahun.".mbidang")?>
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
		
			var KDSASARAN=$('input[name^=KDSASARAN]').val();
			var NMSASARAN_DAERAH=$('input[name^=NMSASARAN_DAERAH]').val();
			var KDBIDANG=$('select[name^=KDBIDANG]').val();
			  
			var dataPost={KDSASARAN:KDSASARAN, NMSASARAN_DAERAH:NMSASARAN_DAERAH, KDBIDANG:KDBIDANG};
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