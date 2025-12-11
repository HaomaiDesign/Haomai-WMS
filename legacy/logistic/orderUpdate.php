<?php 
include '../system/session.php';

if ($_GET['action']=='update')
{	
	$sql = "UPDATE orders SET flagLogistic=".$_GET["newStatus"]." WHERE id=".$_GET['statusId'].";";  
	$stmt = mysqli_query( $conn, $sql); 

}

///////////////////////////////////////////////////

if ($_GET['action']=='remove')
{	
	$sql = "UPDATE orders SET deliveryId=0, flagLogistic=0 WHERE deliveryId=".$_GET['id'].";";  
	$sql.= "DELETE FROM delivery WHERE id=".$_GET['id'].";";  
	$stmt = mysqli_multi_query( $conn, $sql); 
	
	header ("Location: delivery.php?tableStatus=view&page=1");
	
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
	
	if ($_GET['deliveryId']!='') {
		
		$sql3="";
		foreach($_SESSION['delivery']['id'] as $id){
			$sql3.="UPDATE orders SET deliveryId=".$_GET['deliveryId'].", status=8, flagLogistic=1 WHERE id=".$id.";";
		}

		$stmt3 = mysqli_multi_query( $conn, $sql3); 
		
		if ( $stmt3 ) {
			unset($_SESSION['delivery']);
		}
		
		
	}
	else
	{
		
		$datetime = date("Y-m-d H:i:s");
		
		$sql0 = "SELECT id, deliveryCode FROM delivery WHERE businessId=".$_GET['businessId']." ORDER BY deliveryCode DESC;";  
		$stmt0 = mysqli_query( $conn, $sql0); 
			
		if ( $stmt0 ) {
		$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );
		if (isset($row0['deliveryCode']))
			$getDeliveryCode = $row0['deliveryCode'] + 1;
		else
			$getDeliveryCode = 1;
		}
		
		if ($_GET['deliveryUserId']!="")
			$sql1 = "INSERT INTO delivery (businessId, userId, deliveryCode, datetime) VALUES ( ".$_GET['businessId'].", ".$_GET['deliveryUserId'].", '".$getDeliveryCode."', '".$datetime."');";  
		else
			$sql1 = "INSERT INTO delivery (businessId, deliveryCode, datetime) VALUES ( ".$_GET['businessId'].", '".$getDeliveryCode."', '".$datetime."');";  
		
		$stmt1 = mysqli_query( $conn, $sql1);
		
		$sql2 = "SELECT id FROM delivery WHERE businessId=".$_GET['businessId']." ORDER BY id DESC;";  
		$stmt2 = mysqli_query( $conn, $sql2); 


		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );
		$getId = $row2['id'];
		}
		
		$sql3="";
		foreach($_SESSION['delivery']['id'] as $id){
			$sql3.="UPDATE orders SET deliveryId=".$getId.", status=8, flagLogistic=1 WHERE id=".$id.";";
		}

		$stmt3 = mysqli_multi_query( $conn, $sql3); 
		
		if ( $stmt3 ) {
			unset($_SESSION['delivery']);
		}
	
	}
	
}
?>