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
			  <th width='50'>User</th>
			  <th>Nama</th>
			  <th>Group Akses</th>	
			  <th>Akses Data</th>	
			  <th>Tahun</th>			  
			  <th>Tahapan</th>	
			  <th>Blokir</th>		
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="SELECT a.username, a.nama_lengkap, g.nmgroupakses,
				CONCAT(
				if(isnull(b.NMUNIT),'',concat('Forum OPD : [', b.NMUNIT,'] ')), 
				if(isnull(c.NMUNIT),'',concat('Musren Kec : [',c.NMUNIT,'] ')), 
				if(isnull(e.NMDEWAN),'',concat('Pokpir Dewan : [',e.NMDEWAN,'] ')), 
				if(isnull(d.NMBIDANG),'',concat('Verfikator Bidang : [', d.NMBIDANG,'] '))) AS AksesData, 
				concat(a.tahun,' ') as tahun, f.NMTAHAPAN, a.blokir
				 FROM dbsipd_".$_tahun.".__t_users AS a 
				 LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.idopd=b.UNITKEY
				 LEFT JOIN dbsipd_".$_tahun.".mskpd AS c ON a.idkec=c.UNITKEY
				 LEFT JOIN dbsipd_".$_tahun.".mbidang AS d ON a.kdbidang=d.KDBIDANG
				 LEFT JOIN dbsipd_".$_tahun.".mdprd AS e ON a.kddewan=e.KDDEWAN
				 INNER JOIN dbsipd_".$_tahun.".mtahapan AS f ON a.tahapan=f.KDTAHAPAN
				 INNER JOIN dbsipd_".$_tahun.".__t_group_akses AS g ON a.idgroupakses=g.idgroupakses
				 ORDER BY a.idgroupakses, a.username";
				
				$TdAdd="
					<td align=center style='width:100px;'>
					<p align=center>
						<a href='".base_url('login/pages/'.$Pr.'/detail/edit/[/]row->username[\]')."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/detail/hapus/[!>]row->username[<!]")."' ".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
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