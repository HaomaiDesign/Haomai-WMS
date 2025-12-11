<?php
session_start();
include 'system/db.php';
$_SESSION['userLog']['module']="Registration";

$date = date("Y-m-d");
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


$sqlCheck = "SELECT * FROM users WHERE email='".$email."';";  
$stmtCheck = mysqli_query( $conn, $sqlCheck);  




if ( $stmtCheck ) {
$rowCheck = mysqli_fetch_array( $stmtCheck, MYSQLI_ASSOC ); 
if ($rowCheck['email']!="")
{
	$_SESSION['notification']['type']="error";
	$_SESSION['notification']['message']="Correo electrónico existente, por favor intentar con otro o restaure su contraseña.";

	header ("Location: register.php");	
}
else	
{
	$sql = "INSERT INTO users ( username, email, password, fullName, businessId, roleId, languageId, registrationDate) VALUES ( N'".$email."', N'".$email."', N'".$password."', N'".$fullName."', 0, 0, 2, N'".$date."');";  
	$stmt = mysqli_query( $conn, $sql);  

	echo $sql;
	
	if ( $stmt ) {
		
		$sql2 = "SELECT id FROM users ORDER BY id DESC LIMIT 1";  
		$stmt2 = mysqli_query( $conn, $sql2);  
		  
		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );  
		$getUsersId = $row2['id'];	
		}
		
		$_SESSION['user']['id'] = $getUsersId;	
		$_SESSION['user']['email'] = $email;
		$_SESSION['user']['username'] = $email;
		$_SESSION['user']['fullName'] = $fullName;
		$_SESSION['user']['role'] = 'Member';	
		$_SESSION['user']['businessName'] = 'Haomai';		
		$_SESSION['user']['businessId'] = 0;	
		$_SESSION['user']['languageId'] = 2;	
		$_SESSION['user']['subscription'] = 0;
		
		include 'system/languageSettings.php';
		include 'system/isMobile.php';
			
		$_SESSION['start'] = time();
		$_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
		$_SESSION['loggedin'] = true;
		
		
		$_SESSION['userLog']['description']="The user ".$fullName." ID ".$getUsersId." is registred and logged in.";
	
		header ("Location: login.php");
	
	}
}


}
	
/* Free statement and connection resources. */  
mysqli_free_result( $stmt);  
mysqli_close( $conn);  
?>































