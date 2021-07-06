<?php
	$data=$this->input->post();
	if(!empty($data)){
		foreach($data as $key => $value){$$key = $this->andri->clean($value);}
	}else{
		$JENIS_CPCL=$this->uri->segment(6);	
		$MTGKEY=$this->uri->segment(7);	
		$KDDEWAN=$this->uri->segment(8);
		$UNITKEY=$this->uri->segment(9);
	}
	

	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:"3";
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$KDDEWAN=!empty($KDDEWAN)?$KDDEWAN:"";
	$MTGKEY=!empty($MTGKEY)?$MTGKEY:"";
	$KDTAHAP=$_tahap;

	/*
	$UNITKEY=@$this->input->post('UNITKEY');
	$KDDEWAN=@$this->input->post('KDDEWAN');
	$MTGKEY=@$this->input->post('MTGKEY');
	*/
	 
	$wh="";
	if(!empty($_kddewan)){
		$KDDEWAN=$_kddewan;
		$wh=" and KDDEWAN='{$KDDEWAN}'";		
	}

	$row=$this->m_action->ambilData("select NODEWAN as NODEWAN, NMDEWAN AS NMDEWAN from dbsipd_".$_tahun.".mdprd where KDDEWAN='{$KDDEWAN}'");
	$NODEWAN=$row->NODEWAN;
	$NMDEWAN=$row->NMDEWAN;
	
	$dt_ppkd=$this->m_action->ambilData("select nmppkd from dbsipd_".$_tahun.".mppkd");
	
	$row=$this->m_action->ambilData("select UNITKEY ,KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where NMUNIT like '%".$dt_ppkd->nmppkd."%'");
	$UNITKEY=$row->UNITKEY;
	$KDUNIT=$row->KDUNIT;
	$NMUNIT=$row->NMUNIT;
	
	
	$row=$this->m_action->ambilData("SELECT MTGKEY, KDREK, NMREK FROM  dbsipd_".$_tahun.".mrekr WHERE   MTGKEY='".@$MTGKEY."' ORDER BY KDREK");
	
	
	$KDREK=$row->KDREK;
	$NMREK=$row->NMREK;
?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>

<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
		 <!-- Data List Program -->
	  <div class="widget-content form-horizontal">		
			<input type="hidden" name="UNITKEY" id='UNITKEY' value='<?=$UNITKEY?>'>
			<input type="hidden" name="MTGKEY" id='MTGKEY' value='<?=$MTGKEY?>'>
			<div class="control-group">
              <label class="control-label">Lampiran</label>
              <div class="controls">
                	<?=$this->m_auth->cmbQuery('JENIS_CPCL',@$JENIS_CPCL,"select JENIS_CPCL as '0', LAMPIRAN as '1' from dbsipd_".$_tahun.".t_lampiran where JENIS_CPCL in ('3','4')","onchange=\"Fm.submit();\"")?>					
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Dewan</label>
              <div class="controls">
				<?=$this->m_auth->cmbQuery('KDDEWAN',@$KDDEWAN,"select KDDEWAN as '0', concat(NODEWAN,'. ',NMDEWAN) as '1' from dbsipd_".$_tahun.".mdprd where NMDEWAN!='' AND KDDEWAN ".@$_qrydewan." order by NODEWAN asc","onchange=\"Fm.submit();\"")?>	
              </div>
            </div>
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
              <label class="control-label">Rekening</label>
              <div class="controls">
                <div class="input-append">
                  <input type="text" style='width:120px;' readonly  value='<?=$KDREK?>'>
                  <span class="add-on" id='rek'><i class='icon-search'></i></span> 
				 </div>
				 <input type="text" class="span6" readonly  value='<?=$NMREK?>'>		
              </div>
            </div>	
			<div class="control-group">
				 <label class="control-label"></label>
				 <div class="controls">
					<?php if(!empty($JENIS_CPCL)&&!empty($KDDEWAN)&&!empty($UNITKEY)&&!empty($MTGKEY)){ ?>
				 	<a href="<?=base_url('login/pages/'.$Pr.'/cpcl/param/'.$JENIS_CPCL.'/'.$MTGKEY.'/'.$KDDEWAN.'/'.$UNITKEY)?>" <?=$_pinsert?><button type="button" id='btnsimpan' class="btn btn-primary">Tambah</button></a>
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
			  <th>Rekening</th>
			  <th>Kegiatan Prioritas</th>
			  <th>Sasaran Kegiatan</th>
			  <th>Lokasi (Desa/Kel/Kec)	</th>
			  <th>Volume</th>
			  <th>Pagu</th>
			  <th>Penanggung Jawab</th>	
			  <th colspan=3>Aksi</th>
		   </tr>
		  </thead>
		  <tbody>		   
			<?php			
				$i=1;
				$qry=$this->db->query("SELECT a.KDCPCL, concat(e.KDREK,' ',e.NMREK) as NMREK, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PENANGGUNG_JAWAB, a.FOTO, a.TGLVALID FROM dbsipd_".$_tahun.".t_btl_cpcl AS a 
				LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
				LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
				INNER JOIN dbsipd_".$_tahun.".mrekr AS e ON a.MTGKEY=e.MTGKEY
				WHERE a.KDTAHAP='{$KDTAHAP}' AND a.KDDEWAN='{$KDDEWAN}' AND a.UNITKEY='{$UNITKEY}' AND a.MTGKEY='{$MTGKEY}' AND a.JENIS_CPCL='{$JENIS_CPCL}'");
				
				
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
					echo "    
					<tr>					
						<td align=center>".$i.".</td>
						<td><a href='".base_url($FOTO)."' target='_blank'>".$row->NMREK."</a></td>
						<td>".$row->KEGIATAN_PRIORITAS."</td>
						<td>".$row->SASARAN_KEGIATAN."</td>
						<td>".$row->LOKASI."</td>
						<td>".$row->VOLUME."</td>
						<td align=right>".$this->andri->cetakuang($row->PAGU)."</td>
						<td>".$row->PENANGGUNG_JAWAB."</td>
						<td>
							<center ".$valid.">
								".$this->andri->cmbUmum("cmbAksi","",$ArrCmbUmum,"data-id='".@$row->KDCPCL."' class='cmbAksi' style='width:80px;'")."
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

	$qry=$this->db->query("SELECT MTGKEY, KDREK, NMREK FROM dbsipd_".$_tahun.".mrekr WHERE LEFT(KDREK,6) IN ('5.1.4.','5.1.5.','5.1.6.','5.1.7.') AND KDSTREK='3'  ORDER BY KDREK ");$title_rekening="";	
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