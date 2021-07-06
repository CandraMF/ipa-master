<!doctype html>
<html class="no-js" lang="en">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $title; ?></title>
        <meta name="description" content="Lintas, Layanan Informasi dan Konsultasi Investasi Infrastruktur, Investasi PUPR, Investasi Kementerian PUPR">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" type="image/x-icon" href="<?php echo  base_url();  ?>assets/img/favicon.png">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/normalize.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/animate.min.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/font/flaticon.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/font5/flaticon.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/vendor/OwlCarousel/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/vendor/OwlCarousel/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/meanmenu.min.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/vendor/slider/css/nivo-slider.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/vendor/slider/css/preview.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/magnific-popup.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/map.css">
		<link rel="stylesheet" href="<?php echo  base_url();  ?>assets/vendor/dropify/dist/css/dropify.min.css">
        
        
		<link rel="stylesheet" href="<?php echo  base_url();  ?>assets/css/datatables/jquery.dataTables.min.css" type="text/css" />


		<link rel="stylesheet" type="text/css" href="<?php echo  base_url();  ?>assets/css/ticker-style.css"/>
		<link  media="screen" rel="stylesheet" type="text/css" href="<?php echo  base_url();  ?>assets/css/map/jqvmap.css"/>
		

        <!-- Modernizr Js -->
        <script src="<?php echo  base_url();  ?>assets/js/modernizr-2.8.3.min.js"></script>
		<script>
		    var base_url = "<?php echo  base_url();  ?>";
		   
		</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-104637658-1', 'auto');
  ga('send', 'pageview');

</script>	

<style>
      .canvas-map {
	      border: 10px solid #f5f5f5;
	      width: 100%;
	      overflow: hidden;
	      height: 400px;
	      
      }
	
      .jqvmap-zoomin {
        width: 20px;
        height: 20px;
        line-height: 12px;
      }
      .jqvmap-zoomout {
        width: 20px;
        height: 20px;
        top: 35px;
        line-height: 12px;
      }
      
.tab-content > .tab-pane:not(.active) {
    display: block;
    height: 0;
    overflow-y: hidden;
}      
      
.modal {
	margin: 30px auto;
}      
    </style>
	
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->

        <div id="wrapper">
            <!-- Header Area Start Here -->
            <header>                
                <div class="header header-four-style">
	                
					<div class="header-top-bar">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <div class="top-address">
                                        <ul>
                                            <li><a href="#"><img src="<?php echo  base_url();  ?>assets/img/punet2.jpg" width="80" style="margin-top:-8px;"></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <div class="top-address">
                                        <ul  class="text-right">
                                            <li >
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

					<div class="header-area">
                        <div class="container">
                            <div class="row">                         
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                    <div class="logo-area">
                                        <a href="#"><img src="<?php echo  base_url();  ?>assets/img/logolintaspupr.png" alt="logo" ></a>
                                    </div>
                                </div>  
                                <div class="col-lg-7 col-md-7 hidden-sm hidden-xs">
                                    <ul class="header-address">
                                        <li><i class="fa fa-stop" aria-hidden="true"></i>Direktorat Jenderal<span><a href="http://binakonstruksi.pu.go.id">Bina Konstruksi</a></span></li>
                                        
                                        <li><i class="fa fa-stop" aria-hidden="true"></i>Kementerian<span><a href="http://www.pu.go.id">Pekerjaan Umum & Perumahan Rakyat</a></span></li>
                                    </ul>
                                </div>   
                              
                            </div>  
                        </div> 
                    </div>                    
                    <div class="menu-four-style" id="sticker">
                        <div class="container">
                            <div class="row menu-full no-gutters">
                                <div class="col-lg-11 col-md-11 col-sm-12">
                                    <div class="main-menu-area">
                                        <nav>
                                            <ul>
	                                            <li>xxx
	                                            </li>
	                                            
												
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                
                                <div class="col-lg-1 col-md-1 hidden-sm" >
                                    <div class="get-quote2">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu Area Start -->
                <div class="mobile-menu-area">
                    <div class="container">
	                    
                        <div class="row">
                            <div class="col-md-12">

                                <div class="mobile-menu" >
                                    <nav id="dropdown">
                                            <ul>
	                                            <li><a href="#"><?php if($lang=="id") echo '<img src="'.base_url().'assets/img/id.png" width="24">&nbsp;&nbsp;&nbsp;Indonesia'; else echo '<img src="'.base_url().'assets/img/en.png" width="24">&nbsp;&nbsp;&nbsp;English';  ?> </a>
													<ul class="rt-dropdown-menu">

	                                            <?php if ($lang=="en"){  ?>
                                                <li><a href="<?php echo  base_url(); ?>id"><img src="<?php echo  base_url();  ?>assets/img/id.png" width="24"> Indonesia</a></li>
                                                <?php } else {  ?>
                                                <li><a href="<?php echo  base_url(); ?>en"><img src="<?php echo  base_url();  ?>assets/img/en.png" width="24"> English</a></li>
                                                <?php }  ?>
													</ul>
	                                            </li>
	                                            
	                                            <?php if($lang=="id"){  ?>

												<?php 
													$query=$this->db->query("SELECT * FROM tbl_menus where status_menu='Aktif' order by no_urut"); 
													$list_menu=$query->result();
													$induk="";
													$c=0;
													$before="";
													foreach($list_menu as $data){
														if ($induk!=$data->induk){
															$induk=$data->induk;
															if ($before=="menu")
															    echo "</li>";
															else
															if ($before=="submenu")
															    echo "</ul></li>";
														}
														
														if ($data->kategori=="menu"){
															  ?>
															 <li><a href="<?php echo  base_url()  ?>id/<?php echo $data->controller; ?>"><?php echo $data->menu; ?></a></li>
														<?php }
														else  
														if ($data->kategori=="dropdown"){
															  ?>
															 <li><a href="#"><?php echo $data->menu; ?></a>
															 	<ul class="rt-dropdown-menu">
														<?php }
														else  
														if ($data->kategori=="submenu"){ 
														 ?>
		                                                	<li><a href="<?php echo  base_url()  ?>id/<?php echo $data->controller; ?>/<?php echo $data->menu_seo; ?>"><?php echo $data->menu; ?></a></li>
														<?php }
														$before=$data->kategori;
	                                              
	                                            } 
	                                            if ($before=="menu")
												    echo "</li>";
												else
												    echo "</ul></li>";
	                                            

	                                            
	                                          ?>
	                                         <?php } else {  ?>
	                                         
	                                         
	                                         
<?php 
													$query=$this->db->query("SELECT * FROM tbl_menus where status_menu='Aktif' order by no_urut"); 
													$list_menu=$query->result();
													$induk="";
													$c=0;
													$before="";
													foreach($list_menu as $data){
														if ($induk!=$data->induk){
															$induk=$data->induk;
															if ($before=="menu")
															    echo "</li>";
															else
															if ($before=="submenu")
															    echo "</ul></li>";
														}
														
														if ($data->kategori=="menu"){
															  ?>
															 <li><a href="<?php echo  base_url()  ?>en/<?php echo $data->controller_en; ?>"><?php echo $data->menu_en; ?></a></li>
														<?php }
														else  
														if ($data->kategori=="dropdown"){
															  ?>
															 <li><a href="#"><?php echo $data->menu_en; ?></a>
															 	<ul class="rt-dropdown-menu">
														<?php }
														else  
														if ($data->kategori=="submenu"){ 
														 ?>
		                                                	<li><a href="<?php echo  base_url()  ?>en/<?php echo $data->controller_en; ?>/<?php echo $data->menu_en_seo; ?>"><?php echo $data->menu_en; ?></a></li>
														<?php }
														$before=$data->kategori;
	                                              
	                                            } 
	                                            if ($before=="menu")
												    echo "</li>";
												else
												    echo "</ul></li>";
	                                            

	                                            
	                                          ?>
	                                         
	                                         
	                                         
	                                         <?php }  ?>
                                                <li><a href="<?php echo  base_url(); ?>forum">Forum</a></li>
	                                         
	                                         

                                            </ul>
                                    </nav>
                                </div>           
                            </div>
                        </div>
                    </div>
                </div>                  <!-- Mobile Menu Area End -->
            </header>
  
