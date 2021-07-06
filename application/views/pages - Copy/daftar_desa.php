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
			  <th>Kode</th>
			  <th>Nama Desa</th>
			  <th>Kecamatan</th>
			  <th>Akronim</th>
			  <th>Alamat</th>
			  <th>Telepon</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="SELECT a.IDDESA ,a.KDDESA, a.NMDESA, b.NMUNIT AS KEC,a.AKRONIM, a.ALAMAT, a.TELP FROM dbsipd_".$_tahun.".mdesa AS a INNER JOIN dbsipd_".$_tahun.".mskpd AS b ON a.UNITKEY=b.UNITKEY ORDER BY b.KDUNIT, a.KDDESA";
				$TdAdd="
					<td align=center style='width:100px;'>
					<p align=center>
						<a href='".base_url('login/pages/'.$Pr.'/detail/edit/[/]row->IDDESA[\]')."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/detail/hapus/[!>]row->IDDESA[<!]")."'".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
					</p>
					</td>
				";
				$ArrData=array('IDDESA');
				$arrFilterAdd=array('IDDESA');
				echo $this->m_auth->getTable($Qry,$TdAdd,$ArrData,$arrFilterAdd);
			?>
		  </tbody>
		</table>		
	  </div>
	</div>
</div>