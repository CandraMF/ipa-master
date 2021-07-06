<?php
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	$KDTAHAP=$_tahap;
	$hidden=empty($KDBIDANG)?"style='display:none;'":"";
?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>

<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
	  <!-- Data List Program -->
	  <div class="widget-content">		
		<div class="alert alert-info"><strong>Maping SKPD</strong></div>
		<table width='100%'>
		<tr>
			<td>Bidang&nbsp;: </td>
			<td width='500'><?=$this->m_auth->cmbQuery('KDBIDANG',@$KDBIDANG,"select KDBIDANG as '0', NMBIDANG as '1' from dbsipd_".$_tahun.".mbidang","class='span10' onchange=\"Fm.submit();\"")?></td>
			<td>Sub.&nbsp;Bidang&nbsp;: </td>
			<td width='500'><?=$this->m_auth->cmbQuery('KDSUBBIDANG',@$KDSUBBIDANG,"select KDSUBBIDANG as '0', NMSUBBIDANG as '1' from dbsipd_".$_tahun.".mbidang_sub where KDBIDANG='".@$KDBIDANG."'","class='span10'  onchange=\"Fm.submit();\"")?></td>
		</tr>
		</table>
		
		<table class="table table-bordered table-striped with-check" <?=$hidden?>>
		  <thead>
		   <tr>			
			  <th>Kode SKPD</th>
			  <th style='width:300px;'>SKPD </th>
			  <th width='10'>Aksi</th>
		   </tr>
		
		  </thead>
		  <tbody>		   
			<?php			
			$i=1;
			$qry=$this->db->query("SELECT a.UNITKEY, a.KDUNIT, a.NMUNIT, b.UNITKEY AS UNITKEY_BIDANG FROM dbsipd_".$_tahun.".mskpd AS a LEFT JOIN (SELECT UNITKEY FROM dbsipd_".$_tahun.".mbidang_skpd WHERE KDBIDANG='".@$KDBIDANG."' and KDSUBBIDANG='".@$KDSUBBIDANG."') AS b ON a.UNITKEY=b.UNITKEY WHERE a.KDSTUNIT='3' ORDER BY KDUNIT");
			foreach ($qry->result() as $row){
				$Cek=$row->UNITKEY==$row->UNITKEY_BIDANG?"checked":"";		
				echo "    
				<tr>				
					<td>".$row->KDUNIT."</td>
					<td>".$row->NMUNIT."</td>
					<td><center><input type='checkbox' value='".$row->UNITKEY."' class='cek_skpd' ".$Cek."></center></td>					
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
<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('.cek_skpd').click(function(){	
		
			var UNITKEY=$(this).val();
			var KDBIDANG=$('#KDBIDANG').val();
			var KDSUBBIDANG=$('#KDSUBBIDANG').val();
			
			var dataPost={UNITKEY:UNITKEY, KDBIDANG:KDBIDANG, KDSUBBIDANG:KDSUBBIDANG};
			$.post("<?=base_url('daftar/'.$Pr.'/simpan')?>",dataPost,
			function(data){	
				
			});
		});
	});	
</script>

