<?php	
	//// LOG AKTIFITAS
	$data=$this->input->post();
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	$wh="";
	$wh.=!empty($data)?" and `data`='".@$data."'":"";
	$Qry="SELECT username, waktu, `query` AS dt_query, `ACTION` AS aksi, `DATA` AS tabel, field_data, iddata, ipaddress FROM  dbsipd_".$_tahun.".__log_aktifitas WHERE username='".@$username."' ".$wh." ORDER BY waktu desc";
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
			<td>
				<table width='100%'>
				<tr>
					<td width='10'>Kelompok&nbsp;Akses: </td>
					<td><?=$this->m_auth->cmbQuery('idgroupakses',@$idgroupakses,"select idgroupakses as '0', nmgroupakses as '1' from dbsipd_".$_tahun.".__t_group_akses ","class='span12' onchange=\"Fm.submit();\"")?></td>
				</tr>
				</table>
			</td>
			<td>
				<table width='100%'>
				<tr>
					<td width='10'>Username: </td>
					<td><?=$this->m_auth->cmbQuery('username',@$username,"select username as '0', username as '1' from dbsipd_".$_tahun.".__t_users where idgroupakses='".@$idgroupakses."' order by username","class='span12' onchange=\"Fm.submit();\"")?></td>
				</tr>
				</table>
			</td>
			<td width='400'>
				<table width='100%'>
				<tr>
					<td width='10'>Tabel </td>
					<td><?=$this->m_auth->cmbQuery('data',@$data,"select distinct `data` as '0', `data` as '1' from dbsipd_".$_tahun.".__log_aktifitas where username='".@$username."'","class='span12' onchange=\"Fm.submit();\"")?></td>
				</tr>
				</table>
			</td>
			<td align=right>
				<?=$dt->FormPage?>
			</td>
		</tr>
		</table>

		<table class="table table-bordered table-striped with-check">
		  <thead>
		   <tr>			
			  <th>Ip Address</th>
			  <th>Username</th>
			  <th>Action</th>
			  <th>Query</th>
			  <th>Tabel</th>
			  <th>Field</th>
			  <th>Value</th>
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
					<td>".$row->username."</td>					
					<td>".$row->aksi."</td>
					<td>".$row->dt_query."</td>					
					
					<td>".$row->tabel."</td>
					<td>".$row->field_data."</td>
					<td>".$row->iddata."</td>
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