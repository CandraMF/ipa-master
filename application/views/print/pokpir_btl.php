<?php
	$qsts=$this->db->query("select if(tahapan=1,'Murni','Perubahan') as nmtahapan from dbsipd_".$_tahun.".__t_users where username='".$this->session->userdata('SESS_USERNAME')."'");	
	$thprow = $qsts->row();	
?>
<center><strong> 								
PEMERINTAH KABUPATEN SUBANG TAHUN <?=$_tahun?>	<br>
USULAN POKPIR BTL <br> Tahapan : <?=$thprow->nmtahapan?> </strong>	<br><br>							
</center>
 <table class="table table-bordered table-striped with-check">
  <thead>
   <tr>			
	 <th>No</th>
	  <th>Rekening</th>
	  <th>Kegiatan Prioritas</th>
	  <th>Sasaran Kegiatan</th>
	  <th>Lokasi (Desa/Kel/Kec)	</th>
	  <th>Volume</th>
	  <th>Pagu</th>
	  <th>SKPD</th>
	  <th>Dewan</th>
	  <th>Penanggung Jawab</th>	
	  <th>Tgl. Input</th>	
   </tr>
  </thead>
  <tbody>		   
	<?php			
		$i=1;$KDTAHAP=$_tahap;
		$qry=$this->db->query("SELECT a.KDCPCL, concat(e.KDREK,' ',e.NMREK) as NMREK, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, b.NMUNIT, a.PENANGGUNG_JAWAB, a.FOTO, a.TGLVALID, f.NMDEWAN, a.CREATED_DATE FROM dbsipd_".$_tahun.".t_btl_cpcl AS a 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
		LEFT JOIN dbsipd_".$_tahun.".mrekr AS e ON a.MTGKEY=e.MTGKEY
		LEFT JOIN dbsipd_".$_tahun.".mdprd  AS f ON a.KDDEWAN=f.KDDEWAN where a.KDTAHAP='{$KDTAHAP}' and f.NMDEWAN!='' order by a.KDDEWAN
		");
		
		$JPAGU=0;
		$i=1;
		foreach ($qry->result() as $row){	
			if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
			{$TGLVALID="";}else{
				$TGLVALID=$row->TGLVALID;
			}
			echo "    
			<tr>					
				<td align=center>".$i.".</td>
				<td>".$row->NMREK."</td>
				<td>".$row->KEGIATAN_PRIORITAS."</td>
				<td>".$row->SASARAN_KEGIATAN."</td>
				<td>".$row->LOKASI."</td>
				<td>".$row->VOLUME."</td>
				<td align=right>".$this->andri->cetakuang($row->PAGU)."</td>
				<td>".$row->PENANGGUNG_JAWAB."</td>
				<td>".$row->NMUNIT."</td>
				<td>".$row->NMDEWAN."</td>
				<td>".$row->CREATED_DATE."</td>
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
				<td></td>
				<td></td>
				
			</tr>	
		";
	?>

  </tbody>
</table>