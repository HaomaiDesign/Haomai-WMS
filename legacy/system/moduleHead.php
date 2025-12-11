<!doctype html>
<html lang="en" dir="ltr">
<head>
	<title>Haomai System</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="../../assets/images/icons/favicon.png" type="image/x-icon"/>
	<link rel="shortcut icon" type="image/x-icon" href="../../assets/images/icons/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/adminx.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../../assets/css/dashboard.css" />
	<link rel="stylesheet" type="text/css" href="../../assets/css/toastr.min.css" />
	<link rel="stylesheet" type="text/css" href="../../assets/css/all.css" />
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor.js"></script>
    <script src="../../assets/js/adminx.js"></script>
	<script src="../../assets/js/toastr.min.js"></script>
	
	
	
</head>
<body onload="notification(<?php echo "'".$_SESSION['notification']['type']."', '".$_SESSION['notification']['message']."'"; ?>)">
<?php include "notification.php"; ?>
<?php include "userLog.php"; ?>
