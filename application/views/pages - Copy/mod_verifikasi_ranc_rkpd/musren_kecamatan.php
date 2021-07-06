<?php
	$data=$this->input->post();
	if(!empty($data)){foreach($data as $key => $value){$$key = $this->andri->clean($value);}}
	

	
	$UNITKEY=!empty($UNITKEY)?$UNITKEY:"";
	$UNITKEY_KEC=!empty($UNITKEY_KEC)?$UNITKEY_KEC:"";
	$KDKEGUNIT=!empty($KDKEGUNIT)?$KDKEGUNIT:"";
	$JENIS_CPCL=!empty($JENIS_CPCL)?$JENIS_CPCL:"1";
	$KDTAHAP=$_tahap;

	
 
	$row=$this->m_action->ambilData("select KDUNIT, NMUNIT from dbsipd_".$_tahun.".mskpd where UNITKEY='{$UNITKEY}'");
	$KDUNIT=$row->KDUNIT;
	$NMUNIT=$row->NMUNIT;
	
	
?>
 <div class="widget-content form-horizontal">		
	
	<input type="hidden" name="UNITKEY_KEC" id='UNITKEY_KEC' value='<?=$UNITKEY_KEC?>'>
	<input type="hidden" name="KDKEGUNIT" id='KDKEGUNIT' value='<?=$KDKEGUNIT?>'>
	<div class="control-group">
	  <label class="control-label">Lampiran</label>
	  <div class="controls">
			<?=$this->m_auth->cmbQuery('JENIS_CPCL',@$JENIS_CPCL,"select JENIS_CPCL as '0', LAMPIRAN as '1' from dbsipd_".$_tahun.".t_lampiran where JENIS_CPCL in (1,2) order by JENIS_CPCL","onchange=\"Fm.submit();\"","Y")?>					
	  </div>
	</div>	
	<div class="control-group">
	  <label class="control-label">SKPD</label>
	  <div class="controls">
		<?php
			
			if(TRIM($_qryopd)=="NOT IN ('')"){
				echo $this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"select UNITKEY as '0', CONCAT(KDUNIT,' ', NMUNIT) as '1' from dbsipd_".$_tahun.".mskpd where KDSTUNIT in ('3')  order by KDUNIT","class='span12' onchange=\"Fm.submit();\"");
			}else{
				echo $this->m_auth->cmbQuery('UNITKEY',@$UNITKEY,"select UNITKEY as '0', CONCAT(KDUNIT,' ', NMUNIT) as '1' from dbsipd_".$_tahun.".mskpd where KDSTUNIT in ('3') and UNITKEY ".$_qryopd." order by KDUNIT","class='span12' onchange=\"Fm.submit();\"");
			}
			
		?>	

	  </div>
	</div>
	
	
	
</div>
<div class="widget-content">		
  <table class="table table-bordered table-striped with-check">
  <thead>
   <tr>			
	 <th style='padding-bottom:10px;'>No</th>	
	  <th style='padding-bottom:10px;'>Kegiatan Prioritas</th>	  
	  <th style='padding-bottom:10px;'>Sasaran Kegiatan</th>
	  <th style='padding-bottom:10px;'>Program</th>	
	  <th style='padding-bottom:10px;'>Lokasi (Desa/Kel/Kec)	</th>
	  <th style='padding-bottom:10px;'>Volume</th>
	  <th style='padding-bottom:10px;'>Pagu</th>
	  <th>Perangkat Daerah<br>Penanggung Jawab</th>			
	
	  <th style='padding-bottom:10px;'>Aksi<br>/Tgl. Verifikasi</th>
	
   </tr>
  </thead>
  <tbody>		   
	<?php			
		$i=1;
		$qry=$this->db->query("SELECT distinct bb.KDUNIT, bb.NMUNIT, b.NMUNIT as NMKEC, b.KDUNIT as KDUNITKEC, a.KDCPCL, f.NMPRGRM, a.KEGIATAN_PRIORITAS, a.SASARAN_KEGIATAN, concat(a.LOKASI,' ', c.NMDESA,' ' , b.NMUNIT) as LOKASI, concat(a.TARGET, ' ',a.SATUAN) VOLUME, a.PAGU, a.PENANGGUNG_JAWAB, a.FOTO, a.TGLVALID, f.NOPRGRM, f.NMPRGRM, e.NOKEG, e.NMKEG, a.TGLVERIFIKASI FROM dbsipd_".$_tahun.".t_kegiatan_cpcl AS a 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS b ON a.IDKEC=b.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS bbb ON a.UNITKEY_KEC=bbb.UNITKEY 
		LEFT JOIN dbsipd_".$_tahun.".mdesa AS c ON a.IDDESA=c.IDDESA 
		LEFT JOIN dbsipd_".$_tahun.".mskpd AS bb ON a.UNITKEY=bb.UNITKEY 
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_keg AS e ON a.KDKEGUNIT=e.KDKEGUNIT
		INNER JOIN dbsipd_".$_tahun.".t_rpjmd_pgrm AS f ON e.KDPRGRM=f.KDPRGRM				
		WHERE a.KDTAHAP='{$KDTAHAP}' AND a.UNITKEY ='{$UNITKEY}' AND a.JENIS_CPCL IN (1,3)  ORDER BY bbb.KDUNIT, bb.KDUNIT, f.NOPRGRM, e.NOKEG");
		
		$i=1;$KDUNITKEC="";
		foreach ($qry->result() as $row){	
			$FOTO=!empty($row->FOTO)?$row->FOTO:"assets/img-cpcl/photo.png";
			if(empty($row->TGLVALID)||($row->TGLVALID=='0000-00-00')){				
				$cmbdatavalid="Validasi";
				$ArrCmbUmum=array($cmbdatavalid,'Edit','Hapus');
				$TGLVALID="";
			}else{
				$cmbdatavalid="Un Validasi";
				$ArrCmbUmum=array($cmbdatavalid);
				$TGLVALID=$row->TGLVALID;
			}


			if(empty($KDUNITKEC) || $KDUNITKEC!=$row->KDUNITKEC )
				{	$KDUNITKEC=$row->KDUNITKEC;
					
					echo "<tr><td colspan=9 style='font-weight:bold;'>".$row->NMKEC."</td></tr>";
					$i=1;
				}

			echo "    
			<tr>					
				<td align=center>".$i.".</td>
				<td>".$row->KEGIATAN_PRIORITAS."</td>			
				<td>".$row->NOKEG." ".$row->NMKEG." (".$row->SASARAN_KEGIATAN." )</td>
				<td >".$row->NOPRGRM." ".$row->NMPRGRM."</td>
				
				<td>".$row->LOKASI."</td>
				<td>".$row->VOLUME."</td>
				
				<td style='text-align:right;'>".$this->andri->cetakuang($row->PAGU)."</td>
				<td>".$row->NMUNIT."</td>
				<td>
					".$this->andri->cmbUmum("cmbAksi","",$ArrCmbUmum,"data-id='".@$row->KDCPCL."' class='cmbAksi' style='width:80px;'")."<br>
					<center>".$TGLVALID."</center>
				</td>
				
			</tr>
			";
			$i++;
		}
	?>
  </tbody>
</table>
</div>

<div id="popkec" class="modal fade" >
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			
			<div class="modal-body">
				<div id="tree_kec"> </div>
			</div>
			<div class="modal-footer">
				<strong>DAFTAR KECAMATAN</strong>
			</div>
		</div>
	</div>
</div> 

<div id="popskpd" class="modal fade" >
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			
			<div class="modal-body">
				<div id="tree_skpd"> </div>
			</div>
			<div class="modal-footer">
				<strong>DAFTAR SKPD</strong>
			</div>
		</div>
	</div>
</div> 


<script src="<?=base_url("assets/tree/jquery/jquery.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/tree/jquery/jquery-ui.custom.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/tree/jquery/jquery.cookie.js")?>" type="text/javascript"></script>



<script type="text/javascript">	
	$( document ).ready(function() {	
	
		
		$('.cmbAksi').change(function(){	
			var cmbData=$(this).val();
			var KDCPCL=$(this).attr("data-id");			
			switch(cmbData) {
			  case "Validasi":
				var TGLVALID=$('#TGLVALID').val();
				var dataPost={KDCPCL:KDCPCL, TGLVALID:TGLVALID};
				$.post("<?=base_url('verifikasi/verifikasi_ranc_renja_bl/simpan')?>",dataPost,
				function(data){	
					var data = $.parseJSON( data );		
					$('#InfoConfirm').modal('show'); 
					if(data.status=='success')
					{$('#txtinfo').html('Berhasil di simpan');}
					else
					{$('#txtinfo').html('Gagal di simpan');}
					setTimeout(function(){ Fm.submit(); }, 1000);				
				});
			  break;
			  case "Un Validasi":
				var TGLVALID='0000-00-00';
				var dataPost={KDCPCL:KDCPCL, TGLVALID:TGLVALID};
				$.post("<?=base_url('verifikasi/verifikasi_ranc_renja_bl/simpan')?>",dataPost,
				function(data){	
					var data = $.parseJSON( data );		
					$('#InfoConfirm').modal('show'); 
					if(data.status=='success')
					{$('#txtinfo').html('Berhasil di simpan');}
					else
					{$('#txtinfo').html('Gagal di simpan');}
					setTimeout(function(){ Fm.submit(); }, 1000);				
				});
			  break;
			  case "Edit":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/pindah_data_bl/edit/')?>"+KDCPCL+"/<?=$JENIS_VALIDASI?>";
			  break;
			  case "Hapus":
				  parent.location="<?=base_url('login/pages/'.$Pr.'/pindah_data_bl/hapus/')?>"+KDCPCL+"/<?=$JENIS_VALIDASI?>";
			  break;
			}   
		});
		
	});
</script>	