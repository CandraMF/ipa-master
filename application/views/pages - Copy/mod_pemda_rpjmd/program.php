<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDPRGRM, NOPRGRM, NMPRGRM, UNITKEY from dbsipd_".$_tahun.".t_rpjmd_pgrm where KDPRGRM='".$id."'");	
			$UNITKEY=$row->UNITKEY;
			$readonly=" readonly ";
		break;
		case "hapus":	
			$row=$this->m_action->ambilData("select UNITKEY from dbsipd_".$_tahun.".t_rpjmd_pgrm where KDPRGRM='".$id."'");	
			$qry="delete from dbsipd_".$_tahun.".t_rpjmd_pgrm where KDPRGRM='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_rpjmd_pgrm","KDPRGRM", $id);
			header("location:".base_url('login/pages/'.$Pr.'/list/skpd_pgrm/'.$row->UNITKEY));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".t_rpjmd_pgrm");		
			}else{
				$UNITKEY=!empty($row->UNITKEY)?$row->UNITKEY:@$id;
				if(empty($UNITKEY)){
					header("location:".base_url('login/pages/'.$Pr));
				}
				
			}

			
	}
	
?>
<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ PROGRAM ]  [ FORM ]</h5>		
	  </div>
	  <div class="widget-content">
		<div class="control-group form-horizontal">
			<form name=Fm id=Fm method=post action="#">
				<div class="control-group">
				  <label class="control-label">Nomor :</label>
				  <div class="controls">				
					<input type="text"  name="NOPRGRM" id="NOPRGRM" value="<?=@$row->NOPRGRM?>"  class='span6' />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Uraian :</label>
				  <div class="controls">
					<input type="text"  name="NMPRGRM" id="NMPRGRM" value="<?=@$row->NMPRGRM?>"  class='span12'/>
				  </div>
				</div>				
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr.'/list/program/'.$id)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="KDPRGRM" id="KDPRGRM" value="<?=@$row->KDPRGRM?>">
				<input type="hidden" name="UNITKEY" id="UNITKEY" value="<?=@$UNITKEY?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var vKDPRGRM=$('input[name^=KDPRGRM]').val();
			var vNOPRGRM=$('input[name^=NOPRGRM]').val();
			var vNMPRGRM=$('input[name^=NMPRGRM]').val();
			var vUNITKEY=$('input[name^=UNITKEY]').val();
			  
			var dataPost={KDPRGRM:vKDPRGRM, NOPRGRM:vNOPRGRM, NMPRGRM:vNMPRGRM, UNITKEY:vUNITKEY};
			$.post("<?=base_url('pemda/'.$Pr.'_program/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				<?php if($Aksi!='param'){ ?>
					setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/program/'.$id)?>"; }, 1000);		
				<?php }else{ ?>
					setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/skpd_pgrm/'.$id)?>"; }, 1000);	
				<?php } ?>
				
			});
		});
	});	
</script>