<?php include "../system/session.php";?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" type="text/css" href="../assets/css/adminx.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/toastr.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/all.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<style type="text/css">

  table { overflow: visible !important; page-break-after:auto }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }


@media print {
    .export-table {
        overflow: visible !important;
    }
}

</style>
	
		
    </head>

    <body onload="window.print()">
	
		<!--<div class='page'>-->
		<div>
		<div class="container">	
			<div class="card" style="border: 1px solid gray;">
				<div class="card-body" style="padding: 10px; padding-bottom: 0px;">
					<div class="row">				
						<div class="col" style="text-align: center; padding: 25px;">
							
							<strong>RESUMEN DE PRODUCTOS POR VENCIMIENTO</strong><br>
														
							<!--
							<img src="<?php echo $row["logo"]?>" style="height: 50px; width: auto; margin: 0px; padding: 0px;">
							
							<p style="font-size: 10pt;"> 
								<strong><?php echo $row["businessName"]; ?></strong><br>
								<?php if (($row["address"]!="")AND($row["location"]!="")) echo $row["address"]." ".$row["location"]."<br>"; ?>
								<?php if ($row["phone"]!="") echo "TEL: ".$row["phone"]; ?>
							</p>
							-->
							
						</div>
						<br>
						<div class="col" style="text-align: center; padding: 25px;">
							
							<strong><?php echo $_SESSION['language']['Date'];?>: </strong><?php
							
							
// Return current date from the remote server
$date = date('Y-m-d');
echo $date;
?><br>
							<strong><?php echo $_SESSION['language']['Due Date'];?>: </strong><?php echo $_GET["search"]." ".$_SESSION['language']['Days'];?>
							
						</div> 
						
					</div>
				</div>
			</div>	
                <!-- php code para provedor-->
			
			<div class="card" style="border: 1px solid gray; ">			
				<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
					
					<!--
						<table class="table table-sm">
							<thead style="font-size: 10pt;">
								<tr>
									
									 <td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></td>									  
									  <td class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Days'];?></td>									  
									  <td class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></td>
									  
										<td style="width:30%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></td>
										
										<td style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?></td>
										
										
										<td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Unit/Pack'];?></td>
										<td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Capacity']."/".$_SESSION['language']['Unit'];?></td>	
													
									
									
									
								</tr>
							</thead>
							</table>
						-->	
							
							<table class="table table-sm">
							<tbody style="font-size: 10pt; ">
							
								<tr>
									
									 <td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></td>									  
										<td class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Day'];?></td>									  
										<td class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></td>
										<td class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></td>
										<td style="width:35%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></td>
										<td class="text-center" style="width:15%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?></td>

										<!-- <td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Unit/Pack'];?></td>
										<td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Capacity']."/".$_SESSION['language']['Unit'];?></td>	 -->
								
								</tr>
								
								<?php
									$catSql = "";
											
									if (($_GET['reportCat'] != "")AND($_GET['reportCat'] != "ALL")AND($_GET['reportCat'] != "EMPTY")) {
										$catSql .= "AND a.category = '".$_GET['reportCat']."'";
									}

									//$sql1 = "SELECT od.productSku, p.code, od.productName, SUM(od.quantity) AS totalProduct, SUM(od.pack) AS totalPack, od.pack FROM orderDetails AS od INNER JOIN orders ON orders.id = od.orderId INNER JOIN products AS p ON od.productId=p.id WHERE orders.deliveryId =".$_GET['deliveryId']. "GROUP BY od.productSku, p.code, od.productName, od.pack";
									$sql1 = "SELECT a.dueDate,a.id, a.unitBarcode, a.image, a.sku, a.name, a.category, a.flagActive, SUM(b.stock) AS stock
												FROM products AS a LEFT JOIN stockLogs AS b ON a.id=b.productId 
												WHERE a.flagActive=1 
												AND duedate  BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ".$_GET['search']." DAY) ".$catSql."
												GROUP BY a.unitBarcode
												HAVING stock > 0
												ORDER BY dueDate ASC;"; 
									
									
									$stmtProduct = mysqli_query( $conn,$sql1);

									if ($stmtProduct) {
										
										
										while ($row = mysqli_fetch_array($stmtProduct,MYSQLI_ASSOC)) {

											//$totPack = $row['totalProduct']/$row['pack'];

											//echo "<tr>";
											//echo "<td style='text-align: center;'>" . $row["productSku"] ."</td>";
											//echo "<td style='text-align: center;'>" . $row["dueDate"] . "</td>";
											//echo "<td style='text-align: center;'>" . $row["unitBarcode"] . "</td>";
											//echo "<td style='text-align: center;'>" . $row["stock"] . "</td>";
											//echo "<td style='text-align: center;'>" . $row["name"] . "</td>";
											//echo "<td style='text-align: center;'>" . $row["packWholesale"] . "</td>";
											//echo "</tr>";
									?>

									<tr id="tableRow<?php echo $row['id'];?>">
										<td class="text-center">
											<div>
												<div><?php echo $row['dueDate']; ?></div>
											</div>
										</td>
										<td class="text-center">
											<div style="color: red;">
												<strong>
												<?php 
													$days = round((strtotime($row['dueDate'])-strtotime($date))/86400);
													echo $days;
												?>
												</strong>
											</div>
										</td>
										<td class="text-center">                                                                                      
											<strong><div><?php if ($row['stock']!="") echo $row['stock']; else echo "0";?></div>  </strong>                           
										</td>
										<td class="text-center">
											<div><img src="<?php echo $row['image'];?>" class="d-inline-block align-top mr-3" alt=""></div>
										</td>
										<td>
											<!-- <div><a onclick="window.location.href='itemList.php?tableStatus=view&search=<?php echo $row['unitBarcode']; ?>&page=1'" style="cursor: pointer;"><?php if (strlen($row['name'])>50) echo substr($row['name'],0,50)."..."; else echo $row['name']; ?></a></div> -->
											<div><?php echo $row['name']; ?></div>
										</td>
										
										<td class="text-center">                                                                                                          
											<div><?php echo $row['category']; ?></div>                                                                  
										</td>
									
										<!-- <td class="text-center">
											<div><?php echo $row['packWholesale']; ?></div>
										</td>
										<td class="text-center">
											<div><?php echo $row['capacity']." ".$row['unit']; ?></div>
										</td> -->
										
										
										
										
									</tr>
									
									
									
									
									<?php									
											
										}
									}
									else {
										echo "Sin datos de productos.";
									}
								?>
							</tbody>
						</table>  
					
				</div>
				<!--		
				<div class="card-body" style="padding: 10px; padding-left: 30px; font-size: 10pt;">
					<div class="row">		
						<div class="col">
							<strong>Total de Productos: </strong>
							<?php echo number_format($totalProducts,2,",","."); ?>
						</div>						                                         
					</div>
				</div>
				-->
			</div>
		</div>
		</div>
		
					
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    
        <script src="../assets/js/vendor.js"></script>
        <script src="../assets/js/adminx.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
    </body>

</html>
