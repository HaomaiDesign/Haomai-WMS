<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>							
							
							
							
							
							  <?php if ($_GET['tableStatus']=='view') { ?>
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='itemList.php?tableStatus=view&page=1' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
									<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit product']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
									</h3>
								<div class="card-options">
									<div class="item-action">
										<?php 
										
										$sqlCount = "SELECT COUNT(id) AS items FROM products WHERE businessId=".$_SESSION['user']['businessId'].";";  
										
										$stmtCount= mysqli_query( $conn, $sqlCount); 
											
										if ( $stmtCount ) {
										$rowCount = mysqli_fetch_array( $stmtCount, MYSQLI_ASSOC );  
										echo $_SESSION['language']['Total']." ".$rowCount['items']." ".$_SESSION['language']['Items']; 
										}
									
										?>&nbsp&nbsp&nbsp
								</div>
								<div class="item-action dropdown">
								  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-horizontal"></i></a>
								  <div class="dropdown-menu dropdown-menu-right">
									<!--<a href="itemList.php?formStatus=create" class="dropdown-item"><i class="dropdown-icon fe fe-plus"></i> <font color="black"> <?php echo $_SESSION['language']['Add product'];?></font></a>-->
									<a href="task.php?tableStatus=view&target=unit" class="dropdown-item"><i class="dropdown-icon fe fe-refresh-cw"></i> <font color="black"> <?php echo $_SESSION['language']['Add operation'];?></font></a>
									<a onclick="ExportToExcel('xlsx')" class="dropdown-item"><i class="dropdown-icon fe fe-log-out"></i> <font color="black"> <?php echo $_SESSION['language']['Export to Excel'];?></font></a>
								  </div>
								</div>
							  </div>
							</div>
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Unit Barcode'];?></th>
									  <th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['SKU'];?></th>
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Units'];?></th>
									  <th style="width:20%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Product Name (Spanish)'];?></th>
									  <!-- <th style="width:20%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Product Name (Chinese)'];?></th> -->
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Unit/Box'];?></th>
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Due Date'];?></th>
									  <!-- <th style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Description'];?></th> -->
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php														
									 
									if (isset($_GET['date'])){
										$fechaElegida = $_GET['date'];										
										list($y,$m,$d) = explode("-",$_GET['date']);
										$_SESSION['dateChange'] = $d . "/" . $m . "/" . $y;

									} else {
										$fechaElegida = date("Y-m-d");
										$_SESSION['dateChange'] = date("d/m/Y");
									}

									if(!isset($_GET['warehouseId']) || $_GET['warehouseId'] == "allWarehouse"){
										$whSQLrequest = "";										
									}
									else if(isset($_GET['warehouseId'])){																		
										$whSQLrequest = " AND stockLogs.warehouseId = ".$id;
									}

									

									
									//$sql = "SELECT products.sku, products.id, products.code, products.brand, products.name, products.packWholesale, products.description, SUM(stockLogs.stock) AS stock FROM products FULL JOIN stockLogs ON products.id=stockLogs.productId WHERE (stockLogs.date <=  '" . $fechaElegida . " 23:59:59' OR (stock IS NULL AND products.creationDate <= '" . $fechaElegida . " 23:59:59'))  AND   products.businessId=" . $_SESSION['user']['businessId'] . " " . $whSQLrequest . "  GROUP BY products.id, products.sku, products.code, products.brand, products.name, products.packWholesale, products.description ORDER BY products.id ASC;"; 
									////$sql = "SELECT products.sku, products.id, products.code, products.brand, products.name, products.packWholesale, products.description, SUM(stockLogs.stock) AS stock FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE (stockLogs.date <=  '" . $fechaElegida . " 23:59:59' OR (stock IS NULL AND products.creationDate <= '" . $fechaElegida . " 23:59:59'))  AND   products.businessId=" . $_SESSION['user']['businessId'] . " " . $whSQLrequest . " ORDER BY products.id ASC;"; 
									
									if ($_GET['search']!="") {
										$searchByNameSQL =  " AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%' ) ";
									} else {
										$searchByNameSQL = " ";
									}
									
									$sql = "SELECT products.unitbarcode, products.dueDate, products.sku, products.id, products.code, 
											products.brand, products.name, products.name2, products.packWholesale, products.description, 
											SUM(stockLogs.stock) AS stock FROM products AS products 
											LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId 
											WHERE (stockLogs.date <=  '" . $fechaElegida . " 23:59:59' OR (stock IS NULL AND products.creationDate <= '" . $fechaElegida . " 23:59:59'))  
											AND   products.businessId=" . $_SESSION['user']['businessId'] . " " . $whSQLrequest . $searchByNameSQL .  "
											GROUP BY products.id ORDER BY products.id ASC;"; 
									
									
									
									
									
									$stmt = mysqli_query( $conn, $sql);
									
									
									
									
									if ( $stmt ) {
									while( ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)))  
									{  
								
									if ($row['stock']!="") {
								
								?>
									
									<tr>
									<td class="text-center">
										<div><?php echo $row['unitbarcode']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['sku']; ?></div>
									  </td>
									  
									 <td class="text-center">
										<div><strong><?php if ($row['stock']!="") echo number_format($row['stock'],0,",","."); else echo number_format(0,0,",","."); ?></strong></div>
									  </td>
									  <td>
										<div>
											<?php 
												if (strlen($row['name'])>100)
													echo substr($row['name'],0,100)."..."; 
												else
													echo $row['name'];
											?>
										</div>
									  </td>
									  <!-- <td>
										<div>
											<?php 
												if (strlen($row['name2'])>30)
													echo substr($row['name2'],0,30)."..."; 
												else
													echo $row['name2'];
											?>
										</div>
									  </td> -->
									   <td class="text-center">
										<div><?php echo number_format($row['packWholesale'],2,",",".") ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['dueDate']; ?></div>
									  </td>
									 
									  
									  
									  <!-- <td>
										<div>
										<?php 
												if (strlen($row['description'])>30)
													echo substr($row['description'],0,30)."..."; 
												else
													echo $row['description'];
										?>
										
									  </td> -->
									  
									  <td class="text-center">
										<div class="item-action dropdown">
										  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
										  <div class="dropdown-menu dropdown-menu-right">
											<!-- <a href="itemList.php?formStatus=view&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> <?php echo $_SESSION['language']['Edit product'];?></a> -->
											<a href="logs.php?tableStatus=view&productId=<?php echo $row['id']; ?>&unitBarcode=<?php echo $row['unitbarcode']; ?>&page=1" class="dropdown-item"><i class="dropdown-icon fe fe-eye"></i> <?php echo $_SESSION['language']['Logs'];?></a>
											<!--<a href="itemListUpdate.php?formStatus=delete&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-x"></i> <?php echo $_SESSION['language']['Delete'];?></a>-->
										  </div>
										</div>
									  </td>
									</tr>
									<?php }; }; }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }; ?>
							
								</div>
							</div>		
							
							
<script>
							function ExportToExcel(type, fn, dl) {
								var elt = document.getElementById('table');
								var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
								return dl ?
								  XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
								  XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
							  }
</script>							