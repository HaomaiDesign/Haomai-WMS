<?php
ob_start();
include '../system/session.php';
$date = date("Y-m-d");
$_SESSION['userLog']['module']="stock";
 
if ($_GET['formStatus']=='delete')
{
	$_SESSION['form']['table']= 'warehouse'; 
	$_SESSION['form']['condition'] = "id=".$_GET['id'];
	
}

include '../system/formQuery.php';

if ($_GET['formStatus']!='view')
{
$stmt = mysqli_query( $conn, $sql);  
  
if ( $stmt ) {
	
	if ($_GET['formStatus']=='create')
	{	

		$sql1 = "SELECT warehouseId FROM warehouse WHERE businessId=".$_SESSION['user']['businessId']." ORDER BY warehouseId DESC;";  
		$stmt1 = mysqli_query( $conn, $sql1);  
		  
		if ( $stmt1 ) {
		$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );  
		$getWarehouseId = $row1['warehouseId']+1;	
		}

		$sql2 = "SELECT id FROM warehouse ORDER BY id DESC LIMIT 1;";  
		$stmt2 = mysqli_query( $conn, $sql2);  
		  
		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );  
		$getProductId = $row2['id'];	
		}
		
		if ($_POST['code']!="")
			$code = $_POST['code'];
		else
			$code = str_pad($getWarehouseId, 4, "0", STR_PAD_LEFT);
		
		$sql3 = "UPDATE warehouse SET warehouseId=".$getWarehouseId.",code=N'".$code."' WHERE id=".$getProductId.";";  
		$stmt3 = mysqli_query( $conn, $sql3); 
	
	
		header ("Location: warehouse.php?tableStatus=view");
	}	
	
	if ($_GET['formStatus']=='delete')
	{	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The item ID ".$_GET['id']." was removed properly.";
		//$_SESSION['userLog']['description']="The item ID ".$_GET['id']." was removed properly.";
		header ("Location: warehouse.php?tableStatus=view");
	}
	
	if ($_GET['formStatus']=='edit')
	{	

		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The item ID ".$_GET['id']." was updated properly.";
		//$_SESSION['userLog']['description']="The item ID ".$_GET['id']." was updated properly.";
		header ("Location: warehouse.php?tableStatus=view");
	}	
}
else   
{  
    
     die( print_r( mysqli_error($conn), true));  
		
}  
ob_end_flush();
mysqli_free_result( $stmt);  
mysqli_close( $conn);  
}

?>































