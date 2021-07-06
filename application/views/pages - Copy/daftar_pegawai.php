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
			  <th>NIP</th>
			  <th>Nama</th>
			  <th>Gol</th>
			  <th>Unit Organisasi</th>
			  <th>Jabatan</th>
			  <th>Pendidikan</th>
			  <th>Alamat</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="SELECT a.KDPEG, a.NIP, a.NAMA, a.GOL, b.NMUNIT, a.JABATAN, a.PENDIDIKAN, a.ALAMAT FROM dbsipd_".$_tahun.".mpegawai AS a INNER JOIN dbsipd_".$_tahun.".mskpd AS b ON a.UNITKEY=b.UNITKEY order by  b.KDUNIT, a.NAMA";
				$TdAdd="
					<td align=center style='width:100px;'>
					<p align=center>
						<a href='".base_url('login/pages/'.$Pr.'/detail/edit/[/]row->KDPEG[\]')."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/detail/hapus/[!>]row->KDPEG[<!]")."'".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
					</p>
					</td>
				";
				$ArrData=array('KDPEG');
				$arrFilterAdd=array('KDPEG');
				echo $this->m_auth->getTable($Qry,$TdAdd,$ArrData);
			?>
		  </tbody>
		</table>		
	  </div>
	</div>
</div>