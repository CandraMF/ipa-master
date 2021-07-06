<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".mrekr where MTGKEY='".$id."'");	
			
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbsipd_".$_tahun.".mrekr where MTGKEY='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".mrekr","MTGKEY", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".mrekr");		
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
				  <label class="control-label">Kode :</label>
				  <div class="controls">				
					<input type="text"  name="KDREK" id="KDREK" value="<?=@$row->KDREK?>"  class='span8'/>					
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">
					<input type="text"  name="NMREK" id="NMREK" value="<?=@$row->NMREK?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Struktur :</label>
				  <div class="controls">
					<?=$this->m_auth->cmbQuery('KDSTREK',@$row->KDSTREK,"SELECT KDSTREK as '0', NMSTREK as '1' FROM dbsipd_".$_tahun.".mstruktur_rekening")?> 
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">Tipe :</label>
				  <div class="controls">
					<?=$this->andri->cmbUmum('TIPE',@$row->TIPE,array('H','D'))?>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="MTGKEY" id="MTGKEY" value="<?=@$row->MTGKEY?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var MTGKEY=$('input[name^=MTGKEY]').val();
			var KDREK=$('input[name^=KDREK]').val();
			var NMREK=$('input[name^=NMREK]').val();
			var KDSTREK=$('select[name^=KDSTREK]').val();
			var TIPE=$('select[name^=TIPE]').val();
			  
			var dataPost={MTGKEY:MTGKEY, KDREK:KDREK, NMREK:NMREK, KDSTREK:KDSTREK, TIPE:TIPE};
			$.post("<?=base_url('daftar/'.$Pr.'_rekr/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'?tab=tab2')?>"; }, 1000);
			});
		});
	});	
</script>