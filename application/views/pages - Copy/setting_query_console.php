<?php
	$Pesan="";
	$query_script=!empty($query_script)?$query_script:"";

	$Aksi=!empty($Aksi)?$Aksi:"";
	$MainBgRow	 ="white";
	$MainBgRow2	 ="#ECECEC";
	$MainBgPilih	 = "#BFC6FF";
	if ($_GET){foreach($_GET as $key => $value){$$key = $value;}}
	if ($_POST){foreach($_POST as $key => $value){$$key = $value;}}

	$ListMode="";
	$List="";
	
	//$con00 = mysqli_connect('localhost', 'root', '', 'dbsipd_2020');
	$Aksi=empty($query_script)?"goQuery":$Aksi;
	$query_script=!empty($query_script)?$query_script:"show tables";
	if($Aksi=="goQuery"){		
		$qryscript=trim(strtolower($query_script));
		$CekCreate=substr(trim(strtolower($query_script)),0,6);
		$Cekdrop=substr(trim(strtolower($query_script)),0,4);
		$Cekdelete=substr(trim(strtolower($query_script)),0,6);

		$tmpquery_script=str_replace(" ","",trim(strtolower($qryscript)));
		if($Cekdelete=='delete'){
			$Pesan="<p align=center style='font-weight:bold;color:red;'>Maaf, fungsi delete query tidak dapat di eksekusi silahkan hubungi admin</p>";
		}else{
		
			if($Cekdrop=='drop'){			
				$Pesan="<p align=center style='font-weight:bold;color:red;'>Maaf, fungsi drop query tidak dapat di eksekusi silahkan hubungi admin</p>";
			}else{
				if($CekCreate=='create'){
					$Qry = $this->db->query($query_script);
				}else{
					////////////////////////////////////////////////////////////////////////
					$qcek=substr(trim(strtolower($query_script)),0,4);
					if($qcek=='show'){
						$Qry = $this->db->query($query_script);
					}else{
						$Qry = $this->db->query("$query_script limit 100");
					}
					if($Qry->num_rows()>0){
						$ListMode="";$th="";$td="";$i=1;			
						/// IDENTIFIKASI FIELDS
						foreach ($Qry->list_fields() as $Field){
							$th.="<th> ".str_replace('Tables_in_','Nama Database : ',$Field)."</th>";
							if($tmpquery_script=='showtables'){
								$td.="<td>".str_replace('Tables_in_','',trim($Field)).".{[|]Isi['".$Field."']}</td>";
							}else{
								$td.="<td> {[|]Isi['".$Field."']}</td>";
							}
							
							
						}
						$td=str_replace("[|]","$",$td);
						 $arrList=array('information_schema','administrasi_bpb','baselineck', 'cdcol', 'test', 'touchscreen', 'webauth', 'webdav', 'dbdma', 'dbmonitoring');
						/// LIST DATA
						 foreach ($Qry->result_array() as $Isi){
							$wr = $i % 2 == 0 ? "style='background:$MainBgRow'" : "style='background:$MainBgRow2'";
							$wh = $i % 2 == 0 ? "$MainBgRow" : "$MainBgRow2";
							eval("\$tdData = \"$td\";");
							
							if (in_array($tdData, $arrList)) {
								
							 }else{
								$ListMode.="
									<tr $wr  onmouseover=\"TG(this,'#FFCC33')\" onmouseout=\"TG(this,'$wh')\">
										<td align=center>$i</td>
										{$tdData}	
									</tr>
								";$i++; 
							 }
							
						 }

						$List="
							
							
							<table border=1 width=100% cellpadding=3 cellspacing=0 style=' border-collapse: collapse;' align=center>
							<thead>
							<tr>
								<th>No</th>
								$th
							</tr>
								<tbody>$ListMode</tbody>
							</table>
							
						";
					}
					////////////////////////////////////////////////////////////////////////
				}
			}
		}
		
		
		
		
	}
	
	$MainIsi="
		
		$Pesan
		<style>
		body
		{
			font-family:tahoma;
			color:black;
		}
		input[type='submit'], .button
		{
			font-size: 12px;

			cursor:pointer; /*forces the cursor to change to a hand when the button is hovered*/
			padding:3px 10px; /*add some padding to the inside of the button*/
			background: #376AAF; /*the colour of the button*/
			border: 1px solid #FFFFFF; /*required or the default border for the browser will appear*/
			/*give the button curved corners, alter the size as required*/
			-moz-border-radius: 10px;
			-webkit-border-radius: 10px;
			border-radius: 5px;
			/*give the button a drop shadow*/
			-webkit-box-shadow: 0 0 4px rgba(0,0,0, .75);
			-moz-box-shadow: 0 0 4px rgba(0,0,0, .75);
			box-shadow: 0 0 4px rgba(0,0,0, .75);
			/*style the text*/
			color:#f3f3f3;

		}

		</style>
		<form name=Fm2 id=Fm2 method=post action='".base_url("setting_query_console")."' enctype='multipart/form-data'>
			<table border=0 width='100%'>
			<tr>
				<td>Script Query <hr> contoh<span style='font-size:10pt;'><i>*) select * from nama_database.nama_table</i></span></td>
			</tr>
			<tr>
				
				<td> <textarea name='query_script' rows='query_script' style='width:100%;height:100px;font-family:consolas;font-size:10pt;'>{$query_script}</textarea>
				</td>
				<td style='border:0px' align=right width='100'>
					<input type='button' class='button' value='Execute' onclick=\"Fm2.Aksi.value='goQuery';Fm2.submit();\" style='height:90px;width:100%;'>
				</td>
			</tr>
			</table>
			$List
			<input type='hidden' name='Aksi'>
		</form>
	";

	echo $MainIsi;
?>