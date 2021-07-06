<!DOCTYPE html>
<html lang="en">
<head>
<?php
	$qry=$this->db->query("SELECT * FROM dbsipd_".$_tahun.".__t_users WHERE username='".$sUserId."' AND idgroupakses in ('7','9')");
	if($qry->num_rows()>0){
		echo "<title>E-MONEV Kab. Subang @".date('Y')."</title>";
	}else{
		echo "<title>SIRENDA Kab. Subang @".date('Y')."</title>";
	}
	
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
<body style='background-color:white;'>
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
<body>
 <br><br>
	
