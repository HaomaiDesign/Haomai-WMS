<?php
$sqlCart = "SELECT COUNT(id) as countCart FROM cart WHERE userId=" . $_SESSION['user']['id'] . ";";
$stmtCart = mysqli_query($conn, $sqlCart);

if ($stmtCart) {
  while ($rowCart = mysqli_fetch_array($stmtCart, MYSQLI_ASSOC)) {
    $countCart = $rowCart['countCart'];
  }
}

$sqlNew = "SELECT COUNT(id) as countNew FROM orders WHERE businessId=" . $_SESSION['user']['businessId'] . " AND flagBuySell=1 AND status=0;";
$stmtNew = mysqli_query($conn, $sqlNew);

if ($stmtNew) {
  while ($rowNew = mysqli_fetch_array($stmtNew, MYSQLI_ASSOC)) {
    $countNew = $rowNew['countNew'];
  }
}

$sqlBuy = "SELECT COUNT(id) as countBuy FROM orders WHERE businessId=" . $_SESSION['user']['businessId'] . " AND flagBuySell=0 AND status=0;";
$stmtBuy = mysqli_query($conn, $sqlBuy);

if ($stmtBuy) {
  while ($rowBuy = mysqli_fetch_array($stmtBuy, MYSQLI_ASSOC)) {
    $countBuy = $rowBuy['countBuy'];
  }
}
?>

<div class="adminx-container">
  <nav class="navbar navbar-expand justify-content-between fixed-top">
    <?php if ($_SESSION["user"]["roleId"] == 2) { ?>
      <a class="navbar-brand mb-0 h1 d-none d-md-block"
        href="../stock/productsList.php?reportCat=ALL&tableStatus=view&page=1">
      <?php } else { ?>
        <a class="navbar-brand mb-0 h1 d-none d-md-block" href="<?php if ($_SESSION['user']['businessName'] == 'Haomai')
          echo "../company/profile.php?formStatus=create";
        else {
          if ($_SESSION["user"]["roleId"] == 3)
            echo "../reports/reportCatList.php?tableStatus=view&page=1";
          else
            echo "../market/orderList.php?target=company&tableStatus=view&target=out&page=1";
        } ?>">
        <?php } ?>
        <!--<img src="<?php echo $_SESSION['user']['logo']; ?>" class="navbar-brand-image d-inline-block align-top mr-2" alt="">-->
        <img src="../assets/images/logo/logo.png" class="navbar-brand-image d-inline-block align-top mr-2" alt="">
        Haomai System
        <!-- <?php echo $_SESSION['user']['businessName']; ?> -->
      </a>
      <?php if ($_SESSION['user']['roleId'] != 2) { ?>
        <div class="d-flex flex-1 d-block d-md-none">
          <a href="#" class="sidebar-toggle ml-3">
            <i class="fe fe-menu"></i>
          </a>
        </div>
      <?php } ?>
      <ul class="navbar-nav d-flex justify-content-center">
        <?php if ($_SESSION["user"]["roleId"] == 1 || $_SESSION["user"]["roleId"] == 6) { ?>
          <div class="item-action align-self-center mr-2">
            <a href="../market/orderList.php?tableStatus=view&target=out&page=1"
              class="btn btn-outline-secondary btn-sm active">
              <span>
                <i class="fas fa-money-check-alt"></i>
              </span>
              <span class="nav-name">
                <?php echo $_SESSION['language']['Orders']; ?>
              </span>
            </a>
          </div>

          <div class="item-action align-self-center mr-2">
            <a href="../stock/productsList.php?reportCat=ALL&tableStatus=view&page=1"
              class="btn btn-outline-secondary btn-sm active">
              <span>
                <i class="fas fa-list"></i>
              </span>
              <span class="nav-name">
                <?php echo $_SESSION['language']['Products List']; ?>
              </span>
            </a>
          </div>
          <?php if ($_SESSION["user"]["roleId"] == 1) { ?>
            <div class="item-action align-self-center mr-2">
              <a href="../stock/task.php?tableStatus=view&target=unit" class="btn btn-outline-secondary btn-sm active">
                <span>
                  <i class="fas fa-list"></i>
                </span>
                <span class="nav-name">
                  <?php echo $_SESSION['language']['Change Stock']; ?>
                </span>
              </a>
            </div>
          <?php } ?>
        <?php } ?>

      </ul>

      <ul class="navbar-nav d-flex justify-content-end mr-2">

        <!--
      <li class="nav-item dropdown d-flex align-items-center mr-2">
            <a class="nav-link nav-link-notifications" href="../showroom/orderList.php?target=company&tableStatus=view&page=1">
              <i class="fas fa-comment"></i>
    
            </a>    
          </li>
    
      
      
      
      <?php if (($_SESSION['user']['businessId'] != 0) and (($_SESSION['user']['roleId'] == 1) or ($_SESSION['user']['roleId'] == 4) or ($_SESSION['user']['roleId'] == 6))) { ?>
      <li class="nav-item dropdown d-flex align-items-center mr-2">
            <a class="nav-link nav-link-notifications" href="../market/orderList.php?target=company&tableStatus=view&page=1">
              <i class="fas fa-file-import"></i>
        <?php if ($countNew != 0)
          echo "<span id='countNew' class='nav-link-notification-number'>" . $countNew . "</span>"; ?>      
            </a>    
          </li>
      <?php }
      ; ?>
      <?php if ($_SESSION['user']['businessId'] != 0) { ?>
      <li class="nav-item dropdown d-flex align-items-center mr-2">
            <a class="nav-link nav-link-notifications" href="../market/marketCart.php?tableStatus=view&target=<?php if (($_GET['target'] == "supplier") or ($_GET['target'] == "purchase") or ($_GET['target'] == "user"))
              echo "purchase";
            else if (($_GET['target'] == "customer") or ($_GET['target'] == "sale") or ($_GET['target'] == "company"))
              echo "sale";
            else
              echo "purchase"; ?> ">
              <i class="fas fa-shopping-cart"></i>
              <?php if ($countCart != 0)
                echo "<span id='countCart' class='nav-link-notification-number'>" . $countCart . "</span>"; ?>
            </a>    
          </li>
          <?php }
      ; ?>
      <?php if (($_SESSION['user']['businessId'] != 0) and (($_SESSION['user']['roleId'] == 1) or ($_SESSION['user']['roleId'] == 5) or ($_SESSION['user']['roleId'] == 6))) { ?>
          <li class="nav-item dropdown d-flex align-items-center mr-2">
            <a class="nav-link nav-link-notifications" href="../market/orderList.php?target=user&tableStatus=view&page=1">
              <i class="fas fa-file-export"></i>
         <?php if ($countBuy != 0)
           echo "<span id='countBuy' class='nav-link-notification-number'>" . $countBuy . "</span>"; ?> 
            </a>    
          </li>
          <?php }
      ; ?>
      
       <?php if ($_SESSION['user']['subscription'] == 0) { ?>
          <li class="nav-item dropdown d-flex align-items-center mr-2">
            <a class="nav-link nav-link-notifications" href="<?php if ($_SESSION['user']['languageId'] == 4)
              echo "../Instructivo_Chino.pdf";
            else
              echo "../Instructivo.pdf"; ?>" target="_blank">
              <i class="fas fa-question-circle"></i>
        
            </a>    
          </li>
          <?php }
       ; ?>
                -->
        <!-- Notificatoins -->
        <!--
          <li class="nav-item dropdown d-flex align-items-center mr-2">
            <a class="nav-link nav-link-notifications" id="dropdownNotifications" data-toggle="dropdown" href="#">
              <i class="oi oi-bell display-inline-block align-middle"></i>
              <span class="nav-link-notification-number">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-notifications" aria-labelledby="dropdownNotifications">
              <div class="notifications-header d-flex justify-content-between align-items-center">
                <span class="notifications-header-title">
                  Notifications
                </span>
                <a href="#" class="d-flex"><small>Mark all as read</small></a>
              </div>

              <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action unread">
                  <p class="mb-1">Invitation for <strong>Lunch</strong> on <strong>Jan 12th 2018</strong> by <strong>Laura</strong></p>

                  <div class="mb-1">
                    <button type="button" class="btn btn-primary btn-sm">Accept invite</button>
                    <button type="button" class="btn btn-outline-danger btn-sm">Decline</button>
                  </div>

                  <small>1 hour ago</small>
                </a>

                <a href="#" class="list-group-item list-group-item-action">
                  <p class="mb-1"><strong class="text-success">Goal completed</strong><br />1,000 new members today</p>
                  <small>3 days ago</small>
                </a>

                <a href="#" class="list-group-item list-group-item-action">
                  <p class="mb-1 text-danger"><strong>System error detected</strong></p>
                  <small>3 days ago</small>
                </a>

                <a href="#" class="list-group-item list-group-item-action">
                  <p class="mb-1">Your task <strong>Design Draft</strong> is due today.</p>
                  <small>4 days ago</small>
                </a>
              </div>

              <div class="notifications-footer text-center">
                <a href="#"><small>View all notifications</small></a>
              </div>
            </div>
          </li>
      -->
        <!-- Notifications -->
        <?php if ($_SESSION['user']['roleId'] != 2) { ?>
          <div class="item-action">
            <form action="../system/itemList.php" method="get" autocomplete="off">
              <div class="input-icon">

                <input id="search2" name="search2" type="search2" placeholder="Buscar producto"
                  class="form-control header-search" value="<?php if ($_GET['search2'] != "")
                    echo $_GET['search2']; ?>" placeholder="<?php echo $_SESSION['language']['search2']; ?>">
                <input id="tableStatus" name="tableStatus" type="hidden" value="view">

                <span class="input-icon-addon">
                  <i class="fe fe-search"></i>
                </span>


              </div>
            </form>
          </div>
        <?php } ?>

        <li class="nav-item dropdown">
          <div class="dropdown">
            <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
              <span class="avatar" style="background-image: url(<?php if (isset($_SESSION['user']['avatar'])) {
                echo $_SESSION['user']['avatar'];
              } ?>)"></span>
              <span class="ml-2 d-none d-lg-block">
                <span class="text-default">
                  <?php if (isset($_SESSION['user']['fullName'])) {
                    echo $_SESSION['user']['fullName'];
                  } ?>
                </span>
                <small class="text-muted d-block mt-1">
                  <?php echo $_SESSION['language'][$_SESSION['user']['role']]; ?>
                </small>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <?php if ($_SESSION['user']['roleId'] != 2) { ?>
                <a class="dropdown-item" href="../users/userProfile.php?formStatus=view">
                  <i class="fe fe-user"></i>&nbsp &nbsp
                  <?php echo $_SESSION['language']['My Profile']; ?>
                </a>
              <?php } ?>
              <?php if ($_SESSION["user"]["roleId"] == 1) { ?>
                <a class="dropdown-item" href="../company/profile.php?formStatus=<?php if ($_SESSION['user']['businessId'] == 0)
                  echo 'create';
                else
                  echo 'view&id=' . $_SESSION['user']['businessId'] . ''; ?>">
                  <i class="fe fe-file-text"></i>&nbsp &nbsp
                  <?php echo $_SESSION['language']['Company Profile']; ?>
                </a>
                <div class="dropdown-divider"></div>
              <?php } ?>
              <!--
              <a class="dropdown-item" href="mailto:info@haomai.com.ar">
                <i class="fe fe-mail"></i>&nbsp &nbsp <?php echo $_SESSION['language']['Contact us']; ?>
              </a>
        -->

              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="../logout.php">
                <i class="fe fe-log-out"></i>&nbsp &nbsp
                <?php echo $_SESSION['language']['Sign out']; ?>
              </a>
            </div>
          </div>
        </li>
      </ul>
  </nav>

  <script>

    function changeCompany() {

      var businessId = document.getElementById("businessId").value;

      $.ajax({
        url: '../webservice/update.php',
        type: 'GET',
        data: { businessId: businessId, action: "changeCompany" },
        success: function (data) {
          location.reload();
          toastr.options.positionClass = "toast-top-left";
          console.log(data); // Inspect this in your console
        },
      });

    }
  </script>