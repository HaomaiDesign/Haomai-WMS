<?php 
include '../system/session.php';


if ($_GET['action']=='create') {	
	
	$date = date("Y-m-d");
	$time = date("H:i:s");
	
	if ($_GET['target']=='in')
		$flagInOut = 0;
	
	if ($_GET['target']=='out')
		$flagInOut = 1;
	
	
	$sql = "INSERT INTO orders ( date, time, userId, businessId, flagInOut, flagLogistic, flagStock) VALUES ( N'".$date."', N'".$time."', ".$_SESSION['user']['id'].", ".$_SESSION['user']['businessId'].", ".$flagInOut.", 0, 0);";  	
	$stmt = mysqli_query( $conn, $sql); 

	if ( $stmt ) {
		
		$sql2 = "SELECT id FROM orders ORDER BY id DESC";  
		$stmt2 = mysqli_query( $conn, $sql2);  
		  
		if ( $stmt2 ) {
		$row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );  
		$id = $row2['id'];	
		}
		
		header ("Location: orderDetails.php?tableStatus=view&formStatus=view&roleId=".$_SESSION["user"]["roleId"]."&target=".$_GET['target']."&businessId=".$_SESSION['user']['businessId']."&userId=".$_SESSION['user']['id']."&id=".$id);	
		
	} else {
	
	$_SESSION['notification']['type']="error";
	$_SESSION['notification']['message']="The status was not updated properly";
	
	header ("Location: orderList.php?tableStatus=view&target=in&page=1");	
	
	

	}
}





if ($_GET['status']!='')
{	
	$sql = "UPDATE orders SET status=".$_GET["status"]." WHERE id=".$_GET['id'].";";  
	$stmt = mysqli_query( $conn, $sql); 

	if ( $stmt ) {

		if ($_GET["status"]==5) {
			////
			$sqlFlag = "SELECT * FROM orders WHERE id=".$_GET['id'].";";  
			$stmtFlag = mysqli_query( $conn, $sqlFlag); 

			if ( $stmtFlag ) {
			$rowFlag = mysqli_fetch_array( $stmtFlag, MYSQLI_ASSOC );
				
				$sqlStatus="";
				
				if ($rowFlag['flagLogistic']==0){
					$sqlStatus.= "UPDATE orders SET flagLogistic=2 WHERE id=".$_GET['id'].";";
				}
				
				
				if ($rowFlag['flagStock']==0){
					
					$datetime = date("Y-m-d H:i:s");
					
					$sqlStock0 = "SELECT id, requestId FROM stockLogs WHERE businessId=".$_GET['businessId']." ORDER BY requestId DESC;";  
					$stmtStock0 = mysqli_query( $conn, $sqlStock0); 

					if ( $stmtStock0 ) {
					$rowStock0 = mysqli_fetch_array( $stmtStock0, MYSQLI_ASSOC );
					if (isset($rowStock0['requestId']))
						$getStockRequestId = $rowStock0['requestId'] + 1;
					else
						$getStockRequestId = 1;
					}
					
					$sqlStock1 = "SELECT id, warehouseId FROM warehouse WHERE businessId=".$_GET['businessId']." AND warehouseId=1;";  
					$stmtStock1 = mysqli_query( $conn, $sqlStock1); 

					if ( $stmtStock1 ) {
					$rowStock1 = mysqli_fetch_array( $stmtStock1, MYSQLI_ASSOC );
					$getStockWarehouseId = $rowStock1['id'];
					}
					
					
					$sqlStock3 = "SELECT * FROM orderDetails WHERE orderId=".$_GET['id']." ORDER BY id ASC;";  
					$stmtStock3 = mysqli_query( $conn, $sqlStock3);

					if ($_GET['flagInOut']==0)
						$type = 0; // Compra
					if ($_GET['flagInOut']==1)
						$type = 1; // Venta
						
					if ( $stmtStock3 ) {
						
					while( $rowStock3 = mysqli_fetch_array( $stmtStock3, MYSQLI_ASSOC ))  
					{  

					if ($_GET['flagInOut']==0)
						$stock = $rowStock3['quantity'];
					if ($_GET['flagInOut']==1)
						$stock = $rowStock3['quantity']*-1;

						$sqlStatus.= "INSERT INTO stockLogs ( requestId, date, stock, type, businessId, warehouseId, productId, userId, orderId) VALUES ( ".$getStockRequestId.", '".$datetime."', ".$stock.", ".$type.", ".$_GET['businessId'].", ".$getStockWarehouseId.", ".$rowStock3['productId'].", ".$_SESSION['user']['id'].", ".$_GET['id'].");";  
					 

					}
					}
					
					$sqlStatus.= "UPDATE orders SET flagStock=".$type." WHERE id=".$_GET['id'].";";
					
				}
				
				/*
				
				if ($rowFlag['flagAccounting']==0){
					
					$datetime = date("Y-m-d H:i:s");

					$sqlAccounting0 = "SELECT TOP 1 sequenceId FROM fncTreasury WHERE businessId=".$_GET['businessId']." ORDER BY sequenceId DESC;";  
					$stmtAccounting0 = mysqli_query( $conn, $sqlAccounting0); 
					
					if ( $stmtAccounting0 ) {
						$rowAccounting0 = mysqli_fetch_array( $stmtAccounting0, MYSQLI_ASSOC ); 	
						if ($rowAccounting0['sequenceId']!="")
								$getAccountingSequenceId = $rowAccounting0['sequenceId'] + 1;
							else
								$getAccountingSequenceId = 1;
					}
					
					$sqlAccounting1 = "SELECT SUM(itemPrice) AS price, flagBuySell, businessId, requestId FROM swrViewOrderList WHERE id=".$_GET['id']." GROUP BY flagBuySell, businessId, requestId;";  
					$stmtAccounting1 = mysqli_query( $conn, $sqlAccounting1);
					
					
					if ( $stmtAccounting1 ) {
					
						$rowAccounting1 = mysqli_fetch_array( $stmtAccounting1, MYSQLI_ASSOC );
						
						if ($row1['flagBuySell']==0) {
							$price = $row1['price']*-1;
							$account = "Costs";
							$type = 3;
							$description = "N° ".str_pad($rowAccounting1['businessId'], 4, "0", STR_PAD_LEFT)."-".str_pad($rowAccounting1['requestId'], 6, "0", STR_PAD_LEFT);
						}
						if ($rowAccounting1['flagBuySell']==1) {
							$price = $rowAccounting1['price'];
							$account = "Sales";
							$type = 4;
							$description = "N° ".str_pad($rowAccounting1['businessId'], 4, "0", STR_PAD_LEFT)."-".str_pad($row1Accounting['requestId'], 6, "0", STR_PAD_LEFT);
						}	

						$sqlStatus.="INSERT INTO fncTreasury (businessId, userId, sequenceId, type, datetime, account, currency, amount, description) VALUES ( ".$_GET['businessId'].", ".$_SESSION['user']['id'].", ".$getAccountingSequenceId.", ".$type.", '".$datetime."', '".$account."', 'ARS', ".$price.", N'".$description."');";  
						$sqlStatus.="UPDATE orders SET flagAccounting=1 WHERE id=".$_GET['id'].";";
					
						}
				}
				
				*/

				$stmtStatus = mysqli_multi_query( $conn, $sqlStatus);  
				
			
			}
			////
		}







	$_SESSION['notification']['type']="success";
	$_SESSION['notification']['message']="The status was updated properly.";
	$_SESSION['userLog']['module']="status";
	$_SESSION['userLog']['description']="The order ID ".$_GET['id']." was changed to ".$_GET["status"];

	} else {

	$_SESSION['notification']['type']="error";
	$_SESSION['notification']['message']="The status was not updated properly";
		

	}
	
	header ("Location: orderList.php?tableStatus=view");	

}

?>