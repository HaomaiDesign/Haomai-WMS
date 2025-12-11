<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>
<?php unset($_SESSION['form']); ?>
<!-- Start content-->
<?php 

if ($_SESSION['user']['companyGroup']=="tich")
	include "company/3/reportTable.php"; 
else
	include "reportTable.php";

 
?>	
	<!-- End content-->  
<?php include "../system/tableFilters.php"; ?>
<?php include "../system/contentEnd.php"; ?>				
			
