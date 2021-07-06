<?php
	$data=$this->input->post();
	if(!empty($data)){
		foreach($data as $key => $value){$$key = $this->andri->clean($value);}
	}else{
		$JENIS_CPCL=$this->uri->segment(6);	
		$KDKEGUNIT=$this->uri->segment(7);	
		$UNITKEY=$this->uri->segment(9);
	}
	$KDTAHAP=$_tahap;

	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:"1";
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	$KDTAHAP=$_tahap;
 
	$row=$this->m_action->ambilData("select KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where UNITKEY='{$UNITKEY}'");
	$KDUNIT=$row->KDUNIT;
	$NMUNIT=$row->NMUNIT;


	//// Rekening
	$Qry="SELECT a.MTGKEY, a.KDREK, a.NMREK, b.NILAI FROM dbsipd_".$_tahun.".mrekr AS a LEFT JOIN (SELECT MTGKEY, NILAI FROM dbsipd_".$_tahun.".t_raskrtl WHERE UNITKEY='".@$UNITKEY."' AND KDTAHAP='".$KDTAHAP."') AS  b ON a.MTGKEY=b.MTGKEY WHERE LEFT(a.KDREK,3)='5.1' AND a.KDSTREK='3'";
	$dt_rek=$this->m_auth->NaviPage($Qry, "PageRek", @$PageRek,"onchange=\"Fm.submit();\"");

	$hidden=empty($UNITKEY)?"style='display:none;'":"";
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
			<input type="hidden" name="KDTAHAP" id='KDTAHAP' value='<?=@$KDTAHAP?>'>
			
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
		
	  </div>
	    <div class="widget-content" <?=$hidden?>>	
	   <!-- PROGRAM -->
	   <div class="alert alert-info"><strong>Jenis Rekening </strong> </div>
		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th>Kode Rekening</th>
			  <th>Rekening</th>
			  <th>Nilai</th>
			  <th>Aksi</th>
		   </tr>		   
		  </thead>
		  <tbody>		   
			<?php			
			$i=1;
			$valid="";
			foreach ($dt_rek->query->result() as $row){			
				echo "    
				<tr>					
					<td>".$row->KDREK."</td>
					<td>".$row->NMREK."</td>
					<td style='text-align:right;'>".$this->andri->cetakuang($row->NILAI)."</td>
					<td style='width:200px;'>
						<input type='text'  class='DATA_NILAI' data-id='".@$row->MTGKEY."' value='".floatval(@$row->NILAI)."' style='text-align:right;' class='span12'/>
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
	$rowskpd=$this->m_action->ambilData("select length(trim(KDUNIT)) AS jchar2 from dbsipd_".$_tahun.".mskpd WHERE   KDSTUNIT IN (1) limit 1");foreach($rowskpd as $key => $value){$$key = $this->andri->clean($value);}
	$rowskpd=$this->m_action->ambilData("select length(trim(KDUNIT)) AS jchar3 from dbsipd_".$_tahun.".mskpd WHERE   KDSTUNIT IN (2) limit 1");foreach($rowskpd as $key => $value){$$key = $this->andri->clean($value);}
	////////////// SKPD
	$qry=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE   KDSTUNIT IN (1) AND UNITKEY!='203' AND KDUNIT IN (SELECT LEFT(KDUNIT,".$jchar2.") FROM dbsipd_".$_tahun.".mskpd WHERE UNITKEY ".$_qryopd.") ORDER BY kdunit");$title_skpd="";	
	foreach($qry->result() as $row){
		$JL2=strlen(trim($row->KDUNIT));
		$qrysub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE  KDSTUNIT IN (2) and left(KDUNIT,".$JL2.")='".$row->KDUNIT."' AND KDUNIT IN (SELECT LEFT(KDUNIT,".$jchar3.") FROM dbsipd_".$_tahun.".mskpd WHERE UNITKEY ".$_qryopd.")AND UNITKEY!='203' ORDER BY kdunit");$child_skpd="";
		foreach($qrysub->result() as $rowsub){
			$JL3=strlen(trim($rowsub->KDUNIT));
			$qrysubsub=$this->db->query("SELECT UNITKEY, KDUNIT, NMUNIT, KDSTUNIT FROM dbsipd_".$_tahun.".mskpd WHERE  KDSTUNIT IN (3) and left(KDUNIT,".$JL3.")='".$rowsub->KDUNIT."'  AND UNITKEY!='203'  AND UNITKEY ".$_qryopd."  ORDER BY kdunit");$child_skpdsub="";
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
		
	});
</script>	

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('.DATA_NILAI').change(function(){			
			var MTGKEY=$(this).attr("data-id");		
			var NILAI=$(this).val();
			var UNITKEY=$('#UNITKEY').val();		
			var KDTAHAP=$('#KDTAHAP').val();
			  
			var dataPost={MTGKEY:MTGKEY, NILAI:NILAI, UNITKEY:UNITKEY, KDTAHAP:KDTAHAP};
			$.post("<?=base_url('prarka/'.$Pr.'/simpan')?>",dataPost,
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