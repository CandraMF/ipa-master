<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDKEGUNIT, NOKEG, NMKEG, KDPERPEKTIF, KDPRGRM from dbsipd_".$_tahun.".t_rpjmd_keg where KDKEGUNIT='".$id."'");			
			$readonly=" readonly ";
			$KDPRGRM=$row->KDPRGRM;
		break;
		case "hapus":	
			$row=$this->m_action->ambilData("select KDPRGRM from dbsipd_".$_tahun.".t_rpjmd_keg where KDKEGUNIT='".$id."'");	
			$qry="delete from dbsipd_".$_tahun.".t_rpjmd_keg where KDKEGUNIT='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_rpjmd_keg","KDKEGUNIT", $id);
			header("location:".base_url('login/pages/'.$Pr.'/list/program/'.$row->KDPRGRM));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".t_rpjmd_keg");		
			}else{
				$KDPRGRM=!empty($row->KDPRGRM)?$row->KDPRGRM:@$id;
				if(empty($KDPRGRM)){
					header("location:".base_url('login/pages/'.$Pr));
				}
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
					<input type="text"  name="NOKEG" id="NOKEG" value="<?=@$row->NOKEG?>"  class='span6' />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Uraian :</label>
				  <div class="controls">
					<input type="text"  name="NMKEG" id="NMKEG" value="<?=@$row->NMKEG?>"  class='span12'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Perpektif :</label>
				  <div class="controls">					
					<?=$this->m_auth->cmbQuery('KDPERPEKTIF',@$row->KDPERPEKTIF,"select KDPERPEKTIF as '0', NMPERPEKTIF as '1' from dbsipd_".$_tahun.".mjenis_perpektif")?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="KDKEGUNIT" id="KDKEGUNIT" value="<?=@$row->KDKEGUNIT?>">
				<input type="hidden" name="KDPRGRM" id="KDPRGRM" value="<?=@$KDPRGRM?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var KDKEGUNIT=$('input[name^=KDKEGUNIT]').val();
			var NOKEG=$('input[name^=NOKEG]').val();
			var NMKEG=$('input[name^=NMKEG]').val();
			var KDPRGRM=$('input[name^=KDPRGRM]').val();
			var KDPERPEKTIF=$('select[name^=KDPERPEKTIF]').val();
			  
			var dataPost={KDKEGUNIT:KDKEGUNIT, NOKEG:NOKEG, NMKEG:NMKEG, KDPRGRM:KDPRGRM, KDPERPEKTIF:KDPERPEKTIF};
			$.post("<?=base_url('pemda/'.$Pr.'_kegiatan/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				<?php if($Aksi!='param'){ ?>
				setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>"; }, 1000);
				<?php }else{ ?>
				setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/program/'.$id)?>"; }, 1000);		
				<?php } ?>
			});
		});
	});	
</script>