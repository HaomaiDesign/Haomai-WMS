<?php 
session_start();
include "../system/db.php"; 


// (table, id, variable, value, type)
// type = 1 (string)
// type = 2 (number)

//**************************************************//

if ($_GET['action']=="update") {
	
if ($_GET['type']==1)
	$sql= "UPDATE ".$_GET['table']." SET ".$_GET['variable']."=N'".$_GET['value']."' WHERE id=".$_GET['id'].";"; 	

if ($_GET['type']==2)
	if ($_GET['value']==0)
		$sql= "UPDATE ".$_GET['table']." SET ".$_GET['variable']."=0 WHERE id=".$_GET['id'].";";
	else
		$sql= "UPDATE ".$_GET['table']." SET ".$_GET['variable']."=".$_GET['value']." WHERE id=".$_GET['id'].";"; 	

$stmt = mysqli_query( $conn, $sql);  

$date = date("Y-m-d");
$time = date("H:i:s");
$sqlUserLog = "INSERT INTO userLog ( userId, userLogDate, userLogTime, module, description) VALUES ( ".$_SESSION['user']['id'].", N'".$date."', N'".$time."', N'".$_GET['table']."', N'".$_GET['table']." ID ".$_GET['id'].". The variable ".$_GET['variable']." was changed to ".$_GET['value'].".');";  
$stmtUserLog = mysqli_query( $conn, $sqlUserLog);  

}


//**************************************************//



if ($_GET['action']=="remove") {
	
$sql= "DELETE FROM ".$_GET['table']." WHERE id=".$_GET['id'].";"; 	
$stmt = mysqli_query( $conn, $sql);  

$date = date("Y-m-d");
$time = date("H:i:s");
$sqlUserLog = "INSERT INTO userLog ( userId, userLogDate, userLogTime, module, description) VALUES ( ".$_SESSION['user']['id'].", N'".$date."', N'".$time."', N'".$_GET['table']."', N'Register ID ".$_GET['id']." was removed. The variable ".$_GET['variable']." was ".$_GET['value'].".');";  
$stmtUserLog = mysqli_query( $conn, $sqlUserLog);  

}

//**************************************************//

if ($_GET['action']=="updateDueDate") {
	$dueDateFormatted = date("Y-m-d", strtotime($_GET['dueDate']));
	//strtotime($_GET['dueDate']);
	$sql= "UPDATE orderDetails SET newDueDate='".$dueDateFormatted."' WHERE id=".$_GET['productId'].";"; 	
	$stmt = mysqli_query( $conn, $sql);  
	
	$date = date("Y-m-d");
	$time = date("H:i:s");
	$sqlUserLog = "INSERT INTO userLog ( userId, userLogDate, userLogTime, module, description) VALUES ( ".$_SESSION['user']['id'].", N'".$date."', N'".$time."', N'".$_GET['table']."', N'".$_GET['table']." ID ".$_GET['id'].". The variable ".$_GET['variable']." was changed to ".$_GET['value'].".');";  
	$stmtUserLog = mysqli_query( $conn, $sqlUserLog);  

}
	
//**************************************************//

if ($_GET['action']=="flagCompanyActive") {	
$sql = "UPDATE business SET flagCompanyActive=".$_GET['market']." WHERE id=".$_GET['businessId'].";";  
$stmt= mysqli_query( $conn, $sql);  
}
?>
