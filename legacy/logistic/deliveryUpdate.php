<?php 
include '../system/session.php';

if ($_GET['action']=='remove')
{	
	$sql = "UPDATE orders SET deliveryId=0, flagLogistic=0 WHERE id=".$_GET['id'].";";  
	$stmt = mysqli_query( $conn, $sql); 
	
	header ("Location: deliveryList.php?tableStatus=view&target=company&deliveryId=".$_GET['deliveryId']."&page=1");
	
}

///////////////////////////////////////////////////

if ($_GET['action']=='select')
{	
	if ($_GET['selected']==1)
		$_SESSION['delivery']['id'][$_GET['id']] = $_GET['id'];

	if ($_GET['selected']==0) {

		unset($_SESSION['delivery']['id'][$_GET['id']]);
		
	}
	
	

}

///////////////////////////////////////////////////

if ($_GET['action']=='clear')
{	
	unset($_SESSION['delivery']);
}

///////////////////////////////////////////////////

if ($_GET['action']=='assign')
{	
	
	$datetime = date("Y-m-d H:i:s");
	
	$sql0 = "SELECT id, deliveryCode FROM lgtDelivery WHERE businessId=".$_GET['businessId']." ORDER BY deliveryCode DESC;";  
	$stmt0 = mysqli_query( $conn, $sql0); 
		
	if ( $stmt0 ) {
	$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );
	if (isset($row0['deliveryCode']))
		$getDeliveryCode = $row0['deliveryCode'] + 1;
	else
		$getDeliveryCode = 1;
	}
	
	if ($_GET['deliveryUserId']!="")
		$sql1 = "INSERT INTO lgtDelivery (businessId, userId, deliveryCode, datetime) VALUES ( ".$_GET['businessId'].", ".$_GET['deliveryUserId'].", '".$getDeliveryCode."', '".$datetime."');";  
	else
		$sql1 = "INSERT INTO lgtDelivery (businessId, deliveryCode, datetime) VALUES ( ".$_GET['businessId'].", '".$getDeliveryCode."', '".$datetime."');";  
	
	$stmt1 = mysqli_query( $conn, $sql1);
	
	$sql2 = "SELECT id FROM lgtDelivery WHERE businessId=".$_GET['businessId']." ORDER BY id DESC;";  
	$stmt2 = mysqli_query( $conn, $sql2); 


	if ( $stmt2 ) {
	$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );
	$getId = $row2['id'];
	}
	
	$sql3="";
	foreach($_SESSION['delivery']['id'] as $id){
		$sql3.="UPDATE orders SET deliveryId=".$getId.", flagLogistic=1 WHERE id=".$id.";";
	}

	$stmt3 = mysqli_query( $conn, $sql3); 
	
	if ( $stmt3 ) {
		unset($_SESSION['delivery']);
	}
	
}
?>