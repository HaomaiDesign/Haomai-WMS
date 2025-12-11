<?php
ob_start();
include '../system/session.php';
include '../system/formQuery.php';
require '../vendor/autoload.php';

$_SESSION['userLog']['module'] = "My Profile";

if (($_GET['formStatus'] == 'create') or ($_GET['formStatus'] == 'edit')) {

	// if ($_GET['formStatus']=='create')
// 	$stmt = mysqli_query( $conn, $sql);  
// else
// 	$stmt = mysqli_multi_query( $conn, $sql);  	

	$stmt = mysqli_query($conn, $sql);

	if ($stmt) {

		$bucket = 'asiaorientalbucket';

		$s3 = S3Client::factory(array(
			'key' => $IAM_KEY,
			'secret' => $IAM_SECRET,
			'region' => 'sa-east-1',
			'version' => 'latest',
			'signature' => 'v4'
		));


		if ($_GET['formStatus'] == 'edit') {
			if ($_POST['languageId'] != "") {
				unset($_SESSION['language']);
				$_SESSION['user']['languageId'] = $_POST['languageId'];
				include '../system/languageSettings.php';
			}


			if (isset($_POST['email']))
				$_SESSION['user']['email'] = $_POST['email'];
			if (isset($_POST['fullName']))
				$_SESSION['user']['fullName'] = $_POST['fullName'];
			if (isset($_POST['username']))
				$_SESSION['user']['username'] = $_POST['username'];

			$_SESSION['notification']['type'] = "success";
			$_SESSION['notification']['message'] = $_SESSION['language']['Your profile is updated properly'];
			$_SESSION['userLog']['description'] = "The user profile is updated properly.";

			if ($_SESSION["form"]["imageFile"] != "") {




				////////////////

				if ($_FILES['avatar']['type'] == 'image/gif') {
					$file_name = "A" . $_SESSION['user']['id'] . ".gif";
					$type = "image/gif";
				}
				;
				if ($_FILES['avatar']['type'] == 'image/png') {
					$file_name = "A" . $_SESSION['user']['id'] . ".png";
					$type = "image/png";
				}
				;
				if ($_FILES['avatar']['type'] == 'image/jpeg') {
					$file_name = "A" . $_SESSION['user']['id'] . ".jpeg";
					$type = "image/jpeg";
				}
				;

				$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"] . $_SESSION["form"]["imageFile"];
				mkdir($_SESSION["form"]["imageDir"], 0777);

				$flagUploaded = false;

				$max_ancho = 800;
				$max_alto = 600;

				$medidasimagen = getimagesize($_FILES['avatar']['tmp_name']);


				//Si las imagenes tienen una resoluciÃ³n y un peso aceptable se suben tal cual
				if ($medidasimagen[0] < 1280 && $_FILES['avatar']['size'] < 1000000) {

					$nombrearchivo = $_FILES['avatar']['name'];
					move_uploaded_file($_FILES["avatar"]["tmp_name"], $_SESSION["form"]["imageFile"]);
					$flagUploaded = true;
				}


				//Si no, se generan nuevas imagenes optimizadas
				else {
					$nombrearchivo = $_FILES['avatar']['name'];

					//Redimensionar
					$rtOriginal = $_FILES['avatar']['tmp_name'];

					if ($_FILES['avatar']['type'] == 'image/jpeg') {
						$original = imagecreatefromjpeg($rtOriginal);
					} else if ($_FILES['avatar']['type'] == 'image/png') {
						$original = imagecreatefrompng($rtOriginal);
					} else if ($_FILES['avatar']['type'] == 'image/gif') {
						$original = imagecreatefromgif($rtOriginal);
					}

					list($ancho, $alto) = getimagesize($rtOriginal);

					$x_ratio = $max_ancho / $ancho;
					$y_ratio = $max_alto / $alto;

					if (($ancho <= $max_ancho) && ($alto <= $max_alto)) {
						$ancho_final = $ancho;
						$alto_final = $alto;
					} elseif (($x_ratio * $alto) < $max_alto) {
						$alto_final = ceil($x_ratio * $alto);
						$ancho_final = $max_ancho;
					} else {
						$ancho_final = ceil($y_ratio * $ancho);
						$alto_final = $max_alto;
					}

					$lienzo = imagecreatetruecolor($ancho_final, $alto_final);

					imagecopyresampled($lienzo, $original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);

					//imagedestroy($original);

					if ($_FILES['avatar']['type'] == 'image/jpeg') {
						imagejpeg($lienzo, $_SESSION["form"]["imageFile"]);
						$flagUploaded = true;
					} else if ($_FILES['avatar']['type'] == 'image/png') {
						imagepng($lienzo, $_SESSION["form"]["imageFile"]);
						$flagUploaded = true;
					} else if ($_FILES['avatar']['type'] == 'image/gif') {
						imagegif($lienzo, $_SESSION["form"]["imageFile"]);
						$flagUploaded = true;
					}


				}
				////////



				if ($flagUploaded == true) {

					rename($_SESSION["form"]["imageFile"], $_SESSION["form"]["imageDir"] . $file_name);
					$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"] . $file_name;

					$keyname = "profilePicture/" . $file_name;
					$dataImg = $_SESSION["form"]["imageFile"];

					try {
						// Upload data.
						$result = $s3->putObject([
							'Bucket' => $bucket,
							'Key' => $keyname,
							'SourceFile' => $dataImg,
							'ContentType' => 'image',
							'StorageClass' => 'REDUCED_REDUNDANCY'
						]);


						// Print the URL to the object.
						// echo $result['ObjectURL'] . PHP_EOL;
						$urlImage = "https://asiaorientalbucket.s3.sa-east-1.amazonaws.com/profilePicture/" . $file_name;
					} catch (S3Exception $error) {
						echo $error->getMessage() . PHP_EOL;
					}

					$sql3 = "UPDATE users SET avatar=N'" . $urlImage . "' WHERE id=" . $_SESSION['user']['id'] . ";";
					$stmt3 = mysqli_query($conn, $sql3);

					if ($stmt3) {

						$_SESSION['user']['avatar'] = $urlImage;
						$_SESSION['notification']['type'] = "success";
						$_SESSION['notification']['message'] = $_SESSION['language']['Your profile is updated properly'];
						$_SESSION['userLog']['description'] = "The user profile is updated properly.";

					} else {
						$_SESSION['notification']['type'] = "warning";
						$_SESSION['notification']['message'] = $_SESSION['language']['Your profile is updated properly'];
						$_SESSION['userLog']['description'] = "The user profile is updated without avatar.";
					}
				} else {
					$_SESSION['notification']['type'] = "warning";
					$_SESSION['notification']['message'] = $_SESSION['language']['Your profile is updated properly'];
					$_SESSION['userLog']['description'] = "The user profile is updated without avatar.";
				}

			}


		}



	} else {
		$_SESSION['notification']['type'] = "error";
		$_SESSION['notification']['message'] = "Your profile is not updated properly, please try again or contact the Administrator.";
		$_SESSION['userLog']['description'] = "The user profile is not updated properly, please try again or contact the Administrator.";
	}

	header("Location: userProfile.php?formStatus=view");
	ob_end_flush();
	mysqli_free_result($stmt);
	mysqli_close($conn);
}

?>