					<?php
					
					
					$sqlTask = "SELECT COUNT(id) as result FROM tasks WHERE userId=".$_SESSION['user']['id']." AND businessId=".$_SESSION['user']['businessId']; 
					$stmtTask = mysqli_query( $conn, $sqlTask);  
					
					if ( $stmtTask ) {
					while( $rowTask = mysqli_fetch_array( $stmtTask, MYSQLI_ASSOC ))  
					{  
		
						$taskResult = $rowTask['result'];
					
					}
					}
					
					
					?>				
					
					<div class="col-12">
						<?php if ($_GET['tableStatus']=='view') { ?>
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
							
							<a href='task.php?tableStatus=view&target=unit' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp
						
								<div class="card-options">
									<button type="button" id="clean" onclick="clean(<?php echo "'".$_SESSION['user']['id']."', '".$_SESSION['user']['businessId']."'"; ?>)" class="btn btn-danger btn-sm"<?php if ($taskResult==0) echo " disabled"; ?>><i class="fe fe-x mr-2"></i> <?php echo $_SESSION['language']['Empty order'];?></button> &nbsp &nbsp &nbsp 
									<button type="button" id="send" onclick="send(<?php echo "'".$_SESSION['user']['id']."', '".$_SESSION['user']['businessId']."'"; ?>)" class="btn btn-success btn-sm"<?php if ($taskResult==0) echo " disabled"; ?>><i class="fe fe-check mr-2"></i> <?php echo $_SESSION['language']['Send order'];?></button> 
								</div>
							</div>
							
							
						</div>
						<?php }; ?>
						
						<?php if ($_GET['tableStatus']=='view') { ?>
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-body">
								
								
										<?php 
										   $today = date("Y-m-d");
										?>
										
									<div class="row">
									
										<div class="col-sm-3 col-md-3">
											<div class="input-group">
											<span class="input-group-prepend" id="basic-addon1">
												<span class="input-group-text"><?php echo $_SESSION['language']['Date'];?> </span>
											  </span>
											  <input id="date" name="date" type="date" value="<?php echo $today; ?>" class="form-control">
											</div>
										</div>
										
										<div class="col-sm-6 col-md-6">
											<div class="input-group">
											  <span class="input-group-prepend" id="basic-addon1">
												<span class="input-group-text"><?php echo $_SESSION['language']['Warehouse'];?> </span>
											  </span>
											  <select id="warehouseId" name="warehouseId" class="form-control">
												<?php 

														$sqlWarehouse = "SELECT * FROM warehouse WHERE businessId=".$_SESSION['user']['businessId'].";";  
														$stmtWarehouse = mysqli_query( $conn, $sqlWarehouse); 
																							

															if ( $stmtWarehouse ) {
																while( $rowWarehouse = mysqli_fetch_array( $stmtWarehouse, MYSQLI_ASSOC))  
																{  
											
																		echo "<option value='".$rowWarehouse['id']."'>".$rowWarehouse['code']." - ".$rowWarehouse['name']." - ".$rowWarehouse['address']."</option>"; 
											
																}  
															}
													 ?>
											  </select>
											  
											</div>
										</div>
										
										<div class="col-sm-3 col-md-3">	
											<div class="input-group">
											  <span class="input-group-prepend" id="basic-addon1">
												<span class="input-group-text">Tipo </span>
											  </span>
											  <select id="task" name="task" class="form-control">
												<option value="2" selected> <?php echo $_SESSION['language']['Check'];?> </option>
												<!--<option value="1"> <?php echo $_SESSION['language']['Delivered'];?> </option>
												<option value="2"> <?php echo $_SESSION['language']['Received'];?> </option>-->
												
											  </select>
											  
											</div>
										</div>
										
									  </div>
									  
							</div>
						</div>
						<?php }; ?>
						
						
					<!-----------LISTADO DE PRODUCTOS----------------------------->
						
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='productsList.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit product']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
								</h3>
						

							</div>


							  <?php if ($_GET['tableStatus']=='view') { ?>
							
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								   <thead>
									<tr>
									  <th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['SKU'];?></th>
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Code'];?></th>
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Units'];?> </th>
									  <th style="width:40%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Product Name'];?></th>
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Unit/Box'];?></th>
									  <th style="width:20%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Description'];?></th>
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
								
									
									<?php
									
									$sql = "SELECT tasks.id, tasks.productId, tasks.stock, tasks.description, tasks.userId, tasks.businessId, products.sku, products.name, products.unitBarcode, products.packWholesale FROM tasks INNER JOIN products ON tasks.productId=products.id WHERE tasks.userId=".$_SESSION['user']['id']." AND tasks.businessId=".$_SESSION['user']['businessId']; 
									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  <td>
										<div><?php echo $row['sku']; ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['unitBarcode']; ?></div>
									  </td>
									  
									  <td class="text-center">
									    <strong><?php echo  "<input id='stock".$row['id']."' type='number' onchange='updateTask(\"".$row['id']."\")' class='form-control' style='border: none; text-align: center;' value=".$row['stock']." step=1>";?></strong>
									  </td>
									  <td>
										<div><?php echo $row['name']; ?></a></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['packWholesale']; ?></div>
									  </td>
									  
									  <td class="text-center">
										<?php echo  "<input id='description".$row['id']."' type='text' onchange='updateTask(\"".$row['id']."\")' class='form-control' style='border: none; text-align: left;' value='".$row['description']."'>";?>
									  </td>
									  
									  <td class="text-center">
										<a onclick="removeTask(<?php echo "'".$row['id']."','".$row['name']."'"; ?>)" class="icon"><i class="fe fe-x"></i></a>
									  </td>
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
							
							
						</div>
						
						<!-----------FIN DE LISTADO DE PRODUCTOS----------------------------->
						
			
						
		
						
  </div>	
  
<script>	
function removeTask(taskId, itemName){							

    $.ajax({
        url: '../webservice/stock.php',
        type: 'GET',
        data: {taskId:taskId, action:"removeTask"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			toastr.success("Removed: "+taskId+itemName);
			console.log(data); // Inspect this in your console
			location.reload();
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error(itemName);
		console.log(data); // Inspect this in your console
    }  
    });

}

function updateTask(taskId){							

var stockId = "stock"+taskId;
var descriptionId = "description"+taskId;

var stock = document.getElementById(stockId).value;
var description  = document.getElementById(descriptionId).value;

    $.ajax({
        url: '../webservice/stock.php',
        type: 'GET',
        data: {taskId:taskId, description:description, stock:stock, action:"updateTask"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			toastr.success("Product Updated: "+taskId);
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error(taskId);
		console.log(data); // Inspect this in your console
    }  
    });

}

function clean(userId, businessId){							

    $.ajax({
        url: '../webservice/stock.php',
        type: 'GET',
        data: {userId:userId, businessId:businessId, action:"clean"},
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

function send(userId, businessId){							

var date  = document.getElementById('date').value;
var warehouseId  = document.getElementById('warehouseId').value;
var task  = document.getElementById('task').value;

    $.ajax({
        url: '../webservice/stock.php',
        type: 'GET',
        data: {userId:userId, businessId:businessId, date:date, warehouseId:warehouseId, task:task, action:"send"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			console.log(data); // Inspect this in your console
			//location.reload();
			location.href = "logs.php?tableStatus=view&page=1";
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error(userId);
		console.log(data); // Inspect this in your console
    }  
    });

}
</script>																	