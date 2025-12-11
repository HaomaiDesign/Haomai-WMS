<?php include "../system/db.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

//**************************************************//

if ($_GET['action'] == "addProduct") {
	$unitBarcode = $_GET['unitBarcode'];
	$orderId = $_GET['id'];
	$productId = $_GET['productId'];

	$sql0 = "SELECT * FROM orderDetails WHERE orderId=" . $orderId . " AND unitBarcode=" . $unitBarcode . ";";
	$stmt0 = mysqli_query($conn, $sql0);

	if ($stmt0) {
		$row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);

		if ($row0['id'] != "")
			$sql2 = "UPDATE orderDetails SET quantity=quantity+1 WHERE id=" . $_GET['id'] . ";";
		else {

			$sql1 = "SELECT * FROM products WHERE id=" . $productId . ";";
			$stmt1 = mysqli_query($conn, $sql1);

			if ($stmt1) {
				$row1 = mysqli_fetch_array($stmt1, MYSQLI_ASSOC);
				$sql2 = "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity) VALUE ( " . $orderId . ", " . $productId . ", N'" . $row1['sku'] . "', N'" . $row1['name'] . "', N'" . $row1['name2'] . "', N'" . $row1['unitBarcode'] . "', N'" . $row1['image'] . "', " . $row1['packWholesale'] . ", 1);";
			}

		}

		$stmt2 = mysqli_query($conn, $sql2);
	}
}

//**************************************************//

if ($_GET['action'] == "updateNewQuantity") {

	$sql0 = "SELECT oldQuantity FROM orderDetails WHERE id=" . $_GET['cartId'] . ";";
	$stmt0 = mysqli_query($conn, $sql0);

	if ($stmt0) {
		$row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);
		$sql = "";

		if ($row0['oldQuantity'] == NULL)
			$sql .= "UPDATE orderDetails SET oldQuantity=quantity WHERE id=" . $_GET['cartId'] . ";";

		if ($row0['oldQuantity'] == $_GET['quantity'])
			$sql .= "UPDATE orderDetails SET oldQuantity=NULL WHERE id=" . $_GET['cartId'] . ";";

		$sql .= "UPDATE orderDetails SET quantity=" . $_GET['quantity'] . " WHERE id=" . $_GET['cartId'] . ";";
		$stmt = mysqli_multi_query($conn, $sql);
	}
}

//**************************************************//

if ($_GET['action'] == "updateNewQuantitySimple") {
	$sqlStock = "SELECT SUM(stock) AS stock FROM stockLogs WHERE unitBarcode='" . $_GET['unitBarcode'] . "';";
	$stmtStock = mysqli_query($conn, $sqlStock);
	$rowStock = mysqli_fetch_array($stmtStock, MYSQLI_ASSOC);

	if ($_GET['quantity'] <= $rowStock['stock']) {
		$sql = "UPDATE orderDetails SET quantity=" . $_GET['quantity'] . " WHERE id=" . $_GET['id'] . ";";
		$stmt = mysqli_query($conn, $sql);
	} else {
		$_SESSION['notification']['type'] = "error";
		$_SESSION['notification']['message'] = "No Stock: " . $rowStock['stock'];
	}

}
//**************************************************//

if ($_GET['action'] == "removeProduct") {

	$sql = "DELETE FROM orderDetails WHERE id=" . $_GET['orderDetailsId'] . ";";
	$stmt = mysqli_query($conn, $sql);
	$json["type"] = "success";
	$json["message"] = "Product deleted successfully";
	echo json_encode($json);
}

//**************************************************//
//made by mirko
if ($_GET['action'] == "nombreAction") {
	if ($_GET["target"] == "out") {
		$sql = "(SELECT SUM(quantity) as quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack  FROM orderdetails WHERE orderId=" . $_GET["id"] . " AND unitBarcode != 'Special' GROUP BY unitBarcode ORDER BY id ASC)
				UNION
				(SELECT quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack  FROM orderdetails WHERE orderId=" . $_GET["id"] . " AND unitBarcode = 'Special' ORDER BY id ASC);";
	}
	if ($_GET["target"] == "in") {
		// $sql = "SELECT SUM(quantity) as quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack FROM orderDetails WHERE orderId=".$_GET['id']." GROUP BY unitBarcode ORDER BY id ASC;";
		$sql = "SELECT quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, newDueDate FROM orderdetails WHERE orderId=" . $_GET['id'] . " ORDER BY id ASC;";
	}
	// echo $sql;
	$stmt = mysqli_query($conn, $sql);
	if ($stmt) {
		while ($row1 = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
			$json[] = $row1;
		}
	}

	echo json_encode($json);
}

//**************************************************//

if ($_GET['action'] == "removeAllProductsFromOrder") {
	$sql = "DELETE FROM orderDetails WHERE orderId=" . $_GET['orderId'] . ";";
	$stmt = mysqli_query($conn, $sql);
	$json["type"] = "success";
	$json["message"] = "All products deleted successfully";
	echo json_encode($json);
}

//**************************************************//

if ($_GET['action'] == "removeProductByBarcode") {
	// if($_GET["unitBarcode"] != "Special"){
	// 	$sql = "DELETE FROM orderDetails WHERE unitBarcode='".$_GET["unitBarcode"]."' AND orderId=".$_GET['orderId'].";";
	// } else {
	// 	$sql = "DELETE FROM orderDetails WHERE unitBarcode='".$_GET["unitBarcode"]."' AND id=".$_GET["rowId"]." AND orderId=".$_GET['orderId'].";";
	// }
	$sql = "DELETE FROM orderDetails WHERE id=" . $_GET["rowId"] . ";";
	$stmt = mysqli_query($conn, $sql);

	$json["type"] = "success";
	$json["message"] = "Product deleted successfully";
	echo json_encode($json);
}

//**************************************************//

if ($_GET['action'] == "updateNewPrice") {

	$sql0 = "SELECT oldPrice FROM orderDetails WHERE id=" . $_GET['cartId'] . ";";
	$stmt0 = mysqli_query($conn, $sql0);

	if ($stmt0) {
		$row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);
		$sql = "";

		if ($row0['oldPrice'] == NULL)
			$sql .= "UPDATE orderDetails SET oldPrice=price WHERE id=" . $_GET['cartId'] . ";";

		if ($row0['oldPrice'] == $_GET['price'])
			$sql .= "UPDATE orderDetails SET oldPrice=NULL WHERE id=" . $_GET['cartId'] . ";";

		$sql .= "UPDATE orderDetails SET price=" . $_GET['price'] . " WHERE id=" . $_GET['cartId'] . ";";
		$stmt = mysqli_query($conn, $sql);
	}
}

//**************************************************//

if ($_GET['action'] == "updateAdditional") {

	if ($_GET['value'] != "")
		$value = $_GET['value'];
	else
		$value = 0;

	if ($_GET['option'] == 1)
		$sql = "UPDATE orders SET chargePercent=" . $value . ", charge=0 WHERE id=" . $_GET['id'] . ";";

	if ($_GET['option'] == 2)
		$sql = "UPDATE orders SET chargePercent=0, charge=" . $value . " WHERE id=" . $_GET['id'] . ";";

	if ($_GET['option'] == 3)
		$sql = "UPDATE orders SET discountPercent=" . $value . ", discount=0 WHERE id=" . $_GET['id'] . ";";

	if ($_GET['option'] == 4)
		$sql = "UPDATE orders SET discountPercent=0, discount=" . $value . " WHERE id=" . $_GET['id'] . ";";


	$stmt = mysqli_query($conn, $sql);

}

//*******************Creo que no lo uso******************************//

if ($_GET['action'] == "page") {

	if ($_GET['userId'] != "")
		$condition = "userId=" . $_GET['userId'];
	if ($_GET['businessId'] != "")
		$condition = "businessId=" . $_GET['businessId'];

	$sql0 = "SELECT COUNT(*) AS rowNum FROM orders WHERE " . $condition . ";";
	$stmt0 = mysqli_query($conn, $sql0);

	if ($stmt0) {
		$row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);
		$getRow = $row0['rowNum'];
		$limit = 10;

		if ($getRow != "") {

			$min = $getRow - $limit * $_GET['page'];
			$max = $getRow - $limit * $_GET['page'] + $limit;

			if ($min < 0)
				$min = 0;


			$sql1 = "SELECT * FROM ( SELECT *, ROW_NUMBER() OVER (ORDER BY id) as row FROM orders) as alias WHERE row > " . $min . " and row <= " . $max . " ORDER BY id DESC;";
			$stmt1 = mysqli_query($conn, $sql1);


			if ($stmt1) {
				while ($row1 = mysqli_fetch_array($stmt1, MYSQLI_ASSOC)) {
					$json[] = $row1;
				}

				echo json_encode($json);

			}
		}
	}
}

//**************************************************//

if ($_GET['action'] == "getProductStockAndDueDate") {

	if ($_GET['flagInOut'] == "out") {
		// $sql0 = "SELECT products.id, products.sku, products.dueDate, products.name, products.unitBarcode, products.name2, orderDetails.quantity, SUM(stockLogs.stock) AS stock FROM products AS products INNER JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode=".$_GET['unitBarcode']." GROUP BY products.id ORDER BY products.id ASC;";
		// $sql0 = "WITH tabla1 AS (SELECT products.id, products.sku, products.dueDate, products.name, products.unitBarcode, products.name2, SUM(stockLogs.stock) AS stock FROM products AS products INNER JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId WHERE products.unitBarcode=".$_GET['unitBarcode']." GROUP BY products.id ORDER BY products.id ASC) SELECT t1.*, od.quantity FROM orderDetails AS od RIGHT JOIN tabla1 AS t1 on t1.dueDate = od.newDueDate AND od.orderId=".$_GET['orderId']." ORDER BY dueDate ASC;";
		$sql0 = "SELECT t1.*, od.quantity, (t1.stock - t2.quantity) AS available
				FROM (SELECT * FROM orderDetails AS od WHERE orderId=" . $_GET["orderId"] . ") od
				RIGHT JOIN (

					SELECT products.id, products.packWholesale, products.unit, products.capacity, products.image, products.sku, products.dueDate, products.name, products.unitBarcode, products.name2, SUM(stockLogs.stock) AS stock,
					CASE 
						WHEN stockLogs.warehouseId = 1 THEN 'Deposito Leiva'
						WHEN stockLogs.warehouseId = 2 THEN 'Deposito Monroe'
						ELSE stockLogs.warehouseId 
					END AS warehouseId
					FROM products AS products
					INNER JOIN stockLogs AS stockLogs ON products.id=stockLogs.productId
					WHERE products.unitBarcode='" . $_GET["unitBarcode"] . "' GROUP BY products.id HAVING stock > 0 ORDER BY products.id ASC
				
				) AS t1 on t1.id = od.productId
				LEFT JOIN (

					SELECT od.productId, od.productSku, od.productName, SUM(od.quantity) as quantity, od.newDueDate, o.flagInOut
					FROM orderDetails as od
					INNER JOIN orders as o ON od.orderId = o.id 
					WHERE od.unitBarcode='" . $_GET["unitBarcode"] . "'  AND o.flagInOut = 1 AND flagStock = 0 GROUP BY od.productId, od.unitBarcode ORDER BY newDueDate
				
				) AS t2 on t2.productId = t1.id
				ORDER BY dueDate, warehouseId ASC;";
		// echo "query para modal:".$sql0;
		$stmt0 = mysqli_query($conn, $sql0);

		if ($stmt0) {
			while ($row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC)) {
				$json[] = $row0;
			}
		}

	} else {
		$sql2 = "SELECT id, newDueDate, productName, unitBarcode, productName2, productId, productSku, pack, unit, capacity, image, quantity FROM orderDetails WHERE unitBarcode='" . $_GET['unitBarcode'] . "' AND orderId=" . $_GET['orderId'] . ";";
		$stmt2 = mysqli_query($conn, $sql2);

		if ($stmt2) {
			while ($row2 = mysqli_fetch_array($stmt2, MYSQLI_ASSOC)) {
				$json[] = $row2;
			}

		}
		// $sql1 = "SELECT id, sku, name, name2, packWholesale, unitBarcode, image FROM products WHERE unitBarcode=".$_GET['unitBarcode'].";";

		// $sql2 = "INSERT into orderDetails (orderId, productName, productName2, unitBarcode, quantity, image) VALUE ( ".$orderId.", ".$productId.", N'".$row1['name']."', N'".$row1['name2']."', N'".$row1['unitBarcode']."', N'".$row1['image']."', ".$row1['packWholesale'].", 1)";
	}
	echo json_encode($json);
}


//**************************************************//

if ($_GET['action'] == "updateLoteQty") {
	if ($_GET['flagInOut'] == "in") {
		$sql = "UPDATE orderDetails SET quantity =" . $_GET["loteQty"] . " WHERE id=" . $_GET["loteId"] . ";";
		$stmt = mysqli_query($conn, $sql);
		echo "update in:" . $sql;

	} else {

		$sql1 = "SELECT * FROM orderDetails WHERE productId=" . $_GET["loteId"] . " AND orderId=" . $_GET["orderId"] . " LIMIT 1;";
		$stmt1 = mysqli_query($conn, $sql1);
		$num_rows = mysqli_num_rows($stmt1);

		if ($stmt1) {
			if ($num_rows == 0) {
				$dueDateFormatted = "0000-00-00";
				if (isset($_GET['dueDate']) && $_GET['dueDate'] != "0000-00-00") {
					$dueDateFormatted = date("Y-m-d", strtotime($_GET['dueDate']));
					//echo "La date es:".$_GET['dueDate'];
				}
				$sql3 = "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, unit, capacity, quantity, oldQuantity, newDueDate) 
				VALUES ( " . $_GET["orderId"] . ", " . $_GET["loteId"] . ", N'" . $_GET["sku"] . "', N'" . $_GET['name'] . "', N'" . $_GET['name2'] . "', N'" . $_GET['unitBarcode'] . "', N'" . $_GET['image'] . "'," . $_GET['pack'] . ", N'" . $_GET['unit'] . "', " . $_GET['capacity'] . ", " . $_GET["loteQty"] . ",1,'" . $dueDateFormatted . "');";
				echo "insert orderDetails out:" . $sql3 . "\n";
				$stmt3 = mysqli_query($conn, $sql3);

			} else {
				if ($_GET['loteQty'] != 0) {
					$sql3 = "UPDATE orderDetails SET quantity=" . $_GET["loteQty"] . " WHERE productId=" . $_GET["loteId"] . " AND orderId=" . $_GET["orderId"] . ";";
				} else {
					$sql3 = "DELETE FROM orderDetails WHERE productId=" . $_GET["loteId"] . " AND orderId=" . $_GET["orderId"] . ";";
				}
				$stmt3 = mysqli_query($conn, $sql3);
				echo "update orderDet out:" . $sql3 . "\n";
			}
		}

	}
}

if ($_GET['action'] == "updateLoteNewDueDate") {
	$dueDateFormatted = "0000-00-00";
	if (isset($_GET['loteNewDueDate'])) {
		$dueDateFormatted = date("Y-m-d", strtotime($_GET['loteNewDueDate']));
	}
	$sql = "UPDATE orderDetails SET newDueDate =N'" . $dueDateFormatted . "' WHERE id=" . $_GET["loteId"] . ";";
	$stmt = mysqli_query($conn, $sql);
	echo "lotenewdate:" . $sql;
}

if ($_GET['action'] == "addLote") {
	//Chequeo de lotes
	$sql = "SELECT * FROM orderDetails WHERE id=" . $_GET["loteId"] . ";";
	$stmt = mysqli_query($conn, $sql);
	if ($stmt) {
		$row = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
		$sqlCheckDueDates = "SELECT newDueDate FROM orderDetails WHERE unitBarcode='" . $row["unitBarcode"] . "' AND orderId=" . $row["orderId"] . " AND newDueDate IS NULL;";
		$stmtCheckDueDates = mysqli_query($conn, $sqlCheckDueDates);
		if ($stmtCheckDueDates) {
			if (mysqli_num_rows($stmtCheckDueDates) != 0) {
				$json["type"] = "error";
				$json["message"] = "Debe asignar una fecha de vencimiento a todos los lotes antes de crear uno nuevo";
			} else {
				if (isset($row["capacity"])) {
					$capacity = $row["capacity"];
				} else {
					$capacity = "NULL";
				}
				$sql1 = "INSERT INTO orderDetails ( orderId, productId, productSku, productName, productName2, unitBarcode, image, pack, quantity, newDueDate, unit, capacity) VALUES ( " . $row["orderId"] . ", NULL, NULL, N'" . $row['productName'] . "', N'" . $row['productName2'] . "', N'" . $row['unitBarcode'] . "', N'" . $row['image'] . "', " . $row['pack'] . ", 1,NULL, N'" . $row["unit"] . "', " . $capacity . ");";
				$stmt1 = mysqli_query($conn, $sql1);
				if ($stmt1) {
					$json["type"] = "success";
					$json["message"] = "The status was updated properly";
				}
			}
			echo json_encode($json);
		}
		exit();
	}
}


?>