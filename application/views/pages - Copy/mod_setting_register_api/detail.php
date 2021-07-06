<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select IDQRY, NAMA_QRY, QRY from dbsipd_".$_tahun.".api_qry where IDQRY='".$id."'");	
			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".api_qry where IDQRY='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".api_qry","IDQRY", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".api_qry");		
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
				<input type="hidden"  name="IDQRY" id="IDQRY" value="<?=@$row->IDQRY?>"  class='span8'/>
				
				<div class="control-group">
				  <label class="control-label">Nama Query:</label>
				  <div class="controls">
					<input type="text"  name="NAMA_QRY" id="NAMA_QRY" value="<?=@$row->NAMA_QRY?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">QRY :</label>
				  <div class="controls">
					<textarea name="QRY" rows="5" cols="15" id="QRY" class='span8'><?=@$row->QRY?></textarea>
					
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
		
			var IDQRY=$('input[name^=IDQRY]').val();
			var NAMA_QRY=$('input[name^=NAMA_QRY]').val();
			var QRY=$('#QRY').val();
			  
			var dataPost={IDQRY:IDQRY, NAMA_QRY:NAMA_QRY, QRY:QRY};
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