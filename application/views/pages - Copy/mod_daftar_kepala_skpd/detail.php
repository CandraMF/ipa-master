<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDPEG, UNITKEY from dbsipd_".$_tahun.".daftar_kepala_skpd where UNITKEY='".$id."'");	
			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".daftar_kepala_skpd where UNITKEY='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".daftar_kepala_skpd","UNITKEY", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".daftar_kepala_skpd");		
			}
	}
	
?>
<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ FORM ]</h5>		
	  </div>
	  <div class="widget-content">
		<div class="control-group">
			<form name=Fm id=Fm method=post action="#">
				<div class="control-group">
				  <label class="control-label">Unit Organisasi :</label>
				  <div class="controls">				
					<?=$this->m_auth->cmbQuery('UNITKEY',@$row->UNITKEY,"SELECT UNITKEY as '0', CONCAT(KDUNIT,' ',NMUNIT) as '1' FROM dbsipd_".$_tahun.".mskpd WHERE KDSTUNIT='3'")?>					
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('KDPEG',@$row->KDPEG,"SELECT KDPEG AS '0', CONCAT(NIP,' ',NAMA) AS '1' from dbsipd_".$_tahun.".mpegawai ")?> 
				  </div>
				</div>				
				<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var UNITKEY=$('select[name^=UNITKEY]').val();
			var KDPEG=$('select[name^=KDPEG]').val();
			  
			var dataPost={UNITKEY:UNITKEY, KDPEG:KDPEG};
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