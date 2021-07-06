<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select KDPAGU, UNITKEY, PAGU from dbsipd_".$_tahun.".t_pagu_skpd where KDPAGU='".$id."'");			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".t_pagu_skpd where KDPAGU='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_pagu_skpd","KDPAGU", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".t_pagu_skpd");		
			}
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
				  <label class="control-label">Unit Organisasi :</label>
				  <div class="controls">				
					
					<?=$this->m_auth->cmbQuery('UNITKEY',@$row->UNITKEY,"select UNITKEY as '0', concat(KDUNIT,' ',NMUNIT) as '1' from dbsipd_".$_tahun.".mskpd where TIPE='D' and KDSTUNIT='3' and UNITKEY!='203' order by KDUNIT")?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Pagu :</label>				 
				   <div class="controls">
					 <div class="input-append">
					  <input type="text" placeholder="5.000" name="PAGU" id="PAGU" value="<?=floatval(@$row->PAGU)?>" class="span11">
					  <span class="add-on">Rp.</span> </div>
				   </div>
				</div>				
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="KDPAGU" id="KDPAGU" value="<?=@$row->KDPAGU?>">
				<input type="hidden" name="KDTAHAP" id="KDTAHAP" value="<?=@$_tahap?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var UNITKEY=$('select[name^=UNITKEY]').val();
			var PAGU=$('input[name^=PAGU]').val();
			var KDPAGU=$('input[name^=KDPAGU]').val();
			var KDTAHAP=$('input[name^=KDTAHAP]').val();
			  
			var dataPost={KDPAGU:KDPAGU, UNITKEY:UNITKEY, PAGU:PAGU, KDTAHAP:KDTAHAP};
			$.post("<?=base_url('pemda/'.$Pr.'/simpan')?>",dataPost,
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