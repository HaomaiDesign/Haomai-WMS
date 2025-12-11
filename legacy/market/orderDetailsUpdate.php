<?php 
session_start();
include "../system/db.php"; 
date_default_timezone_set('America/Argentina/Buenos_Aires');


//**************************************************//

if($_GET['action']=="addSpecialProduct"){
	$sql="INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate) VALUE ( ".$_GET["orderId"].", NULL, NULL, N'".$_GET["unitBarcode"]."', N'', N'Special', N'', 1, 1,NULL);";
	$stmtInsertSpecialProd = mysqli_query( $conn, $sql); 
	
	if($stmtInsertSpecialProd){
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="Special product created properly";
	} else {
		$_SESSION['notification']['type']="error";
		$_SESSION['notification']['message']="Special product was not created properly";
	}

	header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$_GET['orderId']);
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

	header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$_GET['id']);
	exit();	
	
	
}

//**************************************************//

if ($_GET['action']=="addProduct"){	

	$flagTargetInOut;
	if($_GET['target'] == "out"){
		$flagTargetInOut = 1;
	}
	if($_GET['target'] == "in"){
		$flagTargetInOut = 0;
	}

	$unitBarcode = $_GET['unitBarcode'];
	$orderId = $_GET['orderId'];

	//Stock en base a product (barcode) y fecha (dueDate).
	if($flagTargetInOut == 1){
		$sqlStock = "SELECT products.id, products.name, products.name2, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$_GET["unitBarcode"]."' GROUP BY products.id HAVING stock > 0 ORDER BY products.dueDate ASC;";
	}
	if($flagTargetInOut == 0){
		$sqlStock = "SELECT products.id, products.name, products.name2, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$_GET["unitBarcode"]."' GROUP BY products.id ORDER BY products.dueDate ASC;";
	}
	$stmtStock = mysqli_query( $conn, $sqlStock); 
	// echo "sqlstock:". $sqlStock;
	$rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC );
	$rowStockNumRows = mysqli_num_rows($stmtStock);
	// echo "numrows rowstock:". $rowStockNumRows;

	if($rowStockNumRows == 0){
		// echo "entro rowstock == 0:";
		if($flagTargetInOut == 1){
			// echo "entro flagtargetinout 1";
			$_SESSION['notification']['type']="error";
			$_SESSION['notification']['message']="Product does not exist or no stock available";//Solucion rapida por el momento, dsp dividir no stock de no existe
			header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);	
			exit();
		}
		if($flagTargetInOut == 0){
			// echo "entro flagtargetinout 0";
			header ("Location: ../stock/itemList.php?formStatus=create&target=".$_GET['target']."&unitBarcode=".$unitBarcode."&orderId=".$orderId);	
			exit();
		}
	} else {
		//Obtengo cantidad de cada producto en base a dueDate y unitBarcode
		$sql3 = "SELECT od.productName, SUM(od.quantity) as quantity, od.newDueDate, o.flagInOut FROM orderDetails as od INNER JOIN orders as o ON od.orderId = o.id WHERE od.unitBarcode='".$unitBarcode."'  AND o.flagInOut = ".$flagTargetInOut." AND o.flagStock = 0"; 
		if($flagTargetInOut == 0){
			//Caso update de un ingreso, solo me interesa el order actual
			$sql3.=" AND orderId =".$orderId;
		}
		$sql3.= " GROUP BY od.newDueDate, od.unitBarcode ORDER BY newDueDate;";
		// echo "sql3:". $sql3;
		$stmt3= mysqli_query( $conn, $sql3); 
		$rowStockOrderDetails = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC );
		$rowStockOrderDetailsNumRows = mysqli_num_rows($stmt3);
		// echo "numrows order details:". $rowStockOrderDetailsNumRows;

		if($flagTargetInOut == 0){
	
			$sql7= "SELECT newDueDate FROM orderDetails WHERE orderId=".$orderId." AND unitBarcode='".$unitBarcode."';";
			$stmt7 = mysqli_query( $conn, $sql7 );
			$row7=mysqli_fetch_array( $stmt7, MYSQLI_ASSOC);
			
			echo "sql7:". $sql7;
			do{
				if( $rowStockOrderDetailsNumRows == 0 || $row7['newDueDate'] != ""){
					//Caso insert
					$sqlGetProductId = "SELECT products.id, products.name, products.name2, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$unitBarcode."' GROUP BY products.id ORDER BY products.dueDate ASC;";
					echo "getprod:". $sqlGetProductId;
					$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
					if($stmtGetProductId){

						$rowProductInfo = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
						$sql5= "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate) VALUE ( ".$orderId.", ".$rowProductInfo['id'].", NULL, N'".$rowProductInfo['name']."', N'".$rowProductInfo['name2']."', N'".$rowProductInfo['unitBarcode']."', N'".$rowProductInfo['image']."', ".$rowProductInfo['packWholesale'].", 1,NULL);"; 
						$stmt5 = mysqli_query( $conn, $sql5);
						
						echo $sql5;
						if ( $stmt5 ) {
							$_SESSION['notification']['type']="success";
							$_SESSION['notification']['message']="The status was updated properly.";
						} else {
							$_SESSION['notification']['type']="error";
							$_SESSION['notification']['message']="The status was not updated properly";
						};
					}

					break;
				} else {
					// Caso update
					$sql6= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND orderId=".$orderId." AND newDueDate IS NULL;"; 
					$stmt6 = mysqli_query( $conn, $sql6); 
					
					// echo $sql6;
					
					if ( $stmt6 ) {
						$_SESSION['notification']['type']="success";
						$_SESSION['notification']['message']="The status was updated properly.";
					} else {
						$_SESSION['notification']['type']="error";
						$_SESSION['notification']['message']="The status was not updated properly";
					};
					break;
				};
			}
			while( $row7=mysqli_fetch_array( $stmt7, MYSQLI_ASSOC) );
			header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);
			exit();
		};

		$sql4 = "SELECT id FROM orderDetails WHERE orderId = ".$orderId." AND unitBarcode = '".$unitBarcode."';";
		$stmt4= mysqli_query( $conn, $sql4); 
		$stmt4_numrows = mysqli_num_rows($stmt4);
	
		
		$finalDate;
		$flagIsUpdateOrInsert;

		
		//Caso que no tengo el producto en details y estoy en out
		if($flagTargetInOut == 1){
			if($rowStockOrderDetailsNumRows == 0){
				$flagIsUpdateOrInsert = "insert";
				$finalDate = $rowStock["dueDate"];
				$productId = $rowStock["id"];
		
			//Caso que tengo producto en details y tengo que ver si tengo lleno el lote o no para ver si agrego en el mismo lote o en otro
			} else {
				do {
					print_r($rowStock);
					print_r($rowStockOrderDetails);
					if($rowStock["dueDate"] < $rowStockOrderDetails["newDueDate"]){
						echo "Cond 1";
						$finalDate = $rowStock["dueDate"];
						$productId = $rowStock["id"];
						$flagIsUpdateOrInsert="insert";
						break;
					}
					if($rowStock["dueDate"] > $rowStockOrderDetails["newDueDate"]){
						echo "Cond 2";
						$rowStockOrderDetails = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC );
						if(!$rowStockOrderDetails){
							echo "Cond 5";
							$finalDate = $rowStock["dueDate"];
							$productId = $rowStock["id"];
							$flagIsUpdateOrInsert="insert";
							break;
						}
						continue;
					}
					if($rowStock["dueDate"] == $rowStockOrderDetails["newDueDate"] && $rowStock["stock"] <= $rowStockOrderDetails["quantity"]){
						echo "Cond 3";
						$rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC );
						$rowStockOrderDetails = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC );
						if(!$rowStockOrderDetails && $rowStock){
							echo "Cond 6";
							$finalDate = $rowStock["dueDate"];
							$productId = $rowStock["id"];
							$flagIsUpdateOrInsert="insert";
							break;
						}
						continue;
					}
					
					if($rowStock["dueDate"] == $rowStockOrderDetails["newDueDate"] && $rowStock["stock"] > $rowStockOrderDetails["quantity"]){
						echo "Cond 4";
						$finalDate = $rowStock["dueDate"];
						$productId = $rowStock["id"];
						$flagIsUpdateOrInsert="update";
						if($stmt4_numrows == 0){
							$flagIsUpdateOrInsert="insert";
						}
						break;
					}
				} while ($rowStock && $rowStockOrderDetails);
			
			
				if(!isset($finalDate)){
					//echo "no fd, out";
					$_SESSION['notification']['type']="error";
					$_SESSION['notification']['message']="No Stock. Max: ".$rowStock['stock'];
					header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);	
					exit();
				}
			}
		}
		
		if($finalDate == '0000-00-00'){
			if($flagIsUpdateOrInsert=="update"){
				// $sqlGetProductId = "SELECT * FROM products WHERE unitBarcode='".$unitBarcode."' AND (dueDate='0000-00-00' OR dueDate IS NULL)";//Caso particulares que no son fechas validas
				// $stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
				$sqlGetProductId = "SELECT * FROM orderDetails WHERE unitBarcode='".$unitBarcode."' AND orderId=".$orderId." AND newDueDate='0000-00-00';";//Caso particulares que no son fechas validas
				// echo "sqlgetprod:". $sqlGetProductId;
				$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
				if($stmtGetProductId){
					$rowGetProductId = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
					$sql2= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND productId='".$rowGetProductId["productId"]."' AND orderId=".$orderId.";";
					// echo "sql update:". $sql2;
					$stmt2 = mysqli_query( $conn, $sql2); 
				}
			}
		} else {
			$finalDate = date("Y-m-d",strtotime($finalDate));
	
			if($flagTargetInOut==1 && $flagIsUpdateOrInsert=="update"){
				// echo "en update";
		
				$sql2= "UPDATE orderDetails SET quantity=quantity+1 WHERE unitBarcode='".$unitBarcode."' AND newDueDate='".$finalDate."' AND orderId=".$orderId.";"; 
				
				$stmt2 = mysqli_query( $conn, $sql2); 
				
				// echo $sql2;
				
				if ( $stmt2 ) {
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']="The status was updated properly.";
				} else {
					$_SESSION['notification']['type']="error";
					$_SESSION['notification']['message']="The status was not updated properly";
				}
				header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);	
				exit();
			}
	
		}
		if($flagTargetInOut==1 && $flagIsUpdateOrInsert=="insert"){
			//echo "en insert";
			
			//Obtiene el producto en base al unit barcode (pueden ser mas de 1)
			// $sql1 = "SELECT * FROM products WHERE unitBarcode='".$unitBarcode."' ORDER BY dueDate ASC LIMIT 1;";  
			$sqlGetProductId = "SELECT products.id, products.name, products.name2,products.sku, products.dueDate, products.unitBarcode, products.image, products.packWholesale, SUM(stockLogs.stock) AS stock FROM products AS products LEFT JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode='".$unitBarcode."' GROUP BY products.id HAVING stock > 0 ORDER BY products.dueDate ASC;";
			echo "getprod:". $sqlGetProductId;
			$stmtGetProductId = mysqli_query( $conn, $sqlGetProductId); 
				
			if ( $stmtGetProductId ) {
				//echo "en insert dentro";
				$row1 = mysqli_fetch_array( $stmtGetProductId, MYSQLI_ASSOC );
				$sql2= "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate) VALUE ( ".$orderId.", ".$row1['id'].", N'".$row1['sku']."', N'".$row1['name']."', N'".$row1['name2']."', N'".$row1['unitBarcode']."', N'".$row1['image']."', ".$row1['packWholesale'].", 1,'".$row1['dueDate']."');"; 
				$stmt2 = mysqli_query( $conn, $sql2);  
				//echo $sql2;
					if ( $stmt2 ) {
						$_SESSION['notification']['type']="success";
						$_SESSION['notification']['message']="The status was updated properly.";
					} else {
						$_SESSION['notification']['type']="error";
						$_SESSION['notification']['message']="The status was not updated properly";
					};
				
			} else {
			
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="Product list connection error";
			};
		}

		if($flagTargetInOut==0 && $flagIsUpdateOrInsert=="update"){
			//vemos
			//echo "\nfecha final:".$finalDate;
			//echo "\norderId:".$orderId;
		}
		
		if($flagTargetInOut==0 && $flagIsUpdateOrInsert=="insert"){
			//vemos
			//echo "\nfecha final:".$finalDate;
			//echo "\norderId:".$orderId;
		}

	}
		header ("Location: orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$orderId);	
		exit();
	};


?>