<?php if (isset($_SESSION['userLog']['description'])) 
{ 
$date = date("Y-m-d");
$time = date("H:i:s");
$sqlUserLog = "INSERT INTO userLog ( userId, userLogDate, userLogTime, module, description) VALUES ( N'".$_SESSION['user']['id']."', N'".$date."', N'".$time."', N'".$_SESSION['userLog']['module']."', N'".$_SESSION['userLog']['description']."');";  
$stmtUserLog = mysqli_query( $conn, $sqlUserLog);
// echo "sql userlog:". $sqlUserLog;  
	
unset($_SESSION['userLog']);
}; 
?>