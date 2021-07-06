<?php
	$data=$this->input->post();
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	$idgroupakses=!empty($idgroupakses)?$idgroupakses:"";
	$idopd=!empty($idopd)?$idopd:"";
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".__t_users where username='".$id."'");	
			$idgroupakses=$row->idgroupakses;
			$idopd=$row->idopd;
			$readonly=" readonly ";
		break;
		case "hapus":	
			$id=trim(str_replace("%"," ",$id));
			$qry="delete from dbsipd_".$_tahun.".__t_users where username='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".__t_users","username", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".__t_users");		
			}
	}
	
	$frm_idopd="
		<div class='control-group'>
		  <label class='control-label'>Forum SKPD :</label>
		  <div class='controls'>
			".$this->m_auth->cmbQuery('idopd',@$idopd,"select UNITKEY as '0', concat(KDUNIT,' ',NMUNIT) as '1' from dbsipd_".$_tahun.".mskpd where KDSTUNIT='3' order by KDUNIT","onchange=\"Fm.Aksi.value='BknSimpan';Fm.submit();\"")."
		  </div>
		</div>	
	";
	$frm_idkec="
		<div class='control-group'>
		  <label class='control-label'>Musrenbang Kecamatan :</label>
		  <div class='controls'>
			".$this->m_auth->cmbQuery('idkec',@$row->idkec,"select UNITKEY as '0', concat(KDUNIT,' ',NMUNIT) as '1' from dbsipd_".$_tahun.".mskpd where KDSTUNIT='3' and JENIS_OPD='KECAMATAN' order by KDUNIT")."
		  </div>
		</div>		
	";
	$frm_kdbidang="
		<div class='control-group'>
		  <label class='control-label'>Bidang :</label>
		  <div class='controls'>
			".$this->m_auth->cmbQuery('kdbidang',@$row->kdbidang,"select KDBIDANG as '0', NMBIDANG as '1' from dbsipd_".$_tahun.".mbidang")."
		  </div>
		</div>	
	";
	$frm_kdsubbidang="
		<div class='control-group'>
		  <label class='control-label'>Sub Bidang :</label>
		  <div class='controls'>
			".$this->m_auth->cmbQuery('kdsubbidang',@$row->kdsubbidang,"select KDSUBBIDANG as '0', NMSUBBIDANG as '1' from dbsipd_".$_tahun.".mbidang_sub")."
		  </div>
		</div>	
	";
	
	$frm_kddewan="
		<div class='control-group'>
		  <label class='control-label'>Dewan :</label>
		  <div class='controls'>
			".$this->m_auth->cmbQuery('kddewan',@$row->kddewan,"select KDDEWAN as '0', NMDEWAN as '1' from dbsipd_".$_tahun.".mdprd")."
		  </div>
		</div>		
	";
	switch($idgroupakses){
		case "1":
			$frm_idopd="<input type='hidden' name='idopd' id='idopd' value=''>";
			$frm_idkec="<input type='hidden' name='idkec' id='idkec' value=''>";
			$frm_kdbidang="<input type='hidden' name='kdbidang' id='kdbidang' value=''>";
			$frm_kdsubbidang="<input type='hidden' name='kdsubbidang' id='kdsubbidang' value=''>";
			$frm_kddewan="<input type='hidden' name='kddewan' id='kddewan' value=''>";
		break;
		case "2":
			$frm_idopd="<input type='hidden' name='idopd' id='idopd' value=''>";
			$frm_idkec="<input type='hidden' name='idkec' id='idkec' value=''>";
			$frm_kdbidang="<input type='hidden' name='kdbidang' id='kdbidang' value=''>";			
			$frm_kdsubbidang="<input type='hidden' name='kdsubbidang' id='kdsubbidang' value=''>";			
		break;
		case "3":
			$frm_idopd="<input type='hidden' name='idopd' id='idopd' value=''>";
			$frm_idkec="<input type='hidden' name='idkec' id='idkec' value=''>";
			$frm_kddewan="<input type='hidden' name='kddewan' id='kddewan' value=''>";
			$frm_kdsubbidang="<input type='hidden' name='kdsubbidang' id='kdsubbidang' value=''>";
		break;
		case "4":
			$query=$this->db->query("select * from mskpd where UNITKEY='".@$idopd."' and JENIS_OPD='SKPD'");
			if($query->num_rows()>0){				
				$frm_idkec="<input type='hidden' name='idkec' id='idkec' value=''>";
			}

			if(empty($idopd)){$frm_idkec="<input type='hidden' name='idkec' id='idkec' value=''>";}
			$frm_kdbidang="<input type='hidden' name='kdbidang' id='kdbidang' value=''>";
			$frm_kdsubbidang="<input type='hidden' name='kdsubbidang' id='kdsubbidang' value=''>";
			$frm_kddewan="<input type='hidden' name='kddewan' id='kddewan' value=''>";
		break;
		case "5":
			$frm_idopd="<input type='hidden' name='idopd' id='idopd' value=''>";
			$frm_kdbidang="<input type='hidden' name='kdbidang' id='kdbidang' value=''>";
			$frm_kdsubbidang="<input type='hidden' name='kdsubbidang' id='kdsubbidang' value=''>";
			$frm_kddewan="<input type='hidden' name='kddewan' id='kddewan' value=''>";
		break;
		case "6":
			$frm_idopd="<input type='hidden' name='idopd' id='idopd' value=''>";
			$frm_idkec="<input type='hidden' name='idkec' id='idkec' value=''>";
			$frm_kdbidang="<input type='hidden' name='kdbidang' id='kdbidang' value=''>";
			$frm_kdsubbidang="<input type='hidden' name='kdsubbidang' id='kdsubbidang' value=''>";
			$frm_kddewan="<input type='hidden' name='kddewan' id='kddewan' value=''>";
		break;
		case "8":
			$frm_idopd="<input type='hidden' name='idopd' id='idopd' value=''>";
			$frm_idkec="<input type='hidden' name='idkec' id='idkec' value=''>";
			$frm_kdbidang="<input type='hidden' name='kdbidang' id='kdbidang' value=''>";
			$frm_kddewan="<input type='hidden' name='kddewan' id='kddewan' value=''>";
		break;
		case "9":		
			$frm_idkec="<input type='hidden' name='idkec' id='idkec' value=''>";
			$frm_kdbidang="<input type='hidden' name='kdbidang' id='kdbidang' value=''>";
			$frm_kdsubbidang="<input type='hidden' name='kdsubbidang' id='kdsubbidang' value=''>";
			$frm_kddewan="<input type='hidden' name='kddewan' id='kddewan' value=''>";
		break;
		default:
			$frm_idopd="<input type='hidden' name='idopd' id='idopd' value=''>";
			$frm_idkec="<input type='hidden' name='idkec' id='idkec' value=''>";
			$frm_kdbidang="<input type='hidden' name='kdbidang' id='kdbidang' value=''>";
			$frm_kdsubbidang="<input type='hidden' name='kdsubbidang' id='kdsubbidang' value=''>";
			$frm_kddewan="<input type='hidden' name='kddewan' id='kddewan' value=''>";
	}
?>
<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ FORM ]</h5>		
	  </div>
	  <div class="widget-content">
		<div class="control-group form-horizontal">
			<form name=Fm id=Fm method=post action="#">	
				<div class="control-group">
				  <label class="control-label">Hak Akses :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('idgroupakses',@$idgroupakses,"select idgroupakses as '0', nmgroupakses as '1' from dbsipd_".$_tahun.".__t_group_akses","onchange=\"Fm.Aksi.value='BknSimpan';Fm.submit();\"")?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Username :</label>
				  <div class="controls">				
					<input type="text"  name="username" id="username" value="<?=@$row->username?>"  class='span8' <?=$readonly?>/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">
					<input type="text"  name="nama_lengkap" id="nama_lengkap" value="<?=@$row->nama_lengkap?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nomor HP :</label>
				  <div class="controls">
					<input type="text"  name="nomor_hp" id="nomor_hp" value="<?=@$row->nomor_hp?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nomor WA :</label>
				  <div class="controls">
					<input type="text"  name="nomor_wa" id="nomor_wa" value="<?=@$row->nomor_wa?>"  class='span8'/>
				  </div>
				<div class="control-group">
				  <label class="control-label">Password :</label>
				  <div class="controls">
					<input type="text"  name="password" id="password" class='span8'/>
				  </div>
				</div>
				
				<?=$frm_idopd?>
				<?=$frm_idkec?>
				<?=$frm_kdbidang?>
				<?=$frm_kdsubbidang?>
				<?=$frm_kddewan?>					
				
				<div class="control-group">
				  <label class="control-label">Tahapan :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('tahapan',@$row->tahapan,"select KDTAHAPAN as '0', NMTAHAPAN as '1' from dbsipd_".$_tahun.".mtahapan","","Y")?>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Blokir :</label>
				  <div class="controls">
					<?=$this->andri->cmbUmum('blokir',@$row->blokir,array('Y','N'))?>
				  </div>
				</div>	
				
				
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="Aksi" id='Aksi' value='<?=$Aksi?>'>
				<input type="hidden" name="tahun" id='tahun' value='<?=$_tahun?>'>
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var username=$('#username').val();
			var nama_lengkap=$('#nama_lengkap').val();
			var idopd=$('#idopd').val();
			var idkec=$('#idkec').val();
			var kdsubbidang=$('#kdsubbidang').val();
			var kdbidang=$('#kdbidang').val();
			var kddewan=$('#kddewan').val();
			var tahun=$('#tahun').val();
			var password=$('#password').val();
			var idgroupakses=$('#idgroupakses').val();
			var blokir=$('#blokir').val();
			var tahapan=$('#tahapan').val();
		
			  
			var dataPost={username:username, nama_lengkap:nama_lengkap, idopd:idopd, idkec:idkec, kdbidang:kdbidang, kdsubbidang:kdsubbidang, kddewan:kddewan, tahun:tahun, password:password, idgroupakses:idgroupakses, blokir:blokir, tahapan:tahapan, tahun:tahun};
			$.post("<?=base_url('pengaturan/'.$Pr.'/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr)?>"; }, 1000);
			});
		});
	});	
</script>