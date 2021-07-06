<!DOCTYPE html>
<html lang="en">
<head>
<?php
	$_tahun=date('Y')+1;
	$qry=$this->db->query("SELECT * FROM dbsipd_".$_tahun.".__t_users WHERE username='".$sUserId."' AND idgroupakses='5'");
	if($qry->num_rows()>0){
		echo "<title>E-MONEV Kab. Subang @".date('Y')."</title>";
	}else{
		echo "<title>SIRENDA Kab. Subang @".date('Y')."</title>";
	}
	$tahun=$this->input->get('tahun');
	$_tahun=!empty($tahun)?$tahun:$_tahun;
?>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?=base_url('assets/backend/css/bootstrap.min.css')?>" />
<link rel="stylesheet" href="<?=base_url('assets/backend/css/bootstrap-responsive.min.css')?>" />
<link rel="stylesheet" href="<?=base_url('assets/backend/css/uniform.css')?>" />
<link rel="stylesheet" href="<?=base_url('assets/backend/css/select2.css')?>" />
<link rel="stylesheet" href="<?=base_url('assets/backend/css/matrix-style.css')?>" />
<link rel="stylesheet" href="<?=base_url('assets/backend/css/matrix-media.css')?>" />
<link rel="stylesheet" href="<?=base_url('assets/backend/css/datepicker.css')?>" />

<link href="<?=base_url('assets/backend/font-awesome/css/font-awesome.css')?>" rel="stylesheet" />
<script src="<?=base_url("assets/js/jquery-1.10.2.js")?>"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
<script>
function ambilData(Konten, URL)
{
	$('#popup_overlay').show();	
	Kata = /\s/g
	URL = URL.replace(Kata, '+');
	$(Konten).load(URL);
}
function showPopUp(width)
{
	var panjang=width+2;
	$('#faceboxisi').html('');
	$('#faceboxisi').css('width', width+'px');
	$('#popup').fadeIn('medium');
}
function TglSQL(tgl){
	var tglInd = tgl.split("-");
	var tglSQL = tglInd[2]+"-"+tglInd[1]+"-"+tglInd[0];
	return tglSQL;
}
</script>
<style>
	.faceboxcontent{
		margin-top:0px;
		
		
		border:1px solid #a3a3a3;
		
		background:white;
		
	}
	#facebox{
		padding-bottom:100px;
	}
	#popup_overlay {
		background: #333 none repeat scroll 0 0 !important;
		opacity: 0.8 !important;
		width:100%;
		height:100%;
		display: none;
		z-index:99;
		position:fixed;
	}
</style>
<?php
	
	$data=$this->input->post();
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	
	$idopd=!empty($idopd)?$idopd:"";
	$Aksi=!empty($Aksi)?$Aksi:"";
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
		  <label class='control-label'> SKPD :</label>
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
	$idgroupakses=2;
	$row=$this->m_action->ambilData("select idgroupakses from dbsipd_".$_tahun.".__register_on_off order by CREATED_DATE desc limit 1");	
	$idgroupakses=$row->idgroupakses;
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
	
	$fdisplay=$idgroupakses==0?"style='display:none;'":"";
?>
<div class="row-fluid" <?=$fdisplay?>>
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
					<?=$this->m_auth->cmbQuery('idgroupakses',@$idgroupakses,"select idgroupakses as '0', nmgroupakses as '1' from dbsipd_".$_tahun.".__t_group_akses where idgroupakses='".@$idgroupakses."'","onchange=\"Fm.Aksi.value='BknSimpan';Fm.submit();\"","Y")?>
				  </div>
				</div>
				<?=$frm_idopd?>
				<div class="control-group">
				  <label class="control-label">Tahun :</label>
				  <div class="controls">				
					<input type="text"  name="tahun" id="tahun" value="<?=@$_tahun?>"  class='span8' readonly/>
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
				</div>
				<div class="control-group">
				  <label class="control-label">Password :</label>
				  <div class="controls">
					<input type="text"  name="password" id="password" class='span8'/>
				  </div>
				</div>
				
			
				<?=$frm_idkec?>
				<?=$frm_kdbidang?>
				<?=$frm_kdsubbidang?>
				<?=$frm_kddewan?>			
				
				
				
				
				
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url()?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="tahapan" id='tahapan' value='1'>
				<input type="hidden" name="blokir" id='blokir' value='N'>
				<input type="hidden" name="Aksi" id='Aksi' value='<?=$Aksi?>'>
				
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
			var nomor_hp=$('#nomor_hp').val();
			var nomor_wa=$('#nomor_wa').val();
		
			  
			var dataPost={username:username, nama_lengkap:nama_lengkap, idopd:idopd, idkec:idkec, kdbidang:kdbidang, kdsubbidang:kdsubbidang, kddewan:kddewan, tahun:tahun, password:password, idgroupakses:idgroupakses, blokir:blokir, tahapan:tahapan, tahun:tahun, nomor_hp:nomor_hp, nomor_wa:nomor_wa};
			$.post("<?=base_url('register/'.$Pr.'/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
			
				alert(data.status);
				$( '#btnsimpan' ).css( "display", "none" );
				setTimeout(function(){ parent.location='http://sirenda.subang.go.id'; }, 2000);

			});
		});
	});	
</script>
				<!-- setTimeout(function(){parent.location='http://sirenda.subang.go.id' }, 2000); -->
<!-- POPUP INFO -->
<div id="InfoConfirm" class="modal fade" >
<div class="modal-dialog modal-confirm">
	<div class="modal-content">
		
		<div class="modal-body">
			<p class="text-center" id='txtinfo'></p>
		</div>
		<div class="modal-footer">
			<button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
		</div>
	</div>
</div>
</div>   
<script src="<?=base_url("assets/backend/js/jquery.min.js")?>"></script> 


<script src="<?=base_url("assets/backend/js/jquery.uniform.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/bootstrap-colorpicker.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/bootstrap-datepicker.js")?>"></script> 

<script src="<?=base_url("assets/backend/js/select2.min.js")?>"></script>
<script src="<?=base_url("assets/backend/js/jquery.dataTables.min.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/matrix.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/matrix.tables.js")?>"></script>

<script src="<?=base_url("assets/backend/js/jquery.toggle.buttons.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/masked.js")?>"></script> 

<script src="<?=base_url("assets/backend/js/matrix.form_common.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/wysihtml5-0.3.0.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/jquery.peity.min.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/bootstrap-wysihtml5.js")?>"></script> 
<script>
	$('.textarea_editor').wysihtml5();
</script>
</body>
</html>
