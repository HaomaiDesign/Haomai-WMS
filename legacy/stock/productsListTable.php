<script>
function updateFilterCat(limpiarFiltro = "", id = ""){
	var checkboxes = document.getElementsByName('category_checkbox');
	var allCategory = document.getElementById('AllCategories');
	var checkedValue = "";

	if (limpiarFiltro == "LimpiarFiltro") {
		checkboxes = clearFilter(checkboxes);
	}
	if (allCategory.checked == false) {
		for (var i=0; i<checkboxes.length; i++){
			if (checkboxes[i].checked){
				checkedValue += checkboxes[i].value + ",";
			}
		}
		checkedValue = checkedValue.slice(0, -1);
		document.getElementById('AllCategories').checked = false;
	} else {
		checkboxes = clearFilter(checkboxes);
		checkedValue = "ALL";
		document.getElementById('AllCategories').checked = true;
	}

	var warehouseId = "";
	if (id && id != "AllWarehouse") {
		warehouseId = "warehouseId="+ id +"&";
	}

	window.location.replace("productsList.php?"+warehouseId+"reportCat="+checkedValue+"<?php if($_GET['checkboxBarcode'] != '') echo '&checkboxBarcode='.$_GET['checkboxBarcode'];?>&tableStatus=view&page=1");
}

function clearFilter(checkboxes){
	for (var i=0; i<checkboxes.length; i++){
		checkboxes[i].checked = false;
	}
	return [];
}

function updateGroupByBarcode(){							
	var checkboxChecked = document.getElementById("checkboxGroupbyBarcode").checked;
	
	$('#loading').modal({
    backdrop: 'static',
    keyboard: false
	});

	
	if(checkboxChecked){
		window.location.replace("productsList.php?checkboxBarcode=true<?php if($_GET['search'] != '') echo '&search='.$_GET['search']; if($_GET['reportCat'] != '') echo '&reportCat='.$_GET['reportCat'];?>&tableStatus=view&page=1");
	} else {
		window.location.replace("productsList.php?tableStatus=view<?php if($_GET['search'] != '') echo '&search='.$_GET['search']; if($_GET['reportCat'] != '') echo '&reportCat='.$_GET['reportCat'];?>&page=1");
	}
}

</script>

	<?php


					if (isset($_GET['warehouseId']) && $_GET['warehouseId'] != "AllWarehouse") {
						list($id, $name) = explode("_", $_GET['warehouseId']);
						$_SESSION['whData']['id'] = $id;
						$warehouseRequest = "stockLogs.warehouseId=" . $id;
					} else {
						$warehouseRequest = "";
						$_SESSION['whData']['id'] = "";
					}

					$target = "products.flagActive = 1 AND products.businessId=".$_SESSION['user']['businessId'];
					$warehouseUrl = "";
					if($_GET['checkboxBarcode'] != '') {
						$checkboxGroupByBarcodeUrl = '&checkboxBarcode='.$_GET['checkboxBarcode'];
					}
					if($_GET["warehouseId"] != ""){
						$warehouseUrl = "warehouseId=".$_GET['warehouseId']."&";
					}
					if($_GET["search"] != ""){
						$target.= " AND products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%'";
						$pageUrl = "productsList.php?".$warehouseUrl."reportCat=".$_GET["reportCat"]."&search=".$_GET["search"]."$checkboxGroupByBarcodeUrl&tableStatus=view&page=";
					} else {
						$pageUrl = "productsList.php?".$warehouseUrl."reportCat=".$_GET["reportCat"]."$checkboxGroupByBarcodeUrl&tableStatus=view&page=";
					}
				
					
					$sql0 = "SELECT COUNT(products.id) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId WHERE ".$target.";";   // condicion a mejorar, no funciona bien cuando hay get search con los campos a buscar
					// echo "sql0: ".$sql0;
					$stmt0= mysqli_query( $conn, $sql0); 
						
					if ( $stmt0 ) {
						$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );  
						$totalItem = $row0['rowNum'];
						$limit = 50;
					
						$totalPage = ceil($totalItem/$limit);
						$start = ($_GET['page'] - 1) * $limit;
						
					}

					$isMobile = preg_match("/(android|webos|avantgo|iphone|ipad|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
					?>
					
					<div id="loading"></div>
					
					<?php if ($_GET['tableStatus']=='view') { ?>
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<div class="col-2">
									<div class="input-group" style="width: 200px">
										<select class="form-control" id="sel_wh" name="warehouseId" onchange="updateWarehouse()"
											style="width: auto">
											<option value="AllWarehouse">
												<?php
													echo $_SESSION['language']['All Warehouses']; 
												?>
											</option>
											<?php
												$sql = "SELECT id AS wid, name FROM warehouse WHERE businessId = " . $_SESSION['user']['businessId'];
												$stmt_warehouse = mysqli_query($conn, $sql);
												if ($stmt_warehouse) {
													while ($row = mysqli_fetch_array($stmt_warehouse, MYSQLI_ASSOC)) {
														?>
														<option value=<?php echo $row["wid"];
														if (isset($_GET['warehouseId']) && $_GET['warehouseId'] == $row["wid"])
															echo " selected" ?>><?php echo $row['wid']. " - " .$row["name"]; ?>
														</option>
														<?php
													}
												}
												mysqli_free_result($stmt_warehouse);
											?>
										</select>
									</div>
								</div>
								<div class="col-4 d-flex justify-content-center">
									<?php
										$editTableButton = "";
										if ($_GET["checkboxBarcode"] == "true") {
											$editTableButton = "disabled";
										}

										if (!isset($_GET["editTable"]) || $_GET["editTable"] == "") {
									?>

									<button type="button" class="btn btn-secondary" style="color:white" 
										onclick="updateEditTable(true)" id="editTableButton" <?= $editTableButton ?>>
										<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Select products to stop entry']; ?>
									</button>

									<?php
										} else {
										// Guardar cambios y cambiar el get de la url y volver a la vista de la tabla
									?>
									
									<button type="button" class="btn btn-secondary" style="color:white" 
										onclick="updateEditTable(false)" id="saveChangesButton">
										<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Save changes']; ?>
									</button>

									<?php
										}
									?>
								</div>
								<div class="col-6">
									<form action="productsList.php" method="get" autocomplete="off" >
										<div class="row" style="justify-content:space-around;">
											<?php if ($_SESSION['user']['roleId'] != 2) {?>
												<div style="width: auto; align-self:center;">
														<input class="form-check-input" type="checkbox" onchange="updateGroupByBarcode()" 
														<?php 
															if($_GET["checkboxBarcode"] == "true") echo "checked";
															if($_GET["editTable"] == "true") echo "disabled";
														?> id="checkboxGroupbyBarcode">
														<label class="form-check-label" for="checkboxGroupbyBarcode">
															<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Grouped batch']; ?>
														</label>
												</div>
											<?php }?>
											<div style="width: auto;">
												<button type="button" class="btn btn-secondary" style="color:white" data-toggle="modal" data-target="#exampleModal">
													<?php echo $_SESSION['language']['Category']; ?>
												</button>
											</div>
											<div style="width: auto;">
												<div class="input-icon mb-1">
													<input id="search" name="search" type="search" class="form-control header-search" value="<?php if ($_GET['search']!="") echo $_GET['search']; ?>" placeholder="<?php echo $_SESSION['language']['search'];?>">
													<input id="tableStatus" name="tableStatus" type="hidden" value="view">
													<input id="page" name="page" type="hidden" value="<?= $_GET["page"];?>">
													<span class="input-icon-addon">
														<i class="fe fe-search"></i>
													</span>
												</div>
											</div>
											

											<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="modalTitle"><?php echo $_SESSION['language']['Category']; ?></h5>
														<button type="button " class="close" data-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
														<div class="container-fluid">
															<div class="row mb-3">
																<div class="col-12">
																	<div class="form-check">
																		<input class="form-check-input" style="margin-right:10px;" type="checkbox" id="AllCategories" name="allcategory_checkbox" value="ALL">
																		<label class="form-check-label" for="AllCategories">
																			<?php echo $_SESSION['language']['All']; ?>
																		</label>
																	</div>
																	<?php if ($_GET['reportCat'] == "ALL") {
																		echo "<script>document.getElementById('AllCategories').checked = true;</script>";
																	} ?>
																</div>
															</div>

															<?php
																$warehouseCategoryFilter = "";
																if ($warehouseRequest != "") {
																	$warehouseCategoryFilter = " WHERE ". $warehouseRequest;
																}

																$sqlreportCat = "SELECT DISTINCT p.category AS category, w.name AS warehouseName, w.id AS warehouseId FROM products p INNER JOIN stocklogs ON p.id = stocklogs.`productId` INNER JOIN warehouse w ON stocklogs.`warehouseId` = w.id ". $warehouseCategoryFilter ." ORDER BY w.name ASC, category ASC;";  
																$stmtreportCat = mysqli_query($conn, $sqlreportCat); 

																if ($stmtreportCat) {
																	$warehouse = "";
																	$categoryCount = 0;
																	
																	while ($rowreportCat = mysqli_fetch_array($stmtreportCat, MYSQLI_ASSOC)) {
																		if ($rowreportCat['warehouseName'] != $warehouse) {
																			$warehouse = $rowreportCat['warehouseName'];
																			
																			if ($categoryCount > 0) {
																				echo "</div>"; // Cerrar la fila anterior
																			}
																			
																			echo '<div class="row warehouse-section mt-3 mb-2">';
																			echo '<div class="col-12">';
																			echo '<h5 class="warehouse-title border-bottom pb-2">' . $warehouse . '</h5>';
																			echo '</div>';
																			echo '</div>';
																			
																			echo '<div class="row">';
																			$categoryCount = 0;
																		}

																		echo '<div class="col-md-4 mb-2">';
																		echo '<div class="form-check">';
																		echo '<input class="form-check-input" type="checkbox" id="' . $rowreportCat['warehouseId'] . '-' . $rowreportCat['category'] . '" name="category_checkbox" value="' . $rowreportCat['warehouseId'] . '-' . $rowreportCat['category'] . '">';
																		echo '<label class="form-check-label" for="' . $rowreportCat['warehouseId'] . '-' . $rowreportCat['category'] . '">' . $rowreportCat['category'] . '</label>';
																		echo '</div>';
																		echo '</div>';

																		// Se seleccionan las categorías que ya estaban seleccionadas
																		if (isset($_GET['reportCat']) && $_GET['reportCat'] != '') {
																			$selectedCategories = explode(",", $_GET['reportCat']);
																			if (in_array($rowreportCat['warehouseId'] . "-" . $rowreportCat['category'], $selectedCategories)) {
																				echo "<script>document.getElementById('" . $rowreportCat['warehouseId'] . "-" . $rowreportCat['category'] . "').checked = true;</script>";
																			}
																		}

																		$categoryCount++;
																		
																		// Al final de las iteraciones, cerrar la última fila
																		if ($categoryCount % 3 == 0) {
																			echo '</div><div class="row">';
																		}
																	}
																	
																	// Cerrar la última fila si hay elementos
																	if ($categoryCount > 0) {
																		echo '</div>';
																	}
																}
															?>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" style="color:white" onclick="updateFilterCat('LimpiarFiltro', <?php if (isset($_GET['warehouseId'])) echo "'" . $_GET['warehouseId'] . "'";?>)">
															<?php if(isset($_SESSION['language']['Clear Filter'])) echo $_SESSION['language']['Clear Filter']; else echo '清除筛选'; ?>
														</button>
														<button type="button" class="btn btn-primary" style="color:white" onclick="updateFilterCat('', <?php if (isset($_GET['warehouseId'])) echo "'" . $_GET['warehouseId'] . "'";?>)">
															<?php if (isset($_SESSION['language']['Filter'])) echo $_SESSION['language']['Filter']; else echo '筛选'; ?>
														</button>
													</div>
													</div>
												</div>
											</div>


											<!-- <div style="width: 200px; margin-right: 20px;">
												
													<select id="reportCat" name="reportCat" onchange="updateFilterCat(this.value)" class="form-control"  >
													
													<option value='ALL' <?php if ($_GET["reportCat"] == "ALL") echo "selected" ?>  ><?=$_SESSION["language"]["All"];?></option>
													
													<?php 
															$sqlreportCat = "SELECT DISTINCT p.category AS category, w.name AS warehouseName FROM products p INNER JOIN stocklogs sl ON p.id = sl.`productId` INNER JOIN warehouse w ON sl.`warehouseId` = w.id order by w.name;";  
															$stmtreportCat = mysqli_query( $conn, $sqlreportCat); 
															
																if ( $stmtreportCat ) {
																	while( $rowreportCat = mysqli_fetch_array( $stmtreportCat, MYSQLI_ASSOC))  
																	{  
																		if ($rowreportCat['category']=="")
																			// if ($_GET['reportCat']=="EMPTY")	
																			// 	echo "<option value='EMPTY' selected>(".$_SESSION["language"]["Without category"].")</option>"; 
																			// else
																			echo "<option value='EMPTY'>(".$_SESSION["language"]["Without category"].")</option>"; 
																		else
																			// if ($_GET['reportCat']==$rowreportCat['category'])	
																			// 	echo "<option value='".$rowreportCat['category']. "' selected>".$rowreportCat['category']."</option>"; 
																			// else
																			echo "<option value='".$rowreportCat['category']."'>".$rowreportCat['category']." </option>"; 
																				
																				
																	}  
																	
																	
																}
														?>													
													</select>
											</div> -->
										</div>
									</form>
								</div>
							</div>
						</div>
					
				
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								
									<h3 class="card-title" style="font-weight:bold;">
										<?php if (isset($_GET['search'])) echo "<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?> 
										<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; ?>
									</h3>

									<?php if ($_SESSION['user']['roleId'] != 2) {?>
										<div class="item-action">	
											<a style="margin-left:15px;" target="_blank" href="printCatSaleOrder.php<?php if($_GET["search"] != "" || $_GET["reportCat"] != ""|| $_GET["checkboxBarcode"] != "") echo "?"; if($_GET["search"] != "") echo "search=".$_GET["search"]; if($_GET["reportCat"] != "") echo "&reportCat=".$_GET["reportCat"];  if($_GET["checkboxBarcode"] != "") echo "&checkboxBarcode=".$_GET["checkboxBarcode"];?>"><i class="dropdown-icon fe fe-printer"></i></a>
											<a style="margin-left:15px;" target="_blank" href="exportExcelProducts.php<?php if($_GET["search"] != "" || $_GET["reportCat"] != ""|| $_GET["checkboxBarcode"] != "") echo "?"; if($_GET["search"] != "") echo "search=".$_GET["search"]; if($_GET["reportCat"] != "") echo "&reportCat=".$_GET["reportCat"];  if($_GET["checkboxBarcode"] != "") echo "&checkboxBarcode=".$_GET["checkboxBarcode"];?>"><i class="dropdown-icon fe fe-log-out"></i></a>
										</div>
									<?php }?>

									<div class="card-options">
										<div class="item-action">         
											<?php 
											
												$sqlCount = "SELECT COUNT(*) AS items FROM products WHERE businessId=".$_SESSION['user']['companyId']." AND flagActive=1;";  
												$stmtCount= mysqli_query( $conn, $sqlCount); 
													
												if ( $stmtCount ) {
												$rowCount = mysqli_fetch_array( $stmtCount, MYSQLI_ASSOC );  
												echo $_SESSION['language']['Total']." ".$rowCount['items']." ".$_SESSION['language']['products']; 
												}
											
											?> &nbsp&nbsp&nbsp
										</div>
									
										<?php
												$groupbyClause = "";

												if ($warehouseRequest != "") {
													$warehouseRequest = " AND ". $warehouseRequest;
												}
												
												if ($_GET["checkboxBarcode"] == "true"){
													$groupbyClause = " products.unitbarcode ";
												} else {
													$groupbyClause =" products.id ";
												}
													
													if ($_GET['search']!="")  {
														$sql = "SELECT stockLogs.productId, stockLogs.warehouseId,products.unitbarcode, products.image, products.dueDate, 
														products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, 
														products.name, products.name2, products.packWholesale, products.description, products.flagDiscontinued, 
														sum(stockLogs.stock) AS stock 
														FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
															WHERE products.flagActive = 1";
															
														$sql2 = "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
															WHERE products.flagActive = 1";
															

														if($_GET['search']!=""){
															$sql.= $warehouseRequest . " AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )";
															
															$sql2.= $warehouseRequest . " AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )";
														}
														
														$sql .=	" GROUP BY ".$groupbyClause."
																ORDER BY stockLogs.warehouseId ASC, products.category ASC, products.name ASC LIMIT ".$start.",".$limit.";"; 
																
														$sql2 .=	" GROUP BY ".$groupbyClause.";"; 
																
																//echo "sql SEARCH: ". $sql;
																
													} else {
													
													if (($_GET['reportCat'] != "")AND($_GET['reportCat'] != "ALL")AND($_GET['reportCat'] != "EMPTY")) {
														
														$catList = explode(',', $_GET['reportCat']);
														$catDic = array();
														$lastWarehouseId = "";

														for ($i=0; $i < count($catList); $i++) {
															$catValue = explode('-', $catList[$i]);
															
															if (array_key_exists($catValue[0], $catDic)) {
																$catDic[$catValue[0]] .= ",'" . $catValue[1] . "'";
															} else {
																if($lastWarehouseId != "") {
																	$catDic[$lastWarehouseId] .= ")";
																}
																$catDic[$catValue[0]] = "('" . $catValue[1] . "'";
															}

															$lastWarehouseId = $catValue[0];
														}

														$catDic[$lastWarehouseId] .= ")";

														$catDicKeys = array_keys($catDic);
														
														$sql = "(";
														$sql2 = "(";

														for ($i=0; $i < count($catDicKeys); $i++) {

															$warehouseRequest = " AND stockLogs.warehouseId=" . $catDicKeys[$i];

															$sql .= "SELECT stockLogs.productId, stockLogs.warehouseId, products.unitbarcode, products.image, products.dueDate, 
															products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, 
															products.name, products.name2, products.packWholesale, products.description, products.flagDiscontinued, 
															sum(stockLogs.stock) AS stock 
															FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
															WHERE products.flagActive = 1";
															
															$sql2 .= "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
															WHERE products.flagActive = 1";

															$sql .= $warehouseRequest ." AND products.category IN ". $catDic[$catDicKeys[$i]];
																													
															$sql2 .= $warehouseRequest ." AND products.category IN " .$catDic[$catDicKeys[$i]];

															$sql .=	" GROUP BY ".$groupbyClause."
																ORDER BY stockLogs.warehouseId ASC, products.category ASC, products.name ASC LIMIT ".$start.",".$limit.")"; 
																
															$sql2 .= " GROUP BY ".$groupbyClause.")";
														
															if ($i < count($catDicKeys)-1) {
																$sql .= " UNION (";
																$sql2 .= " UNION (";
															}

														}
													}
													
													if ($_GET['reportCat'] == "EMPTY" ){
														
														$sql = "SELECT stockLogs.productId, stockLogs.warehouseId,products.unitbarcode, products.dueDate, products.image, 
														products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, 
														products.name, products.name2, products.packWholesale, products.description, products.flagDiscontinued, 
														sum(stockLogs.stock) AS stock 
														FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1";
														
														$sql2 = "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1";

														$sql.= $warehouseRequest . " AND products.category = ''";
														
														$sql2.= $warehouseRequest . " AND products.category = ''";
														
														$sql .=	" GROUP BY ".$groupbyClause."
															ORDER BY stockLogs.warehouseId ASC, product.category ASC, products.name ASC LIMIT ".$start.",".$limit.";"; 
															
														$sql2 .= " GROUP BY ".$groupbyClause.";"; 
														
														
														
													}
													
													if ($_GET['reportCat'] == "ALL" ){
														
													$sql = "
														SELECT stockLogs.productId, stockLogs.warehouseId, products.unitbarcode, products.image, products.dueDate, 
														products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, 
														products.name, products.name2, products.packWholesale, products.description, products.flagDiscontinued, 
														sum(stockLogs.stock) AS stock 
														FROM products   LEFT JOIN stockLogs  ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1 ". $warehouseRequest ."
														GROUP BY ".$groupbyClause."
														ORDER BY stockLogs.warehouseId ASC, products.category ASC, products.name ASC
														LIMIT ".$start.",".$limit.";";
														
													$sql2 = "
														SELECT COUNT(*) AS rowNum
														FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1 ". $warehouseRequest ."
														GROUP BY ".$groupbyClause.";";	
														
														// echo "sql ALL: ". $sql;
													}
												}
					
												$stmt = mysqli_query( $conn, $sql);
												$stmt2 = mysqli_query( $conn, $sql2); 	
												
												
												$totalItem = mysqli_num_rows($stmt2);
												$limit = 50;
											
												$totalPage = ceil($totalItem/$limit);
												$start = ($_GET['page'] - 1) * $limit;
												
													
												
										?>   
									
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
								<table id="table" class="table table-sm table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>

									
									<tr>
										<th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></th>
										<?php if ($_SESSION['user']['roleId'] == 2) {?>
											<th class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></th>
											<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></th>
										<?php } ?>

										<th style="width:30%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>

										<th class="text-center" style="width:10%; font-weight:bold;"><?php echo $_SESSION['language']['Category'];?></th>

										<?php if ($_SESSION['user']['roleId'] != 2) {?>
											<?php if (!isset($_GET["checkboxBarcode"]) && !isset($_GET["editTable"])){ ?>
												<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></th>
											<?php } ?>
											<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Unit/Pack'];?></th>
											<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Capacity']."/".$_SESSION['language']['Unit'];?></th>	
											<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Unit Barcode'];?></th>
											<th class="text-center"style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['SKU'];?></th>
											<?php if (!isset($_GET["checkboxBarcode"]) && !isset($_GET["editTable"])){ ?>
												<th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
											<?php } ?>
										<?php }?>
									</tr>
									
								  </thead>
								  <tbody>
									
									
									<?php
									$clickeable = "";
									$rowStyle = "";
									$selectAction = "";

									if ( $stmt ) {                                                        
										while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC )){                      
											$barcode = $row['unitbarcode'];
											$prodId = $row['id'];
											$flagDiscontinued = $row['flagDiscontinued'];
											if (isset($_GET["editTable"]) && $_GET["editTable"] == "true") {
												$clickeable = "class='clickable-row' ";
												$rowSelected = "";
												if ($flagDiscontinued == 1) {
													$rowSelected = "background-color: #ffebf0;";
												}
												$rowStyle = "style='cursor: pointer; $rowSelected'";
												$selectAction = "onclick='updateSelectProduct($barcode,$prodId)'";
											}
											
									?>
												<tr <?= $clickeable ?> <?= $rowStyle ?> <?= $selectAction ?> id="tableRow<?= $row['id'];?>">																
													<td class="text-center">                                                                                      
														<div><strong style="font-size:30pt" ><?php if ($row['stock']!="") echo intval($row['stock']); else echo "0";?></strong></div>                             
													</td>
													<?php if ($_SESSION['user']['roleId'] == 2) {?>
														<td class="text-center">
															<div><img src="<?= $row['image'];?>" class="d-inline-block align-top mr-3" alt=""></div>
														</td>
														<td class="text-center">
															<div>
															<?php if ($_GET["checkboxBarcode"] != "true"){ ?>
															
																<div style="font-weight:bold"><?= $row['dueDate']; ?></div>
															
															<?php } ?>
															</div>
														</td>
													<?php }?>
													<td style="white-space: normal; word-wrap: break-word;">
														<!-- <div><a onclick="window.location.href='itemList.php?tableStatus=view&search=<?php echo $row['unitBarcode']; ?>&page=1'" style="cursor: pointer;"><?php if (strlen($row['name'])>50) echo substr($row['name'],0,50)."..."; else echo $row['name']; ?></a></div> -->
														<?php if ($_SESSION['user']['roleId'] != 2) {?>
															<!-- <div><?php if (strlen($row['name'])>50) echo substr($row['name'],0,50)."..."; else echo $row['name']; ?></div> -->
															<div><?php echo $row['name']; ?></div>
														<?php } else {?>
															<div style="font-weight:bold"><?php echo $row['name']; ?></div>
														<?php }?>
													</td>
												
													<td class="text-center">                                                                                                          
														<div><?php echo $row['warehouseId'] ." - ". $row['category']; ?></div>                                                                  
													</td>
													<?php if ($_SESSION['user']['roleId'] != 2) {?>
														<?php 
															if (!isset($_GET["checkboxBarcode"]) && !isset($_GET["editTable"])){
														?>
														<td class="text-center">
															<div>

																<?php
																	$today = date('Y-m-d');
																	$days = round((strtotime($row['dueDate']) - strtotime($today))/86400);
																	
																?>
																	<div <?php if ($days <= 60 && $days > 0) echo "style='color: blue;'"; if($days <= 0) echo "style='color: red;'"; ?> ><?php echo $row['dueDate']; ?></div>
																</div>
															</td>
														<?php } ?>
														<td class="text-center">
															<div><?php echo $row['packWholesale']; ?></div>
														</td>
														<td class="text-center">
															<div><?php echo $row['capacity']." ".$row['unit']; ?></div>
														</td>

														<td class="text-center">                                                                                      
															<div><?php echo $row['unitbarcode']; ?></div>                                                               
														</td> 
														<td class="text-center">
															<div><?php echo $row['sku']; ?></div>                                                                       
														</td>

														<?php if (!isset($_GET["checkboxBarcode"]) && !isset($_GET["editTable"])){ ?>

														<td class="text-center">
															<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																
																<a href="itemList.php?formStatus=view&&currentPage=<?=$_GET['page'];?>&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> <?php echo $_SESSION['language']['Edit product'];?></a>
																
																<!--<a href="itemList.php?tableStatus=view&search=<?php echo $row['unitBarcode']; ?>&page=1" class="dropdown-item"><i class="dropdown-icon fe fe-eye"></i> <?php echo $_SESSION['language']['Logs'];?></a>-->
																<!--<a href="productsListUpdate.php?formStatus=delete&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-x"></i> <?php echo $_SESSION['language']['Delete'];?></a>-->
																<?php if ((!isset($_GET["checkboxBarcode"]))AND($row['stock']==0)){?>
																	<a href="javascript:void(0)" onclick="remove('<?php echo $row['id']; ?>')" class="dropdown-item"><i class="dropdown-icon fe fe-x"></i> <?php echo $_SESSION['language']['Delete'];?></a>
																<?php } ?>
															</div>
															</div>
														</td>

														<?php } ?>
													<?php }?>
												</tr>

											<?php }; ?>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									
							
							
							
								</div>
							</div>
							<?php }; ?>
							
<script>	
function market(productId){							

var check = document.getElementById(productId).checked;

if (check==false) {
  var market = 0;
} else {
  var market = 1;
}

    $.ajax({
        url: '../webservice/products.php',
        type: 'GET',
        data: {productId:productId, market:market, action:"market"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede agregar el producto");
		console.log(data); // Inspect this in your console
    }  
    });

}

const selectedRows = [];

function updateSelectProduct(unitBarcode, productId){

	var productRow = document.getElementById("tableRow"+productId);

	// verify if the product is already selected

	if (selectedRows.includes(unitBarcode) || productRow.style.backgroundColor == "#ffebf0") {
		selectedRows.splice(selectedRows.indexOf(unitBarcode), 1);
		productRow.style.backgroundColor = "";
	} else {
		productRow.style.backgroundColor = "#ffebf0";
		selectedRows.push(unitBarcode);
	}

	console.log(selectedRows);

}

function updateEditTable(ableToEdit){
	
	$('#loading').modal({
	backdrop: 'static',
	keyboard: false
	});

	if(ableToEdit){
		window.location.replace("productsList.php?editTable=true<?php if($_GET['search'] != '') echo '&search='.$_GET['search']; if($_GET['reportCat'] != '') echo '&reportCat='.$_GET['reportCat'];?>&tableStatus=view&page=1");
	} else {
		$.ajax({
			url: '../webservice/products.php',
			type: 'GET',
			data: {selectedRows: selectedRows, action:"discontinuedProducts"},
			success: function(data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.success("Productos actualizados");
				console.log(data); // Inspect this in your console
			},
			error: function(data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se puede agregar el producto");
			}
		});
		
		window.location.replace("productsList.php?tableStatus=view<?php if($_GET['search'] != '') echo '&search='.$_GET['search']; if($_GET['reportCat'] != '') echo '&reportCat='.$_GET['reportCat'];?>&page=1");
	}
}

function remove(productId){							

//var check = document.getElementById(productId).checked;

var response = confirm("<?php echo $_SESSION['language']['Remove']; ?> <?php echo $_SESSION['language']['Product']; ?>");
if (response == true) {

	$.ajax({
        url: '../webservice/products.php',
        type: 'GET',
        data: {productId:productId, action:"remove"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			document.getElementById("tableRow"+productId).style.display = "none";
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede agregar el producto");
		console.log(data); // Inspect this in your console
    }  
    });

} 

}

function updateWarehouse(){
	let warehouseId = document.getElementById("sel_wh").value;
	if (warehouseId == "AllWarehouse") {
		warehouseId = "ALL";
		console.log('Entre al if');
	} else {
		warehouseId = "warehouseId="+warehouseId+"&";
	}
	// console.log('window href',window.location.href)
	window.location.replace("productsList.php?"+warehouseId+"reportCat=ALL&tableStatus=view&page=1");
	// window.location.replace(window.location.href + "&warehouseId="+warehouseId);
}

function ableUpdate(id,variable){							

	document.getElementById(variable+'Display'+id).style.display = 'none';
	document.getElementById(variable+'Input'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).focus();
	
}

function update(table, id, variable, type){							

var value = document.getElementById(variable+"Input"+id).value;

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

// type 1 =  string // type 2 = number

    $.ajax({
        url: '../webservice/update.php',
        type: 'GET',
        data: {table:table, id:id, variable:variable, value:value, type:type, action:"update"},
        success: function(data) {
			
			//location.reload();
			toastr.options.positionClass = "toast-top-left";
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede agregar el producto");
		console.log(data); // Inspect this in your console
    }  
    });


/*
$('#loading').modal({
    backdrop: 'static',
    keyboard: false
})
*/

}



function updateGroupByBarcode(){							
	var checkboxChecked = document.getElementById("checkboxGroupbyBarcode").checked;
	if(checkboxChecked){
		window.location.replace("productsList.php?checkboxBarcode=true<?php if($_GET["search"] != "") echo "&search=".$_GET["search"]; if($_GET["reportCat"] != "") echo "&reportCat=".$_GET["reportCat"];?>&tableStatus=view&page=1");
	} else {
		window.location.replace("productsList.php?<?php if($_GET["search"] != "") echo "search=".$_GET["search"]; if($_GET["reportCat"] != "") echo "&reportCat=".$_GET["reportCat"];?>&tableStatus=view&page=1");
	}
}
</script>	

															