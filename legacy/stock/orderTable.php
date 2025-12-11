					<?php
					
					if ($_GET['target']=="in") {
						$target = "businessId=".$_SESSION['user']['businessId']." AND flagInOut=0";
						$pageUrl = "orderList.php?target=in&tableStatus=view&page=";
					}
					
					if ($_GET['target']=="out") {
						$target = "businessId=".$_SESSION['user']['businessId']." AND flagInOut=1";
						$pageUrl = "orderList.php?target=out&tableStatus=view&page=";
					}
					
					$sql0 = "SELECT COUNT(id) AS rowNum FROM orders WHERE ".$target.";";  
					$stmt0= mysqli_query( $conn, $sql0);
					// echo $sql0;
						
					if ( $stmt0 ) {
						$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );  

						$totalItem = $row0['rowNum'];
						$limit = 100;
					
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
									
							
								<span class="tag<?php if ($_GET['target']=="in") echo " tag-success"; ?>">
									<a href="orderList.php?tableStatus=view<?php echo "&target=in"; if ($_GET['businessId']!="") echo "&businessId=".$_GET['businessId']; ?>&page=1" class="tag-addon"><?php echo $_SESSION['language']['Merchandise Income'];?></a>
								  </span>	
								  
								  <span class="tag<?php if ($_GET['target']=="out") echo " tag-success"; ?>">
									<a href="orderList.php?tableStatus=view<?php echo "&target=out"; if ($_GET['businessId']!="") echo "&businessId=".$_GET['businessId']; ?>&page=1" class="tag-addon"><?php echo $_SESSION['language']['Merchandise Shipment'];?></a>
								  </span>
								  
	
							</div>
							
							<div class="card-options">
								<div class="item-action">
									<div class="input-group">
											
									  <select id="warehouseId" name="warehouseId" onchange="updateWarehouse()" class="form-control">
										<?php 

												$sqlWarehouse = "SELECT * FROM warehouse WHERE businessId=".$_SESSION['user']['businessId'].";";  
												$stmtWarehouse = mysqli_query( $conn, $sqlWarehouse); 
																					

													if ( $stmtWarehouse ) {
														while( $rowWarehouse = mysqli_fetch_array( $stmtWarehouse, MYSQLI_ASSOC))  
														{  
															if ($_GET['warehouseId']==$rowWarehouse['id'])
																echo "<option value='".$rowWarehouse['id']."' selected>".$rowWarehouse['code']." - ".$rowWarehouse['name']." - ".$rowWarehouse['address']."</option>"; 
															else
																echo "<option value='".$rowWarehouse['id']."'>".$rowWarehouse['code']." - ".$rowWarehouse['name']." - ".$rowWarehouse['address']."</option>"; 
														}  
													}
											 ?>
									  </select>
											  
									</div>
								</div>
							</div>
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
							  </div>
							</div>


							  
							
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-truncate card-table">
								  <thead>
									<tr>
									<th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> #</th>
									  <th style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Date'];?></th>
									  <th style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Time'];?></th>
									  <th style="width:25%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Business Name'];?></th>
									  <th style="width:20%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Address'];?></th>
									  <th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Location'];?></th>
									  <th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Province / State'];?></th>
									  <th onclick="sortTable(7)" class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Status'];?></th>									  
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									
									<?php
									//$sql = "SELECT id, requestId, date, time, userId, businessId, businessName, roleId, fullName, userEmail, companyEmail, COUNT(productId) AS item, SUM(quantity) AS quantity, SUM(itemPrice) AS price, currency, status FROM  ORDER BY id DESC;";  
									//$sql = "SELECT * FROM ( SELECT id, requestId, date, time, userId, businessId, customerId, customerBusinessName, userBusinessName, supplierBusinessName, roleId, fullName, userEmail, supplierCompanyEmail , SUM(CASE WHEN quantity!=0 THEN 1 ELSE 0 END) AS item, SUM(quantity) AS quantity, SUM(itemPrice) AS price, currency, status, flagStock, ROW_NUMBER() OVER (ORDER BY id) as row FROM swrViewOrderList WHERE ".$target." GROUP BY id, orderId, requestId, userId, customerId, businessId, roleId, customerBusinessName, userBusinessName, supplierBusinessName, fullName, date, time, userEmail, supplierCompanyEmail , currency, status, flagStock) as alias WHERE row>".$min." and row<=".$max." ORDER BY id DESC;";  
									//$sql = "SELECT * FROM ( SELECT id, requestId, date, time, userId, businessId, customerId, customerBusinessName, customerAddress, customerLocation, userBusinessName, userAddress, userLocation, supplierBusinessName, supplierAddress, supplierLocation, orderBusinessName, orderAddress, orderLocation, roleId, fullName, userEmail, supplierCompanyEmail, supplierId, SUM(CASE WHEN quantity!=0 THEN 1 ELSE 0 END) AS item, SUM(quantity) AS quantity, SUM(itemPrice) AS price, status, charge, chargePercent, discount, discountPercent, ownerId, flagStock, ROW_NUMBER() OVER (ORDER BY id) as row FROM swrViewOrderList WHERE ".$target." GROUP BY id, orderId, requestId, userId, customerId, businessId, roleId, customerBusinessName, customerAddress, customerLocation, userBusinessName, userAddress, userLocation, supplierBusinessName, supplierAddress, supplierLocation, orderBusinessName, orderLocation, orderAddress, fullName, date, time, userEmail, supplierCompanyEmail , status, charge, chargePercent, discount, discountPercent, ownerId, supplierId, flagStock) as alias WHERE row>".$min." and row<=".$max." ORDER BY id DESC;";  
									
									if ($_GET['target']=='in')
									$sql = "SELECT * FROM orders WHERE businessId=".$_SESSION['user']['businessId']." AND flagInOut=0 ORDER BY id DESC LIMIT ".$start.", ".$limit.";";
							
									if ($_GET['target']=='out')
									$sql = "SELECT * FROM orders WHERE businessId=".$_SESSION['user']['businessId']." AND flagInOut=1 ORDER BY id DESC LIMIT ".$start.", ".$limit.";";
							
									
									$stmt = mysqli_query( $conn, $sql);  

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
									  <td>
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
									  
										<?php if (($_GET['target']=='out')AND($row['flagStock']==0)) { ?>
										<div class="item-action dropdown">
										  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><?php $flagStock=$row['flagStock']; include "orderStatus.php";?></a>
										  <div class="dropdown-menu dropdown-menu-right">
											<a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']."','1','".$_GET['warehouseId']."','".$_SESSION['user']['businessId']."','".$_SESSION['user']['id']; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Delivered'];?></a>
											<a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']."','3','".$_GET['warehouseId']."','".$_SESSION['user']['businessId']."','".$_SESSION['user']['id']; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Not Applied'];?></a>
										  </div>
										</div>
										<?php } elseif (($_GET['target']=='in')AND($row['flagStock']==0)){ ?>
										<div class="item-action dropdown">
										  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><?php $flagStock=$row['flagStock']; include "orderStatus.php";?></a>
										  <div class="dropdown-menu dropdown-menu-right">
											<a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']."','2','".$_GET['warehouseId']."','".$_SESSION['user']['businessId']."','".$_SESSION['user']['id']; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Received'];?></a>
											<a href="javascript:void(0)" onclick="statusUpdate('<?php echo $row['id']."','4','".$_GET['warehouseId']."','".$_SESSION['user']['businessId']."','".$_SESSION['user']['id']; ?>')" class="dropdown-item"> <?php echo $_SESSION['language']['Not Applied'];?></a>
										  
										  </div>
										</div>
										<?php } else { ?>
											<div><?php $flagStock=$row['flagStock']; include "orderStatus.php";?></div>
										<?php }?>
										
									  </td>
									  <td class="text-center">
										  <div>
											<a href="orderDetails.php?formStatus=view&tableStatus=view&target=<?php echo $_GET['target']; ?>&businessId=<?php echo $row['businessId']; ?>&userId=<?php echo $row['userId']; ?>&customerId=<?php echo $row['customerId']; ?>&roleId=<?php echo $row['roleId']; ?>&status=<?php echo $row['status']; ?>&id=<?php echo $row['id']; ?>"><i class="dropdown-icon fe fe-eye"></i></a>
										  </div>
									  </td>
									</tr>
									<?php }; ?>
								
								 </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
							
								</div>
							</div>										

<script>	
function statusUpdate(statusId, newStatus, warehouseId, businessId, userId){							

if (warehouseId=='') {
	warehouseId = document.getElementById("warehouseId").value;
}

    $.ajax({
        url: '../webservice/stock.php',
        type: 'GET',
        data: {statusId:statusId, newStatus:newStatus, warehouseId:warehouseId, businessId:businessId, userId:userId, action:"update"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo modificar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function updateWarehouse(){							

var e = document.getElementById("warehouseId");
var warehouseId = e.options[e.selectedIndex].value;

window.location.replace("orderList.php?target=<?php echo $_GET['target'];?>&tableStatus=view&warehouseId="+warehouseId+"&page=1");

}
</script>																