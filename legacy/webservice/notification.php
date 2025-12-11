<?php include "../system/db.php"; 
date_default_timezone_set('America/Argentina/Buenos_Aires');
$date = date("Y-m-d");
$time = date("H:i:s");

//*********************************************************//
if ($_GET['action']=="addMessage")	// userId + businessId + msg
$sql = "INSERT INTO notification (userId, businessId, date, time, category, description, flagRead) VALUES 
( ".$_GET['userId'].", ".$row1['businessId'].", '".$date."', '".$time."', 'Message','".$_GET['msg']."', 0);";  
$stmt = mysqli_query( $conn, $sql);  	
}

//*********************************************************//
if ($_GET['action']=="readMessage") // msgId
$sql = "UPDATE notification SET flagRead=1 WHERE id=".$_GET['notificationId']." AND category='Message';"; 
$stmt = mysqli_query( $conn, $sql);  	
}

//*********************************************************//
if ($_GET['action']=="readAllMessage")	// userId or businessId?
$sql = "UPDATE notification SET flagRead=1 WHERE userId=".$_GET['userId']." AND category='Message' AND flagRead=0;"; 
$stmt = mysqli_query( $conn, $sql);  	
}

//*********************************************************//
if ($_GET['action']=="addNotification")	// userId + businessId + msg
$sql = "INSERT INTO notification (userId, businessId, date, time, category, description, flagRead) VALUES 
( ".$_GET['userId'].", ".$row1['businessId'].", '".$date."', '".$time."', 'Notification','".$_GET['msg']."', 0);";  
$stmt = mysqli_query( $conn, $sql);  	
}

//*********************************************************//
if ($_GET['action']=="readNotification") // msgId
$sql = "UPDATE notification SET flagRead=1 WHERE id=".$_GET['notificationId']." AND category='Notification';"; 
$stmt = mysqli_query( $conn, $sql);  	
}

//*********************************************************//
if ($_GET['action']=="readAllNotification")	// userId or businessId?
$sql = "UPDATE notification SET flagRead=1 WHERE userId=".$_GET['userId']." AND category='Notification' AND flagRead=0;"; 
$stmt = mysqli_query( $conn, $sql);  	
}

?>
