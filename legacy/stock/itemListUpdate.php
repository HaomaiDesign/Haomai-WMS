<?php
ob_start();
include '../system/session.php';
// require '../vendor/autoload.php';

$date = date("Y-m-d");
$_SESSION['userLog']['module']="stock";
 
if ($_GET['formStatus']=='delete')
{
	$_SESSION['form']['table']= 'product'; 
	$_SESSION['form']['condition'] = "id=".$_GET['id'];
	
}
if(isset($_POST["dueDate"]) && $_POST["dueDate"] == "" ){
	$_POST["dueDate"] = "0000-00-00";
}
include '../system/formQuery.php';

if ($_GET['formStatus']!='view')
{
$stmt = mysqli_query( $conn, $sql);  
  
if ( $stmt ) {
	
	if ($_GET['formStatus']=='create')
	{	

		$sql1 = "SELECT COUNT(id) as items FROM products WHERE businessId=".$_SESSION['user']['businessId'].";";  
		$stmt1 = mysqli_query( $conn, $sql1);  
		// echo "sql1:".$sql1;
	
		 
		if ( $stmt1 ) {
			$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );  
			$getItemId = $row1['items'];	
		}

		$sql2 = "SELECT id,unitBarcode FROM products ORDER BY id DESC LIMIT 1;";  
		$stmt2 = mysqli_query( $conn, $sql2);  
		// echo "sql2:".$sql2;
		
	
		if ( $stmt2 ) {
			$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );  
			$getProductId = $row2['id'];
			$getUnitBarcode = $row2['unitBarcode'];	
		}
		
		$sku = "SKU".str_pad($getItemId, 9, "0", STR_PAD_LEFT);
		
		if ($_POST['code']!="")
			$code = $_POST['code'];
		else
			$code = $sku;

		if ($_POST['unit']!="")
			$unit = $_POST['unit'];
		else
			$unit = ""; 
		
		$sql3 = "UPDATE products SET creationDate='".$date."', updateDate='".$date."', sku=N'".$sku."', unit=N'".$unit."', code=N'".$code."', flagActive=0, flagMarket=0 WHERE id=".$getProductId.";";  
		$stmt3 = mysqli_query( $conn, $sql3); 
		// echo "sql3:".$sql3;

		if ($_SESSION["form"]["imageFile"]!=""){
			
			// $_SESSION['form']['imageDir'] = "../assets/images/company/".$_SESSION['user']['businessId']."/";

			$_SESSION['form']['imageDir'] = "../assets/images/products/";
			$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];	

			// mkdir("../assets/images/products/",0777);	
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
						// $file_name = "C".$_SESSION['user']['businessId']."P".$getProductId.".gif";
						$file_name = $getUnitBarcode.".gif";
						$type = "image/gif";
					};
					if($_FILES['image']['type']=='image/png') {
						// $file_name = "C".$_SESSION['user']['businessId']."P".$getProductId.".png";
						$file_name = $getUnitBarcode.".png";
						$type = "image/png";
					};
					if($_FILES['image']['type']=='image/jpeg') {
						// $file_name = "C".$_SESSION['user']['businessId']."P".$getProductId.".jpeg";
						$file_name = $getUnitBarcode.".jpeg";
						$type = "image/jpeg";
					};
					
					rename($_SESSION["form"]["imageFile"], $_SESSION["form"]["imageDir"].$file_name);
					$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$file_name;
					
					
					//Testear esto. Improvisado para sacar AWS de encima
					$urlImage = $_SESSION["form"]["imageFile"];
					$sql4 = "UPDATE products SET image=N'".$urlImage."' WHERE id=".$getProductId.";"; 
					// echo "sql4:".$sql4;
	
					
					$stmt4 = mysqli_query( $conn, $sql4);  
					  
					if ( $stmt4 ) {
					
						$_SESSION['notification']['type']="success";
						$_SESSION['notification']['message']="The new products ID ".$getProductId." was created properly.";
						//$_SESSION['userLog']['description']="The new products was created properly.";
					} else {
						
					$_SESSION['notification']['type']="error";
					$_SESSION['notification']['message']="The user products ID ".$getProductId." was created properly without avatar1.";
					//$_SESSION['userLog']['description']="The user products ID ".$getProductId." was created properly without avatar.1".$sql3;
				}
					
				} else {
					$_SESSION['notification']['type']="error";
					$_SESSION['notification']['message']="The user products ID ".$getProductId." was created properly without avatar2.";
					//$_SESSION['userLog']['description']="The user products ID ".$getProductId." was created properly without avatar.2".$sql3;
				}
			}
		

		 
			if(isset($_POST["target"]) && ($_POST["target"] == "in" || $_POST["target"] == "out")){
				header ("Location: ../webservice/updateInOut.php?action=addProductIn&unitBarcode=".$getUnitBarcode."&target=".$_POST["target"]."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&orderId=".$_POST["orderId"]."&fromCreateProduct=true");
				exit();
			} else {
				$nextRoute = "productsList.php?tableStatus=view&page=1&reportCat=ALL";
				if(isset($_GET['currentPage'])){
					$nextRoute .= "&page=".$_GET['currentPage'];
				}
				header ("Location: ".$nextRoute);
				exit();
			}
	}	
	
	if ($_GET['formStatus']=='delete')
	{	
		$_SESSION['notification']['type']="success";
		$_SESSION['notification']['message']="The item ID ".$_GET['id']." was removed properly.";
		//$_SESSION['userLog']['description']="The item ID ".$_GET['id']." was removed properly.";
		 
		$nextRoute = "productsList.php?tableStatus=view&reportCat=ALL";
		if(isset($_GET['currentPage'])){
			$nextRoute .= "&page=".$_GET['currentPage'];
		}
		header ("Location: ".$nextRoute);
		exit();
	}
	
	if ($_GET['formStatus']=='edit')
	{	
		if ($_SESSION["form"]["imageFile"]!=""){
			// $_SESSION["form"]["imageDir"] = "../assets/images/company/".$_SESSION['user']['businessId']."/".$_GET['id']."/";
			// $_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];	
			// mkdir("../assets/images/company/",0777);	
			// mkdir("../assets/images/company/".$_SESSION['user']['businessId']."/", 0777);		
			// mkdir($_SESSION["form"]["imageDir"], 0777);



			// $_SESSION['form']['imageDir'] = "../assets/images/company/".$_SESSION['user']['businessId']."/";

			$_SESSION['form']['imageDir'] = "../assets/images/products/";
			$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$_SESSION["form"]["imageFile"];	

			// mkdir("../assets/images/products/",0777);	
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
			} else {
				//Si no, se generan nuevas imagenes optimizadas
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
			
			if ($flagUploaded==true) {
				if($_FILES['image']['type']=='image/gif') {
					// $file_name = "C".$_SESSION['user']['businessId']."P".$_GET['id'].".gif";
					$file_name = $_POST['unitBarcode'].".gif";
					$type = "image/gif";
				};
				if($_FILES['image']['type']=='image/png') {
					// $file_name = "C".$_SESSION['user']['businessId']."P".$_GET['id'].".png";
					$file_name = $_POST['unitBarcode'].".png";
					$type = "image/png";
				};
				if($_FILES['image']['type']=='image/jpeg') {
					// $file_name = "C".$_SESSION['user']['businessId']."P".$_GET['id'].".jpeg";
					$file_name = $_POST['unitBarcode'].".jpeg";
					$type = "image/jpeg";
				};
				
				rename($_SESSION["form"]["imageFile"], $_SESSION["form"]["imageDir"].$file_name);
				$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"].$file_name;
				

				$urlImage = $_SESSION["form"]["imageFile"];
				$sql2 = "UPDATE products SET image=N'".$urlImage."' WHERE id='".$_GET['id']."';";  
				$stmt2 = mysqli_query( $conn, $sql2);  
				// echo "sql final:".$sql2;

				if($stmt2){

					$_SESSION['notification']['type']="success";
					$_SESSION['notification']['message']="The product ID ".$_GET['id']." was updated properly.";
					$_SESSION['userLog']['description']="The product ID ".$_GET['id']." was updated properly.";

				} else {

					$_SESSION['notification']['type']="error";
					$_SESSION['notification']['message']="Error to update the image in the server for the products ID ".$_GET['id'].".";
					$_SESSION['userLog']['description']="Error to update the image in the server for the products ID ".$_GET['id'].".";

				}
				
			} else {

				$_SESSION['notification']['type']="success";
				$_SESSION['notification']['message']="The item ID ".$_GET['id']." was updated properly.";
				$_SESSION['userLog']['description']="The item ID ".$_GET['id']." was updated properly.";
				 
				$nextRoute = "productsList.php?tableStatus=view&reportCat=ALL";
				if(isset($_GET['currentPage'])){
					$nextRoute .= "&page=".$_GET['currentPage'];
				}
				header ("Location: ".$nextRoute);
				exit();

			}
		}
	}	
}
else   
{  
    
     die( print_r( mysqli_error($conn), true));  
		
}  
$nextRoute = "productsList.php?tableStatus=view&reportCat=ALL";
if(isset($_GET['currentPage'])){
	$nextRoute .= "&page=".$_GET['currentPage'];
}
header ("Location: ".$nextRoute);
exit();
ob_end_flush();
mysqli_free_result( $stmt);  
mysqli_close( $conn);  
}

?>































