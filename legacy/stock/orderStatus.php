<?php 


if ($flagStock==0) 
	echo "<span class='badge badge-warning'>".$_SESSION['language']['Pending']."</span>";

if ($flagStock==1) 
	echo "<span class='badge badge-success'>".$_SESSION['language']['Delivered']."</span>";

if ($flagStock==2) 
	echo "<span class='badge badge-success'>".$_SESSION['language']['Received']."</span>";

if ($flagStock==3) 
	echo "<span class='badge badge-secondary'>".$_SESSION['language']['Not Applied']."</span>";

if ($flagStock==4) 
	echo "<span class='badge badge-secondary'>".$_SESSION['language']['Not Applied']."</span>";

/*
if ($status==5) 
	echo "<span class='badge badge-success'>".$_SESSION['language']['Completed']."</span>";

if ($status==6) 
	echo "<span class='badge badge-secondary'>".$_SESSION['language']['Cancelled']."</span>";

if ($status==7) 
	echo "<span class='badge badge-secondary'>".$_SESSION['language']['Rejected']."</span>";
*/
?>