<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>

<?php unset($_SESSION['form']); ?>
<!-- Start content-->
  <div class="col-12">
	<?php if ($_GET['tableStatus']=='view') { ?>
	<div class="card">
		<div class="card-status card-status-left bg-teal"></div>
		<div class="card-header">
			
			<!-- <div class="card-options">
				<div class="item-action">
					<form>
						<input id="searchTable" onkeyup="tableFilter()" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['Search'];?>&hellip;" tabindex="1">
					</form>
				</div>
			</div> -->
		</div>
	</div>
	<?php }; ?>

						

<?php include "warehouseTable.php"; ?>
<?php include "warehouseForm.php"; ?>				
<!-- End content-->  
<?php include "../system/tableFilters.php"; ?>
<?php include "../system/contentEnd.php"; ?>				
			
