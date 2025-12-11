							
							
							  <?php if ($_GET['tableStatus']=='view') { ?>
							
							<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='warehouse.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Warehouse List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit Warehouse']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create Warehouse']; ?>
								</h3>	
							<div class="card-options">
								<div class="item-action">
									<?php 
									
									$sqlCount = "SELECT COUNT(id) AS items FROM warehouse WHERE businessId=".$_SESSION['user']['businessId'].";";  
									
									$stmtCount= mysqli_query( $conn, $sqlCount); 
										
									if ( $stmtCount ) {
									$rowCount = mysqli_fetch_array( $stmtCount, MYSQLI_ASSOC );  
									echo $_SESSION['language']['Total']." ".$rowCount['items']." ".$_SESSION['language']['items']; 
									}
								
									?>
									&nbsp&nbsp&nbsp
								</div>
								<div class="item-action dropdown">
								  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-horizontal"></i></a>
								  <div class="dropdown-menu dropdown-menu-right">
									<a href="warehouse.php?formStatus=create" class="dropdown-item"><i class="dropdown-icon fe fe-plus"></i> <font color="black"> <?php echo $_SESSION['language']['Create Warehouse'];?></font></a>
									
								  </div>
								</div>
							  </div>
							</div>
							
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th onclick="sortTable(0)"  style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Code'];?></th>
									  <th onclick="sortTable(1)" style="width:20%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Product Name'];?></th>
									  <th onclick="sortTable(2)" style="width:30%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Address'];?></th>
									  <th onclick="sortTable(3)" style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Postal Code'];?></th>
									  <th onclick="sortTable(4)" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Location'];?></th>
									  <th onclick="sortTable(5)" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Province / State'];?> </th>
									  <th onclick="sortTable(6)" style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Description'];?> </th>
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									$sql = "SELECT * FROM warehouse WHERE businessId=".$_SESSION['user']['businessId'].";"; 

									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  <td>
										<div><?php echo $row['code']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['name']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['address']; ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['postalCode']; ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['location']; ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['province']; ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['description']; ?></div>
									  </td>
									  
									  
									  <td class="text-center">
										<div class="item-action dropdown">
										  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
										  <div class="dropdown-menu dropdown-menu-right">
											<a href="warehouse.php?formStatus=view&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> <?php echo $_SESSION['language']['Edit'];?></a>
											<a onclick="askRemove('<?php echo $row['id']; ?>')" class="dropdown-item"><i class="dropdown-icon fe fe-x"></i> <?php echo $_SESSION['language']['Delete'];?></a>
										  </div>
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
function askRemove(id){
	
if (confirm("Desea eliminar el depósito?")) {
location.href = "warehouseUpdate.php?formStatus=delete&id="+id;
}

}
</script>	