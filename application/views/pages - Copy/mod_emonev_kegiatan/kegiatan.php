<?php	
	$data=$this->input->post();
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:$this->uri->segment(6);
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:$this->uri->segment(7);
	$KDRANCKEG=!empty($KDRANCKEG)?$KDRANCKEG:@$id;

	
	$KDTAHAP=$_tahap;
	$readonly="";
	switch($Aksi){
		case "edit":
			///////////// KEGIATAN
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".t_kegiatan_keg where KDRANCKEG='".$id."' and KDTAHAP='{$KDTAHAP}'");			
			$readonly=" readonly ";
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}

		break;
		case "hapus":			
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".t_kegiatan_keg where KDRANCKEG='".$id."' and KDTAHAP='{$KDTAHAP}'");			
			$readonly=" readonly ";
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}

			$qry="delete from dbsipd_".$_tahun.".t_kegiatan_dana where KDTAHAP='".$KDTAHAP."' and UNITKEY='".$UNITKEY."' and KDPRGRM='".$KDPRGRM."' and KDKEGUNIT='".$KDKEGUNIT."'";			
			$this->db->query($qry);	
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_kegiatan_dana","KDTAHAP, UNITKEY, KDPRGRM, KDKEGUNIT", "{$KDTAHAP}, {$UNITKEY}, {$KDPRGRM}, {$KDKEGUNIT}");
			$qry="delete from dbsipd_".$_tahun.".t_kegiatan_kinkeg where KDTAHAP='".$KDTAHAP."' and UNITKEY='".$UNITKEY."' and KDPRGRM='".$KDPRGRM."' and KDKEGUNIT='".$KDKEGUNIT."'";
			$this->db->query($qry);	
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_kegiatan_kinkeg","KDTAHAP, UNITKEY, KDPRGRM, KDKEGUNIT", "{$KDTAHAP}, {$UNITKEY}, {$KDPRGRM}, {$KDKEGUNIT}");
			$qry="delete from dbsipd_".$_tahun.".t_kegiatan_keg where KDRANCKEG='".$id."'";
			$this->db->query($qry);	
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_kegiatan_keg","KDRANCKEG", $id);
			
			header("location:".base_url('login/pages/'.$Pr.'/list/back/'.$KDKEGUNIT.'/'.$UNITKEY));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".t_kegiatan_keg");		
			}
	}
	$ref_row=$this->m_action->ambilData("select KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where UNITKEY='{$UNITKEY}'");
	$KDUNIT=$ref_row->KDUNIT;
	$NMUNIT=$ref_row->NMUNIT;
	
	
	$ref_row=$this->m_action->ambilData("SELECT distinct b.KDKEGUNIT, a.KDPRGRM, concat(c.NOPRGRM,b.NOKEG) AS NOKEG, b.NMKEG FROM dbsipd_".$_tahun.".t_renstra_keg AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS c ON a.KDPRGRM=c.KDPRGRM WHERE  a.UNITKEY='{$UNITKEY}' AND a.KDKEGUNIT='{$KDKEGUNIT}'");
	foreach($ref_row as $key => $value){$$key = $this->andri->clean($value);}
	
	$LAT=!empty($LAT)?$LAT:"-6.571589";
	$LONGI=!empty($LONGI)?$LONGI:"107.758736";
?>
<form name=Fm id=Fm method=post action="#">

<input type="hidden" name="KDRANCKEG" id="KDRANCKEG" value="<?=@$KDRANCKEG?>">
<input type="hidden" name="KDTAHAP" id="KDTAHAP" value="<?=@$KDTAHAP?>">
<input type="hidden" name="UNITKEY" id="UNITKEY" value="<?=@$UNITKEY?>">
<input type="hidden" name="KDPRGRM" id="KDPRGRM" value="<?=@$KDPRGRM?>">
<input type="hidden" name="KDKEGUNIT" id="KDKEGUNIT" value="<?=@$KDKEGUNIT?>">

<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>KEGIATAN</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">				
				<div class="control-group">
				  <label class="control-label">SKPD </label>
				  <div class="controls">					
					 <input type="text" class="span12" readonly  value='<?=$KDUNIT?> <?=$NMUNIT?>'>				
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Kegiatan</label>
				  <div class="controls">
					
					 <input type="text" class="span12" readonly  value='<?=$NOKEG?> <?=$NMKEG?>'>		
				  </div>
				</div>	
				
				
				<div class="control-group">
				  <label class="control-label">Latitude :</label>
				  <div class="controls">			
					 <input id="lat" name="lat" value="<?=@$LAT?>"  class='span5' style='border:1px solid #CCCCCC;' readonly/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Longitude :</label>
				  <div class="controls">
					 <input id="long" name="long" value="<?=@$LONGI?>" class='span5' style='border:1px solid #CCCCCC;' readonly/>
				  </div>
				</div>
				<div class="control-group">
					<div id="map_canvas" style="height: 300px;" class='span12'></div>
				</div>	
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>	
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>'">Kembali</button>	
				  </div>
				</div>
			</div>
		  </div>
		</div>
		
	</div>
	
	
	
</div>

</form>	
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=#YOUR-GOOGLE-API-KEY#&sensor=false"></script>
<script type='text/javascript'>//<![CDATA[
	window.onload=function(){
	  var map;
	  function initialize() {
		  var lati=document.getElementById("lat").value;
		  var longi= document.getElementById("long").value;
		  var myLatlng = new google.maps.LatLng(lati, longi);

		  var myOptions = {
			  zoom: 9,
			  center: myLatlng,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
		  };
		  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		  var marker = new google.maps.Marker({
			  draggable: true,
			  position: myLatlng,
			  map: map,
			  title: "Your location"
		  });

		  google.maps.event.addListener(marker, 'dragend', function (event) {
			  document.getElementById("lat").value = event.latLng.lat();
			  document.getElementById("long").value = event.latLng.lng();
			  infoWindow.open(map, marker);
		  });
	  }
	  google.maps.event.addDomListener(window, "load", initialize());
	}//]]> 
</script> 
<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
			/* PAGU KEGIATAN SKPD */
			var KDRANCKEG=$('#KDRANCKEG').val();
			var KDTAHAP=$('#KDTAHAP').val();
			var UNITKEY=$('#UNITKEY').val();
			var KDPRGRM=$('#KDPRGRM').val();
			var KDKEGUNIT=$('#KDKEGUNIT').val();
			
			var LAT=$('#lat').val();
			var LONGI=$('#long').val();
			var dataPost={KDRANCKEG:KDRANCKEG, KDTAHAP:KDTAHAP, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, LAT:LAT, LONGI:LONGI};
			$.post("<?=base_url('emonev/ranckegiatan_kegiatan/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}				
			});
			
			
			<?php if($Aksi!='param'){ ?>
			setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>"; }, 1000);
			<?php }else{ ?>
			setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/program/'.$id)?>"; }, 1000);		
			<?php } ?>
		
		});
	});	
</script>