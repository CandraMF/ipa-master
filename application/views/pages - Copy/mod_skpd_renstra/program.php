<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".t_renstra_pgrm where KDRENPROG='".$id."'");	
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}
			$readonly=" readonly ";
		break;
		case "hapus":	
			$row=$this->m_action->ambilData("select UNITKEY from dbsipd_".$_tahun.".t_renstra_pgrm where KDRENPROG='".$id."'");	
			$qry="delete from dbsipd_".$_tahun.".t_renstra_pgrm where KDRENPROG='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_renstra_pgrm","KDRENPROG", $id);
			header("location:".base_url('login/pages/'.$Pr.'/list/skpd_pgrm/'.$row->UNITKEY));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".t_renstra_pgrm");		
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
				  <label class="control-label">Program :</label>
				  <div class="controls">				
					<?=$this->m_auth->cmbQuery('KDPRGRM',@$row->KDPRGRM,"select KDPRGRM as '0', concat(NOPRGRM,' ',NMPRGRM) as '1' from dbsipd_".$_tahun.".t_rpjmd_pgrm where UNITKEY IN (SELECT URUSKEY FROM mskpd_urusan WHERE UNITKEY='{$UNITKEY}' UNION SELECT UNITKEY AS URUSKEY FROM mskpd WHERE NMUNIT ='NON URUSAN') ORDER BY NOPRGRM")?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Prioritas Daerah :</label>
				  <div class="controls">
					<input type="text"  name="NMPRIORITAS" id="NMPRIORITAS" value="<?=@$NMPRIORITAS?>"  class='span12'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Sasaran Daerah :</label>	 
				  <div class="controls">
					<input type="text"  name="NMSASARAN_DAERAH" id="NMSASARAN_DAERAH" value="<?=@$NMSASARAN_DAERAH?>"  class='span12'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Tolok Ukur (Benefit) :</label>
				  <div class="controls">
					<input type="text"  name="BENEFIT_TOLOK_UKUR" id="BENEFIT_TOLOK_UKUR" value="<?=@$BENEFIT_TOLOK_UKUR?>"  class='span12'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Taget (Benefit):</label>
				  <div class="controls">
					<input type="text"  name="BENEFIT_TARGET" id="BENEFIT_TARGET" value="<?=@$BENEFIT_TARGET?>"  class='span12'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Tolok Ukur (Outcome) :</label>
				  <div class="controls">
					<input type="text"  name="OUTCOME_TOLOK_UKUR" id="OUTCOME_TOLOK_UKUR" value="<?=@$OUTCOME_TOLOK_UKUR?>"  class='span12'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Taget (Outcome):</label>
				  <div class="controls">
					<input type="text"  name="OUTCOME_TARGET" id="OUTCOME_TARGET" value="<?=@$OUTCOME_TARGET?>"  class='span12'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr.'/list/program/'.$id)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="UNITKEY" id="UNITKEY" value="<?=@$UNITKEY?>">
				<input type="hidden" name="KDRENPROG" id="KDRENPROG" value="<?=@$KDRENPROG?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var KDRENPROG=$('#KDRENPROG').val();
			var UNITKEY=$('#UNITKEY').val();
			var KDPRGRM=$('#KDPRGRM').val();			
			var NMPRIORITAS=$('#NMPRIORITAS').val();
			var NMSASARAN_DAERAH=$('#NMSASARAN_DAERAH').val();
			var BENEFIT_TOLOK_UKUR=$('#BENEFIT_TOLOK_UKUR').val();
			var BENEFIT_TARGET=$('#BENEFIT_TARGET').val();
			var OUTCOME_TOLOK_UKUR=$('#OUTCOME_TOLOK_UKUR').val();
			var OUTCOME_TARGET=$('#OUTCOME_TARGET').val();
			var dataPost={KDRENPROG:KDRENPROG, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, NMPRIORITAS:NMPRIORITAS, NMSASARAN_DAERAH:NMSASARAN_DAERAH, BENEFIT_TOLOK_UKUR:BENEFIT_TOLOK_UKUR, BENEFIT_TARGET:BENEFIT_TARGET, OUTCOME_TOLOK_UKUR:OUTCOME_TOLOK_UKUR, OUTCOME_TARGET:OUTCOME_TARGET};
			$.post("<?=base_url('skpd/'.$Pr.'_program/simpan')?>",dataPost,
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