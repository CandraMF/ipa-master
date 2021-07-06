<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select UNITKEY, URUSKEY from dbsipd_".$_tahun.".mskpd_urusan where concat(trim(UNITKEY),'_',trim(URUSKEY))='".$id."'");	
			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".mskpd_urusan where concat(trim(UNITKEY),'_',trim(URUSKEY))='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".mskpd_urusan","concat(trim(UNITKEY),'_',trim(URUSKEY))", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".mskpd_urusan");		
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
				  <label class="control-label">SKPD :</label>
				  <div class="controls">				
					<?=$this->m_auth->cmbQuery('UNITKEY',@$row->UNITKEY,"SELECT UNITKEY as '0', CONCAT(KDUNIT,' ',NMUNIT) as '1' FROM dbsipd_".$_tahun.".mskpd WHERE TIPE='D'")?>
					
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Urusan :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('URUSKEY',@$row->URUSKEY,"SELECT UNITKEY as '0', CONCAT(KDUNIT,' ',NMUNIT) as '1' FROM dbsipd_".$_tahun.".mskpd WHERE KDSTUNIT='2'")?> 
				  </div>
				</div>				
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
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
			var URUSKEY=$('select[name^=URUSKEY]').val();
			  
			var dataPost={UNITKEY:UNITKEY, URUSKEY:URUSKEY};
			$.post("<?=base_url('daftar/'.$Pr.'/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				//setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr)?>"; }, 1000);
			});
		});
	});	
</script>