<?php include "../system/db.php"; 
date_default_timezone_set('America/Argentina/Buenos_Aires');

//**************************************************//

if ($_GET['action']=="add")
{
$sql0 = "SELECT * FROM product WHERE id=".$_GET['productId'].";";  	
$stmt0 = mysqli_query( $conn, $sql0); 

if ( $stmt0 ) {
$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );

if ($_GET['market']=="wholesale") {
$quantity = $row0['packWholesale'];
$price = $row0['priceWholesale'];
$market = 1;
}

if ($_GET['market']=="retail") {
$quantity = 1;
$price = $row0['priceRetail'];
$market = 0;
}
	
$sql= "INSERT INTO swrOrderDetails (orderId, productId, productSku, productName, image, quantity, pack, currency, price, market) VALUES ( ".$_GET['id'].", ".$_GET['productId'].", N'".$row0['sku']."', N'".$row0['name']."', N'".$row0['image']."', ".$quantity.", ".$row0['packWholesale'].", N'".$row0['currency']."', ".$price.", ".$market.");";  
$stmt = mysqli_query( $conn, $sql);

	if ( $stmt ) {
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="Producto agregado";
	} else	{
		$_SESSION['notification']['type']="error";
		$_SESSION['notification']['message']="No se pudo agregar, intente mas tarde.";	
	}
 
}	

header ("Location: orderDetails.php?formStatus=view&tableStatus=view&companyId=".$_GET['companyId']."&supplierId=".$_GET['supplierId']."&userId=".$_GET['userId']."&customerId=".$_GET['customerId']."&roleId=".$_GET['roleId']."&status=".$_GET['status']."&requestId=".$_GET['requestId']."&id=".$_GET['id']."&target=".$_GET['target']);
		
}
?>
