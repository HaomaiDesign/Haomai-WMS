<?php 


if ($status==0) 
	echo "<span id='statusFlag-".$row['id']."' class='badge badge-primary'>".$_SESSION['language']['Requested']."</span>";

if ($status==1) 
	echo "<span class='badge' style='background-color: #e06709;'>".$_SESSION['language']['Reviewing']."</span>";

if ($status==2) 
	echo "<span class='badge badge-warning'>".$_SESSION['language']['Updated']."</span>";

if ($status==3) 
	echo "<span class='badge badge-info'>".$_SESSION['language']['Confirmed']."</span>";

if ($status==4)
	echo "<span class='badge badge-info'>".$_SESSION['language']['Preparing']."</span>";

if ($status==5) {
	if($flagStock == 1)
		echo "<span id='statusFlag-".$row['id']."' class='badge badge-success'>".$_SESSION['language']['Delivered']."</span>";
	if($flagStock == 2)
		echo "<span id='statusFlag-".$row['id']."' class='badge badge-success'>".$_SESSION['language']['Received']."</span>";
	if($flagStock == 3 || $flagStock == 4)
		echo "<span id='statusFlag-".$row['id']."' class='badge badge-secondary'>".$_SESSION['language']['Not Applied']."</span>";
	if($flagStock >=5)
		echo "<span id='statusFlag-".$row['id']."' class='badge badge-success'>".$_SESSION['language']['Completed']."</span>";
}

if ($status==6) 
	echo "<span class='badge badge-secondary'>".$_SESSION['language']['Cancelled']."</span>";

if ($status==7) 
	echo "<span class='badge badge-secondary'>".$_SESSION['language']['Rejected']."</span>";

if ($status==8) 
	echo "<span id='statusFlag-".$row['id']."' class='badge' style='background-color: #c8a2c8;'>".$_SESSION['language']['Delivery']."</span>";

?>