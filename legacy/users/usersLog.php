<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>
<?php unset($_SESSION['form']); ?>
<!-- Start content-->
  <div class="col-12">
	<div class="card">
		<div class="card-status card-status-left bg-teal"></div>
		<div class="card-header">
			<h3 class="card-title">
			<?php if ($_GET['tableStatus']=='view') echo "Company Users Log";?>
			</h3>
		<div class="card-options">
		  <?php if ($_GET['tableStatus']=='view') { echo "<a href='#' class='btn btn-icon btn-lg'><i class='fe fe-more-vertical'></i></a>"; }?>
		</div>
	  </div>
	  
	  <?php include "usersLogTable.php"; ?>
		
	</div>
  </div>		
<!-- End content-->  
<?php include "../system/contentEnd.php"; ?>
