<?php

	$KDPRGRM=$this->uri->segment(6);
	$KDKEGUNIT=$this->uri->segment(7);	
	$UNITKEY=$this->uri->segment(8);	
	$KDTAHAP=$this->uri->segment(9);	
	$readonly="";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	$row = new stdClass();	
	$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".emon_81 where KDPRGRM='".$KDPRGRM."' and KDKEGUNIT='".$KDKEGUNIT."' and UNITKEY='".$UNITKEY."' and KDTAHAP='".$KDTAHAP."'");	

	$readonly=" readonly ";
	foreach($row as $key => $value){$$key = $this->andri->clean($value);}
	
?>
<form name=Fm id=Fm method=post action="#">
<input type="hidden" name="AksiData" id="AksiData" value="<?=@$AksiData?>">
<input type="hidden" name="KDPRGRM" id="KDPRGRM" value="<?=@$KDPRGRM?>">
<input type="hidden" name="KDKEGUNIT" id="KDKEGUNIT" value="<?=@$KDKEGUNIT?>">
<input type="hidden" name="KDTAHAP" id="KDTAHAP" value="<?=@$KDTAHAP?>">
<input type="hidden" name="UNITKEY" id="UNITKEY" value="<?=@$UNITKEY?>">



<div class="row-fluid">
	<div class="span6">
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>KEGIATAN</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">				
				<div class="control-group">
				  <label class="control-label">SKPD </label>
				  <div class="controls">					
					<?=$this->m_auth->cmbQuery('vUNITKEY',@$UNITKEY,"SELECT DISTINCT a.UNITKEY  as '0', concat(a.KDUNIT,' ' ,a.NMUNIT) as '1' FROM dbsipd_".$_tahun.".mskpd  AS a where a.KDSTUNIT='3' ORDER BY a.KDUNIT","onchange=\"Fm.submit();\" disabled")?>					
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label">Program</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('VKDPRGRM',@$KDPRGRM,"SELECT DISTINCT a.KDPRGRM  as '0', concat(a.NOPRGRM,' ' ,a.NMPRGRM) as '1' FROM dbsipd_".$_tahun.".t_rpjmd_pgrm  AS a  WHERE a.UNITKEY ='".@$URUSKEY."' or a.UNITKEY='203'  ORDER BY a.NOPRGRM","onchange=\"Fm.AksiData.value='BknData';Fm.submit();\" disabled")?>		
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Kegiatan</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('VKDKEGUNIT',@$KDKEGUNIT,"SELECT a.KDKEGUNIT as '0', concat(b.NOKEG,' ',b.NMKEG)as '1' FROM dbsipd_".$_tahun.".emon_80 AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT WHERE a.KDPRGRM='".@$KDPRGRM."' AND a.UNITKEY='".@$UNITKEY."'","disabled")?>			
				  </div>
				</div>
			
				<div class="control-group">
				  <label class="control-label">Sasaran :</label>
				  <div class="controls">				
					<textarea name="NMSASARAN" id="NMSASARAN" rows="5" cols="15"><?=@$NMSASARAN?></textarea>
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label">Indikator Kinerja Program (outcome)/ Kegiatan (output):</label>
				  <div class="controls">		
					<textarea name="INDIKATOR_KINERJA" id="INDIKATOR_KINERJA" rows="5" cols="15"><?=@$INDIKATOR_KINERJA?></textarea>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Keterangan :</label>
				  <div class="controls">				
					<textarea name="KETERANGAN" id="KETERANGAN" rows="5" cols="15"><?=@$KETERANGAN?></textarea>
				  </div>
				</div>
			</div>
		  </div>
		</div>
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<div style='font-weight:bold;'>Target Renstra Perangkat Daerah (Akhir Periode Renstra Perangkat Daerah)</div>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="TARGET_RENSTRA_K" id="TARGET_RENSTRA_K" value="<?=@$TARGET_RENSTRA_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='TARGET_RENSTRA_RP' id='TARGET_RENSTRA_RP' value="<?=@$TARGET_RENSTRA_RP?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
			</div>
		  </div>
		</div>

		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<div style='font-weight:bold;'>Realisasi Capaian Kinerja Renstra Perangkat Daerah sampai dengan Renja Perangkat Daerah Tahun Lalu(n-2)</div>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_RENSTRA_K_N2" id="REALISASI_RENSTRA_K_N2" value="<?=@$REALISASI_RENSTRA_K_N2?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_RENSTRA_RP_N2' id='REALISASI_RENSTRA_RP_N2' value="<?=@$REALISASI_RENSTRA_RP_N2?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
			</div>
		  </div>
		</div>

		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<div style='font-weight:bold;'>Target Kinerja dan Anggaran Renja Perangkat Daerah Tahun berjalan (Tahun n-1) yang dievaluasi</div>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="TARGET_RENJA_K" id="TARGET_RENJA_K" value="<?=@$TARGET_RENJA_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='TARGET_RENJA_RP' id='TARGET_RENJA_RP' value="<?=@$TARGET_RENJA_RP?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
			</div>
		  </div>
		</div>

		
	</div>
	
	<div class="span6">
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>Realisasi Kinerja Pada Triwulan</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label label label-warning'>Triwulan :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					I (Satu)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_KINERJA_K_1" id="REALISASI_KINERJA_K_1" value="<?=@$REALISASI_KINERJA_K_1?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_KINERJA_RP_1' id='REALISASI_KINERJA_RP_1' value="<?=@$REALISASI_KINERJA_RP_1?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
				<div class='control-group'>
				  <label class='control-label label label-warning'>Triwulan :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					II (Dua)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_KINERJA_K_2" id="REALISASI_KINERJA_K_2" value="<?=@$REALISASI_KINERJA_K_2?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_KINERJA_RP_2' id='REALISASI_KINERJA_RP_2' value="<?=@$REALISASI_KINERJA_RP_2?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Triwulan :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					III (Tiga)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_KINERJA_K_3" id="REALISASI_KINERJA_K_3" value="<?=@$REALISASI_KINERJA_K_3?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_KINERJA_RP_3' id='REALISASI_KINERJA_RP_3' value="<?=@$REALISASI_KINERJA_RP_3?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Triwulan :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					IV (Empat)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_KINERJA_K_4" id="REALISASI_KINERJA_K_4" value="<?=@$REALISASI_KINERJA_K_4?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_KINERJA_RP_4' id='REALISASI_KINERJA_RP_4' value="<?=@$REALISASI_KINERJA_RP_4?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				
			</div>
		  </div>
		</div>
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<div style='font-weight:bold;'>Realisasi Capaian Kinerja dan Anggaran Renja Perangkat Daerah yang dievaluasi</div>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_CAPAIAN_K" id="REALISASI_CAPAIAN_K" value="<?=@$REALISASI_CAPAIAN_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_CAPAIAN_RP' id='REALISASI_CAPAIAN_RP' value="<?=@$REALISASI_CAPAIAN_RP?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
			</div>
		  </div>
		</div>

		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<div style='font-weight:bold;'>Realisasi Kinerja dan Anggaran Renstra Perangkat Daerah (Akhir Tahun Pelaksanaan Renja Perangkat Daerah)</div>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_KINERJA_ANG_K" id="REALISASI_KINERJA_ANG_K" value="<?=@$REALISASI_KINERJA_ANG_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_KINERJA_ANG_RP' id='REALISASI_KINERJA_ANG_RP' value="<?=@$REALISASI_KINERJA_ANG_RP?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
			</div>
		  </div>
		</div>

		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<div style='font-weight:bold;'>Tingkat Capaian Kinerja Dan Realisasi Anggaran Renstra Perangkat Daerah (%)</div>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_KINERJA_ANG_PERSEN_K" id="REALISASI_KINERJA_ANG_PERSEN_K" value="<?=@$REALISASI_KINERJA_ANG_PERSEN_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_KINERJA_ANG_PERSEN_RP' id='REALISASI_KINERJA_ANG_PERSEN_RP' value="<?=@$REALISASI_KINERJA_ANG_PERSEN_RP?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>	
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>'">Kembali</button>	
				  </div>
				</div>
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
		
			var NMSASARAN=$('#NMSASARAN').val();
			var KDPRGRM=$('#KDPRGRM').val();
			var KDKEGUNIT=$('#KDKEGUNIT').val();
			
			var INDIKATOR_KINERJA=$('#INDIKATOR_KINERJA').val();
			var TARGET_RENSTRA_K=$('#TARGET_RENSTRA_K').val();
			var TARGET_RENSTRA_RP=$('#TARGET_RENSTRA_RP').val();
			var REALISASI_RENSTRA_K_N2=$('#REALISASI_RENSTRA_K_N2').val();
			var REALISASI_RENSTRA_RP_N2=$('#REALISASI_RENSTRA_RP_N2').val();
			var TARGET_RENJA_K=$('#TARGET_RENJA_K').val();
			var TARGET_RENJA_RP=$('#TARGET_RENJA_RP').val();
			var REALISASI_KINERJA_K_1=$('#REALISASI_KINERJA_K_1').val();
			var REALISASI_KINERJA_RP_1=$('#REALISASI_KINERJA_RP_1').val();
			var REALISASI_KINERJA_K_2=$('#REALISASI_KINERJA_K_2').val();
			var REALISASI_KINERJA_RP_2=$('#REALISASI_KINERJA_RP_2').val();
			var REALISASI_KINERJA_K_3=$('#REALISASI_KINERJA_K_3').val();
			var REALISASI_KINERJA_RP_3=$('#REALISASI_KINERJA_RP_3').val();
			var REALISASI_KINERJA_K_4=$('#REALISASI_KINERJA_K_4').val();
			var REALISASI_KINERJA_RP_4=$('#REALISASI_KINERJA_RP_4').val();
			var REALISASI_CAPAIAN_K=$('#REALISASI_CAPAIAN_K').val();
			var REALISASI_CAPAIAN_RP=$('#REALISASI_CAPAIAN_RP').val();
			var REALISASI_KINERJA_ANG_K=$('#REALISASI_KINERJA_ANG_K').val();
			var REALISASI_KINERJA_ANG_RP=$('#REALISASI_KINERJA_ANG_RP').val();
			var REALISASI_KINERJA_ANG_PERSEN_K=$('#REALISASI_KINERJA_ANG_PERSEN_K').val();
			var REALISASI_KINERJA_ANG_PERSEN_RP=$('#REALISASI_KINERJA_ANG_PERSEN_RP').val();
			var KETERANGAN=$('#KETERANGAN').val();
			var UNITKEY=$('#UNITKEY').val();
			var KDTAHAP=$('#KDTAHAP').val();
			
			
			  
			var dataPost={NMSASARAN:NMSASARAN, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, INDIKATOR_KINERJA:INDIKATOR_KINERJA, TARGET_RENSTRA_K:TARGET_RENSTRA_K, TARGET_RENSTRA_RP:TARGET_RENSTRA_RP, REALISASI_RENSTRA_K_N2:REALISASI_RENSTRA_K_N2, REALISASI_RENSTRA_RP_N2:REALISASI_RENSTRA_RP_N2, TARGET_RENJA_K:TARGET_RENJA_K, TARGET_RENJA_RP:TARGET_RENJA_RP, REALISASI_KINERJA_K_1:REALISASI_KINERJA_K_1, REALISASI_KINERJA_RP_1:REALISASI_KINERJA_RP_1, REALISASI_KINERJA_K_2:REALISASI_KINERJA_K_2, REALISASI_KINERJA_RP_2:REALISASI_KINERJA_RP_2, REALISASI_KINERJA_K_3:REALISASI_KINERJA_K_3, REALISASI_KINERJA_RP_3:REALISASI_KINERJA_RP_3, REALISASI_KINERJA_K_4:REALISASI_KINERJA_K_4, REALISASI_KINERJA_RP_4:REALISASI_KINERJA_RP_4, REALISASI_CAPAIAN_K:REALISASI_CAPAIAN_K, REALISASI_CAPAIAN_RP:REALISASI_CAPAIAN_RP, REALISASI_KINERJA_ANG_K:REALISASI_KINERJA_ANG_K, REALISASI_KINERJA_ANG_RP:REALISASI_KINERJA_ANG_RP, REALISASI_KINERJA_ANG_PERSEN_K:REALISASI_KINERJA_ANG_PERSEN_K, REALISASI_KINERJA_ANG_PERSEN_RP:REALISASI_KINERJA_ANG_PERSEN_RP, UNITKEY:UNITKEY, KDTAHAP:KDTAHAP, KETERANGAN:KETERANGAN};
			$.post("<?=base_url('emonev/'.$Pr.'/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				
			});

			
		
		});
	});	
</script>