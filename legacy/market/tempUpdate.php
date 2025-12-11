<?php
include '../system/session.php';

$date = date("Y-m-d");
$_SESSION['userLog']['module']="Customer";

if ($_GET['formStatus']=='delete')
{
	$_SESSION['form']['table']= 'customer'; 
	$_SESSION['form']['condition'] = "id=".$_GET['id'];
	
}

include '../system/formQuery.php';


if ($_GET['action']=='update')
{	
	$sql1 = "UPDATE swrCart SET tempId='', customerId=".$_GET['customerId'].", charge=0, chargePercent=0, discount=0, discountPercent=0, businessName='', address='', taxId='', phone='' WHERE tempId=".$_GET['tempId'].";";     
	$stmt1 = mysqli_query( $conn, $sql1);
	header ("Location: ../market/marketCart.php?tableStatus=view&target=sale&page=1");
}

if (($_GET['formStatus']=='create'))
{
$stmt = mysqli_query( $conn, $sql);  
  
if ( $stmt ) {
	
	if ($_GET['formStatus']=='create')
	{	


			
		$sql1 = "SELECT TOP 1 id, code FROM customer WHERE companyId=".$_SESSION['user']['companyId']." ORDER BY code DESC;";    
		$stmt1 = mysqli_query( $conn, $sql1);  
		  
		if ( $stmt1 ) {
		$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );
		if (isset($row1['code']))
			$code = $row1['code'] + 1;
		else
			$code = 1;
		}
		
		$sql2 = "SELECT TOP 1 id FROM customer WHERE companyId=".$_SESSION['user']['companyId']." ORDER BY id DESC";  
		$stmt2 = mysqli_query( $conn, $sql2);  
		  
		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );  
		$getCustomerId = $row2['id'];		
		}
		
		$sql3 = "UPDATE customer SET code='".$code."', creationDate='".$date."', flagActive=1 WHERE id='".$getCustomerId."';"; 
		$stmt3 = mysqli_query( $conn, $sql3);  
		
		
		if ($_SESSION["form"]["imageFile"]!=""){
		
		$_SESSION['form']['imageDir'] = "../assets/images/customer/".$getCustomerId."/";
		$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];	
		
			mkdir($_SESSION["form"]["imageDir"], 0777);	
			
			if (move_uploaded_file($_FILES["logo"]["tmp_name"], $_SESSION["form"]["imageFile"])) {
					
					$sql4 = "UPDATE customer SET logo='".$_SESSION["form"]["imageFile"]."' WHERE id='".$getCustomerId."';"; 
					$stmt4 = mysqli_query( $conn, $sql4);
						
					$_SESSION['user']['logo'] = $_SESSION["form"]["imageFile"];
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']=$_SESSION['language']['The customer profile is updated properly'];
					$_SESSION['userLog']['description']="The customer profile is updated properly";
					
				} else {
					
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="Error to update the logo in the server for the customer profile ID ".$getCustomerId.".";
				$_SESSION['userLog']['description']="Error to update the logo in the server for the customer profile ID ".$getCustomerId.".";
									
			} 
		}
		else {
			$_SESSION['notification']['type']="warning";
			$_SESSION['notification']['message']=$_SESSION['language']['The customer profile is updated properly'];
			$_SESSION['userLog']['description']="The customer profile is updated properly";
		}
			
			header ("Location: ../market/temp.php?tableStatus=view&customerId=".$getCustomerId."&tempId=".$_GET['tempId']."&page=1");
			
		
		///////////////////////////
		
		

	}



	
}
else   
{  
    
     die( print_r( sqlsrv_errors(), true));  
		
}  
mysqli_free_result( $stmt);  
mysqli_close( $conn); 
} 
?>































