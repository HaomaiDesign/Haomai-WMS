<?php
include '../system/session.php';
$_SESSION['userLog']['module']="ecommerce";
$_SESSION['module']="ecommerce"; 
 
include '../system/formQuery.php';

if ($_GET['formStatus']!='view')
{
$stmt = mysqli_query( $conn, $sql);  
 
if ( $stmt ) {
	
	if ($_GET['formStatus']=='edit')
	{	
		
		
		$_SESSION["form"]["imageDir"] = "../assets/images/company/".$_SESSION['user']['companyId']."/carousel/";
		$_SESSION["form"]["carouselOne"] = basename($_FILES["carouselOne"]["name"]);	
		$_SESSION["form"]["carouselTwo"] = basename($_FILES["carouselTwo"]["name"]);
		$_SESSION["form"]["carouselThree"] = basename($_FILES["carouselThree"]["name"]);		
		$_SESSION["form"]["carouselFour"] = basename($_FILES["carouselFour"]["name"]);	
		$_SESSION["form"]["carouselFive"] = basename($_FILES["carouselFive"]["name"]);
		$_SESSION["form"]["carouselSix"] = basename($_FILES["carouselSix"]["name"]);	
		
		mkdir("../assets/images/company/".$_SESSION['user']['companyId']."/", 0777);
		mkdir($_SESSION["form"]["imageDir"], 0777);
		$sql1 = "";
		
		// resize($_FILES['carouselOne']['tmp_name'], $_FILES['carouselOne']['type'], $_FILES['carouselOne']['size'], $_SESSION["carouselOne"]["name"], $_SESSION["form"]["imageDir"], basename($_FILES["carouselOne"]["name"]));
		function resize($tempName, $imageType, $size, $name, $imageDir, $imageFile) {
			
			////////////////

			
			$max_ancho = 800;
			$max_alto = 600;
			
			$medidasimagen= getimagesize($tempName);

			//Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
				if($medidasimagen[0] < 1280 && $size < 1000000){

				$nombrearchivo=$name;
				move_uploaded_file($tempName, $imageDir.$imageFile);
				$flagUploaded = true;
			}


			//Si no, se generan nuevas imagenes optimizadas
			else {
			$nombrearchivo=$name;

			//Redimensionar
			$rtOriginal=$tempName;

			if($imageType=='image/jpeg'){
			$original = imagecreatefromjpeg($rtOriginal);
			}
			else if($imageType=='image/png'){
			$original = imagecreatefrompng($rtOriginal);
			}
			else if($imageType=='image/gif'){
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
			 
			if($imageType=='image/jpeg'){
			imagejpeg($lienzo, $imageDir.$imageFile);
			
			}
			else if($imageType=='image/png'){
			imagepng($lienzo, $imageDir.$imageFile);
			
			}
			else if($imageType=='image/gif'){
			imagegif($lienzo, $imageDir.$imageFile);
			
			}
			
			
			}
			////////
		}
		
		/*
		if ($_SESSION["form"]["carouselOne"]!="")		
			if (move_uploaded_file($_FILES["carouselOne"]["tmp_name"], $_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselOne"]))
				$sql1.= "UPDATE swrSettings SET carouselOne=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselOne"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';";  
			
		if ($_SESSION["form"]["carouselTwo"]!="")		
			if (move_uploaded_file($_FILES["carouselTwo"]["tmp_name"], $_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselTwo"]))
				$sql1.= "UPDATE swrSettings SET carouselTwo=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselTwo"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 
		
		if ($_SESSION["form"]["carouselThree"]!="")		
			if (move_uploaded_file($_FILES["carouselThree"]["tmp_name"], $_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselThree"]))
				$sql1.= "UPDATE swrSettings SET carouselThree=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselThree"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
		
		if ($_SESSION["form"]["carouselFour"]!="")		
			if (move_uploaded_file($_FILES["carouselFour"]["tmp_name"], $_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselFour"]))
				$sql1.= "UPDATE swrSettings SET carouselFour=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselFour"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
		
		if ($_SESSION["form"]["carouselFive"]!="")		
			if (move_uploaded_file($_FILES["carouselFive"]["tmp_name"], $_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselFive"]))
				$sql1.= "UPDATE swrSettings SET carouselFive=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselFive"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
		
		if ($_SESSION["form"]["carouselSix"]!="")		
			if (move_uploaded_file($_FILES["carouselSix"]["tmp_name"], $_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselSix"]))
				$sql1.= "UPDATE swrSettings SET carouselSix=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselSix"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
		*/

		if ($_SESSION["form"]["carouselOne"]!="") {		
			resize($_FILES['carouselOne']['tmp_name'], $_FILES['carouselOne']['type'], $_FILES['carouselOne']['size'], $_SESSION["carouselOne"]["name"], $_SESSION["form"]["imageDir"], basename($_FILES["carouselOne"]["name"]));
				$sql1.= "UPDATE swrSettings SET carouselOne=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselOne"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';";  
		}
		
		if ($_SESSION["form"]["carouselTwo"]!="") {			
			resize($_FILES['carouselTwo']['tmp_name'], $_FILES['carouselTwo']['type'], $_FILES['carouselTwo']['size'], $_SESSION["carouselTwo"]["name"], $_SESSION["form"]["imageDir"], basename($_FILES["carouselTwo"]["name"]));
				$sql1.= "UPDATE swrSettings SET carouselTwo=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselTwo"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 
		}
		
		if ($_SESSION["form"]["carouselThree"]!="")	{		
			resize($_FILES['carouselThree']['tmp_name'], $_FILES['carouselThree']['type'], $_FILES['carouselThree']['size'], $_SESSION["carouselThree"]["name"], $_SESSION["form"]["imageDir"], basename($_FILES["carouselThree"]["name"]));
				$sql1.= "UPDATE swrSettings SET carouselThree=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselThree"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
		}
		
		if ($_SESSION["form"]["carouselFour"]!="") {			
			resize($_FILES['carouselFour']['tmp_name'], $_FILES['carouselFour']['type'], $_FILES['carouselFour']['size'], $_SESSION["carouselFour"]["name"], $_SESSION["form"]["imageDir"], basename($_FILES["carouselFour"]["name"]));
				$sql1.= "UPDATE swrSettings SET carouselFour=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselFour"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
		}
		
		if ($_SESSION["form"]["carouselFive"]!="") {			
			resize($_FILES['carouselFive']['tmp_name'], $_FILES['carouselFive']['type'], $_FILES['carouselFive']['size'], $_SESSION["carouselFive"]["name"], $_SESSION["form"]["imageDir"], basename($_FILES["carouselFive"]["name"]));
				$sql1.= "UPDATE swrSettings SET carouselFive=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselFive"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
		}
		
		if ($_SESSION["form"]["carouselSix"]!="") {			
			resize($_FILES['carouselSix']['tmp_name'], $_FILES['carouselSix']['type'], $_FILES['carouselSix']['size'], $_SESSION["carouselSix"]["name"], $_SESSION["form"]["imageDir"], basename($_FILES["carouselSix"]["name"]));
				$sql1.= "UPDATE swrSettings SET carouselSix=N'".$_SESSION["form"]["imageDir"].$_SESSION["form"]["carouselSix"]."' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
		}

		
		$stmt1 = mysqli_query( $conn, $sql1);  
		

		if ( $stmt1 ) {
		
			$_SESSION['notification']['type']="success";
			$_SESSION['notification']['message']="The settings was updated properly.";
			$_SESSION['userLog']['description']="The settings was updated properly.";
			
		} else {
			
			$_SESSION['notification']['type']="error";
			$_SESSION['notification']['message']="Error to update the image in the server for the settings.";
			$_SESSION['userLog']['description']="Error to update the image in the server for the settings.";
			
		}
				
		header ("Location: settings.php?formStatus=view");
	}	
}
else   
{  
	
    //die( print_r( sqlsrv_errors(), true));  
	
	$_SESSION['notification']['type']="error";
	$_SESSION['notification']['message']="No se pudo actualizar, intente nuevamente.";
	header ("Location: settings.php?formStatus=view");	
}  

mysqli_free_result( $stmt);  
mysqli_close( $conn);  
}

if ($_GET['action']=='remove')
{
	if ($_GET['item']==1)
		$sql1.= "UPDATE swrSettings SET carouselOne=N'".$_GET['c2']."', carouselTwo=N'".$_GET['c3']."', carouselThree=N'".$_GET['c4']."', carouselFour=N'".$_GET['c5']."', carouselFive=N'".$_GET['c6']."', carouselSix=N'' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
	
	if ($_GET['item']==2)
		$sql1.= "UPDATE swrSettings SET carouselTwo=N'".$_GET['c3']."', carouselThree=N'".$_GET['c4']."', carouselFour=N'".$_GET['c5']."', carouselFive=N'".$_GET['c6']."', carouselSix=N'' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
	
	if ($_GET['item']==3)
		$sql1.= "UPDATE swrSettings SET carouselThree=N'".$_GET['c4']."', carouselFour=N'".$_GET['c5']."', carouselFive=N'".$_GET['c6']."', carouselSix=N'' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 			
	
	if ($_GET['item']==4)
		$sql1.= "UPDATE swrSettings SET carouselFour=N'".$_GET['c5']."', carouselFive=N'".$_GET['c6']."', carouselSix=N'' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 	

	if ($_GET['item']==5)
		$sql1.= "UPDATE swrSettings SET carouselFive=N'".$_GET['c6']."', carouselSix=N'' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 	

	if ($_GET['item']==6)
		$sql1.= "UPDATE swrSettings SET carouselSix=N'' WHERE companyId='".$_SESSION["user"]["companyId"]."';"; 
	
	$stmt1 = mysqli_query( $conn, $sql1); 
	
	header ("Location: settings.php?formStatus=view");
}


?>































