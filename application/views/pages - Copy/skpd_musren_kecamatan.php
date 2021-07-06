<?php
	$data=$this->input->post();
	if(!empty($data)){
		foreach($data as $key => $value){$$key = $this->andri->clean($value);}
	}else{
		$JENIS_CPCL=$this->uri->segment(6);	
		$KDKEGUNIT=$this->uri->segment(7);	
		$UNITKEY_KEC=$this->uri->segment(8);
		$UNITKEY=$this->uri->segment(9);
	}
	

	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:"1";
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$URUSKEY=!empty($URUSKEY)?$URUSKEY:"";
	$UNITKEY_KEC=!empty($UNITKEY_KEC)?$UNITKEY_KEC:"";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	$KDTAHAP=$_tahap;

	/*
	$UNITKEY=@$this->input->post('UNITKEY');
	$UNITKEY_KEC=@$this->input->post('UNITKEY_KEC');
	$KDKEGUNIT=@$this->input->post('KDKEGUNIT');
	*/
	 
	$sty="";
	if(!empty($_idkec)){
		$UNITKEY_KEC=$_idkec;
		$sty="style='display:none;'";		
	}
	$row=$this->m_action->ambilData("select KDUNIT as KDUNIT_KEC, NMUNIT AS NMUNIT_KEC from dbsipd_".$_tahun.".mskpd where UNITKEY='{$UNITKEY_KEC}'");
	$KDUNIT_KEC=$row->KDUNIT_KEC;
	$NMUNIT_KEC=$row->NMUNIT_KEC;
	
 
	$row=$this->m_action->ambilData("select KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where UNITKEY='{$UNITKEY}'");
	$KDUNIT=$row->KDUNIT;
	$NMUNIT=$row->NMUNIT;
	
	$row=$this->m_action->ambilData("SELECT distinct b.KDPRGRM, b.KDKEGUNIT, concat(c.NOPRGRM,b.NOKEG) AS NOKEG, b.NMKEG, c.UNITKEY AS URUSKEY  FROM dbsipd_".$_tahun.".t_rpjmd_keg AS b  INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS c ON b.KDPRGRM=c.KDPRGRM WHERE  b.KDKEGUNIT='{$KDKEGUNIT}'");

	
	
	$NOKEG=$row->NOKEG;
	$NMKEG=$row->NMKEG;
	$URUSKEY=!empty($URUSKEY)?$URUSKEY:$row->URUSKEY;
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:$row->KDKEGUNIT;
	$KDPRGRM=!empty($KDPRGRM)?$KDPRGRM:$row->KDPRGRM;
?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>

<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
		 <!-- Data List Program -->
	  <div class="widget-content form-horizontal">		
					
			<div class="control-group">
              <label class="control-label">Lampiran</label>
              <div class="controls">
                	<?=$this->m_auth->cmbQuery('JENIS_CPCL',@$JENIS_CPCL,"select JENIS_CPCL as '0', LAMPIRAN as '1' from dbsipd_".$_tahun.".t_lampiran where JENIS_CPCL in ('1','2')","onchange=\"Fm.submit();\"")?>					
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Kecamatan</label>
              <div class="controls">
				 
                 <?php
					
					if(TRIM($_qrykec)=="NOT IN ('')"){
						echo $this->m_auth->cmbQuery('UNITKEY_KEC',@$UNITKEY_KEC,"SELECT UNITKEY  as '0', concat(KDUNIT,' ' ,NMUNIT) as '1' FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD='KECAMATAN' and KDSTUNIT IN (3)  AND UNITKEY!='203' ORDER BY kdunit","onchange=\"Fm.submit();\"");
					}else{
						echo $this->m_auth->cmbQuery('UNITKEY_KEC',@$UNITKEY_KEC,"SELECT UNITKEY  as '0', concat(KDUNIT,' ' ,NMUNIT) as '1' FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD='KECAMATAN' and KDSTUNIT IN (3) AND UNITKEY ".$_qrykec." AND UNITKEY!='203' ORDER BY kdunit","onchange=\"Fm.submit();\"");
					}
					
				?>				
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">SKPD Tujuan</label>
              <div class="controls">
				 <?=$this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"SELECT DISTINCT a.UNITKEY  as '0', concat(a.KDUNIT,' ' ,a.NMUNIT) as '1' FROM dbsipd_".$_tahun.".mskpd  AS a where a.KDSTUNIT='3' ORDER BY a.KDUNIT","onchange=\"Fm.submit();\"")?>	
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Urusan</label>
              <div class="controls">
                	<?=$this->m_auth->cmbQuery('URUSKEY',@$URUSKEY,"select a.UNITKEY  as '0', a.NMUNIT as '1' from (SELECT UNITKEY, concat(KDUNIT,' ' ,NMUNIT) as 'NMUNIT'  FROM dbsipd_".$_tahun.".mskpd WHERE UNITKEY='203' union SELECT DISTINCT a.URUSKEY AS UNITKEY, concat(b.KDUNIT,' ' ,b.NMUNIT) as 'NMUNIT' FROM dbsipd_".$_tahun.".mskpd_urusan AS a INNER JOIN dbsipd_".$_tahun.".mskpd AS b on a.URUSKEY=b.UNITKEY where a.UNITKEY='{$UNITKEY}') AS a order by a.NMUNIT","onchange=\"Fm.submit();\"")?>				
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Program</label>
              <div class="controls">
                	<?=$this->m_auth->cmbQuery('KDPRGRM',@$KDPRGRM,"SELECT DISTINCT a.KDPRGRM  as '0', concat(a.NOPRGRM,' ' ,a.NMPRGRM) as '1' FROM dbsipd_".$_tahun.".t_rpjmd_pgrm  AS a  WHERE a.UNITKEY ='{$URUSKEY}' or a.UNITKEY='203'  ORDER BY a.NOPRGRM","onchange=\"Fm.submit();\"")?>					
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Kegiatan</label>
              <div class="controls">
                	<?=$this->m_auth->cmbQuery('KDKEGUNIT',@$KDKEGUNIT,"SELECT distinct b.KDKEGUNIT  as '0', concat(b.NOKEG,' ',b.NMKEG) as '1' FROM dbsipd_".$_tahun.".t_rpjmd_keg AS b WHERE  b.KDPRGRM='".$KDPRGRM."'","onchange=\"Fm.submit();\"")?>					
              </div>
            </div>
			<div class="control-group">
              <label class="control-label"></label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" style='width:120px;' readonly  value='<?=$NOKEG?>'>
                  
				 </div>
				 <input type="text" class="span6" readonly  value='<?=$NMKEG?>'>		
              </div>
            </div>	

			<div class="control-group">
				 <label class="control-label"></label>
				 <div class="controls">
					<?php if(!empty($JENIS_CPCL)&&!empty($KDKEGUNIT)&&!empty($UNITKEY_KEC)){ ?>
				 	<a href="<?=base_url('login/pages/'.$Pr.'/cpcl/param/'.$JENIS_CPCL.'/'.$KDKEGUNIT.'/'.$UNITKEY_KEC.'/'.$UNITKEY)?>" ><button type="button" id='btnsimpan' class="btn btn-primary" <?=$_pinsert?>>Tambah</button></a>
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
			  <th>Kegiatan Prioritas</th>	  
			  <th>Sasaran Kegiatan</th>
			  <th>Program</th>
			
			  <th>Lokasi (Desa/Kel/Kec)	</th>
			  <th>Volume</th>
			  <th>Pagu</th>
			  <th>Penanggung Jawab</th>			
			  <th>Aksi</th>
		   </tr>
		  </thead>
		  <tbody>		   
			<?php			
				$i=1;
				$qry=$this->db->query("SELECT distinct a.KDCPCL, f.NMPRGRM, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PENANGGUNG_JAWAB, a.FOTO, a.TGLVALID FROM dbsipd_".$_tahun.".t_kegiatan_cpcl AS a 
				LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
				LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
				INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT
				INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS f ON e.KDPRGRM=f.KDPRGRM
				
				WHERE a.KDTAHAP='{$KDTAHAP}' AND a.UNITKEY_KEC='{$UNITKEY_KEC}' AND a.UNITKEY='{$UNITKEY}' AND a.KDKEGUNIT='{$KDKEGUNIT}' AND a.JENIS_CPCL='{$JENIS_CPCL}'");
			
				$i=1;
				foreach ($qry->result() as $row){	
					$FOTO=!empty($row->FOTO)?$row->FOTO:"assets/img-cpcl/photo.png";
					if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00'))
					{
						$valid="";$TGLVALID="";$ArrCmbUmum=array();
						if(empty($_pupdate)){$ArrCmbUmum[]='Upload Foto';$ArrCmbUmum[]='Edit';}
						if(empty($_pdelete)){$ArrCmbUmum[]='Delete';}
					}else{
						$valid="style='display:none;'";
						$TGLVALID=$row->TGLVALID;
						$ArrCmbUmum=array();
					}
					//".$this->andri->cmbUmum("cmbAksi","",$ArrCmbUmum,"data-id='".@$row->KDCPCL."' class='cmbAksi' style='width:80px;'")."
					echo "    
					<tr>					
						<td align=center>".$i.".</td>
						<td><a href='".base_url($FOTO)."' target='_blank'>".$row->KEGIATAN_PRIORITAS."</a></td>			
						<td>".$row->SASARAN_KEGIATAN."</td>
						<td>".$row->NMPRGRM."</td>						
						<td>".$row->LOKASI."</td>
						<td>".$row->VOLUME."</td>
						<td align=right>".$this->andri->cetakuang($row->PAGU)."</td>
						<td>".$row->PENANGGUNG_JAWAB."</td>
						<td>
							<center ".$valid.">
								<table celpadding=0 cellspacing=0>
								<tr>
									<td style='border:0px;padding:1px;'><a href='".base_url('login/pages/'.$Pr.'/cpcl/edit/'.$row->KDCPCL)."'><button type='button' class='btn btn-primary'>Edit</button></a></td>

									<td style='border:0px;padding:1px;'><a href='".base_url('login/pages/'.$Pr.'/upload-foto/edit/'.$row->KDCPCL)."'><button type='button' class='btn btn-primary'>Upload&nbsp;Foto</button></a></td>
								
									
								
									<td style='border:0px;padding:1px;'><a href='".base_url('login/pages/'.$Pr.'/cpcl/hapus/'.$row->KDCPCL)."'><button type='button' class='btn btn-primary' style='background-color:#ff3300;'>Hapus</button></a></td>
								</tr>
								</table>
							<br>
							
							
							</center><br>
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
</div>
		
</form>

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
	////////////// KEC
	$qry=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD='KECAMATAN' and KDSTUNIT IN (1) AND UNITKEY!='203' ORDER BY kdunit");$title_kec="";	
	foreach($qry->result() as $row){
		$JL2=strlen(trim($row->KDUNIT));
		$qrysub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD='KECAMATAN' and  KDSTUNIT IN (2) and left(KDUNIT,".$JL2.")='".$row->KDUNIT."'  AND UNITKEY!='203' ORDER BY kdunit");$child_kec="";
		foreach($qrysub->result() as $rowsub){
			$JL3=strlen(trim($rowsub->KDUNIT));
			$qrysubsub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD='KECAMATAN' and KDSTUNIT IN (3) and left(KDUNIT,".$JL3.")='".$rowsub->KDUNIT."' AND UNITKEY ".$_qrykec." AND UNITKEY!='203' ORDER BY kdunit");$child_kecsub="";
			foreach($qrysubsub->result() as $rowsubsub){
				$child_kecsub.='{title: "'.$rowsubsub->KDUNIT.' '.$rowsubsub->NMUNIT.'", key: "'.$rowsubsub->UNITKEY.'" },';
			}
			$child_kec.='{title: "'.$rowsub->KDUNIT.' '.$rowsub->NMUNIT.'", isFolder: true,
					children: [
						'.substr($child_kecsub,0,-1).'		
					]
				},';
		}
		$title_kec.='{title: "'.$row->KDUNIT.' '.$row->NMUNIT.'", isFolder: true,
			children: [
				'.substr($child_kec,0,-1).'				
			]
		},';		
	}

	////////////// SKPD
	/*
	$rowskpd=$this->m_action->ambilData("select length(trim(KDUNIT)) AS jchar2 from dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and  KDSTUNIT IN (2) limit 1");foreach($rowskpd as $key => $value){$$key = $this->andri->clean($value);}
	$rowskpd=$this->m_action->ambilData("select length(trim(KDUNIT)) AS jchar3 from dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and  KDSTUNIT IN (2) limit 1");foreach($rowskpd as $key => $value){$$key = $this->andri->clean($value);}
	////////////// SKPD
	$qry=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and  KDSTUNIT IN (1) AND UNITKEY!='203' AND KDUNIT IN (SELECT LEFT(KDUNIT,".$jchar2.") FROM dbsipd_".$_tahun.".mskpd ) ORDER BY kdunit");$title_skpd="";	
	foreach($qry->result() as $row){
		$JL2=strlen(trim($row->KDUNIT));
		$qrysub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and KDSTUNIT IN (2) and left(KDUNIT,".$JL2.")='".$row->KDUNIT."' AND KDUNIT IN (SELECT LEFT(KDUNIT,".$jchar3.") FROM dbsipd_".$_tahun.".mskpd )AND UNITKEY!='203' ORDER BY kdunit");$child_skpd="";
		foreach($qrysub->result() as $rowsub){
			$JL3=strlen(trim($rowsub->KDUNIT));
			$qrysubsub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and KDSTUNIT IN (3) and left(KDUNIT,".$JL3.")='".$rowsub->KDUNIT."'  AND UNITKEY!='203'   ORDER BY kdunit");$child_skpdsub="";
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
	*/
	////////////// KEGIATAN
/*
	$qry=$this->db->query("SELECT DISTINCT a.KDPRGRM, a.NOPRGRM ,a.NMPRGRM FROM dbsipd_".$_tahun.".t_rpjmd_pgrm  AS a  WHERE a.UNITKEY IN (SELECT URUSKEY FROM dbsipd_".$_tahun.".mskpd_urusan WHERE UNITKEY='{$UNITKEY}')   ORDER BY a.NOPRGRM");$title_keg="";	
	foreach($qry->result() as $row){
		
		$qrysub=$this->db->query("SELECT distinct b.KDKEGUNIT, b.NOKEG, b.NMKEG FROM dbsipd_".$_tahun.".t_rpjmd_keg AS b WHERE  b.KDPRGRM='".$row->KDPRGRM."'");$child_keg="";
		foreach($qrysub->result() as $rowsub){
			$child_keg.='{title: "'.$row->KDPRGRM.$rowsub->NOKEG.' '.$rowsub->NMKEG.'", key: "'.$rowsub->KDKEGUNIT.'"},';
		}
		$title_keg.='{
			title: "'.$row->KDPRGRM.' '.$row->NMPRGRM.'", isFolder: true, 
				children: [ 
					'.substr($child_keg,0,-1).'
				] 
		},';		
	}*/
?>

<script type="text/javascript">	
	$( document ).ready(function() {	
		var treeData = [ <?=substr($title_skpd,0,-1)?> ];
		var treeDataKec = [ <?=substr($title_kec,0,-1)?> ];
		
		////////// SKPD
		$("#tree_kec").dynatree({
			onActivate: function(node) {			
				Fm.UNITKEY_KEC.value=node.data.key;Fm.submit();
			},
			children: treeDataKec
		});

		$('#kec').click(function(){	
			$('#popkec').modal('show'); 
		});

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
			var KDCPCL=$(this).attr("data-id");			
			switch(cmbData) {			 
			  case "Upload Foto":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/upload-foto/edit/')?>"+KDCPCL;
			  break;
			  case "Edit":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/cpcl/edit/')?>"+KDCPCL;
			  break;
			  case "Delete":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/cpcl/hapus/')?>"+KDCPCL;
			  break;
			}   
		});
	});
</script>	