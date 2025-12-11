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
    </head>

    <body onload="window.print()">
		<div class="container">
    		<div class="container"  style="border: 2px solid gray; border-radius: 25px; padding: 0px; margin: 0px; width:100%; padding-top:20px;" >        
				<div class="container">	
					<div class="card" style="border: 1px solid gray; border-radius: 25px;">
                    	<div class="card-body" style="border-bottom: 1px solid gray;">
                        	<div class="row">
								<div class="col" style="text-align: center;">
									<?php
										$sql = "SELECT businessName, legalName, taxId, logo, phone, email, address, postalCode, location, province, country, webPage FROM company WHERE id=".$_GET['companyId'];

										$stmtCompany = mysqli_query($conn,$sql);

                        				if ($stmtCompany) {
                            				$row = mysqli_fetch_array($stmtCompany,MYSQLI_ASSOC);
                        				} else {
                            				echo "Hubo un error al conectar con el sv (company).";
                        				}   
									?>                    
									<img src="<?php echo $row["logo"]?>" style="height: 50px; width: auto; margin-bottom: 5px;">
									
									<p style="font-size: 10pt;"> 
										<strong><?php echo $row["businessName"]; ?></strong><br>
										<?php if (($row["address"]!="")AND($row["location"]!="")) echo $row["address"]." ".$row["location"]."<br>"; ?>
										<?php if ($row["phone"]!="") echo "TEL: ".$row["phone"]; ?>
									</p>
								
                            	</div>
                            	<br>
								<div class="col" style="text-align: center;">
									<h2>ORDEN DE COMPRA</h2>
									Fecha: <strong><?php echo $_GET["date"]; ?></strong><br>
									N° de Orden: <strong><?php echo str_pad($_GET['companyId'], 4, "0", STR_PAD_LEFT)."-".str_pad($_GET["orderId"], 6, "0", STR_PAD_LEFT); ?></strong><br>
								</div>                                          
                        	</div>
                    	</div>

                    	<!-- php code para provedor-->
						<?php
							$sql = "SELECT businessName, legalName, taxId, logo, phone, email, address, postalCode, location, province, country webPage FROM company WHERE id=".$_GET['supplierId'];

							$stmtSupplier = mysqli_query($conn,$sql);

                        	if ($stmtSupplier) {
                            	$row = mysqli_fetch_array($stmtSupplier,MYSQLI_ASSOC);
							} 
							else {
                        		echo "Hubo un error al conectar con el sv (Supplier).";
							} 
						?>
					
						<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
							<div class="container">		
                        		<div class="row" >
									<div class="col-6">
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Nombre:</strong>
                                    		</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php echo $row["legalName"];?>
											</div>                                            
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>CUIT:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php echo $row["taxId"]; ?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Domicilio:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php echo $row["address"]; ?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Localidad:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php echo $row["location"]; ?>
											</div> 
										</div>
									</div>
									<div class="col-6">
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Razon Social:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php echo $row["businessName"]; ?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Email:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php echo $row["email"]; ?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Telefono:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php echo $row["phone"]; ?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Descripcion:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php echo $row["description"]; ?>
											</div> 
										</div>
									</div>
								</div>				
							</div>
						</div>
                	</div>
            	</div>

            	<div class="container">
                	<div class="card" style="border: 1px solid gray; border-radius: 25px;">
                    	<div class="card-body" style="border-bottom: 1px solid gray;">
                            <table class="table table-sm">
                                <thead style="font-size: 10pt;">
                                    <tr>
										<th style="width:10%;font-weight:bold; text-align: center;">Codigo</th>
                                        <th style="width:10%;font-weight:bold; text-align: center;">Cantidad</th>
                                        <th style="width:45%;font-weight:bold;">Descripcion</th>
                                        <th style="width:5%;font-weight:bold; text-align: center;">Pack</th>
                                        <th style="width:15%;font-weight:bold; text-align: right;">Precio Unit.</th>
                                        <th style="width:15%;font-weight:bold; text-align: right;">Importe</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 8pt; padding-top: 0px">
                                    <?php
										$sql = "SELECT * FROM swrOrderDetails WHERE orderId=".$_GET['orderId'];
										$stmtProd = mysqli_query($conn,$sql);
										
										if ($stmtProd) {
											$subtotal = 0;
											while ($row = mysqli_fetch_array($stmtProd,MYSQLI_ASSOC)) {
												
												if($row["market"] == 0){
													$pack = "1.00";
												}
												if($row["market"] == 1){
													$pack = $row["pack"];
												}
												
												$import = $row["quantity"] * $row["price"];
												
												echo "<tr>";
												echo "<td style='text-align: center;'>" . $row["productSku"] ."</td>";
												echo "<td style='text-align: center;'>" . $row["quantity"] . "</td>";
												echo "<td>" . $row["productName"] . "</td>";
												echo "<td style='text-align: center;'>" . $pack . "</td>";
												echo "<td style='text-align: right;'> $ " . number_format($row['price'],2,",",".") . "</td>";
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
						<div class="card-body" style="margin: 0px; padding: 0px;">
							<div class="row">
								<div class="col-8" style="border-right: 1px solid gray; padding-left: 50px; padding-top: 10px;">
									<strong>Comentarios:</strong>
								</div>
								<div class="col-4">
									<div class="row" style="padding: 2px; ">
										<div class="col-6">
											<strong>Subtotal:</strong>
										</div>
                                    	<div class='col-6' style='text-align: right; padding-right: 60px;'>
											<?php echo "$ " . number_format($subtotal,2,",","."); ?>
										</div>
									</div>
									<div class="row" style="padding: 2px; ">
										<div class="col-6">
											<strong>Cargos:</strong>
										</div>
										<div class='col-6' style='text-align: right; padding-right: 60px;'>
											<?php
												$cargos = 0;
												echo "$ " . number_format($cargos,2,",",".");
											?>
										</div>
									</div>
									<div class="row" style="padding: 2px; ">
										<div class="col-6">
											<strong>Descuentos:</strong>
										</div>
										<div class='col-6' style='text-align: right; padding-right: 60px;'>
											<?php
												$descuentos = 0;
												echo "$ " . number_format($descuentos,2,",",".");
											?>
										</div>
									</div>
									<div class="row" style="padding: 2px; ">
										<div class="col-6">
											<strong>TOTAL:</strong>
										</div>
										<div class='col-6' style='text-align: right; padding-right: 60px;'>
											<?php
												$total = $subtotal + $cargos - $descuentos;
												echo "$ " . number_format($total,2,",",".");;
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php 
							mysqli_free_result($stmtProd);
							mysqli_free_result($stmtCompany);
							mysqli_free_result($stmtSupplier);
						?>					
                	</div>
            	</div>           

            	<div class="container">
                	<div class="card" style="border: 1px solid gray; border-radius: 25px;">
                    	<div class="card-body">
                        	<div class="container" style="width: 14rem;">
                            	<strong> Mensajes: </strong>
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
