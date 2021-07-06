<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDDANA, NMDANA, KETERANGAN from dbsipd_".$_tahun.".mdana where KDDANA='".$id."'");	
			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".mdana where KDDANA='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".mdana","KDDANA", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".mdana");		
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
					<input type="text"  name="KDDANA" id="KDDANA" value="<?=@$row->KDDANA?>"  class='span8' <?=$readonly?>/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">
					<input type="text"  name="NMDANA" id="NMDANA" value="<?=@$row->NMDANA?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Keterangan :</label>
				  <div class="controls">
					<input type="text"  name="KETERANGAN" id="KETERANGAN" value="<?=@$row->KETERANGAN?>"  class='span8'/>
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
		
			var KDDANA=$('input[name^=KDDANA]').val();
			var NMDANA=$('input[name^=NMDANA]').val();
			  
			var dataPost={KDDANA:KDDANA, NMDANA:NMDANA};
			$.post("<?=base_url('jenis/'.$Pr.'/simpan')?>",dataPost,
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