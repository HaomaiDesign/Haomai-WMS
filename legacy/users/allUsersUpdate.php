<?php
ob_start();
include '../system/session.php';
$_SESSION['userLog']['module']="All Users";


 
if ($_GET['formStatus']=='delete')
{
	$_SESSION['form']['table']= 'users'; 
	$_SESSION['form']['condition'] = "id=".$_GET['id'];
	
}

include '../system/formQuery.php';

if ($_GET['action']=='resetPassword')
{

$password = password_hash($_GET['newPassword'], PASSWORD_DEFAULT);
$sql = "UPDATE users SET password=N'".$password."', flagResetPassword=1 WHERE id='".$_GET['userId']."';";  
$stmt = mysqli_query( $conn, $sql);

if ( $stmt ) {
$_SESSION['notification']['type']="success";
$_SESSION['notification']['message']="Password restored";
} else {
$_SESSION['notification']['type']="error";
$_SESSION['notification']['message']="The password can not be restored";
}

header ("Location: allUsers.php?tableStatus=view");	

}


if ($_GET['formStatus']!='view')
{
$stmt = mysqli_query( $conn, $sql);  
  
if ( $stmt ) {
	
	if ($_GET['formStatus']=='create')
	{	
		$sql2 = "SELECT TOP 1 id FROM users ORDER BY id DESC";  
		$stmt2 = mysqli_query( $conn, $sql2);  
		  
		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC  );  
		$getUserId = $row2['id'];	
		}
		
		$date = date("Y-m-d");
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$sql4 = "UPDATE users SET password=N'".$password."', registrationDate=N'".$date."' WHERE id=".$getUserId.";";  
		$stmt4 = mysqli_query( $conn, $sql4); 
		
		if ($_SESSION["form"]["imageFile"]!=""){
		
		$_SESSION["form"]["imageDir"] = $_SESSION["form"]["imageDir"].$getUserId."/";
		$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];
		mkdir($_SESSION["form"]["imageDir"], 0777);
			
			if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $_SESSION["form"]["imageFile"])) {
									
				$sql3 = "UPDATE users SET avatar=N'".$_SESSION["form"]["imageFile"]."' WHERE id='".$getUserId."';";  
				$stmt3 = mysqli_query( $conn, $sql3);  
				  
				if ( $stmt3 ) {
				
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']="The new user ID ".$getUserId." was created propertly.";
					$_SESSION['userLog']['description']="The new user was created propertly.";
					$_SESSION['user']['avatar'] = $_SESSION["form"]["imageFile"];
					
				} else {
					
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="The user profile ID ".$getUserId." was created propertly without avatar.";
				$_SESSION['userLog']['description']="The user profile ID ".$getUserId." was created propertly without avatar.";
			}
				
			} else {
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="The user profile ID ".$getUserId." was created propertly without avatar.";
				$_SESSION['userLog']['description']="The user profile ID ".$getUserId." was created propertly without avatar.";
			}
		}
		
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$sql4 = "UPDATE users SET password='".$password."' WHERE id='".$getUserId."';";  
		$stmt4 = mysqli_query( $conn, $sql4); 
					
		header ("Location: allUsers.php?tableStatus=view");
	}	
	
	if ($_GET['formStatus']=='delete')
	{	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The user ID ".$_GET['id']." was removed properly.";
		$_SESSION['userLog']['description']="The user ID ".$_GET['id']." was removed properly.";
		header ("Location: allUsers.php?tableStatus=view");
	}
	
	if ($_GET['formStatus']=='edit')
	{	

		if ($_SESSION["form"]["imageFile"]!=""){
		
		$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];	
		
		mkdir($_SESSION["form"]["imageDir"], 0777);
			
			if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $_SESSION["form"]["imageFile"])) {
									
				$sql2 = "UPDATE users SET avatar=N'".$_SESSION["form"]["imageFile"]."' WHERE id='".$_GET['id']."';";  
				$stmt2 = mysqli_query( $conn, $sql2);  
				  
				if ( $stmt2 ) {
				
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']="The user ID ".$_GET['id']." was updated propertly.";
					$_SESSION['userLog']['description']="The user ID ".$_GET['id']." was updated propertly.";
					$_SESSION['user']['avatar'] = $_SESSION["form"]["imageFile"];
					
				} else {
					
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="Error to update the avatar in the server for the user ID ".$_GET['id'].".";
				$_SESSION['userLog']['description']="Error to update the avatar in the server for the user ID ".$_GET['id'].".";
				
			}
				
			} else {
				$_SESSION['notification']['type']="warning";
				$_SESSION['notification']['message']="The user profile ID ".$_GET['id']." was created propertly without avatar.";
				$_SESSION['userLog']['description']="The user profile ID ".$_GET['id']." was created propertly without avatar.";
			}
		}
		
		
		
		

		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The user ID ".$_GET['id']." was updated properly.";
		$_SESSION['userLog']['description']="The user ID ".$_GET['id']." was updated properly.";
		header ("Location: allUsers.php?formStatus=view&id=".$_GET['id']);
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































