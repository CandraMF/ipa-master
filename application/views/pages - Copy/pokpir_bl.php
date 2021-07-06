
<form method="post" action="<?=base_url('login/pages/'.$Pr)?>" id='Fm' name='Fm'>
<div class="row-fluid">
	<div class="widget-box">
	    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
		<h5><?=$_title?></h5>			
	  </div>
		 <!-- Data List Program -->
	  <div class="widget-content">		
			<a href="<?=base_url("login/cetak/".$Pr)?>" target='_blank'><button type="button" class="btn btn-primary">Cetak Rincian</button></a>
			<a href="<?=base_url("login/cetak/rekap_".$Pr)?>" target='_blank'><button type="button" class="btn btn-primary">Cetak Rekap</button></a>
			<a href="<?=base_url("login/cetak/rekap_bl_btl")?>" target='_blank'><button type="button" class="btn btn-primary">Cetak Rekap BL & BTL</button></a>
	  </div>	
	  
</div>
</form>	