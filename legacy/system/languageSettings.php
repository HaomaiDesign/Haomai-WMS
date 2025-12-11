<?php

if (($_SESSION['user']['languageId']==2)or($_GET['lang']=='spa')or($_GET['lang']==''))
	$language = "spanish";

if (($_SESSION['user']['languageId']==1)or($_GET['lang']=='eng'))
	$language = "english";

if (($_SESSION['user']['languageId']==3)or($_GET['lang']=='por'))
	$language = "portuguese";

if (($_SESSION['user']['languageId']==4)or($_GET['lang']=='chs'))
	$language = "chinese";

if (($_SESSION['user']['languageId']==5)or($_GET['lang']=='jpn'))
	$language = "japanese";

if (($_SESSION['user']['languageId']==6)or($_GET['lang']=='kor'))
	$language = "korean";

$sqlLanguage = "SELECT * FROM translations;"; 
$stmtLanguage = mysqli_query( $conn, $sqlLanguage);

if ( $stmtLanguage ) {
while( $rowLanguage = mysqli_fetch_array( $stmtLanguage, MYSQLI_ASSOC))  
{ 	

    $_SESSION['language'][$rowLanguage['message']] = $rowLanguage[$language];
	
} 
}



?>