<?php
	$KDTAHAP=$_tahap;
	$JENIS_CPCL=$this->uri->segment(4);			

	$JVERIFIKASI=$this->uri->segment(5);	
	$IDKEC=$this->uri->segment(6);			
		



	$wh="";
	$wh=!empty($IDKEC)?" AND a.IDKEC='{$IDKEC}'":"";
	
	$i=1;


	$KETJUDUL=$JVERIFIKASI==1?" PRIORITAS KECAMATAN MENURUT PERANGKAT DAERAH ":" REKAPITULASI KEGIATAN YANG BELUM DI SEPAKATI ";
?>


<center><strong> DAFTAR <?=$KETJUDUL?>(LAMPIRAN III)<br>									
SEBAGAI BAHAN  MUSRENBANG RKPD KABUPATEN SUBANG TAHUN <?=$_tahun?>	<br>							
</strong>	<br><br>							
						
</center>
  <table class="table table-bordered table-striped with-check">
	  <thead>
	   <tr>			
		 <th style='padding-bottom:10px;'>No</th>	
		  <th style='padding-bottom:10px;'>Kegiatan Prioritas</th>	  
		  <th style='display:none;'>Sasaran Kegiatan</th>
		  <th style='display:none;'>Program</th>	
		  <th style='padding-bottom:10px;'>Lokasi (Desa/Kel/Kec)	</th>
		  <th style='padding-bottom:10px;'>Volume</th>
		  <th style='padding-bottom:10px;'>Pagu</th>
		  <th>Perangkat Daerah<br>Penanggung Jawab</th>			
		  <th style='padding-bottom:10px;'>Tgl.Validasi</th>
	   </tr>
	  </thead>
	  <tbody>			   
	<?php			
		
		$whm=$JVERIFIKASI==1?" AND month(a.TGLVALID)>0 ":" AND (a.TGLVALID IS NULL OR a.TGLVALID='0000-00-00')";
		
		$whm="";
		$qry=$this->db->query("SELECT distinct a.KDTAHAP, bb.KDUNIT, bb.NMUNIT, b.NMUNIT as NMKEC, b.KDUNIT as KDUNITKEC, a.KDCPCL, f.NMPRGRM, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PENANGGUNG_JAWAB, a.FOTO, a.TGLVALID, f.NOPRGRM, f.NMPRGRM, e.NOKEG, e.NMKEG, a.TGLVERIFIKASI FROM dbsipd_".$_tahun.".t_kegiatan_cpcl AS a 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.UNITKEY_KEC=b.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS bb ON a.UNITKEY=bb.UNITKEY 
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS f ON e.KDPRGRM=f.KDPRGRM	
		WHERE a.JENIS_CPCL='{$JENIS_CPCL}' and a.KDTAHAP='{$KDTAHAP}' $whm $wh
		 ORDER BY b.KDUNIT, bb.KDUNIT, f.NOPRGRM, e.NOKEG");
		
		$i=1;$KDUNITKEC="";
		foreach ($qry->result() as $row){	
		
			if(empty($KDUNITKEC) || $KDUNITKEC!=$row->KDUNITKEC )
			{	$KDUNITKEC=$row->KDUNITKEC;						
				echo "<tr><td colspan=7 style='font-weight:bold;'>".$row->NMKEC."</td></tr>";
				$i=1;
			}

			echo "    
			<tr>					
				<td align=center>".$i.".</td>
				<td>".$row->KEGIATAN_PRIORITAS."</td>			
				<td style='display:none;'>".$row->NOKEG." ".$row->NMKEG." (".$row->SASARAN_KEGIATAN." )</td>
				<td style='display:none;'>".$row->NOPRGRM." ".$row->NMPRGRM."</td>
				
				<td>".$row->LOKASI."</td>
				<td>".$row->VOLUME."</td>
				
				<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU)."</td>
				<td>".$row->NMUNIT."</td>
				<td>".$row->TGLVALID."</td>
			</tr>
			";
			$i++;
		}
	?>
  </tbody>
</table>