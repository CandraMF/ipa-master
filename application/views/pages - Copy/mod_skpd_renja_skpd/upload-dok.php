<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ PROGRAM ]  [ FORM ]</h5>		
	  </div>
	  <div class="widget-content">
		<div class="control-group  form-horizontal">
			<form name=Fm id=Fm method=post action="#">
				<div class="control-group">
				  <label class="control-label">File upload KAK PDF*)</label>
				  <div class="controls">
					<input type="file" />
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>	
					<button type="button" class="btn btn-primary" onclick="parent.location='<?=base_url('login/pages/'.$Pr.'/list/kegiatan/'.$id)?>'">Kembali</button>	
				  </div>
				</div>	
			</form>
		</div>
	  </div>
	</div>
</div>
  