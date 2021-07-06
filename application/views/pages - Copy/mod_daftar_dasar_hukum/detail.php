<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDDASKUM, NODASKUM, NMDASKUM from dbsipd_".$_tahun.".mdaskum where KDDASKUM='".$id."'");			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".mdaskum where KDDASKUM='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".mdaskum","KDDASKUM", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".mdaskum");		
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
				  <label class="control-label">Nomor :</label>
				  <div class="controls">				
					<input type="text"  name="NODASKUM" id="NODASKUM" value="<?=@$row->NODASKUM?>"  class='span6' />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Uraian :</label>
				  <div class="controls">
					<input type="text"  name="NMDASKUM" id="NMDASKUM" value="<?=@$row->NMDASKUM?>"  class='span12'/>
				  </div>
				</div>				
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="KDDASKUM" id="KDDASKUM" value="<?=@$row->KDDASKUM?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var KDDASKUM=$('input[name^=KDDASKUM]').val();
			var NODASKUM=$('input[name^=NODASKUM]').val();
			var NMDASKUM=$('input[name^=NMDASKUM]').val();
			  
			var dataPost={KDDASKUM:KDDASKUM, NODASKUM:NODASKUM, NMDASKUM:NMDASKUM};
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