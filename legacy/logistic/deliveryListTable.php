					<?php
					
			
					$target = "deliveryId=".$_GET['deliveryId'];
					$pageUrl = "deliveryList.php?tableStatus=view&page=";
			
					
					$sql0 = "SELECT COUNT(*) AS rowNum FROM orders WHERE ".$target.";";  
					$stmt0= mysqli_query( $conn, $sql0); 
						
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
								<h3 class="card-title" style="font-weight:bold;">
								<a href='delivery.php?tableStatus=view&page=1' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Orders List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit order']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
								</h3> 
							  <div class="card-options">
							
								<div class="item-action">
									<a href='orderList.php?tableStatus=view&target=out&action=addDelivery&deliveryId=<?php echo $_GET['deliveryId']; ?>&page=1' class='btn btn-icon btn-sm'><i class='fe fe-plus'></i></a>&nbsp
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
									  <!--<th style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Owner'];?></th>		
									  <th style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Item'];?></th>
									  <th style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Quantity'];?></th>-->		
									  <!--<th class="text-right" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Price'];?></th>	-->
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Status'];?></th>									  
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									
									<?php
									//$sql = "SELECT id, requestId, date, time, userId, businessId, businessName, roleId, fullName, userEmail, companyEmail, COUNT(productId) AS item, SUM(quantity) AS quantity, SUM(itemPrice) AS price, currency, status FROM  ORDER BY id DESC;";  
									//$sql = "SELECT * FROM ( SELECT id, requestId, date, time, userId, businessId, customerId, customerBusinessName, customerAddress, userBusinessName, userAddress, supplierBusinessName, orderBusinessName, orderAddress, roleId, fullName, userEmail, supplierCompanyEmail , SUM(CASE WHEN quantity!=0 THEN 1 ELSE 0 END) AS item, SUM(quantity) AS quantity, SUM(itemPrice) AS price, currency, status, flagLogistic, ROW_NUMBER() OVER (ORDER BY id) as row FROM swrViewOrderList WHERE ".$target." GROUP BY id, orderId, requestId, userId, customerId, businessId, roleId, customerBusinessName, customerAddress, userBusinessName, userAddress, supplierBusinessName, orderBusinessName, orderAddress, fullName, date, time, userEmail, supplierCompanyEmail , currency, status, charge, chargePercent, discount, discountPercent, ownerId, flagLogistic) as alias WHERE row>".$min." and row<=".$max." ORDER BY id DESC;";  
									$sql = "SELECT * FROM orders WHERE deliveryId=".$_GET['deliveryId']." ORDER BY id DESC LIMIT $start, $limit;";
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
										<div><?php $flagLogistic=$row['flagLogistic']; include "orderStatus.php";?></div>
									  </td>
									  <td class="text-center">
										  <div>
											
											<a href="orderDetails.php?formStatus=view&tableStatus=view&target=<?php echo $_GET['target']; ?>&businessId=<?php echo $row['businessId']; ?>&userId=<?php echo $row['userId']; ?>&customerId=<?php echo $row['customerId']; ?>&orderAddress=<?php echo $row['orderAddress']; ?>&roleId=<?php echo $row['roleId']; ?>&status=<?php echo $row['status']; ?>&id=<?php echo $row['id']; ?>"><i class="dropdown-icon fe fe-eye"></i></a>
											<a href="deliveryUpdate.php?action=remove&deliveryId=<?php echo $_GET['deliveryId']; ?>&id=<?php echo $row['id']; ?>"><i class="dropdown-icon fe fe-x"></i></a>
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

function selectCheck(id){							

var result = document.getElementById(id);

if ( result.checked == true) {
	var selected = 1;
} else {
	var selected = 0;
}

    $.ajax({
        url: 'orderUpdate.php',
        type: 'GET',
        data: {id:id, selected:selected, action:"select"},
        success: function(data) {
			//toastr.success(id+selected);
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function clearCheck(){							

    $.ajax({
        url: 'orderUpdate.php',
        type: 'GET',
        data: {action:"clear"},
        success: function(data) {
			//toastr.success(id+selected);
			location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function assign(businessId){							

var deliveryUserId = document.getElementById("deliveryUser").value;

    $.ajax({
        url: 'orderUpdate.php',
        type: 'GET',
        data: {businessId:businessId, deliveryUserId:deliveryUserId, action:"assign"},
        success: function(data) {
			toastr.success(businessId+deliveryUserId);
			location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function statusUpdate(statusId, newStatus, businessId, userId){							

    $.ajax({
        url: 'orderUpdate.php',
        type: 'GET',
        data: {statusId:statusId, newStatus:newStatus, businessId:businessId, userId:userId, action:"update"},
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
</script>																