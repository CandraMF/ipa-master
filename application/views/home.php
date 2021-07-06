<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js"  crossorigin="anonymous" ></script>
    <link rel="stylesheet" href="<?=base_url("assets/login/style.css")?>" />
    <title>I-PA</title>
  </head>
  <body>
	<?php
		$thn=!empty($thn)?$thn:date('Y')-1;
	?>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="<?=base_url('login')?>" class="sign-in-form" method='post'>
            <h2 class="title"><img src="<?=base_url("assets/login/img/logo.png")?>" height="99" border="0" alt=""></h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="username"/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="password" />
            </div>
			 <div class="input-field">
              <i class="fas fa-calendar"></i>
              <input type="text" placeholder="Tahun" name="tahun" value='<?=$thn?>'/>
            </div>
            <input type="submit" value="Login" class="btn solid" />
		
          </form>
          <form action="#" class="sign-up-form">
            <h2 class="title">Tentang I-PA</h2>
           
            <p class="social-text">
				 Sistem Informasi I-PA adalah alat sistematis yang bisa mengawasi Obat  mengelola stok, mengontrol jumlah produk yang akan dikeluarkan, dan melacak obat yang akan didistribusikan.
			</p>
          
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3> I-PA </h3>
            <p>
             UPTD FARMASI <BR>(Dinas Kesehatan Kab. Subang)
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Selengkapnya
            </button>
          </div>
          <img src="<?=base_url("assets/login/img/log.svg")?>" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>PEMERINTAH KABUPATEN SUBANG</h3>
            <p>
              DINAS KESEHATAN (UPTD FARMASI)
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="<?=base_url("assets/login/img/register.svg")?>" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="<?=base_url("assets/login/app.js")?>"></script>
  </body>
</html>
