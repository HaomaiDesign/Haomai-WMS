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

    <body>
	<div class="container">
		
	<div class="container"  style="border: 2px solid gray; border-radius: 25px; padding: 0px; margin: 0px; width:100%; padding-top:20px;" >        
			<div class="container">	
				<div class="card" style="border: 1px solid gray; border-radius: 25px;">
                    <div class="card-body" style="border-bottom: 1px solid gray;">
                        <div class="row">
							<div class="col" style="text-align: center;">
								<?php
									$sql = "SELECT businessName, legalName, taxId, logo, phone, email, address, postalCode, location, province, country webPage FROM company WHERE id=".$_GET['companyId'];

									$stmtCompany = mysqli_query($conn,$sql);

                        			if ($stmtCompany) {
                            			$row = mysqli_fetch_array($stmtCompany,MYSQLI_ASSOC);
                        			} else {
                            			echo "Hubo un error al conectar con el sv (company).";
                        			}   
									
								?>                    
								<img src="<?php echo $row["logo"]?>" style="height: 50px; width: auto; margin-bottom: 5px;">
								
								<p style="font-size: 10pt;"> <?php echo "<strong>" . $row["businessName"] . "</strong><br>" . $row["address"] . " " . $row["location"] . "<br>" . "TEL: " .  $row["phone"] ?> </p>
                            </div>
                            <br>
							<div class="col" style="text-align: center;">
								<h2>NOTA DE PEDIDO</h2>
								Fecha: <strong><?php echo $_GET["date"]; ?></strong><br>
								N° de Pedido: <strong><?php echo $_GET["orderId"]; ?></strong><br>													   
                            </div>                                          
                        </div>
                    </div>

                    <!-- php code para client data-->
                    <?php
                        if ($_GET['userId']!=""){
							$sql = "SELECT company.businessName, company.legalName, company.taxId, company.logo, company.phone, company.email, company.address, company.postalCode, company.location, company.province, company.description FROM users INNER JOIN company ON users.companyId=company.id WHERE users.id=".$_GET['userId'];
						}
					
						if ($_GET['customerId']!=""){
							$sql = "SELECT businessName, legalName, taxId, logo, phone, email, address, postalCode, location, province, description FROM customer WHERE id=".$_GET['customerId'];
						}

                        $stmtCustomer = mysqli_query($conn,$sql);

                        if ($stmtCustomer) {
                            $row = mysqli_fetch_array($stmtCustomer,MYSQLI_ASSOC);
                        } else {
                            echo "hubo un error al conectar con el (customer)";
                        }                    
                    ?>
					
					<div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">
						<div class="row" >
							<div class="col-10" style="border-right: 1px solid gray; padding-top: 10px; padding-left: 50px;">
								<div class="row" >
									<div class="col-6">
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Cliente:</strong>
                                            </div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php
													if($_GET['userId']!=""){
														echo $row["company.legalName"];
													}
													if($_GET['customerId']!=""){
														echo $row["legalName"];
													}
												?>
											</div>                                            
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>CUIT:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
											<?php
													if($_GET['userId']!=""){
														echo $row["company.taxId"];
													}
													if($_GET['customerId']!=""){
														echo $row["taxId"];
													}
												?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Domicilio:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php
													if($_GET['userId']!=""){
														echo $row["company.address"];
													}
													if($_GET['customerId']!=""){
														echo $row["address"];
													}
												?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Localidad:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php
													if($_GET['userId']!=""){
														echo $row["company.location"];
													}
													if($_GET['customerId']!=""){
														echo $row["location"];
													}
												?>
											</div> 
										</div>
									</div>
									<div class="col-6">
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Razon Social:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php
													if($_GET['userId']!=""){
														echo $row["company.businessName"];
													}
													if($_GET['customerId']!=""){
														echo $row["businessName"];
													}
												?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Email:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php
													if($_GET['userId']!=""){
														echo $row["company.email"];
													}
													if($_GET['customerId']!=""){
														echo $row["email"];
													}
												?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Telefono:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php
													if($_GET['userId']!=""){
														echo $row["company.phone"];
													}
													if($_GET['customerId']!=""){
														echo $row["phone"];
													}
												?>
											</div> 
										</div>
										<div class="row" style="padding: 3px; ">
											<div class="col-6">
												<strong>Descripcion:</strong>
											</div>
											<div class='col-6' style='text-align: right; padding-right: 60px;'>
												<?php
													if($_GET['userId']!=""){
														echo $row["company.description"];
													}
													if($_GET['customerId']!=""){
														echo $row["description"];
													}
												?>
											</div> 
										</div>
									</div>
								</div>
							
							</div>
							<div class="col-2" style="padding: 10px; padding-right: 20px; text-align: center;">
								<strong>Acceso Directo</strong>
								<img src="https://api.qrserver.com/v1/create-qr-code/?size=120x1200&data=http://www.haomai.com.ar/showroom/company/<?php echo $_SESSION['user']['companyId']; ?>/index.php?companyId=<?php echo $_SESSION['user']['companyId']; ?>" />                   							
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
													$import = $row["quantity"] * $row["price"];
													$pack = 1.00;
												}
												if($row["market"] == 1){
													$import = $row["quantity"] * $row["price"] * $row["pack"];
													$pack = $row["pack"];
												}
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
						mysqli_free_result($stmtCustomer);
						mysqli_free_result($stmtProd);
						mysqli_free_result($stmtCompany);
					?>
					
                </div>
            </div>           

            <div class="container">
                <div class="card" style="border: 1px solid gray; border-radius: 25px;">
                    <div class="card-body">
                        <div class="container" style="width: 14rem;">
                            <strong> QR de Pedidos</strong>
                            <div>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x1200&data=http://www.haomai.com.ar/showroom/company/<?php echo ['companyId']; ?>/index.php?companyId=<?php echo $row['companyId']; ?>&customerId=<?php echo $_GET['customerId']; ?>" style="width:150px; height:150px;">                    
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
