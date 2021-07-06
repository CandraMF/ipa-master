<?php
	$qsts=$this->db->query("select if(tahapan=1,'Murni','Perubahan') as nmtahapan from dbsipd_".$_tahun.".__t_users where username='".$this->session->userdata('SESS_USERNAME')."'");	
	$thprow = $qsts->row();	
?>

<center><strong> 								
PEMERINTAH KABUPATEN SUBANG TAHUN <?=$_tahun?>	<br>
REKAP USULAN POKPIR BELANJA LANGSUNG  <br> Tahapan : <?=$thprow->nmtahapan?></strong>	<br><br>							
</center>
 <table class="table table-bordered table-striped with-check">
  <thead>
    <tr>			
	  <th>No</th>			  
	  <th>Dewan</th>
	  <th>Pagu</th>  	
   </tr>
  </thead>
  <tbody>		   
	<?php			
		$JENIS_CPCL="3";
		$i=1;$KDTAHAP=$_tahap;
		$qry=$this->db->query("SELECT sum(a.PAGU) AS PAGU,  g.NMDEWAN FROM dbsipd_".$_tahun.".t_kegiatan_cpcl AS a 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS f ON e.KDPRGRM=f.KDPRGRM		
		LEFT JOIN dbsipd_".$_tahun.".mdprd  AS g ON a.KDDEWAN=g.KDDEWAN where  g.NMDEWAN!='' and a.KDTAHAP='{$KDTAHAP}' group by g.NMDEWAN order by g.NMDEWAN
		");
		
		
		$i=1;$JPAGU=0;
		foreach ($qry->result() as $row){	
			if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
			{$TGLVALID="";}else{
				$TGLVALID=$row->TGLVALID;
			}
			echo "    
			<tr>	
				<td align=center>".$i.".</td>				
				<td>".$row->NMDEWAN."</td>
				<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU)."</td>
				
			</tr>
			";
			$JPAGU=$JPAGU+$row->PAGU;
			$i++;
		}
		echo "    
			<tr>	
				<td align=center colspan=2> <strong>Jumlah</strong></td>				
				<td style='text-align:right;'>".$this->andri->cetakuang($JPAGU)."</td>
				
			</tr>
			";
	?>
  </tbody>
</table>