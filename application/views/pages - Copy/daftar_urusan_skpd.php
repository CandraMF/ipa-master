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
			  <th>Urusan</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="SELECT concat(trim(a.UNITKEY),'_',trim(a.URUSKEY)) as UNITKEY, b.KDUNIT, b.NMUNIT, c.NMUNIT AS NMURUS FROM dbsipd_".$_tahun.".mskpd_urusan AS a INNER JOIN dbsipd_".$_tahun.".mskpd AS b ON a.UNITKEY=b.UNITKEY INNER JOIN dbsipd_".$_tahun.".mskpd AS c ON a.URUSKEY=c.UNITKEY ORDER BY b.KDUNIT";
				$TdAdd="
					<td align=center style='width:100px;'>
					<p align=center>
						
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