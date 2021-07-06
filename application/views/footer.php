  </div>
</div>

<!-- POPUP INFO -->
<div id="InfoConfirm" class="modal fade" >
<div class="modal-dialog modal-confirm">
	<div class="modal-content">
		
		<div class="modal-body">
			<p class="text-center" id='txtinfo'></p>
		</div>
		<div class="modal-footer">
			<button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
		</div>
	</div>
</div>
</div>     

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2020 &copy; I-PA.  </div>
</div>
<!--end-Footer-part-->
<script src="<?=base_url("assets/backend/js/default.js")?>"></script> 


<?php
	
	 $query=$this->db->query("select filterpage from dbsipd_".$_tahun.".mfilter_menu where filterpage='".@$Pr."'");
	 $row = $query->row();
	 if(!$row){
?>
	<script src="<?=base_url("assets/backend/js/jquery.min.js")?>"></script> 
	<script src="<?=base_url("assets/backend/js/jquery.ui.custom.js")?>"></script> 
<?php	 
	 }
?>
	

<script src="<?=base_url("assets/backend/js/bootstrap.min.js")?>"></script> 

<script src="<?=base_url("assets/backend/js/jquery.uniform.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/bootstrap-colorpicker.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/bootstrap-datepicker.js")?>"></script> 

<script src="<?=base_url("assets/backend/js/select2.min.js")?>"></script>
<script src="<?=base_url("assets/backend/js/jquery.dataTables.min.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/matrix.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/matrix.tables.js")?>"></script>

<script src="<?=base_url("assets/backend/js/jquery.toggle.buttons.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/masked.js")?>"></script> 

<script src="<?=base_url("assets/backend/js/matrix.form_common.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/wysihtml5-0.3.0.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/jquery.peity.min.js")?>"></script> 
<script src="<?=base_url("assets/backend/js/bootstrap-wysihtml5.js")?>"></script> 
<script>
	$('.textarea_editor').wysihtml5();
</script>
</body>
</html>
