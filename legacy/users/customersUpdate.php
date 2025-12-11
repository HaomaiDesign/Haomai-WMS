<?php
ob_start();
include '../system/session.php';
$_SESSION['userLog']['module']="Customers";

if ($_GET['action']!='') {
	
	if ($_GET['action']=='addOrder') {
		
		$sql = "SELECT * FROM customers WHERE id=".$_GET['customerId'].";";
		$stmt = mysqli_query( $conn, $sql);  
		
			
		if ( $stmt ) {
			while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC  ))  
			{  
		
			$sqlUpdate = "UPDATE orders SET businessName=N'".$row['businessName']."', taxId=N'".$row['taxId']."', phone=N'".$row['phone']."', whatsapp=N'".$row['whatsapp']."', wechat=N'".$row['wechat']."', email=N'".$row['email']."', address=N'".$row['address']."', postalCode=N'".$row['postalCode']."', location=N'".$row['location']."', province=N'".$row['province']."', country=N'".$row['country']."', description=N'".$row['description']."' WHERE id=".$_GET['orderId'].";";
			$stmtUpdate = mysqli_query( $conn, $sqlUpdate);  
				
				
				
				if ( $stmtUpdate ) {
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']="The customer information was added propertly.";
					$_SESSION['userLog']['description']="The customer information was added propertly.";
										
					header ("Location: ../market/orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$_GET['orderId']."&roleId=".$_GET['roleId']);
				} else {
					$_SESSION['notification']['type']="error";
					$_SESSION['notification']['message']="The customer information was not added propertly.";
					$_SESSION['userLog']['description']="The customer information was not added propertly.";
					
					header ("Location: ../market/orderDetails.php?formStatus=view&tableStatus=view&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$_GET['orderId']);
					
				}
			}
		}
		
	}
	
} else {
 
if ($_GET['formStatus']=='delete')
{
	$_SESSION['form']['table']= 'customers'; 
	$_SESSION['form']['condition'] = "id=".$_GET['id'];
	
}



include '../system/formQuery.php';

if ($_GET['formStatus']!='view')
{
$stmt = mysqli_query( $conn, $sql);  
  
if ( $stmt ) {
	
	if ($_GET['formStatus']=='create')
	{	
	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The new user was created propertly.";
		$_SESSION['userLog']['description']="The new user was created propertly.";
							
		if(isset($_POST["orderId"])){
			header ("Location: customers.php?tableStatus=view&target=".$_POST["target"]."&orderId=".$_POST["orderId"]."&roleId=".$_SESSION["user"]["roleId"]);
		} else {
			header ("Location: customers.php?tableStatus=view");
		}	
		exit();
		
	}	
	
	if ($_GET['formStatus']=='delete')
	{	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The user ID ".$_GET['id']." was removed properly.";
		$_SESSION['userLog']['description']="The user ID ".$_GET['id']." was removed properly.";
		header ("Location: customers.php?tableStatus=view");
	}
	
	if ($_GET['formStatus']=='edit')
	{	
	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The user ID ".$_GET['id']." was updated propertly.";
		$_SESSION['userLog']['description']="The user ID ".$_GET['id']." was updated propertly.";
		header ("Location: customers.php?tableStatus=view");
		
	}	
}
else   
{  
    
     die( print_r( mysqli_error($conn), true));  
		
}  
 
}


}
ob_end_flush();
mysqli_free_result( $stmt);  
mysqli_close( $conn); 

?>































