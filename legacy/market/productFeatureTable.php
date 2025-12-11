
							  <?php if ($_GET['tableStatus']=='view') { ?>
								
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
									<?php if ($_GET['formStatus']=='create') echo "<a href='productsList.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
									<?php echo $_SESSION['language']['Features List'];?>
								</h3>
							</div>
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th style="width:25%;font-weight:bold;"> <?php echo $_SESSION['language']['Feature'];?></th>
									  <th style="width:65%;font-weight:bold;"> <?php echo $_SESSION['language']['Value'];?></th>  									  
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									$sql = "SELECT * FROM productFeatures WHERE productId=".$_GET['id']." ORDER BY property ASC;";  
									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  <td>
										<div><?php if ($_SESSION['language'][$row['property']]!="") echo $_SESSION['language'][$row['property']]; else echo $row['property']; ?></div>
									  </td>
									  <td>
										<div><?php if ($_SESSION['language'][$row['value']]!="") echo $_SESSION['language'][$row['value']]; else echo $row['value']; ?></div>
									  </td>
									  
									  <td class="text-center">
										<a href="productFeatureUpdate.php?tableStatus=delete&id=<?php echo $_GET['id']; ?>&featureId=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-trash"></i></a>
									  </td>
									</tr>
									<?php }; ?>
								  </tbody>
								  
								</table>
								<div class="card-footer text-right">
									  <button type="button" onclick="location.href='productsList.php?tableStatus=view'" class="btn btn-primary"> <?php echo $_SESSION['language']['Finish'];?></button>
								</div>
							  </div>
							  
									<?php }}; ?>
							
																