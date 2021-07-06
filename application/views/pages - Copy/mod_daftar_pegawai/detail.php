<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDPEG, NIP, NAMA, GOL, UNITKEY, JABATAN, PENDIDIKAN, ALAMAT from dbsipd_".$_tahun.".mpegawai where KDPEG='".$id."'");	
			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".mpegawai where KDPEG='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".mpegawai","KDPEG", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".mpegawai");		
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
				  <label class="control-label">NIP :</label>
				  <div class="controls">				
					<input type="text"  name="NIP" id="NIP" value="<?=@$row->NIP?>"  class='span6' />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">
					<input type="text"  name="NAMA" id="NAMA" value="<?=@$row->NAMA?>"  class='span8'/>
				  </div>
				</div>		
				<div class="control-group">
				  <label class="control-label">Gol :</label>
				  <div class="controls">
					<?=$this->andri->cmbUmum('GOL',@$row->GOL,array( 'IV.e', 'IV.d', 'IV.c', 'IV.b', 'IV.a', 'III.d', 'III.c', 'III.b', 'III.a', 'II.d', 'II.c', 'II.b', 'II.a', 'I.d', 'I.c', 'I.b', 'I.a'))?>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Unit Organisasi :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('UNITKEY',@$row->UNITKEY,"SELECT UNITKEY AS '0', concat(KDUNIT,' ',NMUNIT) AS '1' FROM dbsipd_".$_tahun.".mskpd WHERE KDSTUNIT='3' ORDER BY KDUNIT")?>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Jabatan :</label>
				  <div class="controls">
					<input type="text"  name="JABATAN" id="JABATAN" value="<?=@$row->JABATAN?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Pendidikan :</label>
				  <div class="controls">
					<input type="text"  name="PENDIDIKAN" id="PENDIDIKAN" value="<?=@$row->PENDIDIKAN?>"  class='span4'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Alamat :</label>
				  <div class="controls">
					<input type="text"  name="ALAMAT" id="ALAMAT" value="<?=@$row->ALAMAT?>"  class='span12'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="KDPEG" id="KDPEG" value="<?=@$row->KDPEG?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  


<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		      
			var KDPEG=$('input[name^=KDPEG]').val();
			var NIP=$('input[name^=NIP]').val();
			var NAMA=$('input[name^=NAMA]').val();
			var GOL=$('select[name^=GOL]').val();
			var UNITKEY=$('select[name^=UNITKEY]').val();
			var JABATAN=$('input[name^=JABATAN]').val();
			var PENDIDIKAN=$('input[name^=PENDIDIKAN]').val();
			var ALAMAT=$('input[name^=ALAMAT]').val();
			  
			var dataPost={KDPEG:KDPEG, NIP:NIP, NAMA:NAMA, GOL:GOL, UNITKEY:UNITKEY, JABATAN:JABATAN, PENDIDIKAN:PENDIDIKAN, ALAMAT:ALAMAT};
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