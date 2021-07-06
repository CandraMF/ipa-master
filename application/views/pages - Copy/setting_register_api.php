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
			  <th>Nama Query</th>
			  <th>Query</th>
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tbody>		  
			<?php
				$Qry="select IDQRY , NAMA_QRY, QRY from dbsipd_".$_tahun.".api_qry order by IDQRY";
				$query = $this->db->query($Qry);
				foreach ($query->result() as $row){
					echo "
					<tr>
						<td>".$row->NAMA_QRY."</td>
						<td>".$row->QRY."</td>
						<td align=center style='width:100px;'>
							<p align=center>
								<a href='".base_url('login/pages/'.$Pr.'/detail/edit/'.$row->IDQRY)."' ".$_pupdate."><i class='icon icon-edit'></i> Edit</a>	
								&nbsp;&nbsp;
								<a href='".base_url("login/pages/".$Pr."/detail/hapus/".$row->IDQRY)."' ".$_pdelete."><i class='icon icon-remove'></i> Delete</a>
								<hr>
								<a href='".base_url('api_sirenda/data/'.$row->IDQRY.'-api-json/')."' target='_blank'><i class='icon icon-edit'></i> Url Api</a>	
								&nbsp;&nbsp;
								

							</p>
						</td>
					</tr>
					";
				}
		
			?>
		  </tbody>
		</table>		
	  </div>
	</div>
</div>