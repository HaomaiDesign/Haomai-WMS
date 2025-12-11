<?php include "../system/db.php"; 
date_default_timezone_set('America/Argentina/Buenos_Aires');

//*********************************************************//

if ($_GET['action']=="add")
{	
		
if ($_GET['customerId']!="")
	$sql0 = "SELECT TOP 1 * FROM cart WHERE customerId='".$_GET['customerId']."' AND productId=".$_GET['productId']." AND market=".$_GET['market'].";";
else
	if ($_GET['supplierId']!="")
		$sql0 = "SELECT TOP 1 * FROM cart WHERE supplierId='".$_GET['supplierId']."' AND productId=".$_GET['productId']." AND market=".$_GET['market'].";";
	else	
		$sql0 = "SELECT TOP 1 * FROM cart WHERE userId='".$_GET['userId']."' AND productId=".$_GET['productId']." AND market=".$_GET['market'].";";

$stmt0= mysqli_query( $conn, $sql0); 

if ( $stmt0 ) {
$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );  
$getCartId = $row0['id'];

if ($getCartId!=""){
	
$sql2 = "UPDATE cart SET quantity=quantity+".$_GET['quantity']." WHERE id=".$getCartId.";";  

$stmt2 = mysqli_query( $conn, $sql2);  	
	
} else {

$sql1 = "SELECT businessId, packWholesale FROM products WHERE id=".$_GET['productId'].";";  
$stmt1 = mysqli_query( $conn, $sql1);  

if ( $stmt1 ) {
$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );  
$getbusinessId = $row1['businessId'];
}

if ($_GET['customerId']!="")
	$sql2 = "INSERT INTO cart (customerId, productId, businessId, quantity, market, charge, chargePercent, discount, discountPercent) VALUES ( ".$_GET['customerId'].", ".$_GET['productId'].", ".$row1['businessId'].", ".$_GET['quantity'].", ".$_GET['market'].",0,0,0,0);";  
else
	if ($_GET['supplierId']!="")	
		$sql2 = "INSERT INTO cart (userId, productId, supplierId, quantity, market, charge, chargePercent, discount, discountPercent) VALUES ( ".$_GET['userId'].", ".$_GET['productId'].", ".$_GET['supplierId'].", ".$_GET['quantity'].", ".$_GET['market'].",0,0,0,0);";  
	else
		$sql2 = "INSERT INTO cart (userId, productId, businessId, quantity, market, charge, chargePercent, discount, discountPercent) VALUES ( ".$_GET['userId'].", ".$_GET['productId'].", ".$row1['businessId'].", ".$_GET['quantity'].", ".$_GET['market'].",0,0,0,0);";  
	
$stmt2 = mysqli_query( $conn, $sql2);  	
}
}

}

//*********************************************************//

if ($_GET['action']=="remove")
{	
$sql = "DELETE FROM cart WHERE id=".$_GET['cartId'].";";  
$stmt = mysqli_query( $conn, $sql);  	
}

//*********************************************************//

if ($_GET['action']=="cleanAll")
{	

if ($_GET['target']=="sale")
	if ($_GET['userbusinessId']!="")	
		$sql = "DELETE FROM cart WHERE ((customerId<>'') AND (businessId=".$_GET['userbusinessId']."));";  
	else
		$sql = "DELETE FROM cart WHERE userId=".$_GET['userId'].";";  

if ($_GET['target']=="purchase")
	$sql = "DELETE FROM cart WHERE userId=".$_GET['userId'].";"; 

$stmt = mysqli_query( $conn, $sql);  	
}

//*********************************************************//

if ($_GET['action']=="cleanCompany")
{
if ($_GET['customerId']!="")	
	$sql = "DELETE FROM cart WHERE customerId=".$_GET['customerId']." AND businessId=".$_GET['businessId'].";";  
else
	if ($_GET['supplierId']!="")	
		$sql = "DELETE FROM cart WHERE userId=".$_GET['userId']." AND supplierId=".$_GET['supplierId'].";";
	else
		$sql = "DELETE FROM cart WHERE userId=".$_GET['userId']." AND businessId=".$_GET['businessId'].";";

$stmt = mysqli_query( $conn, $sql);  	
}

//*********************************************************//

if ($_GET['action']=="updateQuantity")
{	
$sql = "UPDATE cart SET quantity=".$_GET['quantity']." WHERE id=".$_GET['cartId'].";";  
$stmt = mysqli_query( $conn, $sql);  	
}

//*********************************************************//

if ($_GET['action']=="updatePrice")
{	
$sql = "UPDATE cart SET price=".$_GET['price']." WHERE id=".$_GET['cartId'].";";  
$stmt = mysqli_query( $conn, $sql);  	
}


//*********************************************************//


if ($_GET['action']=="updateAdditional")
{	

if ($_GET['value']!="")
	$value = $_GET['value'];
else
	$value = 0;

if ($_GET['option']==1)
	$sql = "UPDATE cart SET chargePercent=".$value.", charge=0 WHERE customerId=".$_GET['id'].";"; 

if ($_GET['option']==2)
	$sql = "UPDATE cart SET chargePercent=0, charge=".$value." WHERE customerId=".$_GET['id'].";"; 

if ($_GET['option']==3)
	$sql = "UPDATE cart SET discountPercent=".$value.", discount=0 WHERE customerId=".$_GET['id'].";"; 

if ($_GET['option']==4)
	$sql = "UPDATE cart SET discountPercent=0, discount=".$value." WHERE customerId=".$_GET['id'].";"; 

 
$stmt = mysqli_query( $conn, $sql);  	

}

//*********************************************************//


if ($_GET['action']=="updateOwner")
{	

if ($_GET['value']!="")
	$value = $_GET['value'];
else
	$value = 0;

if ($_GET['userId']!="")
	$sql = "UPDATE cart SET ownerId=".$value." WHERE supplierId=".$_GET['id']." AND userId=".$_GET['userId'].";"; 
else
	$sql = "UPDATE cart SET ownerId=".$value." WHERE customerId=".$_GET['id'].";"; 


$stmt = mysqli_query( $conn, $sql);  	


}

//*********************************************************//



if ($_GET['action']=="sendCompany")
{	

		$date = date("Y-m-d");
		$time = date("H:i:s");
		
		if ($_GET['target']=="purchase")
			$sql0 = "SELECT id, requestId FROM orders WHERE businessId=".$_GET['businessId']." AND flagBuySell=0 ORDER BY id DESC;";  
		
		if ($_GET['target']=="sale")
			$sql0 = "SELECT id, requestId FROM orders WHERE businessId=".$_GET['businessId']." AND flagBuySell=1 ORDER BY id DESC;";  
		
		echo $sql0;
		
		$stmt0 = mysqli_query( $conn, $sql0); 
		
		if ( $stmt0 ) {
		$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );
		if ($row0['requestId']!="")
			$getRequestId = $row0['requestId'] + 1;
		else
			$getRequestId = 1;
		}
		
		if ($_GET['target']=="sale")
			$buySell = 1;
		
		if ($_GET['target']=="purchase")
			$buySell = 0;
		
	
		if ($_GET['customerId']!="")
			$sql1 = "INSERT INTO orders ( requestId, date, time, businessId, customerId, status, flagBuySell) VALUES ( ".$getRequestId.", N'".$date."', N'".$time."', ".$_GET['businessId'].", ".$_GET['customerId'].", 0, ".$buySell.");";  
		else
			if ($_GET['supplierId']!="")
				$sql1 = "INSERT INTO orders ( requestId, date, time, businessId, supplierId, userId, status, flagBuySell) VALUES ( ".$getRequestId.", N'".$date."', N'".$time."', ".$_GET['businessId'].", ".$_GET['supplierId'].", ".$_GET['userId'].", 0, ".$buySell.");";  
			else
				$sql1 = "INSERT INTO orders ( requestId, date, time, businessId, userId, status, flagBuySell) VALUES ( ".$getRequestId.", N'".$date."', N'".$time."', ".$_GET['businessId'].", ".$_GET['userId'].", 0, ".$buySell.");";  
		
		echo $sql1;
		
		$stmt1 = mysqli_query( $conn, $sql1); 

		if ($_GET['customerId']!="")
			$sql2 = "SELECT id FROM orders WHERE customerId=".$_GET['customerId']." AND businessId=".$_GET['businessId']." ORDER BY id DESC;";  
		else
			if ($_GET['supplierId']!="")
				$sql2 = "SELECT id FROM orders WHERE userId=".$_GET['userId']." AND businessId=".$_GET['businessId']." AND supplierId=".$_GET['supplierId']." ORDER BY id DESC;";  
			else
				$sql2 = "SELECT id FROM orders WHERE userId=".$_GET['userId']." AND businessId=".$_GET['businessId']." ORDER BY id DESC;";  

		$sql2 = "SELECT id FROM orders ORDER BY id DESC;";  
		$stmt2 = mysqli_query( $conn, $sql2); 

		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );
		$getId = $row2['id'];
		}
		
		
		
		if ($_GET['customerId']!="")
			$sql3 = "SELECT product.sku, product.code, product.image, product.name, company.businessName, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, cart.quantity, cart.productId, cart.market, cart.id, cart.price, cart.charge, cart.chargePercent, cart.discount, cart.discountPercent, cart.ownerId, cart.description FROM cart INNER JOIN products ON cart.productId=product.id INNER JOINbusinessON product.businessId=company.id WHERE cart.customerId=".$_GET['customerId']." AND cart.businessId=".$_GET['businessId']." ORDER BY product.name ASC;";  
		else
			if ($_GET['supplierId']!="")	
				$sql3 = "SELECT product.sku, product.code, product.image, product.name, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, cart.quantity, cart.productId, cart.market, cart.id, cart.price, cart.charge, cart.chargePercent, cart.discount, cart.discountPercent, cart.ownerId, cart.description FROM cart INNER JOIN products ON cart.productId=product.id WHERE cart.userId=".$_GET['userId']." AND cart.supplierId=".$_GET['supplierId']." ORDER BY product.name ASC;";  
			else
				$sql3 = "SELECT product.sku, product.code, product.image, product.name, company.businessName, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, cart.quantity, cart.productId, cart.market, cart.id, cart.price, cart.charge, cart.chargePercent, cart.discount, cart.discountPercent, cart.ownerId, cart.description FROM cart INNER JOIN products ON cart.productId=product.id INNER JOINbusinessON product.businessId=company.id WHERE cart.userId=".$_GET['userId']." AND cart.businessId=".$_GET['businessId']." ORDER BY product.name ASC;";  
		
		$stmt3 = mysqli_query( $conn, $sql3);
		
		echo $sql3;
		
		if ( $stmt3 ) {
		$sql4 = "";	
		while( $row3 = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC ))  
		{  
			
			if ($row3['market']==0) $price = $row3['priceRetail'];
			if ($row3['market']==1) $price = $row3['priceWholesale'];
			if ($row3['market']==2) $price = $row3['pricePrivate'];
			
			if ($row3['price']!="") $price = $row3['price'];
			
			$sql4.= "INSERT INTO orderDetails (orderId, productId, productSku, productName, image, quantity, pack, currency, price, market) VALUES ( ".$getId.", ".$row3['productId'].", N'".$row3['sku']."', N'".$row3['name']."', N'".$row3['image']."', ".$row3['quantity'].", ".$row3['packWholesale'].", N'".$row3['currency']."', ".$price.", ".$row3['market'].");";  
			
			if (is_null($row3['charge']))
				$charge = 0;
			else
				$charge = $row3['charge'];
			
			if (is_null($row3['chargePercent']))
				$chargePercent = 0;
			else
				$chargePercent = $row3['chargePercent'];
			
			if (is_null($row3['discount']))
				$discount = 0;
			else
				$discount = $row3['discount'];
			
			if (is_null($row3['discountPercent']))
				$discountPercent = 0;
			else
				$discountPercent = $row3['discountPercent'];
			
			if (is_null($row3['ownerId']))
				$ownerId = 0;
			else
				$ownerId = $row3['ownerId'];
			
			$description = $row3['description'];
		}
		}
		
		echo $sql4;
		
		$stmt4 = mysqli_query( $conn, $sql4); 
		
		if ( $stmt4 ) {
		
		if ($_GET['customerId']!="")
			$sql5 = "DELETE FROM cart WHERE customerId=".$_GET['customerId']." AND businessId=".$_GET['businessId'].";";  
		else
			if ($_GET['supplierId']!="")
				$sql5 = "DELETE FROM cart WHERE userId=".$_GET['userId']." AND supplierId=".$_GET['supplierId'].";";  
			else
				$sql5 = "DELETE FROM cart WHERE userId=".$_GET['userId']." AND businessId=".$_GET['businessId'].";";  
		
		
		echo $sql5;
		$stmt5 = mysqli_query( $conn, $sql5);  
		
		/*
		$sql6 = "SELECT COUNT(*) AS rowNum FROM supplier WHERE businessId=".$_GET['businessId'].";";
		$stmt6 = mysqli_query( $conn, $sql6);
		
		if ( $stmt6 ) {
		$row6 = mysqli_fetch_array( $stmt6, MYSQLI_ASSOC );
		$getSupplier = $row6['rowNum'];
		
			if ($row6['rowNum']==0) {
				
				$sql7 = "SELECT TOP 1 id, supplierCode FROM supplier WHERE id=".$_GET['businessId']." ORDER BY companyCode DESC;";    
				$stmt7 = mysqli_query( $conn, $sql7);  
				  
				if ( $stmt7 ) {
				$row7 = mysqli_fetch_array( $stmt7, MYSQLI_ASSOC );
				if (isset($row7['supplierCode']))
					$supplierCode = $row7['supplierCode'] + 1;
				else
					$supplierCode = 1;
				}		
				
				$sql8 = "UPDATE supplier SET supplierCode=".$supplierCode.", flagActive=1, registrationDate='".$date."' WHERE id='".$getSupplierId."';";
				$stmt8 = mysqli_query( $conn, $sql8);
			
			}
				
		
		}*/
		

		
		$sql9 = "UPDATE orders SET ownerId=".$ownerId.", charge=".$charge.", chargePercent=".$chargePercent.", discount=".$discount.", discountPercent=".$discountPercent.", flagStock=0, flagLogistic=0, flagAccounting=0, flagBuySell=".$buySell.", description=N'".$description."' WHERE id=".$getId.";";
		$stmt9 = mysqli_query( $conn, $sql9);
		
		echo $sql9;
		
		}	
		
	
}

//*********************************************************//

if ($_GET['action']=="sendAll")
{	

	if ($_GET['target']=="sale")
		if ($_GET['userbusinessId']!="")			
			$sqlCompany = "SELECT DISTINCT cart.customerId, cart.businessId, customer.businessName from cart inner join customer on cart.customerId=customer.id  where cart.customerId<>'' and cart.businessId=".$_GET['userbusinessId'].";";
		else
			$sqlCompany = "SELECT DISTINCT product.businessId, company.businessName from cart inner join products on cart.productId=product.id inner joinbusinesson product.businessId=company.id where cart.userId=".$_GET['userId'].";";

		
	if ($_GET['target']=="purchase")
		$sqlCompany = "SELECT DISTINCT cart.supplierId, supplier.businessName from cart inner join products on cart.productId=product.id inner join supplier on cart.supplierId=supplier.id where cart.userId=".$_GET['userId'].";";

	$stmtCompany = mysqli_query( $conn, $sqlCompany); 
	$total = 0;
	
	echo $sqlCompany;
	
	if ( $stmtCompany ) {

	while( $rowCompany = mysqli_fetch_array( $stmtCompany, MYSQLI_ASSOC ))  
	{  


		$date = date("Y-m-d");
		$time = date("H:i:s");
		
		
		if ($_GET['target']=="purchase")
			$sql0 = "SELECT id, requestId FROM orders WHERE businessId=".$_GET['userbusinessId']." AND flagBuySell=0 ORDER BY id DESC;";  
		
		if ($_GET['target']=="sale")
			$sql0 = "SELECT id, requestId FROM orders WHERE businessId=".$_GET['userbusinessId']." AND flagBuySell=1 ORDER BY id DESC;";  

		echo $sql0;
		$stmt0 = mysqli_query( $conn, $sql0); 
		
		if ( $stmt0 ) {
		$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );
		if ($row0['requestId']!="")
			$getRequestId = $row0['requestId'] + 1;
		else
			$getRequestId = 1;
		}
		
		if ($_GET['target']=="sale")
			$buySell = 1;
		
		if ($_GET['target']=="purchase")
			$buySell = 0;
		
	
		if ($_GET['target']=="sale")
			if ($_GET['userbusinessId']!="")	
				$sql1 = "INSERT INTO orders ( requestId, date, time, businessId, customerId, status, flagBuySell) VALUES ( ".$getRequestId.", N'".$date."', N'".$time."', ".$_GET['userbusinessId'].", ".$rowCompany['customerId'].", 0, ".$buySell.");";  
			else
				$sql1 = "INSERT INTO orders ( requestId, date, time, businessId, userId, status, flagBuySell) VALUES ( ".$getRequestId.", N'".$date."', N'".$time."', ".$_GET['userbusinessId'].", ".$_GET['userId'].", 0, ".$buySell.");";  
		
		if ($_GET['target']=="purchase")
			$sql1 = "INSERT INTO orders ( requestId, date, time, businessId, supplierId, userId, status, flagBuySell) VALUES ( ".$getRequestId.", N'".$date."', N'".$time."', ".$_GET['userbusinessId'].", ".$rowCompany['supplierId'].", ".$_GET['userId'].", 0, ".$buySell.");";  
		
		
		echo $sql1;
		
		$stmt1 = mysqli_query( $conn, $sql1); 
		
		if ($_GET['target']=="sale")
			$sql2 = "SELECT id FROM orders WHERE businessId=".$_GET['userbusinessId']." AND flagBuySell=1 ORDER BY id DESC;";  
		
		if ($_GET['target']=="purchase")
			$sql2 = "SELECT id FROM orders WHERE businessId=".$_GET['userbusinessId']." AND flagBuySell=0 ORDER BY id DESC;";  
		
		echo $sql2;
		$stmt2 = mysqli_query( $conn, $sql2); 

		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );
		$getId = $row2['id'];
		}
		
		if ($_GET['target']=="sale")
			if ($_GET['userbusinessId']!="")	
				$sql3 = "SELECT product.sku, product.code, product.image, product.name, company.businessName, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, cart.quantity, cart.quantity, cart.productId, cart.market, cart.id, cart.charge, cart.chargePercent, cart.discount, cart.discountPercent, cart.ownerId, cart.description FROM cart INNER JOIN products ON cart.productId=product.id INNER JOINbusinessON product.businessId=company.id WHERE cart.customerId=".$rowCompany['customerId']." AND cart.businessId=".$_GET['userbusinessId']." ORDER BY product.name ASC;";  
			else
				$sql3 = "SELECT product.sku, product.code, product.image, product.name, company.businessName, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, cart.quantity, cart.quantity, cart.productId, cart.market, cart.id, cart.charge, cart.chargePercent, cart.discount, cart.discountPercent, cart.ownerId, cart.description FROM cart INNER JOIN products ON cart.productId=product.id INNER JOINbusinessON product.businessId=company.id WHERE cart.userId=".$_GET['userId']." AND cart.businessId=".$_GET['userbusinessId']." ORDER BY product.name ASC;";  
		
		if ($_GET['target']=="purchase")
			$sql3 = "SELECT product.sku, product.code, product.image, product.name, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, cart.quantity, cart.quantity, cart.productId, cart.market, cart.id, cart.ownerId, cart.description FROM cart INNER JOIN products ON cart.productId=product.id WHERE cart.userId=".$_GET['userId']." AND cart.supplierId=".$rowCompany['supplierId']." ORDER BY product.name ASC;";  
		

		echo $sql3;
		$stmt3 = mysqli_query( $conn, $sql3);
		
		if ( $stmt3 ) {
		$sql4 = "";	
		while( $row3 = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC ))  
		{  
			if ($row3['market']==0) $price = $row3['priceRetail'];
			if ($row3['market']==1) $price = $row3['priceWholesale'];
			if ($row3['market']==2) $price = $row3['pricePrivate'];
			$sql4.= "INSERT INTO orderDetails (orderId, productId, productSku, productName, image, quantity, pack, currency, price, market) VALUES ( ".$getId.", ".$row3['productId'].", N'".$row3['sku']."', N'".$row3['name']."', N'".$row3['image']."', ".$row3['quantity'].", ".$row3['packWholesale'].", '".$row3['currency']."', ".$price.", ".$row3['market'].");";  
			
			if (is_null($row3['charge']))
				$charge = 0;
			else
				$charge = $row3['charge'];
			
			if (is_null($row3['chargePercent']))
				$chargePercent = 0;
			else
				$chargePercent = $row3['chargePercent'];
			
			if (is_null($row3['discount']))
				$discount = 0;
			else
				$discount = $row3['discount'];
			
			if (is_null($row3['discountPercent']))
				$discountPercent = 0;
			else
				$discountPercent = $row3['discountPercent'];
			
			if (is_null($row3['ownerId']))
				$ownerId = 0;
			else
				$ownerId = $row3['ownerId'];
			
			$description = $row3['description'];
		}
		}
		
		$stmt4 = mysqli_query( $conn, $sql4); 
		
		echo $sql4;
		
		
		if ( $stmt4 ) {
		
		if ($_GET['target']=="sale")
			if ($_GET['userbusinessId']!="")
				$sql5 = "DELETE FROM cart WHERE customerId=".$rowCompany['customerId']." AND businessId=".$_GET['userbusinessId'].";";  
			else
				$sql5 = "DELETE FROM cart WHERE userId=".$_GET['userId']." AND businessId=".$_GET['userbusinessId'].";";  
		
		if ($_GET['target']=="purchase")
			$sql5 = "DELETE FROM cart WHERE userId=".$_GET['userId']." AND supplierId=".$rowCompany['supplierId'].";";  
		
		echo $sql5;
		$stmt5 = mysqli_query( $conn, $sql5);  

		$sql9 = "UPDATE orders SET ownerId=".$ownerId.", charge=".$charge.", chargePercent=".$chargePercent.", discount=".$discount.", discountPercent=".$discountPercent.", flagStock=0, flagLogistic=0, flagAccounting=0, flagBuySell=".$buySell.", description=N'".$description."' WHERE id=".$getId.";";
		$stmt9 = mysqli_query( $conn, $sql9);
		echo $sql9;
		
		}

		
		
	}
	}
}

//*********************************************************//

/*

$sql = "SELECT * FROM cart ORDER BY id DESC";  
$stmt = mysqli_query( $conn, $sql);  

if ( $stmt ) {
while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC )) 
{
$json[] = $row;

foreach ($row as $key => $value) {
  echo $key.','.$value."<br/>";
}


}
}
else
 die( print_r( mysqli_error($conn), true));

echo json_encode($json);

*/



	




?>
