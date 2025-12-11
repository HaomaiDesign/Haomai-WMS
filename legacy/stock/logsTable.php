<?php
$pageUrl = "logs.php?tableStatus=view";

if (isset($_GET['warehouseId'])) {
	$pageUrl .= "&warehouseId=" . $_GET['warehouseId'];
	list($id, $name) = explode("_", $_GET['warehouseId']);
	$_SESSION['whData']['id'] = $id;
	$_SESSION['whData']['name'] = $name;
}

if ($_GET['productId'] != "") {
	$pageUrl .= "&productId=" . $_GET['productId'];
	$productCondition = " AND stockLogs.productId=" . $_GET['productId'];
} else {
	$productCondition = "";
}

/*if($_GET['unitBarcode']!=""){
				   $pageUrl.= "&unitBarcode=".$_GET['unitBarcode'];
				   $productCondition = " AND stockLogs.unitBarcode=".$_GET['unitBarcode'];
			   } else {
				   $productCondition = "";
			   }*/


if (isset($_GET['date'])) {
	$pageUrl .= "&date=" . $_GET['date'];
	$fechaElegida = $_GET['date'];
	list($y, $m, $d) = explode("-", $_GET['date']);
	$_SESSION['dateChange'] = $d . "/" . $m . "/" . $y;
	if ($_GET['date'] == date("Y-m-d"))
		$dateCondition = "";
	else
		$dateCondition = " AND stockLogs.date BETWEEN  '" . $fechaElegida . " 00:00:00' AND '" . $fechaElegida . " 23:59:59'";
} else {
	$dateCondition = "";
	//$fechaElegida = date("Y-m-d");
	//$_SESSION['dateChange'] = date("d/m/Y");
}

if (!isset($_GET['warehouseId']) || $_GET['warehouseId'] == "allWarehouse") {
	$whSQLrequest = "";
} else {
	$whSQLrequest = " AND stockLogs.warehouseId=" . $id;
}
$searchFilter = "";
if ($_GET["search"] != "") {
	$searchFilter = " AND (products.name LIKE '%" . $_GET['search'] . "%' OR stockLogs.description LIKE '%" . $_GET['search'] . "%')";
	$pageUrl .= "&search=" . $_GET['search'];
}

$pageUrl .= "&page=";
$sql0 = "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId INNER JOIN users ON stockLogs.userId=users.id INNER JOIN warehouse ON stockLogs.warehouseId=warehouse.id WHERE products.businessId=" . $_SESSION['user']['businessId'] . $dateCondition . $productCondition . $whSQLrequest .$searchFilter. ";";
$stmt0 = mysqli_query($conn, $sql0);
// echo $sql0;

if ($stmt0) {
	$row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);

	$totalItem = $row0['rowNum'];
	$limit = 100;

	$totalPage = ceil($totalItem / $limit);
	$start = ($_GET['page'] - 1) * $limit;

}


?>


<div class="col-12">


	<?php if ($_GET['tableStatus'] == 'view') { ?>
		<div class="card">
			<div class="card-status card-status-left bg-teal"></div>
			<div class="card-header">


				<!--<a onClick='window.history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp-->

				<form class="form-inline" action="logs.php?tableStatus=view&page=1" method="GET">
					<div class="input-group mb-2 mr-sm-2" style="width: 200px">
						<input type="date" id="datepicker" name="date" class="form-control" onchange="updateList()"
							width="276" value="<?php if (isset($_GET['date'])) {
								$_SESSION['dateChange'] = $_GET['date'];
								echo $_SESSION['dateChange'];
							} else
								echo date("Y-m-d") ?>" autocomplete="off" />
						</div>
						<div class="input-group mb-2 mr-sm-2" style="width: 200px">
							<select class="form-control" id="sel_wh" name="warehouseId" onchange="updateList()"
								style="width: 200px">
								<option value="allWarehouse">
								<?php echo $_SESSION['language']['All Warehouses']; ?>
							</option>
							<?php


							$sql = "SELECT id AS wid, name FROM warehouse WHERE businessId = " . $_SESSION['user']['businessId'];
							$stmt_warehouse = mysqli_query($conn, $sql);
							echo $sql;
							if ($stmt_warehouse) {
								while ($row = mysqli_fetch_array($stmt_warehouse, MYSQLI_ASSOC)) {
									?>
									<option value=<?php echo $row["wid"] . "_" . $row["name"] . "'";
									if (isset($_GET['warehouseId']) && $_SESSION['whData']['id'] == $row["wid"])
										echo " selected" ?>><?php echo $row["name"]; ?>
									</option>
									<?php
								}
							}
							mysqli_free_result($stmt_warehouse);
							?>
						</select>
					</div>
						<!-- <form class="form-inline" action="logs.php" method="GET"> -->
						<div class="card-options">
							<div class="item-action">
									<div class="input-icon mb-3">
										<input id="search" name="search" type="search" class="form-control header-search" onchange="updateList()"
											placeholder="<?php echo $_SESSION['language']['search']; ?>"
											value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
										<input id="tableStatus" name="tableStatus" type="hidden" class="form-control header-search"
											value="view">
										<input id="page" name="page" type="hidden" class="form-control header-search" value="1">
										<span class="input-icon-addon">
											<i class="fe fe-search"></i>
										</span>
									</div>
							</div>
						</div>
					</form>
					<!--
										<div class="input-group mb-2 mr-sm-2" style="width: 200px">
											<select class="form-control" id="productId" name="productId" onchange="updateList()" style="width: 200px">
												<option value=""><?php echo $_SESSION['language']['All Products']; ?></option>
												<?php


												//$sqlProduct = "SELECT id, sku, name FROM products WHERE businessId=".$_SESSION['user']['businessId']." ORDER BY id ASC;";
												//$stmtProduct = mysqli_query( $conn, $sqlProduct);
												//echo $sqlProduct;
												//if ($stmtProduct) {
												//while($rowProduct = mysqli_fetch_array($stmtProduct, MYSQLI_ASSOC)) {
												?>
												<option value=<?php echo $rowProduct["id"];
												if ($_GET['productId'] == $rowProduct["id"])
													echo " selected" ?>><?php echo $rowProduct["sku"] . " - " . $rowProduct["name"]; ?></option>
												<?php
												//}
												//} 
												//mysqli_free_result ($stmtProduct);
												?>
											</select>
										</div>
										-->
				<!-- </form> -->


				<!-- <div class="card-options">
					<div class="item-action">
						<form class="form-inline" action="logs.php" method="GET">
							<div class="input-icon mb-3">
								<input id="search" name="search" type="search" class="form-control header-search"
									placeholder="<?php echo $_SESSION['language']['search']; ?>">
								<input id="tableStatus" name="tableStatus" type="hidden" class="form-control header-search"
									value="view">
								<input id="page" name="page" type="hidden" class="form-control header-search" value="1">
								<span class="input-icon-addon">
									<i class="fe fe-search"></i>
								</span>
							</div>
						</form>
					</div>
				</div> -->
			</div>
		</div>
	<?php }
	; ?>

	<div class="card">
		<div class="card-status card-status-left bg-teal"></div>
		<div class="card-header">
			<h3 class="card-title" style="font-weight:bold;">
				<?php echo $_SESSION['language']['Logs']; ?>
			</h3>

			<div class="item-action">
				<a style="margin-left:15px;" target="_blank" href="printLogs.php?page=<?php echo $_GET['page'] . "&";
				if ($_GET["search"] != "")
					echo "search=" . $_GET["search"];
				if ($_GET["date"] != "")
					echo "&date=" . $_GET["date"];
				if ($_GET["warehouseId"] != "")
					echo "&warehouseId=" . $_GET["warehouseId"]; ?>"><i class="dropdown-icon fe fe-printer"></i></a>
			</div>
			<div class="card-options">
				<div class="item-action">
					<?php echo $_SESSION['language']['Total'] . " " . $totalItem . " " . $_SESSION['language']['Logs']; ?>&nbsp&nbsp&nbsp
				</div>

				<div class="item-action">
					<a href="<?php echo $pageUrl . "1"; ?>" <?php if ($_GET['page'] == 1)
							 echo " style='pointer-events: none;'";
						 else
							 echo " style='color: black;'"; ?>><i class="fas fa-angle-double-left"></i></a>
					<a href="<?php echo $pageUrl . ($_GET['page'] - 1); ?>" <?php if ($_GET['page'] == 1)
							   echo " style='pointer-events: none;'";
						   else
							   echo " style='color: black;'"; ?>><i
							class="fas fa-angle-left"></i></a>
					<a style="color: black;">
						<?php echo $_SESSION['language']['Page'] . " " . $_GET['page'] . " / " . $totalPage; ?>&nbsp
					</a>
					<a href="<?php echo $pageUrl . ($_GET['page'] + 1); ?>" <?php if ($_GET['page'] == $totalPage)
							   echo " style='pointer-events: none;'";
						   else
							   echo " style='color: black;'"; ?>><i
							class="fas fa-angle-right"></i></a>
					<a href="<?php echo $pageUrl . $totalPage; ?>" <?php if ($_GET['page'] == $totalPage)
							 echo " style='pointer-events: none;'";
						 else
							 echo " style='color: black;'"; ?>><i
							class="fas fa-angle-double-right"></i></a>&nbsp
				</div>
			</div>
		</div>




		<div class="table-responsive">
			<table id="table" class="table table-hover table-outline table-vcenter text-truncate card-table">
				<thead>
					<tr>
						<th class="text-center" style="width:5%;font-weight:bold;">
							<?php echo $_SESSION['language']['Date']; ?>
						</th>
						<th class="text-center" style="width:5%;font-weight:bold;">
							<?php echo $_SESSION['language']['Time']; ?>
						</th>
						<!-- <th class="text-center" style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['SKU']; ?></th> -->
						<th class="text-center" style="width:5%;font-weight:bold;">
							<?php echo $_SESSION['language']['Code']; ?>
						</th>
						<th class="text-center" style="width:10%;font-weight:bold;">
							<?php echo $_SESSION['language']['Quantity']; ?>
						</th>
						<th style="width:35%;font-weight:bold;">
							<?php echo $_SESSION['language']['Product Name']; ?>
						</th>
						<th class="text-center" style="width:10%;font-weight:bold;">
							<?php echo $_SESSION['language']['Type']; ?>
						</th>
						<th class="text-center" style="width:10%;font-weight:bold;">
							<?php echo $_SESSION['language']['Warehouse']; ?>
						</th>
						<th style="width:15%;font-weight:bold;">
							<?php echo $_SESSION['language']['Description']; ?>
						</th>
						<!--<th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['User']; ?> </th>-->
					</tr>
				</thead>
				<tbody>


					<?php
					// $searchFilter = "";
					// if ($_GET["search"] != "") {
					// 	$searchFilter = " AND (products.name LIKE '%" . $_GET['search'] . "%' OR stockLogs.description LIKE '%" . $_GET['search'] . "%')";
					// }

					//$sql = "SELECT * FROM ( SELECT stockLogs.id, stockLogs.requestId, stockLogs.date, stockLogs.stock, stockLogs.type, stockLogs.warehouseId, stockLogs.productId, stockLogs.userId, stockLogs.orderId, stockLogs.description, products.name AS productName, products.sku, products.code, users.fullName, warehouse.name as warehouseName, ROW_NUMBER() OVER (ORDER BY stockLogs.id) as row FROM stockLogs INNER JOIN products ON stockLogs.productId=products.id INNER JOIN users ON stockLogs.userId=users.id INNER JOIN warehouse ON stockLogs.warehouseId=warehouse.id WHERE stockLogs.businessId=".$_SESSION['user']['businessId'].") AS alias WHERE row>".$min." and row<=".$max." ORDER BY id DESC;";
					//$sql = "SELECT stockLogs.id, stockLogs.requestId, stockLogs.date, stockLogs.stock, stockLogs.type, stockLogs.warehouseId, stockLogs.productId, stockLogs.userId, stockLogs.orderId, stockLogs.description, products.name AS productName, products.sku, products.code, users.fullName, warehouse.name as warehouseName FROM products  FULL JOIN stockLogs ON products.id=stockLogs.productId INNER JOIN users ON stockLogs.userId=users.id INNER JOIN warehouse ON stockLogs.warehouseId=warehouse.id WHERE (stockLogs.date BETWEEN '" . $fechaElegida . " 00:00:00' AND '" . $fechaElegida . " 23:59:59') AND  products.businessId=" . $_SESSION['user']['businessId'] . " AND products.flagStock=1 ". $whSQLrequest . "  GROUP BY products.id, products.sku, products.code, products.brand, products.name, products.packWholesale, products.description,stockLogs.id,stockLogs.requestId,stockLogs.date,stockLogs.stock,stockLogs.type,stockLogs.warehouseId,stockLogs.productId,stockLogs.userId,stockLogs.orderId,stockLogs.description,users.fullName,warehouse.name ORDER BY products.id ASC;";  
					//$sql = "SELECT * FROM (SELECT ROW_NUMBER() OVER (ORDER BY stockLogs.id ASC) as row, stockLogs.id, stockLogs.requestId, stockLogs.date, stockLogs.stock, stockLogs.type, stockLogs.warehouseId, stockLogs.productId, stockLogs.userId, stockLogs.orderId, stockLogs.description, products.name AS productName, products.sku, products.code, users.fullName, warehouse.name as warehouseName FROM products  FULL JOIN stockLogs ON products.id=stockLogs.productId INNER JOIN users ON stockLogs.userId=users.id INNER JOIN warehouse ON stockLogs.warehouseId=warehouse.id WHERE products.businessId=".$_SESSION['user']['businessId']." AND products.flagStock=1 ".$whSQLrequest.$productCondition.$dateCondition." GROUP BY products.id, products.sku, products.code, products.brand, products.name, products.packWholesale, products.description,stockLogs.id,stockLogs.requestId,stockLogs.date,stockLogs.stock,stockLogs.type,stockLogs.warehouseId,stockLogs.productId,stockLogs.userId,stockLogs.orderId,stockLogs.description,users.fullName,warehouse.name) AS newTable WHERE (row>".$min.") AND (row<=".$max.") ORDER BY date DESC;";
					
					// con user.fullName
					// $sql = "SELECT * FROM (SELECT stockLogs.id, stockLogs.requestId, stockLogs.date, stockLogs.stock, stockLogs.type, stockLogs.warehouseId, stockLogs.productId, stockLogs.userId, stockLogs.orderId, stockLogs.description, products.name AS productName, products.sku, products.unitBarcode, users.fullName, warehouse.name as warehouseName FROM products as products LEFT JOIN stockLogs as stockLogs ON products.id=stockLogs.productId INNER JOIN users as users ON stockLogs.userId=users.id INNER JOIN warehouse as warehouse ON stockLogs.warehouseId=warehouse.id WHERE products.businessId=".$_SESSION['user']['businessId']." ".$searchFilter.$whSQLrequest.$productCondition.$dateCondition." GROUP BY products.id, products.sku, products.unitBarcode, products.brand, products.name, products.packWholesale, products.description,stockLogs.id,stockLogs.requestId,stockLogs.date,stockLogs.stock,stockLogs.type,stockLogs.warehouseId,stockLogs.productId,stockLogs.userId,stockLogs.orderId,stockLogs.description,users.fullName,warehouse.name) AS newTable ORDER BY date DESC LIMIT ".$start.",".$limit.";";
					
					// sin user.fullName
					$sql = "SELECT * FROM (
											SELECT stockLogs.id, stockLogs.requestId, stockLogs.date, stockLogs.stock, stockLogs.type, stockLogs.warehouseId, stockLogs.productId, stockLogs.userId, stockLogs.orderId, stockLogs.description, products.name AS productName, products.sku, products.unitBarcode, warehouse.name as warehouseName 
											FROM products as products 
											LEFT JOIN stockLogs as stockLogs ON products.id=stockLogs.productId 
											INNER JOIN warehouse as warehouse ON stockLogs.warehouseId=warehouse.id 
											WHERE products.businessId=" . $_SESSION['user']['businessId'] . " " . $searchFilter . $whSQLrequest . $productCondition . $dateCondition . " 
											GROUP BY products.id, products.sku, products.unitBarcode, products.brand, products.name, products.packWholesale, products.description,stockLogs.id,stockLogs.requestId,stockLogs.date,stockLogs.stock,stockLogs.type,stockLogs.warehouseId,stockLogs.productId,stockLogs.userId,stockLogs.orderId,stockLogs.description,warehouse.name) AS newTable 
											ORDER BY date DESC LIMIT " . $start . "," . $limit . ";";
					$stmt = mysqli_query($conn, $sql);

					// echo $sql;
					
					if ($stmt) {
						while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {

							$phpdate = strtotime($row['date']);


							?>

							<tr>
								<td class="text-center">
									<div>
										<?php echo date('Y-m-d', $phpdate); ?>
									</div>
								</td class="text-center">
								<td>
									<div>
										<?php echo date('H:i:s', $phpdate); ?>
									</div>
								</td>
								<!-- <td class="text-center">
										<div><?php echo $row['sku']; ?></div>
									  </td> -->

								<td class="text-center">
									<div>
										<?php echo $row['unitBarcode']; ?>
									</div>
								</td>

								<td class="text-center">
									<div><strong>
											<?php echo $row['stock']; ?>
										</strong></div>
								</td>
								<td>
									<div>
										<?php

										if (strlen($name) > 30)
											echo substr($row['productName'], 0, 30) . "...";
										else
											echo $row['productName'];
										?>
									</div>
								</td>
								<td class="text-center">
									<div>
										<?php
										if ($row['type'] == 2)
											echo $_SESSION['language']['Check'];

										if ($row['type'] == 1)
											echo $_SESSION['language']['Delivered'];

										if ($row['type'] == 0)
											echo $_SESSION['language']['Received'];


										?>
									</div>
								</td>
								<td class="text-center">
									<div>
										<?php echo $row['warehouseName']; ?>
									</div>
								</td>
								<td>
									<div>
										<?php echo $row['description']; //echo $row['fullName']; ?>
									</div>
								</td>

							</tr>
						<?php }
						; ?>

					</tbody>
				</table>
			</div>

		<?php }
					; ?>

	</div>
</div>

<script>
	function updateList() {
		let sel_date = document.getElementById('datepicker').value;
		let sel_wh = document.getElementById('sel_wh').value;
		let sel_search = document.getElementById('search').value;
		//let sel_product = "&productId="+document.getElementById('productId').value; 
		// let sel_product = "";
		console.log(sel_date);
		console.log(sel_wh);
		console.log(sel_search)
		location.href = "logs.php?tableStatus=view&page=1&date=" + sel_date + "&warehouseId=" + sel_wh + "&search="+ sel_search ;

	}
</script>