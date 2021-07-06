<style>
	th, td{
		font-family:tahoma;
		font-size:8pt;
		padding:3px;
		height:20px;
	}
</style>
<strong><center>Formulir E.80<br>Evaluasi Terhadap Hasil Renstra Perangkat Daerah Lingkup Kabupaten/kota <br>
Renstra Perangkat Daerah  Kabupaten/Kota Subang Periode <?=$_tahun?> </center></strong>

<table border=1 cellpadding=0 cellspacing=0 style='border-collapse: collapse;' width='100%'>
	  <thead>
		<tr>
			<th width='50' rowspan=2>No.</th>
			<th rowspan=2>Sasaran</th>			
			<th rowspan=2>Program/Kegiatan</th>
			<th rowspan=2>Indikator Kinerja</th>
			<th rowspan=2>Data Capaian Awal Tahun Perencanaan</th>
			<th rowspan=2 colspan=2>Target Capaian Akhir Tahun Perencanaan</th>
			<th colspan=10>Target Renstra Perangkat Daerah Kab/Kota </th>
			<th colspan=10>Realisasi Capaian</th>
			<th colspan=10>Rasio Capaian</th>
			<th rowspan=2>Unit Penganggung Jawab</th>
		</tr>
		<tr>
			<th colspan='2'>1</th>		
			<th colspan='2'>2</th>		
			<th colspan='2'>3</th>		
			<th colspan='2'>4</th>		
			<th colspan='2'>5</th>		
			<th colspan='2'>1</th>		
			<th colspan='2'>2</th>		
			<th colspan='2'>3</th>		
			<th colspan='2'>4</th>		
			<th colspan='2'>5</th>		
			<th colspan='2'>1</th>		
			<th colspan='2'>2</th>		
			<th colspan='2'>3</th>		
			<th colspan='2'>4</th>		
			<th colspan='2'>5</th>	
		</tr>
		<tr>
			<th rowspan=2>(1)</th>
			<th rowspan=2>(2)</th>
			<th rowspan=2>(3)</th>
			<th rowspan=2>(4)</th>
			<th rowspan=2>(5)</th>
			<th colspan='2'>(6)</th>
			<th colspan='2'>(7)</th>
			<th colspan='2'>(8)</th>
			<th colspan='2'>(9)</th>
			<th colspan='2'>(10)</th>
			<th colspan='2'>(11)</th>
			<th colspan='2'>(12)</th>
			<th colspan='2'>(13)</th>
			<th colspan='2'>(14)</th>
			<th colspan='2'>(15)</th>
			<th colspan='2'>(16)</th>
			<th colspan='2'>(17)</th>
			<th colspan='2'>(18)</th>
			<th colspan='2'>(19)</th>
			<th colspan='2'>(20)</th>
			<th colspan='2'>(21)</th>
			<th rowspan=2>(22)</th>	
		</tr>
		<tr>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			<th>K</th><th>Rp.</th>
			
		</tr>
	  </thead>
	  <tbody>	
		<?php			
		$i=1;$KDPRGRM="";
		$sGroup= $this->session->userdata("SESS_GROUP");
		if($sGroup==9){
		
			$qry=$this->db->query("SELECT a.KDTAHAP, a.KDPRGRM, a.KDKEGUNIT, a.UNITKEY,  a.NMSASARAN, b.NMPRGRM , c.NMKEG, a.INDIKATOR_KINERJA, a.CAPAIAN_AWAL_THN, a.CAPAIAN_AKHIR_THN_K, a.CAPAIAN_AKHIR_THN_RP, a.RENSTRA_1_K, a.RENSTRA_1_RP, a.RENSTRA_2_K, a.RENSTRA_2_RP, a.RENSTRA_3_K, a.RENSTRA_3_RP, a.RENSTRA_4_K, a.RENSTRA_4_RP, a.RENSTRA_5_K, a.RENSTRA_5_RP, a.REALISASI_1_K, a.REALISASI_1_RP, a.REALISASI_2_K, a.REALISASI_2_RP, a.REALISASI_3_K, a.REALISASI_3_RP, a.REALISASI_4_K, a.REALISASI_4_RP, a.REALISASI_5_K, a.REALISASI_5_RP, a.RASIO_1_K, a.RASIO_1_RP, a.RASIO_2_K, a.RASIO_2_RP, a.RASIO_3_K, a.RASIO_3_RP, a.RASIO_4_K, a.RASIO_4_RP, a.RASIO_5_K, a.RASIO_5_RP, d.NMUNIT  FROM dbsipd_".$_tahun.".emon_80 AS a  INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS b ON a.KDPRGRM=b.KDPRGRM INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS c ON a.KDKEGUNIT=c.KDKEGUNIT INNER JOIN dbsipd_".$_tahun.".mskpd AS d ON a.UNITKEY=d.UNITKEY WHERE a.KDTAHAP='".$_tahap."' and a.UNITKEY='".$_idopd."' order by d.KDUNIT, b.NOPRGRM, c.NOKEG");
			
		}else{
			$qry=$this->db->query("SELECT a.KDTAHAP, a.KDPRGRM, a.KDKEGUNIT, a.UNITKEY,  a.NMSASARAN, b.NMPRGRM , c.NMKEG, a.INDIKATOR_KINERJA, a.CAPAIAN_AWAL_THN, a.CAPAIAN_AKHIR_THN_K, a.CAPAIAN_AKHIR_THN_RP, a.RENSTRA_1_K, a.RENSTRA_1_RP, a.RENSTRA_2_K, a.RENSTRA_2_RP, a.RENSTRA_3_K, a.RENSTRA_3_RP, a.RENSTRA_4_K, a.RENSTRA_4_RP, a.RENSTRA_5_K, a.RENSTRA_5_RP, a.REALISASI_1_K, a.REALISASI_1_RP, a.REALISASI_2_K, a.REALISASI_2_RP, a.REALISASI_3_K, a.REALISASI_3_RP, a.REALISASI_4_K, a.REALISASI_4_RP, a.REALISASI_5_K, a.REALISASI_5_RP, a.RASIO_1_K, a.RASIO_1_RP, a.RASIO_2_K, a.RASIO_2_RP, a.RASIO_3_K, a.RASIO_3_RP, a.RASIO_4_K, a.RASIO_4_RP, a.RASIO_5_K, a.RASIO_5_RP, d.NMUNIT  FROM dbsipd_".$_tahun.".emon_80 AS a  INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS b ON a.KDPRGRM=b.KDPRGRM INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS c ON a.KDKEGUNIT=c.KDKEGUNIT INNER JOIN dbsipd_".$_tahun.".mskpd AS d ON a.UNITKEY=d.UNITKEY WHERE a.KDTAHAP='".$_tahap."' order by d.KDUNIT, b.NOPRGRM, c.NOKEG");
		}
		
		foreach ($qry->result() as $row){	
			if(empty($KDPRGRM) || $KDPRGRM!=$row->KDPRGRM ){	
				$KDPRGRM=$row->KDPRGRM;
				echo "<tr bgcolor='#339900'><td colspan=38 style='color:black;font-weight:bold;'>".$row->NMPRGRM."</td></tr>";
				$i=1;
			}
			echo "    
			<tr class='TrAksi' data-KDPRGRM='".$row->KDPRGRM."' data-KDKEGUNIT='".$row->KDKEGUNIT."' data-UNITKEY='".$row->UNITKEY."' data-KDTAHAP='".$row->KDTAHAP."'>	
				<td><center>$i.</center></td>
				<td>".$row->NMSASARAN."</td>	
				<td>".$row->NMKEG."</td>
				<td>".$row->INDIKATOR_KINERJA."</td>					
				<td>".$row->CAPAIAN_AWAL_THN."</td>
				<td>".$row->CAPAIAN_AKHIR_THN_K."</td>
				<td>".$row->CAPAIAN_AKHIR_THN_RP."</td>
				<td>".$row->RENSTRA_1_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RENSTRA_1_RP)."</td>
				<td>".$row->RENSTRA_2_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RENSTRA_2_RP)."</td>
				<td>".$row->RENSTRA_3_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RENSTRA_3_RP)."</td>
				<td>".$row->RENSTRA_4_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RENSTRA_4_RP)."</td>
				<td>".$row->RENSTRA_5_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RENSTRA_5_RP)."</td>
				<td align=right>".$row->REALISASI_1_K."</td>
				<td align=right>".$this->andri->cetakuang($row->REALISASI_1_RP)."</td>
				<td>".$row->REALISASI_2_K."</td>
				<td align=right>".$this->andri->cetakuang($row->REALISASI_2_RP)."</td>
				<td>".$row->REALISASI_3_K."</td>
				<td>".$this->andri->cetakuang($row->REALISASI_3_RP)."</td>
				<td align=right>".$row->REALISASI_4_K."</td>
				<td>".$this->andri->cetakuang($row->REALISASI_4_RP)."</td>
				<td>".$row->REALISASI_5_K."</td>
				<td align=right>".$this->andri->cetakuang($row->REALISASI_5_RP)."</td>
				<td>".$row->RASIO_1_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RASIO_1_RP)."</td>
				<td>".$row->RASIO_2_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RASIO_2_RP)."</td>
				<td>".$row->RASIO_3_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RASIO_3_RP)."</td>
				<td>".$row->RASIO_4_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RASIO_4_RP)."</td>
				<td>".$row->RASIO_5_K."</td>
				<td align=right>".$this->andri->cetakuang($row->RASIO_5_RP)."</td>
				<td>".$row->NMUNIT."</td>
			</tr>
			";
			$i++;
		}			
		?>

	  </tbody>
	</table>