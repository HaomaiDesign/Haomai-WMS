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

if (($_GET['formStatus']=='create')or($_GET['formStatus']=='edit')or($_GET['formStatus']=='delete'))
{
$stmt = mysqli_query( $conn, $sql);  
  
if ( $stmt ) {
	
	if ($_GET['formStatus']=='create')
	{	

		if (($_GET['target']=='sale')OR($_GET['target']=='customer')) {
			
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
		
		$sql3 = "UPDATE customer SET code='".$code."', flagActive=1, creationDate='".$date."' WHERE id='".$getCustomerId."';"; 
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
		
		if ($_GET['target']=='sale')		
			header ("Location: ../market/market.php?tableStatus=view&market=wholesale&target=sale&customerId=".$getCustomerId."&page=1");
		
		if ($_GET['target']=='customer')		
			header ("Location: ../market/list.php?tableStatus=view&target=customer&page=1");
		
		}	
		
		
		///////////////////////////
		
		
		if (($_GET['target']=='purchase')OR($_GET['target']=='supplier')) {
			
		$sql1 = "SELECT TOP 1 id FROM supplier ORDER BY id DESC;"; 
		$stmt1 = mysqli_query( $conn, $sql1);  
		  
		if ( $stmt1 ) {
		$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );  
		$getSupplierId = $row1['id'];		
		}
		
		$sql2 = "SELECT TOP 1 id, supplierCode FROM supplier WHERE companyId=".$_SESSION['user']['companyId']." ORDER BY supplierCode DESC;";    
		$stmt2 = mysqli_query( $conn, $sql2);  
		  
		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );
		if (isset($row2['supplierCode']))
			$supplierCode = $row2['supplierCode'] + 1;
		else
			$supplierCode = 1;
		}		
			
		$sql3 = "UPDATE supplier SET supplierCode=".$supplierCode.", flagActive=1, registrationDate='".$date."' WHERE id='".$getSupplierId."';"; 
		$stmt3 = mysqli_query( $conn, $sql3);  
		
		if ($_SESSION["form"]["imageFile"]!=""){
		
		$_SESSION['form']['imageDir'] = "../assets/images/company/".$getCompanyId."/";
		$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];	
		
			mkdir($_SESSION["form"]["imageDir"], 0777);	
			
			if (move_uploaded_file($_FILES["logo"]["tmp_name"], $_SESSION["form"]["imageFile"])) {
					
					$sql4 = "UPDATE supplier SET logo='".$_SESSION["form"]["imageFile"]."' WHERE id='".$getSupplierId."';"; 
					$stmt4 = mysqli_query( $conn, $sql4);
						
					$_SESSION['user']['logo'] = $_SESSION["form"]["imageFile"];
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']=$_SESSION['language']['The company profile is updated properly'];
					$_SESSION['userLog']['description']="The company profile is updated properly";
					
				} else {
					
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="Error to update the logo in the server for the company profile ID ".$getSupplierId.".";
				$_SESSION['userLog']['description']="Error to update the logo in the server for the company profile ID ".$getSupplierId.".";
									
			} 
		}
		else {
			$_SESSION['notification']['type']="warning";
			$_SESSION['notification']['message']=$_SESSION['language']['The company profile is updated properly'];
			$_SESSION['userLog']['description']="The company profile is updated properly";
		}
		
		if ($_GET['target']=='purchase')		
			header ("Location: ../market/market.php?tableStatus=view&market=wholesale&target=purchase&supplierId=".$getSupplierId."&page=1");
		
		if ($_GET['target']=='supplier')		
			header ("Location: ../market/list.php?tableStatus=view&target=supplier&page=1");
		
		}
		

	}

	if ($_GET['formStatus']=='edit')
	{	
		

		if ($_SESSION["form"]["imageFile"]!=""){
			
		$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];	
		
			mkdir($_SESSION["form"]["imageDir"], 0777);
		
				if (move_uploaded_file($_FILES["logo"]["tmp_name"], $_SESSION["form"]["imageFile"])) {
								
					$_SESSION['user']['logo'] = $_SESSION["form"]["imageFile"];
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']="The customer profile ID ".$_SESSION['user']['companyId']." was created propertly.";
					$_SESSION['userLog']['description']="The customer profile ID ".$_SESSION['user']['companyId']." was created propertly.";
				} 
				else 
				{
					$_SESSION['notification']['type']="warning";
					$_SESSION['notification']['message']="The customer profile ID ".$_SESSION['user']['companyId']." was created propertly without logo.";
					$_SESSION['userLog']['description']="The customer profile ID ".$_SESSION['user']['companyId']." was created propertly without logo.";
				}
			
				
		}
		else
		{
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The customer profile ID ".$_SESSION['user']['companyId']." was updated propertly.";		
		$_SESSION['userLog']['description']="The customer profile ID ".$_SESSION['user']['companyId']." was updated propertly.";	
		
		}
		
		header ("Location: list.php?tableStatus=view");
	}

	if ($_GET['formStatus']=='delete')
	{	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The customer ID ".$_GET['id']." was removed properly.";
		$_SESSION['userLog']['description']="The customer ID ".$_GET['id']." was removed properly.";
		header ("Location: list.php?tableStatus=view&page=1");
	}	
}
else   
{  
    
     die( print_r( mysqli_error($conn), true));  
		
}  
mysqli_free_result( $stmt);  
mysqli_close( $conn); 
} 
?>































