<?php include "../system/session.php";?>
<!--Copypaste para mantener session on-->

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

		<style>
		@page { size: 8.5in 11in; margin: 1cm }
		body {
			zoom: 100%
		}
		div.page { page-break-after: always }
		</style>
		
    </head>

    <body onload="window.print()">
	
		<!--<div class='page'>-->
		<div>
		<div class="container">	
			<div class="card" style="border: 1px solid gray; border-radius: 10px;">
				<div class="card-body" style="border-bottom: 1px solid gray; padding: 10px; padding-bottom: 0px;">
					<div class="row">				
						<div class="col" style="text-align: center;">
							
							<?php
								// $sql = "SELECT businessName, legalName, taxId, logo, phone, email, address, postalCode, location, province, country, webPage FROM business 
								// WHERE id=".$_SESSION["user"]["businessId"];

								// $stmtCompany = mysqli_query($conn,$sql);

								// if ($stmtCompany) {
								// 	$row = mysqli_fetch_array($stmtCompany,MYSQLI_ASSOC);
								// } else {
								// 	echo "Hubo un error al conectar con el sv (company).";
								// }   
								
							?>  
							
							<!-- <img src="<?php echo $row["logo"]?>" style="height: 100px; width: auto; margin: 0px; padding: 0px;">
							
							<p style="font-size: 15pt;"> 
								<strong><?php echo $row["businessName"]; ?></strong><br>
								<?php if (($row["address"]!="")AND($row["location"]!="")) echo $row["address"]." ".$row["location"]."<br>"; ?>
								<?php if ($row["phone"]!="") echo "TEL: ".$row["phone"]; ?>
							</p> -->
							
							
						</div>
						<br>
						<div class="col" style="text-align: center; padding-top: 10px; font-size: 15pt; padding-bottom:20px;">
							<strong><?= strtoupper($_SESSION['language']['Products List']);?></strong><br>
							<strong>Fecha: </strong>
							<?php $date = date('d-m-y h:i:s');
								  echo $date;
							?><br>
																	   
						</div> 
						
					</div>
				</div>
				
                <!-- php code para provedor-->
					
				<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
				
						<table class="table table-sm">
							<thead style="font-size: 10pt;">
								<tr>
									
									<th class="text-center" style="width:5%;font-weight:bold; text-align: center; font-size:10pt;"><?php echo $_SESSION['language']['Unit Barcode'];?></th>
									<th class="text-center" style="width:5%;font-weight:bold; text-align: center; font-size:10pt;"><?php echo $_SESSION['language']['SKU'];?></th>
									<th class="text-center" style="width:5%;font-weight:bold; text-align: center; font-size:10pt;"><?php echo $_SESSION['language']['Category'];?></th>
									<th class="text-center" style="width:5%;font-weight:bold; font-size:10pt;"><?php echo $_SESSION['language']['Stock'];?></th>
									<th class="text-center" style="width:35%;font-weight:bold; font-size:10pt;"><?php echo $_SESSION['language']['Product Name'];?></th>
									<th class="text-center" style="width:35%;font-weight:bold; font-size:10pt;"><?php echo $_SESSION['language']['Product Name'];?> (Chino)</th>
									<th class="text-center" style="width:5%;font-weight:bold; text-align: center; font-size:10pt;"><?php echo $_SESSION['language']['Unit/Pack'];?></th>
									<th class="text-center" style="width:5%;font-weight:bold; text-align: center; font-size:10pt;"><?php echo $_SESSION['language']['Capacity']."/".$_SESSION['language']['Unit'];?></th>
									<th class="text-center" style="width:5%;font-weight:bold; text-align: center;font-size:10pt;"><?php echo $_SESSION['language']['Due Date'];?></th>
									
								</tr>
							</thead>
							<tbody style="font-size: 10pt; padding-top: 0px">
								<?php
									$groupbyClause = "";
									if ($_GET["checkboxBarcode"] == "true"){
										$groupbyClause = " products.unitbarcode ";
									} else {
										$groupbyClause =" products.id ";
									}
									
									if ($_GET['search']!="" || $_GET['reportCat'] != ""){
										$sql1 = "SELECT stockLogs.productId,products.unitbarcode, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description,sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
											WHERE products.flagActive = 1";

										if($_GET['search']!=""){
											$sql1.= " AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )";
										}
										if($_GET['reportCat'] != ""){
											$sql1.= " AND products.category = '".$_GET['reportCat']."'";
										}

										$sql1 .=	" GROUP BY ".$groupbyClause."
												 ORDER BY products.unitbarcode ASC;"; 
									} else {
										$sql1 = "
											SELECT stockLogs.productId,products.unitbarcode, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description ,sum(stockLogs.stock) AS stock 
											FROM products   LEFT JOIN stockLogs  ON products.id=stockLogs.productId 
											WHERE products.flagActive = 1
											GROUP BY ".$groupbyClause."
											ORDER BY products.unitbarcode ASC;";
									}
									//echo "sql:".$sql1;
												
									$stmtProduct = mysqli_query( $conn,$sql1);

									if ($stmtProduct) {
										
										$totalProducts = 0;
										
										while ($row = mysqli_fetch_array($stmtProduct,MYSQLI_ASSOC)) {

											//$totPack = $row['totalProduct']/$row['pack'];

											echo "<tr>";
											
											echo "<td style='text-align: center; font-size:11pt;'>" . $row["unitbarcode"] . "</td>";
											echo "<td style='text-align: center; font-size:11pt;'>" . $row["sku"] ."</td>";		
											echo "<td style='text-align: center; font-size:11pt;'>" . $row["category"] ."</td>";
											if(isset($row["stock"]))
												echo  "<td style='text-align: center; font-size:11pt;'>" . $row["stock"]  . "</td>";
											else 
												echo "<td style='text-align: center; font-size:11pt;'>0</td>";
											// echo "<td style='text-align: center; font-size:11pt;'>" . $row["stock"]  . "</td>";
											echo "<td style='text-align: center; font-size:11pt;'>" . $row["name"] . "</td>";
											echo "<td style='text-align: center; font-size:11pt;'>" . $row["name2"] . "</td>";
											echo "<td style='text-align: center; font-size:11pt;'>" . $row["packWholesale"] . "</td>";
											echo "<td style='text-align: center; font-size:11pt;'>" . $row["capacity"] . "</td>";
											if(!isset($row["dueDate"]) || (isset($row["dueDate"]) && $row["dueDate"] == "0000-00-00"))
												echo "<td style='text-align: center; font-size:11pt;'> - </td>";
											else
												echo "<td style='text-align: center; font-size:11pt;'>" . $row["dueDate"] . "</td>";
										
															
											echo "</tr>";

											$totalProducts += 1;
											
											
										}
									}
									else {
										echo "Sin datos de productos.";
									}
								?>
							</tbody>
						</table>  
					
				</div>
						
				<div class="card-body" style="padding: 10px; padding-left: 30px; font-size: 10pt;">
					<div class="row">		
						<div class="col">
							<strong>Total de Productos: </strong>
							<?php echo number_format($totalProducts,2,",","."); ?>
						</div>						                                         
					</div>
				</div>
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
