<?php

	$KDPRGRM=$this->uri->segment(6);

	$KDKEGUNIT=$this->uri->segment(7);	
		
	$UNITKEY=$this->uri->segment(8);	
	$KDTAHAP=$this->uri->segment(9);	
	$readonly="";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	$row = new stdClass();	
	$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".emon_80 where KDPRGRM='".$KDPRGRM."' and KDKEGUNIT='".$KDKEGUNIT."' and UNITKEY='".$UNITKEY."' and KDTAHAP='".$KDTAHAP."'");	

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
				  <label class="control-label">Indikator Kinerja :</label>
				  <div class="controls">				
					<textarea name="INDIKATOR_KINERJA" id="INDIKATOR_KINERJA" rows="5" cols="15"><?=@$INDIKATOR_KINERJA?></textarea>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Data Capaian Awal Tahun Perencanaan  :</label>
				  <div class="controls">	
					<textarea name="CAPAIAN_AWAL_THN" id="CAPAIAN_AWAL_THN" rows="5" cols="15"><?=@$CAPAIAN_AWAL_THN?></textarea>
					
				  </div>
				</div>
			</div>
		  </div>
		</div>
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>Target Capaian Akhir Tahun Perencanaan</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="CAPAIAN_AKHIR_THN_K" id="CAPAIAN_AKHIR_THN_K" value="<?=@$CAPAIAN_AKHIR_THN_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='CAPAIAN_AKHIR_THN_RP' id='CAPAIAN_AKHIR_THN_RP' value="<?=@$CAPAIAN_AKHIR_THN_RP?>"  class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>			
				
			</div>
		  </div>
		</div>
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>Target Renstra Perangkat Daerah Kab/Kota</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					1 (Satu)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RENSTRA_1_K" id="RENSTRA_1_K" value="<?=@$RENSTRA_1_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RENSTRA_1_RP' id='RENSTRA_1_RP' value="<?=@$RENSTRA_1_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					2 (Dua)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RENSTRA_2_K" id="RENSTRA_2_K" value="<?=@$RENSTRA_2_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RENSTRA_2_RP' id='RENSTRA_2_RP' value="<?=@$RENSTRA_2_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					3 (Tiga)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RENSTRA_3_K" id="RENSTRA_3_K" value="<?=@$RENSTRA_3_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RENSTRA_3_RP' id='RENSTRA_3_RP' value="<?=@$RENSTRA_3_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					4 (Empat)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RENSTRA_4_K" id="RENSTRA_4_K" value="<?=@$RENSTRA_4_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RENSTRA_4_RP' id='RENSTRA_4_RP' value="<?=@$RENSTRA_4_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					5 (Lima)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RENSTRA_5_K" id="RENSTRA_5_K" value="<?=@$RENSTRA_5_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RENSTRA_5_RP' id='RENSTRA_5_RP' value="<?=@$RENSTRA_5_RP?>" class='span7' >
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
			<h5>Realisasi Capaian</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					1 (Satu)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_1_K" id="REALISASI_1_K" value="<?=@$REALISASI_1_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_1_RP' id='REALISASI_1_RP' value="<?=@$REALISASI_1_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					2 (Dua)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_2_K" id="REALISASI_2_K" value="<?=@$REALISASI_2_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_2_RP' id='REALISASI_2_RP' value="<?=@$REALISASI_2_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					3 (Tiga)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_3_K" id="REALISASI_3_K" value="<?=@$REALISASI_3_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_3_RP' id='REALISASI_3_RP' value="<?=@$REALISASI_3_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					4 (Empat)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_4_K" id="REALISASI_4_K" value="<?=@$REALISASI_4_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_4_RP' id='REALISASI_4_RP' value="<?=@$REALISASI_4_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					5 (Lima)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="REALISASI_5_K" id="REALISASI_5_K" value="<?=@$REALISASI_5_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='REALISASI_5_RP' id='REALISASI_5_RP' value="<?=@$REALISASI_5_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>
			</div>
				
				
			</div>
		  </div>
		</div>
	</div>

	<div class="span6">
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>Rasio Capaian</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<div class="control-group form-horizontal">
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					1 (Satu)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RASIO_1_K" id="RASIO_1_K" value="<?=@$RASIO_1_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RASIO_1_RP' id='RASIO_1_RP' value="<?=@$RASIO_1_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>		
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					2 (Dua)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RASIO_2_K" id="RASIO_2_K" value="<?=@$RASIO_2_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RASIO_2_RP' id='RASIO_2_RP' value="<?=@$RASIO_2_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					3 (Tiga)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RASIO_3_K" id="RASIO_3_K" value="<?=@$RASIO_3_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RASIO_3_RP' id='RASIO_3_RP' value="<?=@$RASIO_3_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					4 (Empat)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RASIO_4_K" id="RASIO_4_K" value="<?=@$RASIO_4_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RASIO_4_RP' id='RASIO_4_RP' value="<?=@$RASIO_4_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
				</div>	
				<div class='control-group'>
				  <label class='control-label label label-warning'>Tahun :</label>
				  <label class='control-label label label-info' style='text-align:left;padding-left:14px;'>				
					5 (Lima)
				  </label>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Kinerja :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type="text"  name="RASIO_5_K" id="RASIO_5_K" value="<?=@$RASIO_5_K?>"  class='span12'/>
					  </div>
				   </div>
				</div>
				<div class='control-group'>
				  <label class='control-label'>Nilai :</label>				  
				  <div class='controls'>
					 <div class='input-append'>
					  <input type='text' placeholder='numeric' name='RASIO_5_RP' id='RASIO_5_RP' value="<?=@$RASIO_5_RP?>" class='span7' >
					  <span class='add-on'>Rp</span> </div>
				   </div>
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
			var CAPAIAN_AWAL_THN=$('#CAPAIAN_AWAL_THN').val();
			var CAPAIAN_AKHIR_THN_K=$('#CAPAIAN_AKHIR_THN_K').val();
			var CAPAIAN_AKHIR_THN_RP=$('#CAPAIAN_AKHIR_THN_RP').val();
			var RENSTRA_1_K=$('#RENSTRA_1_K').val();
			var RENSTRA_1_RP=$('#RENSTRA_1_RP').val();
			var RENSTRA_2_K=$('#RENSTRA_2_K').val();
			var RENSTRA_2_RP=$('#RENSTRA_2_RP').val();
			var RENSTRA_3_K=$('#RENSTRA_3_K').val();
			var RENSTRA_3_RP=$('#RENSTRA_3_RP').val();
			var RENSTRA_4_K=$('#RENSTRA_4_K').val();
			var RENSTRA_4_RP=$('#RENSTRA_4_RP').val();
			var RENSTRA_5_K=$('#RENSTRA_5_K').val();
			var RENSTRA_5_RP=$('#RENSTRA_5_RP').val();
			var REALISASI_1_K=$('#REALISASI_1_K').val();
			var REALISASI_1_RP=$('#REALISASI_1_RP').val();
			var REALISASI_2_K=$('#REALISASI_2_K').val();
			var REALISASI_2_RP=$('#REALISASI_2_RP').val();
			var REALISASI_3_K=$('#REALISASI_3_K').val();
			var REALISASI_3_RP=$('#REALISASI_3_RP').val();
			var REALISASI_4_K=$('#REALISASI_4_K').val();
			var REALISASI_4_RP=$('#REALISASI_4_RP').val();
			var REALISASI_5_K=$('#REALISASI_5_K').val();
			var REALISASI_5_RP=$('#REALISASI_5_RP').val();
			var RASIO_1_K=$('#RASIO_1_K').val();
			var RASIO_1_RP=$('#RASIO_1_RP').val();
			var RASIO_2_K=$('#RASIO_2_K').val();
			var RASIO_2_RP=$('#RASIO_2_RP').val();
			var RASIO_3_K=$('#RASIO_3_K').val();
			var RASIO_3_RP=$('#RASIO_3_RP').val();
			var RASIO_4_K=$('#RASIO_4_K').val();
			var RASIO_4_RP=$('#RASIO_4_RP').val();
			var RASIO_5_K=$('#RASIO_5_K').val();
			var RASIO_5_RP=$('#RASIO_5_RP').val();
			var UNITKEY=$('#UNITKEY').val();
			var KDTAHAP=$('#KDTAHAP').val();
			
			  
			var dataPost={NMSASARAN:NMSASARAN, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, INDIKATOR_KINERJA:INDIKATOR_KINERJA, CAPAIAN_AWAL_THN:CAPAIAN_AWAL_THN, CAPAIAN_AKHIR_THN_K:CAPAIAN_AKHIR_THN_K, CAPAIAN_AKHIR_THN_RP:CAPAIAN_AKHIR_THN_RP, RENSTRA_1_K:RENSTRA_1_K, RENSTRA_1_RP:RENSTRA_1_RP, RENSTRA_2_K:RENSTRA_2_K, RENSTRA_2_RP:RENSTRA_2_RP, RENSTRA_3_K:RENSTRA_3_K, RENSTRA_3_RP:RENSTRA_3_RP, RENSTRA_4_K:RENSTRA_4_K, RENSTRA_4_RP:RENSTRA_4_RP, RENSTRA_5_K:RENSTRA_5_K, RENSTRA_5_RP:RENSTRA_5_RP, REALISASI_1_K:REALISASI_1_K, REALISASI_1_RP:REALISASI_1_RP, REALISASI_2_K:REALISASI_2_K, REALISASI_2_RP:REALISASI_2_RP, REALISASI_3_K:REALISASI_3_K, REALISASI_3_RP:REALISASI_3_RP, REALISASI_4_K:REALISASI_4_K, REALISASI_4_RP:REALISASI_4_RP, REALISASI_5_K:REALISASI_5_K, REALISASI_5_RP:REALISASI_5_RP, RASIO_1_K:RASIO_1_K, RASIO_1_RP:RASIO_1_RP, RASIO_2_K:RASIO_2_K, RASIO_2_RP:RASIO_2_RP, RASIO_3_K:RASIO_3_K, RASIO_3_RP:RASIO_3_RP, RASIO_4_K:RASIO_4_K, RASIO_4_RP:RASIO_4_RP, RASIO_5_K:RASIO_5_K, RASIO_5_RP:RASIO_5_RP, UNITKEY:UNITKEY, KDTAHAP:KDTAHAP};
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