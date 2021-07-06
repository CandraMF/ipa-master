<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".mskpd where UNITKEY='".$id."'");			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".mskpd where UNITKEY='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".mskpd","UNITKEY", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".mskpd");		
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
			<form name=Fm id=Fm method=post action="#" class="form-horizontal">				
				<div class="control-group">
				  <label class="control-label">Kode Unit :</label>
				  <div class="controls">				
					<input type="text"  name="KDUNIT" id="KDUNIT" value="<?=@$row->KDUNIT?>"  class='span8' <?=$readonly?>/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">
					<input type="text"  name="NMUNIT" id="NMUNIT" value="<?=@$row->NMUNIT?>"  class='span8'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Akronim :</label>
				  <div class="controls">
					<input type="text"  name="AKRONIM" id="AKRONIM" value="<?=@$row->AKRONIM?>"  class='span8'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Struktur :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('KDSTUNIT',@$row->KDSTUNIT,"select KDSTUNIT as '0', NMSTUNIT as '1' from dbsipd_".$_tahun.".mstruktur_unit")?>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Alamat :</label>
				  <div class="controls">
					<input type="text"  name="ALAMAT" id="ALAMAT" value="<?=@$row->ALAMAT?>"  class='span8'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Telepon :</label>
				  <div class="controls">
					<input type="text"  name="TELEPON" id="TELEPON" value="<?=@$row->TELEPON?>"  class='span8'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Tipe :</label>
				  <div class="controls">
					<?=$this->andri->cmbUmum('TIPE',@$row->TIPE,array('H','D'))?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Jenis :</label>
				  <div class="controls">
					<?=$this->andri->cmbUmum('JENIS_OPD',@$row->JENIS_OPD,array('SKPD','KECAMATAN'))?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="UNITKEY" id="UNITKEY" value="<?=@$row->UNITKEY?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var UNITKEY=$('input[name^=UNITKEY]').val();
			var KDUNIT=$('input[name^=KDUNIT]').val();
			var NMUNIT=$('input[name^=NMUNIT]').val();
			var AKRONIM=$('input[name^=AKRONIM]').val();
			var KDSTUNIT=$('select[name^=KDSTUNIT]').val();
			var ALAMAT=$('input[name^=ALAMAT]').val();
			var TELEPON=$('input[name^=TELEPON]').val();
			var TIPE=$('select[name^=TIPE]').val();
			var JENIS_OPD=$('select[name^=JENIS_OPD]').val();
			  
			var dataPost={UNITKEY:UNITKEY, KDUNIT:KDUNIT, NMUNIT:NMUNIT, AKRONIM:AKRONIM, KDSTUNIT:KDSTUNIT, ALAMAT:ALAMAT, TELEPON:TELEPON, TIPE:TIPE, JENIS_OPD:JENIS_OPD};
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