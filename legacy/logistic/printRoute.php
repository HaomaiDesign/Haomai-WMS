<!--Copypaste para mantener session on-->
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
								//$sql = "SELECT c.businessName, c.logo, c.phone, c.address, c.location, d.deliveryCode FROM delivery as d INNER JOIN businessas c ON d.businessId = c.id WHERE d.id=".$_GET['deliveryId'];
								$sql = "SELECT businessName, legalName, taxId, logo, phone, email, address, postalCode, location, province, country, webPage FROM business WHERE id=".$_GET['businessId'];
								$stmtDelivery = mysqli_query($conn,$sql);
						
								if ($stmtDelivery) {
									$row = mysqli_fetch_array($stmtDelivery,MYSQLI_ASSOC);
								} 
								else {
									echo "Hubo un error al conectar con el sv (Company).";
								}   
							?>                    
							<img src="<?php echo $row["logo"]?>" style="height: 50px; width: auto; margin: 0px; padding: 0px;">
							
							<p style="font-size: 10pt;"> 
								<strong><?php echo $row["businessName"]; ?></strong><br>
								<?php if (($row["address"]!="")AND($row["location"]!="")) echo $row["address"]." ".$row["location"]."<br>"; ?>
								<?php if ($row["phone"]!="") echo "TEL: ".$row["phone"]; ?>
							</p>
							
							
						</div>
						<br>
						<div class="col" style="text-align: center; padding-top: 10px;">
							<strong>RESUMEN DE PRODUCTOS</strong><br>
							<strong>Fecha: </strong><?php echo $_GET["date"]; ?><br>
							<strong>N° de Entrega: </strong><?php echo "D-".str_pad($_GET["deliveryId"], 8, "0", STR_PAD_LEFT); ?><br>													   
						</div> 
						
					</div>
				</div>
				
                <!-- php code para provedor-->
					
				<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
				
						<table class="table table-sm">
							<thead style="font-size: 10pt;">
								<tr>
									
									<th style="width:15%;font-weight:bold; text-align: center;">Codigo</th>
									<th style="width:10%;font-weight:bold; text-align: center;">Cantidad</th>
									<th style="width:35%;font-weight:bold;">Producto</th>
									<th style="width:35%;font-weight:bold;">Producto (Chino)</th>
									<th style="width:10%;font-weight:bold; text-align: center;">Unit/Pack</th>
													
									
									
									
								</tr>
							</thead>
							<tbody style="font-size: 10pt; padding-top: 0px">
								<?php
									//$sql1 = "SELECT od.productSku, p.code, od.productName, SUM(od.quantity) AS totalProduct, SUM(od.pack) AS totalPack, od.pack FROM orderDetails AS od INNER JOIN orders ON orders.id = od.orderId INNER JOIN products AS p ON od.productId=p.id WHERE orders.deliveryId =".$_GET['deliveryId']. "GROUP BY od.productSku, p.code, od.productName, od.pack";
									$sql1 = "SELECT unitBarcode, SUM(quantity) AS quantities, productName, productName2, pack FROM (SELECT b.unitBarcode, b.quantity, b.productName, b.productName2, b.pack, a.deliveryId FROM orders AS a LEFT JOIN orderDetails AS b ON a.id=b.orderId WHERE a.deliveryId=".$_GET['deliveryId'].") AS allTable GROUP BY unitBarcode ORDER BY productName ASC";
									
									$stmtProduct = mysqli_query( $conn,$sql1);

									if ($stmtProduct) {
										
										$totalProducts = 0;
										$totalQuantities = 0;
										
										while ($row = mysqli_fetch_array($stmtProduct,MYSQLI_ASSOC)) {

											//$totPack = $row['totalProduct']/$row['pack'];

											echo "<tr>";
											//echo "<td style='text-align: center;'>" . $row["productSku"] ."</td>";
											echo "<td style='text-align: center;'>" . $row["unitBarcode"] . "</td>";
											echo "<td style='text-align: center;'>" . number_format($row['quantities'],2,",","."). "</td>";
											echo "<td>" . $row["productName"] . "</td>";
											echo "<td>" . $row["productName2"] . "</td>";
											echo "<td style='text-align: center;'>" . number_format($row["pack"],2,",","."). "</td>";
															
											echo "</tr>";

											$totalProducts += 1;
											$totalQuantities += $row['quantities'];
											
											
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
						<div class="col">
							<strong>Total de Cantidades: </strong>
							<?php echo number_format($totalQuantities,2,",","."); ?>	   
						</div> 	                                         
					</div>
				</div>
			</div>
		</div>
		</div>
		
		<!--<div class='page'>-->
		<div>
				<!--Pedidos Individuales-->
				<?php
					
					$sql2 = "SELECT * FROM orders WHERE deliveryId=".$_GET['deliveryId']." ORDER BY id ASC;";
					$stmtOrders = mysqli_query($conn,$sql2);
					
					//echo $sql2;

					if ($stmtOrders) {
						while($rowOrders = mysqli_fetch_array($stmtOrders,MYSQLI_ASSOC)){

						$sql3 = "SELECT * FROM orders WHERE id=".$rowOrders['id'].";";
						$stmtGeneral = mysqli_query($conn,$sql3);
						//echo $sql3;

						if ($stmtGeneral) {
							while($row = mysqli_fetch_array($stmtGeneral,MYSQLI_ASSOC)){
								

							?>
							<div class="container">
								<div class="card" style="border: 1px solid gray; border-radius: 10px;">
									<div class="card-body" style="margin: 0px; padding: 5px; padding-left: 30px; font-size: 10pt;">
										<strong>Numero de Pedido: <?php echo $row['id']; ?></strong>
									</div>
									<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
										<div class="row" >
											<div class="col-12" style="padding-top: 3px; padding-left: 30px;">
												<div class="row" >
													<div class="col-8">
														<div>
															<strong>Cliente: </strong>
																<?php
																	echo $row['businessName'];
																?>
														</div>
														
														<div style="padding-top: 2px; padding-bottom: 2px;">
														<strong>Domicilio: </strong>
															<?php
																echo $row['address'];
															?>
														</div>
													</div>
													<div class="col-4">
														<div>
															<strong>Localidad/Provincia: </strong>
																<?php
																	echo $row['location'];
																?>
														</div>
														
														<div style="padding-top: 2px; padding-bottom: 2px;">
															<strong>Telefono: </strong>
																<?php
																	echo $row['phone'];
																?>
														</div>
													</div>
												</div>
											</div>		
										</div>
									</div>	
									<div class="card-body" style="border-bottom: 1px solid gray;">
										<table class="table table-sm">
											<thead style="font-size: 10pt;">
												<tr>
													
													<th style="width:10%;font-weight:bold; text-align: center;">Codigo</th>
													<th style="width:5%;font-weight:bold; text-align: center;">Cantidad</th>
													<th style="width:40%;font-weight:bold;">Producto</th>
													<th style="width:40%;font-weight:bold;">Producto (Chino)</th>
													<th style="width:5%;font-weight:bold; text-align: center;">Unit/Pack</th>
													
													
												</tr>
											</thead>
											<tbody style="font-size: 10pt; padding-top: 0px">
												<?php
													$sql3 = "SELECT * FROM orderDetails WHERE orderId=".$rowOrders['id']." ORDER BY productName ASC;";
													$stmtProduct = mysqli_query($conn,$sql3);
											
													if ($stmtProduct) {
														$subtotalProducts = 0;
														$subtotalQuantities = 0;
														while ($rowProd = mysqli_fetch_array($stmtProduct,MYSQLI_ASSOC)) {
															
															echo "<tr>";
															echo "<td style='text-align: center;'>" . $rowProd["unitBarcode"] . "</td>";
															echo "<td style='text-align: center;'>" . $rowProd["quantity"] . "</td>";
															echo "<td>" . $rowProd["productName"] . "</td>";
															echo "<td>" . $rowProd["productName2"] . "</td>";
															echo "<td style='text-align: center;'>" . number_format($rowProd["pack"],2,",","."). "</td>";
															echo "</tr>";
															
															$subtotalProducts += 1;
															$subtotalQuantities += $rowProd["quantity"];
														}
													}
													else {
														echo "Sin datos de productos.";
													}
												?>
											</tbody>
										</table>       
									</div>
									<div class="card-body" style="margin: 0px; padding: 0px; ">
										<div class="row" style="margin: 0px; padding: 2px; padding-left: 20px;">
											<div class="col-6" style="margin: 0px; padding: 0px; font-size: 10pt;">
												<strong>Total de Productos :</strong> <?php echo $subtotalProducts; ?>
											</div>
											<div class="col-6" style="margin: 0px; padding: 0px; font-size: 10pt;">
												<strong>Total de Cantidades :</strong> <?php echo $subtotalQuantities; ?>
											</div>
									</div>
									
									<?php 
										mysqli_free_result($stmtProduct);
									?>					
								</div>
							</div>
						</div>
						<?php
							}
						}
						else {
							echo "Hubo un error al conectar con el pedido";
							print_r( mysqli_error($conn), true);
						}

					} //While de cada pedido

					} else {
						echo "Hubo un error al conectar con los pedidos";
						print_r( mysqli_error($conn), true);
					}
						?>
						
					<?php 
						mysqli_free_result($stmtDelivery);
						mysqli_free_result($stmtUser);
					?>
					
					</div>
					
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    
        <script src="../assets/js/vendor.js"></script>
        <script src="../assets/js/adminx.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
    </body>

</html>
