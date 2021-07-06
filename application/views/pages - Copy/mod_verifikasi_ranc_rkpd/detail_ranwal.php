<?php	
	$data=$this->input->post();
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:$this->uri->segment(6);
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:$this->uri->segment(7);
	$KDRANCKEG=!empty($KDRANCKEG)?$KDRANCKEG:@$id;
	$AksiData=!empty($AksiData)?$AksiData:"";

	
	$KDTAHAP=$_tahap;
	$readonly="";
	switch($Aksi){
		case "edit":
			///////////// KEGIATAN
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".t_kegiatan_keg where KDRANCKEG='".$id."' and KDTAHAP='{$KDTAHAP}'");			
			$readonly=" readonly ";
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}
			
			if(!empty($AksiData)){
				$data=$this->input->post();
				if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
			}
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
	
	
	$ref_row=$this->m_action->ambilData("SELECT distinct a.KDPRGRM, concat(c.NOPRGRM,b.NOKEG) AS NOKEG, b.NMKEG, c.UNITKEY AS URUSKEY FROM dbsipd_".$_tahun.".t_renstra_keg AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS c ON a.KDPRGRM=c.KDPRGRM WHERE  a.UNITKEY='{$UNITKEY}' AND a.KDKEGUNIT='".$KDKEGUNIT."'");
	
	if (!empty($data)){
		foreach($data as $key => $value){$$key = $this->andri->clean($value);}
	}else{
		foreach($ref_row as $key => $value){$$key = $this->andri->clean($value);}
	}
	
	$LAT=!empty($LAT)?$LAT:"-6.571589";
	$LONGI=!empty($LONGI)?$LONGI:"107.758736";
?>
<form name=Fm id=Fm method=post action="#">

<input type="hidden" name="KDRANCKEG" id="KDRANCKEG" value="<?=@$KDRANCKEG?>">
<input type="hidden" name="KDTAHAP" id="KDTAHAP" value="<?=@$KDTAHAP?>">
<input type="hidden" name="UNITKEY" id="UNITKEY" value="<?=@$UNITKEY?>">
<input type="hidden" name="AksiData" id="AksiData" value="<?=@$AksiData?>">


<div class="row-fluid">
	<div class="span6">
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
				  <label class="control-label">Urusan</label>
				  <div class="controls">					
						<?=$this->m_auth->cmbQuery('URUSKEY',@$URUSKEY,"select a.UNITKEY  as '0', a.NMUNIT as '1' from (SELECT UNITKEY, concat(KDUNIT,' ' ,NMUNIT) as 'NMUNIT'  FROM dbsipd_".$_tahun.".mskpd WHERE UNITKEY='203' union SELECT DISTINCT a.URUSKEY AS UNITKEY, concat(b.KDUNIT,' ' ,b.NMUNIT) as 'NMUNIT' FROM dbsipd_".$_tahun.".mskpd_urusan AS a INNER JOIN dbsipd_".$_tahun.".mskpd AS b on a.URUSKEY=b.UNITKEY where a.UNITKEY='{$UNITKEY}') AS a order by a.NMUNIT","onchange=\"Fm.AksiData.value='BknData';Fm.submit();\"")?>							
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Program</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('KDPRGRM',@$KDPRGRM,"SELECT DISTINCT a.KDPRGRM  as '0', concat(a.NOPRGRM,' ' ,a.NMPRGRM) as '1' FROM dbsipd_".$_tahun.".t_rpjmd_pgrm  AS a  WHERE a.UNITKEY ='".@$URUSKEY."' or a.UNITKEY='203'  ORDER BY a.NOPRGRM","onchange=\"Fm.AksiData.value='BknData';Fm.submit();\"")?>		
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Kegiatan</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('KDKEGUNIT',@$KDKEGUNIT,"SELECT a.KDKEGUNIT as '0', concat(b.NOKEG,' ',b.NMKEG)as '1' FROM dbsipd_".$_tahun.".t_renstra_keg AS a INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS b ON a.KDKEGUNIT=b.KDKEGUNIT WHERE a.KDPRGRM='{$KDPRGRM}' AND a.UNITKEY='{$UNITKEY}'")?>			
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Sifat</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('KDSIFAT',@$KDSIFAT,"select KDSIFAT as '0', NMSIFAT as '1' from dbsipd_".$_tahun.".msifat_kegiatan")?>		
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label">Lokasi :</label>
				  <div class="controls">				
					<input type="text" name="LOKASI" id="LOKASI" value="<?=@$LOKASI?>"  class='span12'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Kegiatan Prioritas :</label>
				  <div class="controls">				
					<input type="text"  name="KEGIATAN_PRIORITAS" id="KEGIATAN_PRIORITAS" value="<?=@$KEGIATAN_PRIORITAS?>"  class='span12'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Sasaran Kegiatan :</label>
				  <div class="controls">				
					<input type="text"  name="SASARAN_KEGIATAN" id="SASARAN_KEGIATAN" value="<?=@$SASARAN_KEGIATAN?>"  class='span12'/>
				  </div>
				</div>				
				<div class="control-group">
				  <label class="control-label">Pagu :</label>				  
				  <div class="controls">
					 <div class="input-append">
					  
					  <input type="text" placeholder='numeric' name="PAGU" id="PAGU" value="<?=floatval(@$PAGU)?>" class="span7">
					  <span class="add-on">Rp</span> </div>
				   </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Pagu (N+1):</label>				  
				  <div class="controls">
					 <div class="input-append">
					  
					  <input type="text" placeholder='numeric' name="PAGUN1" id="PAGUN1" value="<?=floatval(@$PAGUN1)?>" READONLY class="span7">
					  <span class="add-on">Rp</span> </div>
				   </div>
				</div>

				
				<div class="control-group">
				  <label class="control-label">Volume Target :</label>				  
				  <div class="controls">
					 <div class="input-append">
					  <input type="text" placeholder='numeric' name="TARGET" id="TARGET" value="<?=floatval(@$TARGET)?>" class="span7">
					</div>
				   </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Volume Satuan :</label>
				  <div class="controls">
					<input type="text"  name="SATUAN" id="SATUAN" value="<?=@$SATUAN?>"  class='span12'/>
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
			</div>
		  </div>
		</div>
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>Sumber Dana</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				<?php
					$query=$this->db->query("SELECT a.KDDANA, a.NMDANA, b.NILAIN, b.NILAIN1, b.KETERANGAN FROM dbsipd_".$_tahun.".mdana AS a LEFT JOIN (SELECT KDDANA, NILAIN, NILAIN1, KETERANGAN from dbsipd_".$_tahun.".t_kegiatan_dana WHERE KDTAHAP='{$KDTAHAP}' AND UNITKEY='{$UNITKEY}' AND KDPRGRM='{$KDPRGRM}' AND KDKEGUNIT='{$KDKEGUNIT}') AS b ON a.KDDANA=b.KDDANA");
					$i=1;
					foreach ($query->result_array() as $Isi){
						echo "
				
							<input type='hidden' id='KDDANA{$i}' value='{$Isi['KDDANA']}'>
							<div class='control-group'>
							 <label class='control-label label label-warning'>Dana :</label>
							 <label class='control-label label label-info'>				
								{$Isi['NMDANA']}
							  </label>
							</div>
							
							<div class='control-group'>
							  <label class='control-label'>Nilai (n) :</label>				  
							  <div class='controls'>
								 <div class='input-append'>
								  <input type='text' placeholder='numeric' name='NILAIN' id='NILAIN{$i}' value='{$Isi['NILAIN']}' class='span7'>
								  <span class='add-on'>Rp</span> </div>
							   </div>
							</div>
							<div class='control-group'>
							  <label class='control-label'>Nilai (n+1) :</label>				  
							  <div class='controls'>
								 <div class='input-append'>
								  <input type='text' placeholder='numeric' name='NILAIN1' id='NILAIN1{$i}' value='{$Isi['NILAIN1']}' class='span7' readonly>
								  <span class='add-on'>Rp</span> </div>
							   </div>
							</div>			
							<div class='control-group'>
							  <label class='control-label'>Keterangan :</label>
							  <div class='controls'>
								<input type='text'  name='KET_DANA' id='KET_DANA{$i}' value='{$Isi['KETERANGAN']}'  class='span12'/>
							  </div>
							</div>	
						";$i++;
					}
				?>	
				<input type="hidden" name="JMLDANA" id="JMLDANA" value='<?=($i-1)?>'>
			</div>
		  </div>
		</div>
	</div>
	
	<div class="span6">
		<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			<h5>Kinerja Kegiatan</h5>		
		  </div>
		  <div class="widget-content">
			<div class="control-group form-horizontal">
				
				<?php
					$query=$this->db->query("SELECT a.KDKINERJA, a.NMKINERJA, b.TOLAK_UKUR, b.TARGET_KINERJA_N, b.TARGET_KINERJA_N1 from mkinerja_kegiatan AS a LEFT JOIN (SELECT KDKINERJA, TOLAK_UKUR, TARGET_KINERJA_N, TARGET_KINERJA_N1 FROM t_kegiatan_kinkeg WHERE   KDTAHAP='{$KDTAHAP}' AND UNITKEY='{$UNITKEY}' AND KDPRGRM='{$KDPRGRM}' AND KDKEGUNIT='{$KDKEGUNIT}') AS b ON a.KDKINERJA=b.KDKINERJA");
					$i=1;
					foreach ($query->result_array() as $Isi){
						echo "
							<input type='hidden' id='KDKINERJA{$i}' value='{$Isi['KDKINERJA']}'>
							<div class='control-group'>
							  <label class='control-label label label-warning'>Indikator :</label>
							  <label class='control-label label label-info'>				
								{$Isi['NMKINERJA']}
							  </label>
							</div>
							<div class='control-group'>
							  <label class='control-label'>Tolak Ukur :</label>
							  <div class='controls'>
								<input type='text'  id='TOLAK_UKUR{$i}' value='{$Isi['TOLAK_UKUR']}'  class='span12'/>
							  </div>
							</div>
							<div class='control-group'>
							  <label class='control-label'>Target Kinerja (n) :</label>
							  <div class='controls'>
								<input type='text' id='TARGET_KINERJA_N{$i}' value='{$Isi['TARGET_KINERJA_N']}'  class='span12'/>
							  </div>
							</div>
							<div class='control-group'>
							  <label class='control-label'>Target Kinerja (n+1) :</label>
							  <div class='controls'>
								<input type='text' id='TARGET_KINERJA_N1{$i}' value='{$Isi['TARGET_KINERJA_N1']}'  class='span12'/>
							  </div>
							</div>
						";
						$i++;
					}
				?>
				<input type="hidden" name="JMLKINERJA" id="JMLKINERJA" value='<?=($i-1)?>'>
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
			var KDSIFAT=$('#KDSIFAT').val();
			var KEGIATAN_PRIORITAS=$('#KEGIATAN_PRIORITAS').val();
			var SASARAN_KEGIATAN=$('#SASARAN_KEGIATAN').val();
			var LOKASI=$('#LOKASI').val();
			var TARGET=$('#TARGET').val();
			var SATUAN=$('#SATUAN').val();
			var PAGU=$('#PAGU').val();
			var NPAGUN1=parseFloat(PAGU*10)/100
			$('#PAGUN1').val(NPAGUN1);
			var PAGUN1=$('#PAGUN1').val();
			var LAT=$('#lat').val();
			var LONGI=$('#long').val();
			var dataPost={KDRANCKEG:KDRANCKEG, KDTAHAP:KDTAHAP, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, KDSIFAT:KDSIFAT, KEGIATAN_PRIORITAS:KEGIATAN_PRIORITAS, SASARAN_KEGIATAN:SASARAN_KEGIATAN, LOKASI:LOKASI, TARGET:TARGET, SATUAN:SATUAN, PAGU:PAGU, PAGUN1:PAGUN1, LAT:LAT, LONGI:LONGI};
			$.post("<?=base_url('skpd/ranckegiatan_kegiatan/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}				
			});
			
		

			/* MASTER VARIABEL */			
			var JMLDANA=$('#JMLDANA').val();
			var JMLKINERJA=$('#JMLKINERJA').val();

			/* PAGU KEGIATAN DANA */
			var i =1;
			while(JMLDANA>=i){
				
					
				var KDDANA=$('#KDDANA'+i).val();
				var NILAIN=$('#NILAIN'+i).val();
				var JNILAIN1=parseFloat((NILAIN*10)/100);
				$('#NILAIN1'+i).val(JNILAIN1);
				var NILAIN1=$('#NILAIN1'+i).val();
				var KET_DANA=$('#KET_DANA'+i).val();
				
				  
				var dataPost={ KDTAHAP:KDTAHAP, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, KDDANA:KDDANA, NILAIN:NILAIN, NILAIN1:NILAIN1, KETERANGAN:KET_DANA};
				$.post("<?=base_url('skpd/ranckegiatan_dana/simpan')?>",dataPost,
				function(data){	
					var data = $.parseJSON( data );		
					$('#InfoConfirm').modal('show'); 
					if(data.status=='success')
					{$('#txtinfo').html('Berhasil di simpan');}
					else
					{$('#txtinfo').html('Gagal di simpan');}				
				});
				i++;
			}

			/* KINERJA KEGIATAN */
			var z=1;
		
			while(JMLKINERJA>=z){			
				
				var KDKINERJA=$('#KDKINERJA'+z).val();
				var TOLAK_UKUR=$('#TOLAK_UKUR'+z).val();
				var TARGET_KINERJA_N=$('#TARGET_KINERJA_N'+z).val();
				var TARGET_KINERJA_N1=$('#TARGET_KINERJA_N1'+z).val();
				
				  
				var dataPost={KDTAHAP:KDTAHAP,  UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, KDKINERJA:KDKINERJA, TOLAK_UKUR:TOLAK_UKUR, TARGET_KINERJA_N:TARGET_KINERJA_N, TARGET_KINERJA_N1:TARGET_KINERJA_N1};
				$.post("<?=base_url('skpd/ranckegiatan_kinkeg/simpan')?>",dataPost,
				function(data){	
					var data = $.parseJSON( data );		
					$('#InfoConfirm').modal('show'); 
					if(data.status=='success')
					{$('#txtinfo').html('Berhasil di simpan');}
					else
					{$('#txtinfo').html('Gagal di simpan');}
				});
				z++;
			}
			
			<?php if($Aksi!='param'){ ?>
			setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>"; }, 1000);
			<?php }else{ ?>
			setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/program/'.$id)?>"; }, 1000);		
			<?php } ?>
		
		});
	});	
</script>