<?php 
include "../system/db.php"; 
date_default_timezone_set('America/Argentina/Buenos_Aires');


//**************************************************//

if($_GET['action']=="addSpecialProduct"){
	$sql="INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate) VALUE ( ".$_GET["orderId"].", NULL, NULL, N'".$_GET["unitBarcode"]."', N'', N'Special', N'', 1, 1,NULL);";
	$stmtInsertSpecialProd = mysqli_query( $conn, $sql); 
	
	if($stmtInsertSpecialProd){
		// $_SESSION['notification']['type']="success";
		// $_SESSION['notification']['message']="Special product created properly";
        $json["type"] = "success";
        $json["message"] = "Special product created properly";
		
	} else {
		// $_SESSION['notification']['type']="error";
		// $_SESSION['notification']['message']="Special product was not created properly";
        $json["type"] = "error";
        $json["message"] = "Special product was not created properly";
	}
    echo json_encode($json);

	// header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$_GET['orderId']);
	exit();
}

if($_GET['action']=="updateOrderWarehouseId") {
	$sql="UPDATE orders SET warehouseId=".$_GET["warehouseId"]." WHERE id=".$_GET['orderId'].";";
	$stmtUpdateOrderWarehouseId = mysqli_query($conn, $sql);

	if($stmtUpdateOrderWarehouseId){
		$json["type"] = "success";
		$json["message"] = "Se actualizo el deposito correctamente";
		
	} else {
		$json["type"] = "error";
		$json["message"] = "No se actualizo el deposito correctamente";
	}
	echo json_encode($json);
	exit();

}

if($_GET['action']=="updateSpecialProdQuantity") {
	$sql="UPDATE orderDetails SET quantity=".$_GET["quantity"]." WHERE id=".$_GET['productId'].";";
	$stmtUpdateSpecialProdQty = mysqli_query($conn, $sql);

	if($stmtUpdateSpecialProdQty){
        $json["type"] = "success";
        $json["message"] = "Special product quantity update properly";
		
	} else {
        $json["type"] = "error";
        $json["message"] = "Special product was not update properly";
	}
	echo json_encode($json);
	exit();
}

//**************************************************//

if ($_GET['action']=="updateQuantity"){
	//Esto seera descomentado en breve(?)
	
	// if($_GET['action'] == 'out'){
	// 	$userQty = $_GET['quantity'];
	
	// 	$sqlStock = "SELECT products.*, SUM(stockLogs.stock) AS stock FROM products AS products INNER JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$_GET["unitBarcode"]."' GROUP BY products.id ORDER BY products.dueDate ASC;";
	// 	$stmtStock = mysqli_query( $conn, $sqlStock); 
	// 	$row_cnt = mysqli_num_rows($stmtStock);
	// 	$sqlTotalStock = "SELECT  SUM(stockLogs.stock) AS stock FROM products AS products INNER JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$_GET["unitBarcode"]."' ORDER BY products.dueDate ASC;";
	// 	$stmtTotalStock = mysqli_query( $conn, $sqlStock); 
	// 	$rowTotalStock = mysqli_fetch_array( $stmtTotalStock, MYSQLI_ASSOC );
	
	// 	if($row_cnt == 0 || $userQty > $rowTotalStock["stock"]){
	// 		$_SESSION['notification']['type']="error";
	// 		$_SESSION['notification']['message']="No Stock";
	
	// 	} else {
	// 		$sql1 = "DELETE FROM orderDetails WHERE unitBarcode='".$_GET["unitBarcode"]."' AND orderId=".$_GET['orderId'].";";
	// 		$stmt1 = mysqli_query( $conn, $sql1);
	// 		if ($stmt1) {
	// 			$quantity = $userQty;
	// 			$stockUsed = 0;
	// 			while($rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC )){
	// 				//echo "quantity:".$quantity;
	// 				//echo "rowstock:".$rowStock['stock'];
	// 				if($quantity <= 0){
	// 					break;
	// 				}
	// 				if($quantity > $rowStock['stock']){
	// 					$quantity = $rowStock['stock'];
	// 					$stockUsed += $rowStock['stock'];
	// 				} else {
	// 					$stockUsed += $quantity;
	// 				}
	// 				//echo "rowstock:".$stockUsed;
	// 				$sql3 = "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate) VALUE ( ".$_GET['orderId'].", ".$rowStock['id'].", N'".$rowStock['sku']."', N'".$rowStock['name']."', N'".$rowStock['name2']."', N'".$rowStock['unitBarcode']."', N'".$rowStock['image']."', ".$rowStock['packWholesale'].", ".$quantity.",'".$rowStock['dueDate']."');";
	// 				$stmt3 = mysqli_query( $conn, $sql3);
	// 				$quantity = $userQty - $stockUsed;
	// 				//echo "sql:".$sql3;
	// 			}
	// 		}
	// 	}

	// } else {
	// 	// caso in
	// 	//Get de total de cantidad del prod (todos los lotes)
	// 	$sqlTotalQty = "SELECT SUM(quantity) as totalQty from orderDetails WHERE unitBarcode = '".$_GET["unitBarcode"]."' and orderId=".$_GET["orderId"];
	// 	$stmtTotalQty = mysqli_query( $conn, $sqlQty); 
	// 	if($stmtTotalQty){
	// 		$rowTotalQty = mysqli_fetch_array( $stmtTotalQty, MYSQLI_ASSOC );
	// 		if($rowTotalQty["totalQty"] < $_GET["quantity"]){

	// 		} else {

	// 		}
	// 	}
	// 	// si total de cantidad < quantity nueva del usuario: quantity del usuario - el total de cantidad
	// 	// si total de cantidad > quantity nueva del usuario: quantity del usuario - el total de cantidad
	// 	// caso == rebotamos al usuario a la vista, no va a cambiar la cantidad por el mismo valor
	// 	// la dif va en un nuevo lote sin fecha
	// }

	// header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$_GET['id']);
	exit();	
	
	
}

//OUT
if ($_GET['action'] == "addProductOut") {

	$unitBarcode = $_GET['unitBarcode'];
	$orderId = $_GET['orderId'];
	$flagTargetInOut = 1;

	$sqlStock = "SELECT products.id, products.name, products.name2, products.sku, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock, products.unit, products.capacity, products.packBarcode FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$_GET["unitBarcode"]."' GROUP BY products.id HAVING stock > 0 ORDER BY products.dueDate, products.id ASC;";
	$stmtStock = mysqli_query( $conn, $sqlStock); 
	// echo "sqlstock:". $sqlStock;
	$rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC );
	$rowStockNumRows = mysqli_num_rows($stmtStock);

	if($rowStockNumRows == 0) {
		$_SESSION['notification']['type']="error";
		$_SESSION['notification']['message']="Product does not exist or no stock available";//Solucion rapida por el momento, dsp dividir no stock de no existe
		
		$json["type"] = "error";
		$json["message"] = "Product does not exist or no stock available";
		echo json_encode($json);
		exit();

	} 
	//Obtengo cantidad de cada producto en base a dueDate y unitBarcode
	$sql1 = "SELECT od.productName, od.productId, SUM(od.quantity) as quantity, od.newDueDate, o.flagInOut FROM orderDetails as od INNER JOIN orders as o ON od.orderId = o.id WHERE od.unitBarcode='".$unitBarcode."'  AND o.flagInOut = ".$flagTargetInOut." AND o.flagStock = 0 GROUP BY od.newDueDate, od.unitBarcode, od.productId ORDER BY newDueDate, od.productId ASC;"; 
	// echo "sql details:". $sql1;
	$stmt1= mysqli_query( $conn, $sql1); 
	$rowStockOrderDetails = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );
	$rowStockOrderDetailsNumRows = mysqli_num_rows($stmt1);

	//obtendo los products id del pedido actual para usarla dsp en el while
	$sql2 = "SELECT productId FROM orderDetails WHERE orderId = ".$orderId." AND unitBarcode = '".$unitBarcode."';";
	$stmt2= mysqli_query( $conn, $sql2); 
	$stmt2_numrows = mysqli_num_rows($stmt2);
	while ($row2 = mysqli_fetch_array($stmt2,MYSQLI_ASSOC)){
		$detailsProductId[] = $row2['productId'];
	}
	
	// $finalDate;
	$flagIsUpdateOrInsert;
	

	//Caso que no tengo el producto en details y estoy en out
	if($rowStockOrderDetailsNumRows == 0){
		// echo "Cond 0";
		$flagIsUpdateOrInsert = "insert";
		$productData = $rowStock;
		// $finalDate = $rowStock["dueDate"];
		// $productId = $rowStock["id"];

	//Caso que tengo producto en details y tengo que ver si tengo lleno el lote o no para ver si agrego en el mismo lote o en otro
	} else {
		// do {
		// 	print_r($rowStock);
		// 	print_r($rowStockOrderDetails);
		// 	if($rowStock["dueDate"] < $rowStockOrderDetails["newDueDate"]){
		// 		echo "Cond 1";
		// 		// $finalDate = $rowStock["dueDate"];
		// 		// $productId = $rowStock["id"];
		// 		$productData = $rowStock;
		// 		$flagIsUpdateOrInsert="insert";
		// 		break;
		// 	}
		// 	if($rowStock["dueDate"] > $rowStockOrderDetails["newDueDate"]){
		// 		echo "Cond 2";
		// 		$rowStockOrderDetails = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );
		// 		if(!$rowStockOrderDetails){
		// 			echo "Cond 5";
		// 			// $finalDate = $rowStock["dueDate"];
		// 			// $productId = $rowStock["id"];
		// 			$productData = $rowStock;
		// 			$flagIsUpdateOrInsert="insert";
		// 			break;
		// 		}
		// 		continue;
		// 	}
		// 	if($rowStock["dueDate"] == $rowStockOrderDetails["newDueDate"] && $rowStock["stock"] <= $rowStockOrderDetails["quantity"]){
		// 		echo "Cond 3";
		// 		// echo "stockrow:";
		// 		// print_r($rowStock);
		// 		// echo "orderdetailsrow:";
		// 		// print_r($rowStockOrderDetails);

		// 		$rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC );
		// 		$rowStockOrderDetails = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );
		// 		// print_r($rowStockOrderDetails);
		// 		if(!$rowStockOrderDetails && $rowStock){
		// 			echo "Cond 6";
		// 			// $finalDate = $rowStock["dueDate"];
		// 			// $productId = $rowStock["id"];
		// 			$productData = $rowStock;
		// 			$flagIsUpdateOrInsert="insert";
		// 			break;
		// 		} 
		// 		continue;
		// 	}
			
		// 	if($rowStock["dueDate"] == $rowStockOrderDetails["newDueDate"] && $rowStock["stock"] > $rowStockOrderDetails["quantity"]){
		// 		echo "Cond 4";
		// 		// echo "stockrow:";
		// 		// print_r($rowStock);
		// 		// echo "orderdetailsrow:";
		// 		// print_r($rowStockOrderDetails);
		// 		// $finalDate = $rowStock["dueDate"];
		// 		// $productId = $rowStock["id"];

		// 		$productData = $rowStock;
		// 		if($stmt2_numrows == 0){
		// 			//caso NO hay rows de este prod en este pedido de details
		// 			$flagIsUpdateOrInsert="insert";
		// 		} else {
		// 			$flagIsUpdateOrInsert="update";	
		// 		}
		// 		break;
		// 	}
		// } while ($rowStock && $rowStockOrderDetails);

		do {
			// print_r($rowStock);
			// print_r($rowStockOrderDetails);
			if($rowStock["id"] < $rowStockOrderDetails["productId"]){
				// echo "Cond 1";
				$productData = $rowStock;
				$flagIsUpdateOrInsert="insert";
				break;
			}
			if($rowStock["id"] > $rowStockOrderDetails["productId"]){
				// echo "Cond 2";
				$rowStockOrderDetails = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );
				if(!$rowStockOrderDetails){
					// echo "Cond 5";
					$productData = $rowStock;
					$flagIsUpdateOrInsert="insert";
					break;
				}
				continue;
			}
			if($rowStock["id"] == $rowStockOrderDetails["productId"] && $rowStock["stock"] <= $rowStockOrderDetails["quantity"]){
				// echo "Cond 3";
				// echo "stockrow:";
				// print_r($rowStock);
				// echo "orderdetailsrow:";
				// print_r($rowStockOrderDetails);

				$rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC );
				$rowStockOrderDetails = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );
				// print_r($rowStockOrderDetails);
				if(!$rowStockOrderDetails && $rowStock){
					// echo "Cond 6";
					$productData = $rowStock;
					$flagIsUpdateOrInsert="insert";
					break;
				} 
				continue;
			}
			
			if($rowStock["id"] == $rowStockOrderDetails["productId"] && $rowStock["stock"] > $rowStockOrderDetails["quantity"]){
				//El lote tiene espacio disponible
				// echo "Cond 4";
				// echo "stockrow:";
				// print_r($rowStock);
				// echo "orderdetailsrow:";
				// print_r($rowStockOrderDetails);

				$productData = $rowStock;
				if(!$detailsProductId || !in_array($productData['id'],$detailsProductId)){
					//caso NO existe el lote de este prod en este pedido de details
					$flagIsUpdateOrInsert="insert";
				} else {
					$flagIsUpdateOrInsert="update";	
				}
				break;
			}
		} while ($rowStock && $rowStockOrderDetails);
	}
	
	if(!isset($productData)){
		// echo "no fd, out";
		$json["type"] = "error";
		$json["message"] = "No Stock. Max: ".$rowStock['stock'];
		echo json_encode($json);	
		exit();
	}

	if($flagIsUpdateOrInsert=="update"){
		// Aumentar quantity de lote en caso de dueDate nulo
		// echo "en update\n";
		// print_r($productData);
		// if($finalDate == '0000-00-00'){
		// 	// $sqlGetProductId = "SELECT * FROM products WHERE unitBarcode='".$unitBarcode."' AND (dueDate='0000-00-00' OR dueDate IS NULL)";//Caso particulares que no son fechas validas
		// 	// $stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
		// 	$sqlGetProductId = "SELECT * FROM orderDetails WHERE unitBarcode='".$unitBarcode."' AND orderId=".$orderId." AND newDueDate='0000-00-00';";//Caso particulares que no son fechas validas
		// 	// echo "sqlgetprod:". $sqlGetProductId;
		// 	$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
		// 	if($stmtGetProductId){
		// 		$rowGetProductId = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
		// 		if(isset($productId)){
		// 			$sql3= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND productId='".$productId."' AND orderId=".$orderId.";";
		// 		} else {
		// 			echo "entre al else de prodid";
		// 			$sql3= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND productId='".$rowGetProductId["productId"]."' AND orderId=".$orderId.";";
		// 		}
		// 		// echo "sql update:". $sql3;
		// 		$stmt3 = mysqli_query( $conn, $sql3);
		// 		if($stmt3){
		// 			$json["type"] = "success";
		// 			$json["message"] = "The status was updated properly 1";
		// 			echo json_encode($json);
		// 		} else {
		// 			$json["type"] = "error";
		// 			$json["message"] = "The status was not updated properly 1";
		// 			echo json_encode($json);
		// 		}
		// 		exit();
		// 	}
		// } else {
		// 	$finalDate = date("Y-m-d",strtotime($finalDate));

		// 	$sql3= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND newDueDate='".$finalDate."' AND orderId=".$orderId.";"; 
		// 	$stmt3 = mysqli_query( $conn, $sql3); 
			
		// 	// echo $sql3;
			
		// 	if ( $stmt3 ) {
		// 		$json["type"] = "success";
		// 		$json["message"] = "The status was updated properly 2";
		// 	} else {
		// 		$json["type"] = "error";
		// 		$json["message"] = "Product list connection error 2";
		// 	}
		// 	echo json_encode($json);
		// 	exit();
		// }
		$sql3= "UPDATE orderDetails SET quantity=quantity+1 WHERE productId='".$productData['id']."' AND orderId=".$orderId.";";
		// echo "sql update:". $sql3;
		$stmt3 = mysqli_query( $conn, $sql3);
		if($stmt3){
			$json["type"] = "success";
			$json["message"] = "The status was updated properly 1";
			echo json_encode($json);
		} else {
			$json["type"] = "error";
			$json["message"] = "The status was not updated properly 1";
			echo json_encode($json);
		}
		exit();
	}

	if($flagIsUpdateOrInsert == "insert"){
		//echo "en insert";
		
		//Obtiene el producto en base al unit barcode (pueden ser mas de 1)
		// $sqlGetProductId = "SELECT products.id, products.name, products.name2,products.sku, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock, products.unit, products.capacity FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$unitBarcode."' GROUP BY products.id HAVING stock > 0 ORDER BY products.dueDate ASC;";
		// // echo "getprod:". $sqlGetProductId;
		// $stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
		// if ( $stmtGetProductId ) {
		// 	//echo "en insert dentro";
		// 	$row1 = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
		// aca va el codigo que puse abajo
		// } else {
		// 	$json["type"] = "error";
		// 	$json["message"] = "Product list connection error";
		// };

		
		// if(isset($finalDate) && $finalDate != '0000-00-00'){
		// 	$dateInsert = $finalDate;
		// } else {
		// 	$dateInsert = $productData['dueDate'];
		// }

		if(isset($productData["capacity"]) && $productData["capacity"] != ""){
			$capacity = $productData["capacity"];
		} else {
			$capacity = "NULL";
		}
		// echo "prod data:";
		// print_r($productData);

		$sql4= "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate, unit, capacity, packBarcode) VALUE ( ".$orderId.", ".$productData['id'].", N'".$productData['sku']."', N'".$productData['name']."', N'".$productData['name2']."', N'".$productData['unitBarcode']."', N'".$productData['image']."', ".$productData['packWholesale'].", 1,'".$productData['dueDate']."', N'".$productData["unit"]."', ".$capacity.",'".$productData['packBarcode']."');"; 
		$stmt4 = mysqli_query( $conn, $sql4);
		// echo "insert tamos por aca:". $sql4;
		if ( $stmt4 ) {
			$json["type"] = "success";
			$json["message"] = "The status was updated properly 3";
		} else {
			$json["type"] = "error";
			$json["message"] = "The status was not updated properly 3";
		};
	}
	echo json_encode($json);
	exit();

}

//IN

if($_GET['action'] == "addProductIn") {
	//echo "entre al addProd";
	$unitBarcode = $_GET['unitBarcode'];
	$orderId = $_GET['orderId'];
	$flagTargetInOut = 0;

	$sqlStock = "SELECT products.id, products.name, products.name2, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock, products.packBarcode FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$unitBarcode."' GROUP BY products.id ORDER BY products.dueDate ASC;";
	$stmtStock = mysqli_query( $conn, $sqlStock); 
	//echo "sqlstock:". $sqlStock;
	// $rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC );
	$rowStockNumRows = mysqli_num_rows($stmtStock);

	if($rowStockNumRows == 0) {
		//echo "Caso producto nuevo ej codigo A1";
		$json["type"] = "newProduct";
		$json["route"] = "../stock/itemList.php?formStatus=create&target=".$_GET['target']."&unitBarcode=".$unitBarcode."&orderId=".$orderId;
		echo json_encode($json);	
		exit();
	}

	// $sql1 = "SELECT od.productName, od.productId, SUM(od.quantity) as quantity, od.newDueDate, o.flagInOut FROM orderDetails as od INNER JOIN orders as o ON od.orderId = o.id WHERE od.unitBarcode='".$unitBarcode."'  AND o.flagInOut = ".$flagTargetInOut." AND o.flagStock = 0 AND orderId =".$orderId." GROUP BY od.newDueDate, od.unitBarcode, od.productId ORDER BY newDueDate, od.productId ASC;"; 

	// $stmt1= mysqli_query( $conn, $sql1); 
	// $rowStockOrderDetails = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );
	// $rowStockOrderDetailsNumRows = mysqli_num_rows($stmt1);

	// echo "verifico si existe el producto en orderDetails en base al unitBarcode: ".$sql1;

	// $sql2= "SELECT newDueDate FROM orderDetails WHERE orderId=".$orderId." AND unitBarcode='".$unitBarcode."';";
	// $stmt2 = mysqli_query( $conn, $sql2 );
	// $row2=mysqli_fetch_array( $stmt2, MYSQLI_ASSOC);

	// echo "buscando si existe el producto en orderDetails: ".$sql2;

	//Caso insert
	$sqlGetProductId = "SELECT products.id, products.name, products.name2, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock, products.unit, products.capacity, products.packBarcode FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$unitBarcode."' GROUP BY products.id ORDER BY products.dueDate ASC;";
	// echo "obtengo producto en base al unitBarcode:". $sqlGetProductId;

	$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
	if($stmtGetProductId){
		$rowProductInfo = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
		
		if(isset($rowProductInfo["capacity"])){
			$capacity = $rowProductInfo["capacity"];
		} else {
			$capacity = "NULL";
		}
		$sql3= "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate, unit, capacity, packBarcode) VALUE ( ".$orderId.", ".$rowProductInfo['id'].", NULL, N'".$rowProductInfo['name']."', N'".$rowProductInfo['name2']."', N'".$rowProductInfo['unitBarcode']."', N'".$rowProductInfo['image']."', ".$rowProductInfo['packWholesale'].", 1,NULL, N'".$rowProductInfo["unit"]."', ".$capacity.",'".$rowProductInfo['packBarcode']."');"; 
		$stmt3 = mysqli_query( $conn, $sql3);
		
		// echo "haciendo el insert de nuevo lote: ".$sql3;
		if ( $stmt3 ) {
			$_SESSION['notification']['type']="success";
			$_SESSION['notification']['message']="The status was updated properly.";
			$json["type"] = "success";
			$json["message"] = "The status was updated properly 1";
			// echo "Hola entre 2 veces?";
		} else {
			$_SESSION['notification']['type']="error";
			$_SESSION['notification']['message']="The status was not updated properly";
			$json["type"] = "error";
			$json["message"] = "The status was not updated properly";
		};
		if(!isset($_GET["fromCreateProduct"])){
			echo json_encode($json);
		} else {
			header ("Location: ../market/orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);
		}
	}
	exit();

	// do{
	// 	if( $rowStockOrderDetailsNumRows == 0 || $row2['newDueDate'] != ""){
	// 		//Caso insert
	// 		$sqlGetProductId = "SELECT products.id, products.name, products.name2, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock, products.unit, products.capacity FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$unitBarcode."' GROUP BY products.id ORDER BY products.dueDate ASC;";
	// 		// echo "obtengo producto en base al unitBarcode:". $sqlGetProductId;
	// 		$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
	// 		if($stmtGetProductId){
	// 			$rowProductInfo = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
				
	// 			if(isset($rowProductInfo["capacity"])){
	// 				$capacity = $rowProductInfo["capacity"];
	// 			} else {
	// 				$capacity = "NULL";
	// 			}
	// 			$sql3= "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate, unit, capacity) VALUE ( ".$orderId.", ".$rowProductInfo['id'].", NULL, N'".$rowProductInfo['name']."', N'".$rowProductInfo['name2']."', N'".$rowProductInfo['unitBarcode']."', N'".$rowProductInfo['image']."', ".$rowProductInfo['packWholesale'].", 1,NULL, N'".$rowProductInfo["unit"]."', ".$capacity.");"; 
	// 			$stmt3 = mysqli_query( $conn, $sql3);
				
	// 			// echo "haciendo el insert de nuevo lote: ".$sql3;
	// 			if ( $stmt3 ) {
	// 				$_SESSION['notification']['type']="success";
	// 				$_SESSION['notification']['message']="The status was updated properly.";
	// 				$json["type"] = "success";
	// 				$json["message"] = "The status was updated properly 1";
	// 				// echo "Hola entre 2 veces?";
	// 			} else {
	// 				$_SESSION['notification']['type']="error";
	// 				$_SESSION['notification']['message']="The status was not updated properly";
	// 				$json["type"] = "error";
	// 				$json["message"] = "The status was not updated properly";
	// 			};
	// 			if(!isset($_GET["fromCreateProduct"])){
	// 				echo json_encode($json);
	// 				exit();
	// 			}
	// 		}

	// 		break;
	// 	} else {
	// 		// Caso update
	// 		$sql4= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND orderId=".$orderId." AND newDueDate IS NULL;"; 
	// 		$stmt4 = mysqli_query( $conn, $sql4); 
			
	// 		// echo $sql4;
			
	// 		if ( $stmt4 ) {
	// 			$_SESSION['notification']['type']="success";
	// 			$_SESSION['notification']['message']="The status was updated properly.";
	// 			$json["type"] = "success";
	// 			$json["message"] = "The status was updated properly 2";
	// 			echo json_encode($json);
	// 			exit();
	// 		} else {
	// 			$_SESSION['notification']['type']="error";
	// 			$_SESSION['notification']['message']="The status was not updated properly";
	// 			$json["type"] = "error";
	// 			$json["message"] = "The status was not updated properly";
	// 			echo json_encode($json);
	// 			exit();
	// 		};
	// 		break;
	// 	};
	// }
	// while( $row2=mysqli_fetch_array( $stmt2, MYSQLI_ASSOC) );
	
	// if(isset($_GET["fromCreateProduct"])){
	// 	header ("Location: ../market/orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);
	// 	exit();
	// }
		
	// $sql5 = "SELECT id FROM orderDetails WHERE orderId = ".$orderId." AND unitBarcode = '".$unitBarcode."';";
	// $stmt5= mysqli_query( $conn, $sql5); 
	// $stmt5_numrows = mysqli_num_rows($stmt5);

	
	// $finalDate;
	// $flagIsUpdateOrInsert;

	// Aumentar quantity de lote en caso de dueDate nulo
	// if($finalDate == '0000-00-00'){
	// 	if($flagIsUpdateOrInsert=="update"){
	// 		// $sqlGetProductId = "SELECT * FROM products WHERE unitBarcode='".$unitBarcode."' AND (dueDate='0000-00-00' OR dueDate IS NULL)";//Caso particulares que no son fechas validas
	// 		// $stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
	// 		$sqlGetProductId = "SELECT * FROM orderDetails WHERE unitBarcode='".$unitBarcode."' AND orderId=".$orderId." AND newDueDate='0000-00-00';";//Caso particulares que no son fechas validas
	// 		// echo "sqlgetprod:". $sqlGetProductId;
	// 		$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
	// 		if($stmtGetProductId){
	// 			$rowGetProductId = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
	// 			if(isset($productId)){
	// 				$sql6= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND productId='".$productId."' AND orderId=".$orderId.";";
	// 			} else {
	// 				$sql6= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND productId='".$rowGetProductId["productId"]."' AND orderId=".$orderId.";";
	// 			}
	// 			// echo "sql update:". $sql6;
	// 			$stmt6 = mysqli_query( $conn, $sql6);
	// 			if($stmt6){
	// 				$json["type"] = "success";
	// 				$json["message"] = "The status was updated properly 3";
	// 				echo json_encode($json);
	// 			} else {
	// 				$json["type"] = "error";
	// 				$json["message"] = "The status was not updated properly";
	// 				echo json_encode($json);
	// 			}
	// 			exit();
	// 		}
	// 	}
	// } 
	// else {
	// 	$finalDate = date("Y-m-d",strtotime($finalDate));

	// 	if($flagTargetInOut==1 && $flagIsUpdateOrInsert=="update"){
	// 		// echo "en update";
	
	// 		$sql6= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND newDueDate='".$finalDate."' AND orderId=".$orderId.";"; 
			
	// 		$stmt6 = mysqli_query( $conn, $sql6); 
			
	// 		// echo $sql6;
			
	// 		if ( $stmt2 ) {
	// 			$_SESSION['notification']['type']="success";
	// 			$_SESSION['notification']['message']="The status was updated properly.";
	// 			$json["type"] = "success";
	// 			$json["message"] = "The status was updated properly 4";
	// 		} else {
	// 			$_SESSION['notification']['type']="error";
	// 			$_SESSION['notification']['message']="The status was not updated properly";
	// 			$json["type"] = "error";
	// 			$json["message"] = "Product list connection error";
	// 		}
	// 		echo json_encode($json);
	// 		// header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);	
	// 		exit();
	// 	}

	// }
	// echo json_encode($json);
	// exit();
}	



//***************************************// ADD PRODUCT VIEJO //**************************************/

// if ($_GET['action']=="addProduct"){	

// 	$flagTargetInOut;
// 	if($_GET['target'] == "out"){
// 		$flagTargetInOut = 1;
// 	}
// 	if($_GET['target'] == "in"){
// 		$flagTargetInOut = 0;
// 	}

// 	$unitBarcode = $_GET['unitBarcode'];
// 	$orderId = $_GET['orderId'];

// 	//Stock en base a product (barcode) y fecha (dueDate).
// 	if($flagTargetInOut == 1){
// 		$sqlStock = "SELECT products.id, products.name, products.name2, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$_GET["unitBarcode"]."' GROUP BY products.id HAVING stock > 0 ORDER BY products.dueDate, products.id ASC;";
// 	}
// 	if($flagTargetInOut == 0){
// 		$sqlStock = "SELECT products.id, products.name, products.name2, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$_GET["unitBarcode"]."' GROUP BY products.id ORDER BY products.dueDate ASC;";
// 	}
// 	$stmtStock = mysqli_query( $conn, $sqlStock); 
// 	// echo "sqlstock:". $sqlStock;
// 	$rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC );
// 	$rowStockNumRows = mysqli_num_rows($stmtStock);
// 	// echo "numrows rowstock:". $rowStockNumRows;

// 	if($rowStockNumRows == 0){
// 		// echo "entro rowstock == 0:";
// 		if($flagTargetInOut == 1){
// 			// echo "entro flagtargetinout 1";
// 			$_SESSION['notification']['type']="error";
// 			$_SESSION['notification']['message']="Product does not exist or no stock available";//Solucion rapida por el momento, dsp dividir no stock de no existe
            
//             $json["type"] = "error";
//             $json["message"] = "Product does not exist or no stock available";
//             echo json_encode($json);
// 			exit();
// 		}
// 		if($flagTargetInOut == 0){
// 			// echo "Caso producto nuevo ej codigo A1";
// 			$json["type"] = "newProduct";
//             $json["route"] = "../stock/itemList.php?formStatus=create&target=".$_GET['target']."&unitBarcode=".$unitBarcode."&orderId=".$orderId;
//             echo json_encode($json);	
// 			exit();
// 		}


// 	} else {
// 		//Obtengo cantidad de cada producto en base a dueDate y unitBarcode
// 		$sql3 = "SELECT od.productName, od.productId, SUM(od.quantity) as quantity, od.newDueDate, o.flagInOut FROM orderDetails as od INNER JOIN orders as o ON od.orderId = o.id WHERE od.unitBarcode='".$unitBarcode."'  AND o.flagInOut = ".$flagTargetInOut." AND o.flagStock = 0  "; 
// 		if($flagTargetInOut == 0){
// 			//Caso update de un ingreso, solo me interesa el order actual
// 			$sql3.=" AND orderId =".$orderId;
// 		}
// 		$sql3.= " GROUP BY od.newDueDate, od.unitBarcode, od.productId ORDER BY newDueDate, od.productId ASC;";
// 		// echo "sql3:". $sql3;
// 		$stmt3= mysqli_query( $conn, $sql3); 
// 		$rowStockOrderDetails = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC );
// 		$rowStockOrderDetailsNumRows = mysqli_num_rows($stmt3);
// 		// echo "numrows order details:". $rowStockOrderDetailsNumRows;

// 		if($flagTargetInOut == 0){
	
// 			$sql7= "SELECT newDueDate FROM orderDetails WHERE orderId=".$orderId." AND unitBarcode='".$unitBarcode."';";
// 			$stmt7 = mysqli_query( $conn, $sql7 );
// 			$row7=mysqli_fetch_array( $stmt7, MYSQLI_ASSOC);
			
// 			// echo "sql7:". $sql7;
// 			do{
// 				if( $rowStockOrderDetailsNumRows == 0 || $row7['newDueDate'] != ""){
// 					//Caso insert
// 					$sqlGetProductId = "SELECT products.id, products.name, products.name2, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock, products.unit, products.capacity FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$unitBarcode."' GROUP BY products.id ORDER BY products.dueDate ASC;";
// 					// echo "getprod:". $sqlGetProductId;
// 					$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
// 					if($stmtGetProductId){
// 						$rowProductInfo = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
						
// 						if(isset($rowProductInfo["capacity"])){
// 							$capacity = $rowProductInfo["capacity"];
// 						} else {
// 							$capacity = "NULL";
// 						}
// 						$sql5= "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate, unit, capacity) VALUE ( ".$orderId.", ".$rowProductInfo['id'].", NULL, N'".$rowProductInfo['name']."', N'".$rowProductInfo['name2']."', N'".$rowProductInfo['unitBarcode']."', N'".$rowProductInfo['image']."', ".$rowProductInfo['packWholesale'].", 1,NULL, N'".$rowProductInfo["unit"]."', ".$capacity.");"; 
// 						$stmt5 = mysqli_query( $conn, $sql5);
						
// 						// echo $sql5;
// 						if ( $stmt5 ) {
// 							$_SESSION['notification']['type']="success";
// 							$_SESSION['notification']['message']="The status was updated properly.";
//                             $json["type"] = "success";
//                             $json["message"] = "The status was updated properly";
// 						} else {
// 							$_SESSION['notification']['type']="error";
// 							$_SESSION['notification']['message']="The status was not updated properly";
//                             $json["type"] = "error";
//                             $json["message"] = "The status was not updated properly";
// 						};
// 						if(!isset($_GET["fromCreateProduct"])){
// 							echo json_encode($json);
// 						}
// 					}

// 					break;
// 				} else {
// 					// Caso update
// 					$sql6= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND orderId=".$orderId." AND newDueDate IS NULL;"; 
// 					$stmt6 = mysqli_query( $conn, $sql6); 
					
// 					// echo $sql6;
					
// 					if ( $stmt6 ) {
// 						$_SESSION['notification']['type']="success";
// 						$_SESSION['notification']['message']="The status was updated properly.";
//                         $json["type"] = "success";
//                         $json["message"] = "The status was updated properly";
//                         echo json_encode($json);
// 					} else {
// 						$_SESSION['notification']['type']="error";
// 						$_SESSION['notification']['message']="The status was not updated properly";
//                         $json["type"] = "error";
//                         $json["message"] = "The status was not updated properly";
//                         echo json_encode($json);
// 					};
// 					break;
// 				};
// 			}
// 			while( $row7=mysqli_fetch_array( $stmt7, MYSQLI_ASSOC) );
			
// 			if(isset($_GET["fromCreateProduct"])){
// 				header ("Location: ../market/orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);
// 			}
// 			exit();
// 		};

// 		$sql4 = "SELECT id FROM orderDetails WHERE orderId = ".$orderId." AND unitBarcode = '".$unitBarcode."';";
// 		$stmt4= mysqli_query( $conn, $sql4); 
// 		$stmt4_numrows = mysqli_num_rows($stmt4);
	
		
// 		$finalDate;
// 		$flagIsUpdateOrInsert;

		
// 		//Caso que no tengo el producto en details y estoy en out
// 		if($flagTargetInOut == 1){
// 			if($rowStockOrderDetailsNumRows == 0){
// 				// echo "Cond 0";
// 				$flagIsUpdateOrInsert = "insert";
// 				$finalDate = $rowStock["dueDate"];
// 				$productId = $rowStock["id"];
		
// 			//Caso que tengo producto en details y tengo que ver si tengo lleno el lote o no para ver si agrego en el mismo lote o en otro
// 			} else {
// 				do {
// 					// print_r($rowStock);
// 					// print_r($rowStockOrderDetails);
// 					if($rowStock["dueDate"] < $rowStockOrderDetails["newDueDate"]){
// 						// echo "Cond 1";
// 						$finalDate = $rowStock["dueDate"];
// 						$productId = $rowStock["id"];
// 						$flagIsUpdateOrInsert="insert";
// 						break;
// 					}
// 					if($rowStock["dueDate"] > $rowStockOrderDetails["newDueDate"]){
// 						// echo "Cond 2";
// 						$rowStockOrderDetails = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC );
// 						if(!$rowStockOrderDetails){
// 							// echo "Cond 5";
// 							$finalDate = $rowStock["dueDate"];
// 							$productId = $rowStock["id"];
// 							$flagIsUpdateOrInsert="insert";
// 							break;
// 						}
// 						continue;
// 					}
// 					if($rowStock["dueDate"] == $rowStockOrderDetails["newDueDate"] && $rowStock["stock"] <= $rowStockOrderDetails["quantity"]){
// 						// echo "Cond 3";
// 						// echo "stockrow:";
// 						// print_r($rowStock);
// 						// echo "orderdetailsrow:";
// 						// print_r($rowStockOrderDetails);

// 						$rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC );
// 						$rowStockOrderDetails = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC );
// 						// echo "stockrow post:";
// 						// print_r($rowStock);
// 						// echo "orderdetailsrow post:";
// 						// print_r($rowStockOrderDetails);
// 						if(!$rowStockOrderDetails && $rowStock){
// 							// echo "Cond 6";
// 							$finalDate = $rowStock["dueDate"];
// 							$productId = $rowStock["id"];
// 							// echo "finaldate:".$finalDate;
// 							// echo "prodid:".$productId;
// 							$flagIsUpdateOrInsert="insert";
// 							break;
// 						}
// 						continue;
// 					}
					
// 					if($rowStock["dueDate"] == $rowStockOrderDetails["newDueDate"] && $rowStock["stock"] > $rowStockOrderDetails["quantity"]){
// 						// echo "Cond 4";
// 						// echo "stockrow:";
// 						// print_r($rowStock);
// 						// echo "orderdetailsrow:";
// 						// print_r($rowStockOrderDetails);
// 						$finalDate = $rowStock["dueDate"];
// 						$productId = $rowStock["id"];
// 						$flagIsUpdateOrInsert="update";
// 						if($stmt4_numrows == 0){
// 							$flagIsUpdateOrInsert="insert";
// 						}
// 						break;
// 					}
// 				} while ($rowStock && $rowStockOrderDetails);
			
			
// 				if(!isset($finalDate)){
// 					// echo "no fd, out";
// 					$_SESSION['notification']['type']="error";
// 					$_SESSION['notification']['message']="No Stock. Max: ".$rowStock['stock'];
                    
//                     $json["type"] = "error";
//                     $json["message"] = "No Stock. Max: ".$rowStock['stock'];
//                     echo json_encode($json);
// 					// header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);	
// 					exit();
// 				}
// 			}
// 		}


// 		if($finalDate == '0000-00-00'){
// 			if($flagIsUpdateOrInsert=="update"){
// 				// $sqlGetProductId = "SELECT * FROM products WHERE unitBarcode='".$unitBarcode."' AND (dueDate='0000-00-00' OR dueDate IS NULL)";//Caso particulares que no son fechas validas
// 				// $stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
// 				$sqlGetProductId = "SELECT * FROM orderDetails WHERE unitBarcode='".$unitBarcode."' AND orderId=".$orderId." AND newDueDate='0000-00-00';";//Caso particulares que no son fechas validas
// 				// echo "sqlgetprod:". $sqlGetProductId;
// 				$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
// 				if($stmtGetProductId){
// 					$rowGetProductId = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
// 					if(isset($productId)){
// 						$sql2= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND productId='".$productId."' AND orderId=".$orderId.";";
// 					} else {
// 						$sql2= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND productId='".$rowGetProductId["productId"]."' AND orderId=".$orderId.";";
// 					}
// 					// echo "sql update:". $sql2;
// 					$stmt2 = mysqli_query( $conn, $sql2);
// 					if($stmt2){
// 						$json["type"] = "success";
//                         $json["message"] = "The status was updated properly";
//                         echo json_encode($json);
// 					} else {
// 						$json["type"] = "error";
//                         $json["message"] = "The status was not updated properly";
//                         echo json_encode($json);
// 					}
// 					exit();
// 				}
// 			}
// 		} else {
// 			$finalDate = date("Y-m-d",strtotime($finalDate));
	
// 			if($flagTargetInOut==1 && $flagIsUpdateOrInsert=="update"){
// 				// echo "en update";
		
// 				$sql2= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND newDueDate='".$finalDate."' AND orderId=".$orderId.";"; 
				
// 				$stmt2 = mysqli_query( $conn, $sql2); 
				
// 				// echo $sql2;
				
// 				if ( $stmt2 ) {
// 					$_SESSION['notification']['type']="success";
// 					$_SESSION['notification']['message']="The status was updated properly.";
//                     $json["type"] = "success";
//                     $json["message"] = "The status was updated properly";
// 				} else {
// 					$_SESSION['notification']['type']="error";
// 					$_SESSION['notification']['message']="The status was not updated properly";
//                     $json["type"] = "error";
//                     $json["message"] = "Product list connection error";
// 				}
//                 echo json_encode($json);
// 				// header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);	
// 				exit();
// 			}
	
// 		}



// 		if($flagTargetInOut==1 && $flagIsUpdateOrInsert=="insert"){
// 			//echo "en insert";
			
// 			//Obtiene el producto en base al unit barcode (pueden ser mas de 1)
// 			// $sql1 = "SELECT * FROM products WHERE unitBarcode='".$unitBarcode."' ORDER BY dueDate ASC LIMIT 1;";  
// 			$sqlGetProductId = "SELECT products.id, products.name, products.name2,products.sku, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock, products.unit, products.capacity FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$unitBarcode."' GROUP BY products.id HAVING stock > 0 ORDER BY products.dueDate ASC;";
// 			// echo "getprod:". $sqlGetProductId;
// 			$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
// 			if ( $stmtGetProductId ) {
// 				//echo "en insert dentro";
// 				$row1 = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );

// 				if(isset($row1["capacity"])){
// 					$capacity = $row1["capacity"];
// 				} else {
// 					$capacity = "NULL";
// 				}

// 				if(isset($finalDate) && $finalDate != '0000-00-00'){
// 					$sql2= "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate, unit, capacity) VALUE ( ".$orderId.", ".$productId.", N'".$row1['sku']."', N'".$row1['name']."', N'".$row1['name2']."', N'".$row1['unitBarcode']."', N'".$row1['image']."', ".$row1['packWholesale'].", 1,'".$finalDate."', N'".$row1["unit"]."', ".$capacity.");"; 
// 				} else {
// 					$sql2= "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate, unit, capacity) VALUE ( ".$orderId.", ".$productId.", N'".$row1['sku']."', N'".$row1['name']."', N'".$row1['name2']."', N'".$row1['unitBarcode']."', N'".$row1['image']."', ".$row1['packWholesale'].", 1,'".$row1['dueDate']."', N'".$row1["unit"]."', ".$capacity.");"; 
// 				}
// 				$stmt2 = mysqli_query( $conn, $sql2);  
// 				// echo "insert tamos por aca:". $sql2;
// 				if ( $stmt2 ) {
// 					$_SESSION['notification']['type']="success";
// 					$_SESSION['notification']['message']="The status was updated properly.";
// 					$json["type"] = "success";
// 					$json["message"] = "The status was updated properly";
// 				} else {
// 					$_SESSION['notification']['type']="error";
// 					$_SESSION['notification']['message']="The status was not updated properly";
// 					$json["type"] = "error";
// 					$json["message"] = "The status was not updated properly";
// 				};
				
// 			} else {
			
// 				$_SESSION['notification']['type']="error";
// 				$_SESSION['notification']['message']="Product list connection error";
//                 $json["type"] = "error";
//                 $json["message"] = "Product list connection error";
// 			};
// 		}
//         echo json_encode($json);

// 		if($flagTargetInOut==0 && $flagIsUpdateOrInsert=="update"){
// 			//echo "\nfecha final:".$finalDate;
// 			//echo "\norderId:".$orderId;
// 		}
		
// 		if($flagTargetInOut==0 && $flagIsUpdateOrInsert=="insert"){
// 			//echo "\nfecha final:".$finalDate;
// 			//echo "\norderId:".$orderId;
// 		}

// 	}
// 		// header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);	
// 		exit();
// };


?>