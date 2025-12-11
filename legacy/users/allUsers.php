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
			<h3 class="card-title" style="font-weight:bold;">
			<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='allUsers.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
			<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Users List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit User']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create a new user']; ?>
			</h3>
		<!-- <div class="card-options">
		  <?php if ($_GET['tableStatus']=='view') { echo "<a href='allUsers.php?formStatus=create' class='btn btn-icon btn-lg'><i class='fe fe-user-plus'></i></a>"; }?>
		</div> -->
	  </div>
	  
	  <?php include "allUsersTable.php"; ?>
	  
	  <?php include "allUsersForm.php"; $info='info'?>
		
	</div>
  </div>		
<!-- End content-->  
<?php include "../system/contentEnd.php"; ?>			
			
