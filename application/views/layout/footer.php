 <?php
	$query=$this->db->query("SELECT * from tbl_statis"); 
	$data_statis=$query->result();
	foreach($data_statis as $data){	
		$fb=$data->akun_fb;
		$twitter=$data->akun_twitter;
		$ig=$data->akun_ig;
		$alamat_html=$data->alamat_html;
	}
 ?>	
 <footer>
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="footer-box">
                        <h2 class="title-bar-footer"><?php echo language('Tautan',$lang); ?></h2>
                        <ul class="useful-link">
							<?php $query=$this->db->query("SELECT * FROM tbl_tautan where status_data='Aktif'"); 
								$list_tautan=$query->result();
								foreach($list_tautan as $data){	                         ?>
                            <li><a href="<?php echo $data->link; ?>"><?php echo $data->nama_tautan; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="footer-box" style="margin-bottom:50px;">
                        <h2 class="title-bar-footer"><?php echo language('Kontak',$lang); ?></h2>
                        <div class="news-letter">
                           <?php echo $alamat_html; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="footer-box">
                        <h2 class="title-bar-footer">Disclaimer</h2>
                        <div class="news-letter">
	                        <?php if($lang=="id"){  ?>
                           Informasi pada layanan ini diperoleh dari berbagai sumber yang kredibel. 
Kementerian Pekerjaan Umum dan Perumahan Rakyat  tidak bertanggung jawab atas penyalahgunaan informasi tersebut dan kerugian yang ditimbulkan
<?php } else {  ?>


Information on this service is obtained from a variety of credible sources.
The Ministry of Public Works and Public Housing is not responsible for the misuse of such information and any losses incurred
<?php }  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <a href="https://seal.beyondsecurity.com/vulnerability-scanner-verification/lintas.pu.go.id"><img src="https://seal.beyondsecurity.com/verification-images/lintas.pu.go.id/vulnerability-scanner-2.gif" alt="Website Security Test" border="0" /></a>
<p>&copy; 2017 <?php echo language('Direktorat Jenderal Bina Konstruksi',$lang); ?></p>
        </div>
    </div>
            
 </footer>
 </div>
   





        <!-- Preloader Start Here -->
        <!-- Preloader End Here -->

        <!-- jquery-->  
        <script src="<?php echo  base_url();  ?>assets/js/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/input-custom.js" type="text/javascript"></script>
		<script src="<?php echo  base_url();  ?>assets/vendor/dropify/dist/js/dropify.min.js"></script>
        
		<script src="<?php echo  base_url();  ?>assets/js/jquery.ticker.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/wow.min.js"></script>
        <script src="<?php echo  base_url();  ?>assets/vendor/slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/vendor/slider/home.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/vendor/OwlCarousel/owl.carousel.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/jquery.meanmenu.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/jquery.scrollUp.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/validator.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/modernizr-2.8.3.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/main.js" type="text/javascript"></script>
        
        <script src="<?php echo  base_url();  ?>assets/js/jquery.magnific-popup.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/vendor/noUiSlider/nouislider.min.js" type="text/javascript"></script>
        <script src="<?php echo  base_url();  ?>assets/js/wNumb.js" type="text/javascript"></script>
		<script src="<?php echo  base_url();  ?>assets/js/jquery.vmap.js" type="text/javascript" ></script>
		<script src="<?php echo  base_url();  ?>assets/js/jquery.vmap.indonesia.js" charset="utf-8" type="text/javascript" ></script>
        
        
        
		<script src='https://www.google.com/recaptcha/api.js'></script>



<!-- livezilla.net PLACE SOMEWHERE IN BODY -->
<div id="lvztr_657" style="display:none"></div><script id="lz_r_scr_d3770e3c52cde89c29c97595b223716b" type="text/javascript">lz_ovlel = [{type:"wm",icon:"commenting"},{type:"chat",icon:"comments",counter:true},{type:"ticket",icon:"envelope"}];lz_ovlel_classic = true;lz_ovlec = null;lz_code_id="d3770e3c52cde89c29c97595b223716b";var script = document.createElement("script");script.async=true;script.type="text/javascript";var src = "http://lintas.pu.go.id/chat/server.php?rqst=track&output=jcrpt&intid=YWRtaW5pc3RyYXRvcg__&intgroup=c3VwcG9ydA__&ovlv=djI_&ovltwo=MQ__&ovlc=MQ__&esc=IzQwNzhjNw__&epc=IzQ5ODllMQ__&ovlts=MA__&ovlmb=MA__&ovlapo=MQ__&nse="+Math.random();script.src=src;document.getElementById('lvztr_657').appendChild(script);</script>
<!-- livezilla.net PLACE SOMEWHERE IN BODY -->




<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110158615-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-110158615-1');
</script>




</body>
</html>
