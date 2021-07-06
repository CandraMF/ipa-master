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
			  <th>Nama</th>
			  <th>Akronim</th>
			  <th>Struktur</th>
			  <th>Alamat</th>
			  <th>Telepon</th>
			  <th>Tipe</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="select a.UNITKEY, concat(a.KDUNIT,' ') as KDUNIT, a.NMUNIT, a.AKRONIM, b.NMSTUNIT, a.ALAMAT, a.TELEPON, a.TIPE from dbsipd_".$_tahun.".mskpd as a inner join dbsipd_".$_tahun.".mstruktur_unit as  b on a.KDSTUNIT=b.KDSTUNIT where a.KDUNIT!='0.00.00.' order by a.KDUNIT";
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