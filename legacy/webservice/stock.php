<?php include "../system/db.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');
$date = date("Y-m-d");
$datetime = date("Y-m-d H:i:s");
//*********************************************************//

if ($_GET['action'] == "add") {

	$sql0 = "SELECT * FROM tasks WHERE businessId='" . $_GET['businessId'] . "' AND userId='" . $_GET['userId'] . "' AND productId=" . $_GET['productId'] . " LIMIT 1;";
	$stmt0 = mysqli_query($conn, $sql0);

	if ($stmt0) {
		$row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);
		$getCartId = $row0['id'];

		if ($getCartId != "") {
			$sql2 = "UPDATE tasks SET stock=" . $_GET['stock'] . ", description=N'" . $_GET['description'] . "' WHERE id=" . $getCartId . ";";
			$stmt2 = mysqli_query($conn, $sql2);

		} else {
			$sql2 = "INSERT INTO tasks (stock, businessId, productId, unitBarcode, userId, description) VALUES ( " . $_GET['stock'] . ", " . $_GET['businessId'] . ", " . $_GET['productId'] . ", N'" . $_GET['unitBarcode'] . "', " . $_GET['userId'] . ", '" . $_GET['description'] . "');";
			$stmt2 = mysqli_query($conn, $sql2);

		}
	}

}

//*********************************************************//

if ($_GET['action'] == "removeTask") {
	$sql = "DELETE FROM tasks WHERE id=" . $_GET['taskId'] . ";";
	$stmt = mysqli_query($conn, $sql);
}

//*********************************************************//


if ($_GET['action'] == "updateTask") {
	$sql = "UPDATE tasks SET stock=" . $_GET['stock'] . ", description=N'" . $_GET['description'] . "' WHERE id=" . $_GET['taskId'] . ";";
	$stmt = mysqli_query($conn, $sql);
}

//*********************************************************//


// if ($_GET['action']=="update"){	

// 	if (($_GET['newStatus']==1)OR($_GET['newStatus']==2)) {
// 		$sql0 = "SELECT id, requestId FROM stockLogs WHERE businessId=".$_GET['businessId']." ORDER BY requestId DESC;";  
// 		$stmt0 = mysqli_query( $conn, $sql0); 

// 		if ( $stmt0 ) {
// 			$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );
// 			if (isset($row0['requestId']))
// 				$getRequestId = $row0['requestId'] + 1;
// 			else
// 				$getRequestId = 1;
// 		}

// 		$sql3 = "SELECT * FROM orderDetails WHERE orderId=".$_GET['statusId']." ORDER BY id ASC;";  
// 		$stmt3 = mysqli_query( $conn, $sql3);

// 		if ($_GET['newStatus']==1)
// 			$type = 1; // egreso
// 		if ($_GET['newStatus']==2)
// 			$type = 0; // ingreso

// 		if ( $stmt3 ) {
// 			$sql4 = "";	
// 			while( $row3 = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC ))  { 
// 				//Si producto es uno especial, continue (no afecta stock ni nada)
// 				if($row3["unitBarcode"] == "Special"){
// 					continue;
// 				}

// 				if ($_GET['newStatus']==1) {
// 					$stock = $row3['quantity']*-1;

// 					$sql9 = "SELECT username FROM users where id = ".$_GET['userId'].";";
// 					$stmt9 = mysqli_query( $conn, $sql9);
// 					$row9 = mysqli_fetch_array( $stmt9, MYSQLI_ASSOC );

// 					$sql4.= "INSERT INTO stockLogs ( requestId, date, stock, type, businessId, warehouseId, productId, userId, orderId,description) VALUES ( ".$getRequestId.", '".$datetime."', ".$stock.", ".$type.", ".$_GET['businessId'].", ".$_GET['warehouseId'].", ".$row3['productId'].", ".$_GET['userId'].", ".$_GET['statusId'].",'".$_GET['statusId']."号订单 - 订单生成者: ".$row9['username']."');";    
// 				}
// 				if ($_GET['newStatus']==2){
// 					$stock = $row3['quantity'];
// 					//Agrego nuevo lote, nunca existe (aunque tengan la misma fecha no es el mismo lote)

// 					$sql5 = "SELECT * FROM products WHERE unitBarcode='".$row3["unitBarcode"]."' ORDER BY id DESC LIMIT 1";
// 					$stmt5 = mysqli_query( $conn, $sql5);
// 					if($stmt5){
// 						$row5 = mysqli_fetch_array( $stmt5, MYSQLI_ASSOC );

// 						$sqlGetProduct = "SELECT * FROM products WHERE unitBarcode='".$row3["unitBarcode"]."' ORDER BY id DESC LIMIT 1;";
// 						//echo "sqlGetProduct:".$sqlGetProduct;
// 						$stmtGetProduct = mysqli_query( $conn, $sqlGetProduct);

// 						if($stmtGetProduct){
// 							$rowGetProduct = mysqli_fetch_array( $stmtGetProduct, MYSQLI_ASSOC );

// 							//$sql6 = "INSERT INTO products ( businessId, sku, code, name, name2, subtitle, category, subcategory, brand, groups, currency, priceRetail, priceWholesale, packWholesale, stockCode, capacity, unit, unitBarcode, packBarcode,purchasePrice,creationDate,updateDate,dueDate,image,description,sortId,flagActive,flagMarket,flagGroup1,flagGroup2,flagGroup3,marketLimit) VALUES ( ".$rowGetProduct["businessId"].", N'".$rowGetProduct["sku"]."',N'".$rowGetProduct["code"]."', N'".$rowGetProduct["name"]."', N'".$rowGetProduct["name2"]."', N'".$rowGetProduct["subtitle"]."',N'".$rowGetProduct["category"]."', N'".$rowGetProduct["subcategory"]."', N'".$rowGetProduct["brand"]."', N'".$rowGetProduct["groups"]."',N'".$rowGetProduct["currency"]."', ".$rowGetProduct["priceRetail"].", ".$rowGetProduct["priceWholesale"].", ".$rowGetProduct["packWholesale"].",N'".$rowGetProduct["stockCode"]."', ".$rowGetProduct["capacity"].", ".$rowGetProduct["unit"].", N'".$rowGetProduct["unitBarcode"]."',N'".$rowGetProduct["packBarcode"]."',".$rowGetProduct["purchasePrice"].",'".$rowGetProduct["creationDate"]."','".$rowGetProduct["updateDate"]."','".$rowGetProduct["dueDate"]."',N'".$rowGetProduct["image"]."',N'".$rowGetProduct["description"]."',".$rowGetProduct["sortId"].",".$rowGetProduct["flagActive"].",".$rowGetProduct["flagMarket"].",".$rowGetProduct["flagGroup1"].",".$rowGetProduct["flagGroup2"].",".$rowGetProduct["flagGroup3"].",".$rowGetProduct["marketLimit"].") ";
// 							//$sql6 = "INSERT INTO products ( businessId, sku, code, name, name2, subtitle, category, subcategory, brand, groups, currency, packWholesale, stockCode, unitBarcode, packBarcode,creationDate,updateDate,dueDate,image,description,flagActive,flagMarket) VALUES ( ".$rowGetProduct["businessId"].", N'".$rowGetProduct["sku"]."',N'".$rowGetProduct["code"]."', N'".$rowGetProduct["name"]."', N'".$rowGetProduct["name2"]."', N'".$rowGetProduct["subtitle"]."',N'".$rowGetProduct["category"]."', N'".$rowGetProduct["subcategory"]."', N'".$rowGetProduct["brand"]."', N'".$rowGetProduct["groups"]."',N'".$rowGetProduct["currency"]."', ".$rowGetProduct["packWholesale"].",N'".$rowGetProduct["stockCode"]."', N'".$rowGetProduct["unitBarcode"]."',N'".$rowGetProduct["packBarcode"]."','".$rowGetProduct["creationDate"]."','".$rowGetProduct["updateDate"]."','".$rowGetProduct["dueDate"]."',N'".$rowGetProduct["image"]."',N'".$rowGetProduct["description"]."',".$rowGetProduct["flagActive"].",".$rowGetProduct["flagMarket"].") ";
// 							//$sql6 = "INSERT INTO products ( name, name2, unitBarcode) VALUES ( N'".$rowGetProduct["name"]."', N'".$rowGetProduct["name2"]."', N'".$rowGetProduct["unitBarcode"]."') ";

// 							if(isset($row3["capacity"])){
// 								$capacity = $row3["capacity"];
// 							} else {
// 								$capacity = "NULL";
// 							}
// 							$sql6 = "INSERT INTO products ( businessId, sku, code, name, name2, subtitle, category, subcategory, stockCode, unitBarcode, packBarcode,image,flagActive, unit, capacity)
// 							VALUES ( ".$_GET['businessId'].", N'".$rowGetProduct["sku"]."',N'".$rowGetProduct["code"]."', N'".$rowGetProduct["name"]."', N'".$rowGetProduct["name2"]."', N'".$rowGetProduct["subtitle"]."',N'".$rowGetProduct["category"]."', N'".$rowGetProduct["subcategory"]."', N'".$rowGetProduct["stockCode"]."', N'".$rowGetProduct["unitBarcode"]."',N'".$rowGetProduct["packBarcode"]."',N'".$rowGetProduct["image"]."',".$rowGetProduct["flagActive"].", N'".$row3["unit"]."', ".$capacity.");";

// 							echo "sql6:".$sql6;
// 							$stmt6 = mysqli_query( $conn, $sql6);
// 							if($stmt6){
// 								$sql7 = "SELECT * FROM products WHERE unitBarcode='".$row3["unitBarcode"]."' ORDER BY id DESC LIMIT 1;";
// 								echo "sql7:".$sql7;

// 								$stmt7 = mysqli_query( $conn, $sql7);
// 								if($stmt7){
// 									$row7 = mysqli_fetch_array( $stmt7, MYSQLI_ASSOC );

// 									$sku = "SKU".str_pad($row7["id"], 9, "0", STR_PAD_LEFT);
// 									$dueDateFormatted = '0000-00-00';
// 									if(isset($row3["newDueDate"]) || $row3["newDueDate"] != null){
// 										$dueDateFormatted = $row3["newDueDate"];
// 									}
// 									$sql8 = "UPDATE products SET sku='".$sku."', dueDate='".$dueDateFormatted."', packWholesale=".$rowGetProduct["packWholesale"].", creationDate='".$date."', updateDate='".$date."', image=N'".$rowGetProduct["image"]."', description=N'".$rowGetProduct["description"]."', flagActive=1, flagMarket=0 WHERE id=".$row7["id"];

// 									echo "sql8:".$sql8;
// 									$stmt8 = mysqli_query( $conn, $sql8);

// 									$sql9 = "SELECT username FROM users where id = ".$_GET['userId'].";";
// 									$stmt9 = mysqli_query( $conn, $sql9);
// 									$row9 = mysqli_fetch_array( $stmt9, MYSQLI_ASSOC );

// 									$sql4.= "INSERT INTO stockLogs ( requestId, date, stock, type, businessId, warehouseId, productId, userId, orderId,description) VALUES ( ".$getRequestId.", '".$datetime."', ".$stock.", ".$type.", ".$_GET['businessId'].", ".$_GET['warehouseId'].", ".$row7["id"].", ".$_GET['userId'].", ".$_GET['statusId'].",'".$_GET['statusId']."号订单 - 订单生成者: ".$row9["username"]."');";  
// 								}
// 							} else {
// 								echo "Murio insert";
// 							}
// 						}
// 					}
// 				}



// 					//$sql4.= "INSERT INTO stockLogs ( requestId, date, stock, type, businessId, warehouseId, productId, userId, orderId) VALUES ( ".$getRequestId.", '".$datetime."', ".$stock.", ".$type.", ".$_GET['businessId'].", ".$_GET['warehouseId'].", ".$row3['productId'].", ".$_GET['userId'].", ".$_GET['statusId'].");";  

// 			}
// 		}
// 	}

// 	$sql4.= "UPDATE orders SET status=5, flagStock=".$_GET['newStatus']." WHERE id=".$_GET['statusId'].";";
// 	$stmt4 = mysqli_multi_query( $conn, $sql4);  


// 	if ( $stmt4 ) {
// 		$_SESSION['userLog']['module']="status";
// 		$_SESSION['userLog']['description']="The order ID ".$_GET['statusId']." was changed to 5.";
// 	}



// }

//************************** Codigo optimizado de la funcion update *******************************//

if ($_GET['action'] == "update") {

	if (($_GET['newStatus'] == 1) || ($_GET['newStatus'] == 2)) {

		$sql0 = "SELECT id, requestId FROM stockLogs WHERE businessId=" . $_GET['businessId'] . " ORDER BY requestId DESC;";
		$stmt0 = mysqli_query($conn, $sql0);

		if ($stmt0) {
			$row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);
			if (isset($row0['requestId']))
				$getRequestId = $row0['requestId'] + 1;
			else
				$getRequestId = 1;
		}
		$sql1 = "SELECT * FROM orderDetails WHERE orderId=" . $_GET['statusId'] . " ORDER BY id ASC;";
		$stmt1 = mysqli_query($conn, $sql1);

		if ($_GET['newStatus'] == 1)
			$type = 1; // egreso
		if ($_GET['newStatus'] == 2)
			$type = 0; // ingreso

		if ($stmt1) {
			while ($row1 = mysqli_fetch_array($stmt1, MYSQLI_ASSOC)) {
				//Si producto es uno especial, continue (no afecta stock ni nada)
				if ($row1['unitBarcode'] == "Special") {
					continue;
				}

				if ($_GET['newStatus'] == 1) {
					$stock = $row1['quantity'] * -1;

					$sql2 = "SELECT username FROM users WHERE id = " . $_GET['userId'] . ";";
					$stmt2 = mysqli_query($conn, $sql2);
					$row2 = mysqli_fetch_array($stmt2, MYSQLI_ASSOC);

					$sql2ymedio = "SELECT businessName FROM orders WHERE id = " . $_GET['statusId'] . ";";
					$stmt2ymedio = mysqli_query($conn, $sql2ymedio);
					$row2ymedio = mysqli_fetch_array($stmt2ymedio, MYSQLI_ASSOC);

					// Obtener el warehouseId de stockLogs basado en el productId. Esto es para buscar el warehouseId de ingreso. equivalente al egreso que estoy haciendo
					$sqlWarehouse = "SELECT warehouseId FROM stockLogs WHERE productId = " . $row1['productId'] . " AND type = 0 ORDER BY id DESC LIMIT 1;";
					$stmtWarehouse = mysqli_query($conn, $sqlWarehouse);
					$rowWarehouseId = mysqli_fetch_array($stmtWarehouse, MYSQLI_ASSOC);


					$sql3 .= "INSERT INTO stockLogs ( requestId, date, stock, type, businessId, warehouseId, productId, userId, orderId,description) VALUES ( " . $getRequestId . ", '" . $datetime . "', " . $stock . ", " . $type . ", " . $_GET['businessId'] . ", " . $rowWarehouseId['warehouseId'] . ", " . $row1['productId'] . ", " . $_GET['userId'] . ", " . $_GET['statusId'] . ",'" . $_GET['statusId'] . "号订单 - 订单生成者: " . $row2['username'] . " - 给: " . $row2ymedio['businessName'] . "');";
					//echo "cambio stockLog: ".$sql3;
				}
				if ($_GET['newStatus'] == 2) {

					// Al final se inserta en stockLogs
					$stock = $row1['quantity'];

					if (isset($row1['capacity'])) {
						$capacity = $row1['capacity'];
					} else {
						$capacity = "NULL";
					}
					//Agrego nuevo lote, nunca existe (aunque tengan la misma fecha no es el mismo lote)

					$sqlGetProduct = "SELECT * FROM products WHERE unitBarcode='" . $row1["unitBarcode"] . "' ORDER BY id DESC LIMIT 1";
					$stmtGetProduct = mysqli_query($conn, $sqlGetProduct);

					if ($stmtGetProduct) {
						$rowGetProduct = mysqli_fetch_array($stmtGetProduct, MYSQLI_ASSOC);

						$sql4 = "INSERT INTO products (businessId, sku, code, name, name2, subtitle, category, subcategory, stockCode, unitBarcode, packBarcode, image, flagActive, unit, capacity)
						VALUES ( " . $_GET['businessId'] . ", NULL, N'" . $rowGetProduct["code"] . "', N'" . $rowGetProduct["name"] . "', N'" . $rowGetProduct["name2"] . "', N'" . $rowGetProduct["subtitle"] . "',N'" . $rowGetProduct["category"] . "', N'" . $rowGetProduct["subcategory"] . "', N'" . $rowGetProduct["stockCode"] . "', N'" . $rowGetProduct["unitBarcode"] . "',N'" . $rowGetProduct["packBarcode"] . "',N'" . $rowGetProduct["image"] . "'," . $rowGetProduct["flagActive"] . ",  N'" . $row3["unit"] . "', " . $capacity . ");";

						// echo "sql4:".$sql4;

						$stmt4 = mysqli_query($conn, $sql4);
						if ($stmt4) {

							$sql5 = "SELECT id FROM products WHERE unitBarcode='" . $row1["unitBarcode"] . "' AND sku IS NULL ORDER BY id DESC LIMIT 1";
							$stmt5 = mysqli_query($conn, $sql5);
							// echo "select que busca id: ".$sql5;

							if ($stmt5) {
								// echo "salio bien el select";
								$row5 = mysqli_fetch_array($stmt5, MYSQLI_ASSOC);

								// Encontrar el producto insertado para actualizarle el sku
								$sku = "SKU" . str_pad($row5["id"], 9, "0", STR_PAD_LEFT);
								$dueDateFormatted = '0000-00-00';
								if (isset($row1["newDueDate"]) || $row1["newDueDate"] != null) {
									$dueDateFormatted = $row1["newDueDate"];
								}

								$sql6 = "UPDATE products SET sku='" . $sku . "', dueDate='" . $dueDateFormatted . "', packWholesale=" . $rowGetProduct["packWholesale"] . ", creationDate='" . $date . "', updateDate='" . $date . "', image=N'" . $rowGetProduct["image"] . "', description=N'" . $rowGetProduct["description"] . "', flagActive=1, flagMarket=0 WHERE id=" . $row5["id"];

								// echo "sql6:".$sql6;
								$stmt6 = mysqli_query($conn, $sql6);

								$sql7 = "SELECT username FROM users where id = " . $_GET['userId'] . ";";
								$stmt7 = mysqli_query($conn, $sql7);
								$row7 = mysqli_fetch_array($stmt7, MYSQLI_ASSOC);

								$sql3 .= "INSERT INTO stockLogs ( requestId, date, stock, type, businessId, warehouseId, productId, userId, orderId,description) VALUES ( " . $getRequestId . ", '" . $datetime . "', " . $stock . ", " . $type . ", " . $_GET['businessId'] . ", " . $_GET['warehouseId'] . ", " . $row5["id"] . ", " . $_GET['userId'] . ", " . $_GET['statusId'] . ",'" . $_GET['statusId'] . "号订单 - 订单生成者: " . $row7["username"] . "');";
								// echo "inserto en stockLogs: ".$sql3;
							}
						} else {
							echo "Murio insert";
						}
					}
				}
			}
		}
	}

	$sql3 .= "UPDATE orders SET status=5, flagStock=" . $_GET['newStatus'] . " WHERE id=" . $_GET['statusId'] . ";";
	$stmt3 = mysqli_multi_query($conn, $sql3);
	////
	//echo "query para cambiar el estado: ".$sql3;

	$json[] = $stmt3;

	if ($stmt3) {
		$_SESSION['userLog']['module'] = "status";
		$_SESSION['userLog']['description'] = "The order ID " . $_GET['statusId'] . " was changed to 5.";
	}

	echo json_encode($json);
}

if ($_GET['action'] == "getProductStock") {
	$sqlProductStock = "SELECT name, SUM(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='" . $_GET["unitBarcode"] . "';";
	$stmtProductStock = mysqli_query($conn, $sqlProductStock);

	if ($stmtProductStock) {
		$rowProductStock = mysqli_fetch_array($stmtProductStock, MYSQLI_ASSOC);
		if ($rowProductStock["stock"] <= 50) {
			$json["type"] = "warning";
		} else {
			$json["type"] = "ok";
		}
		$json["stock"] = $rowProductStock["stock"];
		$json["product"] = $rowProductStock["name"];
	} else {
		$json["Error"] = 'Error al obtener stock y producto';
	}

	echo json_encode($json);
	exit();
}

//*********************************************************//


if ($_GET['action'] == "clean") {
	$sql = "DELETE FROM tasks WHERE userId=" . $_GET['userId'] . " AND businessId=" . $_GET['businessId'] . ";";
	$stmt = mysqli_query($conn, $sql);
}

//*********************************************************//

if ($_GET['action'] == "send") {

	$sql0 = "SELECT id, requestId FROM stockLogs WHERE businessId=" . $_GET['businessId'] . " ORDER BY requestId DESC;";
	$stmt0 = mysqli_query($conn, $sql0);

	if ($stmt0) {
		$row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);
		if (isset($row0['requestId']))
			$getRequestId = $row0['requestId'] + 1;
		else
			$getRequestId = 1;
	}

	$sql3 = "SELECT * FROM tasks WHERE userId=" . $_GET['userId'] . " AND businessId=" . $_GET['businessId'] . " ORDER BY id ASC;";
	$stmt3 = mysqli_query($conn, $sql3);

	if ($_GET['date'] == $date)
		$insertDate = $datetime;
	else
		$insertDate = $_GET['date'];

	if ($stmt3) {
		$sql4 = "";
		while ($row3 = mysqli_fetch_array($stmt3, MYSQLI_ASSOC)) {
			$sql4 .= "INSERT INTO stockLogs ( requestId, date, stock, type, businessId, warehouseId, productId, unitBarcode, userId, description) VALUES ( " . $getRequestId . ", '" . $insertDate . "', " . $row3['stock'] . ", " . $_GET['task'] . ", " . $row3['businessId'] . ", " . $_GET['warehouseId'] . ", " . $row3['productId'] . ", " . $row3['unitBarcode'] . ", " . $row3['userId'] . ", '" . $row3['description'] . "');";
		}
	}

	$sql4 .= "DELETE FROM tasks WHERE userId=" . $_GET['userId'] . " AND businessId=" . $_GET['businessId'] . ";";
	$stmt4 = mysqli_multi_query($conn, $sql4);


}
//*********************************************************//

if ($_GET['action'] == "updateAllProdsStockState") {
	$sql0 = "WITH orderProds AS (
					SELECT `unitBarcode` FROM orderdetails WHERE `orderId` = " . $_GET['orderId'] . "
				),
				totalStock AS (
					SELECT prod.`unitBarcode`, SUM(stock) OVER (PARTITION BY prod.`unitBarcode`) AS totalStock
					FROM products prod
					INNER JOIN stocklogs sl ON prod.id = sl.`productId`
					INNER JOIN orderProds op ON prod.`unitBarcode` = op.`unitBarcode`
					GROUP BY prod.`unitBarcode`
				),
				stockByDate AS (
					SELECT prod.`unitBarcode`, prod.category, prod.`minStock`, stock, ROW_NUMBER() OVER (PARTITION BY prod.`unitBarcode` ORDER BY date DESC) AS rn
					FROM products prod
					INNER JOIN stocklogs sl ON prod.id = sl.`productId`
					INNER JOIN orderProds op ON prod.`unitBarcode` = op.`unitBarcode`
					AND sl.stock > 0
				)
			SELECT sbd.`unitBarcode`, sbd.category, sbd.stock, SUM(stock) AS sumIncome, totalStock, sbd.`minStock`
			FROM totalStock ts
			INNER JOIN stockByDate sbd ON ts.`unitBarcode` = sbd.`unitBarcode`
			WHERE rn <= 2 AND sbd.category NOT IN ('GOLOSINAS', 'BEBIDAS')
			GROUP BY sbd.`unitBarcode`, totalStock
			ORDER BY sbd.`unitBarcode`ASC;";

	$stmt0 = mysqli_query($conn, $sql0);

	$sql1 = "SELECT `unitBarcode`, quantity FROM orderDetails WHERE orderId=" . $_GET['orderId'] . " ORDER BY id ASC;";

	$stmt1 = mysqli_query($conn, $sql1);

	if ($stmt1) {
		while ($row1 = mysqli_fetch_array($stmt1, MYSQLI_ASSOC)) {
			$json[$row1['unitBarcode']] = $row1['quantity'];
		}

	}

	// valida que el stock total actual es menor o igual al minimo de stock
	//$row0['minStock'] != 0 && ($row0['totalStock'] <= $row0['minStock'] || 

	// valida que la cantidad egresada es mayor o igual al 40% del stock total previo al egreso
	// valida que el stock total actual es menos del 60% de la suma de los ultimos dos ingresos
	if ($stmt0) {
		while ($row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC)) {
			if (
				($json[$row0['unitBarcode']] >= (($row0['totalStock'] + $json[$row0['unitBarcode']]) * 0.4)) ||
				($row0['sumIncome'] != 0 && $row0['totalStock'] < ($row0['sumIncome'] * 0.6))
			) {
				$unitBarcodes[] = $row0['unitBarcode'];
			}
		}
	}

	$sql2 = "UPDATE products SET lowStock=1 WHERE unitBarcode IN (";

	for ($i = 0; $i < count($unitBarcodes); $i++) {
		if ($i < count($unitBarcodes) - 1)
			$sql2 .= "'" . $unitBarcodes[$i] . "', ";
		else
			$sql2 .= "'" . $unitBarcodes[$i] . "'";
	}

	$sql2 .= ");";
	$stmt2 = mysqli_query($conn, $sql2);

	echo json_encode($unitBarcodes);

}

//*********************************************************//

if ($_GET['action'] == "updateProdStockState") {

	$sql1 = "UPDATE products SET lowStock=" . $_GET['stockState'] . " WHERE unitBarcode = '" . $_GET['unitBarcode'] . "' AND flagActive = 1;";
	echo $sql1;
	$stmt1 = mysqli_query($conn, $sql1);
	$json['status'] = $stmt1;
	echo json_encode($json);
}




/*

if ($_GET['action']=="import")
{	
$sql = "SELECT products.id, products.code, products.name, products.category, products.subcategory, products.brand, products.packWholesale, stkItem.linkProductId FROM products FULL JOIN stkItem ON products.id=stkItem.linkProductId WHERE products.businessId=".$_GET['businessId']." ORDER BY products.id ASC;";  
$stmt = mysqli_query( $conn, $sql);  	

if ( $stmt ) {
$sql2 = "";	
$item = 0;

while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
{  
	if ($row['linkProductId']=="")
	{
		$sql2.= "INSERT INTO stkItem ( businessId, linkProductId, code, pack, name, category, subcategory, brand, dateCreated, dateUpdated) VALUES ( ".$_GET['businessId'].", ".$row['id'].", '".$row['code']."', ".$row['packWholesale'].", '".$row['name']."', '".$row['category']."', '".$row['subcategory']."', '".$row['brand']."', '".$date."', '".$date."');"; 
		$item = $item + 1 ;
	}
}

$stmt2 = mysqli_query( $conn, $sql2); 

if ( $stmt2 ) {

$_SESSION['notification']['type']="info";
$_SESSION['notification']['message']="Items imported: ".$item;
	
}	
}
}

*/

?>