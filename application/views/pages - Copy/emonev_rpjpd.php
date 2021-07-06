<?php
	$data=$this->input->post();
	if(!empty($data)){
		foreach($data as $key => $value){$$key = $this->andri->clean($value);}
	}else{
		$JENIS_CPCL=$this->uri->segment(6);	
		$KDKEGUNIT=$this->uri->segment(7);	
		$UNITKEY=$this->uri->segment(9);
	}

	
	$JENIS_TIPE=1;
	
	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:"1";
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	$KDTAHAP=$_tahap;
 
	$row=$this->m_action->ambilData("select KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where UNITKEY='{$UNITKEY}'");
	$KDUNIT=$row->KDUNIT;
	$NMUNIT=$row->NMUNIT;
	
	
	$row=$this->m_action->ambilData("SELECT a.KDRANCPROG, a.KDRANCKEG, a.KDPRGRM, b.KDKEGUNIT, concat(c.NOPRGRM,b.NOKEG) AS NOKEG, b.NMKEG FROM dbsipd_".$_tahun.".t_kegiatan_keg AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS c ON a.KDPRGRM=c.KDPRGRM WHERE a.KDTAHAP='{$KDTAHAP}' AND a.UNITKEY='{$UNITKEY}' AND a.KDKEGUNIT='{$KDKEGUNIT}'");
	
	
	$NOKEG=$row->NOKEG;
	$NMKEG=$row->NMKEG;
	$KDPRGRM=$row->KDPRGRM;
	$KDRANCKEG=$row->KDRANCKEG;
	$KDRANCPROG=$row->KDRANCPROG;
	
	$row=$this->m_action->ambilData("select JKUISIONER from dbsipd_".$_tahun.".e_jkuisioner where LINK_SUB='".$Pr."'");
	$JKUISIONER=$row->JKUISIONER;
	$KDTAHAP=$_tahap;
	

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
			<input type="hidden" name="KDTAHAP" id='KDTAHAP' value='<?=@$KDTAHAP?>'>
			
			
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
	  </div>
	  <div class="widget-content">		
		  <table class="table table-bordered table-striped with-check" >
		  <thead>
		   <tr>			
			  <th>No. Urut</th>
			  <th>Deskripsi</th>			 
			  <th>Aksi</th>
			  <th>Keterangan</th>
		   </tr>
		  </thead>
		  <tbody>		   
			<?php			
			$i=1;
			$qry=$this->db->query("SELECT a.IDKUISIONER, a.NMKUISIONER, b.KDOPTION, b.KDISIAN, b.ALASAN FROM dbsipd_".$_tahun.".e_mkuisioner AS a LEFT JOIN (SELECT `KDISIAN`, `IDKUISIONER`, `KDOPTION`, `ALASAN` FROM dbsipd_".$_tahun.".e_t_kuisioner WHERE `UNITKEY`='".@$UNITKEY."' and `KDTAHAP`='".@$KDTAHAP."' and `KDKEGUNIT`='".@$KDKEGUNIT."') AS b ON a.IDKUISIONER=b.IDKUISIONER WHERE a.JKUISIONER='".@$JKUISIONER."' ORDER BY a.URUTAN");
			foreach ($qry->result() as $row){	
				
				$sty=$row->KDOPTION=='2'?" style='background-color:#F9F9F9;width:95%;'":" style='display:none;' readonly";
				echo "    
				<tr>					
					<td><center>$i.</center></td>
					<td>".$row->NMKUISIONER."</td>
					<td>".$this->m_auth->cmbQuery('KDOPTION',@$row->KDOPTION,"select KDOPTION as '0', NMOPTION as '1' from dbsipd_".$_tahun.".e_moption","class='DATA_OPTION' data-isian='".@$row->KDISIAN."' data-id='".@$row->IDKUISIONER."' style='background-color:#F9F9F9;'")."</td>
					<td style='width:300px;'>
						<input type='text'  class='DATA_ALASAN' id='ALASAN' data-isian='".@$row->KDISIAN."' data-id='".@$row->IDKUISIONER."' value='".@$row->ALASAN."' ".$sty." class='span12'/>
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
	$qry=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and  KDSTUNIT IN (2) AND UNITKEY!='203' ORDER BY kdunit");$title_skpd="";	
	foreach($qry->result() as $row){
		$JL2=strlen(trim($row->KDUNIT));
		$qrysub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and KDSTUNIT IN (3) and left(KDUNIT,".$JL2.")='".$row->KDUNIT."'  AND UNITKEY!='203' ORDER BY kdunit");$child_skpd="";
		foreach($qrysub->result() as $rowsub){
			$JL3=strlen(trim($rowsub->KDUNIT));
			$qrysubsub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE JENIS_OPD!='KECAMATAN' and KDSTUNIT IN (4) and left(KDUNIT,".$JL3.")='".$rowsub->KDUNIT."'  AND UNITKEY!='203' ORDER BY kdunit");$child_skpdsub="";
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

	$qry=$this->db->query("SELECT b.KDPRGRM, b.NOPRGRM, b.NMPRGRM FROM dbsipd_".$_tahun.".t_kegiatan_keg  AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS b ON a.KDPRGRM=b.KDPRGRM WHERE a.KDTAHAP='{$KDTAHAP}' AND a.UNITKEY='{$UNITKEY}' ORDER BY b.NOPRGRM");$title_keg="";	
	foreach($qry->result() as $row){
		$qrysub=$this->db->query("SELECT b.KDKEGUNIT, b.NOKEG, b.NMKEG FROM dbsipd_".$_tahun.".t_kegiatan_keg AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT WHERE a.KDTAHAP='{$KDTAHAP}' AND a.UNITKEY='{$UNITKEY}' AND a.KDPRGRM='".$row->KDPRGRM."'");$child_keg="";
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
		$('.DATA_OPTION').change(function(){			
			var IDKUISIONER=$(this).attr("data-id")
			var KDISIAN=$(this).attr("data-isian")
			var KDOPTION=$(this).val();
			var KDKEGUNIT=$('#KDKEGUNIT').val();
			var ALASAN='';
			var UNITKEY=$('#UNITKEY').val();
			var KDPRGRM=$('#KDPRGRM').val();
			var KDTAHAP=$('#KDTAHAP').val();

			  
			var dataPost={KDISIAN:KDISIAN, IDKUISIONER:IDKUISIONER, KDOPTION:KDOPTION, KDKEGUNIT:KDKEGUNIT, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDTAHAP:KDTAHAP, ALASAN:ALASAN};
			$.post("<?=base_url('emonev/kuisioner/simpan')?>",dataPost,
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
		$('.DATA_ALASAN').change(function(){			
			var IDKUISIONER=$(this).attr("data-id")
			var KDISIAN=$(this).attr("data-isian")
			var KDKEGUNIT=$('#KDKEGUNIT').val();
			var ALASAN=$(this).val();
			var UNITKEY=$('#UNITKEY').val();
			var KDPRGRM=$('#KDPRGRM').val();
			var KDTAHAP=$('#KDTAHAP').val();

			  
			var dataPost={KDISIAN:KDISIAN, IDKUISIONER:IDKUISIONER,  KDKEGUNIT:KDKEGUNIT, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDTAHAP:KDTAHAP, ALASAN:ALASAN};
			$.post("<?=base_url('emonev/kuisioner_alasan/simpan')?>",dataPost,
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