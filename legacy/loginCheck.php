<?php
session_start();
include 'system/db.php';
$_SESSION['userLog']['module'] = "Login";
$login = 0;

if (isset($_COOKIE["hmsys_login_access"])) {
	$username = $_COOKIE['hmsys_login_username'];
	$password = $_COOKIE['hmsys_login_access'];
	$remember = 1;
} else {
	$username = $_POST['username'];
	$password = $_POST['password'];
	if (isset($_POST["remember"]))
		$remember = 1;
	else
		$remember = 0;

}
//$sql = "SELECT users.id, users.email, users.password, users.fullName, users.businessId, users.roleId, users.avatar, users.languageId, company.businessName, company.logo FROM users INNER JOINbusinessON users.businessId=company.Id WHERE users.email='".$email."'";  
$sql = "SELECT * FROM users WHERE ((username=N'" . $username . "')OR(email=N'" . $username . "')OR(phone=N'" . $username . "'));";
$stmt = mysqli_query($conn, $sql);


if ($stmt) {
	while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
		if (password_verify($password, $row['password'])) {
			$login = 1;
			$id = $row['id'];
			$fullName = $row['fullName'];
			$username = $row['username'];
			$roleId = $row['roleId'];
			$avatar = $row['avatar'];
			$languageId = $row['languageId'];
			$businessId = $row['businessId'];
			$flagResetPassword = $row['flagResetPassword'];
			$address = $row['address'];
			$phone = $row['phone'];


			if ($businessId != '') {
				$sql2 = "SELECT * FROM business WHERE id='" . $businessId . "'";
				$stmt2 = mysqli_query($conn, $sql2);
				$row2 = mysqli_fetch_array($stmt2, MYSQLI_ASSOC);

				$businessName = $row2['businessName'];
				$logo = $row2['logo'];
				$subscription = $row2['subscription'];
				$flagCompanyVerified = $row2['flagCompanyVerified'];
				$flagCompanyActive = $row2['flagCompanyActive'];
			}

		} else {
			$login = 0;
			setcookie("hmsys_login_access", "", time() - 3600);
			unset($_COOKIE["hmsys_login_access"]);
		}
	}
} else {
	$_SESSION['notification']['type'] = "error";
	$_SESSION['notification']['message'] = "Problem with the server conection, please try again later.";
}


if ($login == 1) {

	$_SESSION['user']['id'] = $id;
	$_SESSION['user']['email'] = $email;
	$_SESSION['user']['fullName'] = $fullName;
	$_SESSION['user']['username'] = $username;
	$_SESSION['user']['roleId'] = $roleId;
	$_SESSION['user']['address'] = $address;
	$_SESSION['user']['phone'] = $phone;

	include 'system/isMobile.php';

	if ($_SESSION['user']['roleId'] == 0)
		$_SESSION['user']['role'] = "Member";

	if ($_SESSION['user']['roleId'] == 1)
		$_SESSION['user']['role'] = "Administrator";

	if ($_SESSION['user']['roleId'] == 2)
		$_SESSION['user']['role'] = "Responsable";

	if ($_SESSION['user']['roleId'] == 3)
		$_SESSION['user']['role'] = "User";

	if ($_SESSION['user']['roleId'] == 4)
		$_SESSION['user']['role'] = "Sales";

	if ($_SESSION['user']['roleId'] == 5)
		$_SESSION['user']['role'] = "Purchases";

	if ($_SESSION['user']['roleId'] == 6)
		$_SESSION['user']['role'] = "Market";



	$_SESSION['user']['businessId'] = $businessId;

	if ($businessName != '')
		$_SESSION['user']['businessName'] = $businessName;
	else
		$_SESSION['user']['businessName'] = "Haomai Technology";


	$_SESSION['user']['avatar'] = $avatar;
	$_SESSION['user']['logo'] = $logo;
	$_SESSION['user']['languageId'] = $languageId;
	$_SESSION['user']['subscription'] = $subscription;
	$_SESSION['user']['flagCompanyVerified'] = $flagCompanyVerified;
	$_SESSION['user']['flagCompanyActive'] = $flagCompanyActive;

	include 'system/languageSettings.php';

	$_SESSION['start'] = time();
	$_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
	$_SESSION['loggedin'] = true;


	if ($remember == 1) {
		setcookie("hmsys_login_username", $username);
		setcookie("hmsys_login_access", $password);
	}

	if ($remember == 0) {
		setcookie("hmsys_login_username", "", time() - 3600);
		unset($_COOKIE["hmsys_login_username"]);
		setcookie("hmsys_login_access", "", time() - 3600);
		unset($_COOKIE["hmsys_login_access"]);

	}

	$_SESSION['userLog']['description'] = "The user " . $fullName . " ID " . $id . " is logged in.";

	if ($_GET['login'] == "")
		if (isset($_SESSION['user']['flagResetPassword']) && $_SESSION['user']['flagResetPassword'] == 1) {
			header("Location: users/userProfile.php?formStatus=view");
		} else {
			if (isset($row2['mlRefreshDate'])) { //valid. mp
				$dateLimit = date_create();
				$dateLimit = date_add($dateLimit, date_interval_create_from_date_string("2 months"));
				if ($row2['mlRefreshDate'] <= $dateLimit) {
					include('mp_update.php');
				}
			}
			if ($_SESSION['user']['businessId'] == 0) {
				header("Location: company/profile.php?formStatus=create");
				//header ("Location: market/market.php?tableStatus=view&market=retail");
			} else {
				//ASIA - empleado, administrador y "sub administrador" (claudio)
				if ($_SESSION["user"]["roleId"] == 2 || $_SESSION["user"]["roleId"] == 1 || $_SESSION["user"]["roleId"] == 6) {
					//header ("Location: market/orderList.php?tableStatus=view&target=out&page=1");
					header("Location: stock/productsList.php?reportCat=ALL&tableStatus=view&page=1");
					exit();
				}
				//ASIA - gerente
				if ($_SESSION["user"]["roleId"] == 3) {
					header("Location: reports/reportCatList.php?reportCat=ALL&tableStatus=view&page=1");
					exit();
				}
				exit();
			}
		}

} else {

	$_SESSION['notification']['type'] = "error";
	$_SESSION['notification']['message'] = "Usuario o contraseña incorrecta, por favor intentar nuevamente.";

	$_SESSION['loggedin'] = false;

	header("Location: login.php");



}

/* Free statement and connection resources. */
mysqli_free_result($stmt);
mysqli_close($conn);
?>