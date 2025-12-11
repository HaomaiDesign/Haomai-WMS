<?php 
session_start();
include "../system/db.php"; 
date_default_timezone_set('America/Argentina/Buenos_Aires');

//*********************************************************//

if ($_GET['action']=="page")
{	

if ($_GET['userId']!="") $condition = "userId=".$_GET['userId'];
if ($_GET['businessId']!="") $condition = "businessId=".$_GET['businessId'];

$sql0 = "SELECT COUNT(*) AS rowNum FROM orders WHERE ".$condition.";";  
$stmt0= mysqli_query( $conn, $sql0); 

if ( $stmt0 ) {
$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );  
$getRow = $row0['rowNum'];
$limit = 10;

if ($getRow!=""){
	
$min = $getRow - $limit * $_GET['page'];
$max = $getRow - $limit * $_GET['page'] + $limit;	
	
if ($min<0) $min = 0;


$sql1 = "SELECT * FROM ( SELECT SELECT product.id, product.sku, product.code, product.image, product.name, company.businessName, product.category, product.currency, product.priceRetail, ROW_NUMBER() OVER (ORDER BY product.id) as row FROM products INNER JOINbusinesson product.businessId=company.id ) as alias WHERE row>".$min." and row<=".$max." ORDER BY id DESC;";  
$stmt1 = mysqli_query( $conn, $sql1);  	


if ( $stmt1 ) {
while( $row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC )) 
{
$json[] = $row1;
}

echo json_encode($json);

}
}
}
}


if ($_GET['action']=="discontinuedProducts"){
	$selectedRows = $_GET['selectedRows'];
	if (count($selectedRows) == 0) {
		$json = array("status" => "error", "message" => "No products selected.");
		echo json_encode($json);
		return;
	}
	$selectedRows = implode("','", $selectedRows);
	$sql = "UPDATE products SET flagDiscontinued=1 WHERE unitBarcode IN ('$selectedRows');";
	$stmt= mysqli_query( $conn, $sql);
}

//*********************************************************//

if ($_GET['action']=="market")
{	

if ($_GET['market']==1)
	$sql = "UPDATE products SET flagMarket=".$_GET['market']." WHERE id=".$_GET['productId'].";";  
else
	$sql = "UPDATE products SET flagMarket=".$_GET['market'].", flagGroup3=0 WHERE id=".$_GET['productId'].";";  

$stmt= mysqli_query( $conn, $sql); 

$date = date("Y-m-d");
$time = date("H:i:s");
$sqlUserLog = "INSERT INTO userLog ( userId, userLogDate, userLogTime, module, description) VALUES ( N'".$_SESSION['user']['id']."', N'".$date."', N'".$time."', N'Products', N'Product ID ".$_GET['productId'].". The products market status was changed to ".$_GET['market'].".');";  
$stmtUserLog = mysqli_query( $conn, $sqlUserLog);  

}

//*********************************************************//

if ($_GET['action']=="market2")
{	
$sql = "UPDATE products SET flagMarket2=".$_GET['market']." WHERE id=".$_GET['productId'].";";  
$stmt= mysqli_query( $conn, $sql); 

$date = date("Y-m-d");
$time = date("H:i:s");
$sqlUserLog = "INSERT INTO userLog ( userId, userLogDate, userLogTime, module, description) VALUES ( N'".$_SESSION['user']['id']."', N'".$date."', N'".$time."', N'Products', N'Product ID ".$_GET['productId'].". The products market 2 status was changed to ".$_GET['market'].".');";  
$stmtUserLog = mysqli_query( $conn, $sqlUserLog);  

}


//*********************************************************//

if ($_GET['action']=="active")
{	
$sql = "UPDATE products SET flagActive=".$_GET['active']." WHERE id=".$_GET['productId'].";";  
$stmt= mysqli_query( $conn, $sql); 

$date = date("Y-m-d");
$time = date("H:i:s");
$sqlUserLog = "INSERT INTO userLog ( userId, userLogDate, userLogTime, module, description) VALUES ( N'".$_SESSION['user']['id']."', N'".$date."', N'".$time."', N'Products', N'Product ID ".$_GET['productId'].". The products active status was changed to ".$_GET['active'].".');";  
$stmtUserLog = mysqli_query( $conn, $sqlUserLog);  

}

//*********************************************************//

if ($_GET['action']=="group")
{	
$sql = "UPDATE products SET ".$_GET['variable']."=".$_GET['value']." WHERE id=".$_GET['productId'].";";  
$stmt= mysqli_query( $conn, $sql); 

$date = date("Y-m-d");
$time = date("H:i:s");
$sqlUserLog = "INSERT INTO userLog ( userId, userLogDate, userLogTime, module, description) VALUES ( N'".$_SESSION['user']['id']."', N'".$date."', N'".$time."', N'Products', N'Product ID ".$_GET['productId'].". The ".$_GET['variable']." was changed to ".$_GET['value'].".');";  
$stmtUserLog = mysqli_query( $conn, $sqlUserLog);  

}

//*********************************************************//

if ($_GET['action']=="remove")
{	

$sql = "UPDATE products SET flagActive=0, flagMarket=0 WHERE id=".$_GET['productId'].";";  


$stmt= mysqli_query( $conn, $sql); 

$date = date("Y-m-d");
$time = date("H:i:s");
$sqlUserLog = "INSERT INTO userLog ( userId, userLogDate, userLogTime, module, description) VALUES ( N'".$_SESSION['user']['id']."', N'".$date."', N'".$time."', N'Products', N'Product ID ".$_GET['productId'].". The products was removed from products list.');";  
$stmtUserLog = mysqli_query( $conn, $sqlUserLog);  

}

//*********************************************************//

if ($_GET['action']=="sort")
{	

$sql1 = "SELECT COUNT(id) AS allProducts FROM products WHERE businessId=".$_GET['businessId'].";";  
$stmt1= mysqli_query( $conn, $sql1); 

if ( $stmt1 ) {
$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );  
$allProducts = $row1['allProducts'] ;
}


if ($_GET['sortValue']<=$allProducts)
{
	
	if ($_GET['oldSortValue']>$_GET['sortValue']) {
	
	$sql2 = "UPDATE products SET sortId=sortId+1 WHERE businessId=".$_GET['businessId']." AND sortId BETWEEN ".$_GET['sortValue']." AND ".$_GET['oldSortValue'].";";
	$sql2.= "UPDATE products SET sortId=".$_GET['sortValue']." WHERE id=".$_GET['productId'].";";  
	$stmt2= mysqli_query( $conn, $sql2); 
	}
   
   ///// Abajo
	if ($_GET['oldSortValue']<$_GET['sortValue']) {
		
	$sql2 = "UPDATE products SET sortId=sortId-1 WHERE businessId=".$_GET['businessId']." AND sortId BETWEEN ".$_GET['oldSortValue']." AND ".$_GET['sortValue'].";";
	$sql2.= "UPDATE products SET sortId=".$_GET['sortValue']." WHERE id=".$_GET['productId'].";";  
	$stmt2= mysqli_query( $conn, $sql2); 
	
	}
	
	/*
	///// Arriba
	if ($_GET['oldSortValue']>$_GET['sortValue']) {
		
	$num = $_GET['oldSortValue'] - 1;

	$sql2= "UPDATE products SET sortId=0 WHERE sortId=".$_GET['oldSortValue']." AND businessId=".$_GET['businessId'].";";

	for ($x = $num; $x >= $_GET['sortValue'] ; $x--) {
	$newValue = $x + 1;
	$sql2.= "UPDATE products SET sortId=".$newValue." WHERE sortId=".$x." AND businessId=".$_GET['businessId'].";";
	}

	$sql2.= "UPDATE products SET sortId=".$_GET['sortValue']." WHERE id=".$_GET['productId'].";";  
	$stmt2= mysqli_query( $conn, $sql2); 
	}
    ///// Abajo
	if ($_GET['oldSortValue']<$_GET['sortValue']) {
		
	$num = $_GET['oldSortValue'] + 1;

	$sql2= "UPDATE products SET sortId=0 WHERE sortId=".$_GET['oldSortValue']." AND businessId=".$_GET['businessId'].";";

	for ($x = $num; $x <= $_GET['sortValue'] ; $x++) {
	$newValue = $x - 1;
	$sql2.= "UPDATE products SET sortId=".$newValue." WHERE sortId=".$x." AND businessId=".$_GET['businessId'].";";
	}

	$sql2.= "UPDATE products SET sortId=".$_GET['sortValue']." WHERE id=".$_GET['productId'].";";  
	$stmt2= mysqli_query( $conn, $sql2); 
	}
	////
	*/
}

}
?>
