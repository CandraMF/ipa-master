
<?php
	$qsts=$this->db->query("select if(tahapan=1,'Murni','Perubahan') as nmtahapan from dbsipd_".$_tahun.".__t_users where username='".$this->session->userdata('SESS_USERNAME')."'");	
	$thprow = $qsts->row();	
?>

<center><strong> 								
PEMERINTAH KABUPATEN SUBANG TAHUN <?=$_tahun?>	<br>
REKAP USULAN POKPIR BELANJA LANGSUNG & BELANJA TIDAK LANGSUNG  <br> Tahapan : <?=$thprow->nmtahapan?></strong>	<br><br>							
</center>
 <table class="table table-bordered table-striped with-check">
  <thead>
    <tr>			
	  <th>No</th>			  
	  <th>Dewan</th>
	  <th>Pagu BTL</th>  	
	  <th>Pagu BL</th>  	
	  <th>Jumlah</th>  	
   </tr>
  </thead>
  <tbody>		   
	<?php			
		$JENIS_CPCL="3";
		$i=1;$KDTAHAP=$_tahap;
		$qry=$this->db->query("SELECT * FROM (SELECT a.NODEWAN,a.KDDEWAN, a.NMDEWAN, if(isnull(b.PAGU_BTL),0,b.PAGU_BTL) AS PAGU_BTL, if(isnull(c.PAGU_BL),0,c.PAGU_BL) AS PAGU_BL, (if(isnull(b.PAGU_BTL),0,b.PAGU_BTL)+if(isnull(c.PAGU_BL),0,c.PAGU_BL)) AS JML FROM dbsipd_".$_tahun.".mdprd AS a
		LEFT JOIN (SELECT KDDEWAN, SUM(PAGU) AS PAGU_BTL from dbsipd_".$_tahun.".t_btl_cpcl WHERE KDTAHAP='{$KDTAHAP}' GROUP BY KDDEWAN) AS b ON a.KDDEWAN=b.KDDEWAN
		LEFT JOIN (SELECT KDDEWAN, SUM(PAGU) AS PAGU_BL from dbsipd_".$_tahun.".t_kegiatan_cpcl  WHERE KDTAHAP='{$KDTAHAP}' GROUP BY KDDEWAN) AS c ON a.KDDEWAN=c.KDDEWAN) AS z WHERE z.JML>0 ORDER BY z.NODEWAN ASC
		");
		
		
		
		$i=1;$JPAGU_BTL=0;$JPAGU_BL=0;$JJML=0;
		foreach ($qry->result() as $row){	
			if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
			{$TGLVALID="";}else{
				$TGLVALID=$row->TGLVALID;
			}
			echo "    
			<tr>	
				<td align=center>".$i.".</td>				
				<td>".$row->NMDEWAN."</td>
				<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU_BTL)."</td>
				<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU_BL)."</td>
				<td style='text-align:right;'>".$this->andri->cetakuang($row->JML)."</td>
				
			</tr>
			";
			$JPAGU_BTL=$JPAGU_BTL+$row->PAGU_BTL;
			$JPAGU_BL=$JPAGU_BL+$row->PAGU_BL;
			$JJML=$JJML+$row->JML;
			$i++;
		}
		echo "    
			<tr>	
				<td align=center colspan=2> <strong>Total</strong></td>				
				<td style='text-align:right;'>".$this->andri->cetakuang($JPAGU_BTL)."</td>
				<td style='text-align:right;'>".$this->andri->cetakuang($JPAGU_BL)."</td>
				<td style='text-align:right;'>".$this->andri->cetakuang($JJML)."</td>
				
			</tr>
			";
	?>
  </tbody>
</table>