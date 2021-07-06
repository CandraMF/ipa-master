<?php
	$KDTAHAP=$_tahap;
	$JVERIFIKASI=$this->uri->segment(4);			
	$KDBIDANG=$this->uri->segment(5);			
	$KDSUBBIDANG=$this->uri->segment(6);			
	$row=$this->m_action->ambilData("select NMBIDANG from dbsipd_".$_tahun.".mbidang where KDBIDANG='".$KDBIDANG."'");		
	foreach($row as $key => $value){$$key = $this->andri->clean($value);}


	$text="";
	$wh="";
	
	$whm=$JVERIFIKASI==1?" AND month(a.TGLVALID)>0 ":" AND (a.TGLVALID IS NULL OR a.TGLVALID='0000-00-00')";
	
	$i=1;
	$qm=$this->db->query("SELECT distinct a.UNITKEY, b.AKRONIM FROM dbsipd_".$_tahun.".mbidang_skpd as a inner join dbsipd_".$_tahun.".mskpd as b on a.UNITKEY=b.UNITKEY WHERE KDBIDANG ='{$KDBIDANG}' ".$wh." ORDER BY b.KDUNIT ASC ");$field="";
	$th="";$td="";
	foreach ($qm->result() as $isi){
		$field.=", SUM(if(a.UNITKEY='".$isi->UNITKEY."', a.PAGU,0)) AS NILAI_".$i;
		$td.="<td style='text-align:right;width:10%;'>[+]xthis->andri->cetakuang([|]row->NILAI_".$i.")[-]</td>";
		$th.="<th>".$isi->AKRONIM."</th>";
		$i++;	
	}
	$td=str_replace("[+]",'".$',$td);
	$td=str_replace("[-]",'."',$td);
	$td=str_replace("[|]",'$',$td);
	$td=str_replace("xthis",'this',$td);

	$KETJUDUL=$JVERIFIKASI==1?" PRIORITAS KECAMATAN MENURUT PERANGKAT DAERAH ":" REKAPITULASI KEGIATAN YANG BELUM DI SEPAKATI ";
?>


<center><strong>DAFTAR <?=$KETJUDUL?> (LAMPIRAN II)<br>									
SEBAGAI BAHAN MUSRENBANG RKPD KABUPATEN SUBANG TAHUN <?=$_tahun?>	<br>							
LINGKUP BIDANG <?=$NMBIDANG?> </strong>	<br><br>							
</center>
 <table class="table table-bordered table-striped with-check">
  <thead>
   <tr>			
	  <th rowspan=2 style='padding-bottom:20px;'>No</th>			  
	  <th rowspan=2 style='padding-bottom:20px;'>Nama Kecamatan</th>			  
	  <th colspan='<?=$i-1?>'>Perangkat Daerah</th>		
	  <th rowspan=2 style='padding-bottom:20px;'>Jumlah</th>
	</tr>
	<tr>
	  <?=$th?>	  			  
   </tr>
  </thead>
  <tbody>		   
	<?php			
		

		$qry=$this->db->query("SELECT  b.NMUNIT ".$field." , sum(a.PAGU) AS PAGU FROM dbsipd_".$_tahun.".t_kegiatan_cpcl AS a
		INNER JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY
		 WHERE a.KDTAHAP='{$KDTAHAP}' AND a.UNITKEY IN (SELECT UNITKEY FROM dbsipd_".$_tahun.".mbidang_skpd WHERE KDBIDANG ='{$KDBIDANG}' ".$wh.") AND a.JENIS_CPCL IN (1,3) ".$whm." 
		 GROUP BY b.NMUNIT  WITH ROLLUP");
		
		$i=1;$KECAMATAN="";
		foreach ($qry->result() as $row){	
		

			
			@eval("\$data = \"$td\";");
			IF(!empty($row->NMUNIT)){
				echo "    
				<tr>					
					<td align=center>".$i.".</td>			
					<td>".$row->NMUNIT."</td>					
					".$data."
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU)."</td>		
				</tr>
				";
			}else{
				echo "    
				<tr style='font-weight:bold;'>					
					<td colspan=2 style='text-align:right;'>Jumlah</td>					
					".$data."
					<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU)."</td>		
				</tr>
				";
			}
			
			$i++;
		}
	?>
  </tbody>
</table>