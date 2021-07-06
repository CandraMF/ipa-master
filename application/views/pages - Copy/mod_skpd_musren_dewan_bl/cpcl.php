<?php
	$KDTAHAP=$_tahap;
	$data=$this->input->post();
	if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}

	$JENIS_CPCL=$this->uri->segment(6);	
	$KDDEWAN=$this->uri->segment(8);

	$IDKEC=!empty($IDKEC)?$IDKEC:"";
	

	

	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".t_kegiatan_cpcl where KDCPCL='".$id."'");	
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}
			$readonly=" readonly ";	
			if(!empty($AksiData)){
				$data=$this->input->post();
				if (!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
			}
		break;
		case "hapus":	
			$row=$this->m_action->ambilData("select JENIS_CPCL, KDKEGUNIT, KDDEWAN, UNITKEY from dbsipd_".$_tahun.".t_kegiatan_cpcl where KDCPCL='".$id."'");
			$JENIS_CPCL=$row->JENIS_CPCL;
			$KDKEGUNIT=$row->KDKEGUNIT;
			$KDDEWAN=$row->KDDEWAN;
			$UNITKEY=$row->UNITKEY;
			$qry="delete from dbsipd_".$_tahun.".t_kegiatan_cpcl where KDCPCL='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_kegiatan_cpcl","KDCPCL", $id);

			echo"<script>parent.location='".base_url("login/pages/".$Pr."/list/Aksi/".$JENIS_CPCL."/".$KDKEGUNIT."/".$KDDEWAN."/".$UNITKEY)."';</script>";
		
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".t_kegiatan_cpcl");		
			}
	}

	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:$this->uri->segment(7);		
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:$this->uri->segment(9);

	$LAT=!empty($LAT)?$LAT:"-6.571589";
	$LONGI=!empty($LONGI)?$LONGI:"107.758736";
	$POSTIDKEC=$this->input->post('IDKEC');
	$IDKEC=!empty($POSTIDKEC)?@$POSTIDKEC:$IDKEC;
	
	$dtprgrm = new stdClass();	
	$dtprgrm=$this->m_action->ambilData("SELECT KDPRGRM FROM dbsipd_".$_tahun.".t_rpjmd_keg WHERE KDKEGUNIT='".$KDKEGUNIT."'");
	$KDPRGRM=!empty($KDPRGRM)?$KDPRGRM:$dtprgrm->KDPRGRM;

	//////// REF
	$wh="";
	if(!empty($_kddewan)){
		$KDDEWAN=$_kddewan;
		$wh=" and KDDEWAN='{$KDDEWAN}'";		
	}
	$ref_row=$this->m_action->ambilData("select NODEWAN as NODEWAN, NMDEWAN AS NMDEWAN from dbsipd_".$_tahun.".mdprd where KDDEWAN='{$KDDEWAN}'");
	$NODEWAN=$ref_row->NODEWAN;
	$NMDEWAN=$ref_row->NMDEWAN;
	

	
	$row=$this->m_action->ambilData("SELECT distinct b.KDPRGRM, b.KDKEGUNIT, concat(c.NOPRGRM,b.NOKEG) AS NOKEG, b.NMKEG, c.UNITKEY AS URUSKEY FROM dbsipd_".$_tahun.".t_rpjmd_keg AS b  INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS c ON b.KDPRGRM=c.KDPRGRM WHERE  b.KDKEGUNIT='{$KDKEGUNIT}'");

	
	
	$NOKEG=$row->NOKEG;
	$NMKEG=$row->NMKEG;
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:$row->KDKEGUNIT;
	$KDPRGRM=!empty($KDPRGRM)?$KDPRGRM:$row->KDPRGRM;
	$URUSKEY=!empty($URUSKEY)?$URUSKEY:$row->URUSKEY;
	
	
	$rpagu = new stdClass();	
	$rpagu=$this->m_action->ambilData("SELECT PAGU FROM dbsipd_".$_tahun.".mdprd WHERE KDDEWAN='".$KDDEWAN."'");


	$rjml = new stdClass();	
	$rjml=$this->m_action->ambilData("SELECT z.JML FROM (
	SELECT  a.KDDEWAN, (if(isnull(b.PAGU_BTL),0,b.PAGU_BTL)+if(isnull(c.PAGU_BL),0,c.PAGU_BL)) AS JML FROM dbsipd_".$_tahun.".mdprd AS a
	LEFT JOIN (SELECT KDDEWAN, SUM(PAGU) AS PAGU_BTL from dbsipd_".$_tahun.".t_btl_cpcl WHERE KDTAHAP='{$KDTAHAP}' GROUP BY KDDEWAN) AS b ON a.KDDEWAN=b.KDDEWAN
	LEFT JOIN (SELECT KDDEWAN, SUM(PAGU) AS PAGU_BL from dbsipd_".$_tahun.".t_kegiatan_cpcl  WHERE KDTAHAP='{$KDTAHAP}' AND KDCPCL!='".$id."' GROUP BY KDDEWAN) AS c ON a.KDDEWAN=c.KDDEWAN
	) AS z WHERE z.JML>0 AND z.KDDEWAN='".$KDDEWAN."'");
	
	$NILAI_TOTAL=$rjml->JML;
	$NILAI_PAGU=$rpagu->PAGU;

?>
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

<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ FORM ]</h5>		
	  </div>
	  <div class="widget-content">
		<div class="control-group">
			
			<form name=Fm id=Fm method=post action="#"class="form-horizontal">
				<div class="control-group">
				  <label class="control-label">Lampiran</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('JENIS_CPCL',@$JENIS_CPCL,"select JENIS_CPCL as '0', LAMPIRAN as '1' from dbsipd_".$_tahun.".t_lampiran where JENIS_CPCL ='".@$JENIS_CPCL."'","onchange=\"Fm.submit();\"","Y")?>			
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Dewan</label>
				  <div class="controls">
					<div class="input-append">
					  <input type="text" style='width:120px;' readonly  value='<?=$NODEWAN?>'>					
					 </div>
					 <input type="text" class="span6" readonly  value='<?=$NMDEWAN?>'>	
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">SKPD Tujuan</label>
				  <div class="controls">
					 <?=$this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"SELECT DISTINCT a.UNITKEY  as '0', concat(a.KDUNIT,' ' ,a.NMUNIT) as '1' FROM dbsipd_".$_tahun.".mskpd  AS a where a.KDSTUNIT='3' ORDER BY a.KDUNIT","onchange=\"Fm.submit();\"")?>	
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Urusan</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('URUSKEY',@$URUSKEY,"select a.UNITKEY  as '0', a.NMUNIT as '1' from (SELECT UNITKEY, concat(KDUNIT,' ' ,NMUNIT) as 'NMUNIT'  FROM dbsipd_".$_tahun.".mskpd WHERE UNITKEY='203' union SELECT DISTINCT a.URUSKEY AS UNITKEY, concat(b.KDUNIT,' ' ,b.NMUNIT) as 'NMUNIT' FROM dbsipd_".$_tahun.".mskpd_urusan AS a INNER JOIN dbsipd_".$_tahun.".mskpd AS b on a.URUSKEY=b.UNITKEY where a.UNITKEY='{$UNITKEY}') AS a order by a.NMUNIT","onchange=\"Fm.submit();\"")?>				
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Program</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('KDPRGRM',@$KDPRGRM,"SELECT DISTINCT a.KDPRGRM  as '0', concat(a.NOPRGRM,' ' ,a.NMPRGRM) as '1' FROM dbsipd_".$_tahun.".t_rpjmd_pgrm  AS a  WHERE a.UNITKEY ='".@$URUSKEY."' or a.UNITKEY='203'  ORDER BY a.NOPRGRM","onchange=\"Fm.submit();\"")?>					
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Kegiatan</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('KDKEGUNIT',@$KDKEGUNIT,"SELECT distinct b.KDKEGUNIT  as '0', concat(b.NOKEG,' ',b.NMKEG) as '1' FROM dbsipd_".$_tahun.".t_rpjmd_keg AS b WHERE  b.KDPRGRM='".$KDPRGRM."'","onchange=\"Fm.submit();\"")?>					
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Sifat</label>
				  <div class="controls">
						<?=$this->m_auth->cmbQuery('KDSIFAT',@$KDSIFAT,"select KDSIFAT as '0', NMSIFAT as '1' from dbsipd_".$_tahun.".msifat_kegiatan")?>		
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Kecamatan :</label>
				  <div class="controls">				
					<?=$this->m_auth->cmbQuery('IDKEC',@$IDKEC,"select UNITKEY as '0', NMUNIT as '1' from dbsipd_".$_tahun.".mskpd where JENIS_OPD='KECAMATAN' and `TIPE`='D'","onchange='Fm.submit();'")?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Desa :</label>
				  <div class="controls">				
					<?=$this->m_auth->cmbQuery('IDDESA',@$IDDESA,"select IDDESA as '0', NMDESA as '1' from dbsipd_".$_tahun.".mdesa where UNITKEY='{$IDKEC}'")?>
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
					  <input type="hidden" placeholder='numeric' name="NHGU" id="NHGU" value="<?=floatval(@$PAGU)?>" class="span7">
					  <input type="text" placeholder='numeric' name="PAGU" id="PAGU" value="<?=floatval(@$PAGU)?>" class="span7">
					  <span class="add-on">Rp</span> </div>
				   </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Target :</label>				  
				  <div class="controls">
					 <div class="input-append">
					  <input type="text" placeholder='numeric' name="TARGET" id="TARGET" value="<?=floatval(@$TARGET)?>" class="span7">
					</div>
				   </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Satuan :</label>
				  <div class="controls">
					<input type="text"  name="SATUAN" id="SATUAN" value="<?=@$SATUAN?>"  class='span12'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Penanggung Jawab :</label>
				  <div class="controls">
					<input type="text"  name="PENANGGUNG_JAWAB" id="PENANGGUNG_JAWAB" value="<?=@$PENANGGUNG_JAWAB?>"  class='span12'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Deskripsi :</label>
				  <div class="controls">
					<input type="text"  name="DESKRIPSI" id="DESKRIPSI" value="<?=@$DESKRIPSI?>"  class='span12'/>
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
					<label class="control-label"></label>
					<div class="controls">
						<div id="map_canvas" style="width: 615px; height: 300px;"></div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr.'/cpcl/param/'.$JENIS_CPCL.'/'.$KDKEGUNIT.'/'.$KDDEWAN.'/'.$UNITKEY)?>';">Baru</button>
						<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
						<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url("login/pages/".$Pr."/list/Aksi/".$JENIS_CPCL."/".$KDKEGUNIT."/".$KDDEWAN."/".$UNITKEY)?>'">Kembali</button>
					</div>
				</div>


				
				<input type="hidden" name="KDCPCL" id="KDCPCL" value="<?=@$KDCPCL?>">
				<input type="hidden" name="KDTAHAP" id="KDTAHAP" value="<?=@$KDTAHAP?>">
				<input type="hidden" name="UNITKEY_KEC" id="UNITKEY_KEC" value="<?=@$UNITKEY_KEC?>">
			
				<input type="hidden" name="JENIS_CPCL" id="JENIS_CPCL" value="<?=@$JENIS_CPCL?>">
				<input type="hidden" name="KDDEWAN" id="KDDEWAN" value="<?=@$KDDEWAN?>">
				<input type="hidden" name="FOTO" id="FOTO" value="<?=@$FOTO?>">

				<input type="hidden" name="NILAI_TOTAL" id="NILAI_TOTAL" value="<?=@$NILAI_TOTAL?>">
				<input type="hidden" name="NILAI_PAGU" id="NILAI_PAGU" value="<?=@$NILAI_PAGU?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
			var KDCPCL=$('#KDCPCL').val();
			var JENIS_CPCL=$('#JENIS_CPCL').val();
			var KDTAHAP=$('#KDTAHAP').val();
			var UNITKEY_KEC=$('#UNITKEY_KEC').val();
			var UNITKEY=$('#UNITKEY').val();
			var KDPRGRM=$('#KDPRGRM').val();
			var KDKEGUNIT=$('#KDKEGUNIT').val();
			var KDDEWAN=$('#KDDEWAN').val();
			var KDSIFAT=$('#KDSIFAT').val();
			
			var KEGIATAN_PRIORITAS=$('#KEGIATAN_PRIORITAS').val();
			var SASARAN_KEGIATAN=$('#SASARAN_KEGIATAN').val();
			var IDKEC=$('#IDKEC').val();
			var IDDESA=$('#IDDESA').val();
			var LOKASI=$('#LOKASI').val();
			var TARGET=$('#TARGET').val();
			var SATUAN=$('#SATUAN').val();
			var DESKRIPSI=$('#DESKRIPSI').val();
			var PAGU=parseFloat($('#PAGU').val());
			var PENANGGUNG_JAWAB=$('#PENANGGUNG_JAWAB').val();
			var LAT=$('#lat').val();
			var LONGI=$('#long').val();

			var NILAI_TOTAL=parseFloat($('#NILAI_TOTAL').val());
			var NILAI_PAGU=parseFloat($('#NILAI_PAGU').val());
			
			var JNILAI=PAGU+NILAI_TOTAL;
			var SISAPAGU=NILAI_PAGU - NILAI_TOTAL;

			if(JNILAI>=NILAI_PAGU){
				alert('Maaf, Data Gagal disimpan Karena Melebihi Pagu Dengan sisa Rp. '+SISAPAGU);
			}else{
				var dataPost={KDCPCL:KDCPCL, JENIS_CPCL:JENIS_CPCL, KDTAHAP:KDTAHAP, UNITKEY_KEC:UNITKEY_KEC, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, KDDEWAN:KDDEWAN, KDSIFAT:KDSIFAT, KEGIATAN_PRIORITAS:KEGIATAN_PRIORITAS, SASARAN_KEGIATAN:SASARAN_KEGIATAN, IDKEC:IDKEC, IDDESA:IDDESA, LOKASI:LOKASI, TARGET:TARGET, SATUAN:SATUAN, DESKRIPSI:DESKRIPSI, PAGU:PAGU, PENANGGUNG_JAWAB:PENANGGUNG_JAWAB, LAT:LAT, LONGI:LONGI};
				$.post("<?=base_url('skpd/'.$Pr.'/simpan')?>",dataPost,
				function(data){	
					var data = $.parseJSON( data );		
					$('#InfoConfirm').modal('show'); 
					if(data.status=='success')
					{$('#txtinfo').html('Berhasil di simpan');}
					else
					{$('#txtinfo').html('Gagal di simpan');}
					$( '#btnsimpan' ).css( "display", "none" );
				});
			}
		});
	});	
</script>