					
<script>

$( document ).ready(function() {
    console.log("<?php echo $sql;?>");
});

function notificateLowStock(orderId){
	$.ajax({
        url: '../webservice/stock.php',
        type: 'GET',
        data: {orderId:orderId, action:"updateAllProdsStockState"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			data = JSON.parse(data);
			if(data.length > 0)
				toastr.warning("以下产品库存不足：\n" + data.join(", "));
        },
		error: function(data) { 
			toastr.options.positionClass = "toast-top-left";
			toastr.error("No se pudo obtener el estado actual de stock de los productos");
			console.log(data); // Inspect this in your console
    	}  
    });
}


function statusUpdateStock(dropdownIdName, statusId, newStatus, warehouseId, businessId, userId){							

// if (warehouseId=='') {
// 	warehouseId = document.getElementById("warehouseId").value;
// }

	statusBadge = document.getElementById('statusFlag-'+statusId);
	if(newStatus <= 4){
		document.getElementById(dropdownIdName).innerHTML = ""
	}

	var flagName = "";
	var flagClass = "badge badge-success";
	if(newStatus == 1) {
		flagName = "<?php echo $_SESSION['language']['Delivered']?>";
	}
	if(newStatus == 2) {
		flagName = "<?php echo $_SESSION['language']['Received']?>";
	}
	if(newStatus == 3 || newStatus == 4) {
		flagName = "<?php echo $_SESSION['language']['Not Applied']?>";
		flagClass = "badge badge-secondary";
	}
	if(newStatus >= 5) {
		flagName = "<?php echo $_SESSION['language']['Completed']?>";
	}

	statusBadge.className = flagClass;
	statusBadge.innerHTML = flagName;
	statusBadge.style.backgroundColor = "";
	
	// console.log("info:",statusId, newStatus, warehouseId, businessId, userId);
    $.ajax({
        url: '../webservice/stock.php',
        type: 'GET',
        data: {statusId:statusId, newStatus:newStatus, warehouseId:warehouseId, businessId:businessId, userId:userId, action:"update"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			// location.reload();
			// console.log(data); // Inspect this in your console
			if ($_GET['target']=='out') {
				notificateLowStock(statusId);
			}
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo modificar");
		console.log(data); // Inspect this in your console
    }  
    });

}

		
function statusUpdate(dropdownIdName,statusId, newStatus, flagInOut){
	//Disable del button
	//document.getElementById(dropdownIdName).innerHTML = ""

	document.getElementById('statusFlag-'+statusId).className = 'badge';
	document.getElementById('statusFlag-'+statusId).style.backgroundColor = '#c8a2c8';
	document.getElementById('statusFlag-'+statusId).innerHTML = "<?php echo $_SESSION['language']['Delivery'];?>";

    $.ajax({
        url: '../webservice/status.php',
        type: 'GET',
        data: {statusId:statusId, newStatus:newStatus, flagInOut:flagInOut, action:"update"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			//location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo modificar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function ableUpdate(id,variable){							

	document.getElementById(variable+'Display'+id).style.display = 'none';
	document.getElementById(variable+'Input'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).focus();
	
}

function update(table, id, variable, type){							

var value = document.getElementById(variable+"Input"+id).value;
/*
if (isNaN(value)){
	document.getElementById(variable+'Display'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).style.display = 'none';
} else { 
	var val = Number(value);
	val.toFixed(2);
	document.getElementById(variable+'Display'+id).innerHTML = val;
	document.getElementById(variable+'Display'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).style.display = 'none';
}
*/

    $.ajax({
        url: '../webservice/update.php',
        type: 'GET',
        data: {table:table, id:id, variable:variable, value:value, type:type},
        success: function(data) {
			
			location.reload();
			toastr.options.positionClass = "toast-top-left";
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede agregar el producto");
		console.log(data); // Inspect this in your console
    }  
    });



$('#loading').modal({
    backdrop: 'static',
    keyboard: false
})



}
</script>		
					
					<?php
					
					if ($_GET['target']=="in") {
						if ($_GET['search']!="")
							$target = "((userId=".$_SESSION['user']['id'].") AND (flagInOut=0) AND ((requestId LIKE N'%".$_GET['search']."%')OR(customerBusinessName LIKE N'%".$_GET['search']."%')OR(customerAddress LIKE N'%".$_GET['search']."%')OR(userBusinessName LIKE N'%".$_GET['search']."%')OR(userAddress LIKE N'%".$_GET['search']."%')OR(orderBusinessName LIKE N'%".$_GET['search']."%')OR(orderWhatsapp LIKE N'%".$_GET['search']."%')OR(orderWechat LIKE N'%".$_GET['search']."%')OR(orderPhone LIKE N'%".$_GET['search']."%')OR(orderAddress LIKE N'%".$_GET['search']."%')))";
						else
							//$target = "userId=".$_SESSION['user']['id'];
							$target = "((businessId=".$_SESSION['user']['businessId'].") AND (flagInOut=0))";
						$pageUrl = "orderList.php?target=in&tableStatus=view&page=";
						$flagInOut = 0;
					}
					
					if ($_GET['target']=="out") {
						if ($_GET['search']!="")
							$target = "((businessId=".$_SESSION['user']['businessId'].") AND (flagInOut=1) AND ((requestId LIKE N'%".$_GET['search']."%')OR(customerBusinessName LIKE N'%".$_GET['search']."%')OR(customerAddress LIKE N'%".$_GET['search']."%')OR(userBusinessName LIKE N'%".$_GET['search']."%')OR(userAddress LIKE N'%".$_GET['search']."%')OR(orderBusinessName LIKE N'%".$_GET['search']."%')OR(orderWhatsapp LIKE N'%".$_GET['search']."%')OR(orderWechat LIKE N'%".$_GET['search']."%')OR(orderPhone LIKE N'%".$_GET['search']."%')OR(orderAddress LIKE N'%".$_GET['search']."%')))";
						else
							$target = "((businessId=".$_SESSION['user']['businessId'].") AND (flagInOut=1))";
						
						$pageUrl = "orderList.php?target=out&tableStatus=view&page=";
						$flagInOut = 1;
					}
					
					$sql0 = "SELECT COUNT(id) AS rowNum FROM orders WHERE ".$target.";";  // condicion a mejorar, no funciona bien cuando hay get search con los campos a buscar

					$stmt0= mysqli_query( $conn, $sql0); 
						
					if ( $stmt0 ) {
						$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );  
						$totalItem = $row0['rowNum'];
						$limit = 50;
					
						$totalPage = ceil($totalItem/$limit);
						$start = ($_GET['page'] - 1) * $limit;
					}
					
					?>
					
					
					<div class="col-12">
						<?php if ($_GET['tableStatus']=='view') { ?>
						
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<div class="tags">
								
								<?php if($_SESSION["user"]["roleId"] != 2){ ?>
									<span class="tag<?php if ($_GET['target']=="in") echo " tag-success"; ?>">
									  <a href="orderList.php?tableStatus=view<?php echo "&target=in"; if ($_GET['businessId']!="") echo "&businessId=".$_GET['businessId']; ?>&page=1" class="tag-addon"><?php echo $_SESSION['language']['Merchandise Income'];?></a>
									</span>	
								<?php } ?>
								  
								  <span class="tag<?php if ($_GET['target']=="out") echo " tag-success"; ?>">
									<a href="orderList.php?tableStatus=view<?php echo "&target=out"; if ($_GET['businessId']!="") echo "&businessId=".$_GET['businessId']; ?>&page=1" class="tag-addon"><?php echo $_SESSION['language']['Merchandise Shipment'];?></a>
								  </span>
								
								
								
								  
								
	
								</div>
								<?php if($_SESSION["user"]["roleId"] != 2){ ?>
									<div class="card-options">
										<div class="item-action">
										<button type="button" id="add" onclick="window.location.href='orderUpdate.php?action=create&target=<?php echo $_GET['target']?>&businessId=<?php echo $_GET['businessId']?>&userId=<?php echo $_GET['userId']?>&date=<?= date('d-m-Y'); ?>'" class="btn btn-success btn-sm"><i class="fe fe-plus mr-2"></i> <?php echo $_SESSION['language']['Add'];?> </button> 
										<!--<button type="button" id="add" onclick="window.location.href='orderDetails.php?tableStatus=view&target=<?php echo $_GET['target']?>&businessId=<?php echo $_GET['businessId']?>&userId=<?php echo $_GET['userId']?>&id=<?php echo $_GET['id']?>&market=wholesale&page=1'" class="btn btn-success btn-sm"><i class="fe fe-plus mr-2"></i> <?php echo $_SESSION['language']['Add product'];?> </button> -->
										</div>
									</div>
								<?php } ?>
								<!--
								<div class="card-options">
									<div class="item-action">
										<form action="orderList.php" method="get">
											<input type="hidden" name="tableStatus" class="form-control" value="view">
											
											<?php if ($_GET['tableStatus']!="") echo "<input type='hidden' name='tableStatus' class='form-control' value='".$_GET['tableStatus']."'>";?>
											<?php //if ($_GET['search']!="") echo "<input type='hidden' name='search' class='form-control' value='".$_GET['search']."'>";?>
											<?php if ($_GET['target']!="") echo "<input type='hidden' name='target' class='form-control' value='".$_GET['target']."'>";?>
											<?php if ($_GET['market']!="") echo "<input type='hidden' name='market' class='form-control' value='".$_GET['market']."'>";?>
											<?php if ($_GET['businessId']!="") echo "<input type='hidden' name='businessId' class='form-control' value='".$_GET['businessId']."'>";?>
											<?php echo "<input type='hidden' name='page' class='form-control' value='1'>";?>
											<input id="search" name="search" value="<?php if ($_GET['search']!="") echo $_GET['search'];?>" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['Search'];?>&hellip;">
										</form>
									</div>
								</div>
								-->
						</div>
						</div>
						
						
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Orders List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit order']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
								</h3>
							  <div class="card-options">
								<div class="item-action">
									<?php echo $_SESSION['language']['Total']." ".$totalItem." ".$_SESSION['language']['orders']; ?>&nbsp&nbsp&nbsp
								</div>
								
								<div class="item-action">
									<a href="<?php echo $pageUrl."1";?>"<?php if ($_GET['page']==1) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-double-left"></i></a>
									<a href="<?php echo $pageUrl.($_GET['page']-1);?>"<?php if ($_GET['page']==1) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-left"></i></a>
									<a style="color: black;"><?php echo $_SESSION['language']['Page']." ".$_GET['page']." / ".$totalPage; ?>&nbsp </a> 
									<a href="<?php echo $pageUrl.($_GET['page']+1);?>"<?php if ($_GET['page']==$totalPage) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-right"></i></a>
									<a href="<?php echo $pageUrl.$totalPage;?>"<?php if ($_GET['page']==$totalPage) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-double-right"></i></a>&nbsp
								</div>
								
								
								<!-- <div class="item-action">
								  <button type="button" id="add" onclick="window.location.href='orderUpdate.php?action=create&target=<?php echo $_GET['target']?>&businessId=<?php echo $_GET['businessId']?>&userId=<?php echo $_GET['userId']?>'" class="btn btn-success btn-sm"><i class="fe fe-plus mr-2"></i> <?php echo $_SESSION['language']['Add'];?> </button> 
								  <button type="button" id="add" onclick="window.location.href='orderDetails.php?tableStatus=view&target=<?php echo $_GET['target']?>&businessId=<?php echo $_GET['businessId']?>&userId=<?php echo $_GET['userId']?>&id=<?php echo $_GET['id']?>&market=wholesale&page=1'" class="btn btn-success btn-sm"><i class="fe fe-plus mr-2"></i> <?php echo $_SESSION['language']['Add product'];?> </button>
								</div> -->
							  
							  </div>
							</div>


							  
							
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> #</th>
									  <th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Date'];?></th>
									  <th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Time'];?></th>
									  	<?php if ($_GET['target']=='in') { ?>
									  		<th style="width:30%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Origin'];?></th> <!-- "出处" -->
											<th style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Warehouse'];?></th>
									  	<?php }?> 	
									  	<?php if ($_GET['target']=='out') { ?>
									  		<th style="width:25%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Business Name'];?></th>
											<th style="width:20%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Address'];?></th>
									  	<?php }?> 
									  <!--<th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Location'];?></th>
									  <th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Province / State'];?></th>
									  <th style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Owner'];?></th>		
									  <th style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Item'];?></th>
									  <th style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Quantity'];?></th>-->		
									  <!--<th class="text-right" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Price'];?></th>	-->
									  <th class="text-center" style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Status'];?></th>									  
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									
									<?php
									//$sql = "SELECT * FROM ( SELECT id, requestId, date, time, userId, businessId, customerId, customerBusinessName, userBusinessName, supplierBusinessName, roleId, fullName, userEmail, supplierCompanyEmail , SUM(CASE WHEN quantity!=0 THEN 1 ELSE 0 END) AS item, SUM(quantity) AS quantity, SUM(itemPrice) AS price, currency, status, charge, chargePercent, discount, discountPercent, ownerId, ROW_NUMBER() OVER (ORDER BY id) as row FROM swrViewOrderList WHERE ".$target." GROUP BY id, orderId, requestId, userId, customerId, businessId, roleId, customerBusinessName, userBusinessName, supplierBusinessName, fullName, date, time, userEmail, supplierCompanyEmail , currency, status, charge, chargePercent, discount, discountPercent, ownerId) as alias WHERE row>".$min." and row<=".$max." ORDER BY id DESC;";  
									//$sql = "SELECT * FROM ( SELECT id, requestId, date, time, userId, businessId, customerId, customerBusinessName, customerAddress, customerLocation, userBusinessName, userAddress, userLocation, supplierBusinessName, supplierAddress, supplierLocation, orderBusinessName, orderAddress, orderLocation, roleId, fullName, userEmail, supplierCompanyEmail, supplierId, SUM(CASE WHEN quantity!=0 THEN 1 ELSE 0 END) AS item, SUM(quantity) AS quantity, SUM(itemPrice) AS price, status, charge, chargePercent, discount, discountPercent, ownerId, flagAccounting, flagStock, ROW_NUMBER() OVER (ORDER BY id) as row FROM swrViewOrderList WHERE ".$target." GROUP BY id, orderId, requestId, userId, customerId, businessId, roleId, customerBusinessName, customerAddress, customerLocation, userBusinessName, userAddress, userLocation, supplierBusinessName, supplierAddress, supplierLocation, orderBusinessName, orderLocation, orderAddress, fullName, date, time, userEmail, supplierCompanyEmail , status, charge, chargePercent, discount, discountPercent, ownerId, supplierId, flagAccounting, flagStock) as alias ORDER BY id DESC;";  
									/*
									if ($_GET['target']=='in')
										$sql = "SELECT a.id, a.date, a.time, a.businessName, a.address, a.location, a.flagInOut, b.orderId, COUNT(b.quantity) AS products, SUM(b.quantity) AS units FROM orders AS a LEFT JOIN orderDetails AS b ON a.id=b.orderId UNION SELECT a.id, a.date, a.time, a.businessName, a.address, a.location, a.flagInOut, b.orderId, COUNT(b.quantity) AS products, SUM(b.quantity) AS units FROM orders AS a RIGHT JOIN orderDetails AS b ON a.id=b.orderId WHERE a.flagInOut=0 GROUP BY b.quantity ORDER BY a.id DESC;";
									
									if ($_GET['target']=='out')
										$sql = "SELECT a.id, a.date, a.time, a.businessName, a.address, a.location, a.flagInOut, b.orderId, COUNT(b.quantity) AS products, SUM(b.quantity) AS units FROM orders AS a LEFT JOIN orderDetails AS b ON a.id=b.orderId WHERE a.flagInOut=1 GROUP BY b.quantity ORDER BY a.id DESC;";
									*/
										
										if ($_GET['target']=='in')
											$sql = "SELECT o.*, w.name AS warehouseName FROM orders o INNER JOIN warehouse w ON o.warehouseId = w.id WHERE flagInOut=0 ORDER BY id DESC LIMIT $start, $limit;";
									
										if ($_GET['target']=='out')
											$sql = "SELECT * FROM orders WHERE flagInOut=1 ORDER BY id DESC LIMIT $start, $limit;";
											// $sql = "SELECT o.*, w.name AS warehouseName FROM orders o INNER JOIN warehouse w ON o.warehouseId = w.id WHERE flagInOut=1 ORDER BY id DESC LIMIT $start, $limit;";
										
									
									$stmt = mysqli_query( $conn, $sql);  
									
									$count = 0;
								
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
								
									
									?>
									<tr>
									  <td>
										<div><?php echo str_pad($row['id'], 8, "0", STR_PAD_LEFT); ?></div>
									  </td>
									  <td>
										<div><?php echo date('d-m-Y', strtotime($row['date'])); ?></div>
									  </td>
									  <td>
										<div><?php echo date('H:i:s', strtotime($row['time'])); ?></div>
									  </td>

									  <?php if ($_GET['target']=='in') {?>
										<td>
											<div>
											<?php 
											
												$description = $row['description']; 
											
											if (strlen($description)>30)
													echo substr($description,0,30)."..."; 
												else
													echo $description;
											
											?>
											</div>
										</td>
										<td>
											<div>
											<?php 
											
												$warehouseName = $row['warehouseName']; 
											
											if (strlen($warehouseName)>30)
													echo substr($warehouseName,0,30)."..."; 
												else
													echo $warehouseName;
											
											?>
											</div>
										</td>
									  <?php } ?>

									  <?php if ($_GET['target']=='out') {?>
										<td>
											<div>
											<?php 
											
											if (strlen($row['businessName'])>30)
													echo substr($row['businessName'],0,30)."..."; 
												else
													echo $row['businessName'];
													
											?>
											</div>
										</td>
										<td>
											<div>
											<?php 
											
												$address = $row['address']; 
											
											if (strlen($address)>30)
													echo substr($address,0,30)."..."; 
												else
													echo $address;
											
											?>
											</div>
										</td>
									  <?php } ?>
									   <!--<td>
										<div>
										<?php 
										
											$location = $row['location']; 
										
										if (strlen($location)>30)
												echo substr($location,0,30)."..."; 
											else
												echo $location;
												
										?>
										</div>
									  </td>
									   <td>
										<div>
										<?php 
										
											$province = $row['province']; 
										
										if (strlen($province)>30)
												echo substr($location,0,30)."..."; 
											else
												echo $location;
												
										?>
										</div>
									  </td>
									 
									  <td class="text-center">
										<div><?php echo $row['products']; ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['units']; ?></div>
									  </td>
									  -->
									  <td class="text-center">
										<div class="item-action dropdown">
										  <a href="javascript:void(0)" <?php if($_SESSION["user"]["roleId"] != 2 && $row['status'] != 5) echo "data-toggle='dropdown'"; ?>  class="icon"><?php $status=$row['status']; $flagStock=$row['flagStock']; include "orderStatus.php";?></a>
										  <div id="dropdownStatusInfoId<?=$row['id'];?>" class="dropdown-menu dropdown-menu-right">
											<!-- <a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']; ?>','1','<?php echo $flagInOut; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Reviewing'];?></a>
											<a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']; ?>','2','<?php echo $flagInOut; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Updated'];?></a>
											<a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']; ?>','4','<?php echo $flagInOut; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Preparing'];?></a>
											<a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']; ?>','8','<?php echo $flagInOut; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Delivery'];?></a>
											<a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']; ?>','5','<?php echo $flagInOut; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Completed'];?></a>
											<a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']; ?>','6','<?php echo $flagInOut; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Cancelled'];?></a> -->
											<?php if (($_GET['target']=='out')&&($row['flagStock']==0)) { ?>
												<a href="javascript:void(0)" onclick="statusUpdateStock('dropdownStatusInfoId<?=$row['id'];?>','<?php echo $row['id']."','1','".$row['warehouseId']."','".$_SESSION['user']['businessId']."','".$_SESSION['user']['id']; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Delivered'];?></a>
												<a href="javascript:void(0)" onclick="statusUpdate('dropdownStatusInfoId<?=$row['id'];?>','<?php echo $row['id']; ?>','8','<?php echo $flagInOut; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Delivery'];?></a>
												<a href="javascript:void(0)" onclick="statusUpdateStock('dropdownStatusInfoId<?=$row['id'];?>','<?php echo $row['id']."','3','".$row['warehouseId']."','".$_SESSION['user']['businessId']."','".$_SESSION['user']['id']; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Not Applied'];?></a>
											<?php } ?>
											<?php if (($_GET['target']=='in')&&($row['flagStock']==0)) { ?>
												<a href="javascript:void(0)" onclick="statusUpdateStock('dropdownStatusInfoId<?=$row['id'];?>','<?php echo $row['id']."','2','".$row['warehouseId']."','".$_SESSION['user']['businessId']."','".$_SESSION['user']['id']; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Received'];?></a>
												<a href="javascript:void(0)" onclick="statusUpdateStock('dropdownStatusInfoId<?=$row['id'];?>','<?php echo $row['id']."','4','".$row['warehouseId']."','".$_SESSION['user']['businessId']."','".$_SESSION['user']['id']; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Not Applied'];?></a>
											<?php } ?>  
											
										  </div>
										</div>
										
										
										
									  </td>
									  <td class="text-center">
										  <div>
										  	<?php if($_SESSION["user"]["roleId"] != 2){ ?>
												<a style="margin-right:10px" href="printSaleOrderPage.php?target=<?= $_GET["target"];?>&businessId=<?php echo $row['businessId']; ?>&userId=<?php echo $row['userId']; ?>&date=<?php echo date('d-m-Y', strtotime($row['date'])); ?>&requestId=<?php echo $row['requestId']; ?>&orderId=<?php echo $row['id']; ?>" target="_blank"><i class="dropdown-icon fe fe-printer"></i></a>
												<?php if($row["status"] != 5){ ?>
													<a style="margin-right:10px" href="orderDetails.php?formStatus=view&tableStatus=view&target=<?php echo $_GET['target']; ?>&businessId=<?php echo $row['businessId']; ?>&requestId=<?php echo $row['requestId']; ?>&supplierId=<?php echo $row['supplierId']; ?>&userId=<?php echo $row['userId']; ?>&customerId=<?php echo $row['customerId']; ?>&roleId=<?php echo $_SESSION["user"]["roleId"]; ?>&status=<?php echo $row['status']; ?>&id=<?php echo $row['id']; ?>&date=<?php echo $row['date']; ?>&warehouseId=<?php echo $row['warehouseId']; ?>"><i class="dropdown-icon fas fa-pencil-alt"></i></a>
												<?php } ?>
											<?php } ?>
											<a href="../stock/orderDetails.php?formStatus=view&tableStatus=view&target=<?php echo $_GET['target']; ?>&businessId=<?php echo $row['businessId']; ?>&userId=<?php echo $row['userId']; ?>&customerId=<?php echo $row['customerId']; ?>&roleId=<?php echo $row['roleId']; ?>&status=<?php echo $row['status']; ?>&id=<?php echo $row['id']; ?>"><i class="dropdown-icon fe fe-eye"></i></a>
										  </div>
									  </td>
									</tr>
									<?php }; ?>
									
									<?php 
										
										if ( $count > 0 && $count <= 5 ) {
										
										for ($x = $count; $x <= 5; $x++) {
										  
										  echo "<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>";
										  
										}
										
										
										}

									?>
									
									
								 </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
							
								</div>
							</div>		

<div id="loading"></div>							
														