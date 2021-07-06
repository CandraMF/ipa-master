<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".mdesa where IDDESA='".$id."'");			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".mdesa where IDDESA='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".mdesa","IDDESA", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".mdesa");		
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
			<form name=Fm id=Fm method=post action="#" class="form-horizontal">				
				<div class="control-group">
				  <label class="control-label">Kode Desa :</label>
				  <div class="controls">				
					<input type="text"  name="KDDESA" id="KDDESA" value="<?=@$row->KDDESA?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">
					<input type="text"  name="NMDESA" id="NMDESA" value="<?=@$row->NMDESA?>"  class='span8'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Kecamatan :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('UNITKEY',@$row->UNITKEY,"select UNITKEY as '0', NMUNIT as '1' from dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD='KECAMATAN' order by KDUNIT")?>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Akronim :</label>
				  <div class="controls">
					<input type="text"  name="AKRONIM" id="AKRONIM" value="<?=@$row->AKRONIM?>"  class='span8'/>
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
					<input type="text"  name="TELP" id="TELP" value="<?=@$row->TELP?>"  class='span8'/>
				  </div>
				</div>	
				
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="IDDESA" id="IDDESA" value="<?=@$row->IDDESA?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var IDDESA=$('input[name^=IDDESA]').val();
			var KDDESA=$('input[name^=KDDESA]').val();
			var NMDESA=$('input[name^=NMDESA]').val();
			var AKRONIM=$('input[name^=AKRONIM]').val();
			var UNITKEY=$('select[name^=UNITKEY]').val();
			var ALAMAT=$('input[name^=ALAMAT]').val();
			var TELP=$('input[name^=TELP]').val();
		
			  
			var dataPost={IDDESA:IDDESA, KDDESA:KDDESA, NMDESA:NMDESA, AKRONIM:AKRONIM, UNITKEY:UNITKEY, ALAMAT:ALAMAT, TELP:TELP};
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