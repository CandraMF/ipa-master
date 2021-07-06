<?php
	
	$readonly="";
	switch($Aksi){
		case "edit":
			$row = new stdClass();	
			$row=$this->m_action->ambilData("select * from dbsipd_".$_tahun.".t_renstra_dana where KDRENDANA='".$id."'");			
			$readonly=" readonly ";
			foreach($row as $key => $value){$$key = $this->andri->clean($value);}
		break;
		case "hapus":	
			$row=$this->m_action->ambilData("select KDRENSKEG FROM dbsipd_".$_tahun.".t_renstra_dana where KDRENDANA='".$id."'");
			$qry="delete from dbsipd_".$_tahun.".t_renstra_dana where KDRENDANA='".$id."'";
			$this->db->query($qry);		
			$this->m_action->logData($qry, "DELETE", "dbsipd_".$_tahun.".t_renstra_dana","KDRENDANA", $id);
			header("location:".base_url('login/pages/'.$Pr.'/list/kegiatan/'.$row->KDRENSKEG));
		break;
		default:
			if(empty($Aksi)){
				$row=$this->m_action->KosongkanData("dbsipd_".$_tahun.".t_renstra_dana");		
			}else{				
				$row=$this->m_action->ambilData("SELECT KDRENSKEG, KDRENPROG, UNITKEY, KDPRGRM, KDKEGUNIT from dbsipd_".$_tahun.".t_renstra_keg WHERE KDRENSKEG='".@$id."'");
				foreach($row as $key => $value){$$key = $this->andri->clean($value);}

				if(empty($id)){
					header("location:".base_url('login/pages/'.$Pr));
				}
			}
	}
	
	$SetThnAwal=$_tahun-2;
	$SetThnAkhir=$_tahun+3;
	$i=1;
	while($SetThnAkhir>=$SetThnAwal){
		$ArrThn[$i-1]=$SetThnAwal;
		$SetThnAwal++;
		$i++;
	}
	
?>

<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ FORM ]</h5>		
	  </div>
	  <div class="widget-content">
		<div class="control-group form-horizontal">
			<form name=Fm id=Fm method=post action="#" class="form-horizontal">
				<div class="control-group">
				  <label class="control-label">Tahun :</label>
				  <div class="controls">	
					<input type='text' name='TAHUN' id='TAHUN' value='<?=floatval(@$row->TAHUN)?>' class='span4' readonly>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Persen :</label>
				  <div class="controls">
					 <div class="input-append">
					  <input type="text" placeholder='numeric' name="PERSEN" id="PERSEN" value="<?=floatval(@$row->PERSEN)?>" class="span3">
					  <span class="add-on">%</span> </div>
				   </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Pagu :</label>				  
				  <div class="controls">
					 <div class="input-append">
					  <input type="text" placeholder='numeric' name="PAGU" id="PAGU" value="<?=floatval(@$row->PAGU)?>" class="span7">
					  <span class="add-on">Rp</span> </div>
				   </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Kuantitas :</label>
				  <div class="controls">				
					<input type="text"  name="KUANTITAS" id="KUANTITAS" value="<?=floatval(@$row->KUANTITAS)?>"  class='span6' placeholder='numeric' />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Satuan :</label>
				  <div class="controls">				
					<input type="text"  name="SATUAN" id="SATUAN" value="<?=@$row->SATUAN?>"  class='span6' />
				  </div>
				</div>				
				<div class="control-group">
				  <label class="control-label">Keterangan :</label>
				  <div class="controls">
					<input type="text"  name="KETERANGAN" id="KETERANGAN" value="<?=@$row->KETERANGAN?>"  class='span12'/>
				  </div>
				</div>	
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr.'/list/dana/'.$id)?>'">Kembali</button>
				  </div>
				</div>
				<input type="hidden" name="KDRENDANA" id="KDRENDANA" value="<?=@$KDRENDANA?>">
				<input type="hidden" name="KDRENSKEG" id="KDRENSKEG" value="<?=@$KDRENSKEG?>">
				<input type="hidden" name="KDRENPROG" id="KDRENPROG" value="<?=@$KDRENPROG?>">				
				<input type="hidden" name="UNITKEY" id="UNITKEY" value="<?=@$UNITKEY?>">
				<input type="hidden" name="KDPRGRM" id="KDPRGRM" value="<?=@$KDPRGRM?>">
				<input type="hidden" name="KDKEGUNIT" id="KDKEGUNIT" value="<?=@$KDKEGUNIT?>">
			</form>	
		</div>
	  </div>
	</div>
</div>
  
 

<script>	
	$( document ).ready(function() {		
		/*script grid*/		
		$('#btnsimpan').click(function(){	
		
			var KDRENDANA=$('input[name^=KDRENDANA]').val();
			var KDRENSKEG=$('input[name^=KDRENSKEG]').val();
			var KDRENPROG=$('input[name^=KDRENPROG]').val();
			var UNITKEY=$('input[name^=UNITKEY]').val();
			var KDPRGRM=$('input[name^=KDPRGRM]').val();
			var KDKEGUNIT=$('input[name^=KDKEGUNIT]').val();
			var TAHUN=$('input[name^=TAHUN]').val();
			var PERSEN=$('input[name^=PERSEN]').val();
			var PAGU=$('input[name^=PAGU]').val();
			var KUANTITAS=$('input[name^=KUANTITAS]').val();
			var SATUAN=$('input[name^=SATUAN]').val();
			var KETERANGAN=$('input[name^=KETERANGAN]').val();
			
			  
			var dataPost={KDRENDANA:KDRENDANA, KDRENSKEG:KDRENSKEG, KDRENPROG:KDRENPROG, UNITKEY:UNITKEY, KDPRGRM:KDPRGRM, KDKEGUNIT:KDKEGUNIT, TAHUN:TAHUN, PERSEN:PERSEN, PAGU:PAGU, KUANTITAS:KUANTITAS, SATUAN:SATUAN, KETERANGAN:KETERANGAN};
			$.post("<?=base_url('skpd/'.$Pr.'_dana/simpan')?>",dataPost,
			function(data){	
				var data = $.parseJSON( data );		
				$('#InfoConfirm').modal('show'); 
				if(data.status=='success')
				{$('#txtinfo').html('Berhasil di simpan');}
				else
				{$('#txtinfo').html('Gagal di simpan');}
				<?php if($Aksi!='param'){ ?>
				setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/dana/'.$id)?>"; }, 1000);
				<?php }else{ ?>
				setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>"; }, 1000);		
				<?php } ?>
			});
		});
	});	
</script>