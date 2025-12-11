<?php include "../system/session.php";?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" type="text/css" href="../assets/css/adminx.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/toastr.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/all.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<style type="text/css">

  table { overflow: visible !important; page-break-after:auto }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }


@media print {
	body {
		-webkit-print-color-adjust: exact !important;
		print-color-adjust: exact !important;
  	}
    .export-table {
        overflow: visible !important;
    }
}
</style>
		
    </head>

    <body onload="window.print()">
	
		<!--<div class='page'>-->
		<div>
		<div class="container">	
			<div class="card" style="border: 1px solid gray;">
				<div class="card-body" style="padding: 10px; padding-bottom: 0px;">
					<div class="row">				
						<div class="col" style="text-align: center; padding: 25px;">
							
							<strong>RESUMEN DE PRODUCTOS POR CATEGORIA</strong><br>
							
							<strong><?php echo $_SESSION['language']['Category'];?>: </strong><?php echo $_GET["reportCat"];?>
							
							<!--
							<img src="<?php echo $row["logo"]?>" style="height: 50px; width: auto; margin: 0px; padding: 0px;">
							
							<p style="font-size: 10pt;"> 
								<strong><?php echo $row["businessName"]; ?></strong><br>
								<?php if (($row["address"]!="")AND($row["location"]!="")) echo $row["address"]." ".$row["location"]."<br>"; ?>
								<?php if ($row["phone"]!="") echo "TEL: ".$row["phone"]; ?>
							</p>
							-->
							
						</div>
						<br>
						<div class="col" style="text-align: center; padding: 25px;">
							
							<strong><?php echo $_SESSION['language']['Date'];?>: </strong><?php
							
							
// Return current date from the remote server
$date = date('Y-m-d');
echo $date;
?><br>
							
							<?php if ($_GET['search']!="") echo "<strong>".$_SESSION['language']['Search'].": </strong> ".$_GET["search"];?>
							
						</div> 
						
					</div>
				</div>
				</div>
                <!-- php code para provedor-->
				<div class="card" style="border: 1px solid gray;">	
				<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
				
						<table class="table table-bordered table-sm">
							
							
							<tbody style="font-size: 10pt; padding-top: 0px">
							
								<tr>
									
									<!-- <td class="text-center" style="width:10%;font-weight:bold; text-align: center;"><?php echo $_SESSION['language']['Unit Barcode'];?></td> -->
									<!-- <td class="text-center" style="width:10%;font-weight:bold; text-align: center;"><?php echo $_SESSION['language']['SKU'];?></td> -->
									<td class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></td>
									<!-- agrego image -->
									<td class="text-center" style="widtd:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></td> 
									<td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></td>
									<td class="text-left" style="width:40%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></td>
									<td class="text-center" style="width:15%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?></td>
									<!-- <td class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Capacity'];?></td>
									<td class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Unit'];?></td> -->
									<!-- <td class="text-center" style="width:10%;font-weight:bold; text-align: center;"><?php echo $_SESSION['language']['Unit Barcode'];?></td> -->
								</tr>
								
								<?php
									//$sql1 = "SELECT od.productSku, p.code, od.productName, SUM(od.quantity) AS totalProduct, SUM(od.pack) AS totalPack, od.pack FROM orderDetails AS od INNER JOIN orders ON orders.id = od.orderId INNER JOIN products AS p ON od.productId=p.id WHERE orders.deliveryId =".$_GET['deliveryId']. "GROUP BY od.productSku, p.code, od.productName, od.pack";
									
									if ($_GET["checkboxBarcode"] == "true"){
										$groupbyClause = " products.unitbarcode ";
									} else {
										$groupbyClause =" products.id ";
									}
									

									if ($warehouseRequest != "") {
										$warehouseRequest = " AND ". $warehouseRequest;
									}
										
									if ($_GET['search']!="")  {
										$sql = "SELECT stockLogs.productId, stockLogs.warehouseId,products.unitbarcode, products.image, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description, products.flagDiscontinued, sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
											WHERE products.flagActive = 1";
											

										if($_GET['search']!=""){
											$sql.= $warehouseRequest . " AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )";
											
										}
										
										$sql .=	" GROUP BY ".$groupbyClause." ORDER BY stockLogs.warehouseId ASC, products.category ASC, products.name ASC;"; 
												
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

											for ($i=0; $i < count($catDicKeys); $i++) {
												$warehouseRequest = " AND stockLogs.warehouseId=" . $catDicKeys[$i];

												$sql .= "SELECT stockLogs.productId, stockLogs.warehouseId, products.unitbarcode, products.image, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description, products.flagDiscontinued, sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
												WHERE products.flagActive = 1";
												
												$sql .= $warehouseRequest ." AND products.category IN ". $catDic[$catDicKeys[$i]];
																										
												$sql .=	" GROUP BY ".$groupbyClause."
													ORDER BY stockLogs.warehouseId ASC, products.category ASC, products.name ASC)"; 
													
												if ($i < count($catDicKeys)-1) {
													$sql .= " UNION (";
												}
											}
											$sql .= " ORDER BY warehouseId ASC, category ASC, name ASC;";
										}
										
										if ($_GET['reportCat'] == "EMPTY" ){
											$sql = "SELECT stockLogs.productId, stockLogs.warehouseId,products.unitbarcode, products.dueDate, products.image, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description, products.flagDiscontinued, sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
											WHERE products.flagActive = 1";
											
											$sql.= $warehouseRequest . " AND products.category = ''";
											$sql .=	" GROUP BY ".$groupbyClause."
												ORDER BY stockLogs.warehouseId ASC, product.category ASC, products.name ASC;"; 	
										}
										
										if ($_GET['reportCat'] == "ALL" ){
											
											$sql = "
												SELECT stockLogs.productId, stockLogs.warehouseId, products.unitbarcode, products.image, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description , products.flagDiscontinued, sum(stockLogs.stock) AS stock 
												FROM products   LEFT JOIN stockLogs  ON products.id=stockLogs.productId 
												WHERE products.flagActive = 1 ". $warehouseRequest ."
												GROUP BY ".$groupbyClause."
												ORDER BY stockLogs.warehouseId ASC, products.category ASC, products.name ASC;";
												
												// echo "sql ALL: ". $sql;
										}
									}

									$stmtProduct = mysqli_query( $conn,$sql);

									if ($stmtProduct) {
										
										$totalProducts = 0;
										$lastBarcode = "";
										$today = date('Y-m-d');
										$dueDateColor = "";
										while ($row = mysqli_fetch_array($stmtProduct,MYSQLI_ASSOC)) {
											$rowSelected = "";
											$flagDiscontinued = $row['flagDiscontinued'];

											if ($flagDiscontinued == 1) {
												// $rowSelected = "style='background-color: #ffebf0 !important;'";
												$rowSelected = "color: #ff0000 !important;";
											}
											//$totPack = $row['totalProduct']/$row['pack'];

											echo "<tr onload='printImage()'>";
											//echo "<td style='text-align: center;'>" . $row["productSku"] ."</td>";
												//echo "<td style='text-align: center;'>" . $row["unitbarcode"] . "</td>";
												//echo "<td style='text-align: center;'>" . $row["sku"] . "</td>";
												$cantidadStock = $row["stock"] != 0 ? intval($row["stock"]) : "";
												echo "<td style='text-align: center; font-size: 30pt; vertical-align: middle; $rowSelected'><strong>" . $cantidadStock . "</strong></td>";
												if ($lastBarcode != $row["unitbarcode"]){
													echo "<td class='text-center'><div><img src='". $row["image"]. "' class='d-inline-block align-top mr-3'></div></td>";
												} else {
													echo "<td style='text-align: center; font-size: 15pt; vertical-align: middle; $rowSelected'>同上</td>";
												}
												// Verifico si la fecha de vencimiento es menor a la fecha actual
												
												$days = round((strtotime($row['dueDate']) - strtotime($today))/86400);
												if($days <= 0) $dueDateColor = "color: red;";
												echo "<td style='text-align: center; font-size: 15pt; vertical-align: middle; $rowSelected; $dueDateColor'>";
													if ($_GET["checkboxBarcode"] != "true") echo $row["dueDate"];
												echo "</td>";
												$dueDateColor = "";

												echo "<td style='text-align: left; font-size: 15pt; vertical-align: middle; $rowSelected'>" . $row["name"] . "</td>";
												echo "<td style='text-align: center; font-size: 15pt; vertical-align: middle; $rowSelected'>". $row['warehouseId'] ." - ". $row['category'] . "</td>";
												// echo "<td style='text-align: center; vertical-align: middle;'>" . $row["capacity"] . "</td>";
												// echo "<td style='text-align: center; vertical-align: middle;'>" . $row["unit"] ."</td>";

												// echo "<td style='text-align: center; vertical-align: middle;'>" . $row["unitbarcode"] . "</td>";
											echo "</tr>";

											$totalProducts += 1;
											$lastBarcode = $row["unitbarcode"];
											
										}
									} else {
										echo "Error: " . $sql . "<br>" . mysqli_error($conn);
									}
								
								?>
							</tbody>
						</table>  
					
				</div>
						
				
			</div>
		</div>
		</div>
		
					
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    
        <script src="../assets/js/vendor.js"></script>
        <script src="../assets/js/adminx.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
		
    </body>
	

</html>
