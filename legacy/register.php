<?php session_start(); ?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
  <title>Haomai System</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="./assets/images/icons/favicon.png" type="image/x-icon" />
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

<body
  onload="notification(<?php echo "'" . $_SESSION['notification']['type'] . "', '" . $_SESSION['notification']['message'] . "'"; ?>)">
  <?php include "system/notification.php"; ?>
  <?php /*$_SESSION['user']['languageId'] = 2;	include "system/languageSettings.php";*/?>
  <div class="page">
    <div class="page-single">
      <div class="container">
        <div class="row">
          <div class="col col-login mx-auto">
            <div class="text-center mb-6">
              <!--<img src="./assets/images/icons/logo.png" class="h-6" alt="">-->
            </div>

            <form class="card"
              action="registerCheck.php?status=register<?php if ($_GET['register'] != "")
                echo "&register=" . $_GET['register'];
              if ($_GET['companyId'] != "")
                echo "&companyId=" . $_GET['companyId'];
              if ($_GET['pass'] != "")
                echo "&pass=" . $_GET['pass']; ?>"
              method="post">
              <div class="card-body p-6">
                <div class="card-title text-center">
                  <?php echo $_SESSION['language']['']; ?>REGISTRACIÓN
                </div>

                <div class="form-group">
                  <label class="form-label">Nombre Completo</label>
                  <input type="text" class="form-control" name="fullName" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Ingresar Nombre Completo" required>
                </div>
                <div class="form-group">
                  <label class="form-label">Correo Electrónico</label>
                  <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Ingresar Correo Electrónico" required>
                </div>
                <div class="form-group">
                  <label class="form-label">
                    Contraseña
                  </label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                    placeholder="Contraseña" required>
                </div>

                <div class="form-group">
                  <label class="custom-switch">
                    <input type="checkbox" name="term" class="custom-switch-input" required checked>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">De acuerdo con <a href="terms.php">términos y
                        condiciones</a></span>
                  </label>
                </div>
                <input type="hidden" name="lang" class="form-control" value="<?php echo $_GET['lang']; ?>">
                <div class="form-footer">
                  <button type="submit" class="btn btn-primary btn-block">Crear cuenta</button>
                </div>
              </div>
            </form>

            <!-- <?php if ($_GET['register'] != "eshop") { ?>
        
        <div class="card">
                <div class="card-body p-6">
                 
          <div class="form-group text-center ">
          <label class="form-label">
            Instructivo para la tienda virtual <a href="./Instructivo.pdf" target="_blank"> Abrir</a>
          </label>
          </div>
          
                </div>
              </div>
        
        <?php } ?> -->

            <div class="text-center text-muted">
              Ya tiene una cuenta? <a href="./login.php">Ingresar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>