<?php include "../system/db.php"; 
date_default_timezone_set('America/Argentina/Buenos_Aires');

//*********************************************************//

if ($_GET['action']=="add")
{	
$sql0 = "SELECT TOP 1 * FROM users WHERE email='".$_GET['email']."';";  
$stmt0= mysqli_query( $conn, $sql0); 

if ( $stmt0 ) {
$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );  

$sql1 = "SELECT TOP 1 * FROM swrPrivate WHERE businessId=".$_GET['businessId']." AND userId=".$row0['id'].";";  
$stmt1= mysqli_query( $conn, $sql1); 
$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC ); 

if ($row1['id']=="")
{
$sql2 = "INSERT INTO swrPrivate (businessId, userId) VALUES ( ".$_GET['businessId'].", ".$row0['id'].");";  
$stmt2 = mysqli_query( $conn, $sql2);  	
}
}
}

//*********************************************************//

if ($_GET['action']=="remove")
{	
$sql = "DELETE FROM swrPrivate WHERE id=".$_GET['id'].";";  
$stmt = mysqli_query( $conn, $sql);  	
}

?>
