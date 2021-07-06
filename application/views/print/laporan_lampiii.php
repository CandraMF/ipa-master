<?php
	$KDTAHAP=$_tahap;
	$JVERIFIKASI=$this->uri->segment(4);			
	$KDBIDANG=$this->uri->segment(5);			
		
	$row=$this->m_action->ambilData("select NMBIDANG from dbsipd_".$_tahun.".mbidang where KDBIDANG='".$KDBIDANG."'");		
	foreach($row as $key => $value){$$key = $this->andri->clean($value);}


	$wh="";
	$wh=!empty($KDSUBBIDANG)?" AND KDSUBBIDANG='{$KDSUBBIDANG}'":"";
	$whm=$JVERIFIKASI==1?" AND month(a.TGLVALID)>0 ":" AND (a.TGLVALID IS NULL OR a.TGLVALID='0000-00-00')";
	
	$i=1;
	$qm=$this->db->query("SELECT a.UNITKEY, b.AKRONIM FROM dbsipd_".$_tahun.".mbidang_skpd as a inner join dbsipd_".$_tahun.".mskpd as b on a.UNITKEY=b.UNITKEY WHERE KDBIDANG ='{$KDBIDANG}' ".$wh);$field="";
	$th="";$td="";
	foreach ($qm->result() as $isi){
		$field.=", SUM(if(a.UNITKEY='".$isi->UNITKEY."', a.PAGU,0)) AS NILAI_".$i;
		$td.="<td style='text-align:right;'>[+]row->NILAI_".$i."[-]</td>";
		$th.="<th>".$isi->AKRONIM."</th>";
		$i++;	
	}

	$td=str_replace("[+]",'".$',$td);
	$td=str_replace("[-]",'."',$td);

	$KETJUDUL=$JVERIFIKASI==1?" PRIORITAS KECAMATAN MENURUT PERANGKAT DAERAH ":" REKAPITULASI KEGIATAN YANG BELUM DI SEPAKATI ";
?>


<center><strong> DAFTAR <?=$KETJUDUL?>(LAMPIRAN III)<br>									
SEBAGAI BAHAN  MUSRENBANG RKPD KABUPATEN SUBANG TAHUN <?=$_tahun?>	<br>							
LINGKUP BIDANG <?=$NMBIDANG?> </strong>	<br><br>							
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
		$qry=$this->db->query("SELECT distinct bb.KDUNIT, bb.NMUNIT, b.NMUNIT as NMKEC, b.KDUNIT as KDUNITKEC, a.KDCPCL, f.NMPRGRM, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PENANGGUNG_JAWAB, a.FOTO, a.TGLVALID, f.NOPRGRM, f.NMPRGRM, e.NOKEG, e.NMKEG, a.TGLVERIFIKASI FROM dbsipd_".$_tahun.".t_kegiatan_cpcl AS a 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS bbb ON a.UNITKEY_KEC=bbb.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS bb ON a.UNITKEY=bb.UNITKEY 
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS f ON e.KDPRGRM=f.KDPRGRM				
		WHERE a.KDTAHAP='{$KDTAHAP}' AND a.UNITKEY IN (SELECT UNITKEY FROM dbsipd_".$_tahun.".mbidang_skpd WHERE KDBIDANG ='{$KDBIDANG}' ".$wh.") AND a.JENIS_CPCL IN (2,4) $whm ORDER BY bbb.KDUNIT, bb.KDUNIT, f.NOPRGRM, e.NOKEG");		
		
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