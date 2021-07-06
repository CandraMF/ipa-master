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
	   <!-- rincian kegiatan opd -->
	   <div class="alert alert-info"><strong>Jenis Rekening </strong> </div>
		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th >Kode Program</th>
			  <th >Kode Keg Unit</th>
			  <th >Kegiatan</th>
			  <th >Sasaran</th>
              <th >Target</th>
              <th >Satuan</th>
			  <th >Pagu</th>
		   </tr>
		  </thead>
		  <tbody>		   
			<?php			
			
			//// Rekening
				$Qry="SELECT a.KDPRGRM,a.KDKEGUNIT,a.KEGIATAN_PRIORITAS AS Keg,a.SASARAN_KEGIATAN as sas,a.TARGET as target,a.SATUAN as satuan,a.PAGU as pagu FROM t_kegiatan_keg AS a 
                LEFT JOIN (SELECT KDPRGRM, NMPRGRM AS NAMA_PROGRAM FROM dbsipd_2020.t_rpjmd_pgrm) AS b on a.KDPRGRM = b.KDPRGRM
                LEFT JOIN (SELECT NMKEG AS NAMA_KEG, KDPRGRM FROM dbsipd_2020.t_rpjmd_keg) AS c on b.KDPRGRM = c.KDPRGRM WHERE a.UNITKEY=183;";
				$query = $this->db->query($Qry);

				foreach ($query->result() as $row){
						
				/*echo "    
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
					<td style='text-align:center;'>N/A</td>
					<td style='text-align:center;'>N/A</td>
				</tr>
                ";*/
                echo "    
				<tr>	
					<td style='text-align:right;'>".$this->andri->cetakuang($row->NAMA_PROGRAM)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->NAMA_KEG)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->.Keg)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->.sas)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->.target)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->.satuan)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->.pagu)."</td>		
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
