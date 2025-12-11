<?php
include '../system/session.php';

$date = date("Y-m-d");
$_SESSION['form']['table']= $_GET['table']; 



if ($_GET['formStatus']=='delete') {

if ($_GET['target']=="supplier") {		
	$sql = "UPDATE supplier SET flagActive=0 WHERE id=".$_GET['id'].";"; 
	$stmt = mysqli_query( $conn, $sql);  
}
if ($_GET['target']=="customer") {
	$sql = "UPDATE customer SET flagActive=0 WHERE id=".$_GET['id'].";"; 
	$stmt = mysqli_query( $conn, $sql);  
}

if ( $stmt ) {
$_SESSION['notification']['type']="success";
$_SESSION['notification']['message']="The customer ID ".$_GET['id']." was removed properly.";
$_SESSION['userLog']['description']="The customer ID ".$_GET['id']." was removed properly.";
}

header ("Location: list.php?tableStatus=view&target=".$_GET['target']."&page=1");

}



if (($_GET['formStatus']=='create')or($_GET['formStatus']=='edit'))
{

include '../system/formQuery.php';
$stmt = mysqli_query( $conn, $sql);  
  
if ( $stmt ) {
	
	if ($_GET['formStatus']=='create')
	{	
		if ($_GET['target']=="supplier") {

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
		
		$_SESSION['form']['imageDir'] = "../assets/images/company/".$getSupplierId."/";
		$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];	
		
			mkdir($_SESSION["form"]["imageDir"], 0777);	
			
			if (move_uploaded_file($_FILES["logo"]["tmp_name"], $_SESSION["form"]["imageFile"])) {
					
					$sql5 = "UPDATE supplier SET logo='".$_SESSION["form"]["imageFile"]."' WHERE id='".$getSupplierId."';"; 
					$stmt5 = mysqli_query( $conn, $sql4);
						
					$_SESSION['user']['logo'] = $_SESSION["form"]["imageFile"];
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']=$_SESSION['language']['The customer profile is updated properly'];
					$_SESSION['userLog']['description']="The customer profile is updated properly";
					
				} else {
					
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="Error to update the logo in the server for the customer profile ID ".$getSupplierId.".";
				$_SESSION['userLog']['description']="Error to update the logo in the server for the customer profile ID ".$getSupplierId.".";
									
			} 
		}
		else {
			$_SESSION['notification']['type']="warning";
			$_SESSION['notification']['message']=$_SESSION['language']['The customer profile is updated properly'];
			$_SESSION['userLog']['description']="The customer profile is updated properly";
		}
		
		}
		
		if ($_GET['target']=="customer") {
		
		$sql1 = "SELECT TOP 1 id FROM customer WHERE companyId=".$_SESSION['user']['companyId']." ORDER BY id DESC"; 
		$stmt1 = mysqli_query( $conn, $sql1);  
		  
		if ( $stmt1 ) {
		$row1= mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );  
		$getCustomerId = $row1['id'];		
		}
		
		$sql2 = "SELECT TOP 1 code FROM customer WHERE companyId=".$_SESSION['user']['companyId']." ORDER BY code DESC"; 
		$stmt2 = mysqli_query( $conn, $sql2);  
		  
		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );  
		$getCode = $row2['code'];		
		}
		
		if ($_POST['code']!="")
			$code = $_POST['code'];
		else
			$code = $getCode + 1;
		
		$sql3 = "UPDATE customer SET code=".$code.", creationDate='".$date."', flagActive=1 WHERE id='".$getCustomerId."';"; 
		
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
		
		}
		
		header ("Location: list.php?tableStatus=view&target=".$_GET['target']."&page=1");
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
		
		
		header ("Location: list.php?tableStatus=view&target=".$_GET['target']."&page=".$_GET['page']);
	}

}
else   
{  
    
     //die( print_r( sqlsrv_errors(), true));  
	echo $sql;
}  
mysqli_free_result( $stmt);  
mysqli_close( $conn); 
} 
?>































