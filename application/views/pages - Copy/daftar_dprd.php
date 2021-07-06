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
			  <th>No. Urut</th>
			  <th>Nama </th>
			  <th>Fraksi</th>
			  <th>Pagu</th>
			  <th>Keterangan</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="SELECT a.KDDEWAN, concat(a.NODEWAN,'_') as NODEWAN, a.NMDEWAN, a.FRAKSI, a.PAGU, a.KETERANGAN FROM dbsipd_".$_tahun.".mdprd AS a  order by  a.NODEWAN";
				$TdAdd="
					<td align=center style='width:100px;'>
					<p align=center>
						<a href='".base_url('login/pages/'.$Pr.'/detail/edit/[/]row->KDDEWAN[\]')."'><i class='icon icon-edit'></i> Edit</a>	
						&nbsp;&nbsp;
						<a href='".base_url("login/pages/".$Pr."/detail/hapus/[!>]row->KDDEWAN[<!]")."'><i class='icon icon-remove'></i> Delete</a>
					</p>
					</td>
				";
				$ArrData=array('KDDEWAN');
				$arrFilterAdd=array('KDDEWAN');
				echo $this->m_auth->getTable($Qry,$TdAdd,$ArrData);
			?>
		  </tbody>
		</table>		
	  </div>
	</div>
</div>