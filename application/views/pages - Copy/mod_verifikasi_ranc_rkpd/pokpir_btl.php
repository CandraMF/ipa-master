<?php
	$data=$this->input->post();
	if(!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	

	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$UNITKEY_KEC=!empty($UNITKEY_KEC)?$UNITKEY_KEC:"";
	$MTGKEY=!empty($MTGKEY)?$MTGKEY:"";
	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:"3";
	$KDTAHAP=$_tahap;
	 
	$dt_ppkd=$this->m_action->ambilData("select nmppkd from dbsipd_".$_tahun.".mppkd");
	$row=$this->m_action->ambilData("select UNITKEY ,KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where NMUNIT like '%".$dt_ppkd->nmppkd."%'");
	$UNITKEY=$row->UNITKEY;
	$KDUNIT=$row->KDUNIT;
	$NMUNIT=$row->NMUNIT;
	
	
	$row=$this->m_action->ambilData("SELECT MTGKEY, KDREK, NMREK FROM  dbsipd_".$_tahun.".mrekr WHERE LEFT(KDREK,6) IN ('5.1.4.','5.1.5.') AND  MTGKEY='".@$MTGKEY."' ORDER BY KDREK");
	
	
	$KDREK=$row->KDREK;
	$NMREK=$row->NMREK;
	

?>
 <div class="widget-content form-horizontal">		
	<input type="hidden" name="UNITKEY" id='UNITKEY' value='<?=$UNITKEY?>'>
	<input type="hidden" name="UNITKEY_KEC" id='UNITKEY_KEC' value='<?=$UNITKEY_KEC?>'>

	<input type="hidden" name="KDKEGUNIT" id='KDKEGUNIT' value='<?=@$KDKEGUNIT?>'>
	<div class="control-group">
	  <label class="control-label">Lampiran</label>
	  <div class="controls">
			<?=$this->m_auth->cmbQuery('JENIS_CPCL',@$JENIS_CPCL,"select JENIS_CPCL as '0', LAMPIRAN as '1' from dbsipd_".$_tahun.".t_lampiran where JENIS_CPCL in (3,4) order by JENIS_CPCL","onchange=\"Fm.submit();\"","Y")?>				
	  </div>
	</div>	
	<div class="control-group">
	  <label class="control-label">SKPD Tujuan</label>
	  <div class="controls">
		<div class="input-append">
		  <input type="text" style='width:120px;' readonly  value='<?=$KDUNIT?>'>		  
		 </div>
		 <input type="text" class="span6" readonly  value='<?=$NMUNIT?>'>				
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label"></label>
	  <div class="controls">
		<button type="button" class="btn btn-primary" onclick="Fm.MTGKEY.value='';Fm.submit();">Reset</button>		
	  </div>
	</div>	
</div>
<div class="widget-content">		
  <table class="table table-bordered table-striped with-check">
  <thead>
   <tr>			
	  <th>No</th>			  
	  <th>Pokpir</th>			  
	  
	  <th>Rekening</th>
	  <th>Kegiatan Prioritas</th>
	  <th>Sasaran Kegiatan</th>
	  <th>Lokasi (Desa/Kel/Kec)	</th>
	  <th>Volume</th>
	  <th>Pagu</th>
	  <th>Penanggung Jawab</th>		
	  <th>Aksi<br>/Tgl. Verifikasi</th>	
   </tr>
  </thead>
  <tbody>		   
	<?php			
		//$wh=!empty($MTGKEY)?" AND a.MTGKEY='".@$MTGKEY."' ":"";
		$wh="";
		$i=1;
		$qry=$this->db->query("SELECT a.KDCPCL, i.KDUNIT as KODE_KEC, i.NMUNIT as NMKEC, concat(e.KDREK,' ',e.NMREK) as NMREK,  a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PENANGGUNG_JAWAB, a.FOTO, concat(j.NODEWAN,' ',j.NMDEWAN) AS DEWAN , f_tglind(a.TGLVALID) AS TGLVALID FROM dbsipd_".$_tahun.".t_btl_cpcl AS a 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
		INNER JOIN dbsipd_".$_tahun.".mrekr AS e ON a.MTGKEY=e.MTGKEY		
		INNER JOIN dbsipd_".$_tahun.".mskpd AS i ON a.IDKEC=i.UNITKEY
		INNER JOIN dbsipd_".$_tahun.".mdprd AS j ON a.KDDEWAN=j.KDDEWAN
		WHERE a.KDTAHAP='{$KDTAHAP}' AND  a.UNITKEY='{$UNITKEY}' AND a.JENIS_CPCL='{$JENIS_CPCL}' ".$wh." order by i.KDUNIT");
		
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
				<td>".$row->NMREK."</td>
				<td>".$row->KEGIATAN_PRIORITAS."</td>
				<td>".$row->SASARAN_KEGIATAN."</td>
				<td><a href='".base_url($FOTO)."' target='_blank'>".$row->LOKASI."</a></td>
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

<div id="poprek" class="modal fade" >
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			
			<div class="modal-body">
				<div id="tree_rekening"> </div>
			</div>
			<div class="modal-footer">
				<strong>DAFTAR REKENING</strong>
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
	
	
	////////////// REKENING

	$qry=$this->db->query("SELECT MTGKEY, KDREK, NMREK FROM dbsipd_".$_tahun.".mrekr WHERE LEFT(KDREK,6) IN ('5.1.4.','5.1.5.') AND KDSTREK='3'  ORDER BY KDREK ");$title_rekening="";	
	foreach($qry->result() as $row){
		$JL2=strlen(trim($row->KDREK));
		$qrysub=$this->db->query("SELECT MTGKEY, KDREK, NMREK FROM dbsipd_".$_tahun.".mrekr WHERE  KDSTREK='4' AND left(KDREK,".$JL2.")='".$row->KDREK."' ORDER BY KDREK");$child_rekening="";
		foreach($qrysub->result() as $rowsub){
			$JL3=strlen(trim($rowsub->KDREK));
			$qrysubsub=$this->db->query("SELECT MTGKEY, KDREK, NMREK FROM dbsipd_".$_tahun.".mrekr WHERE  KDSTREK='5' AND left(KDREK,".$JL3.")='".$rowsub->KDREK."' ORDER BY KDREK");$child_rekeningsub="";
			foreach($qrysubsub->result() as $rowsubsub){
				$child_rekeningsub.='{title: "'.$rowsubsub->KDREK.' '.$rowsubsub->NMREK.'", key: "'.$rowsubsub->MTGKEY.'" },';
			}
			$child_rekening.='{title: "'.$rowsub->KDREK.' '.$rowsub->NMREK.'", isFolder: true,
					children: [
						'.substr($child_rekeningsub,0,-1).'		
					]
				},';
		}
		$title_rekening.='{title: "'.$row->KDREK.' '.$row->NMREK.'", isFolder: true,
			children: [
				'.substr($child_rekening,0,-1).'				
			]
		},';		
	}
?>

<script type="text/javascript">	
	$( document ).ready(function() {	
		////////// REKENING

		var treeDataRek = [ <?=substr($title_rekening,0,-1)?> ];
		$("#tree_rekening").dynatree({
			onActivate: function(node) {			
				Fm.MTGKEY.value=node.data.key;Fm.submit();
			},
			children: treeDataRek
		});

		$('#rek').click(function(){	
			$('#poprek').modal('show'); 
		});
		
		
		$('.cmbAksi').change(function(){	
			var cmbData=$(this).val();
			var KDCPCL=$(this).attr("data-id");			
			switch(cmbData) {
			  case "Validasi":
				var TGLVALID=$('#TGLVALID').val();
				var dataPost={KDCPCL:KDCPCL, TGLVALID:TGLVALID};
				$.post("<?=base_url('verifikasi/verifikasi_ranc_renja_btl/simpan')?>",dataPost,
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
				$.post("<?=base_url('verifikasi/verifikasi_ranc_renja_btl/simpan')?>",dataPost,
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
				  parent.location="<?=base_url('login/pages/'.$Pr.'/pindah_pokpir_btl/edit/')?>"+KDCPCL+"/<?=$JENIS_VALIDASI?>";
			  break;
			  case "Hapus":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/pindah_pokpir_btl/hapus/')?>"+KDCPCL+"/<?=$JENIS_VALIDASI?>";
			  break;
			}   
		});
		
	});
</script>	