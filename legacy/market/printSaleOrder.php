<?php include '../system/session.php';?>


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

	<script>
		function preparePrint(){
			window.print();
      		// window.onafterprint = window.close;
		}
	</script>
    <body onload="preparePrint()">
	<div class="container" style="height: 297mm;">
		
	<div class="container"  style="border: 2px solid gray; border-radius: 25px; padding: 0px; margin: 0px; width:100%; padding-top:20px;" >        
		<?php if ($_GET["target"] == "out") {?>
			<div class="container">	
				<div class="card" style="border: 1px solid gray; border-radius: 25px;">
                    <div class="card-body">
                        <div class="row">
							<div class="col" style="text-align: center;">
								<!-- <?php
									// $sql = "SELECT businessName, legalName, taxId, logo, phone, email, address, postalCode, location, province, country, webPage FROM business WHERE id=".$_GET['businessId'];

									// $stmtCompany = mysqli_query($conn,$sql);

                        			// if ($stmtCompany) {
                            		// 	$row = mysqli_fetch_array($stmtCompany,MYSQLI_ASSOC);
                        			// } else {
                            		// 	echo "Hubo un error al conectar con el sv (company).";
                        			// }   
									
								?>                    
								<img src="<?php echo $row["logo"]?>" style="height: 100px; width: auto; margin-bottom: 5px;">
								
								<p style="font-size: 15pt;"> 
									<strong><?php echo $row["businessName"]; ?></strong><br>
									<?php if (($row["address"]!="")AND($row["location"]!="")) echo $row["address"]." ".$row["location"]."<br>"; ?>
									<?php if ($row["phone"]!="") echo "TEL: ".$row["phone"]; ?>
								</p>
                            </div>
                            <br>
							<div class="col" style="text-align: center;">
								<h2>NOTA DE PEDIDO</h2>
								Fecha: <strong><?php echo $_GET["date"]; ?></strong><br>
								N° de Pedido: <strong><?php echo str_pad($_GET["orderId"], 8, "0", STR_PAD_LEFT); ?></strong><br>													   
                            </div>                                           -->
                        </div>
                    </div>

                    <!-- php code para client data-->
                    <?php
						$sql1 = "SELECT businessName, phone, email, address, location, taxId, whatsapp, wechat, description FROM orders WHERE id=".$_GET['orderId'];
						$stmtCustomer = mysqli_query($conn,$sql1);

						if ($stmtCustomer) {
							$row = mysqli_fetch_array($stmtCustomer,MYSQLI_ASSOC);
						} else {
							echo "hubo un error al conectar con el (customer)";
						}    
                    ?>
					<div class="card-body" style="margin: 0px; padding: 0px; font-size: 15pt;">
						<div class="row" >
							<div class="col-12" style="padding-top: 10px; padding-left: 50px;">
								<div class="row" >
									<div class="col-6">
										<div class="row" style="padding: 3px; padding-bottom:20px; ">
											<div class="col-4">
												<strong>Cliente:</strong>
                                            </div>
											<div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
												<?php
													echo $row["businessName"];
												?>
											</div>                                            
										</div>
										<!-- <div class="row" style="padding: 3px; padding-bottom:20px;">
											<div class="col-4">
												<strong>CUIT:</strong>
											</div>
											<div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
											<?php
													echo $row["taxId"];
												?>
											</div> 
										</div> -->
										<?php if ($_SESSION['user']['subscription']>=3) {?>
										<div class="row" style="padding: 3px; padding-bottom:20px;">
											<div class="col-4">
												<strong>Whatsapp:</strong>
											</div>
											<div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
											<?php
													echo $row["whatsapp"];
												?>
											</div> 
										</div>
										<?php };?>
										<!-- <div class="row" style="padding: 3px; padding-bottom:20px;">
											<div class="col-4">
												<strong>Localidad:</strong>
											</div>
											<div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
												<?php
													echo $row["location"];
												?>
											</div> 
										</div> -->
									</div>
									<div class="col-6">
										<!-- <div class="row" style="padding: 3px; padding-bottom:20px;">
											<div class="col-4">
												<strong>Razon Social:</strong>
											</div>
											<div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt'>
												<?php
													echo $row["legalName"];
												?>
											</div> 
										</div> -->
										<!-- <div class="row" style="padding: 3px; padding-bottom:20px;">
											<div class="col-3">
												<strong>Email:</strong>
											</div>
											<div class='col-9' style='text-align: left; padding-right: 60px; font-size: 16pt;'>
												<?php
													echo $row["email"];
												?>
											</div> 
										</div> -->
										<?php if ($_SESSION['user']['subscription']>=3) {?>
										<div class="row" style="padding: 3px; ">
											<div class="col-3">
												<strong>Wechat:</strong>
											</div>
											<div class='col-9' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
												<?php
													echo $row["wechat"];
												?>
											</div> 
										</div>
										<?php };?>
										<div class="row" style="padding: 3px; padding-bottom:20px;">
											<div class="col-4">
												<strong>Telefono:</strong>
											</div>
											<div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
												<?php
													echo $row["phone"];
												?>
											</div> 
										</div>
										<!--
										<div class="row" style="padding: 3px; ">
											<div class="col-4">
												<strong>Descripcion:</strong>
											</div>
											<div class='col-8' style='text-align: right; padding-right: 60px;'>
												<?php
													echo $row["description"];
												?>
											</div> 
										</div>
										-->
									</div>
									<div class="col-6">
										<div class="row" style="padding: 3px; padding-bottom:20px;">
											<div class="col-4">
												<strong>Domicilio:</strong>
											</div>
											<div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
												<?php
													echo $row["address"];
												?>
											</div> 
										</div>
									</div>
									<div class ="col-6">
										<div class="row" style="padding: 3px; padding-bottom:20px;">
											<div class="col-4">
												<strong>N° pedido:</strong>
											</div>
											<div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
												<?php
													echo str_pad($_GET['orderId'], 8, "0", STR_PAD_LEFT);
												?>
											</div> 
										</div>
									</div>
								</div>
								<?php

								//Chequeo si existe customer en tabla customers
									$sqlCheckUser = "SELECT businessName FROM customers WHERE businessName = N'".$row["businessName"]."' LIMIT 1;";
									$stmtCheckUser = mysqli_query($conn,$sqlCheckUser);
									if($stmtCheckUser){
										$user_num_rows = mysqli_num_rows($stmtCheckUser);
										if($user_num_rows == 0 && $row["businessName"] != ""){
											$sqlInsertNewUser = "INSERT INTO customers (businessName, phone, email, address, location, taxId, whatsapp, wechat, description)
											VALUES (N'".$row["businessName"]."',N'".$row["phone"]."',N'".$row["email"]."',N'".$row["address"]."',
											N'".$row["location"]."',N'".$row["taxId"]."',N'".$row["whatsapp"]."',N'".$row["wechat"]."',N'".$row["description"]."')";

											$stmtInsertNewUser = mysqli_query($conn,$sqlInsertNewUser);
										}
									}
									
									$sqlNote = "SELECT description FROM orders WHERE id=".$_GET['orderId'];
									$stmtNote = mysqli_query($conn,$sqlNote);

									if ($stmtNote) {
									$rowNote = mysqli_fetch_array($stmtNote,MYSQLI_ASSOC);
								?>
										<!-- <div class="row">
											<div class="col-2">
												<strong>Descripción:</strong>
											</div>
											<div class='col-10' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
												<?php
													echo $rowNote["description"];
												?>
											</div> 
										</div> -->
								<?php
									}                    
								?>
								
							
							</div>
							
						</div>
					</div>
				
                </div>
            </div>
			
			<?php } ?>

            <div class="container">
                <div class="card" style="border: 1px solid gray; border-radius: 25px; margin-inline:-2%;">
                    <div class="card-body" style="border-bottom: 1px solid gray;">
                            <table class="table table-sm">
                                <thead style="font-size: 10pt;">
                                    <tr>
										<!-- <th style="width:15%; font-weight:bold; font-size: 16pt; text-align: center;"><?php echo $_SESSION['language']['Unit Barcode'];?></th> -->
                                        <th style="width:10%; font-weight:bold; font-size: 16pt; text-align: center;"><?php echo $_SESSION['language']['Quantity'];?></th>
                                        <th style="width:35%; font-weight:bold; font-size: 16pt;"><?php echo $_SESSION['language']['Product Name'];?></th>
										<!-- <th style="width:35%; font-weight:bold; font-size: 16pt;"><?php echo $_SESSION['language']['Product Name'];?></th> -->
                                        <th style="width:5%; font-weight:bold; font-size: 16pt; text-align: center;"><?php echo $_SESSION['language']['Unit/Pack'];?></th>
                                        
                                    </tr>
                                </thead>
                                <tbody style="font-size: 10pt; padding-top: 0px">
                                    <?php
									
										$sql2 = " SELECT orderId, productName, productName2, unitBarcode, image, SUM(quantity) AS quantity, pack, currency FROM orderDetails WHERE orderId=".$_GET["orderId"]." GROUP BY unitBarcode";
										$stmtProd = mysqli_query($conn,$sql2);
										$products = 0;
										$units = 0;
										
										if ($stmtProd) {
											$subtotal = 0;
											while ($row = mysqli_fetch_array($stmtProd,MYSQLI_ASSOC)) {
											
											if ($row["quantity"]!=0) {									
												if($row["market"] == 0){
													$pack = "1.00";
												}
												if($row["market"] == 1){
													$pack = $row["pack"];
												}
												
												$import = $row["quantity"] * $row["price"];
												
												echo "<tr>";
												// echo "<td style='text-align: center; font-size: 16pt;'>" . $row["unitBarcode"] ."</td>";
												echo "<td style='text-align: center; font-size: 16pt;'>" . $row["quantity"] . "</td>";
												echo "<td style='font-size: 16pt;'>" . $row["productName"] . "</td>";
												// echo "<td style='font-size: 16pt;'>" . $row["productName2"] . "</td>";
												echo "<td style='text-align: center; font-size: 16pt;'>" . $pack . "</td>";
												echo "</tr>";

												$products += 1;
												$units += $row["quantity"];
											}
											}

										}
										else {
											echo "Sin datos de productos.";
										}
                                    ?>
                                </tbody>
                            </table>
                                
                    </div>
					
                </div>
            </div>           
			<!--
            <div class="container">
                <div class="card" style="border: 1px solid gray; border-radius: 25px;">
                    <div class="card-body">
                        <div class="container" style="width: 14rem;">
                            <strong> QR de Pedidos</strong>
                            <div>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x1200&data=http://www.haomai.com.ar/showroom/company/<?php echo ['businessId']; ?>/index.php?businessId=<?php echo $row['businessId']; ?>&customerId=<?php echo $_GET['customerId']; ?>" style="width:150px; height:150px;">                    
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			-->
	</div>
	<div class="card" style=" position:absolute; bottom:0; border-radius: 25px; border: 1px solid gray; width:95%;">
		<div class="card-body" style="margin: 0px; padding: 0px; font-size: 18pt;">
			<div class="row">
				<div class="col-12" style="padding-top: 10px; padding-left: 50px; padding-bottom: 50px;">
					<div class="row" style="padding: 2px; ">
						<div class="col-12">
							<strong>Cantidad de Productos: </strong>
							<?php echo $products; ?>
						</div>
					</div>
					<div class="row" style="padding: 2px; ">
						<div class="col-12">
							<strong>Total de Unidades: </strong>
							<?php
								
								echo $units;
							?>
						</div>
					</div>
					
				</div>
				<!-- <div class="col-8" style="border-left: 1px solid gray; padding-left: 50px; padding-top: 10px;">
					<strong>Comentarios: </strong>
					
						<?php
						
						// $sqlNote = "SELECT description FROM orders WHERE id=".$_GET['orderId'];
						// $stmtNote = mysqli_query($conn,$sqlNote);
	
						// if ($stmtNote) {
						// $rowNote = mysqli_fetch_array($stmtNote,MYSQLI_ASSOC);
						// echo $rowNote['description'];
						
						// }                    
					?>
					
					
				</div> -->
				
			</div>
		</div>
	</div>
	<?php 
		if($stmtCustomer) mysqli_free_result($stmtCustomer);
		if($stmtProd) mysqli_free_result($stmtProd);
		if($stmtCompany) mysqli_free_result($stmtCompany);
	?>
			

		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    
        <script src="../assets/js/vendor.js"></script>
        <script src="../assets/js/adminx.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
    </body>

</html>
