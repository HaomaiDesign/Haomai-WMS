<?php
$pageUrl = "productsDemand.php?tableStatus=view";

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
		$dateCondition = "a.date BETWEEN  '" . $fechaElegida . " 00:00:00' AND '" . $fechaElegida . " 23:59:59'";
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
// $currentDate = date('Y-m-01');
// $startDate = date('Y-m-01', strtotime('-4 month', strtotime($currentDate)));

$pageUrl .= "&page=";
$sql0 = "SELECT
    products.`unitBarcode`,
    products.name AS productName,
    SUM(stocklogs.stock) AS ingresos,
    YEAR(stocklogs.`date`) AS yr,
    CASE WHEN MONTH(stocklogs.`date`) IN (12,1,2) THEN 1 
        WHEN MONTH(stocklogs.`date`) IN (3,4,5) THEN 2
        WHEN MONTH(stocklogs.`date`) IN (6,7,8) THEN 3
        ELSE 4 END AS periodo
FROM stocklogs
    INNER JOIN products ON products.id = stocklogs.productId
WHERE stock > 0 AND YEAR(stocklogs.`date`) = 2023
GROUP BY
    products.`unitBarcode`,
    periodo
ORDER BY products.`unitBarcode`, periodo";

$stmt0 = mysqli_query($conn, $sql0);
// echo $sql0;

if ($stmt0) {
	$row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);

	$totalItem = $row0['rowNum'];
	// echo $totalItem;
	// print_r($row0);
	$limit = 50;

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

				<!--<form class="form-inline" action="logs.php?tableStatus=view&page=1" method="GET">
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
				</form> -->


				<form class="form-inline" action="logs.php?tableStatus=view&page=1" method="GET">
					<div class="input-group mb-2 mr-sm-2" style="width: 200px">
						<select class="form-control" id="periodNumber" name="periodNumber" onchange="filterByPeriod()"
							style="width: 200px">
							<option value="all">
								<?php echo $_SESSION['language']['All']; ?>
							</option>
							<option <?php if ($_GET['periodNumber'] == 1)
								echo 'selected' ?> value="1">12 - 2 夏季</option>
								<option <?php if ($_GET['periodNumber'] == 2)
								echo 'selected' ?> value="2">3 - 5 秋季</option>
								<option <?php if ($_GET['periodNumber'] == 3)
								echo 'selected' ?> value="3">6 - 8 冬季</option>
								<option <?php if ($_GET['periodNumber'] == 4)
								echo 'selected' ?> value="4">9 - 11 春季</option>
							</select>
						</div>
						<div class="input-group mb-2 mr-sm-2" style="width: 200px">
							<select class="form-control" id="year" name="year" onchange="filterByYear()" style="width: 200px">
								<option value="all">
								<?php echo $_SESSION['language']['All']; ?>
							</option>
							<option <?php if ($_GET['year'] == "2022")
								echo 'selected' ?> value="2022">2022</option>
								<option <?php if ($_GET['year'] == "2023")
								echo 'selected' ?> value="2023">2023</option>
								<!-- <option value="3">2024</option> -->
							</select>
						</div>
					</form>


					<div class="card-options">
						<div class="item-action">
							<form class="form-inline" action="productsDemand.php" method="GET">
								<div class="input-icon mb-3">
									<input id="search" name="search" type="search" class="form-control header-search" value='<?php if ($_GET['search'] != '')
								echo $_GET['search'] ?>' placeholder="<?php echo $_SESSION['language']['search']; ?>">
								<input id="tableStatus" name="tableStatus" type="hidden" class="form-control header-search"
									value="view">
								<?php if (isset($_GET['periodNumber']))
									echo "<input id='periodNumber' name='periodNumber' type='hidden' class='form-control header-search' value='" . $_GET["periodNumber"] . "'>"
										?>
								<?php if (isset($_GET['year']))
									echo "<input id='year' name='year' type='hidden' class='form-control header-search' value='" . $_GET["year"] . "'>"
										?>

									<input id="page" name="page" type="hidden" class="form-control header-search" value="1">
									<span class="input-icon-addon">
										<i class="fe fe-search"></i>
									</span>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	<?php }
	; ?>

	<div class="card">
		<div class="card-status card-status-left bg-teal"></div>
		<div class="card-header">
			<h3 class="card-title" style="font-weight:bold;">
				<?php echo $_SESSION['language']['Report']; ?>
			</h3>

			<!-- <div class="item-action">
				<a style="margin-left:15px;" target="_blank" href="printLogs.php?page=<?php echo $_GET['page'] . "&";
				if ($_GET["search"] != "")
					echo "search=" . $_GET["search"];
				if ($_GET["date"] != "")
					echo "&date=" . $_GET["date"];
				if ($_GET["warehouseId"] != "")
					echo "&warehouseId=" . $_GET["warehouseId"]; ?>"><i class="dropdown-icon fe fe-printer"></i></a>
			</div> -->
			<div class="card-options">
				<div class="item-action">
					<?php echo $_SESSION['language']['Total'] . " " . $totalItem . " " . $_SESSION['language']['Report']; ?>&nbsp&nbsp&nbsp
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
			<table id="reportTable" class="table table-hover table-outline table-vcenter text-truncate card-table">
				<thead>
					<tr>
						<th class="text-center" style="width:20%;font-weight:bold;">
							<?php echo $_SESSION['language']['Code']; ?>
						</th>
						<th style="width:30%;font-weight:bold;">
							<?php echo $_SESSION['language']['Product Name']; ?>
						</th>
						<!-- <th class="text-center" style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['SKU']; ?></th> -->
						<th class="text-center" style="width:10%;font-weight:bold;">
							<?php echo $_SESSION['language']['Merchandise Income']; ?>
						</th>
						<th class="text-center" style="width:10%;font-weight:bold;">
							<?php echo $_SESSION['language']['Merchandise Shipment']; ?>
						</th>
						<th class="text-center" style="width:10%;font-weight:bold;">
							<?php echo $_SESSION['language']['Month']; ?>
						</th>
						<th class="text-center" style="width:15%;font-weight:bold;">
							<?php echo $_SESSION['language']['Year']; ?>
						</th>
						<!--<th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['User']; ?> </th>-->
					</tr>
				</thead>
				<tbody>


					<?php
					$searchFilter = "";
					if ($_GET["search"] != "") {
						$searchFilter = " AND (products.name LIKE '%" . $_GET['search'] . "%' OR products.`unitBarcode` LIKE '%" . $_GET['search'] . "%')";
					}
					$yearFilter = "";
					if ($_GET["year"] != "") {
						$yearFilter = " AND (YEAR(stocklogs.`date`)=" . $_GET['year'] . ")";
					}
					$periodFilter = "";
					if ($_GET["periodNumber"] != "") {
						$periodosMeses = [
							"1" => [12, 1, 2],
							"2" => [3, 4, 5],
							"3" => [6, 7, 8],
							"4" => [9, 10, 11]
						];

						$periodNumber = $_GET["periodNumber"] ?? null;

						if (array_key_exists($periodNumber, $periodosMeses)) {
							$months = $periodosMeses[$periodNumber];
							$periodFilter = " AND MONTH(stocklogs.`date`) IN (" . implode(', ', $months) . ")";
						} else {
							$periodFilter = "";
						}
					}

					// $currentDate = date('Y-m-01');
					// $startDate = date('Y-m-01', strtotime('-4 month', strtotime($currentDate)));
					
					$sql = "WITH ingresos AS (
							SELECT
								products.`unitBarcode`,
								products.name AS productName,
								SUM(stocklogs.stock) AS ingresos,
								YEAR(stocklogs.`date`) AS yr,
								CASE WHEN MONTH(stocklogs.`date`) IN (12,1,2) THEN 1 
									WHEN MONTH(stocklogs.`date`) IN (3,4,5) THEN 2
									WHEN MONTH(stocklogs.`date`) IN (6,7,8) THEN 3
									ELSE 4 END AS periodo
							FROM stocklogs
								INNER JOIN products ON products.id = stocklogs.productId
							WHERE stock > 0 " . $searchFilter . $yearFilter . $periodFilter . "
							GROUP BY
								products.`unitBarcode`,
								periodo
						),
						egresos AS (
							SELECT
								products.`unitBarcode`,
								products.name AS productName,
								SUM(stocklogs.stock) AS egresos,
								YEAR(stocklogs.`date`) AS yr,
								CASE WHEN MONTH(stocklogs.`date`) IN (12,1,2) THEN 1 
									WHEN MONTH(stocklogs.`date`) IN (3,4,5) THEN 2
									WHEN MONTH(stocklogs.`date`) IN (6,7,8) THEN 3
									ELSE 4 END AS periodo
							FROM stocklogs
								INNER JOIN products ON products.id = stocklogs.productId
							WHERE stock < 0 " . $searchFilter . $yearFilter . $periodFilter . " 
							GROUP BY
								products.`unitBarcode`,
								periodo
							)
						SELECT * FROM (
							SELECT
								COALESCE(i.`unitBarcode`, e.`unitBarcode`) as barcode, COALESCE(i.productName, e.productName) as productName, COALESCE(e.egresos, 0) as egresos, 
								COALESCE(i.ingresos, 0) as ingresos, COALESCE(e.periodo, i.periodo) as periodo, COALESCE(i.yr, e.yr) as yr
							FROM ingresos as i
								LEFT JOIN egresos as e ON e.`unitBarcode` = i.`unitBarcode` AND e.yr = i.yr AND e.periodo = i.periodo
							UNION
							SELECT
								COALESCE(i.`unitBarcode`, e.`unitBarcode`) as barcode, COALESCE(i.productName, e.productName) as productName, COALESCE(e.egresos, 0) as egresos,
								COALESCE(i.ingresos, 0) as ingresos, COALESCE(e.periodo, i.periodo) as periodo, COALESCE(i.yr, e.yr) as yr
							FROM ingresos as i
								RIGHT JOIN egresos as e ON e.`unitBarcode` = i.`unitBarcode` AND e.yr = i.yr AND e.periodo = i.periodo
						) as a
						ORDER BY 
							barcode, periodo
						LIMIT " . $start . "," . $limit . ";";

					$stmt = mysqli_query($conn, $sql);

					// echo $sql;
					
					if ($stmt) {
						while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {

							$phpdate = strtotime($row['date']);


							?>

							<tr>

								<td class="text-center">
									<div>
										<?php echo $row['barcode']; ?>
									</div>
								</td>

								<td>
									<div>
										<?php

										if (strlen($name) > 30)
											echo substr($row['productName'], 0, 50) . "...";
										else
											echo $row['productName'];
										?>
									</div>
								</td>

								<td class="text-center">
									<div><strong>
											<?php echo $row['ingresos']; ?>
										</strong></div>
								</td>

								<td class="text-center">
									<div><strong>
											<?php echo $row['egresos']; ?>
										</strong></div>
								</td>

								<td class="text-center">
									<div>
										<?php
										if ($row['periodo'] == 1) {
											echo "12 - 2 夏季";
										}
										if ($row['periodo'] == 2) {
											echo "3 - 5 秋季";
										}
										if ($row['periodo'] == 3) {
											echo "6 - 8 冬季";
										}
										if ($row['periodo'] == 4) {
											echo "9 - 11 春季";
										}
										?>
									</div>
								</td>

								<td class="text-center">
									<div>
										<?php echo $row['yr'] ?>
									</div>
								</td>

							</tr>
						<?php }
						; ?>

					</tbody>
				</table>
				<div id="loading"></div>
			</div>

		<?php }
					; ?>

	</div>
</div>

<script>
	function colorEqualCellGroups() {
		var table = document.getElementById("reportTable");
		var rows = table.getElementsByTagName("tr");
		var prevCellValue = "";
		var prevRowColor = "";

		for (var i = 1; i < rows.length; i++) {
			var cells = rows[i].getElementsByTagName("td");
			if (prevCellValue != "" && cells[0].innerHTML != prevCellValue && prevRowColor == rows[i].style.backgroundColor) {
				if (prevRowColor == "")
					rows[i].style.backgroundColor = "rgba(242, 242, 242, 1)";
			}
			if (prevCellValue != "" && cells[0].innerHTML == prevCellValue && prevRowColor != rows[i].style.backgroundColor) {
				rows[i].style.backgroundColor = prevRowColor;
			}
			var prevCellValue = cells[0].innerHTML;
			var prevRowColor = rows[i].style.backgroundColor;
		}
	}
	function filterByPeriod() {
		let otherFilters = "<?php if (isset($_GET['search']))
			echo '&search=' . $_GET['search'];
		if (isset($_GET['year']))
			echo '&year=' . $_GET['year']; ?>";

		const periodNumber = $('#periodNumber').val();
		let target = '';
		if (periodNumber != 'all') {
			target = 'periodNumber=' + periodNumber + '&';
		}

		$('#loading').modal({
			backdrop: 'static',
			keyboard: false
		})
		window.location.replace("productsDemand.php?" + target + "tableStatus=view&page=1" + otherFilters);
	}

	function filterByYear() {
		let otherFilters = "<?php if (isset($_GET['search']))
			echo '&search=' . $_GET['search'];
		if (isset($_GET['periodNumber']))
			echo '&periodNumber=' . $_GET['periodNumber']; ?>";

		const year = $('#year').val();
		let target = '';
		if (year != 'all') {
			target = 'year=' + year + '&';
		}


		$('#loading').modal({
			backdrop: 'static',
			keyboard: false
		})
		window.location.replace("productsDemand.php?" + target + "tableStatus=view&page=1" + otherFilters);
	}

	colorEqualCellGroups();
</script>