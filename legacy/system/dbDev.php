<?php
$servername = "asiaorientaldb-dev.mysql.database.azure.com";
$dbName = "asiaorientaldb";
$username = "AsiaAdmDev";
$password = "H@0ma1D3v";
$port = 3306;
/*
$conn = mysqli_init(); 
if (!$conn) {
  die("mysqli_init failed");
}

mysqli_ssl_set($conn, NULL, NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL); 
mysqli_real_connect($conn, $servername, $username, $password, $dbName, 3306);

if (!$conn) {
  die("Connect Error: " . mysqli_connect_error());
}
*/
$conn = mysqli_connect($servername,$username,$password,$dbName,$port);

if(!$conn){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}



mysqli_set_charset($conn,"utf8mb4");


// if (mysqli_connect_errno()) {
//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
//   exit();
// } 

?>