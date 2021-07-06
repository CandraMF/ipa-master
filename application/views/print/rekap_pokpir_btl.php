<?php
	$qsts=$this->db->query("select if(tahapan=1,'Murni','Perubahan') as nmtahapan from dbsipd_".$_tahun.".__t_users where username='".$this->session->userdata('SESS_USERNAME')."'");	
	$thprow = $qsts->row();	
?>
<center><strong> 								
PEMERINTAH KABUPATEN SUBANG TAHUN <?=$_tahun?>	<br>
REKAP USULAN POKPIR BTL<br> Tahapan : <?=$thprow->nmtahapan?> </strong>	<br><br>							
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
		$i=1;$KDTAHAP=$_tahap;$JPAGU=0;
		$qry=$this->db->query("SELECT sum(a.PAGU) as PAGU, f.NMDEWAN FROM dbsipd_".$_tahun.".t_btl_cpcl AS a 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
		LEFT JOIN dbsipd_".$_tahun.".mrekr AS e ON a.MTGKEY=e.MTGKEY
		LEFT JOIN dbsipd_".$_tahun.".mdprd  AS f ON a.KDDEWAN=f.KDDEWAN where a.KDTAHAP='{$KDTAHAP}' and f.NMDEWAN!='' group by f.NMDEWAN order by f.NMDEWAN
		");
		
		
		$i=1;
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