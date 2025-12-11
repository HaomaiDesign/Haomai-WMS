<?php 
session_start();
include "../system/db.php"; 
date_default_timezone_set('America/Argentina/Buenos_Aires');

//*********************************************************//

if ($_GET['action']=='update')
{	
	$sql = "UPDATE orders SET status=".$_GET["newStatus"]." WHERE id=".$_GET['statusId'].";";  
	$stmt = mysqli_query( $conn, $sql); 
	
	if ( $stmt ) {

		if ($_GET["newStatus"]==5) {
			
			echo "entre";
			
			////
			$sqlFlag = "SELECT * FROM orders WHERE id=".$_GET['statusId'].";";  
			$stmtFlag = mysqli_query( $conn, $sqlFlag); 

			if ( $stmtFlag ) {
			$rowFlag = mysqli_fetch_array( $stmtFlag, MYSQLI_ASSOC );
				
				$sqlStatus="";
				
				if (($rowFlag['flagLogistic']==0)OR(is_null($rowFlag['flagLogistic']))) {
					$sqlStatus.= "UPDATE orders SET flagLogistic=2 WHERE id=".$_GET['statusId'].";";
				}
				
				
				if (($rowFlag['flagStock']==0)OR(is_null($rowFlag['flagStock']))) {
					
					$datetime = date("Y-m-d H:i:s");
					
					$sqlStock0 = "SELECT id, requestId FROM stockLogs WHERE businessId=".$_SESSION['user']['businessId']." ORDER BY requestId DESC;";  
					$stmtStock0 = mysqli_query( $conn, $sqlStock0); 

					if ( $stmtStock0 ) {
					$rowStock0 = mysqli_fetch_array( $stmtStock0, MYSQLI_ASSOC );
					if (isset($rowStock0['requestId']))
						$getStockRequestId = $rowStock0['requestId'] + 1;
					else
						$getStockRequestId = 1;
					}
					
					$sqlStock1 = "SELECT id, warehouseId FROM warehouse WHERE businessId=".$_SESSION['user']['businessId']." AND warehouseId=1;";  
					$stmtStock1 = mysqli_query( $conn, $sqlStock1); 

					if ( $stmtStock1 ) {
					$rowStock1 = mysqli_fetch_array( $stmtStock1, MYSQLI_ASSOC );
					$getStockWarehouseId = $rowStock1['id'];
					}
					
					
					$sqlStock3 = "SELECT * FROM orderDetails WHERE orderId=".$_GET['statusId']." ORDER BY id ASC;";  
					$stmtStock3 = mysqli_query( $conn, $sqlStock3);

					if ($_GET['flagBuySell']==1)
						$type = 1; // Venta
					if ($_GET['flagBuySell']==0)
						$type = 2; // Compra
						
					if ( $stmtStock3 ) {
						
					while( $rowStock3 = mysqli_fetch_array( $stmtStock3, MYSQLI_ASSOC ))  
					{  

					if ($_GET['flagBuySell']==1)
						$stock = $rowStock3['quantity']*-1;
					if ($_GET['flagBuySell']==0)
						$stock = $rowStock3['quantity'];

						$sqlStatus.= "INSERT INTO stockLogs ( requestId, date, stock, type, businessId, warehouseId, productId, userId, orderId) VALUES ( ".$getStockRequestId.", '".$datetime."', ".$stock.", ".$type.", ".$_SESSION['user']['businessId'].", ".$getStockWarehouseId.", ".$rowStock3['productId'].", ".$_SESSION['user']['id'].", ".$_GET['statusId'].");";  
					 

					}
					}
					
					$sqlStatus.= "UPDATE orders SET flagStock=".$type." WHERE id=".$_GET['statusId'].";";
					
				}
				
				
				
				if (($rowFlag['flagAccounting']==0)OR(is_null($rowFlag['flagAccounting']))) {
					
					$datetime = date("Y-m-d H:i:s");

					$sqlAccounting0 = "SELECT TOP 1 sequenceId FROM fncTreasury WHERE businessId=".$_SESSION['user']['businessId']." ORDER BY sequenceId DESC;";  
					$stmtAccounting0 = mysqli_query( $conn, $sqlAccounting0); 
					
					if ( $stmtAccounting0 ) {
						$rowAccounting0 = mysqli_fetch_array( $stmtAccounting0, MYSQLI_ASSOC ); 	
						if ($rowAccounting0['sequenceId']!="")
								$getAccountingSequenceId = $rowAccounting0['sequenceId'] + 1;
							else
								$getAccountingSequenceId = 1;
					}
					
					$sqlAccounting1 = "SELECT SUM(itemPrice) AS price, flagBuySell, businessId, requestId FROM swrViewOrderList WHERE id=".$_GET['statusId']." GROUP BY flagBuySell, businessId, requestId;";  
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
							$description = "N° ".str_pad($rowAccounting1['businessId'], 4, "0", STR_PAD_LEFT)."-".str_pad($rowAccounting1['requestId'], 6, "0", STR_PAD_LEFT);
						}	

						$sqlStatus.="INSERT INTO fncTreasury (businessId, userId, sequenceId, type, datetime, account, currency, amount, description) VALUES ( ".$_SESSION['user']['businessId'].", ".$_SESSION['user']['id'].", ".$getAccountingSequenceId.", ".$type.", '".$datetime."', '".$account."', 'ARS', ".$price.", N'".$description."');";  
						$sqlStatus.="UPDATE orders SET flagAccounting=1 WHERE id=".$_GET['statusId'].";";
					
						}
				}

				$stmtStatus = mysqli_query( $conn, $sqlStatus);  
				
				echo $sqlStatus;
			}
			////
		}

	$_SESSION['userLog']['module']="status";
	$_SESSION['userLog']['description']="The order ID ".$_GET['statusId']." was changed to ".$_GET["newStatus"];

	}

}

?>
