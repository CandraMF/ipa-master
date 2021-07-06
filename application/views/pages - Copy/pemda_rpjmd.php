<?php
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	
	switch($Aksi){
		case "program":
			$row=$this->m_action->ambilData("select KDPRGRM, NMPRGRM, UNITKEY from dbsipd_".$_tahun.".t_rpjmd_pgrm where KDPRGRM='".$id."'");	
			$KDPRGRM=!empty($KDPRGRM)?$KDPRGRM:$row->KDPRGRM;
			$NMPRGRM=!empty($NMPRGRM)?$NMPRGRM:$row->NMPRGRM;
			$UNITKEY=!empty($UNITKEY)?$UNITKEY:$row->UNITKEY;
		break;
		case "skpd_pgrm":
			$UNITKEY=$id;
		break;
		case "kegiatan":
			$row=$this->m_action->ambilData("SELECT b.UNITKEY, a.KDPRGRM, b.NMPRGRM FROM  dbsipd_".$_tahun.".t_rpjmd_keg AS a INNER JOIN  dbsipd_".$_tahun.".t_rpjmd_pgrm AS b ON a.KDPRGRM=b.KDPRGRM WHERE a.KDKEGUNIT='".@$id."'");	
		
			$KDPRGRM=!empty($KDPRGRM)?$KDPRGRM:$row->KDPRGRM;
			$NMPRGRM=!empty($NMPRGRM)?$NMPRGRM:$row->NMPRGRM;
			$UNITKEY=!empty($UNITKEY)?$UNITKEY:$row->UNITKEY;
		break;
		
	}
	
	//// Program
	$Qry="SELECT KDPRGRM, NOPRGRM, NMPRGRM FROM dbsipd_".$_tahun.".t_rpjmd_pgrm WHERE UNITKEY='".@$UNITKEY."' ORDER BY NOPRGRM";
	$dt_pgrm=$this->m_auth->NaviPage($Qry, "PagePgrm", @$PagePgrm,"onchange=\"Fm.submit();\"");
	//// Kegiatan
	$Qry="SELECT a.KDKEGUNIT, a.NOKEG, a.NMKEG, b.NMPERPEKTIF FROM  dbsipd_".$_tahun.".t_rpjmd_keg AS a INNER JOIN  dbsipd_".$_tahun.".mjenis_perpektif AS b ON a.KDPERPEKTIF=b.KDPERPEKTIF WHERE a.KDPRGRM='".@$KDPRGRM."' ORDER BY a.NOKEG";
	$dt_keg=$this->m_auth->NaviPage($Qry, "PageKeg", @$PageKeg,"onchange=\"Fm.submit();\"");

?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>
<input type="hidden" name="KDPRGRM" value="<?=@$KDPRGRM?>">
<input type="hidden" name="NMPRGRM" value="<?=@$NMPRGRM?>">
<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
		 <!-- Data List Program -->
	  <div class="widget-content">		
		<div class="alert alert-info"><strong>Program  </strong></div>
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
					<td><?=$this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"select UNITKEY as '0', NMUNIT as '1' from dbsipd_".$_tahun.".mskpd where KDSTUNIT='2' order by KDUNIT","class='span12' onchange=\"Fm.KDPRGRM.value='';Fm.NMPRGRM.value='';Fm.submit();\"")?></td>
				</tr>
				</table>
			</td>
			<td align=right>
				<?=$dt_pgrm->FormPage?>
			</td>
		</tr>
		</table>

		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th width='50'>Kode</th>
			  <th>Uraian </th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		   
			<?php			
			$i=1;
			foreach ($dt_pgrm->query->result() as $row){
				$ClickData="Fm.KDPRGRM.value='".$row->KDPRGRM."';Fm.NMPRGRM.value='".$row->NMPRGRM."';Fm.submit();";
				echo "
				<tr>				
					<td>".$row->NOPRGRM."</td>
					<td onclick=\"{$ClickData}\"><a href='#'>".$row->NMPRGRM."</a></td>
					<td align=center style='width:100px;'>
					<p align=center>
						<a href='".base_url('login/pages/'.$Pr.'/program/edit/'.$row->KDPRGRM)."'  ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/program/hapus/".$row->KDPRGRM)."' ".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
					</p>
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
		if(!empty($KDPRGRM)){
	  ?>
	  <!-- Data List Kegiatan -->
	   <div class="widget-content">		
	    <div class="alert alert-info"><strong>Kegiatan</strong> [ <?=@$NMPRGRM?> ]</div>
		<table width='100%'>
		<tr>
			<td>
				<span class="label label-info" <?=$_pinsert?>>			
					<a href="<?=base_url('login/pages/'.$Pr.'/kegiatan/param/'.$KDPRGRM)?>"  style='color:white;padding:5px;' >
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
			  <th width='50'>Kode</th>
			  <th>Uraian</th>
			  <th>Perpektif</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		 
			<?php			
			$i=1;
			foreach ($dt_keg->query->result() as $row){
				echo "
				<tr>				
					<td>".$row->NOKEG."</td>
					<td>".$row->NMKEG."</td>
					<td>".$row->NMPERPEKTIF."</td>
					<td align=center style='width:100px;'>
					<p align=center>
						<a href='".base_url('login/pages/'.$Pr.'/kegiatan/edit/'.$row->KDKEGUNIT)."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/kegiatan/hapus/".$row->KDKEGUNIT)."' ".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
					</p>
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