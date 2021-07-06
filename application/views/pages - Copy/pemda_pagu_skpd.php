
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
			  <th>Pagu</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="select a.KDPAGU, b.KDUNIT, b.NMUNIT, a.PAGU from dbsipd_".$_tahun.".t_pagu_skpd as a inner join dbsipd_".$_tahun.".mskpd as b on a.UNITKEY=b.UNITKEY where KDTAHAP='".@$_tahap."' and KDSTUNIT='3'";
				$TdAdd="
					<td align=center style='width:100px;'>
					<p align=center>
						<a href='".base_url('login/pages/'.$Pr.'/detail/edit/[/]row->KDPAGU[\]')."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/detail/hapus/[!>]row->KDPAGU[<!]")."' ".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
					</p>
					</td>
				";
				$ArrData=array('KDPAGU');
				$arrFilterAdd=array('KDPAGU');
				echo $this->m_auth->getTable($Qry,$TdAdd,$ArrData,$arrFilterAdd);
			?>
		  </tbody>
		</table>		
	  </div>
	</div>
</div>