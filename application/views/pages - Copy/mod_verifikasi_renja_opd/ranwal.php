<?php
	$data=$this->input->post();
	if(!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	$KDTAHAP=$_tahap;
	switch($Aksi){
		case "kegiatan":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".t_kegiatan_keg where KDRANCKEG='".$id."' and KDTAHAP='{$KDTAHAP}'");	foreach($row as $key => $value){$$key = $this->andri->clean($value);}
		break;
		case "program":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".t_kegiatan_keg where KDRANCKEG='".$id."' and KDTAHAP='{$KDTAHAP}'");	foreach($row as $key => $value){$$key = $this->andri->clean($value);}
		break;
		case "back":
			$KDKEGUNIT=$id;
			$UNITKEY=$this->uri->segment(7);
		break;
	}
	
	

	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	
	$query=$this->db->query("select * from dbsipd_".$_tahun.".t_kegiatan_keg where  UNITKEY='{$UNITKEY}' and KDKEGUNIT='{$KDKEGUNIT}'");
	if($query->num_rows()>0){
		$hide="style='display:none;'";
	}else{
		$hide="";
	}
 
	$row=$this->m_action->ambilData("select KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where UNITKEY='{$UNITKEY}'");
	$KDUNIT=$row->KDUNIT;
	$NMUNIT=$row->NMUNIT;
	
	
	$row=$this->m_action->ambilData("SELECT distinct b.KDKEGUNIT, concat(c.NOPRGRM,b.NOKEG) AS NOKEG, b.NMKEG FROM dbsipd_".$_tahun.".t_renstra_keg AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS c ON a.KDPRGRM=c.KDPRGRM WHERE a.UNITKEY='{$UNITKEY}' AND a.KDKEGUNIT='{$KDKEGUNIT}'");

	
	
	$NOKEG=$row->NOKEG;
	$NMKEG=$row->NMKEG;


	//// Jumlah Kinerja Kegiatan
	$Qry="SELECT b.NMKINERJA, a.TOLAK_UKUR, a.TARGET_KINERJA_N, a.TARGET_KINERJA_N1, a.TGLVALID FROM  dbsipd_".$_tahun.".t_kegiatan_kinkeg AS a inner join dbsipd_".$_tahun.".mkinerja_kegiatan as b on a.KDKINERJA=b.KDKINERJA  WHERE a.KDKEGUNIT='".@$KDKEGUNIT."' AND a.UNITKEY='".@$UNITKEY."' AND a.KDTAHAP='{$KDTAHAP}'  ORDER BY a.KDKINERJA";
	 
	$dt_kinkeg=$this->m_auth->NaviPage($Qry, "PageKinKeg", @$PageKinKeg,"onchange=\"Fm.submit();\"");
	
	//// Jumlah Dana
	$Qry="SELECT b.NMDANA, a.NILAIN, a.NILAIN1, a.KETERANGAN, a.TGLVALID  FROM  dbsipd_".$_tahun.".t_kegiatan_dana AS a inner join dbsipd_".$_tahun.".mdana as b on a.KDDANA=b.KDDANA  WHERE a.KDKEGUNIT='".@$KDKEGUNIT."' AND a.UNITKEY='".@$UNITKEY."' AND a.KDTAHAP='{$KDTAHAP}' ORDER BY a.KDDANA";
	$dt_dana=$this->m_auth->NaviPage($Qry, "PageDana", @$PageDana,"onchange=\"Fm.submit();\"");

	$ArrTahap=array('Murni','Perubahan');
?>

		 <!-- Data List Program -->
	  <div class="widget-content form-horizontal">		
			<input type="hidden" name="UNITKEY" id='UNITKEY' value='<?=$UNITKEY?>'>			
			<input type="hidden" name="KDKEGUNIT" id='KDKEGUNIT' value='<?=$KDKEGUNIT?>'>
		
			<div class="control-group">
              <label class="control-label">SKPD</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" style='width:120px;' readonly  value='<?=$KDUNIT?>'>
                  <span class="add-on" id='skpd'><i class='icon-search'></i></span> 
				 </div>
				 <input type="text" class="span6" readonly  value='<?=$NMUNIT?>'>				
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Kegiatan</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" style='width:120px;' readonly  value='<?=$NOKEG?>'>
                  <span class="add-on" id='keg'><i class='icon-search'></i></span> 
				 </div>
				 <input type="text" class="span6" readonly  value='<?=$NMKEG?>'>		
              </div>
            </div>	
			<div class="control-group" <?=$hide?>>
				 <label class="control-label"></label>
				 <div class="controls">
					<?php if(!empty($KDKEGUNIT)&&!empty($UNITKEY)){ ?>
				 	<a href="<?=base_url('login/pages/'.$Pr.'/kegiatan/param/'.$KDKEGUNIT.'/'.$UNITKEY)?>" ><button type="button" id='btnsimpan' class="btn btn-primary" <?=$_pinsert?>>Tambah</button></a>
					<?php } ?>
					<button type="button" onclick="Fm.submit();" class="btn btn-primary">Reload</button>
				 </div>
			
			</div>	
			
	  </div>
	   <div class="widget-content">		
		  <table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th>No</th>			  
			  <th>Prioritas Daerah</th>			  
			  <th>Sasaran Daerah</th>
			  <th>Program</th>
			  <th>Kegiatan Prioritas</th>
			  <th>Sasaran Kegiatan</th>
			  <th>Lokasi (Desa/Kel/Kec)	</th>
			  <th>Volume</th>
			  <th>Pagu</th>
			  <th>Pagu (N+1)</th>
			 	
			  <th>Aksi / Tgl. Verifikasi</th>
		   </tr>
		  </thead>
		  <tbody>		   
			<?php			
				$i=1;
				$qry=$this->db->query("SELECT distinct e.KDPRGRM, a.KDRANCKEG, g.NMPRIORITAS, h.NMSASARAN_DAERAH, f.NMPRGRM, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, a.LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PAGUN1, a.FOTO, a.TGLVALID FROM dbsipd_".$_tahun.".t_kegiatan_keg AS a 				
				INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT
				INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS f ON e.KDPRGRM=f.KDPRGRM
				INNER JOIN dbsipd_".$_tahun.".t_renstra_pgrm AS rp ON a.KDPRGRM=rp.KDPRGRM and a.UNITKEY=rp.UNITKEY  
				LEFT JOIN dbsipd_".$_tahun.".mprioritas_daerah AS g ON rp.KDPRIORITAS=g.KDPRIORITAS
				LEFT JOIN dbsipd_".$_tahun.".msasaran_derah AS h ON rp.KDSASARAN=h.KDSASARAN
				WHERE a.KDTAHAP='{$KDTAHAP}' AND  a.UNITKEY='{$UNITKEY}' AND a.KDKEGUNIT='{$KDKEGUNIT}'");
			
				$i=1;
				foreach ($qry->result() as $row){	
					$FOTO=!empty($row->FOTO)?$row->FOTO:"assets/img-cpcl/photo.png";
					
					$ArrCmbUmum=array();$valid="";
					if(empty($_pupdate)){$ArrCmbUmum[]='Edit';}
					$TGLVALID=$row->TGLVALID;
					echo "    
					<tr>					
						<td align=center>".$i.".</td>
						<td><a href='".base_url($FOTO)."' target='_blank'>".$row->NMPRIORITAS."</a></td>						
						<td>".$row->NMSASARAN_DAERAH."</td>
						<td>".$row->NMPRGRM."</td>
						<td>".$row->KEGIATAN_PRIORITAS."</td>
						<td>".$row->SASARAN_KEGIATAN."</td>
						<td>".$row->LOKASI."</td>
						<td>".$row->VOLUME."</td>
						<td align=right>".$this->andri->cetakuang($row->PAGU)."</td>
						<td align=right>".$this->andri->cetakuang($row->PAGUN1)."</td>
						
						<td>
							<center>
								".$this->andri->cmbUmum("cmbAksi","",$ArrCmbUmum,"data-id='".@$row->KDRANCKEG."' data-KDTAHAP='".@$KDTAHAP."' data-UNITKEY='".@$UNITKEY."' data-KDPRGRM='".@$row->KDPRGRM."' data-KDKEGUNIT='".@$KDKEGUNIT."' class='cmbAksi' style='width:80px;'")."
							</center>
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
	   <!-- Data List Kinerja Kegiatan -->
	   <div class="widget-content">		
	    <div class="alert alert-info"><strong>Kinerja Kegiatan</strong></div>
	
		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>						
			  <th style='width:300px;'>Indikator</th>
			  <th>Tolak Ukur</th>
			  <th>Target Kinerja (n)</th>
			  <th>Target Kinerja (n+1)</th>
			</tr>
		  </thead>
		  <tbody>		 
			<?php			
			$i=1;
			foreach ($dt_kinkeg->query->result() as $row){
				if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
				{$valid="";}else{$valid="style='display:none;'";}
				echo "
				<tr>				
					<td>".$row->NMKINERJA."</td>
					<td>".$row->TOLAK_UKUR."</td>
					<td>".$row->TARGET_KINERJA_N."</td>
					<td>".$row->TARGET_KINERJA_N1."</td>
					
				</tr>
				";
				$i++;
			}			
			?>
		  </tbody>
		</table>
	  </div>
	  <!-- Data List Pendanaan -->
	   <div class="widget-content">		
	    <div class="alert alert-info"><strong>Daftar Sumber Dana</strong> [ <?=@$NMKEG?> ]</div>
	
		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>						
			  <th style='width:300px;'>Sumber&nbsp;Dana</th>
			  <th>Nilai</th>
			  <th>Nilai (1)</th>
			  <th>Keterangan</th>
			</tr>
		  </thead>
		  <tbody>		 
			<?php			
			$i=1;
			foreach ($dt_dana->query->result() as $row){
				if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
				{$valid="";}else{$valid="style='display:none;'";}
				echo "
				<tr>				
					<td>".$row->NMDANA."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->NILAIN)."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->NILAIN1)."</td>	
					<td>".$row->KETERANGAN."</td>
				</tr>
				";
				$i++;
			}			
			?>
		  </tbody>
		</table>
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

<div id="popkeg" class="modal fade" >
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			
			<div class="modal-body">
				<div id="tree_keg"> </div>
			</div>
			<div class="modal-footer">
				<strong>DAFTAR KEGIATAN</strong>
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
	////////////// KEGIATAN

	$qry=$this->db->query("SELECT distinct b.KDPRGRM, b.NOPRGRM ,b.NMPRGRM FROM dbsipd_".$_tahun.".t_kegiatan_keg  AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS b ON a.KDPRGRM=b.KDPRGRM WHERE  a.KDTAHAP='".$KDTAHAP."' and  a.UNITKEY='{$UNITKEY}' ORDER BY b.NOPRGRM");$title_keg="";	
	foreach($qry->result() as $row){
		$qrysub=$this->db->query("SELECT distinct b.KDKEGUNIT, b.NOKEG, b.NMKEG FROM dbsipd_".$_tahun.".t_kegiatan_keg AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT WHERE (a.TGLVALID NOT IN ('0000-00-00') OR a.TGLVALID IS NOT NULL) and a.KDTAHAP='".$KDTAHAP."' and a.UNITKEY='{$UNITKEY}' AND a.KDPRGRM='".$row->KDPRGRM."'");$child_keg="";
		foreach($qrysub->result() as $rowsub){
			$child_keg.='{title: "'.$row->NOPRGRM.$rowsub->NOKEG.' '.$rowsub->NMKEG.'", key: "'.$rowsub->KDKEGUNIT.'"},';
		}
		$title_keg.='{
			title: "'.$row->NOPRGRM.' '.$row->NMPRGRM.'", isFolder: true, 
				children: [ 
					'.substr($child_keg,0,-1).'
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
		////////// KEGIATAN
		$("#tree_keg").dynatree({
			onActivate: function(node) {			
				Fm.KDKEGUNIT.value=node.data.key;Fm.submit();
			},
			children: [					
				<?=substr($title_keg,0,-1)?>				
			]
		});

		$('#keg').click(function(){	
			$('#popkeg').modal('show'); 
		});

		$('.cmbAksi').change(function(){	
			var cmbData=$(this).val();
			var KDRANCKEG=$(this).attr("data-id");		
			var KDTAHAP=$(this).attr("data-KDTAHAP");		
			var UNITKEY=$(this).attr("data-UNITKEY");		
			var KDPRGRM=$(this).attr("data-KDPRGRM");		
			var KDKEGUNIT=$(this).attr("data-KDKEGUNIT");		
			switch(cmbData) {			 
			  case "Validasi":
				var TGLVALID=$('#TGLVALID').val();
				var dataPost={KDRANCKEG:KDRANCKEG, KDTAHAP:KDTAHAP, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, TGLVALID:TGLVALID};
				$.post("<?=base_url('verifikasi/verifikasi_ranwal_kegiatan/simpan')?>",dataPost,
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
				var dataPost={KDRANCKEG:KDRANCKEG, KDTAHAP:KDTAHAP, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, TGLVALID:TGLVALID};
				$.post("<?=base_url('verifikasi/verifikasi_ranwal_kegiatan/simpan')?>",dataPost,
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
				  parent.location="<?=base_url('login/pages/'.$Pr.'/detail_ranwal/edit/')?>"+KDRANCKEG;
			  break;
			  case "Delete":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/detail_ranwal/hapus/')?>"+KDRANCKEG;
			  break;
			}   
		});
	});
</script>	