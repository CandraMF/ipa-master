<?php
	
	//// LOG AKTIFITAS
	$Qry="SELECT a.ipaddress, a.link_url, CONCAT('<strong>', c.nama_menu,'</strong> > ',b.nama_sub) AS modul, a.waktu FROM dbsipd_".$_tahun.".__log_server AS a INNER JOIN dbsipd_".$_tahun.".__t_submenu AS b ON a.link_sub=b.link_sub INNER JOIN dbsipd_".$_tahun.".__t_mainmenu AS c ON b.id_main=c.id_main WHERE a.username='{$sUserId}' ORDER BY a.waktu desc";
	$dt=$this->m_auth->NaviPage($Qry, "PageLog", @$PageLog,"onchange=\"Fm.submit();\"");

?>
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>
<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
		 <!-- Data List Program -->
	  <div class="widget-content">		
		
		<table width='100%' border=0 align=right>
		<tr>
			
			<td align=right>
				<?=$dt->FormPage?>
			</td>
		</tr>
		</table>

		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th width='50'>IP Address</th>
			  <th>Modul</th>
			  <th>Url</th>
			  <th>Waktu</th>
			</tr>
		  </thead>
		  <tbody>		   
			<?php			
			$i=1;
			foreach ($dt->query->result() as $row){				
				echo "
				<tr>				
					<td>".$row->ipaddress."</td>
					<td>".$row->modul."</td>
					<td>".$row->link_url."</td>					
					<td>".$row->waktu."</td>
				</tr>
				";
				$i++;
			}			
			?>
		  </tbody>
		</table>
	  </div>	
	
</div>
</form>	