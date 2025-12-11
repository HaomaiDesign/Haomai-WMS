<?php
include 'system/session.php';
$_SESSION['userLog']['module']="Logout";
$_SESSION['userLog']['description']="The user ".$_SESSION['user']['fullName']." ID ".$_SESSION['user']['id']." is logged out.";
include "system/userLog.php";

setcookie("hmsys_login_username", "", time()-3600);
unset($_COOKIE["hmsys_login_username"]);
setcookie("hmsys_login_access", "", time()-3600);
unset($_COOKIE["hmsys_login_access"]);

setcookie("hmsys_securitylogin", "", time()-3600);
unset($_SESSION["user"]);

if ($_GET['logout']=="showroom") {
	header ("Location: showroom/index.php?companyId=".$_GET['companyId']);
}

if ($_GET['logout']=="") {
if(session_destroy()) // Destroying All Sessions
{
	header("Location: login.php");
}
}

?>