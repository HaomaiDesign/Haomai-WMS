<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>

<!-- Start content-->

<?php
    echo "<script>console.log('company id : ".$_SESSION['user']['companyId']."');</script>";

    $APP_ID = "724439895016636";
    $redirect_uri = "https://www.haomai.com.ar/market/mp_authorize.php"; //Cambiar esto para que no sea /demo cuando pase a prod

    //Obtengo access token si ya existe. Acordarse de que vence cada 6 meses.
    $sql = "SELECT mlAccessToken, mlUserId FROM company WHERE id=".$_SESSION['user']['companyId'].";";  
    $stmt = mysqli_query( $conn, $sql); 
	
    if ( $stmt ) {
	    $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC );
	    if ($row['mlAccessToken']!="") {
		    $mlAccessToken = $row['mlAccessToken'];
		    $mlUserId = $row['mlUserId'];
	    }

    }
    if ($mlAccessToken=="") {
        if(isset($_GET['code'])){
            $ch = curl_init('https://api.mercadopago.com/oauth/token');

            $data->client_secret = 'APP_USR-724439895016636-070100-4c922edc8dac38ca4a96a058c1268a03-578417178'; //De Haomai MP App access token prod
            $data->grant_type = 'authorization_code';
            $data->code = $_GET['code']; //Llega del redirect de MP luego de autorizar
            $data->redirect_uri = $redirect_uri;

            $data_encoded = json_encode($data);

            //adjunto data al curl
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_encoded);
            
            //seteado de -H (Headers creo)
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));

            //return response instead of outputting
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //set method
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

            //ejecucion del request
            $exec = curl_exec($ch);
            $err = curl_error($ch);

            //catcheo de errores
            
            if ($err) {
                echo "cURL Error #:" . $err;
                print_r($result);
            } else {
                $result = json_decode($exec);
                //print_r($result);
                
                $expirationDate = date_create(); 
                $expirationDate = date_add($expirationDate,date_interval_create_from_date_string("6 months"));
                $expirationDate = date_format($expirationDate,"Y-m-d");
                 
                
                $sql1 = "UPDATE company SET mlAccessToken='". $result->access_token ."', mlPublicKey='". $result->public_key ."', mlRefreshToken='". $result->refresh_token ."', mlUserId='". $result->user_id ."', mlRefreshDate='".$expirationDate."' WHERE id=".$_SESSION['user']['companyId'].";";  
                $stmt1 = mysqli_query( $conn, $sql1); 
                  
                if ($stmt1){
                    $_SESSION['notification']['type'] = "success";
                    $_SESSION['notification']['message'] = "ML linked properly"; 
                    $mlAccessToken = $result->access_token;
                    $mlUserId = $result->user_id;
                }else{
                    $_SESSION['notification']['type'] = "error";
                    $_SESSION['notification']['message'] = "Error to save in our registry"; 
                }
            }
        }
    }
?>

<div class="col-lg-12">
	<div class="card">
		<div class="card-status card-status-left bg-blue"></div>
		<div class="card-header">
			<h3 class="card-title" style="font-weight:bold;">Mercado Pago</h3>
		</div>
        <div class ="card-body">        
            <h4> Para realizar los pagos a través de MercadoPago, necesitamos vincular Haomai con su cuenta de MercadoPago.</h4>
            <br>        
        </div>

		<div class="card-footer text-right">
		  <a href="https://auth.mercadopago.com.ar/authorization?client_id=<?php echo $APP_ID; ?>&response_type=code&platform_id=mp&redirect_uri=<?php echo $redirect_uri; ?>" target="_blank" class="btn btn-primary<?php  if ($mlAccessToken!="") echo " disabled"; ?>">Autorizar </a>
		</div>
	</div>
</div>
<!-- End content-->  
<?php include "../system/contentEnd.php"; ?>	