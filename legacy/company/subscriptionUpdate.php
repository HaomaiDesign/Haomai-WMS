<?php
include '../system/session.php';

$_SESSION['userLog']['module']="Subscription";

$sql = "UPDATE company SET subscription=".$_GET['plan']." WHERE id=".$_SESSION['user']['companyId'].";";  
$stmt = mysqli_query( $conn, $sql);  

if ( $stmt ) {
$_SESSION['user']['subscription'] = $_GET['plan'];	
$_SESSION['userLog']['description']="The company ID ".$_SESSION['user']['companyId']." update the subscription to ".$_GET['plan'].".";
}

if ($_GET['plan']==0)
{	
	header ("Location: subscription.php?id=".$_SESSION['user']['id']);
}

if ($_GET['plan']==1)
{	
	header ("Location: https://www.mercadopago.com.ar/checkout/v1/redirect?pref_id=449712631-50e1c5e5-2111-41b9-b8dd-76020d9ce0eb");
}

if ($_GET['plan']==2)
{	
	header ("Location: https://www.mercadopago.com.ar/checkout/v1/redirect?pref_id=449712631-0f9362d5-effe-4ce4-9225-d693543623fa");
}

if ($_GET['plan']==3)
{	
	header ("Location: https://www.mercadopago.com.ar/checkout/v1/redirect?pref_id=449712631-838fa675-f89e-44df-b108-108eddf06bda");
}

if ($_GET['plan']==4)
{	
	header ("Location: https://www.mercadopago.com.ar/checkout/v1/redirect?pref_id=449712631-59aa179f-d932-46f7-ac4b-24567698495a");
}


?>































