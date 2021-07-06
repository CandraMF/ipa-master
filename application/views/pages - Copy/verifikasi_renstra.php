<?php
	$data=$this->input->post();
	if(!empty($data)){
		foreach($data as $key => $value){$$key = $this->andri->clean($value);}
	}else{
		$JENIS_CPCL=$this->uri->segment(6);	
		$KDKEGUNIT=$this->uri->segment(7);	
		$UNITKEY=$this->uri->segment(9);
	}
	

	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:"1";
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	$KDTAHAP=$_tahap;
 
	$row=$this->m_action->ambilData("select KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where UNITKEY='{$UNITKEY}'");
	$KDUNIT=$row->KDUNIT;
	$NMUNIT=$row->NMUNIT;
	
	
	$row=$this->m_action->ambilData("SELECT a.KDRENPROG, a.KDRENSKEG, a.KDPRGRM, b.KDKEGUNIT, concat(c.NOPRGRM,b.NOKEG) AS NOKEG, b.NMKEG FROM dbsipd_".$_tahun.".t_renstra_keg AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS c ON a.KDPRGRM=c.KDPRGRM WHERE  a.UNITKEY='{$UNITKEY}' AND a.KDKEGUNIT='{$KDKEGUNIT}'");
	foreach($row as $key => $value){$$key = $this->andri->clean($value);}
	


	//// Program
	$Qry="SELECT a.KDRENPROG, a.KDPRGRM, concat(b.NOPRGRM,' ',b.NMPRGRM) as NMPRGRM, c.NMPRIORITAS, d.NMSASARAN_DAERAH, a.BENEFIT_TOLOK_UKUR, a.BENEFIT_TARGET, a.OUTCOME_TOLOK_UKUR, a.OUTCOME_TARGET, f_tglind(a.TGLVALID) as TGLVALID FROM dbsipd_".$_tahun.".t_renstra_pgrm as a inner join dbsipd_".$_tahun.".t_rpjmd_pgrm as b on a.KDPRGRM=b.KDPRGRM LEFT JOIN dbsipd_".$_tahun.".mprioritas_daerah as c on a.KDPRIORITAS=c.KDPRIORITAS LEFT JOIN dbsipd_".$_tahun.".msasaran_derah AS d on a.KDSASARAN=d.KDSASARAN WHERE a.UNITKEY='".@$UNITKEY."'  ORDER BY b.NOPRGRM";
	$dt_pgrm=$this->m_auth->NaviPage($Qry, "PagePgrm", @$PagePgrm,"onchange=\"Fm.submit();\"");
	//// Kegiatan
	$Qry="SELECT a.KDRENSKEG,a.KDRENPROG, a.KDKEGUNIT, concat(b.NOKEG,'', b.NMKEG) as NMKEG, a.OUTPUT_TOLOK_UKUR, a.OUTPUT_TARGET, a.KETERANGAN, a.TARGET_5THN, a.DANA_5THN, f_tglind(a.TGLVALID) as TGLVALID FROM  dbsipd_".$_tahun.".t_renstra_keg AS a INNER JOIN  dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT WHERE a.KDKEGUNIT='".@$KDKEGUNIT."' and a.KDPRGRM='".@$KDPRGRM."' AND a.UNITKEY='".@$UNITKEY."'  ORDER BY b.NOKEG";
	$dt_keg=$this->m_auth->NaviPage($Qry, "PageKeg", @$PageKeg,"onchange=\"Fm.submit();\"");

	//// Jumlah Dana
	$Qry="SELECT a.KDRENDANA, a.TAHUN,a.PERSEN, a.PAGU, a.KUANTITAS, a.SATUAN, a.KETERANGAN, f_tglind(a.TGLVALID) as TGLVALID FROM  dbsipd_".$_tahun.".t_renstra_dana AS a  WHERE a.KDKEGUNIT='".@$KDKEGUNIT."' AND a.UNITKEY='".@$UNITKEY."'   ORDER BY a.TAHUN";
	$dt_dana=$this->m_auth->NaviPage($Qry, "PageDana", @$PageDana,"onchange=\"Fm.submit();\"");

?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>

<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
		 <!-- Data List Program -->
	  <div class="widget-content form-horizontal">		
			<input type="hidden" name="UNITKEY" id='UNITKEY' value='<?=@$UNITKEY?>'>
			<input type="hidden" name="KDKEGUNIT" id='KDKEGUNIT' value='<?=@$KDKEGUNIT?>'>
			<input type="hidden" name="KDPRGRM" id='KDPRGRM' value='<?=@$KDPRGRM?>'>
			<input type="hidden" name="KDRENSKEG" id='KDRENSKEG' value='<?=@$KDRENSKEG?>'>
			<input type="hidden" name="KDRENPROG" id='KDRENPROG' value='<?=@$KDRENPROG?>'>
			<input type="hidden" name="TGLVALID" id='TGLVALID' value='<?=date('Y-m-d')?>'>
			
			
			<div class="control-group">
              <label class="control-label">SKPD Tujuan</label>
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
			<div class="control-group">
              <label class="control-label"></label>
              <div class="controls">
                <button type="button" class="btn btn-primary" onclick="Fm.submit();">Reload</button>				
              </div>
            </div>	
			
	  </div>
	   <div class="widget-content">		
	   <!-- PROGRAM -->
	   <div class="alert alert-info"><strong>Program</strong> </div>
		<table class="table table-bordered table-striped with-check">
		  <thead>
		  <tr>			
			  <th rowspan=3 style='width:300px;'>Program </th>
			  <th rowspan=3>Prioritas Daerah </th>
			  <th rowspan=3>Sasaran Daerah</th>
			  <th colspan=4>Indikator Kinerja</th>	
			  <th rowspan=3>Aksi</th>
		   </tr>
		   <tr>
			  <th colspan=2>Capaian Program (Benefit)</th>
			  <th colspan=2>Program (Outcome)</th>			  
			</tr>
			<tr>
			  <th>Tolok Ukur</th>
			  <th>Target</th>
			  <th>Tolok Ukur</th>
			  <th>Target</th>
			</tr>
		  </thead>
		  <tbody>		   
			<?php			
			$i=1;
			$valid="";
			foreach ($dt_pgrm->query->result() as $row){
				if(empty($row->TGLVALID)||($row->TGLVALID=='00-00-0000')){
					$valid="<center><a href='#' id='validasi_program'><i class='icon icon-edit'></i> Validasi</a></center>";
				}else{
					$valid="<center><a href='#' id='unvalidasi_program'><i class='icon icon-edit'></i> Un Validasi</a></center>";
				}
				echo "    
				<tr>					
					<td>".$row->NMPRGRM."</td>
					<td>".$row->NMPRIORITAS."</td>
					<td>".$row->NMSASARAN_DAERAH."</td>
					<td>".$row->BENEFIT_TOLOK_UKUR."</td>
					<td>".$row->BENEFIT_TARGET."</td>
					<td>".$row->OUTCOME_TOLOK_UKUR."</td>
					<td>".$row->OUTCOME_TARGET."</td>
					<td align=center style='width:100px;'>".$valid."<br><center>".$row->TGLVALID."</center></td>
				</tr>
				";
				$i++;
			}			
			?>
		  </tbody>
		</table>
	   </div>
	   <div class="widget-content">		
			<!-- KEGIATAN -->
			<div class="alert alert-info"><strong>Kegiatan</strong> </div>
		
			<table class="table table-bordered table-striped with-check">
			  <thead>
			    <tr>						
				  <th style='width:300px;' rowspan=2>Kegiatan</th>
				  <th colspan=2>Indikator Kinerja (Output)</th>
				  <th rowspan=2>Catatan Penting</th>
				  <th colspan=2>Prakiraan Maju Renja 5 Tahun Terakhir</th>
				  <th rowspan=2>Aksi</th>
				</tr>
				<tr>
				  <th>Tolok Ukur</th>
				  <th>Target</th>
				  <th>Target</th>
				  <th>Kebutuhan Dana/Pagu Indikatif (Rp.)</th>
				</tr>
			  </thead>
			  <tbody>		 
				<?php			
				$i=1;$valid="";
				foreach ($dt_keg->query->result() as $row){
					if(empty($row->TGLVALID)||($row->TGLVALID=='00-00-0000')){
						$valid="<center><a href='#' id='validasi_kegiatan'><i class='icon icon-edit'></i> Validasi</a>	</center>	";
					}else{
						$valid="<center><a href='#' id='unvalidasi_kegiatan'><i class='icon icon-edit'></i> Un Validasi</a></center>";
					}
					echo "
					<tr>				
						<td >".$row->NMKEG."</td>
						<td>".$row->OUTPUT_TOLOK_UKUR."</td>
						<td>".$row->OUTPUT_TARGET."</td>
						<td>".$row->KETERANGAN."</td>
						<td>".$row->TARGET_5THN."</td>
						<td style='text-align:right;'>".$this->andri->cetakuang($row->DANA_5THN)."</td>						
						<td align=center style='width:100px;'>".$valid."<br><center>".$row->TGLVALID."</center></td>
					</tr>
					";
					$i++;
				}			
				?>
			  </tbody>
			</table>
	   </div>
	   <div class="widget-content">		
			<!-- DANA -->
			<div class="alert alert-info"><strong>Daftar Target Pendanaan</strong> [ <?=@$NMKEG?> ]</div>
			
			<table class="table table-bordered table-striped with-check">
			  <thead>
			   <tr>						
				  <th>Tahun</th>
				  <th>Persen</th>
				  <th>Pagu</th>
				  <th>Kuantitas</th>
				  <th>Satuan</th>
				  <th>Keterangan</th>
				</tr>
			  </thead>
			  <tbody>		 
				<?php			
				$i=1;
				foreach ($dt_dana->query->result() as $row){
					echo "
					<tr>				
						<td>".$row->TAHUN."</td>
						<td style='text-align:right;'>".floatval($row->PERSEN)." %</td>
						<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU)."</td>
						<td style='text-align:right;'>".$this->andri->cetakuang($row->KUANTITAS)."</td>				
						<td>".$row->SATUAN."</td>
						<td>".$row->KETERANGAN."</td>
						
					</tr>
					";
					$i++;
				}			
				?>
			  </tbody>
			</table>
	   </div>
	  
</div>
		
</form>


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
	$rowskpd=$this->m_action->ambilData("select length(trim(KDUNIT)) AS jchar2 from dbsipd_".$_tahun.".mskpd WHERE KDSTUNIT IN (1) limit 1");foreach($rowskpd as $key => $value){$$key = $this->andri->clean($value);}
	$rowskpd=$this->m_action->ambilData("select length(trim(KDUNIT)) AS jchar3 from dbsipd_".$_tahun.".mskpd WHERE KDSTUNIT IN (2) limit 1");foreach($rowskpd as $key => $value){$$key = $this->andri->clean($value);}
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
	$qry=$this->db->query("SELECT distinct b.KDPRGRM, b.NOPRGRM, b.NMPRGRM FROM dbsipd_".$_tahun.".t_renstra_keg  AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS b ON a.KDPRGRM=b.KDPRGRM WHERE  a.UNITKEY='{$UNITKEY}' ORDER BY b.NOPRGRM");$title_keg="";	
	foreach($qry->result() as $row){
		$qrysub=$this->db->query("SELECT distinct b.KDKEGUNIT, b.NOKEG, b.NMKEG FROM dbsipd_".$_tahun.".t_renstra_keg AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT WHERE  a.UNITKEY='{$UNITKEY}' AND a.KDPRGRM='".$row->KDPRGRM."'");$child_keg="";
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
	});
</script>	

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#validasi_program').click(function(){			
			var KDRENPROG=$('#KDRENPROG').val();
			var TGLVALID=$('#TGLVALID').val();
			var dataPost={KDRENPROG:KDRENPROG, TGLVALID:TGLVALID};
			$.post("<?=base_url('verifikasi/'.$Pr.'_program/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				setTimeout(function(){ Fm.submit(); }, 1000);				
			});
		});

		$('#validasi_kegiatan').click(function(){			
			var KDRENSKEG=$('#KDRENSKEG').val();
			var KDRENPROG=$('#KDRENPROG').val();
			var TGLVALID=$('#TGLVALID').val();
			var dataPost={KDRENPROG:KDRENPROG, KDRENSKEG:KDRENSKEG, TGLVALID:TGLVALID};
			$.post("<?=base_url('verifikasi/'.$Pr.'_kegiatan/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				setTimeout(function(){ Fm.submit(); }, 1000);			
			});
		});

		$('#unvalidasi_program').click(function(){			
			var KDRENPROG=$('#KDRENPROG').val();
			var TGLVALID='0000-00-00';
			var dataPost={KDRENPROG:KDRENPROG, TGLVALID:TGLVALID};
			$.post("<?=base_url('verifikasi/'.$Pr.'_program/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				setTimeout(function(){ Fm.submit(); }, 1000);				
			});
		});

		$('#unvalidasi_kegiatan').click(function(){			
			var KDRENSKEG=$('#KDRENSKEG').val();
			var KDRENPROG=$('#KDRENPROG').val();
			var TGLVALID='0000-00-00';
			var dataPost={KDRENPROG:KDRENPROG, KDRENSKEG:KDRENSKEG, TGLVALID:TGLVALID};
			$.post("<?=base_url('verifikasi/'.$Pr.'_kegiatan/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				setTimeout(function(){ Fm.submit(); }, 1000);			
			});
		});
	});	
</script>