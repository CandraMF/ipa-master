<?php
	$data=$this->input->post();
	if(!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	

	
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$UNITKEY_KEC=!empty($UNITKEY_KEC)?$UNITKEY_KEC:"";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:"3";
	$KDTAHAP=$_tahap;
	 
	
	$row=$this->m_action->ambilData("select KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where UNITKEY='{$UNITKEY}'");
	$KDUNIT=$row->KDUNIT;
	$NMUNIT=$row->NMUNIT;
	
	
?>
 <div class="widget-content form-horizontal">		
	<input type="hidden" name="UNITKEY_KEC" id='UNITKEY_KEC' value='<?=$UNITKEY_KEC?>'>
	<input type="hidden" name="KDKEGUNIT" id='KDKEGUNIT' value='<?=$KDKEGUNIT?>'>
	<div class="control-group">
	  <label class="control-label">Lampiran</label>
	  <div class="controls">
			<?=$this->m_auth->cmbQuery('JENIS_CPCL',@$JENIS_CPCL,"select JENIS_CPCL as '0', LAMPIRAN as '1' from dbsipd_".$_tahun.".t_lampiran where JENIS_CPCL in (3,4) order by JENIS_CPCL","onchange=\"Fm.submit();\"","Y")?>					
	  </div>
	</div>	
	<div class="control-group">
	  <label class="control-label">SKPD</label>
	  <div class="controls">
		<?php
			
			if(TRIM($_qryopd)=="NOT IN ('')"){
				echo $this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"select UNITKEY as '0', CONCAT(KDUNIT,' ', NMUNIT) as '1' from dbsipd_".$_tahun.".mskpd where KDSTUNIT in ('3')  order by KDUNIT","class='span12' onchange=\"Fm.submit();\"");
			}else{
				echo $this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"select UNITKEY as '0', CONCAT(KDUNIT,' ', NMUNIT) as '1' from dbsipd_".$_tahun.".mskpd where KDSTUNIT in ('3') and UNITKEY ".$_qryopd." order by KDUNIT","class='span12' onchange=\"Fm.submit();\"");
			}
			
		?>	

	  </div>
	</div>
	
	
	
</div>
<div class="widget-content">		
  <table class="table table-bordered table-striped with-check">
  <thead>
   <tr>			
	  <th>No</th>			  
	  <th>Pokpir</th>			  
	  <th>Prioritas Daerah</th>			  
	  <th>Sasaran Daerah</th>
	  <th>Program</th>
	  <th>Kegiatan Prioritas</th>
	  <th>Sasaran Kegiatan</th>
	  <th>Lokasi (Desa/Kel/Kec)	</th>
	  <th>Volume</th>
	  <th>Pagu</th>
	  <th>Penanggung Jawab</th>		
	  <th >Aksi<br>/Tgl. Verifikasi</th>
	
   </tr>
  </thead>
  <tbody>		   
	<?php			
		$i=1;
		$qry=$this->db->query("SELECT a.KDCPCL, i.KDUNIT as KODE_KEC, i.NMUNIT as NMKEC,g.NMPRIORITAS, h.NMSASARAN_DAERAH, f.NMPRGRM, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PENANGGUNG_JAWAB, a.FOTO, concat(j.NODEWAN,' ',j.NMDEWAN) AS DEWAN , f_tglind(a.TGLVALID) AS TGLVALID FROM dbsipd_".$_tahun.".t_kegiatan_cpcl AS a 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS f ON e.KDPRGRM=f.KDPRGRM
		INNER JOIN dbsipd_".$_tahun.".t_renstra_pgrm AS rp ON a.KDPRGRM=rp.KDPRGRM and a.UNITKEY=rp.UNITKEY  
		LEFT JOIN dbsipd_".$_tahun.".mprioritas_daerah AS g ON rp.KDPRIORITAS=g.KDPRIORITAS
		LEFT JOIN dbsipd_".$_tahun.".msasaran_derah AS h ON rp.KDSASARAN=h.KDSASARAN
		INNER JOIN dbsipd_".$_tahun.".mskpd AS i ON a.IDKEC=i.UNITKEY
		INNER JOIN dbsipd_".$_tahun.".mdprd AS j ON a.KDDEWAN=j.KDDEWAN
		WHERE a.KDTAHAP='{$KDTAHAP}' AND  a.UNITKEY='{$UNITKEY}' AND a.JENIS_CPCL='{$JENIS_CPCL}' order by i.KDUNIT");
		$i=1;$KODE_KEC="";
		foreach ($qry->result() as $row){	
			$FOTO=!empty($row->FOTO)?$row->FOTO:"assets/img-cpcl/photo.png";
			if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00')){				
				$cmbdatavalid="Validasi";
				$ArrCmbUmum=array($cmbdatavalid,'Edit','Hapus');
				$TGLVALID="";
			}else{
				$cmbdatavalid="Un Validasi";
				$ArrCmbUmum=array($cmbdatavalid);
				$TGLVALID=$row->TGLVALID;
			}


			if(empty($KODE_KEC) || $KODE_KEC!=$row->KODE_KEC)
			{$KODE_KEC=$row->KODE_KEC;echo "<tr bgcolor='#339900'><td colspan=15>".$row->KODE_KEC." ".$row->NMKEC."</td></tr>";$i=1;}

			echo "    
			<tr>					
				<td align=center>".$i.".</td>
				<td>".$row->DEWAN."</td>						
				<td><a href='".base_url($FOTO)."' target='_blank'>".$row->NMPRIORITAS."</a></td>						
				<td>".$row->NMSASARAN_DAERAH."</td>
				<td>".$row->NMPRGRM."</td>
				<td>".$row->KEGIATAN_PRIORITAS."</td>
				<td>".$row->SASARAN_KEGIATAN."</td>
				<td>".$row->LOKASI."</td>
				<td>".$row->VOLUME."</td>
				<td align=right>".$this->andri->cetakuang($row->PAGU)."</td>
				<td>".$row->PENANGGUNG_JAWAB."</td>
				<td>
					".$this->andri->cmbUmum("cmbAksi","",$ArrCmbUmum,"data-id='".@$row->KDCPCL."' class='cmbAksi' style='width:80px;'")."<br>
					<center>".$TGLVALID."</center>
				</td>
				
			</tr>
			";
			$i++;
		}
	?>
  </tbody>
</table>
</div>

<div id="popkec" class="modal fade" >
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			
			<div class="modal-body">
				<div id="tree_kec"> </div>
			</div>
			<div class="modal-footer">
				<strong>DAFTAR KECAMATAN</strong>
			</div>
		</div>
	</div>
</div> 

<div id="popskpd" class="modal fade" >
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			
			<div class="modal-body">
				<div id="tree_skpd"> </div>
			</div>
			<div class="modal-footer">
				<strong>DAFTAR SKPD</strong>
			</div>
		</div>
	</div>
</div> 


<script src="<?=base_url("assets/tree/jquery/jquery.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/tree/jquery/jquery-ui.custom.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/tree/jquery/jquery.cookie.js")?>" type="text/javascript"></script>

<link href="<?=base_url("assets/tree/src/skin/ui.dynatree.css")?>" rel="stylesheet" type="text/css">
<script src="<?=base_url("assets/tree/src/jquery.dynatree.js")?>" type="text/javascript"></script>

<!-- Start_Exclude: This block is not part of the sample code -->
<link href="<?=base_url("assets/tree/prettify.css")?>" rel="stylesheet">
<script src="<?=base_url("assets/tree/prettify.js")?>" type="text/javascript"></script>
<link href="<?=base_url("assets/tree/sample.css")?>" rel="stylesheet" type="text/css">
<script src="<?=base_url("assets/tree/sample.js")?>" type="text/javascript"></script>
<!-- End_Exclude -->

<?php
	

	////////////// SKPD
	$rowskpd=$this->m_action->ambilData("select length(trim(KDUNIT)) AS jchar2 from dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and  KDSTUNIT IN (1) limit 1");foreach($rowskpd as $key => $value){$$key = $this->andri->clean($value);}
	$rowskpd=$this->m_action->ambilData("select length(trim(KDUNIT)) AS jchar3 from dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and  KDSTUNIT IN (2) limit 1");foreach($rowskpd as $key => $value){$$key = $this->andri->clean($value);}
	////////////// SKPD
	$qry=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and  KDSTUNIT IN (1) AND UNITKEY!='203' AND KDUNIT IN (SELECT LEFT(KDUNIT,".$jchar2.") FROM dbsipd_".$_tahun.".mskpd WHERE UNITKEY ".$_qryopd.") ORDER BY kdunit");$title_skpd="";	
	foreach($qry->result() as $row){
		$JL2=strlen(trim($row->KDUNIT));
		$qrysub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and KDSTUNIT IN (2) and left(KDUNIT,".$JL2.")='".$row->KDUNIT."' AND KDUNIT IN (SELECT LEFT(KDUNIT,".$jchar3.") FROM dbsipd_".$_tahun.".mskpd WHERE UNITKEY ".$_qryopd.")AND UNITKEY!='203' ORDER BY kdunit");$child_skpd="";
		foreach($qrysub->result() as $rowsub){
			$JL3=strlen(trim($rowsub->KDUNIT));
			$qrysubsub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and KDSTUNIT IN (3) and left(KDUNIT,".$JL3.")='".$rowsub->KDUNIT."'  AND UNITKEY!='203'  AND UNITKEY ".$_qryopd."  ORDER BY kdunit");$child_skpdsub="";
			foreach($qrysubsub->result() as $rowsubsub){
				$child_skpdsub.='{title: "'.$rowsubsub->KDUNIT.' '.$rowsubsub->NMUNIT.'", key: "'.$rowsubsub->UNITKEY.'" },';
			}
			$child_skpd.='{title: "'.$rowsub->KDUNIT.' '.$rowsub->NMUNIT.'", isFolder: true,
					children: [
						'.substr($child_skpdsub,0,-1).'		
					]
				},';
		}
		$title_skpd.='{title: "'.$row->KDUNIT.' '.$row->NMUNIT.'", isFolder: true,
			children: [
				'.substr($child_skpd,0,-1).'				
			]
		},';		
	}
	
?>

<script type="text/javascript">	
	$( document ).ready(function() {	
		var treeData = [ <?=substr($title_skpd,0,-1)?> ];
	
		////////// SKPD
		$("#tree_skpd").dynatree({
			onActivate: function(node) {			
				Fm.UNITKEY.value=node.data.key;Fm.submit();
			},
			children: treeData
		});

		$('#skpd').click(function(){	
			$('#popskpd').modal('show'); 
		});
		
		
		$('.cmbAksi').change(function(){	
			var cmbData=$(this).val();
			var KDCPCL=$(this).attr("data-id");			
			switch(cmbData) {
			  case "Validasi":
				var TGLVALID=$('#TGLVALID').val();
				var dataPost={KDCPCL:KDCPCL, TGLVALID:TGLVALID};
				$.post("<?=base_url('verifikasi/verifikasi_ranc_renja_bl/simpan')?>",dataPost,
				function(data){	
					var data = $.parseJSON( data );		
					$('#InfoConfirm').modal('show'); 
					if(data.status=='success')
					{$('#txtinfo').html('Berhasil di simpan');}
					else
					{$('#txtinfo').html('Gagal di simpan');}
					setTimeout(function(){ Fm.submit(); }, 1000);				
				});
			  break;
			  case "Un Validasi":
				var TGLVALID='0000-00-00';
				var dataPost={KDCPCL:KDCPCL, TGLVALID:TGLVALID};
				$.post("<?=base_url('verifikasi/verifikasi_ranc_renja_bl/simpan')?>",dataPost,
				function(data){	
					var data = $.parseJSON( data );		
					$('#InfoConfirm').modal('show'); 
					if(data.status=='success')
					{$('#txtinfo').html('Berhasil di simpan');}
					else
					{$('#txtinfo').html('Gagal di simpan');}
					setTimeout(function(){ Fm.submit(); }, 1000);				
				});
			  break;
			  case "Edit":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/pindah_pokpir_bl/edit/')?>"+KDCPCL+"/<?=$JENIS_VALIDASI?>";
			  break;
			  case "Hapus":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/pindah_pokpir_bl/hapus/')?>"+KDCPCL+"/<?=$JENIS_VALIDASI?>";
			  break;
			}   
		});
		
	});
</script>	