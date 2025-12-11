<?php
// VARIABLES TO USE 

//$_SESSION['form']['table']= 'company'; 
//if ($_GET['formStatus']=='edit') 
//	$_SESSION['form']['condition'] = "id=".$_SESSION['user']['businessId'];
//include "formQuery.php";

//Permite subir solo una imagen


// INSERT
if ($_GET['formStatus']=='create') 
{
$sql = "INSERT INTO ".$_SESSION['form']['table']." ( "; 

for ($i = 0; $i <= $_SESSION['form']['quantity']; $i++) {
    
	if ((($_SESSION['form']['type'][$i]=='image')and($_POST[$_SESSION['form']['data'][$i]]!=""))or($_SESSION['form']['type'][$i]=='string')or($_SESSION['form']['type'][$i]=='number'))
	{
		$sql.= $_SESSION['form']['data'][$i];
		if ($i < $_SESSION['form']['quantity']) 
			$sql.= ", ";
		else 
			$sql.= ") VALUES ( ";	
	}
} 

for ($i = 0; $i <= $_SESSION['form']['quantity']; $i++) {
	
	if ($_SESSION['form']['type'][$i]=='string') 
	{
		$sql.= "N'".$_POST[$_SESSION['form']['data'][$i]]."'";
		if ($i < $_SESSION['form']['quantity']) 
			$sql.= ", ";
		else 
			$sql.= ");";
	};
	
	if ($_SESSION['form']['type'][$i]=='number')
	{
		$sql.= "".$_POST[$_SESSION['form']['data'][$i]]."";
		if ($i < $_SESSION['form']['quantity']) 
			$sql.= ", ";
		else 
			$sql.= ");";
	};
	
	if (($_SESSION['form']['type'][$i]=='image')and(basename($_FILES[$_SESSION['form']['data'][$i]]["name"])!=""))
	{
		// Need set correct route using update sql en update.php $_SESSION['form']['imageDir'] + id +  $_SESSION['form']['imageFile']	
		$_SESSION['form']['imageDir'] = "../assets/images/".$_SESSION['form']['data'][$i]."/".$_GET['id']."/";
		$_SESSION['form']['imageFile'] = basename($_FILES[$_SESSION['form']['data'][$i]]["name"]);
		
	}
} 

}

// UPDATE
// Ultimo campo si o si tiene que guardar valor

if ($_GET['formStatus']=='edit') 
{

$sql = "UPDATE ".$_SESSION['form']['table']." SET "; 

for ($i = 0; $i <= $_SESSION['form']['quantity']; $i++) {
    
	if ($_SESSION['form']['type'][$i]=='string') 
	{
		$sql.= $_SESSION['form']['data'][$i]."=N'".$_POST[$_SESSION['form']['data'][$i]]."'";
		if ($i < $_SESSION['form']['quantity']) 
			$sql.= ", ";
		else 
			$sql.= " WHERE ";

	};
	
	if ($_SESSION['form']['type'][$i]=='number')
	{
		if ($_POST[$_SESSION['form']['data'][$i]]!="")
			$sql.= $_SESSION['form']['data'][$i]."=".$_POST[$_SESSION['form']['data'][$i]]."";
		else
			$sql.= $_SESSION['form']['data'][$i]."=0";
		
		if ($i < $_SESSION['form']['quantity']) 
			$sql.= ", ";
		else 
			$sql.= " WHERE ";
	};
	
	if (($_SESSION['form']['type'][$i]=='image')and(basename($_FILES[$_SESSION['form']['data'][$i]]["name"])!=""))
	{
		
		$_SESSION['form']['imageDir'] = "../assets/images/".$_SESSION['form']['data'][$i]."/".$_GET['id']."/";				
		$_SESSION['form']['imageFile'] = basename($_FILES[$_SESSION['form']['data'][$i]]["name"]);
		$sql.= $_SESSION['form']['data'][$i]."=N'".$_SESSION['form']['imageDir'].$_SESSION['form']['imageFile']."'";
		if ($i < $_SESSION['form']['quantity']) 
			$sql.= ", ";
		else 
			$sql.= " WHERE ";
	}
	
} 

$sql.= $_SESSION['form']['condition'].";";


}

// DELETE ROW
if ($_GET['formStatus']=='delete') 
{

$sql = "DELETE FROM ".$_SESSION['form']['table']." WHERE "; 

$sql.= $_SESSION['form']['condition'].";";


}

// SELECT
if ($_GET['formStatus']=='view') 
{

$sql1 = "SELECT * FROM ".$_SESSION['form']['table']." WHERE ".$_SESSION['form']['condition'].";"; 
$stmt1 = mysqli_query( $conn, $sql1);

$sql2 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$_SESSION['form']['table']."';";
$stmt2 = mysqli_query( $conn, $sql2);

$i = 0;

if ( $stmt1 ) {
while( $row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC))  
{ 	
while( $row2 = mysqli_fetch_array( $stmt2, MYSQLI_NUM))  
{  
for ($i = 0; $i < 1 ; $i++) {
    $_SESSION['form']['server'][$row2[$i]] = $row1[$row2[$i]];
} 
}
}
}
}

?>































