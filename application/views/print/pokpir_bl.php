<?php
	$qsts=$this->db->query("select if(tahapan=1,'Murni','Perubahan') as nmtahapan from dbsipd_".$_tahun.".__t_users where username='".$this->session->userdata('SESS_USERNAME')."'");	
	$thprow = $qsts->row();	
?>
<center><strong> 								
PEMERINTAH KABUPATEN SUBANG TAHUN <?=$_tahun?>	<br>
USULAN POKPIR BELANJA LANGSUNG  <br> Tahapan : <?=$thprow->nmtahapan?></strong> </strong>	<br><br>							
</center>
 <table class="table table-bordered table-striped with-check">
  <thead>
    <tr>			
	  <th>No</th>			  
	  <th>Kegiatan Prioritas</th>
	  <th>Sasaran Kegiatan</th>
	  <th>Program</th>
	  <th>Lokasi (Desa/Kel/Kec)	</th>
	  <th>Volume</th>
	  <th>Pagu</th>
	  <th>Penanggung Jawab</th>	
	  <th>Dewan</th>	
	  <th>SKPD</th>	
   </tr>
  </thead>
  <tbody>		   
	<?php			
		$JENIS_CPCL="3";
		$i=1;$KDTAHAP=$_tahap;
		$qry=$this->db->query("SELECT a.KDCPCL, f.NMPRGRM, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PENANGGUNG_JAWAB, a.FOTO, a.TGLVALID, g.NMDEWAN, bb.NMUNIT FROM dbsipd_".$_tahun.".t_kegiatan_cpcl AS a 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS bb ON a.UNITKEY=bb.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS f ON e.KDPRGRM=f.KDPRGRM		
		LEFT JOIN dbsipd_".$_tahun.".mdprd  AS g ON a.KDDEWAN=g.KDDEWAN where a.KDTAHAP='{$KDTAHAP}' and g.NMDEWAN!='' order by a.KDDEWAN
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
				<td>".$row->KEGIATAN_PRIORITAS."</td>						
				<td>".$row->SASARAN_KEGIATAN."</td>
				<td>".$row->NMPRGRM."</td>
				
				<td>".$row->LOKASI."</td>
				<td>".$row->VOLUME."</td>
				<td align=right>".$this->andri->cetakuang($row->PAGU)."</td>
				<td>".$row->PENANGGUNG_JAWAB."</td>
				<td>".$row->NMDEWAN."</td>
				<td>".$row->NMUNIT."</td>
				
			</tr>
			";
			$JPAGU=$JPAGU+$row->PAGU;
			$i++;
		}
		ECHO "
			<tr>	
				<td align=center colspan=6> <strong>Total</strong></td>
				
				<td align=right>".$this->andri->cetakuang($JPAGU)."</td>
				<td></td>
				<td></td>
				
			</tr>	
		";
	?>
  </tbody>
</table>