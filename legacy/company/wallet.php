<?php include "../system/session.php"; ?>

<?php 

$sql0 = "SELECT * FROM company WHERE id=".$_GET['companyId'].";";  
$stmt0 = mysqli_query( $conn, $sql0); 
	
if ( $stmt0 ) {
	$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );
	if ($row0['mlAccessToken']!="") {
		$mlAccessToken = $row0['mlAccessToken'];
		$mlUserId = $row0['mlUserId'];
	}

}

if ($mlAccessToken=="") {
if (isset($_GET['code']))
{
	//////////// AUTORIZACION DEL VENDEDOR ////////////
$url = 'https://api.mercadopago.com/oauth/token';

//create a new cURL resource
$ch = curl_init($url);

//setup request to send json via POST

$data->client_id = "3755650389058110"; // ID usado es de test
$data->client_secret = 'qWbAOqBXehXQcSGTc4eCUaM6EGXKpXN7'; // ID usado es de test
$data->grant_type = 'authorization_code';
$data->code = $_GET['code'];
$data->redirect_uri = 'https://haomaisystembase.azurewebsites.net/settings/companyWallet.php?companyId='.$_GET['companyId'];

$payload = json_encode($data);

//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//set method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

//execute the POST request
$exec = curl_exec($ch);
$err = curl_error($ch);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
	$result = json_decode($exec);
	
	if (isset($result->message))
	{
		$_SESSION['notification']['type'] = "error";
		$_SESSION['notification']['message'] = $result->message; 
	}
	
	$sql1 = "UPDATE company SET mlAccessToken='". $result->access_token ."', mlPublicKey='". $result->public_key ."', mlRefreshToken='". $result->refresh_token ."', mlUserId='". $result->user_id ."' WHERE id=".$_GET['companyId'].";";  
	$stmt1 = mysqli_query( $conn, $sql1); 
	
	if ($stmt1)
	{
		$_SESSION['notification']['type'] = "success";
		$_SESSION['notification']['message'] = "ML linked properly"; 
		$mlAccessToken = $result->access_token;
		$mlUserId = $result->user_id;
	}
	else
	{
		$_SESSION['notification']['type'] = "error";
		$_SESSION['notification']['message'] = "Error to save in our registry"; 
	}
}


//close cURL resource
curl_close($ch);

}
}

?>


<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>

<!-- Start content-->

<div class="col-lg-12">
	<div class="card">
		<div class="card-status card-status-left bg-blue"></div>
		<div class="card-header">
			<h3 class="card-title" style="font-weight:bold;">Mercado Pago</h3>
		</div>

		<div class="card-footer text-right">
		  <a href="https://auth.mercadopago.com.ar/authorization?client_id=3755650389058110&response_type=code&platform_id=mp&redirect_uri=https://haomaisystembase.azurewebsites.net/settings/companyWallet.php?companyId=<?php echo $_GET['companyId'];?>" class="btn btn-primary<?php if ($mlAccessToken!="") echo " disabled"; ?>">Autorizar </a>
		</div>
	</div>
</div>
<!-- End content-->  
<?php include "../system/contentEnd.php"; ?>	