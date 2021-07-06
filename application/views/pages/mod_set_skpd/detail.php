<?php
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbipa_".$_tahun.".tbl_set_skpd where Id='".$id."'");	
			$readonly=" readonly ";
		break;
		case "hapus":	
			$qry="delete from dbipa_".$_tahun.".tbl_set_skpd where Id='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbipa_".$_tahun.".tbl_set_skpd","Id", $id);
			header("location:".base_url('login/pages/'.$Pr));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbipa_".$_tahun.".tbl_set_skpd");		
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
				<input type="hidden"  name="Id" id="Id" value="<?=@$row->Id?>"  class='span8' <?=$readonly?>/>
				<div class="control-group">
				  <label class="control-label">Kode :</label>
				  <div class="controls">				
					<input type="text"  name="KdUnitKerja" id="KdUnitKerja" value="<?=@$row->KdUnitKerja?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Nama :</label>
				  <div class="controls">
					<input type="text"  name="NmUnitKerja" id="NmUnitKerja" value="<?=@$row->NmUnitKerja?>"  class='span8'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label">UPTD :</label>
				  <div class="controls">
					<input type="text"  name="UPTD" id="UPTD" value="<?=@$row->UPTD?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Alamat :</label>
				  <div class="controls">
					<input type="text"  name="Alamat" id="Alamat" value="<?=@$row->Alamat?>"  class='span8'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Akronim :</label>
				  <div class="controls">
					<input type="text"  name="Akr" id="Akr" value="<?=@$row->Akr?>"  class='span8'/>
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
		
			var Id=$('#Id').val();
			var KdUnitKerja=$('#KdUnitKerja').val();
			var NmUnitKerja=$('#NmUnitKerja').val();
			var UPTD=$('#UPTD').val();
			var Alamat=$('#Alamat').val();
			var Akr=$('#Akr').val();
			  
			var dataPost={Id:Id, KdUnitKerja:KdUnitKerja, NmUnitKerja:NmUnitKerja, UPTD:UPTD, Alamat:Alamat, Akr:Akr};
			$.post("<?=base_url('setting/'.$Pr.'/simpan')?>",dataPost,
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