<?php
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	
	$wh="";
	if(!empty($_idopd)){
		$UNITKEY=$_idopd;
		$wh=" and UNITKEY='".$UNITKEY."'";
	}
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
	
	//// Program
	$Qry="SELECT a.KDRENPROG, a.KDPRGRM, concat(b.NOPRGRM,' ',b.NMPRGRM) as NMPRGRM, a.NMPRIORITAS, a.NMSASARAN_DAERAH, a.BENEFIT_TOLOK_UKUR, a.BENEFIT_TARGET, a.OUTCOME_TOLOK_UKUR, a.OUTCOME_TARGET, a.TGLVALID FROM dbsipd_".$_tahun.".t_renstra_pgrm as a inner join dbsipd_".$_tahun.".t_rpjmd_pgrm as b on a.KDPRGRM=b.KDPRGRM  WHERE a.UNITKEY='".@$UNITKEY."'  ORDER BY b.NOPRGRM";
	$dt_pgrm=$this->m_auth->NaviPage($Qry, "PagePgrm", @$PagePgrm,"onchange=\"Fm.submit();\"");
	//// Kegiatan
	$Qry="SELECT a.KDRENSKEG,a.KDRENPROG, a.KDKEGUNIT, concat(b.NOKEG,'', b.NMKEG) as NMKEG, a.OUTPUT_TOLOK_UKUR, a.OUTPUT_TARGET, a.KETERANGAN, a.TARGET_5THN, a.DANA_5THN, a.TGLVALID FROM  dbsipd_".$_tahun.".t_renstra_keg AS a INNER JOIN  dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT WHERE a.KDPRGRM='".@$KDPRGRM."' AND a.UNITKEY='".@$UNITKEY."'  ORDER BY b.NOKEG";
	$dt_keg=$this->m_auth->NaviPage($Qry, "PageKeg", @$PageKeg,"onchange=\"Fm.submit();\"");

	//// Jumlah Dana
	$Qry="SELECT a.KDRENDANA, a.TAHUN,a.PERSEN, a.PAGU, a.KUANTITAS, a.SATUAN, a.KETERANGAN, a.TGLVALID FROM  dbsipd_".$_tahun.".t_renstra_dana AS a  WHERE a.KDRENSKEG='".@$KDRENSKEG."' AND a.UNITKEY='".@$UNITKEY."'   ORDER BY a.TAHUN";
	$dt_dana=$this->m_auth->NaviPage($Qry, "PageDana", @$PageDana,"onchange=\"Fm.submit();\"");
	
?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>
<input type="hidden" name="KDPRGRM" value="<?=@$KDPRGRM?>">
<input type="hidden" name="NMPRGRM" value="<?=@$NMPRGRM?>">
<input type="hidden" name="KDRENPROG" value="<?=@$KDRENPROG?>">

<input type="hidden" name="KDRENSKEG" value="<?=@$KDRENSKEG?>">
<input type="hidden" name="KDKEGUNIT" value="<?=@$KDKEGUNIT?>">
<input type="hidden" name="NMKEG" value="<?=@$NMKEG?>">
<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
	  <!-- Data List Program -->
	  <div class="widget-content">		
		
		<table width='100%' border=0>
		<tr>
			<td width='10'>
				<span class="label label-info" <?=$_pinsert?>>			
					<a href="<?=base_url('login/pages/'.$Pr.'/program/param/'.@$UNITKEY)?>"  style='color:white;padding:5px;' >
						<i class="icon icon-plus-sign"></i> Tambah
					</a>
				</span>
			</td>
			<td width='70%'>
				<table width='100%'>
				<tr>
					<td width='10'>Unit&nbsp;Organisasi&nbsp;: </td>
					<td><?=$this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"select UNITKEY as '0', CONCAT(KDUNIT,' ', NMUNIT) as '1' from dbsipd_".$_tahun.".mskpd where KDSTUNIT in ('3') and UNITKEY ".$_qryopd." order by KDUNIT","class='span12' onchange=\"Fm.KDPRGRM.value='';Fm.KDRENPROG.value='';Fm.KDRENSKEG.value='';Fm.NMPRGRM.value='';Fm.submit();\"")?></td>
				</tr>
				</table>
			</td>
			<td align=right>
				<?=$dt_pgrm->FormPage?>
			</td>
		</tr>
		</table>
		 <div class="alert alert-info"><strong>Program</strong></div>
		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th rowspan=3 style='width:300px;'>Program </th>
			  <th rowspan=3>Prioritas Daerah </th>
			  <th rowspan=3>Sasaran Daerah</th>
			  <th colspan=4>Indikator Kinerja</th>	
			  <th rowspan=3>Aksi</th>
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
			foreach ($dt_pgrm->query->result() as $row){
				$ClickData="Fm.KDPRGRM.value='".$row->KDPRGRM."';Fm.KDRENPROG.value='".$row->KDRENPROG."';Fm.KDRENSKEG.value='';Fm.NMPRGRM.value='".$row->NMPRGRM."';Fm.submit();";
				if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
				{$valid="";$TGLVALID="";}else{$valid="style='display:none;'";$TGLVALID=$row->TGLVALID;}

				
				echo "    
				<tr>					
					<td onclick=\"{$ClickData}\"><a href='#'>".$row->NMPRGRM."</a></td>
					<td>".$row->NMPRIORITAS."</td>
					<td>".$row->NMSASARAN_DAERAH."</td>
					<td>".$row->BENEFIT_TOLOK_UKUR."</td>
					<td>".$row->BENEFIT_TARGET."</td>
					<td>".$row->OUTCOME_TOLOK_UKUR."</td>
					<td>".$row->OUTCOME_TARGET."</td>
					<td align=center style='width:100px;'>
					<center ".$valid.">
						<a href='".base_url('login/pages/'.$Pr.'/program/edit/'.$row->KDRENPROG)."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/program/hapus/".$row->KDRENPROG)."' ".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
					</center>
					<center>".$TGLVALID."</center>
					</td>
				</tr>
				";
				$i++;
			}			
			?>
		  </tbody>
		</table>
		
	  </div>	

	  <?php
		 //////////////////// LIST KEGIATAN
		if(!empty($NMPRGRM)&&!empty($UNITKEY)){
	  ?>
	  <!-- Data List Kegiatan -->
	   <div class="widget-content">		
	    <div class="alert alert-info"><strong>Kegiatan</strong> [ <?=@$NMPRGRM?> ]</div>
		<table width='100%'>
		<tr>
			<td>
				<span class="label label-info" <?=$_pinsert?>>			
					<a href="<?=base_url('login/pages/'.$Pr.'/kegiatan/param/'.$KDRENPROG)?>"  style='color:white;padding:5px;' >
						<i class="icon icon-plus-sign"></i> Tambah
					</a>
				</span>
			</td>
			<td align=right>
				<?=$dt_keg->FormPage?>
			</td>
		</tr>
		</table>
		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>						
			  <th style='width:300px;' rowspan=2>Kegiatan</th>
			  <th colspan=2>Indikator Kinerja (Output)</th>
			  <th rowspan=2>Catatan Penting</th>
			  <th colspan=2>Prakiraan Maju Renja 5 Tahun Terakhir</th>
			  <th rowspan=2>Aksi</th>
			</tr>
			<tr>
			  <th>Tolok Ukur</th>
			  <th>Target</th>
			  <th>Target</th>
			  <th>Kebutuhan Dana/Pagu Indikatif (Rp.)</th>
			</tr>
		  </thead>
		  <tbody>		 
			<?php			
			$i=1;
			foreach ($dt_keg->query->result() as $row){
				$ClickData="Fm.KDRENSKEG.value='".$row->KDRENSKEG."';Fm.KDKEGUNIT.value='".$row->KDKEGUNIT."';Fm.NMKEG.value='".$row->NMKEG."';Fm.submit();";
				if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
				{$valid="";$TGLVALID="";}else{$valid="style='display:none;'";$TGLVALID=$row->TGLVALID;}
				echo "
				<tr>				
					<td onclick=\"{$ClickData}\"><a href='#'>".$row->NMKEG."</a></td>
					<td>".$row->OUTPUT_TOLOK_UKUR."</td>
					<td>".$row->OUTPUT_TARGET."</td>
					<td>".$row->KETERANGAN."</td>
					<td>".$row->TARGET_5THN."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->DANA_5THN)."</td>
					<td align=center style='width:100px;'>
					<center ".$valid.">
						<a href='".base_url('login/pages/'.$Pr.'/kegiatan/edit/'.$row->KDRENSKEG)."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/kegiatan/hapus/".$row->KDRENSKEG)."' ".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
					</center>
					<center>".$TGLVALID."</center>
					</td>
				</tr>
				";
				$i++;
			}			
			?>
		  </tbody>
		</table>
	  </div>
	  <?php } ?>


	  <?php
		 //////////////////// LIST JUMLAH DANA
		if(!empty($KDRENSKEG)&&!empty($UNITKEY)){
	  ?>
	  <!-- Data List Kegiatan -->
	   <div class="widget-content">		
	    <div class="alert alert-info"><strong>Daftar Target Pendanaan</strong> [ <?=@$NMKEG?> ]</div>
		<table width='100%'>
		<tr>
			<td>
				<!-- <span class="label label-info" <?=$_pinsert?>>			
					<a href="<?=base_url('login/pages/'.$Pr.'/dana/param/'.$KDRENSKEG)?>"  style='color:white;padding:5px;' >
						<i class="icon icon-plus-sign"></i> Tambah
					</a>
				</span> -->
			</td>
			<td align=right>
				<?=$dt_dana->FormPage?>
			</td>
		</tr>
		</table>
		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>						
			  <th>Tahun</th>
			  <th>Persen</th>
			  <th>Pagu</th>
			  <th>Kuantitas</th>
			  <th>Satuan</th>
			  <th>Keterangan</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		 
			<?php			
			$i=1;
			foreach ($dt_dana->query->result() as $row){
				if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
				{$valid="";}else{$valid="style='display:none;'";}
				echo "
				<tr>				
					<td>".$row->TAHUN."</td>
					<td style='text-align:right;'>".floatval($row->PERSEN)." %</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->KUANTITAS)."</td>				
					<td>".$row->SATUAN."</td>
					<td>".$row->KETERANGAN."</td>
					<td align=center style='width:100px;'>
					<center ".$valid.">
						<a href='".base_url('login/pages/'.$Pr.'/dana/edit/'.$row->KDRENDANA)."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/dana/hapus/".$row->KDRENDANA)."' ".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
					</center>
					</td>
				</tr>
				";
				$i++;
			}			
			?>
		  </tbody>
		</table>
	  </div>
	  <?php } ?>
</div>
</form>


