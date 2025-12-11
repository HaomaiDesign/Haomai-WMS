<?php session_start();
//$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
include 'system/isMobile.php';

if (("$_SERVER[HTTP_HOST]"=="tich.com.ar")OR("$_SERVER[HTTP_HOST]"=="www.tich.com.ar")) {
	header ("Location: https://www.tich.com.ar/eshop/index.php?companyId=3");
	//header ("Location: https://www.tich.com.ar/ecommerce/company/3/index.php?companyId=3");
	/*
	if ($_SESSION['user']['device']=="Mobile") {
		header ("Location: /ecommerce/company/3/index.php?companyId=3");
	} else {
		header ("Location: /showroom/index.php?companyId=3");
	}*/
	
}; 

if (("$_SERVER[HTTP_HOST]"=="tich.ar")OR("$_SERVER[HTTP_HOST]"=="www.tich.ar")) {
	header ("Location: https://www.tich.com.ar/ecommerce/company/3/index.php?companyId=3");
	
}; 

if (("$_SERVER[HTTP_HOST]"=="tianchuang.com.ar")OR("$_SERVER[HTTP_HOST]"=="www.tianchuang.com.ar")) {
	header ("Location: https://www.tich.com.ar/ecommerce/company/3/index.php?companyId=3");
	
}; 

if (("$_SERVER[HTTP_HOST]"=="bambusaludable.com.ar")OR("$_SERVER[HTTP_HOST]"=="www.bambusaludable.com.ar")) {	
	header ("Location: https://www.tich.com.ar/eshop/index.php?companyId=3");
	//header ("Location: /eshop/index.php?companyId=3");
}; 

if ("$_SERVER[HTTP_HOST]"=="haomai.com.ar") {
	if ($_SERVER['HTTPS'] === 'off') {
		header ("Location: https://haomai.com.ar");
	}
};



?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title> Haomai</title>
  
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163916096-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-163916096-1');
	</script>

  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="assets/homepage/img/favicon.png" rel="icon">
  <link href="assets/homepage/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700|Open+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="assets/homepage/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="assets/homepage/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/homepage/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="assets/homepage/lib/aos/aos.css" rel="stylesheet">
  <link href="assets/homepage/lib/magnific-popup/magnific-popup.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="assets/homepage/css/style.css" rel="stylesheet">
  
  <script src="https://cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>

</head>

<body>

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <h1><a href="#intro" class="scrollto">HAOMAI</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="#intro"><img src="assets/homepage/img/logo.png" alt="" title="" /></img></a> -->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">

		  <li class="menu-active"><a href="login.php">Acceso</a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro">

    <div class="intro-text">
	  <br><br><br>
      <h2>Publique sus productos y reciba sus pedidos</h2>
      <p>Comparte el codigo QR autogenerado y gestione los pedidos con su cuenta.</p>
	  <p></p>
      <!--<a href="register.php" class="btn-get-started scrollto">Registrar</a>-->
	  <a href="login.php" class="btn-get-started scrollto">Acceder</a>
	  <!--<a href="register.php" class="btn-get-started scrollto">Registrar</a>-->
    </div>

<!--
    <div class="product-screens">
	
      <div class="product-screen-3" data-aos="fade-up" data-aos-delay="400">
        <img src="assets/homepage/img/expo.jpg" alt="">
      </div>
	
      <div class="product-screen-2" data-aos="fade-up" data-aos-delay="200">
        <img src="assets/homepage/img/product-screen-2.png" alt="">
      </div>

      <div class="product-screen-3" data-aos="fade-up">
        <img src="assets/homepage/img/product-screen-3.png" alt="">
      </div>

	
    </div>	-->
	

  </section><!-- #intro -->


  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-lg-left text-center">
          <div class="copyright">
            &copy; Copyright 2020 <strong>Haomai Technology SRL</strong>. Derechos reservados.
          </div>
          <div class="credits">
            <!--
              All the links in the footer should remain intact.
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Avilon
            -->
            Diseñado por <a href="http://www.haomaidesign.com">Haomai Design</a>
          </div>
        </div>
   
      </div>
    </div>
  </footer><!-- #footer -->


  <!-- JavaScript Libraries -->
  <script src="assets/homepage/lib/jquery/jquery.min.js"></script>
  <script src="assets/homepage/lib/jquery/jquery-migrate.min.js"></script>
  <script src="assets/homepage/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/homepage/lib/easing/easing.min.js"></script>
  <script src="assets/homepage/lib/aos/aos.js"></script>
  <script src="assets/homepage/lib/superfish/hoverIntent.js"></script>
  <script src="assets/homepage/lib/superfish/superfish.min.js"></script>
  <script src="assets/homepage/lib/magnific-popup/magnific-popup.min.js"></script>

  <!-- Contact Form JavaScript File -->
  <script src="assets/homepage/contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="assets/homepage/js/main.js"></script>

</body>
</html>
