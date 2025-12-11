<?php
ob_start();
include '../system/session.php';
include '../system/formQuery.php';
require '../vendor/autoload.php';
$date = date("Y-m-d");
$_SESSION['userLog']['module'] = "Company Profile";

if (($_GET['formStatus'] == 'create') or ($_GET['formStatus'] == 'edit')) {
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

		if ($_GET['formStatus'] == 'create') {
			$sql2 = "SELECT id, businessName FROM business ORDER BY id DESC LIMIT 1;";
			$stmt2 = mysqli_query($conn, $sql2);



			if ($stmt2) {
				$row2 = mysqli_fetch_array($stmt2, MYSQLI_ASSOC);
				$getbusinessId = $row2['id'];
				$getBusinessName = $row2['businessName'];
				$_SESSION['user']['businessId'] = $getbusinessId;
				$_SESSION['user']['businessName'] = $getBusinessName;
			}

			$sql3 = "UPDATE users SET roleId=1, businessId=" . $_SESSION['user']['businessId'] . " WHERE id='" . $_SESSION['user']['id'] . "';";
			$sql3 .= "UPDATE business SET registrationDate='" . $date . "', subscription=0, flagCompanyActive=0, flagCompanyVerified=0 WHERE id='" . $_SESSION['user']['businessId'] . "';";
			$stmt3 = mysqli_multi_query($conn, $sql3);


			if ($stmt3) {
				$_SESSION['user']['role'] = 'Administrator';
				$_SESSION['user']['roleId'] = 1;

				if ($_SESSION['user']['languageId'] != "")
					$_SESSION['user']['languageId'] = $_SESSION['user']['languageId'];
				else
					$_SESSION['user']['languageId'] = 2;

				$_SESSION['user']['subscription'] = 0;
				include 'system/languageSettings.php';
			}

			$sql4 = "INSERT INTO settings (businessId, marketDisplay, languageId) VALUES ( " . $_SESSION['user']['businessId'] . ", 0, " . $_SESSION['user']['languageId'] . ");";
			$stmt4 = mysqli_query($conn, $sql4);


			$sql5 = "INSERT INTO warehouse (businessId, warehouseId, code, name) VALUES ( " . $_SESSION['user']['businessId'] . ", 1, '0001', 'Principal');";
			$stmt5 = mysqli_query($conn, $sql5);


			if ($_SESSION["form"]["imageFile"] != "") {

				$_SESSION['form']['imageDir'] = "../assets/images/logo/" . $_SESSION['user']['businessId'] . "/";
				$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"] . $_SESSION["form"]["imageFile"];

				mkdir($_SESSION["form"]["imageDir"], 0777);

				////////////////
				$flagUploaded = false;

				$max_ancho = 800;
				$max_alto = 600;

				$medidasimagen = getimagesize($_FILES['logo']['tmp_name']);

				//Si las imagenes tienen una resoluciÃ³n y un peso aceptable se suben tal cual
				if ($medidasimagen[0] < 1280 && $_FILES['logo']['size'] < 1000000) {

					$nombrearchivo = $_FILES['logo']['name'];
					move_uploaded_file($_FILES["logo"]["tmp_name"], $_SESSION["form"]["imageFile"]);
					$flagUploaded = true;
				}


				//Si no, se generan nuevas imagenes optimizadas
				else {
					$nombrearchivo = $_FILES['logo']['name'];

					//Redimensionar
					$rtOriginal = $_FILES['logo']['tmp_name'];

					if ($_FILES['logo']['type'] == 'image/jpeg') {
						$original = imagecreatefromjpeg($rtOriginal);
					} else if ($_FILES['logo']['type'] == 'image/png') {
						$original = imagecreatefrompng($rtOriginal);
					} else if ($_FILES['logo']['type'] == 'image/gif') {
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

					if ($_FILES['logo']['type'] == 'image/jpeg') {
						imagejpeg($lienzo, $_SESSION["form"]["imageFile"]);
						$flagUploaded = true;
					} else if ($_FILES['logo']['type'] == 'image/png') {
						imagepng($lienzo, $_SESSION["form"]["imageFile"]);
						$flagUploaded = true;
					} else if ($_FILES['logo']['type'] == 'image/gif') {
						imagegif($lienzo, $_SESSION["form"]["imageFile"]);
						$flagUploaded = true;
					}


				}
				////////


				if ($flagUploaded == true) {

					if ($_FILES['logo']['type'] == 'image/gif') {
						$file_name = "L" . $_SESSION['user']['businessId'] . ".gif";
						$type = "image/gif";
					}
					;
					if ($_FILES['logo']['type'] == 'image/png') {
						$file_name = "L" . $_SESSION['user']['businessId'] . ".png";
						$type = "image/png";
					}
					;
					if ($_FILES['logo']['type'] == 'image/jpeg') {
						$file_name = "L" . $_SESSION['user']['businessId'] . ".jpeg";
						$type = "image/jpeg";
					}
					;

					rename($_SESSION["form"]["imageFile"], $_SESSION["form"]["imageDir"] . $file_name);
					$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"] . $file_name;

					$keyname = "companyPicture/" . $file_name;
					$dataImg = $_SESSION["form"]["imageFile"];

					try {
						// Upload data.
						$result = $s3->putObject([
							'Bucket' => $bucket,
							'Key' => $keyname,
							'Body' => $dataImg,
							'ContentType' => 'image',
							'StorageClass' => 'REDUCED_REDUNDANCY'
						]);

						// Print the URL to the object.
						// echo $result['ObjectURL'] . PHP_EOL;
						$urlImage = "https://asiaorientalbucket.s3.sa-east-1.amazonaws.com/companyPicture/" . $file_name;
					} catch (S3Exception $error) {
						echo $error->getMessage() . PHP_EOL;
					}

					$sql6 = "UPDATE business SET logo='" . $urlImage . "' WHERE id='" . $_SESSION['user']['businessId'] . "';";
					$stmt6 = mysqli_query($conn, $sql6);

					if ($stmt6) {
						$_SESSION['user']['logo'] = $urlImage;
						$_SESSION['notification']['type'] = "success";
						$_SESSION['notification']['message'] = $_SESSION['language']['The business profile is updated properly'];
						$_SESSION['userLog']['description'] = "The business profile is updated properly";

					} else {

						$_SESSION['notification']['type'] = "error";
						$_SESSION['notification']['message'] = "Error to update the logo in the server for the business profile ID " . $getbusinessId . ".";
						$_SESSION['userLog']['description'] = "Error to update the logo in the server for the business profile ID " . $getbusinessId . ".";

					}
				} else {

					$_SESSION['notification']['type'] = "error";
					$_SESSION['notification']['message'] = "Error to update the logo in the server for the business profile ID " . $getbusinessId . ".";
					$_SESSION['userLog']['description'] = "Error to update the logo in the server for the business profile ID " . $getbusinessId . ".";

				}
			} else {
				$_SESSION['notification']['type'] = "warning";
				$_SESSION['notification']['message'] = $_SESSION['language']['The business profile is updated properly'];
				$_SESSION['userLog']['description'] = "The business profile is updated properly";
			}

			header("Location: ../market/productsList.php?tableStatus=view");
		}

		if ($_GET['formStatus'] == 'edit') {
			$sql2 = "SELECT businessName FROM business WHERE id=" . $_SESSION['user']['businessId'] . ";";
			$stmt2 = mysqli_query($conn, $sql2);

			if ($stmt2) {
				$row2 = mysqli_fetch_array($stmt2, MYSQLI_ASSOC);
				$_SESSION['user']['businessName'] = $row2['businessName'];
			}

			if ($_SESSION["form"]["imageFile"] != "") {

				$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"] . $_SESSION["form"]["imageFile"];

				mkdir($_SESSION["form"]["imageDir"], 0777);

				////////////////
				$flagUploaded = false;

				$max_ancho = 800;
				$max_alto = 600;

				$medidasimagen = getimagesize($_FILES['logo']['tmp_name']);

				//Si las imagenes tienen una resoluciÃ³n y un peso aceptable se suben tal cual
				if ($medidasimagen[0] < 1280 && $_FILES['logo']['size'] < 1000000) {

					$nombrearchivo = $_FILES['logo']['name'];
					move_uploaded_file($_FILES["logo"]["tmp_name"], $_SESSION["form"]["imageFile"]);
					$flagUploaded = true;
				}


				//Si no, se generan nuevas imagenes optimizadas
				else {
					$nombrearchivo = $_FILES['logo']['name'];

					//Redimensionar
					$rtOriginal = $_FILES['logo']['tmp_name'];

					if ($_FILES['logo']['type'] == 'image/jpeg') {
						$original = imagecreatefromjpeg($rtOriginal);
					} else if ($_FILES['logo']['type'] == 'image/png') {
						$original = imagecreatefrompng($rtOriginal);
					} else if ($_FILES['logo']['type'] == 'image/gif') {
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

					if ($_FILES['logo']['type'] == 'image/jpeg') {
						imagejpeg($lienzo, $_SESSION["form"]["imageFile"]);
						$flagUploaded = true;
					} else if ($_FILES['logo']['type'] == 'image/png') {
						imagepng($lienzo, $_SESSION["form"]["imageFile"]);
						$flagUploaded = true;
					} else if ($_FILES['logo']['type'] == 'image/gif') {
						imagegif($lienzo, $_SESSION["form"]["imageFile"]);
						$flagUploaded = true;
					}


				}
				////////


				if ($flagUploaded == true) {

					if ($_FILES['logo']['type'] == 'image/gif') {
						$file_name = "L" . $_SESSION['user']['businessId'] . ".gif";
						$type = "image/gif";
					}
					;
					if ($_FILES['logo']['type'] == 'image/png') {
						$file_name = "L" . $_SESSION['user']['businessId'] . ".png";
						$type = "image/png";
					}
					;
					if ($_FILES['logo']['type'] == 'image/jpeg') {
						$file_name = "L" . $_SESSION['user']['businessId'] . ".jpeg";
						$type = "image/jpeg";
					}
					;

					rename($_SESSION["form"]["imageFile"], $_SESSION["form"]["imageDir"] . $file_name);
					$_SESSION["form"]["imageFile"] = $_SESSION["form"]["imageDir"] . $file_name;

					$keyname = "companyPicture/" . $file_name;
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
					} catch (S3Exception $error) {
						echo "ERROR: " . $error->getMessage() . PHP_EOL;
					}

					$urlImage = "https://asiaorientalbucket.s3.sa-east-1.amazonaws.com/companyPicture/" . $file_name;

					$sql6 = "UPDATE business SET logo='" . $urlImage . "' WHERE id='" . $_SESSION['user']['businessId'] . "';";
					$stmt6 = mysqli_query($conn, $sql6);

					if ($stmt6) {
						$_SESSION['user']['logo'] = $urlImage;
						$_SESSION['notification']['type'] = "success";
						$_SESSION['notification']['message'] = "The business profile ID " . $_SESSION['user']['businessId'] . " was created propertly.";
						$_SESSION['userLog']['description'] = "The business profile ID " . $_SESSION['user']['businessId'] . " was created propertly.";
					} else {
						$_SESSION['notification']['type'] = "warning";
						$_SESSION['notification']['message'] = "The business profile ID " . $_SESSION['user']['businessId'] . " was created propertly without logo.";
						$_SESSION['userLog']['description'] = "The business profile ID " . $_SESSION['user']['businessId'] . " was created propertly without logo.";
					}
				} else {
					$_SESSION['notification']['type'] = "warning";
					$_SESSION['notification']['message'] = "The business profile ID " . $_SESSION['user']['businessId'] . " was created propertly without logo.";
					$_SESSION['userLog']['description'] = "The business profile ID " . $_SESSION['user']['businessId'] . " was created propertly without logo.";
				}

			} else {
				$_SESSION['notification']['type'] = "success";
				$_SESSION['notification']['message'] = "The business profile ID " . $_SESSION['user']['businessId'] . " was updated propertly.";
				$_SESSION['userLog']['description'] = "The business profile ID " . $_SESSION['user']['businessId'] . " was updated propertly.";

			}

			header("Location: profile.php?formStatus=view&id=" . $_SESSION['user']['businessId']);

		}
	} else {

		die(print_r(sqlsrv_errors(), true));

	}
	ob_end_flush();
	mysqli_free_result($stmt);
	mysqli_close($conn);
}

?>