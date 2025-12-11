<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>

<?php unset($_SESSION['form']); ?>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<!-- Start content-->
  <div class="col-12">
	<?php if ($_GET['tableStatus']=='view') { ?>
	<div class="card">
		<div class="card-status card-status-left bg-teal"></div>
		<div class="card-header">				
			
				<form class="form-inline" action="itemList.php?tableStatus=view" method="GET">
					<div style="width: 200px">
						<input type="date" id="datepicker" value="<?php if(isset($_GET['date'])){ $_SESSION['dateChange'] = $_GET['date']; echo $_SESSION['dateChange'];} else echo date("Y-m-d")?>" name="date" class="form-control" onchange="updateList()" width="276" autocomplete="off"/>
					</div>
					
					
					<div style="width: 200px">
						<select id='sel_wh' class="form-control" onchange="updateList()" name="warehouseId" style="width: 200px">
							<option value='allWarehouse'><?php echo $_SESSION['language']['All Warehouses'];?></option>
							<?php
								if(isset($_GET['warehouseId'])){
									list($id,$name) = explode("_",$_GET['warehouseId']);									
									$_SESSION['whData']['id'] = $id;
									$_SESSION['whData']['name'] = $name;
								}
								
								$sql = "SELECT id AS wid, name FROM warehouse WHERE businessId = ".$_SESSION['user']['businessId'];
								$stmt_warehouse = mysqli_query( $conn, $sql);
								if ($stmt_warehouse) {
									while($row = mysqli_fetch_array($stmt_warehouse, MYSQLI_ASSOC)) {
							?>
							<option value=<?php echo $row["wid"] . "_" . $row["name"] . "'"; if(isset($_GET['warehouseId']) && $_SESSION['whData']['id'] == $row["wid"]) echo " selected"  ?>><?php echo $row["name"] ?></option>
							<?php
									}
								} else {
									echo "Hubo un error al conectar con warehouse";
								}
								mysqli_free_result ($stmt_warehouse);
							?>
						</select>
					</div>
					
				</form>
			
			<div class="card-options">
				<div class="item-action">
					
					<form action="itemList.php" method="get" autocomplete="off" >
					<div class="input-icon mb-3">
						<input id="search" name="search" type="search" class="form-control header-search" value="<?php if ($_GET['search']!="") echo $_GET['search']; ?>" placeholder="<?php echo $_SESSION['language']['search'];?>">
						<input id="tableStatus" name="tableStatus" type="hidden" value="view">
						
						<span class="input-icon-addon">
						  <i class="fe fe-search"></i>
						</span>
					</div>
					</form>
					
					<!--
					<form id="search">
						<div class="input-icon mb-3">
							<input id="searchTable" onkeyup="tableFilter()" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['search'];?>" tabindex="1" autofocus>
							<span class="input-icon-addon">
					  			<i class="fe fe-search"></i>
							</span>
						</div>
					</form>
					-->
					
				</div>
			</div>
		</div>
	</div>
	<?php }; ?>
	

<?php include "itemListTable.php"; ?>
<?php include "itemListForm.php"; ?>				
<!-- End content-->  
<?php include "../system/tableFilters.php"; ?>
<?php include "../system/contentEnd.php"; ?>				
			
<script>	
function importProduct(businessId){							

    $.ajax({
        url: '../webservice/stock.php',
        type: 'GET',
        data: {businessId:businessId, action:"import"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			console.log(data); // Inspect this in your console
			location.reload();
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error(userId);
		console.log(data); // Inspect this in your console
    }  
    });

}
</script>	

<script>
	function updateList(){
		let sel_date = document.getElementById('datepicker').value;
		let sel_wh = document.getElementById('sel_wh').value; 
		console.log(sel_date);
		console.log(sel_wh);
		location.href = "itemList.php?tableStatus=view&date="+sel_date+"&warehouseId="+sel_wh;

	}
	
	
</script>