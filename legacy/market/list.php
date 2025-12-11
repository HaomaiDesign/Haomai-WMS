<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>
<?php unset($_SESSION['form']); ?>
<!-- Start content-->
<?php include "listTable.php"; ?>
<?php include "listForm.php"; $info='info'?>
<!-- End content-->  
<?php include "../system/contentEnd.php"; ?>			
			
