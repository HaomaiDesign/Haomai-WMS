<!--Copypaste para mantener session on-->
<?php include "../../../system/session.php";?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" type="text/css" href="../../../assets/css/adminx.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../../../assets/css/dashboard.css" />
        <link rel="stylesheet" type="text/css" href="../../../assets/css/toastr.min.css" />
        <link rel="stylesheet" type="text/css" href="../../../assets/css/all.css" />
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
		<div class='page'>
		<div class="container">	
			<div class="card" style="border: 1px solid gray; border-radius: 10px;">
				<div class="card-body" style="border-bottom: 1px solid gray; padding: 10px; padding-bottom: 0px;">
					<div class="row">				
						<div class="col" style="text-align: center;">
							<?php
								$sql = "SELECT c.businessName, c.logo, c.phone, c.address, c.location, d.deliveryCode FROM lgtDelivery as d INNER JOIN company as c ON d.companyId = c.id WHERE d.id=".$_GET['deliveryId'];
								$stmtDelivery = mysqli_query($conn,$sql);
						
								if ($stmtDelivery) {
									$row = mysqli_fetch_array($stmtDelivery,MYSQLI_ASSOC);
								} 
								else {
									echo "Hubo un error al conectar con el sv (Company).";
								}   
							?>                    
							<img src="<?php echo "../../".$row["logo"]?>" style="height: 50px; width: auto; margin: 0px; padding: 0px;">
							
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
							<strong>N° de Entrega: </strong><?php echo str_pad($_GET['companyId'], 4, "0", STR_PAD_LEFT)."-".str_pad($row["deliveryCode"], 6, "0", STR_PAD_LEFT); ?><br>													   
						</div> 
						
					</div>
				</div>
				
                <!-- php code para provedor-->
					
				<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
					<table class="table table-sm">
						<thead style="font-size: 10pt;">
							<tr>
								
								<th style="width:15%;font-weight:bold; text-align: center;">Codigo</th>
								<th style="width:15%;font-weight:bold; text-align: center;">Cantidad</th>
								<th style="width:50%;font-weight:bold;">Descripcion</th>
								<th style="width:20%;font-weight:bold; text-align: center;">Cantidad/Pack</th>
								
								
                                  
                            </tr>
						</thead>
						<tbody style="font-size: 10pt; padding-top: 0px">
							<?php
								$sql = "SELECT od.productSku, p.code, od.productName, SUM(od.quantity) AS totalProduct, SUM(od.pack) AS totalPack, od.pack FROM swrOrderDetails AS od INNER JOIN swrOrder ON swrOrder.id = od.orderId INNER JOIN product AS p ON od.productId=p.id WHERE swrOrder.deliveryId =".$_GET['deliveryId']. "GROUP BY od.productSku, p.code, od.productName, od.pack";

								$stmtProduct = mysqli_query($conn,$sql);

								if ($stmtProduct) {
									$totPacks = 0;
									$totalProds = 0;
									
									while ($row = mysqli_fetch_array($stmtProduct,MYSQLI_ASSOC)) {

										$totPack = $row['totalProduct']/$row['pack'];

										echo "<tr>";
										//echo "<td style='text-align: center;'>" . $row["productSku"] ."</td>";
										echo "<td style='text-align: center;'>" . $row["code"] . "</td>";
										echo "<td style='text-align: center;'>" . number_format($row['totalProduct'],2,",","."). "</td>";
										echo "<td>" . $row["productName"] . "</td>";
										echo "<td style='text-align: center;'>" . number_format($row['pack'],2,",",".") . "</td>";
									
										echo "</tr>";

										$totPacks += $totPack;
										$totalProds += $row['totalProduct'];
										
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
							<strong>Total de Cajas: </strong>
							<?php echo number_format($totPacks,2,",","."); ?>
						</div>	
						<div class="col">
							<strong>Total de Unidades: </strong>
							<?php echo number_format($totalProds,2,",","."); ?>	   
						</div> 	                                         
					</div>
				</div>
			</div>
		</div>
		</div>
		
		<div class='page'>
				<!--Pedidos Individuales-->
				<?php
					
					$sql = "SELECT c.legalName, c.address, c.location, c.province, c.phone, cus.legalName AS cusName, cus.address AS cusAddress, cus.location AS cusLocation, cus.province AS cusProvince, cus.phone AS cusPhone, o.id AS orderId, o.requestId, o.businessName AS ordBusinessName, o.address AS ordAddress, o.location AS ordLocation, o.phone AS ordPhone FROM swrOrder AS o FULL JOIN users ON users.companyId  = o.userId FULL JOIN company AS c ON c.id = users.companyId FULL JOIN customer AS cus ON cus.id  = o.customerId WHERE o.deliveryId = " . $_GET['deliveryId']. " ORDER BY o.requestId ASC;";
					$stmtGeneral = mysqli_query($conn,$sql);

					if ($stmtGeneral) {
						while($row = mysqli_fetch_array($stmtGeneral,MYSQLI_ASSOC)){
							

						?>
						<div class="container">
							<div class="card" style="border: 1px solid gray; border-radius: 10px;">
								<div class="card-body" style="margin: 0px; padding: 5px; padding-left: 30px; font-size: 10pt;">
									<strong>Numero de Pedido: <?php echo $row['requestId']; ?></strong>
								</div>
								<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
									<div class="row" >
										<div class="col-12" style="padding-top: 3px; padding-left: 30px;">
											<div class="row" >
												<div class="col-8">
													<div>
														<strong>Cliente: </strong>
															<?php
																if($row['cusName'] == ""){
																	$name = $row['legalName'];
																} else {
																	$name = $row['cusName'];
																}
																
																if ($row['ordBusinessName'] != "")
																	$name = $row['ordBusinessName'];
																
																echo $name;
															?>
													</div>
													
													<div style="padding-top: 2px; padding-bottom: 2px;">
													<strong>Domicilio: </strong>
														<?php
														
															if($row['cusAddress'] == ""){
																$address = $row['address'];
															} else {
																$address = $row['cusAddress'];
															}
															
															if ($row['ordAddress'] != "")
																$address = $row['ordAddress'];
															
															echo $address;
														
														
														?>
													</div>
												</div>
												<div class="col-4">
													<div>
														<strong>Localidad/Provincia: </strong>
															<?php
															
																if($row['cusLocation'] == ""){
																	$location = $row['location'];
																} else {
																	$location = $row['cusLocation'];
																}
																
																if ($row['ordLocation'] != "")
																	$location = $row['ordLocation'];
																
																echo $location;
																
																
															?>
													</div>
													
													<div style="padding-top: 2px; padding-bottom: 2px;">
														<strong>Telefono: </strong>
															<?php
															
																if($row['cusPhone'] == ""){
																	$phone = $row['phone'];
																} else {
																	$phone = $row['cusPhone'];
																}
																
																if ($row['ordPhone'] != "")
																	$phone = $row['ordPhone'];
																
																echo $phone;
																
															
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
												<th style="width:10%;font-weight:bold; text-align: center;">Cantidad</th>
												<th style="width:40%;font-weight:bold;">Descripcion</th>
												<th style="width:10%;font-weight:bold; text-align: center;">Unit/Pack</th>
												
												<th style="width:15%;font-weight:bold; text-align: right;">Precio Unit.</th>
												<th style="width:15%;font-weight:bold; text-align: right;">Importe</th>
											</tr>
										</thead>
										<tbody style="font-size: 10pt; padding-top: 0px">
											<?php
												$sql = "SELECT od.productSku, p.code, od.productName, od.quantity, od.market, od.pack, od.price FROM swrOrderDetails AS od INNER JOIN product AS p ON od.productId=p.id WHERE od.orderId =" .$row['orderId'];
												$stmtProduct = mysqli_query($conn,$sql);
										
												if ($stmtProduct) {
													$subtotal = 0;
													while ($rowProd = mysqli_fetch_array($stmtProduct,MYSQLI_ASSOC)) {
														
														if($rowProd["market"] == 0){
															$pack = 1.00;
														}
														if($rowProd["market"] == 1){
															$pack = $rowProd["pack"];
														}
												
														$import = $rowProd["quantity"] * $rowProd["price"];
														
														echo "<tr>";
														
														echo "<td style='text-align: center;'>" . $rowProd["code"] . "</td>";
														echo "<td style='text-align: center;'>" . $rowProd["quantity"] . "</td>";
														echo "<td>" . $rowProd["productName"] . "</td>";
														echo "<td style='text-align: center;'>" . number_format($pack,2,",","."). "</td>";
														
														echo "<td style='text-align: right;'> $ " . number_format($rowProd['price'],2,",",".") . "</td>";
														echo "<td style='text-align: right;'> $ " . number_format($import,2,",",".") . "</td>";
														echo "</tr>";
														
														$subtotal += $import;
													}
												}
												else {
													echo "Sin datos de productos.";
												}
											?>
										</tbody>
									</table>       
								</div>

								<?php
									$sqlOrder = "SELECT charge, chargePercent, discount, discountPercent FROM swrOrder WHERE id=" . $row['orderId'];
									$stmtOrder = mysqli_query($conn,$sqlOrder);
									if($stmtOrder){
										$rowOrder = mysqli_fetch_array($stmtOrder,MYSQLI_ASSOC);
								?>
								
								<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
									<div class="row" style="margin-left: 30px; padding: 3px;">
										<div class="col" style="padding: 2px; ">		
											<strong>Subtotal: </strong>
											<?php echo "$ " . number_format($subtotal,2,",","."); ?>
										</div>
										<div class="col" style="padding: 2px; ">
											<strong>Cargos: </strong>
											<?php
												if(isset($rowOrder['chargePercent']) && $rowOrder['chargePercent'] != 0.00)
													$cargos = $rowOrder['chargePercent'] * $subtotal / 100;
												elseif(isset($rowOrder['charge']) && $rowOrder['charge'] != 0.00)
													$cargos = $rowOrder['charge'];
												else
													$cargos = 0;
												echo "$ " . number_format($cargos,2,",","."); 
											?>
										</div>
										<div class="col" style="padding: 2px; ">
											<strong>Descuentos: </strong>
											<?php
												if(isset($rowOrder['discountPercent']) && $rowOrder['discountPercent'] != 0.00)
													$descuentos = $rowOrder['discountPercent'] * $subtotal / 100;
												elseif(isset($rowOrder['discount']) && $rowOrder['discount'] != 0.00)
													$descuentos = $rowOrder['discount'];
												else
													$descuentos = 0;
												echo "$ " . number_format($descuentos,2,",",".");
											?>
										</div>
										<div class="col" style="padding: 2px; ">
											<strong>TOTAL: </strong>
											<?php 
												$total = $subtotal + $cargos - $descuentos;
												echo "$ " . number_format($total,2,",","."); 
											?>
										</div>	
									</div>
								</div>
								<?php
									} else {
										echo "Error (swrOrder charge, discount).";
									}
									mysqli_free_result($stmtOrder);
								?>
								<?php 
									mysqli_free_result($stmtProduct);
								?>					
                			</div>
						</div>
					<?php
						}
					}
					else {
						echo "hubo un error al conectar con el (UNI)";
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
    
        <script src="../../../assets/js/vendor.js"></script>
        <script src="../../../assets/js/adminx.js"></script>
        <script src="../../../assets/js/toastr.min.js"></script>
    </body>

</html>
