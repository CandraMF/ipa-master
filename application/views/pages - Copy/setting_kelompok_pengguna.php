<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>
		 <!-- <span class="label label-info">
			<a href="<?=base_url('login/pages/'.$Pr.'/detail')?>"  style='color:white;padding:5px;' >
				<i class="icon icon-plus-sign"></i> Tambah
			</a>			
		 </span> -->
	  </div>
	  <div class="widget-content nopadding">		
		<table class="table table-bordered data-table">
		  <thead>
			<tr>
			  <th width='50'>Kode</th>
			  <th>Nama</th>
			  <th>Keterangan</th>	
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="select idgroupakses , nmgroupakses, keterangan from dbsipd_".$_tahun.".__t_group_akses where nmgroupakses!='Admin'";
				$TdAdd="
					<td align=center style='width:100px;'>
					<p align=center>
						<a href='".base_url('login/pages/'.$Pr.'/detail/edit/[/]row->idgroupakses[\]')."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						
					</p>
					</td>
				";
				$ArrData=array('');
				echo $this->m_auth->getTable($Qry,$TdAdd,$ArrData);
			?>
		  </tbody>
		</table>		
	  </div>
	</div>
</div>
<?php
	/*|
						<a href='".base_url("login/pages/".$Pr."/detail/hapus/[!>]row->idgroupakses[<!]")."'><i class='icon icon-remove'></i> Delete</a>*/
?>