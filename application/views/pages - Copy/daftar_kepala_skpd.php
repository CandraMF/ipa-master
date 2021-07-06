<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>
		 <span class="label label-info" <?=$_pinsert?>>
			<a href="<?=base_url('login/pages/'.$Pr.'/detail')?>"  style='color:white;padding:5px;' >
				<i class="icon icon-plus-sign"></i> Tambah
			</a>
			
			
		 </span>
	  </div>
	  <div class="widget-content nopadding">		
		<table class="table table-bordered data-table">
		  <thead>
			<tr>
			  <th width='50'>Kode</th>			
			  <th>Unit Organisasi</th>
			  <th>NIP</th>
			  <th>Nama</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="SELECT c.UNITKEY, c.KDUNIT, c.NMUNIT, b.NIP, b.NAMA FROM dbsipd_".$_tahun.".mpegawai_pa AS a INNER JOIN dbsipd_".$_tahun.".mpegawai AS b ON a.KDPEG=b.KDPEG INNER JOIN dbsipd_".$_tahun.".mskpd AS c ON a.UNITKEY=c.UNITKEY ORDER BY c.KDUNIT, b.NAMA";
				$TdAdd="
					<td align=center style='width:100px;'>
					<p align=center>
						<a href='".base_url('login/pages/'.$Pr.'/detail/edit/[/]row->UNITKEY[\]')."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/detail/hapus/[!>]row->UNITKEY[<!]")."'".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
					</p>
					</td>
				";
				$ArrData=array('UNITKEY');
				$arrFilterAdd=array('UNITKEY');
				echo $this->m_auth->getTable($Qry,$TdAdd,$ArrData,$arrFilterAdd);
			?>
		  </tbody>
		</table>		
	  </div>
	</div>
</div>