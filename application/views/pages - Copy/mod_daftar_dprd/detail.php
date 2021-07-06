<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDDEWAN, NODEWAN, NMDEWAN, FRAKSI, PAGU, KETERANGAN from dbsipd_".$_tahun.".mdprd where KDDEWAN='".$id."'");	
			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".mdprd where KDDEWAN='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".mdprd","KDDEWAN", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".mdprd");		
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
				  <label class="control-label">No. Urut  :</label>
				  <div class="controls">				
					<input type="text"  name="NODEWAN" id="NODEWAN" value="<?=@$row->NODEWAN?>"  class='span6' />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama Anggota :</label>
				  <div class="controls">
					<input type="text"  name="NMDEWAN" id="NMDEWAN" value="<?=@$row->NMDEWAN?>"  class='span8'/>
				  </div>
				</div>		
				<div class="control-group">
				  <label class="control-label">Fraksi :</label>
				  <div class="controls">
					<input type="text"  name="FRAKSI" id="FRAKSI" value="<?=@$row->FRAKSI?>"  class='span8'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Pagu :</label>
				  <div class="controls">
					<input type="text"  name="PAGU" id="PAGU" value="<?=@$row->PAGU?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Keterangan :</label>
				  <div class="controls">
					<input type="text"  name="KETERANGAN" id="KETERANGAN" value="<?=@$row->KETERANGAN?>"  class='span12'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="KDDEWAN" id="KDDEWAN" value="<?=@$row->KDDEWAN?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  


<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		      
			var KDDEWAN=$('input[name^=KDDEWAN]').val();
			var NODEWAN=$('input[name^=NODEWAN]').val();
			var NMDEWAN=$('input[name^=NMDEWAN]').val();
			var FRAKSI=$('input[name^=FRAKSI]').val();
			var PAGU=$('input[name^=PAGU]').val();
			var KETERANGAN=$('input[name^=KETERANGAN]').val();
			  
			var dataPost={KDDEWAN:KDDEWAN, NODEWAN:NODEWAN, NMDEWAN:NMDEWAN, FRAKSI:FRAKSI, PAGU:PAGU, KETERANGAN:KETERANGAN};
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