					<?php
					
					
					$target = "businessId=".$_SESSION['user']['businessId'];
					$pageUrl = "delivery.php?tableStatus=view&page=";
					
					
					$sql0 = "SELECT COUNT(id) AS rowNum FROM delivery WHERE ".$target.";";  
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
									 
									  <th style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> #</th>
									  <th class="text-center" style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Date'];?></th>
									  <th class="text-center" style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Time'];?></th>
									  <th class="text-center" style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Orders'];?></th>	
									  <th class="text-center" style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Item'];?></th>	
									  <th class="text-center" style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Quantity'];?></th>	
									  
									  
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									
									<?php
									//$sql = "SELECT id, requestId, date, time, userId, businessId, businessName, roleId, fullName, userEmail, companyEmail, COUNT(productId) AS item, SUM(quantity) AS quantity, SUM(itemPrice) AS price, currency, status FROM  ORDER BY id DESC;";  
									
									//$sql = "SELECT * FROM ( SELECT lgtDelivery.id, lgtDelivery.datetime, lgtDelivery.businessId, lgtDelivery.userId, lgtDelivery.deliveryCode, users.fullName, COUNT(DISTINCT orders.id) AS items, SUM(orderDetails.quantity) AS quantity, SUM(orderDetails.price*orderDetails.quantity) AS price, ROW_NUMBER() OVER (ORDER BY lgtDelivery.id) as row FROM lgtDelivery INNER JOIN orders ON orders.deliveryId=lgtDelivery.id INNER JOIN orderDetails ON orders.id=orderDetails.orderId LEFT JOIN users ON lgtDelivery.userId=users.id WHERE lgtDelivery.businessId=".$_SESSION['user']['businessId']." GROUP BY lgtDelivery.id, lgtDelivery.datetime, lgtDelivery.businessId, lgtDelivery.userId, lgtDelivery.deliveryCode, users.fullName) as alias WHERE row>".$min." and row<=".$max." ORDER BY id DESC;";  
									
									$sql = "SELECT id, datetime, SUM(quantity) AS quantities, COUNT(unitbarcode) AS products, orders FROM (SELECT a.id, a.datetime, SUM(c.quantity) AS quantity, COUNT(b.id) AS orders, c.unitBarcode FROM delivery AS a LEFT JOIN orders AS b ON a.id=b.deliveryId LEFT JOIN orderDetails AS c ON b.id=c.orderId GROUP BY a.id, c.unitBarcode) as newTable GROUP BY id ORDER BY id DESC LIMIT $start, $limit;";
									
									$stmt = mysqli_query( $conn, $sql);  
							
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
					
									
									?>
									<tr>
									  
									  <td>
										<div><?php echo str_pad($row['id'], 8, "0", STR_PAD_LEFT);?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo date('d-m-Y', strtotime($row['datetime'])); ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo date('H:i:s', strtotime($row['datetime'])); ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo number_format($row['orders'],0,",","."); ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo number_format($row['products'],2,",","."); ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo number_format($row['quantities'],2,",","."); ?></div>
									  </td>
									
									  
									  <td class="text-center">
										  <div>
											<a href="printRoute.php?deliveryId=<?php echo $row['id']; ?>&businessId=<?php echo $_SESSION['user']['businessId']; ?>&date=<?php echo date('d-m-Y', strtotime($row['datetime'])); ?>" target="_blank"><i class="dropdown-icon fe fe-printer"></i></a>
											<a href="deliveryList.php?tableStatus=view&target=out&businessId=<?php echo $_SESSION['user']['businessId']; ?>&deliveryId=<?php echo $row['id']; ?>&page=1"><i class="dropdown-icon fe fe-eye"></i></a>
											<a onclick="removeDelivery('<?php echo $row['id'];?>')"><i class="dropdown-icon fe fe-x"></i></a>
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
															

function removeDelivery(id){							

if (confirm("Desea eliminar la entrega?")) {

	$.ajax({
			url: 'orderUpdate.php',
			type: 'GET',
			data: {id:id, action:"remove"},
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
}
</script>		