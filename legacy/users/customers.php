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
			<div class="card-options">
				<div class="item-action">
					<form action="customers.php?target=<?=$_GET["target"]?>&orderId=<?=$_GET["orderId"]?>" method="get" autocomplete="off" >
					<div class="input-icon mb-3">
						<input id="search" name="search" type="search" class="form-control header-search" value="<?php if ($_GET['search']!="") echo $_GET['search']; ?>" placeholder="<?php echo $_SESSION['language']['search'];?>">
						<input id="tableStatus" name="tableStatus" type="hidden" value="view">
						
						<span class="input-icon-addon">
							<i class="fe fe-search"></i>
						</span>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-status card-status-left bg-teal"></div>
		<div class="card-header">
			<h3 class="card-title" style="font-weight:bold;">
			<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='customers.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
			<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Customers']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit Customer']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create a new customer']; ?>
			</h3>
		<?php if($_SESSION["user"]["roleId"] ==1){ ?>
			<div class="card-options">
				<?php 
					$routeRef = "customers.php?formStatus=create";
					if(isset($_GET["orderId"])){
						$routeRef .= "&target=".$_GET["target"]."&orderId=".$_GET["orderId"]."&roleId=".$_SESSION["user"]["roleId"];
					}
					if ($_GET['tableStatus']=='view') {
						echo "<a href='".$routeRef."' class='btn btn-icon btn-lg'><i class='fe fe-user-plus'></i></a>"; 
					}
				?>
			</div>
		<?php } ?>
	  </div>
	  
	  <?php include "customersTable.php"; ?>
	  
	  <?php include "customersForm.php"; $info='info'?>
		
	</div>
  </div>		
<!-- End content--> 

<script>
$(searchTable).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});

</script>

<?php include "../system/tableFilters.php"; ?>
<?php include "../system/contentEnd.php"; ?>			
			
