<!DOCTYPE html>
<html lang="en">
<head>
<title>I-PA</title>

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
<div id='popup_overlay'></div>
<div style='position:fixed;bottom:0;display:none;width:100%;height:100%;z-index:1001;' id='popup'>
	<center>
		<div id="facebox" style='margin-top:5%;'> 
			<div class="faceboxpopup"> 
			
				<div class="faceboxcontent" id="faceboxisi" style="max-height:550px;overflow-y:auto;overflow-x:visible;">
					
				</div>
						
				
			</div> 
		</div>
	</center>
</div>

<!--Header-part-->
<div id="header">
	<?php
		echo "<h1><a href='dashboard.html'>I-PA</a></h1>";
		
	?>

</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
 
  
    <li class=""><a title="" href="<?=base_url('login/logout')?>"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>




<!--sidebar-menu-->

<div id="sidebar"> 
  <?=$_menu?>
</div>
<?php
	$qsts=$this->db->query("select if(tahapan=1,'Murni','Perubahan') as nmtahapan from dbsipd_".$_tahun.".__t_users where username='".$this->session->userdata('SESS_USERNAME')."'");	
	$thprow = $qsts->row();	
?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?=base_url("login/pages/beranda")?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="<?=base_url("login/pages/".$Pr)?>" class="current"><?=$_title?></a> <strong style='color:red'>&nbsp;&nbsp;[ DB : dbipa_<?=$this->session->userdata('SESS_TAHUN')?> , User : <?=$this->session->userdata('SESS_USERNAME')?>  ]</strong></div>   
  </div>
  <div class="container-fluid">
 
	
