<?php session_start();

//$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
/*
if ($_SERVER['HTTPS'] === 'off') {
	header ("Location: https://www.haomai.com.ar$_SERVER[REQUEST_URI]");
}

if (isset($_COOKIE["hmsys_login_access"])) {
	header ("Location: loginCheck.php");
}*/
?>

<!doctype html>
<html lang="en" dir="ltr">
<head>
	<title>Haomai System</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="./assets/images/icons/favicon.png" type="image/x-icon"/>
	<link rel="shortcut icon" type="image/x-icon" href="./assets/images/icons/favicon.png" />
    <link rel="stylesheet" type="text/css" href="./assets/css/adminx.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="./assets/css/dashboard.css" />
	<link rel="stylesheet" type="text/css" href="./assets/css/toastr.min.css" />
	<link rel="stylesheet" type="text/css" href="./assets/css/all.css" />
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="./assets/js/vendor.js"></script>
    <script src="./assets/js/adminx.js"></script>
	<script src="./assets/js/toastr.min.js"></script>
	
	
	
</head>
<body onload="notification(<?php echo "'".$_SESSION['notification']['type']."', '".$_SESSION['notification']['message']."'"; ?>)">
<?php include "system/notification.php"; ?>
    <div class="page">
      <div class="page-single">
        <div class="container">
          <div class="row">
            <div class="col col-login mx-auto">
              <div class="text-center mb-6">
                <!--<img src="./assets/images/icons/logo.png" class="h-6" alt="">-->
              </div>
              <form class="card" action="loginCheck.php" method="post">
                <div class="card-body p-6">
                  <div class="card-title text-center">INGRESO AL SISTEMA</div>
                  <div class="form-group">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="username" value="<?php if(isset($_COOKIE["hmsys_login_username"])) { echo $_COOKIE["hmsys_login_username"]; } ?>" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label class="form-label">
                      Contraseña
                      <a href="recovery.php?recovery=system" class="float-right small">Me olvidé la contraseña</a>
                    </label>
                    <input type="password" name="password" class="form-control" value="<?php if(isset($_COOKIE["hmsys_login_access"])) { echo $_COOKIE["hmsys_login_access"]; } ?>" id="exampleInputPassword1" placeholder="Password">
                  </div>
					<!--				  
                  <div class="form-group">
					<label class="custom-switch">
					  <input id="remember" type="checkbox" name="remember" class="custom-switch-input" checked>
					  <span class="custom-switch-indicator"></span>
					  <span class="custom-switch-description">Recuerdame</span>
					</label>
				  </div>
				  
				  <div class="form-group">
					<label class="custom-switch">
					  <input type="checkbox" name="autologin" class="custom-switch-input">
					  <span class="custom-switch-indicator"></span>
					  <span class="custom-switch-description">Auto Login</span>
					</label>
				  </div>
                  -->
				  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                  </div>
                </div>
              </form><!--
              <div class="text-center text-muted">
                Aún no tiene cuenta? <a href="./register.php">Registrar</a>
              </div>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  
</html>