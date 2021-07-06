<?php
	$tab1="";$tab2="";$tab3="";
	$tab=@$this->input->get('tab');
	switch($tab){
		case "tab2":
			$tab2=" class='active'";
		break;
		case "tab3":
			$tab3=" class='active'";
		break;
		default:
			$tab1=" class='active'";
	}
?>
<div class="row-fluid">
	<div class="widget-box">
	   <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>
	  </div>
	  <div class="widget-title">
		<ul class="nav nav-tabs">
		  <li <?=$tab1?>><a data-toggle="tab" href="#tab1">Pendapatan</a></li>
		  <li <?=$tab2?>><a data-toggle="tab" href="#tab2">Belanja</a></li>
		  <li <?=$tab3?>><a data-toggle="tab" href="#tab3">Pembiayaan</a></li>
		</ul>
	  </div>
	  <div class="widget-content tab-content">	  
		<div id="tab1" class="tab-pane active">

			<p align=right>	
				<span class="label label-info">
					<a href="<?=base_url('login/pages/'.$Pr.'/rekd')?>"  style='color:white;padding:5px;' >
						<i class="icon icon-plus-sign"></i> Tambah</a>			
				 </span>
			</p>
			 
			<table class="table table-bordered data-table">
			  <thead>
				<tr>
				  <th>Kode</th>
				  <th width='250'>Nama Rekening</th>
				  <th>Struktur</th>
				  <th>Tipe</th>
				  <th width='50'>Aksi</th>
				</tr>
			  </thead>
			  <tbody>		  
				<?php
					$Qry="SELECT a.MTGKEY, concat(a.KDREK,' ') as KDREK, a.NMREK, b.NMSTREK, a.TIPE FROM dbsipd_".$_tahun.".mrekd AS a INNER JOIN dbsipd_".$_tahun.".mstruktur_rekening AS b ON a.KDSTREK=b.KDSTREK ORDER BY a.KDREK";
					$TdAdd="
						<td align=center style='width:100px;'>
						<p align=center>
							<a href='".base_url('login/pages/'.$Pr.'/rekd/edit/[/]row->MTGKEY[\]')."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
							&nbsp;&nbsp;
							<a href='".base_url("login/pages/".$Pr."/rekd/hapus/[!>]row->MTGKEY[<!]")."'".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
						</p>
						</td>
					";
					$ArrData=array('MTGKEY');
					$arrFilterAdd=array('MTGKEY');
					echo $this->m_auth->getTable($Qry,$TdAdd,$ArrData,$arrFilterAdd);
				?>
			  </tbody>
			</table>
		</div>
		<div id="tab2" class="tab-pane"> 
			  <p align=right>	
				<span class="label label-info">
					<a href="<?=base_url('login/pages/'.$Pr.'/rekr')?>"  style='color:white;padding:5px;' >
						<i class="icon icon-plus-sign"></i> Tambah</a>			
				 </span>
			  </p>
			  <table class="table table-bordered data-table">
			  <thead>
				<tr>
				  <th>Kode</th>
				  <th width='250'>Nama Rekening</th>
				  <th>Struktur</th>
				  <th>Tipe</th>
				   <th width='50'>Aksi</th>
				</tr>
			  </thead>
			  <tbody>		  
				<?php
					$Qry="SELECT a.MTGKEY, concat(a.KDREK,' ') as KDREK, a.NMREK, b.NMSTREK, a.TIPE FROM dbsipd_".$_tahun.".mrekr AS a INNER JOIN dbsipd_".$_tahun.".mstruktur_rekening AS b ON a.KDSTREK=b.KDSTREK ORDER BY a.KDREK";
					$TdAdd="
						<td align=center style='width:100px;'>
						<p align=center>
							<a href='".base_url('login/pages/'.$Pr.'/rekr/edit/[/]row->MTGKEY[\]')."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
							&nbsp;&nbsp;
							<a href='".base_url("login/pages/".$Pr."/rekr/hapus/[!>]row->MTGKEY[<!]")."'".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
						</p>
						</td>
					";
					$ArrData=array('MTGKEY');
					$arrFilterAdd=array('MTGKEY');
					echo $this->m_auth->getTable($Qry,$TdAdd,$ArrData,$arrFilterAdd);
				?>
			  </tbody>
			 </table>
		</div>
		<div id="tab3" class="tab-pane">
			  <p align=right>	
				<span class="label label-info">
					<a href="<?=base_url('login/pages/'.$Pr.'/rekb')?>"  style='color:white;padding:5px;' >
						<i class="icon icon-plus-sign"></i> Tambah</a>			
				 </span>
			  </p>
			  <table class="table table-bordered data-table">
			  <thead>
				<tr>
				  <th>Kode</th>
				  <th width='250'>Nama Rekening</th>
				  <th>Struktur</th>
				  <th>Tipe</th>
				  <th width='50'>Aksi</th>
				</tr>
			  </thead>
			  <tbody>		  
				<?php
					$Qry="SELECT a.MTGKEY, concat(a.KDREK,' ') as KDREK, a.NMREK, b.NMSTREK, a.TIPE FROM dbsipd_".$_tahun.".mrekb AS a INNER JOIN dbsipd_".$_tahun.".mstruktur_rekening AS b ON a.KDSTREK=b.KDSTREK ORDER BY a.KDREK";
					$TdAdd="
						<td align=center style='width:100px;'>
						<p align=center>
							<a href='".base_url('login/pages/'.$Pr.'/rekb/edit/[/]row->MTGKEY[\]')."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
							&nbsp;&nbsp;
							<a href='".base_url("login/pages/".$Pr."/rekb/hapus/[!>]row->MTGKEY[<!]")."'".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
						</p>
						</td>
					";
					$ArrData=array('MTGKEY');
					$arrFilterAdd=array('MTGKEY');
					echo $this->m_auth->getTable($Qry,$TdAdd,$ArrData,$arrFilterAdd);
				?>
			  </tbody>
			 </table>
	    </div>
	  </div>
	</div>

	
</div>