<script>
function updateFilterCat(){							
	// var reportCat = document.getElementById("reportCat").value;
	console.log($('#reportCat').val());
	const selectedCategories = $('#reportCat').val();
	var target = 'reportCat=';
	selectedCategories.map(
	(cat, index) => {
		target = target + `${cat},`;
	});
	
	target = target.slice(0,-1) + '&';
	console.log(target);

	$('#loading').modal({
    backdrop: 'static',
    keyboard: false
	})
	window.location.replace("reportCatList.php?"+target+"tableStatus=view&page=1");
	// window.location.replace("reportCatList.php?reportCat="+category+"&tableStatus=view&page=1");
	
}
</script>
	<?php
					$target = "products.flagActive = 1 AND products.businessId=".$_SESSION['user']['businessId'];
					if($_GET["search"] != ""){
						$target.= " AND products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%'";
						$pageUrl = "reportCatList.php?reportCat=ALL&search=".$_GET["search"]."&tableStatus=view&page=";
					} else {
						$pageUrl = "reportCatList.php?reportCat=".$_GET["reportCat"]."&tableStatus=view&page=";
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
					<?php if ($_GET['tableStatus']=='view') { ?>
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
							
								<div class="card-options">
									<div class="item-action">
								
										<!--
											<form>
											<div class="input-icon mb-3">
												<input id="searchTable" onkeyup="tableFilter()" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['search'];?>" tabindex="1">
												<span class="input-icon-addon">
												<i class="fe fe-search"></i>
												</span>
											</div>
											</form>
											
										-->
										<div class="row">
											<form action="reportCatList.php" method="get" autocomplete="off" >
												<div  style="width: 200px; margin-right: 20px;">
													<div class="input-icon mb-1">
														<input id="search" name="search" type="search" class="form-control header-search" value="<?php if ($_GET['search']!="") echo $_GET['search']; ?>" placeholder="<?php echo $_SESSION['language']['search'];?>">
														<input id="tableStatus" name="tableStatus" type="hidden" value="view">
														<input id="page" name="page" type="hidden" value="<?= $_GET["page"];?>">
														<span class="input-icon-addon">
															<i class="fe fe-search"></i>
														</span>
													</div>
												</div>
											</form>
											<div style="width: 200px; margin-right: 20px;">
												<!-- <?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Category']; ?>  -->
												<select id="reportCat" multiple class="form-control" >
												<!-- onchange="updateFilterCat(this.value)" -->
												<option value='ALL' <?php if ($_GET["reportCat"] == "ALL") echo "selected" ?>  ><?=$_SESSION["language"]["All"];?></option>
												
												<?php 
														$sqlreportCat = "SELECT distinct category FROM products order by category;";  
														$stmtreportCat = mysqli_query( $conn, $sqlreportCat);
														
															if ( $stmtreportCat ) {
																while( $rowreportCat = mysqli_fetch_array( $stmtreportCat, MYSQLI_ASSOC))  
																{  
																	if ($rowreportCat['category']=="")
																		if ($_GET["reportCat"]=="EMPTY")	
																			echo "<option value='EMPTY' selected>(".$_SESSION["language"]["Without category"].")</option>"; 
																		else
																			echo "<option value='EMPTY'>(".$_SESSION["language"]["Without category"].")</option>"; 
																	else
																		echo "<option value='".$rowreportCat['category']."'>".$rowreportCat['category']." </option>"; 
																		// if ($_GET["reportCat"]==$rowreportCat['category'])	
																		// 	echo "<option value='".$rowreportCat['category']. "' selected>".$rowreportCat['category']."</option>"; 
																		// else
																		// 	echo "<option value='".$rowreportCat['category']."'>".$rowreportCat['category']." </option>"; 
																}
															}
													?>
												</select>
											</div>
											<div style="margin-right: 20px;">
												<a class="btn btn-outline-secondary btn-sm active" onclick="updateFilterCat()">
													筛选
													<!-- <input type="button" value="筛选" onclick="updateFilterCat()"/> -->
												</a>
											</div>
										</div>
									</div>
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
									<div class="item-action">	
										<a style="margin-left:15px;" target="_blank" href="printCatSaleOrder.php<?php if($_GET["search"] != "" || $_GET["reportCat"] != ""|| $_GET["details"] != "") echo "?"; if($_GET["search"] != "") echo "search=".$_GET["search"]; if($_GET["reportCat"] != "") echo "&reportCat=".$_GET["reportCat"];  if($_GET["details"] != "") echo "&details=".$_GET["details"];?>"><i class="dropdown-icon fe fe-printer"></i></a>
									</div>
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
												if ($_GET['details']!=""){
													$groupbyClause =" products.id ";
												} 
												else {
													$groupbyClause = " products.unitbarcode ";	
												}	
													
													if ($_GET['search']!="")  {
														$sql = "SELECT stockLogs.productId, products.unitbarcode, products.image, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description,sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
															WHERE products.flagActive = 1";
															
														$sql2 = "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
															WHERE products.flagActive = 1";	
															

														if($_GET['search']!=""){
															$sql.= " AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )";
															
															$sql2.= " AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )";
														}
														
														$sql .=	" GROUP BY ".$groupbyClause."
																ORDER BY products.category, products.name DESC LIMIT ".$start.",".$limit.";"; 
																
														$sql2 .=	" GROUP BY ".$groupbyClause."
																ORDER BY stock DESC ;"; 
																
																//echo "sql SEARCH: ". $sql;
																
													} else {
													
													if (($_GET['reportCat'] != "")AND($_GET['reportCat'] != "ALL")AND($_GET['reportCat'] != "EMPTY")) {
														
														$catList = explode(',', $_GET['reportCat']);
														$catFilter = "(";
														for ($i=0; $i < count($catList); $i++) {

															$catFilter .= "'".$catList[$i]."'" . ',';
														}
														$catFilter = substr($catFilter,0,-1) . ')';

														$sql = "SELECT stockLogs.productId,products.unitbarcode, products.image, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description,sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1";
														
														$sql2 = "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1";

														$sql.= " AND products.category IN ".$catFilter;
														
														$sql2.= " AND products.category IN ".$catFilter;
														
														$sql .=	" GROUP BY ".$groupbyClause."
															ORDER BY products.category, products.name DESC LIMIT ".$start.",".$limit.";"; 
															
														$sql2 .= " GROUP BY ".$groupbyClause."
															ORDER BY stock DESC ;"; 
														
														
														// echo "sql CATEGORY: ". $sql;
														
													}
													
													if ($_GET['reportCat'] == "EMPTY"){
														
														$sql = "SELECT stockLogs.productId,products.unitbarcode, products.dueDate, products.image, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description,sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1";
														
														$sql2 = "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1";

														$sql.= " AND products.category = ''";
														
														$sql2.= " AND products.category = '".$_GET['reportCat']."'";
														
														$sql .=	" GROUP BY ".$groupbyClause."
															ORDER BY products.category, products.name DESC LIMIT ".$start.",".$limit.";"; 
															
														$sql2 .=	" GROUP BY ".$groupbyClause."
															ORDER BY stock DESC ;"; 
														
														//echo "sql EMPTY: ". $sql;
														
													}
													
													if ($_GET['reportCat'] == "ALL"){
														
													$sql = "
														SELECT stockLogs.productId,products.unitbarcode, products.dueDate, products.image, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description ,sum(stockLogs.stock) AS stock 
														FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1
														GROUP BY ".$groupbyClause."
														ORDER BY products.category, products.name DESC
														LIMIT ".$start.",".$limit.";";
														
													$sql2 = "
														SELECT COUNT(*) AS rowNum
														FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
														WHERE products.flagActive = 1
														GROUP BY ".$groupbyClause."
														ORDER BY stock DESC;";	
														
														//echo "sql ALL: ". $sql;
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
										
										<th style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></th>
										<th class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></th>
										<th style="width:30%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>
										<th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?></th>
										<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></th>									  
										<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Unit/Pack'];?></th>
										<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Capacity']."/".$_SESSION['language']['Unit'];?></th>	
										<!-- <th class="text-center"style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['SKU'];?></th> -->
										<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Unit Barcode'];?></th>
										<!-- <?php if(isset($_GET['details'])) { ?>
										<?php } ?> -->
										<th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
									
								  </thead>
								  <tbody>
									
									
									<?php                                                                                                                
									if ( $stmt ) {                                                        
										while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC )){                                                                                                          
											
									?>

												<!--<tr id="tableRow<?php echo $row['id'];?>" onclick="javascript:location.href='reportCatList.php?reportCat=ALL&details=true&search=<?php echo $row['unitbarcode']; ?>&tableStatus=view&page=1'">  -->
												<tr id="tableRow<?php echo $row['id'];?>">
													       																											
													<td class="text-center">                                                                                      
														<div><strong><?php if ($row['stock']!="") echo $row['stock']; else echo "0.00";?></strong></div>                             
													</td>
													<td class="text-center">
														<div><img src="<?php echo $row['image'];?>" class="d-inline-block align-top mr-3" alt=""></div>
													</td>
													<td>
														<!-- <div><a onclick="window.location.href='itemList.php?tableStatus=view&search=<?php echo $row['unitBarcode']; ?>&page=1'" style="cursor: pointer;"><?php if (strlen($row['name'])>50) echo substr($row['name'],0,50)."..."; else echo $row['name']; ?></a></div> -->
														<div><?php if (strlen($row['name'])>50) echo substr($row['name'],0,50)."..."; else echo $row['name']; ?></div>
													</td>
												
													<td>                                                                                                          
														<div><?php echo $row['category']; ?></div>                                                                  
													</td>
													<td class="text-center">
														<div><?php echo $row['dueDate']; ?></div>
													</td>
													<td class="text-center">
														<div><?php echo $row['packWholesale']; ?></div>
													</td>
													<td class="text-center">
														<div><?php echo $row['capacity']." ".$row['unit']; ?></div>
													</td>
													<!-- <td class="text-center">
														<div><?php echo $row['sku']; ?></div>                                                                       
													</td> -->
													<td class="text-center">                                                                                      
														<div><?php echo $row['unitbarcode']; ?></div>                                                               
													</td> 
													<!-- <?php if(isset($_GET['details'])) { ?>
													<?php } ?> -->
														
													<td class="text-center">
													
														<?php if ($_SESSION['user']['roleId']==1) { ?>
													
															<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<!-- <?php if (($row['stock']=="")OR($row['stock']==0)) { ?>
																<a href="itemList.php?formStatus=view&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> <?php echo $_SESSION['language']['Edit product'];?></a>
																<?php }; ?> -->
																<!--<a href="itemList.php?tableStatus=view&search=<?php echo $row['unitBarcode']; ?>&page=1" class="dropdown-item"><i class="dropdown-icon fe fe-eye"></i> <?php echo $_SESSION['language']['Logs'];?></a>-->
																<!--<a href="productsListUpdate.php?formStatus=delete&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-x"></i> <?php echo $_SESSION['language']['Delete'];?></a>-->
																<?php if($_GET["checkboxBarcode"] != "true"){?>
																	<a href="javascript:void(0)" onclick="remove('<?php echo $row['id']; ?>')" class="dropdown-item"><i class="dropdown-icon fe fe-x"></i> <?php echo $_SESSION['language']['Delete'];?></a>
																<?php } ?>
															</div>
															</div>
															
															<?php } ?>
															
															<?php if (($_SESSION['user']['roleId']==3)AND(!isset($_GET['details']))) { ?>
															<div>
																<a href="reportCatList.php?reportCat=ALL&details=true&search=<?php echo $row['unitbarcode']; ?>&tableStatus=view&page=1" class="dropdown-item"><i class="dropdown-icon fe fe-eye"></i></a>
															</div>
														
														<?php } ?>
														
													</td>
												</tr>

											<?php }; ?>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									
							
							<div id="loading"></div>
							
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
		window.location.replace("reportCatList.php?checkboxBarcode=true<?php if($_GET["search"] != "") echo "&search=".$_GET["search"]; if($_GET["reportCat"] != "") echo "&reportCat=".$_GET["reportCat"];?>&tableStatus=view&page=1");
	} else {
		window.location.replace("reportCatList.php?<?php if($_GET["search"] != "") echo "search=".$_GET["search"]; if($_GET["reportCat"] != "") echo "&reportCat=".$_GET["reportCat"];?>&tableStatus=view&page=1");
	}
}




</script>
															