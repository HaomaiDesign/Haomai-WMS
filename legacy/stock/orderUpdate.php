<?php 
include '../system/session.php';

if ($_GET['status']!='')
{	
	$sql = "UPDATE orders SET status=".$_GET["status"]." WHERE id=".$_GET['id'].";";  
	$stmt = mysqli_query( $conn, $sql); 

	if ( $stmt ) {

	$_SESSION['notification']['type']="success";
	$_SESSION['notification']['message']="The status was updated properly.";

	} else {

	$_SESSION['notification']['type']="error";
	$_SESSION['notification']['message']="The status was not updated properly";
		

	}
	
	header ("Location: orderList.php?tableStatus=view");	

}

?>