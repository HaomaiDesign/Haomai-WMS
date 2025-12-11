<?php
session_start();
include 'system/db.php';
#include '../system/session.php';
$_SESSION['userLog']['module']="Recovery";

if (isset($_GET['companyId'])) 
	$companyId = $_GET['companyId'];
else
	$companyId = "none";



#resetPassword estando logueado (boton Restablecer Contraseña)
if($_GET['resetOldPassword'] == "true"){
	$oldPassword = $_POST['oldPassword'];
	$newPassword = $_POST['newPassword'];
	$renewPassword = $_POST['renewPassword'];

	if(strcmp($newPassword,$renewPassword) != 0){
		$_SESSION['notification']['type']="error";
		$_SESSION['notification']['message']="La contraseña nueva no coincide con la reingresada.";

	} else {
		$sqlReset1 = "SELECT * FROM users WHERE id=" . $_SESSION['user']['id'] . ";";  
		$stmtReset1 = mysqli_query($conn, $sqlReset1); 
		if ($stmtReset1) {
			$row = mysqli_fetch_array($stmtReset1, MYSQLI_ASSOC);
			if (password_verify($oldPassword,$row['password'])){
				$newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);	
				$sqlReset2 = "UPDATE users SET password=N'". $newPasswordHashed . "' WHERE id=" . $_SESSION['user']['id'] . ";"; 
				$stmtReset2 = mysqli_query( $conn, $sqlReset2);

				if ($stmtReset2){
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']="La contraseña se ha cambiado con éxito.";

					if (isset($_SESSION['user']['flagResetPassword'])){
						$sqlReset3 = "UPDATE users SET flagResetPassword = 0 WHERE id=" . $_SESSION['user']['id'] . ";"; 
						$stmtReset3 = mysqli_query( $conn, $sqlReset3);

						$_SESSION['user']['flagResetPassword'] = 0;

					}

				} else {
					$_SESSION['notification']['type']="error";
					$_SESSION['notification']['message']="La contraseña nueva no se pudo guardar.";	
				}

			} else { 
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="La contraseña antigua es errónea.";			
			}	
		}
		mysqli_free_result($stmtReset1);
	}

	header("Location: users/userProfile.php?formStatus=view");
	exit();
}
 elseif ($_GET['password']=='reset'){
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql1 = "SELECT * FROM users WHERE email='".$email."';";  
$stmt1 = mysqli_query( $conn, $sql1);  

if ( $stmt1 ) {
	$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );

	if ($_GET['token']==$row1['password'])
	{

		$sql2 = "UPDATE users SET password=N'".$password."' WHERE email='".$email."'";  
		$stmt2 = mysqli_query( $conn, $sql2);  

		if ( $stmt2 ) {
	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The password was changed properly.";
	
		$_SESSION['user']['id'] = $row1['id'];
		$_SESSION['user']['email'] = $email;
		$_SESSION['user']['fullName'] = $row1['fullName'];
		$_SESSION['user']['roleId'] = $row1['roleId'];
		$_SESSION['user']['avatar'] = $row1['avatar'];
		$_SESSION['user']['languageId'] = $row1['languageId'];
		
		if ($_SESSION['user']['roleId']==0)
			$_SESSION['user']['role'] = "End User";	
		
		if ($_SESSION['user']['roleId']==1)
			$_SESSION['user']['role'] = "Administrator";	
		
		if ($_SESSION['user']['roleId']==2)
			$_SESSION['user']['role'] = "Responsable";	
		
		if ($_SESSION['user']['roleId']==3)
			$_SESSION['user']['role'] = "User";	
		
		if ($_SESSION['user']['roleId']!=0)
		{
			$sql2 = "SELECT * FROM company WHERE id='".$row1['companyId']."'";  
			$stmt2 = mysqli_query( $conn, $sql2); 
			$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );
						
			$_SESSION['user']['companyId'] = $row2['id'];
			$_SESSION['user']['businessName'] = $row2['businessName'];
			$_SESSION['user']['logo'] = $row2['logo'];	
		}
		

		
		include 'system/languageSettings.php';
		
		$_SESSION['start'] = time();
		$_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
		$_SESSION['loggedin'] = true;
	
	
	
		if ($_GET['recovery']=="system")
			header ("Location: dashboard/index.php");	
		
		if ($_GET['recovery']=="stand")
			header ("Location: stand/index.php?companyId=".$companyId);
		
		}

	}
	else
	{
		header ("Location: recovery.php?reset=false&email=".$email."&token=".$_GET['token']."&companyId=".$companyId."&recovery=".$_GET['recovery']);

	}
}

}


if ($_GET['password']=='recovery')
{
$email = $_POST['email'];
$sql = "SELECT * FROM users WHERE email='".$email."'";  
$stmt = mysqli_query( $conn, $sql);  
  
if ( $stmt ) {
$row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ); 

if ($row['email']!="")
{
	
$url = 'https://api.sendgrid.com/';
$user = 'azure_ece4b8e6e4e5e23f811f073bdf29339a@azure.com';
$pass = 'HMpass11';

$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];

$body="<html><head><title>Haomai System</title></head><body>";
$body.="Estimado/a ".$row['fullName'].",<br><br>";
$body.="Hemos recibido una solicitud para la recuperación de contraseña, para avanzar con la operación le pedimos el favor de hacer click en el siguiente link:<br><br>";
$body.="<a href='".$base_url."/recoveryUpdate.php?email=".$email."&token=".$row['password']."&companyId=".$companyId."&recovery=".$_GET['recovery']."' target='_blank'>".$base_url."/recoveryUpdate.php?email=".$email."&token=".$row['password']."&companyId=".$companyId."&recovery=".$_GET['recovery']."</a><br><br>";	
$body.="Muchas gracias,<br><br>";		
$body.="Equipo de Haomai<br><br>";	
$body.="</body></html>";	


 $params = array(
      'api_user' => $user,
      'api_key' => $pass,
      'to' => $email,
      'subject' => 'Password Recovery',
      'html' => $body,
      'from' => 'info@haomai.com.ar',
   );

 $request = $url.'api/mail.send.json';

 // Generate curl request
 $session = curl_init($request);

 // Tell curl to use HTTP POST
 curl_setopt ($session, CURLOPT_POST, true);

 // Tell curl that this is the body of the POST
 curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

 // Tell curl not to return headers, but do return the response
 curl_setopt($session, CURLOPT_HEADER, false);
 curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

 // obtain response
 $response = curl_exec($session);
 curl_close($session);

 // print everything out
 print_r($response);

header ("Location: recovery.php?verify=true&email=".$email);

mysqli_free_result( $stmt);  
mysqli_close( $conn);  
}
else
{
	header ("Location: recovery.php?verify=false&email=".$email);	
}
}
}

if ((isset($_GET['token']))AND($_GET['password']!='reset'))
{
$email = $_GET['email'];

$sql = "SELECT * FROM users WHERE email='".$email."';";  
$stmt = mysqli_query( $conn, $sql);  

if ( $stmt ) {
	$row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC );
		
	if ($_GET['token']==$row['password'])
		header ("Location: recovery.php?reset=true&email=".$email."&token=".$_GET['token']."&companyId=".$companyId."&recovery=".$_GET['recovery']);	
	else
		header ("Location: recovery.php?reset=false&email=".$email."&token=".$_GET['token']."&companyId=".$companyId."&recovery=".$_GET['recovery']);
	}
	
}

?>































