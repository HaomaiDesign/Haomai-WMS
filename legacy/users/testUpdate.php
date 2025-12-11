<?php
/*
			$connectionString = "DefaultEndpointsProtocol=https;AccountName=haomaistorage;AccountKey=hTTdejbY7iVY3z2SRzYgxU2HpdbCNEyxKvvQUx3aTiGJPK20cx+2HxyWVhj4bwq3CMEVXYhFs7aWM5I2jxe7IQ==;EndpointSuffix=core.windows.net";
			
			// Create blob client.
			$blobClient = BlobRestProxy::createBlobService($connectionString);
			
			# Create the BlobService that represents the Blob service for the storage account
			$createContainerOptions = new CreateContainerOptions();
			
			$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
			
			// Set container metadata.
			$createContainerOptions->addMetaData("key1", "hTTdejbY7iVY3z2SRzYgxU2HpdbCNEyxKvvQUx3aTiGJPK20cx+2HxyWVhj4bwq3CMEVXYhFs7aWM5I2jxe7IQ==");
			$createContainerOptions->addMetaData("key2", "LpMxGzdyvx3P35qDQu+vWI95pO0V0a4RFXbmkGJzWvaNAsJUTF46126N98ggqgD074ST/clOBFbLjSqY0qF8OQ==");

			$containerName = "haomai";
			
			$fileToUpload = $_FILES["avatar"]["tmp_name"];

			# Upload file as a block blob
			echo "Uploading BlockBlob: ".PHP_EOL;
			echo $fileToUpload;
			echo "<br />";
			
			$content = fopen($_FILES["avatar"]["tmp_name"], "r");

			//Upload blob
			$blobClient->createBlockBlob($containerName, $fileToUpload, $content);
*/

$max_ancho = 800;
$max_alto = 600;

$nombrearchivo=$_FILES['images']['name'];

//Redimensionar
$rtOriginal=$_FILES['images']['tmp_name'];

if($_FILES['images']['type']=='image/jpeg'){
$original = imagecreatefromjpeg($rtOriginal);
}
else if($_FILES['images']['type']=='image/png'){
$original = imagecreatefrompng($rtOriginal);
}
else if($_FILES['images']['type']=='image/gif'){
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
 
if($_FILES['images']['type']=='image/jpeg'){
imagejpeg($lienzo,"./".$nombrearchivo);
}
else if($_FILES['images']['type']=='image/png'){
imagepng($lienzo,"./".$nombrearchivo);
}
else if($_FILES['images']['type']=='image/gif'){
imagegif($lienzo,"./".$nombrearchivo);
}

echo "listo";

?>































