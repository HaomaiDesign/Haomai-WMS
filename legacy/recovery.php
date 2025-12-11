<?php session_start(); ?>
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
<body>
    <div class="page">
      <div class="page-single">
        <div class="container">
          <div class="row">
            <div class="col col-login mx-auto">
              <div class="text-center mb-6">
                <!--<img src="./assets/images/icons/logo.png" class="h-6" alt="">-->
              </div>
			  
			  <?php if ($_GET['reset']=='true') { ?>
			  
			  <form class="card" action="recoveryUpdate.php?password=reset&recovery=<?php echo $_GET['recovery'];?>&token=<?php echo $_GET['token']; if (isset($_GET['companyId'])) echo "&companyId=".$_GET['companyId'];?>" method="post">
                <div class="card-body p-6">
                  <div class="card-title text-center">RESTAURAR CONTRASEÑA</div>
                  <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php if(isset($_GET["email"])) { echo $_GET["email"]; } ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label class="form-label">
                      Nueva Contraseña                    
                    </label>
                    <input type="password" name="password" class="form-control" value="" id="exampleInputPassword1" placeholder="********">
                  </div>

                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Actualizar Contraseña</button>
                  </div>
                </div>
              </form>

              
			  
			  <?php } else { ?>
			  
			  <form class="card" action="recoveryUpdate.php?password=recovery&recovery=<?php echo $_GET['recovery']; if (isset($_GET['companyId'])) echo "&companyId=".$_GET['companyId'];?>" method="post">
                <div class="card-body p-6">
                  <div class="card-title text-center">RECUPERACIÓN DE CONTRASEÑA</div>
                  <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php if(isset($_GET["email"])) { echo $_GET["email"]; } ?>" placeholder="Enter email">
                  </div>
					<font color="red"><?php if ($_GET['reset']=='false') echo "Recovery token is expired, please request again."; else if($_GET['verify']=='true') echo "Please verify the recovery email sent (check SPAM folder), it may take a few minutes to receive.";  else if($_GET['verify']=='false') echo "Email does not exist, please verify.";?></font>
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Recuperar</button>
                  </div>
                </div>
              </form>
              <div class="text-center text-muted">
                Volver a <a href="./login.php">Ingreso</a>
              </div>
			    <?php } ?>
				
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  
</html>