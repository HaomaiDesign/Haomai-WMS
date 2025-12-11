<?php
include '../system/session.php';
$_SESSION['userLog']['module']="showroom";
 
if ($_GET['formStatus']=='delete')
{
	$_SESSION['form']['table']= 'product'; 
	$_SESSION['form']['condition'] = "id=".$_GET['id'];
	
}

include '../system/formQuery.php';

if ($_GET['tableStatus']=='delete')
{		
	$sql = "DELETE FROM productFeatures WHERE id=".$_GET['featureId'].";";
}	




if ($_GET['formStatus']!='view')
{

$stmt = mysqli_query( $conn, $sql);  
  
if ( $stmt ) {
	
	if ($_GET['tableStatus']=='delete')
	{		
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The feature was removed properly.";
		$_SESSION['userLog']['description']="The feature was removed properly.";
		header ("Location: productFeature.php?formStatus=create&tableStatus=view&id=".$_GET['id']);
	}	
	
	if ($_GET['formStatus']=='create')
	{		
		header ("Location: productFeature.php?formStatus=create&tableStatus=view&id=".$_GET['id']);
	}	
	
	if ($_GET['formStatus']=='delete')
	{	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The product ID ".$_GET['id']." was removed properly.";
		$_SESSION['userLog']['description']="The product ID ".$_GET['id']." was removed properly.";
		header ("Location: productsList.php?tableStatus=view");
	}
	
	if ($_GET['formStatus']=='edit')
	{	

		if ($_SESSION["form"]["imageFile"]!=""){
		
		$_SESSION["form"]["imageDir"] = "assets/images/company/".$_SESSION['eShop']['companyId']."/".$_GET['id']."/";
		$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];		
		
		mkdir($_SESSION["form"]["imageDir"], 0777);
			
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $_SESSION["form"]["imageFile"])) {
									
				$sql2 = "UPDATE product SET image=N'".$_SESSION["form"]["imageFile"]."' WHERE id='".$_GET['id']."';";  
				$stmt2 = mysqli_query( $conn, $sql2);  
				  
				if ( $stmt2 ) {
				
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']="The product ID ".$_GET['id']." was updated properly.";
					$_SESSION['userLog']['description']="The product ID ".$_GET['id']." was updated properly.";
					
				} else {
					
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="Error to update the image in the server for the product ID ".$_GET['id'].".";
				$_SESSION['userLog']['description']="Error to update the image in the server for the product ID ".$_GET['id'].".";
				
			}
				
			} else {
				$_SESSION['notification']['type']="warning";
				$_SESSION['notification']['message']="The product ID ".$_GET['id']." was created properly without image.";
				$_SESSION['userLog']['description']="The product ID ".$_GET['id']." was created properly without image.";
			}
		}

		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The product ID ".$_GET['id']." was updated properly.";
		$_SESSION['userLog']['description']="The product ID ".$_GET['id']." was updated properly.";
		header ("Location: productsList.php?tableStatus=view");
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































