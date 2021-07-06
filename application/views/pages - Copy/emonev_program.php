<?php
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	$KDTAHAP=$_tahap;
	switch($Aksi){
		case "program":
			$row=$this->m_action->ambilData("select a.KDRENPROG, a.KDPRGRM, concat(b.NOPRGRM,' ',b.NMPRGRM) as NMPRGRM, a.UNITKEY from dbsipd_".$_tahun.".t_renstra_pgrm as a inner join dbsipd_".$_tahun.".t_rpjmd_pgrm as b on a.KDPRGRM=b.KDPRGRM where a.KDRENPROG='".$id."' ");	
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}
		break;
		case "skpd_pgrm":
			$UNITKEY=$id;
		break;
		case "kegiatan":
			$row=$this->m_action->ambilData("SELECT a.KDRENSKEG, a.KDKEGUNIT, concat(c.NOKEG,' ',c.NMKEG) as NMKEG, a.KDRENPROG, a.UNITKEY, a.KDPRGRM, concat(b.NOPRGRM,' ',b.NMPRGRM) as NMPRGRM FROM  dbsipd_".$_tahun.".t_renstra_keg AS a INNER JOIN  dbsipd_".$_tahun.".t_rpjmd_pgrm AS b ON a.KDPRGRM=b.KDPRGRM inner join dbsipd_".$_tahun.".t_rpjmd_keg as c on a.KDKEGUNIT=c.KDKEGUNIT WHERE a.KDRENSKEG='".@$id."' ");		
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}
		break;

		case "dana":
			$row=$this->m_action->ambilData("SELECT a.KDRENDANA, a.KDRENPROG, a.KDRENSKEG, a.KDPRGRM, a.KDKEGUNIT, CONCAT(d.NOPRGRM,' ',d.NMPRGRM) as NMPRGRM, concat(e.NOKEG,' ',e.NMKEG) as NMKEG, a.UNITKEY FROM dbsipd_".$_tahun.".t_renstra_dana AS a INNER JOIN dbsipd_".$_tahun.".t_renstra_pgrm AS b ON a.KDRENPROG=b.KDRENPROG INNER JOIN dbsipd_".$_tahun.".t_renstra_keg AS c ON a.KDRENSKEG=c.KDRENSKEG INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS d ON a.KDPRGRM=d.KDPRGRM INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT WHERE a.KDRENDANA='".@$id."' ");
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}
		break;
		
	}
		
	$wh="";
	if(!empty($_idopd)){
		$UNITKEY=$_idopd;
		$wh=" and UNITKEY='".$UNITKEY."'";
	}
?>

<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>
<input type="hidden" name="KDTAHAP" id='KDTAHAP' value='<?=$KDTAHAP?>'>
<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
	  <!-- Data List Program -->
	  <div class="widget-content">		
		
		<table width='100%'>
		<tr>
			<td width='10'>Unit&nbsp;Organisasi&nbsp;: </td>
			<td><?=$this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"select UNITKEY as '0', CONCAT(KDUNIT,' ', NMUNIT) as '1' from dbsipd_".$_tahun.".mskpd where KDSTUNIT in ('3') and UNITKEY ".$_qryopd." order by KDUNIT","class='span12' onchange=\"Fm.KDPRGRM.value='';Fm.KDRENPROG.value='';Fm.KDRENSKEG.value='';Fm.NMPRGRM.value='';Fm.submit();\"")?></td>
		</tr>
		</table>
		 <div class="alert alert-info"><strong>Program</strong></div>
		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th rowspan=3 style='width:10px;'>No. </th>
			  <th rowspan=3 style='width:300px;'>Program </th>
			  <th rowspan=3>Prioritas Daerah </th>
			  <th rowspan=3>Sasaran Daerah</th>
			  <th colspan=4>Indikator Kinerja</th>	
			 
		   </tr>
		   <tr>
			  <th colspan=2>Capaian Program (Benefit)</th>
			  <th colspan=2>Program (Outcome)</th>			  
			</tr>
			<tr>
			  <th>Tolok Ukur</th>
			  <th>Target</th>
			  <th>Tolok Ukur</th>
			  <th>Target</th>
			</tr>
		  </thead>
		  <tbody>		   
			<?php			
			$i=1;
			$Qry="SELECT e.HASIL_MONITORING, e.PERSENTASE, a.KDPRGRM, a.KDRENPROG, a.KDPRGRM, b.NOPRGRM, b.NMPRGRM, c.NMPRIORITAS, d.NMSASARAN_DAERAH, a.BENEFIT_TOLOK_UKUR, a.BENEFIT_TARGET, a.OUTCOME_TOLOK_UKUR, a.OUTCOME_TARGET, a.TGLVALID FROM dbsipd_".$_tahun.".t_renstra_pgrm as a inner join dbsipd_".$_tahun.".t_rpjmd_pgrm as b on a.KDPRGRM=b.KDPRGRM LEFT JOIN dbsipd_".$_tahun.".mprioritas_daerah as c on a.KDPRIORITAS=c.KDPRIORITAS LEFT JOIN dbsipd_".$_tahun.".msasaran_derah AS d on a.KDSASARAN=d.KDSASARAN LEFT JOIN (SELECT KDPRGRM, HASIL_MONITORING, PERSENTASE FROM t_kegiatan_emonv_prog WHERE UNITKEY='".@$UNITKEY."' AND KDTAHAP='".@$KDTAHAP."') AS e on a.KDPRGRM=e.KDPRGRM WHERE a.UNITKEY='".@$UNITKEY."'  ORDER BY b.NOPRGRM";
	
			$dbqry=$this->db->query($Qry);
			foreach ($dbqry->result() as $row){
				
				echo "    
				<tr>					
					<td><strong style='color:red;'>".$row->NOPRGRM."</strong></td>
					<td><strong style='color:red;'>".$row->NMPRGRM."</strong></td>
					<td>".$row->NMPRIORITAS."</td>
					<td>".$row->NMSASARAN_DAERAH."</td>
					<td>".$row->BENEFIT_TOLOK_UKUR."</td>
					<td>".$row->BENEFIT_TARGET."</td>
					<td>".$row->OUTCOME_TOLOK_UKUR."</td>
					<td>".$row->OUTCOME_TARGET."</td>					
				</tr>
				<tr>				
					<td colspan=8 style='background-color:white;'>
						<table width='100%'>
						<tr>
							<td style='border:none;background-color:white;text-align:right;'>Monitorng</td>
							<td style='border:none;background-color:white;'>
								<input type='text'  id='HASIL_MONITORING{$i}' data-id='".$row->KDPRGRM."' value='".$row->HASIL_MONITORING."'  class='span14 HASIL_MONITORING'/>
							</td>
							<td style='border:none;background-color:white;text-align:right;width:10px;'>Prosentase</td>
							<td style='border:none;background-color:white;width:10px;'>							
								".$this->m_auth->cmbQuery('PERSENTASE',@$row->PERSENTASE,"select PERSENTASE as '0', concat(PERSENTASE,'%') as '1' from dbsipd_".$_tahun.".e_persentase","data-id='".@$row->KDPRGRM."' class='cmbAksi' style='width:80px;'")."
							</td>
							
						</tr>
						</table>
					</td>					
				</tr>
				";
				$i++;
			}			
			?>
		  </tbody>
		</table>
	  </div>	
</div>
</form>

<script type="text/javascript">	
	$( document ).ready(function() {	
		
		$('.cmbAksi').change(function(){	
			var KDTAHAP=$('#KDTAHAP').val();
			var UNITKEY=$('#UNITKEY').val();		
			var KDPRGRM=$(this).attr("data-id");						
			var PERSENTASE=$(this).val();			

			
			var dataPost={KDTAHAP:KDTAHAP,  UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, PERSENTASE:PERSENTASE};
			$.post("<?=base_url('emonev/program_persentase/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				setTimeout(function(){ $('#InfoConfirm').modal('hide'); }, 1000);
			});
		});

		$('.HASIL_MONITORING').change(function(){	
			/* PAGU KEGIATAN SKPD */			
			var KDTAHAP=$('#KDTAHAP').val();
			var UNITKEY=$('#UNITKEY').val();		
			var KDPRGRM=$(this).attr("data-id");			
			var HASIL_MONITORING=$(this).val();			

			var dataPost={KDTAHAP:KDTAHAP,  UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, HASIL_MONITORING:HASIL_MONITORING};
			$.post("<?=base_url('emonev/program_monitoring/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				 
				setTimeout(function(){ $('#InfoConfirm').modal('hide'); }, 1000);
			});		
		});
	});
</script>