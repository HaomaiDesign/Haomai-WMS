<?php
include '../system/session.php';
$date = date("Y-m-d");
$_SESSION['userLog']['module']="showroom";
 
if ($_GET['formStatus']=='delete')
{	
	$sql = "UPDATE product SET flagActive=0, flagMarket=0, flagStock=0, flagPurchase=0 WHERE id=".$_GET['id'].";";  

} else
{
	include '../system/formQuery.php';	
}


if ($_GET['formStatus']!='view')
{

$stmt = mysqli_query( $conn, $sql); 		
 
if ( $stmt ) {
	
	if ($_GET['formStatus']=='create')
	{	
		if ($_GET['supplierId']!="")
			$target = $_GET['supplierId'];  
		else
			$target = $_SESSION['user']['companyId'];
		
		$sql1 = "SELECT COUNT(id) as items FROM product WHERE companyId=".$target.";";  
		
		$stmt1 = mysqli_query( $conn, $sql1);  
		  
		if ( $stmt1 ) {
		$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );  
		$getItemId = $row1['items'];	
		}

		$sql2 = "SELECT TOP 1 id FROM product ORDER BY id DESC";  
		$stmt2 = mysqli_query( $conn, $sql2);  
		  
		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );  
		$getProductId = $row2['id'];	
		}
		
		$sku = "AR-".str_pad($target, 4, "0", STR_PAD_LEFT)."-".str_pad($getItemId, 4, "0", STR_PAD_LEFT);
		
		if ($_POST['code']!="")
			$code = $_POST['code'];
		else
			$code = $sku;
		
		if (isset($_POST['flagGroup1'])) $flagGroup1 = 1; else $flagGroup1 = 0;
		if (isset($_POST['flagGroup2'])) $flagGroup2 = 1; else $flagGroup2 = 0;
		if (isset($_POST['flagGroup3'])) $flagGroup3 = 1; else $flagGroup3 = 0;
		
		if ($_GET['supplierId']!="")
			$sql3 = "UPDATE product SET creationDate='".$date."', sortId=".$getItemId.", flagActive=0, flagMarket=1, flagStock=1, flagPurchase=1, flagGroup1=".$flagGroup1.", flagGroup2=".$flagGroup2.", flagGroup3=".$flagGroup3.", code=N'".$code."', sku=N'".$sku."' WHERE id=".$getProductId.";";  
		else
			$sql3 = "UPDATE product SET creationDate='".$date."', sortId=".$getItemId.", flagActive=1, flagMarket=1, flagStock=1, flagPurchase=1, flagGroup1=".$flagGroup1.", flagGroup2=".$flagGroup2.", flagGroup3=".$flagGroup3.", code=N'".$code."', sku=N'".$sku."' WHERE id=".$getProductId.";";  
		
		echo $sql1;
		echo $sql3;
		echo $_GET['supplierId'];
		
		$stmt3 = mysqli_query( $conn, $sql3); 
	

		if ($_SESSION["form"]["imageFile"]!=""){

		$_SESSION["form"]["imageDir"] = "../assets/images/company/".$target."/".$getProductId."/";
		$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];
		mkdir("../assets/images/company/".$target."/", 0777);		
		mkdir($_SESSION["form"]["imageDir"], 0777);
		
		
		////////////////
		$flagUploaded = false;
		
		$max_ancho = 800;
		$max_alto = 600;
		
		$medidasimagen= getimagesize($_FILES['image']['tmp_name']);

		//Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
			if($medidasimagen[0] < 1280 && $_FILES['image']['size'] < 1000000){

			$nombrearchivo=$_FILES['image']['name'];
			move_uploaded_file($_FILES["image"]["tmp_name"], $_SESSION["form"]["imageFile"]);
			$flagUploaded = true;
		}


		//Si no, se generan nuevas imagenes optimizadas
		else {
		$nombrearchivo=$_FILES['image']['name'];

		//Redimensionar
		$rtOriginal=$_FILES['image']['tmp_name'];

		if($_FILES['image']['type']=='image/jpeg'){
		$original = imagecreatefromjpeg($rtOriginal);
		}
		else if($_FILES['image']['type']=='image/png'){
		$original = imagecreatefrompng($rtOriginal);
		}
		else if($_FILES['image']['type']=='image/gif'){
		$original = imagecreatefromgif($rtOriginal);
		}

		list($ancho,$alto)=getimagesize($rtOriginal);

		$x_ratio = $max_ancho / $ancho;
		$y_ratio = $max_alto / $alto;
		
		if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
			$ancho_final = $ancho;
			$alto_final = $alto;
		}
		elseif (($x_ratio * $alto) < $max_alto){
			$alto_final = ceil($x_ratio * $alto);
			$ancho_final = $max_ancho;
		}
		else{
			$ancho_final = ceil($y_ratio * $ancho);
			$alto_final = $max_alto;
		}

		$lienzo=imagecreatetruecolor($ancho_final,$alto_final); 

		imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
		 
		//imagedestroy($original);
		 
		if($_FILES['image']['type']=='image/jpeg'){
		imagejpeg($lienzo, $_SESSION["form"]["imageFile"]);
		$flagUploaded = true;
		}
		else if($_FILES['image']['type']=='image/png'){
		imagepng($lienzo, $_SESSION["form"]["imageFile"]);
		$flagUploaded = true;
		}
		else if($_FILES['image']['type']=='image/gif'){
		imagegif($lienzo, $_SESSION["form"]["imageFile"]);
		$flagUploaded = true;
		}
		
		
		}
		////////
		
			
			if ($flagUploaded==true) {
				
				if($_FILES['image']['type']=='image/gif') {
					$file_name = "C".$_SESSION['user']['companyId']."P".$getProductId.".gif";
					$type = "image/gif";
				};
				if($_FILES['image']['type']=='image/png') {
					$file_name = "C".$_SESSION['user']['companyId']."P".$getProductId.".png";
					$type = "image/png";
				};
				if($_FILES['image']['type']=='image/jpeg') {
					$file_name = "C".$_SESSION['user']['companyId']."P".$getProductId.".jpeg";
					$type = "image/jpeg";
				};
				
				rename($_SESSION["form"]["imageFile"], $_SESSION["form"]["imageDir"].$file_name);
				$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$file_name;
				
				/*
				$curl = curl_init();		
				curl_setopt_array($curl, array(
				CURLOPT_URL => "http://haomaisystem.azurewebsites.net/api/user/SaveProfilePic",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => array('image'=> new CURLFILE($_SESSION["form"]["imageFile"],$type,$file_name)),		
				CURLOPT_HTTPHEADER => array(
					"Cookie: ARRAffinity=b6c882a5e013db277ef434fb044e8255f520bbdc70059876373bab098d534452"
				),
				));

				$response = curl_exec($curl);
				$response=str_replace('"','',$response); 

				curl_close($curl);
				
				unlink($_SESSION["form"]["imageFile"]);
				*/
				$sql3 = "UPDATE product SET image=N'".$_SESSION["form"]["imageFile"]."' WHERE id=".$getProductId.";"; 

				
				$stmt3 = mysqli_query( $conn, $sql3);  
				  
				if ( $stmt3 ) {
				
					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']="The new product ID ".$getProductId." was created properly.";
					//$_SESSION['userLog']['description']="The new product was created properly.";
				} else {
					
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="The user product ID ".$getProductId." was created properly without avatar1.";
				//$_SESSION['userLog']['description']="The user product ID ".$getProductId." was created properly without avatar.1".$sql3;
			}
				
			} else {
				$_SESSION['notification']['type']="error";
				$_SESSION['notification']['message']="The user product ID ".$getProductId." was created properly without avatar2.";
				//$_SESSION['userLog']['description']="The user product ID ".$getProductId." was created properly without avatar.2".$sql3;
			}
		}
		
		$pageGet = "";
		
		if ($_GET['market']=="retail") $pageGet.= "&market=retail"; if ($_GET['market']=="wholesale") $pageGet.= "&market=wholesale"; if ($_GET['companyId']!="") $pageGet.= "&companyId=".$_GET['companyId']; if ($_GET['customerId']!="") $pageGet.= "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") $pageGet.= "&supplierId=".$_GET['supplierId']; if ($_GET['target']!="") $pageGet.= "&target=".$_GET['target'];
	
		if ($_GET['supplierId']!="")
			header ("Location: market.php?tableStatus=view".$pageGet."&page=1");
		else
			header ("Location: productsList.php?tableStatus=view".$pageGet."&page=1");
			//header ("Location: productFeature.php?formStatus=create&tableStatus=view&id=".$getProductId);
	
		
	}	
	
	if ($_GET['formStatus']=='delete')
	{	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The product ID ".$_GET['id']." was removed properly.";
		$_SESSION['userLog']['description']="The product ID ".$_GET['id']." was removed properly.";
		header ("Location: productsList.php?tableStatus=view&page=1");
	}
	
	if ($_GET['formStatus']=='edit')
	{	
		
		
		if (isset($_POST['flagGroup1'])) $flagGroup1 = 1; else $flagGroup1 = 0;
		if (isset($_POST['flagGroup2'])) $flagGroup2 = 1; else $flagGroup2 = 0;
		if (isset($_POST['flagGroup3'])) $flagGroup3 = 1; else $flagGroup3 = 0;
		
		$sql3 = "UPDATE product SET flagGroup1=".$flagGroup1.", flagGroup2=".$flagGroup2.", flagGroup3=".$flagGroup3." WHERE id=".$_GET['id'].";";  
		$stmt3 = mysqli_query( $conn, $sql3);
		
		if ($_SESSION["form"]["imageFile"]!=""){
		
		$_SESSION["form"]["imageDir"] = "../assets/images/company/".$_SESSION['user']['companyId']."/".$_GET['id']."/";
		$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];		
		mkdir("../assets/images/company/".$_SESSION['user']['companyId']."/", 0777);		
		mkdir($_SESSION["form"]["imageDir"], 0777);
		
			////////////////
		$flagUploaded = false;
		
		$max_ancho = 800;
		$max_alto = 600;
		
		$medidasimagen= getimagesize($_FILES['image']['tmp_name']);

		//Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
			if($medidasimagen[0] < 1280 && $_FILES['image']['size'] < 1000000){

			$nombrearchivo=$_FILES['image']['name'];
			move_uploaded_file($_FILES["image"]["tmp_name"], $_SESSION["form"]["imageFile"]);
			$flagUploaded = true;
		}


		//Si no, se generan nuevas imagenes optimizadas
		else {
		$nombrearchivo=$_FILES['image']['name'];

		//Redimensionar
		$rtOriginal=$_FILES['image']['tmp_name'];

		if($_FILES['image']['type']=='image/jpeg'){
		$original = imagecreatefromjpeg($rtOriginal);
		}
		else if($_FILES['image']['type']=='image/png'){
		$original = imagecreatefrompng($rtOriginal);
		}
		else if($_FILES['image']['type']=='image/gif'){
		$original = imagecreatefromgif($rtOriginal);
		}

		list($ancho,$alto)=getimagesize($rtOriginal);

		$x_ratio = $max_ancho / $ancho;
		$y_ratio = $max_alto / $alto;
		
		if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
			$ancho_final = $ancho;
			$alto_final = $alto;
		}
		elseif (($x_ratio * $alto) < $max_alto){
			$alto_final = ceil($x_ratio * $alto);
			$ancho_final = $max_ancho;
		}
		else{
			$ancho_final = ceil($y_ratio * $ancho);
			$alto_final = $max_alto;
		}

		$lienzo=imagecreatetruecolor($ancho_final,$alto_final); 

		imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
		 
		//imagedestroy($original);
		 
		if($_FILES['image']['type']=='image/jpeg'){
		imagejpeg($lienzo, $_SESSION["form"]["imageFile"]);
		$flagUploaded = true;
		}
		else if($_FILES['image']['type']=='image/png'){
		imagepng($lienzo, $_SESSION["form"]["imageFile"]);
		$flagUploaded = true;
		}
		else if($_FILES['image']['type']=='image/gif'){
		imagegif($lienzo, $_SESSION["form"]["imageFile"]);
		$flagUploaded = true;
		}
		
		
		}
		////////
		
			if ($flagUploaded==true) {
				
				if($_FILES['image']['type']=='image/gif') {
					$file_name = "C".$_SESSION['user']['companyId']."P".$_GET['id'].".gif";
					$type = "image/gif";
				};
				if($_FILES['image']['type']=='image/png') {
					$file_name = "C".$_SESSION['user']['companyId']."P".$_GET['id'].".png";
					$type = "image/png";
				};
				if($_FILES['image']['type']=='image/jpeg') {
					$file_name = "C".$_SESSION['user']['companyId']."P".$_GET['id'].".jpeg";
					$type = "image/jpeg";
				};
				
				rename($_SESSION["form"]["imageFile"], $_SESSION["form"]["imageDir"].$file_name);
				$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$file_name;
				/*
				$curl = curl_init();		
				curl_setopt_array($curl, array(
				CURLOPT_URL => "http://haomaisystem.azurewebsites.net/api/user/SaveProfilePic",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => array('image'=> new CURLFILE($_SESSION["form"]["imageFile"],$type,$file_name)),		
				CURLOPT_HTTPHEADER => array(
					"Cookie: ARRAffinity=b6c882a5e013db277ef434fb044e8255f520bbdc70059876373bab098d534452"
				),
				));

				$response = curl_exec($curl);
				$response=str_replace('"','',$response); 

				curl_close($curl);
				
				unlink($_SESSION["form"]["imageFile"]);
									
				$sql2 = "UPDATE product SET image=N'".$response."' WHERE id='".$_GET['id']."';";  
				*/
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
		header ("Location: productsList.php?tableStatus=view&page=1");
	}	
}
else   
{  
	
	$_SESSION['notification']['type']="error";
	$_SESSION['notification']['message']="Error to update the image in the server for the product ID ".$_GET['id'].".";
	$_SESSION['userLog']['description']="Error to update the image in the server for the product ID ".$_GET['id'].".";
	header ("Location: productsList.php?tableStatus=view");
	/*
     echo $sql;
     die( print_r( sqlsrv_errors(), true));  
	*/	
}  

mysqli_free_result( $stmt);  
mysqli_close( $conn);  
}

?>































