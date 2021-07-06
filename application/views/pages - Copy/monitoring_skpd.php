<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>
<div class="control-group">
	<label class="control-label"></label>
	<div class="controls">			
		<a href="<?=base_url("login/cetak/".$Pr)?>" target='_blank'><button type="button" class="btn btn-primary">Cetak</button></a>
		<a href="<?=base_url("login/cetak/v".$Pr)?>" target='_blank'><button type="button" class="btn btn-primary">View</button></a>
	</div>
</div>
<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
	
	   <div class="widget-content">		
	   <!-- PROGRAM -->
	   <div class="alert alert-info"><strong>Jenis Rekening </strong> </div>
		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th rowspan=3>Kode SKPD</th>
			  <th rowspan=3>Nama SKPD</th>
			  <th colspan='7'>Renstra</th>
			  <th colspan='3'>Renja</th>
			  <th rowspan='3'>Pagu APBD</th>
		   </tr>
		   <tr>
			  <th rowspan=2>Jml Program</th>
			  <th rowspan=2>Jml Kegiatan</th>
			  <th colspan=5>Pagu</th>
			  <th rowspan=2>Jml Program</th>
			  <th rowspan=2>Jml Kegiatan</th>
			  <th rowspan=2>Pagu</th>
		   </tr>	
		   <tr>
			<th>Tahun 1</th>
			<th>Tahun 2</th>
			<th>Tahun 3</th>
			<th>Tahun 4</th>
			<th>Tahun 5</th>
		   </tr>
		  </thead>
		  <tbody>		   
			<?php			
			$i=1;
			$valid="";
				$Qry="SELECT TAHUN FROM dbsipd_".$_tahun.".t_renstra_dana WHERE PAGU>0 GROUP BY TAHUN ORDER BY TAHUN";
				$query = $this->db->query($Qry);$i=1;$FieldQry="";
				foreach ($query->result() as $row){
					if(5>=$i){
						$FieldQry.=", sum(if(TAHUN='".$row->TAHUN."',PAGU,0)) AS PAGU_".$i;
					}
						
					$i++;
				}

			//// Rekening
				$Qry="SELECT a.KDUNIT, a.NMUNIT, b.JMLRENST_PGRM, c.JMLRENST_KEG, d.PAGU_1, d.PAGU_2, d.PAGU_3, d.PAGU_4, d.PAGU_5, e.JMLRENJ_PRGRM, f.JMLRENJ_KEG, f.PAGU_RENJA, g.PAGU_SKPD FROM dbsipd_".$_tahun.".mskpd AS a 
				LEFT JOIN (SELECT UNITKEY, COUNT(*) AS JMLRENST_PGRM FROM dbsipd_".$_tahun.".t_renstra_pgrm GROUP BY UNITKEY) AS b ON a.UNITKEY=b.UNITKEY
				LEFT JOIN (SELECT UNITKEY, COUNT(*) as JMLRENST_KEG FROM dbsipd_".$_tahun.".t_renstra_keg GROUP BY UNITKEY) AS c ON a.UNITKEY=c.UNITKEY
				LEFT JOIN (SELECT UNITKEY ".$FieldQry." FROM dbsipd_".$_tahun.".t_renstra_dana GROUP BY UNITKEY) AS d ON a.UNITKEY=d.UNITKEY
				LEFT JOIN (SELECT a.UNITKEY, COUNT(*) AS JMLRENJ_PRGRM FROM (SELECT UNITKEY, KDPRGRM from dbsipd_".$_tahun.".t_kegiatan_keg GROUP BY UNITKEY, KDPRGRM) AS a GROUP BY a.UNITKEY) AS e ON a.UNITKEY=e.UNITKEY
				LEFT JOIN (SELECT UNITKEY, COUNT(*) AS JMLRENJ_KEG, SUM(PAGU) AS PAGU_RENJA from dbsipd_".$_tahun.".t_kegiatan_keg GROUP BY UNITKEY) AS f ON a.UNITKEY=f.UNITKEY
				LEFT JOIN (SELECT UNITKEY, PAGU AS PAGU_SKPD FROM dbsipd_".$_tahun.".t_pagu_skpd WHERE KDTAHAP='".$this->session->userdata('SESS_USERNAME')."') AS g ON a.UNITKEY=g.UNITKEY
				WHERE a.KDSTUNIT='3'
				ORDER BY a.KDUNIT";
				$query = $this->db->query($Qry);

				foreach ($query->result() as $row){
						
				echo "    
				<tr>	
					<td>".$row->KDUNIT."</td>
					<td>".$row->NMUNIT."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->JMLRENST_PGRM)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->JMLRENST_KEG)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU_1)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU_2)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU_3)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU_4)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU_5)."</td>		
					<td style='text-align:right;'>".$this->andri->cetakuang($row->JMLRENJ_PRGRM)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->JMLRENJ_KEG)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU_RENJA)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU_SKPD)."</td>
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
