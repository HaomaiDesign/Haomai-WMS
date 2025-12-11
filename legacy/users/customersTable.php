
							  <?php if ($_GET['tableStatus']=='view') { ?>
							
							  <div class="table-responsive">
								<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th style="width:5%;font-weight:bold;">#</th>
									  <th style="width:25%;font-weight:bold;"><?php echo $_SESSION['language']['Business Name'];?></th>
									  <th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Address'];?></th>
									  <th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Phone'];?></th>
									  <th style="width:25%;font-weight:bold;"><?php echo $_SESSION['language']['Email'];?></th>									  
									  <th style="width:5%;font-weight:bold;" class="text-center"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									if($_GET['search'] != ""){
										$sql = "SELECT * FROM customers WHERE businessName LIKE '%".$_GET['search']."%' OR address LIKE '%".$_GET['search']."%' OR phone LIKE '%".$_GET['search']."%' ORDER BY id DESC;";
									} else {
										$sql = "SELECT * FROM customers WHERE businessId=".$_SESSION['user']['businessId']." ORDER BY id DESC";  
									}

									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC  ))  
									{  
									
									?>
									
									<tr>
									  <td>
										<div><?php echo $row['id']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['businessName']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['address']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['phone']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['email']; ?></div>
									  </td>
									  <td class="text-center">
										<?php if ($_GET['target']!='') { ?>
										<div class="item-action dropdown">
										  
										  
											<a href="customersUpdate.php?action=addOrder&target=<?php echo $_GET['target'];?>&orderId=<?php echo $_GET['orderId'];?>&customerId=<?php echo $row['id'];?>&roleId=<?php echo $_GET['roleId'];?>" class="dropdown-item"><i class="dropdown-icon fe fe-check-circle"></i></a>
										  
										</div>
										
										
										<?php } else { ?>
										<div class="item-action dropdown">
										  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
										  <div class="dropdown-menu dropdown-menu-right">
											<a href="customers.php?formStatus=view&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> <?php echo $_SESSION['language']['Edit'];?> </a>
											<a href="customersUpdate.php?formStatus=delete&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-user-minus"></i> <?php echo $_SESSION['language']['Delete'];?></a>
										  </div>
										</div>
										<?php }?>
									  </td>
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
									
									
							    	
		