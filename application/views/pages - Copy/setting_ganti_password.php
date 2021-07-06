<div class="row-fluid">
	<div class="widget-box">
	  <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?> [ FORM ]</h5>		
	  </div>
	  <div class="widget-content">
		<div class="control-group form-horizontal">
			<form name=Fm id=Fm method=post action="#" class="form-horizontal">
				<div class="control-group">
				  <label class="control-label">Username :</label>
				  <div class="controls">	
					<input type="text" id='username' value='<?=@$sUserId?>' readonly/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Kata Sandi Lama :</label>
				  <div class="controls">	
					<input type="password" id='pwd_lama' name='pwd_lama'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Kata Sandi Baru :</label>
				  <div class="controls">	
					<input type="password" id='pwd_baru' name='pwd_baru'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label">Ulangi Sandi Baru :</label>
				  <div class="controls">	
					<input type="password" id='pwd_baru_ulangi' name='pwd_baru_ulangi'/>
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label"></label>
				  <div class="controls">
					<button type="button" id='btnsimpan' class="btn btn-primary">Simpan</button>					
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
			
			var username=$('#username').val();
			var pwd_lama=$('#pwd_lama').val();
			var pwd_baru=$('#pwd_baru').val();
			var pwd_baru_ulangi=$('#pwd_baru_ulangi').val();
			
			if(pwd_baru==pwd_baru_ulangi){
				var dataPost={username:username, pwd_lama:pwd_lama, pwd_baru:pwd_baru};
				$.post("<?=base_url('pengaturan/'.$Pr)?>",dataPost,
				function(data){	
					var data = $.parseJSON( data );		
					$('#InfoConfirm').modal('show'); 
					$('#txtinfo').html('Success');
					setTimeout(function(){ parent.location="<?=base_url('login/pages/'.$Pr)?>"; }, 1000);
				});
			}else{
				alert('Maaf, Password Baru Tidak Sama');
			}
			  
			
		});
	});	
</script>