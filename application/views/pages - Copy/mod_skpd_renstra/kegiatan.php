<?php
	$readonly="";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".t_renstra_keg where KDRENSKEG='".$id."'");			
			$readonly=" readonly ";
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}
		break;
		case "hapus":	
			$row=$this->m_action->ambilData("select a.KDRENPROG FROM dbsipd_".$_tahun.".t_renstra_keg as a where a.KDRENSKEG='".$id."'");
			$qry="delete from dbsipd_".$_tahun.".t_renstra_dana where KDRENSKEG='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_renstra_dana","KDRENSKEG", $id);
			$qry="delete from dbsipd_".$_tahun.".t_renstra_keg where KDRENSKEG='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_renstra_keg","KDRENSKEG", $id);
			header("location:".base_url('login/pages/'.$Pr.'/list/program/'.$row->KDRENPROG));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".t_renstra_keg");		
			}else{				
				$row=$this->m_action->ambilData("SELECT KDRENPROG,  UNITKEY, KDPRGRM FROM dbsipd_".$_tahun.".t_renstra_pgrm WHERE KDRENPROG='".@$id."'");
				foreach($row as $key => $value){$$key = $this->andri->clean($value);}

				if(empty($id)){
					header("location:".base_url('login/pages/'.$Pr));
				}
			}
	}
	
?>
<form name=Fm id=Fm method=post action="#">
<div class="row-fluid">
	<div class="span6">
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>KEGIATAN</h5>		
		  </div>
		  <div class="widget-content">
				<div class="control-group">
				  <label class="control-label">Kegiatan :</label>
				  <div class="controls">				
					<?=$this->m_auth->cmbQuery('KDKEGUNIT',@$row->KDKEGUNIT,"select KDKEGUNIT as '0', concat(NOKEG,' ',NMKEG) as '1' from dbsipd_".$_tahun.".t_rpjmd_keg where KDPRGRM IN (SELECT KDPRGRM FROM dbsipd_".$_tahun.".t_renstra_pgrm WHERE KDRENPROG='{$KDRENPROG}')")?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Tolok Ukur (Output) :</label>
				  <div class="controls">				
					<input type="text"  name="OUTPUT_TOLOK_UKUR" id="OUTPUT_TOLOK_UKUR" value="<?=@$OUTPUT_TOLOK_UKUR?>"  class='span12' />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Target (Output) :</label>
				  <div class="controls">				
					<input type="text"  name="OUTPUT_TARGET" id="OUTPUT_TARGET" value="<?=@$OUTPUT_TARGET?>"  class='span12' />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Target (5 Tahun Terakhir) :</label>
				  <div class="controls">				
					<input type="text"  name="TARGET_5THN" id="TARGET_5THN" value="<?=@$TARGET_5THN?>"  class='span12' />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Dana (5 Tahun Terakhir) :</label>
				  <div class="controls">
					 <div class="input-append">					 
					  <input type="text" placeholder='numeric' name="DANA_5THN" id="DANA_5THN" value="<?=floatval(@$DANA_5THN)?>" class="span7">
					  <span class="add-on">Rp</span> </div>
				   </div>				
				</div>				
				<div class="control-group">
				  <label class="control-label">Keterangan :</label>
				  <div class="controls">
					<input type="text"  name="KETERANGAN" id="KETERANGAN" value="<?=@$KETERANGAN?>"  class='span12'/>
				  </div>
				</div>	
				<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>'">Kembali</button>
				<input type="hidden" name="KDRENSKEG" id="KDRENSKEG" value="<?=@$KDRENSKEG?>">
				<input type="hidden" name="KDRENPROG" id="KDRENPROG" value="<?=@$KDRENPROG?>">
				<input type="hidden" name="UNITKEY" id="UNITKEY" value="<?=@$UNITKEY?>">
				<input type="hidden" name="KDPRGRM" id="KDPRGRM" value="<?=@$KDPRGRM?>">				
		  </div>
		</div>
		
	</div>
	
	<div class="span6">
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>Kinerja Kegiatan</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<?php
					$query=$this->db->query("SELECT b.KDRENDANA, a.TAHUN, b.PERSEN, b.PAGU, b.KUANTITAS, b.SATUAN, b.KETERANGAN FROM dbsipd_".$_tahun.".mtahun AS a LEFT JOIN (SELECT KDRENDANA, TAHUN, PERSEN, PAGU, KUANTITAS, SATUAN, KETERANGAN from dbsipd_".$_tahun.".t_renstra_dana WHERE  UNITKEY='{$UNITKEY}' AND KDPRGRM='{$KDPRGRM}' AND KDKEGUNIT='{$KDKEGUNIT}') AS b ON a.TAHUN=b.TAHUN");
					$i=1;
					foreach ($query->result_array() as $row){
						echo "
							<input type='hidden' id='KDRENDANA{$i}' value='".@$row['KDRENDANA']."'>
							<input type='hidden' id='TAHUN{$i}' value='".@$row['TAHUN']."'>
							
							<div class='control-group'>
							 <label class='control-label label label-warning'>Tahun :</label>
							 <label class='control-label label label-info'>				
								{$row['TAHUN']}
							  </label>
							</div>
							<div class='control-group'>
							  <label class='control-label'>Persen :</label>
							  <div class='controls'>
								 <div class='input-append'>
								  <input type='text' placeholder='numeric' name='PERSEN' id='PERSEN".$i."' value='".floatval(@$row['PERSEN'])."' class='span3'>
								  <span class='add-on'>%</span> </div>
							   </div>
							</div>
							<div class='control-group'>
							  <label class='control-label'>Pagu :</label>				  
							  <div class='controls'>
								 <div class='input-append'>
								  <input type='text' placeholder='numeric' name='PAGU' id='PAGU".$i."' value='".floatval(@$row['PAGU'])."' class='span7'>
								  <span class='add-on'>Rp</span> </div>
							   </div>
							</div>
							<div class='control-group'>
							  <label class='control-label'>Kuantitas :</label>
							  <div class='controls'>				
								<input type='text'  name='KUANTITAS' id='KUANTITAS".$i."' value='".floatval(@$row['KUANTITAS'])."'  class='span6' placeholder='numeric' />
							  </div>
							</div>
							<div class='control-group'>
							  <label class='control-label'>Satuan :</label>
							  <div class='controls'>				
								<input type='text'  name='SATUAN' id='SATUAN".$i."' value='".@$row['SATUAN']."'  class='span6' />
							  </div>
							</div>				
							<div class='control-group'>
							  <label class='control-label'>Keterangan :</label>
							  <div class='controls'>
								<input type='text'  name='KET_DANA' id='KET_DANA".$i."' value='".@$row['KETERANGAN']."'  class='span12'/>
							  </div>
							</div>	
						";
						$i++;
					}
				?>
				<input type="hidden" name="JMLDANA" id="JMLDANA" value='<?=($i-1)?>'>
			</div>
		  </div>
		</div>
	</div>
	
</div>

</form>	
<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var KDRENSKEG=$('#KDRENSKEG').val();
			var KDRENPROG=$('#KDRENPROG').val();
			var UNITKEY=$('#UNITKEY').val();
			var KDPRGRM=$('#KDPRGRM').val();
			var KDKEGUNIT=$('#KDKEGUNIT').val();			
			var OUTPUT_TOLOK_UKUR=$('#OUTPUT_TOLOK_UKUR').val();
			var OUTPUT_TARGET=$('#OUTPUT_TARGET').val();
			var TARGET_5THN=$('#TARGET_5THN').val();
			var DANA_5THN=$('#DANA_5THN').val();
			var KETERANGAN=$('#KETERANGAN').val();
			
			  
			var dataPost={KDRENSKEG:KDRENSKEG, KDRENPROG:KDRENPROG, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, OUTPUT_TOLOK_UKUR:OUTPUT_TOLOK_UKUR, OUTPUT_TARGET:OUTPUT_TARGET, TARGET_5THN:TARGET_5THN, DANA_5THN:DANA_5THN, KETERANGAN:KETERANGAN};
			$.post("<?=base_url('skpd/'.$Pr.'_kegiatan/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				
			});

			/* PAGU KEGIATAN DANA */
			var i =1;
			var JMLDANA=$('#JMLDANA').val();
			while(JMLDANA>=i){
				var KDRENDANA=$('#KDRENDANA'+i).val();
			
				
				var TAHUN=$('#TAHUN'+i).val();
				var PERSEN=$('#PERSEN'+i).val();
				var PAGU=$('#PAGU'+i).val();
				var KUANTITAS=$('#KUANTITAS'+i).val();
				var SATUAN=$('#SATUAN'+i).val();
				var KET_DANA=$('#KET_DANA'+i).val();
				
				  
				var dataPost={KDRENDANA:KDRENDANA, KDRENSKEG:KDRENSKEG, KDRENPROG:KDRENPROG, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, TAHUN:TAHUN, PERSEN:PERSEN, PAGU:PAGU, KUANTITAS:KUANTITAS, SATUAN:SATUAN, KETERANGAN:KET_DANA};
				$.post("<?=base_url('skpd/'.$Pr.'_dana/simpan')?>",dataPost,
				function(data){	
					var data = $.parseJSON( data );		
					$('#InfoConfirm').modal('show'); 
					if(data.status=='success')
					{$('#txtinfo').html('Berhasil di simpan');}
					else
					{$('#txtinfo').html('Gagal di simpan');}
					
				});
				i++;
			}
			
			<?php if($Aksi!='param'){ ?>
			setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>"; }, 1000);
			<?php }else{ ?>
			setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/program/'.$id)?>"; }, 1000);		
			<?php } ?>
		
		});
	});	
</script>