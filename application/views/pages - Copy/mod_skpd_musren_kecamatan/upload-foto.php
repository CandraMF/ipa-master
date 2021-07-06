<?php
	$row = new stdClass();	
	$id=$this->uri->segment(6);
	$row=$this->m_action->ambilData("select FOTO, JENIS_CPCL, KDKEGUNIT, UNITKEY_KEC, UNITKEY from dbsipd_".$_tahun.".t_kegiatan_cpcl where KDCPCL='".$id."'");		
	$JENIS_CPCL=$row->JENIS_CPCL;
	$KDKEGUNIT=$row->KDKEGUNIT;
	$UNITKEY_KEC=$row->UNITKEY_KEC;
	$UNITKEY=$row->UNITKEY;
	$FOTO=!empty($row->FOTO)?"<img src=".base_url($row->FOTO)." height='200' width='250'/>":"";
?>
<style>
body {font-family: calibri;}
.bgColor {
    max-width: 440px;
    height: 400px;
  
    padding: 30px;
    border-radius: 4px;
	text-align: center;    
}
#targetOuter{	
	position:relative;
    text-align: center;

    margin: 20px auto;
    width: 200px;
    height: 200px;
	border-radius: 4px;
}
.btnSubmit {
    background-color: #565656;
    border-radius: 4px;
    padding: 10px;
    border: #333 1px solid;
    color: #FFFFFF;
    width: 200px;
	cursor:pointer;
}
.inputFile {
    padding: 5px 0px;
	margin-top:8px;	
    background-color: #FFFFFF;
    width: 48px;	
    overflow: hidden;
	opacity: 0;	
	cursor:pointer;
}
.icon-choose-image {
    position: absolute;
    opacity: 0.1;
    top: 50%;
    left: 50%;
    margin-top: -24px;
    margin-left: -24px;
    width: 48px;
    height: 48px;
}
.upload-preview {border-radius:4px;}
#body-overlay {background-color: rgba(0, 0, 0, 0.6);z-index: 999;position: absolute;left: 0;top: 0;width: 100%;height: 100%;display: none;}
#body-overlay div {position:absolute;left:50%;top:50%;margin-top:-32px;margin-left:-32px;}

</style>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript">
function showPreview(objFileInput) {
    if (objFileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (e) {
            $("#targetLayer").html('<img src="'+e.target.result+'" width="200px" height="200px" class="upload-preview" />');
			$("#targetLayer").css('opacity','0.7');
			$(".icon-choose-image").css('opacity','0.5');
        }
		fileReader.readAsDataURL(objFileInput.files[0]);
    }
}

$(document).ready(function (e) {
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "<?=base_url('skpd/'.$Pr.'_upload_foto/'.$id)?>",
			type: "POST",
			data:  new FormData(this),
			beforeSend: function(){$("#body-overlay").show();},
			contentType: false,
    	    processData:false,
			success: function(data)
		    {
			$("#targetLayer").html(data);
			$("#targetLayer").css('opacity','1');
			setInterval(function() {$("#body-overlay").hide(); },500);
			},
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>
<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ UPLOAD-FOTO ]</h5>		
	  </div>
	  <div class="widget-content">

		<div class="control-group">
				<form id="uploadForm" action="<?=base_url("login/pages/".$Pr."/upload-foto/edit/".$id)?>" method="post">

				<center>
					<input type="submit" value="Kembali" onclick="parent.location='<?=base_url("login/pages/".$Pr."/list/Aksi/".$JENIS_CPCL."/".$KDKEGUNIT."/".$UNITKEY_KEC."/".$UNITKEY)?>'" class="btnSubmit" />
					<input type="submit" value="Upload Photo" class="btnSubmit" />
				</center>
				<div id="targetOuter">
					<div id="targetLayer"></div>
					<img src="<?=base_url("assets/img-cpcl/photo.png")?>"  class="icon-choose-image" />					
					<div class="icon-choose-image" >
						<input name="userImage" id="userImage" type="file" class="inputFile" onChange="showPreview(this);" />
					</div>
				</div>
				<div>
				
				</form><br><br><br><br><br>
		</div>
	  </div>
	</div>
</div>
  