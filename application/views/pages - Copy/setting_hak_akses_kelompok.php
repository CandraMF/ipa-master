<?php
	$display=!empty($idgroupakses)?"":"style='display:none;'";
?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>
<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
		 <!-- Data List Program -->
	  <div class="widget-content">		
		
		<table width='100%' border=0>
		<tr>	
			<td width='70%'>
				<table width='100%'>
				<tr>
					<td width='10'>Kelompok&nbsp;Akses: </td>
					<td><?=$this->m_auth->cmbQuery('idgroupakses',@$idgroupakses,"select idgroupakses as '0', nmgroupakses as '1' FROM dbsipd_".$_tahun.".__t_group_akses","class='span12' onchange=\"Fm.submit();\"")?></td>
				</tr>
				</table>
			</td>
			
		</tr>
		</table>

		<table class="table table-bordered table-striped with-check" <?=$display?>>
		  <thead>
		   <tr>			
			  <th>No. Urut</th>
			  <th>Menu</th>
			  <th>View</th>
			  <th>Insert</th>
			  <th>Update</th>
			  <th>Delete</th>
		   </tr>
		  </thead>
		  <tbody>		   
			<?php			
			$i=1;
			$qry=$this->db->query("SELECT a.id_main, 0 as id_sub, a.nama_menu AS menu, 1 AS levelmenu, c.id_main as valid_main, c.id_sub as valid_sub, c.pinsert, c.pupdate, c.pdelete FROM dbsipd_".$_tahun.".__t_mainmenu AS a LEFT JOIN (SELECT id_main, id_sub, pinsert, pupdate, pdelete from dbsipd_".$_tahun.".__t_hak_akses WHERE idgroupakses='".@$idgroupakses."' AND id_sub='0' ) AS c ON a.id_main=c.id_main WHERE a.aktif='Y' ORDER BY a.urutan");
			foreach ($qry->result() as $row){	
				$cek=$row->id_main==$row->valid_main?"checked":"";
				echo "    
				<tr>					
					<td style='background-color:#FF6666;font-weight:bold;color:white;'>$i.</td>
					<td style='background-color:#FF6666;font-weight:bold;color:white;width:400px;'>".str_replace(' ','&nbsp;',$row->menu)."</td>
					<td style='background-color:#FF6666;font-weight:bold;color:white;'><center><input type='checkbox' ".$cek." value='".$row->id_main.'|'.$row->id_sub."' class='viewdata' id='viewdata_".$i."_0'/></center></td>
					<td style='background-color:#FF6666;font-weight:bold;color:white;'></td>
					<td style='background-color:#FF6666;font-weight:bold;color:white;'></td>
					<td style='background-color:#FF6666;font-weight:bold;color:white;'></td>
				</tr>
				";
				$qrysub=$this->db->query("SELECT a.id_main, a.id_sub, a.nama_sub AS menu, 2 AS levelmenu, b.id_main as valid_main, b.id_sub as valid_sub, b.pinsert, b.pupdate, b.pdelete FROM dbsipd_".$_tahun.".__t_submenu AS a LEFT JOIN (SELECT id_main, id_sub, pinsert, pupdate, pdelete FROM dbsipd_".$_tahun.".__t_hak_akses WHERE idgroupakses='".@$idgroupakses."' AND id_sub!='0') AS b ON a.id_main=b.id_main AND a.id_sub=b.id_sub WHERE a.id_main='".$row->id_main."' and a.aktif='Y'  ORDER BY a.urutan_submenu");
				
				$z=1;
				foreach ($qrysub->result() as $rowsub){
					$cek=$rowsub->id_sub==$rowsub->valid_sub?"checked":"";
					$pinsert=$rowsub->pinsert=="Y"?"checked":"";
					$pupdate=$rowsub->pupdate=="Y"?"checked":"";
					$pdelete=$rowsub->pdelete=="Y"?"checked":"";
					echo "    
					<tr>					
						<td>$i.$z.</td>
						<td style='width:400px;'>".str_replace(' ','&nbsp;',$rowsub->menu)."</td>
						<td><center><input type='checkbox' ".$cek." value='".$rowsub->id_main.'|'.$rowsub->id_sub."|_".$i."_".$z."' class='viewdata' id='viewdata_".$i."_".$z."'/></center></td>
						<td><center><input type='checkbox' value='".$rowsub->id_main."|".$rowsub->id_sub."|viewdata_".$i."_".$z."' class='insertdata' ".$pinsert." id='pinsert_".$i."_".$z."'/></center></td>
						<td><center><input type='checkbox' value='".$rowsub->id_main.'|'.$rowsub->id_sub."|viewdata_".$i."_".$z."' class='updatedata' ".$pupdate." id='pupdate_".$i."_".$z."'/></center></td>
						<td><center><input type='checkbox' value='".$rowsub->id_main.'|'.$rowsub->id_sub."|viewdata_".$i."_".$z."' class='deletedata' ".$pdelete." id='pdelete_".$i."_".$z."'/></center></td>
					</tr>
					";
					$z++;
				}	
				
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
		
		$('.viewdata').click(function(){	
			var valdata=$(this).val();	
			var idgroupakses=$('#idgroupakses').val();	
			
			var dataPost={idgroupakses:idgroupakses, valdata:valdata};
			$.post("<?=base_url('pengaturan/'.$Pr.'/viewdata')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				if(data.idviewdata!=0){
					$('#pinsert'+data.idviewdata).attr('checked', false);
					$('#pupdate'+data.idviewdata).attr('checked', false);
					$('#pdelete'+data.idviewdata).attr('checked', false);
				}
			});		
		});

		$('.insertdata').click(function(){	
			var valdata=$(this).val();	
			var idgroupakses=$('#idgroupakses').val();	
		
			var dataPost={idgroupakses:idgroupakses, valdata:valdata};
			$.post("<?=base_url('pengaturan/'.$Pr.'/insertdata')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				if(data.idviewdata!=0){
					$('#'+data.idviewdata).attr('checked', true);
				}				
			});		
		});

		$('.updatedata').click(function(){	
			var valdata=$(this).val();	
			var idgroupakses=$('#idgroupakses').val();	
			
			var dataPost={idgroupakses:idgroupakses, valdata:valdata};
			$.post("<?=base_url('pengaturan/'.$Pr.'/updatedata')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				if(data.idviewdata!=0){
					$('#'+data.idviewdata).attr('checked', true);
				}				
			});		
		});

		$('.deletedata').click(function(){	
			var valdata=$(this).val();	
			var idgroupakses=$('#idgroupakses').val();	
			
			var dataPost={idgroupakses:idgroupakses, valdata:valdata};
			$.post("<?=base_url('pengaturan/'.$Pr.'/deletedata')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				if(data.idviewdata!=0){
					$('#'+data.idviewdata).attr('checked', true);
				}				
			});		
		});
	});	
</script>

