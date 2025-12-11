<?php
//Deprecado
if ($_GET['target'] == "in") {

	$conditionId = $_GET['id'];
	$_SESSION['form']['table'] = 'orders';
	$view = "business";



}

if ($_GET['target'] == "out") {
	$conditionId = $_GET['id'];
	$_SESSION['form']['table'] = 'orders';
	$view = "business";
}


if ($_GET['formStatus'] == 'view') {
	$_SESSION['form']['condition'] = "id=" . $conditionId;
	include "../system/formQuery.php"; // Get data from DB	
}

$tempCustomer = 1;

?>


<?php if ($view == "personal") { ?>

	<div class="col-12">
		<div class="card">
			<div class="card-status card-status-left bg-teal"></div>
			<div class="card-header">
				<h3 class="card-title" style="font-weight:bold;">
					<?php if ($_GET['tableStatus'] == 'view')
						echo "<a href='orderList.php?target=" . $_GET['target'] . "&tableStatus=view&page=1' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
					<?php if ($_GET['tableStatus'] == 'view')
						echo $_SESSION['language']['Order details']; ?>
				</h3>

				<!--
									<div class="card-options">
										<a onclick="window.print()" class='btn btn-icon btn-lg'><i class='fe fe-printer'></i></a>
									</div>
									-->
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-sm-6 col-md-6">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Full Name']; ?></label>
							<input type="text" name="fullName" class="form-control" value="<?php if (isset($_SESSION['form']['server']['fullName']))
								echo $_SESSION['form']['server']['fullName']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'fullName';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>
					<div class="col-sm-6 col-md-6">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Email']; ?></label>
							<input type="text" name="email" class="form-control" value="<?php if (isset($_SESSION['form']['server']['email']))
								echo $_SESSION['form']['server']['email']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'email';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>
					<div class="col-sm-6 col-md-6">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Personal ID']; ?></label>
							<input type="text" name="personalId" class="form-control" value="<?php if (isset($_SESSION['form']['server']['personalId']))
								echo $_SESSION['form']['server']['personalId']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'personalId';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Personal Phone']; ?></label>
							<input type="text" name="phone" class="form-control" value="<?php if (isset($_SESSION['form']['server']['phone']))
								echo $_SESSION['form']['server']['phone']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'phone';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Personal Mobile']; ?></label>
							<input type="text" name="mobile" class="form-control" value="<?php if (isset($_SESSION['form']['server']['mobile']))
								echo $_SESSION['form']['server']['mobile']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'mobile';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>
					<div class="col-sm-9 col-md-9">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Address']; ?></label>
							<input type="text" name="address" class="form-control" value="<?php if (isset($_SESSION['form']['server']['address']))
								echo $_SESSION['form']['server']['address']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'address';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Postal Code']; ?></label>
							<input type="text" name="postalCode" class="form-control" value="<?php if (isset($_SESSION['form']['server']['postalCode']))
								echo $_SESSION['form']['server']['postalCode']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'postalCode';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Location']; ?></label>
							<input type="text" name="location" class="form-control" value="<?php if (isset($_SESSION['form']['server']['location']))
								echo $_SESSION['form']['server']['location']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'location';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Province / State']; ?></label>
							<input type="text" name="province" class="form-control" value="<?php if (isset($_SESSION['form']['server']['province']))
								echo $_SESSION['form']['server']['province']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'province';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Country']; ?></label>
							<input type="text" name="country" class="form-control" value="<?php if (isset($_SESSION['form']['server']['country']))
								echo $_SESSION['form']['server']['country']; ?>" readonly>
							<?php $_SESSION['form']['data'][] = 'country';
							$_SESSION['form']['type'][] = 'string';
							$_SESSION['form']['quantity']++; ?>
						</div>
					</div>

				</div>
			</div>
		</div>

	<?php }
if ($view == "business") { ?>

		<div class="col-lg-12">
			<form class="card" action="" autocomplete="off" method="post" enctype="multipart/form-data">
				<div class="card-status card-status-left bg-teal"></div>
				<div class="card-header">
					<h3 class="card-title" style="font-weight:bold;">
						<?php if ($_GET['tableStatus'] == 'view')
							echo "<a href='orderList.php?target=" . $_GET['target'] . "&tableStatus=view&page=1' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
						<?php echo $_SESSION['language']['Order details'] . " N° " . str_pad($_GET['id'], 8, "0", STR_PAD_LEFT); ?>
					</h3>
					<?php if ($_GET['target'] == 'out' && $_GET["roleId"] == "1") { ?>
						<div class="card-options">
							<div class="item-action">
								<button type="button" id="add"
									onclick="window.location.href='../users/customers.php?tableStatus=view&target=<?php echo $_GET['target']; ?>&orderId=<?php echo $_GET['id']; ?>&roleId=<?php echo $_GET['roleId']; ?>'"
									class="btn-success btn-sm"><i class="fe fe-check-circle"></i>
									<?php echo $_SESSION['language']['Select Customer']; ?> </button>
							</div>
						</div>
					<?php } ?>
					<!--
									<div class="card-options">
										<a onclick="window.print()" class='btn btn-icon btn-lg'><i class='fe fe-printer'></i></a>
									</div>
									-->
				</div>
				<?php if ($_GET['target'] == 'out') { ?>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-8 col-md-8">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Business Name']; ?></label>
									<input type="text" name="businessName" id="businessName"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','businessName','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['businessName']))
											echo $_SESSION['form']['server']['businessName']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2) {
												  echo "readonly";
											  } ?>>
									<?php $_SESSION['form']['data'][] = 'businessName';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-4 col-md-4">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Tax ID']; ?></label>
									<input type="text" name="taxId" id="taxId"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','taxId','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['taxId']))
											echo $_SESSION['form']['server']['taxId']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'taxId';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-3 col-md-3">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Phone']; ?></label>
									<input type="text" name="phone" id="phone"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','phone','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['phone']))
											echo $_SESSION['form']['server']['phone']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'phone';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-3 col-md-3">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Whatsapp']; ?></label>
									<input type="text" name="whatsapp" id="whatsapp"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','whatsapp','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['whatsapp']))
											echo $_SESSION['form']['server']['whatsapp']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'whatsapp';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-3 col-md-3">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Wechat']; ?></label>
									<input type="text" name="wechat" id="wechat"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','wechat','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['wechat']))
											echo $_SESSION['form']['server']['wechat']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'wechat';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-3 col-md-3">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Email']; ?></label>
									<input type="email" name="email" id="email"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','email','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['email']))
											echo $_SESSION['form']['server']['email']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'email';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-9 col-md-9">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Address']; ?></label>
									<input type="text" name="address" id="address"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','address','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['address']))
											echo $_SESSION['form']['server']['address']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'address';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-3 col-md-3">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Postal Code']; ?></label>
									<input type="text" name="postalCode" id="postalCode"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','postalCode','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['postalCode']))
											echo $_SESSION['form']['server']['postalCode']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'postalCode';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-4 col-md-4">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Location']; ?></label>
									<input type="text" name="location" id="location"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','location','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['location']))
											echo $_SESSION['form']['server']['location']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'location';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-4 col-md-4">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Province / State']; ?></label>
									<input type="text" name="province" id="province"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','province','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['province']))
											echo $_SESSION['form']['server']['province']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'province';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-4 col-md-4">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Country']; ?></label>
									<select name="country" id="select-countries" class="form-control custom-select" readonly>
										<option value="Argentina" data-data='{"image": "assets/images/flags/ar.svg"}' <?php if ($_SESSION['form']['server']['country'] == 'Argentina')
											echo 'selected'; ?>> Argentina
										</option>
										<option value="Brazil" data-data='{"image": "assets/images/flags/br.svg"}' <?php if ($_SESSION['form']['server']['country'] == 'Brazil')
											echo 'selected'; ?>> Brazil
										</option>
										<option value="Chile" data-data='{"image": "assets/images/flags/de.svg"}' <?php if ($_SESSION['form']['server']['country'] == 'Chile')
											echo 'selected'; ?>> Chile
										</option>
										<option value="China" data-data='{"image": "assets/images/flags/cn.svg"}' <?php if ($_SESSION['form']['server']['country'] == 'China')
											echo 'selected'; ?>> China
										</option>
									</select>
									<?php $_SESSION['form']['data'][] = 'country';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
							<div class="col-sm-12 col-md-12">
								<div class="form-group">
									<label class="form-label"><?php echo $_SESSION['language']['Description']; ?></label>
									<input type="text" name="description" id="description"
										onchange="update('<?php echo $_SESSION['form']['table']; ?>','<?php echo $_SESSION['form']['server']['id']; ?>','description','1')"
										class="form-control" value="<?php if (isset($_SESSION['form']['server']['description']))
											echo $_SESSION['form']['server']['description']; ?>" <?php if ($_SESSION["user"]["roleId"] == 2)
												  echo " readonly"; ?>>
									<?php $_SESSION['form']['data'][] = 'description';
									$_SESSION['form']['type'][] = 'string';
									$_SESSION['form']['quantity']++; ?>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</form>


		<?php } ?>


		<?php if ($_GET['tableStatus'] == 'view') { ?>
			<div class="card">
				<div class="card-status card-status-left bg-teal"></div>


				<div class="card-header">


					<div class="row">

						<div class="col-12">
							<form onsubmit="sendBarcodeToUpdate()" autocomplete="off" method="get">
								<input type="hidden" id="targetInput" name="target" class="form-control"
									value="<?php echo $_GET['target']; ?>">
								<input type="hidden" id="userIdInput" name="userId" class="form-control"
									value="<?php echo $_SESSION['user']['id']; ?>">
								<input type="hidden" id="businessIdInput" name="businessId" class="form-control"
									value="<?php echo $_SESSION['user']['businessId']; ?>">
								<input type="hidden" id="orderIdInput" name="orderId" class="form-control"
									value="<?php echo $_GET['id']; ?>">
								<input type="hidden" id="inputActionId" name="action" class="form-control"
									value="addProduct">
								<div class="row">
									<div class="col-">
										<label id="unitBarcodeTitleId"
											class="form-label"><?php echo $_SESSION['language']['Unit Barcode']; ?></label>
										<input id="unitBarcode" name="unitBarcode" value="" type="text"
											class="form-control header-search" placeholder="" autofocus required <?php if ($_GET["roleId"] == 2)
												echo "readonly"; ?>>
									</div>
									<?php if ($_GET["target"] == "out") { ?>
										<div class="col- my-auto ml-3">
											<div class="form-check">
												<input class="form-check-input" type="checkbox"
													onchange="let title = document.getElementById('unitBarcodeTitleId'); if(document.getElementById('checkboxSpecialProduct').checked) {title.innerHTML = 'PRODUCTO ESPECIAL (NOMBRE)'; document.getElementById('inputActionId').value = 'addSpecialProduct'; } else {title.innerHTML = '<?= $_SESSION['language']['Unit Barcode']; ?>'; document.getElementById('inputActionId').value = 'addProduct';}"
													value="false" id="checkboxSpecialProduct">
												<label class="form-check-label" for="checkboxSpecialProduct">
													Producto especial
												</label>
											</div>
										</div>
									<?php } ?>
									<div class="col my-auto ml-4">
										<a href="printSaleOrder.php?target=<?= $_GET["target"]; ?>&businessId=<?php echo $_GET['businessId']; ?>&userId=<?php echo $_GET['userId']; ?>&date=<?php echo date('d-m-Y', strtotime($_GET['date'])); ?>&requestId=<?php echo $_GET['requestId']; ?>&orderId=<?php echo $_GET['id']; ?>"
											target="_blank"><i class="dropdown-icon fe fe-printer"></i></a>
									</div>
								</div>
							</form>
						</div>
						<!--
								<div class="col-6">
									<form action="orderDetailsUpdate.php" autocomplete="off" method="get">
										<input type="hidden" name="target" class="form-control" value="<?php echo $_GET['target']; ?>">
										<input type="hidden" name="userId" class="form-control" value="<?php echo $_SESSION['user']['id']; ?>">
										<input type="hidden" name="businessId" class="form-control" value="<?php echo $_SESSION['user']['id']; ?>">
										<input type="hidden" name="orderId" class="form-control" value="<?php echo $_GET['id']; ?>">
										<input type="hidden" name="action" class="form-control" value="addProduct">
										<label class="form-label"><?php echo $_SESSION['language']['Product Name']; ?></label>
										<select id="unitBarcode" name="unitBarcode" onchange="this.form.submit()"  class="form-control header-search">
											<option value="" selected></option>
										<?php

										$sqlList = "SELECT * FROM products GROUP BY name ORDER BY name ASC;";
										//$stmtList = mysqli_query( $conn, $sqlList);  
									
										if ($stmtList) {
											while ($rowList = mysqli_fetch_array($stmtList, MYSQLI_ASSOC)) {
												echo "<option value='" . $rowList['unitBarcode'] . "'>" . $rowList['name'] . "/" . $rowList['name2'] . "</option>";

											}
										}
										?>

										</select>
									</form>
								</div>
-->

						<!--
								<div class="item-action">
									<form action="orderDetailsUpdate.php" autocomplete="off" method="get">
										<input type="hidden" name="target" class="form-control" value="<?php echo $_GET['target']; ?>">
										<input type="hidden" name="userId" class="form-control" value="<?php echo $_SESSION['user']['id']; ?>">
										<input type="hidden" name="businessId" class="form-control" value="<?php echo $_SESSION['user']['id']; ?>">
										<input type="hidden" name="orderId" class="form-control" value="<?php echo $_GET['id']; ?>">
										<input type="hidden" name="action" class="form-control" value="addProduct">
										<label class="form-label"><?php echo $_SESSION['language']['Unit Barcode']; ?></label>
										<input list="productList2" id="productSelected2" name="productSelected2" value="" type="text" class="form-control header-search" placeholder="" autofocus>
									</form>
								</div>
								-->


					</div>


				</div>


				<div class="table-responsive">
					<table id="table" class="table table-outline table-vcenter text-nowrap card-table">
						<thead>
							<tr>
								<th style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Product ID']; ?>
								</th>
								<th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Image']; ?></th>
								<th class="text-center" style="width:5%;min-width:100px;font-weight:bold;">
									<?php echo $_SESSION['language']['Quantity']; ?>
								</th>
								<th style="width:30%;font-weight:bold;">
									<?php echo $_SESSION['language']['Product Name']; ?>
								</th>
								<th style="width:30%;font-weight:bold;">
									<?php echo $_SESSION['language']['Product Name']; ?>
								</th>
								<th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i>
									<?php echo $_SESSION['language']['Due Date']; ?></th>
								<th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Pack']; ?></th>
								<th class="text-right" style="width:5%;font-weight:bold;"> <i class="fe fe-settings"></i>
								</th>
							</tr>
						</thead>
						<tbody id="orderDetailsTableBody">

							<?php


							//$sql = "SELECT * FROM orderDetails WHERE orderId=".$_GET['id']." ORDER BY id ASC;";
							if ($_GET["target"] == "out") {
								// $sql = "SELECT orderDetails.*, products.dueDate AS productDueDate FROM orderDetails INNER JOIN products AS products ON orderDetails.unitBarcode = products.unitBarcode WHERE orderId=".$_GET['id']." GROUP BY products.unitBarcode ORDER BY id ASC;";
								// $sql = "SELECT SUM(quantity) as quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack  FROM orderDetails WHERE orderId=".$_GET["id"]." GROUP BY unitBarcode ORDER BY id ASC;";
								$sql = "(SELECT quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack  FROM orderdetails WHERE orderId=" . $_GET["id"] . " AND unitBarcode = 'Special' ORDER BY id ASC)
													UNION
													(SELECT SUM(quantity) as quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack  FROM orderdetails WHERE orderId=" . $_GET["id"] . " AND unitBarcode != 'Special' GROUP BY unitBarcode ORDER BY id ASC);";
							}
							if ($_GET["target"] == "in") {
								// $sql = "SELECT * FROM orderdetails WHERE orderId=".$_GET['id']." ORDER BY id ASC;";
								$sql = "SELECT SUM(quantity) as quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack FROM orderdetails WHERE orderId=" . $_GET['id'] . " GROUP BY unitBarcode ORDER BY id ASC;";
							}
							//$sql = "SELECT b.id, b.unitBarcode, b.image, a.status, b.quantity, b.productName, b.pack, b.market, b.currency, b.price, b.oldPrice, b.oldQuantity FROM orders as a RIGHT JOIN orderDetails as b ON a.id=b.orderId WHERE b.orderId=".$_GET['id']." AND a.businessId=".$_GET['businessId']." ORDER BY b.productSku ASC;";  
						
							//echo "para andres: ".$sql;
						
							$stmt = mysqli_query($conn, $sql);
							$totalPrice = 0;

							if ($stmt) {
								while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {

									?>

									<tr>
										<td>
											<div><?php echo $row['unitBarcode']; ?></div>
										</td>
										<td class="text-center">
											<div><img src="<?php echo $row['image']; ?>" class="d-inline-block align-top mr-3"
													alt=""></div>
										</td>
										<td class="text-center">
											<input <?php if ($row['unitBarcode'] != "Special")
												echo "readonly"; ?> type='number'
												onchange="changeSpecialProdQuantity(<?= $row['orderId'] ?>,<?= $row['id'] ?>, this.value)"
												class='form-control' style='border: none; text-align: center;' value=<?php echo $row['quantity']; ?> min=1 step=1>

											<?php

											//echo  "<input id='quantityId".$row['id']."' type='number' onchange='updateNewQuantity(\"".$row['id']."\",\"".$row['unitBarcode']."\",)' class='form-control' style='border: none; text-align: center;' value=".$row['quantity']." min=0 step=1>";
											//echo  "<input id='quantityId".$row['id']."' type='number' onchange='window.location.href = 'orderDetailsUpdate.php?formStatus=view&tableStatus=view&target=out&businessId=3&userId=1&id=20= + this.value;"' class='form-control' style='border: none; text-align: center;' value=".$row['quantity']." min=0 step=1>";
											if ($row['oldQuantity'] != "")
												echo "<small class='text-muted'>" . $_SESSION['language']['Original'] . ": <strike>" . $row['oldQuantity'] . "</strike></small>";


											?>

										</td>
										<td>
											<div>
												<?php if ($row['quantity'] == 0)
													echo "<strike>" . $row['productName'] . "</strike>";
												else
													echo $row['productName']; ?>
											</div>
										</td>
										<td>
											<div>
												<?php if ($row['quantity'] == 0)
													echo "<strike>" . $row['productName2'] . "</strike>";
												else
													echo $row['productName2']; ?>
											</div>
										</td>
										<td>
											<div style="text-align:center">
												<?php if ($row["unitBarcode"] == "Special") { ?>
													-
												<?php } else { ?>
													<button type="button" id="modifyDates"
														onclick="openModalDates('<?= $row['unitBarcode']; ?>', <?= "'" . $_GET['target'] . "'"; ?>, <?= $row['orderId']; ?>)"
														class="btn-success btn-sm"><i class="far fa-calendar"></i> </button>
												<?php } ?>
											</div>
										</td>
										<td>
											<div><?php echo $row['pack']; ?></div>
										</td>
										<?php if ($_SESSION["user"]["roleId"] == 1) { ?>
											<td class="text-right">
												<div><a
														onclick="removeProductByBarcode('<?= $row["unitBarcode"]; ?>',<?= $_GET["id"]; ?>,<?= $row["id"]; ?>)"><i
															class="fe fe-x"></i></a></div>
											</td>
										<?php } ?>


									</tr>
									<?php
								}
								;
								?>
							</tbody>

						</table>
					</div>

				</div>


				<?php
				if ($_GET['target'] == "company") {
					?>
					<div class="card">
						<div class="card-status card-status-left bg-teal"></div>
						<div class="card-body" style="padding-top: 10px; padding-bottom: 10px; ">
							<div class="row">

								<?php

								$sqlOrder = "SELECT * FROM orders WHERE id=" . $_GET['id'] . ";";
								$stmtOrder = mysqli_query($conn, $sqlOrder);


								if ($stmtOrder) {

									$rowOrder = mysqli_fetch_array($stmtOrder, MYSQLI_ASSOC);


									?>


									<div class="col">
										<a><strong><?php echo $_SESSION['language']['Charge']; ?> (%) :</strong></a>
									</div>
									<div class="col-1">
										<input onchange="updateAdditional('<?php echo $rowOrder['id']; ?>','1')"
											id="chargePercent<?php echo $rowOrder['id']; ?>" type="number" class="form-control"
											style="border: none; text-align: right; padding: 1px;" value=<?php if ($rowOrder['chargePercent'] != 0)
												echo $rowOrder['chargePercent']; ?> min=0.01 max=100
											step=0.01>
									</div>

									<div class="col">
										<a><strong><?php echo $_SESSION['language']['Charge']; ?> ($) :</strong></a>
									</div>
									<div class="col-2">
										<input onchange="updateAdditional('<?php echo $rowOrder['id']; ?>','2')"
											id="charge<?php echo $rowOrder['id']; ?>" type="number" class="form-control"
											style="border: none; text-align: right; padding: 1px;" value=<?php if ($rowOrder['chargePercent'] != 0) {
												$charge = $totalPrice * ($rowOrder['chargePercent'] / 100);
												echo $charge;
											}
											if ($rowOrder['charge'] != 0) {
												echo $rowOrder['charge'];
												$charge = $rowOrder['charge'];
											} ?> min=0.01 step=0.01>
									</div>

									<div class="col text-right">
										<a><strong><?php echo $_SESSION['language']['Discount']; ?> (%) :</strong></a>
									</div>
									<div class="col-1">
										<input onchange="updateAdditional('<?php echo $rowOrder['id']; ?>','3')"
											id="discountPercent<?php echo $rowOrder['id']; ?>" type="number" class="form-control"
											style="border: none; text-align: right; padding: 1px;" value=<?php if ($rowOrder['discountPercent'] != 0)
												echo $rowOrder['discountPercent']; ?> min=0.01 max=100
											step=0.01>
									</div>

									<div class="col text-right">
										<a><strong><?php echo $_SESSION['language']['Discount']; ?> ($) :</strong></a>
									</div>
									<div class="col-2">
										<input onchange="updateAdditional('<?php echo $rowOrder['id']; ?>','4')"
											id="discount<?php echo $rowOrder['id']; ?>" type="number" class="form-control"
											style="border: none; text-align: right; padding: 1px;" value=<?php if ($rowOrder['discountPercent'] != 0) {
												$discount = $totalPrice * ($rowOrder['discountPercent'] / 100);
												echo $discount;
											}
											if ($rowOrder['discount'] != 0) {
												echo $rowOrder['discount'];
												$discount = $rowOrder['discount'];
											} ?> min=0.01 step=0.01>
									</div>
								<?php } ?>
							</div>
						</div>

					</div>

					<?php
				}
				?>

				<!--
							
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
								<div><strong><?php echo $_SESSION['language']['Subtotal']; ?> : <font color="green"><?php echo "$ " . number_format($totalPrice, 2, ",", "."); ?></font></strong></div>
								  <div class="card-options">
									<div><strong><?php echo $_SESSION['language']['total']; ?> : <font color="green"><?php $totalPrice = $totalPrice + $charge - $discount;
										echo "$ " . number_format($totalPrice, 2, ",", "."); ?></font></strong></div>
								  </div>
								</div>

							</div>
							-->
				<?php
							}
		}
		;
		?>
	</div>

	<!-- Modal de fechas y quantities -->




</div>
<div id="modalDates" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog">

		<div class="modal-content">
			<?php

			?>
			<div class="modal-header">
				<h4 class="modal-title" id="productName2"></h4>
				<h5 class="modal-title" id="productName1"></h5>
			</div>

			<div class="modal-body">
				<h5 class="modal-title" id="productUnitBarcode"><?php echo $_SESSION['language']['Product ID'] . ": " ?>
				</h5>
				<?php
				if ($_GET['target'] == 'in') {
					?>
					<button type="button" id="addLote" class="btn-success btn-sm"> <i class="fe fe-plus mr-2"></i> Agregar
						lote </button>
					<?php
				}
				?>
				<table id="table" class="table table-outline table-vcenter text-nowrap card-table">
					<thead>
						<tr>
							<th class="text-center" style="width:10%;min-width:100px;font-weight:bold;">
								<?php echo $_SESSION['language']['Quantity']; ?>
							</th>
							<th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i>
								<?php echo $_SESSION['language']['Due Date']; ?></th>
							<?php
							if ($_GET['target'] == 'out') {
								?>
								<th class="text-center" style="width:10%;font-weight:bold;">
									<?php echo $_SESSION['language']['Available']; ?>
								</th>
								<th class="text-center" style="width:10%;font-weight:bold;">
									<?php echo $_SESSION['language']['Stock']; ?>
								</th>
								<th class="text-center" style="width:10%;font-weight:bold;">
									<?php echo $_SESSION['language']['Warehouse']; ?>
								</th>
								<?php
							} else {
								?>
								<th class="text-center" style="width:5%;font-weight:bold;"> <i class="fe fe-settings"></i>
								</th>
								<?php
							}
							?>
						</tr>
					</thead>
					<tbody id="modalProdTableBody">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="location.reload()" class="btn btn-default"
					data-dismiss="modal">Cerrar</button>
			</div>

		</div>
	</div>
</div>

<script>

	// no anduvo F
	// function setSpecialProductTitle(){
	// 	let checkboxSpecialProduct = document.getElementById("checkboxSpecialProduct").checked;
	// 	let unitBarcodeTitle = document.getElementById("unitBarcodeTitleId");
	// 	if(checkboxSpecialProduct == true){
	// 		unitBarcodeTitle.innerHTML = "PRODUCTO ESPECIAL (NOMBRE)";
	// 	} else {
	// 		unitBarcodeTitle.innerHTML = "<?= $_SESSION['language']['Unit Barcode']; ?>";
	// 	}
	// }
	function confirmationSound() {
		var snd = new Audio("assets/sounds/confirmation-sound.mp3");
		snd.play();

	}
	function alertSound() {
		var snd = new Audio("assets/sounds/alert-sound.mp3");
		snd.play();

	}



	function getProductStockAndDueDates(unitBarcode, flagInOut, orderId) {
		console.log(flagInOut);

		$.ajax({
			url: '../webservice/orders.php',
			type: 'GET',
			data: { unitBarcode: unitBarcode, flagInOut: flagInOut, orderId: orderId, action: 'getProductStockAndDueDate' },
			success: function (data) {
				toastr.options.positionClass = "toast-top-left";
				console.log('entramos al success');
				console.log("data:", data);
				let productsParsed = JSON.parse(data);
				if (!productsParsed) {
					location.reload();
					return;
				}
				console.log("data entero: ", productsParsed); // Inspect this in your console

				let name = "";
				let name2 = "";
				if (flagInOut == "out") {
					name = productsParsed[0].name;
					name2 = productsParsed[0].name2;
				} else {
					document.getElementById("addLote").onclick = function addLote() {
						console.log("entre a addlote, loteid:", productsParsed[0].id);
						$.ajax({
							url: '../webservice/orders.php',
							type: 'GET',
							data: { action: "addLote", loteId: productsParsed[0].id },
							success: function (data) {
								// toastr.success("Dato actualizado");
								data = JSON.parse(data);
								notification(data.type, data.message);
								if (data.type == "success") {
									getProductStockAndDueDates(unitBarcode, flagInOut, orderId)
								}
								//location.reload();
								toastr.options.positionClass = "toast-top-left";
								console.log(data); // Inspect this in your console
							},
							error: function (data) {
								toastr.options.positionClass = "toast-top-left";
								toastr.error("No se pudo actualizar");
								console.log(data); // Inspect this in your console
							}
						});
					}
					name = productsParsed[0].productName;
					name2 = productsParsed[0].productName2;
				}
				//console.log(name,name2);
				document.getElementById("productName2").innerHTML = name2;
				document.getElementById("productName1").innerHTML = name;
				document.getElementById("productUnitBarcode").innerHTML = "<?= $_SESSION['language']['Product ID'] ?>: " + productsParsed[0].unitBarcode;

				//Creo tr's
				let tableRows = "";
				let deleteButton = "";
				let showStock = "";
				let dueDate = "";
				let warehouse = "";
				let available = "";

				productsParsed.forEach((prod) => {
					console.log("aca va prod:" + prod);
					if (flagInOut == "in") {
						deleteButton =
							`<td class="text-center">
							<div><a onclick="removeProduct(${prod.id},'${unitBarcode}', '${flagInOut}', ${orderId})"><i class="fe fe-x"></i></a></div>
						</td>`;
						showStock = "";
						dueDate =
							`<td class="text-center">
							<input id="loteNewDueDate${prod.id}" onchange="changeLoteNewDueDate(${prod.id}, ${orderId}, '${flagInOut}')" type='date' ${prod.newDueDate != null && "value='" + prod.newDueDate + "'"} class='form-control' style='border: none; text-align: center;'>
						</td>`;
					} else {
						deleteButton = "";
						showStock =
							`<td class="text-center">
							<div><strong>${prod.stock}</strong></div>
						</td>`;
						available =
							`<td class="text-center">
							<div><strong>${prod.available == null ? prod.stock : prod.available}</strong></div>
						</td>`;
						dueDate =
							`<td class="text-center">
							<div>${prod.dueDate == '0000-00-00' ? '-' : prod.dueDate}</div>
						</td>`;
						warehouse =
							`<td class="text-center">
							<div>${prod.warehouseId}</div>
						</td>`;

					}
					tableRows +=
						`<tr>
					<td class='text-center'>
						<input id="loteQty${prod.id}" type='number' onchange="changeLoteQty(${prod.id}, ${orderId}, '${flagInOut}', '${prod.dueDate}',${prod.stock},${prod.productId}, ${prod.available}, ${prod.quantity})" class='form-control' style='border: none; text-align: center;' value="${prod.quantity}" min=${flagInOut == 'in' ? 1 : 0} max=${prod.available == null ? prod.stock : (prod.available + prod.quantity)} step=1 <?php if ($_GET["roleId"] == 2)
							echo "readonly"; ?>>
					</td>
					${dueDate}
					${available}
					${showStock}
					${warehouse}
					${deleteButton}
				</tr>`;
				})
				document.getElementById("modalProdTableBody").innerHTML = tableRows;
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo mostrar los productos en la tabla del modal");
				console.log(data); // Inspect this in your console
			}
		})
	}

	function getTableDetailsContent() {
		console.log("table details content???");
		let orderId = "<?= $_GET["id"] ?>";
		let target = "<?= $_GET["target"] ?>";
		$.ajax({
			url: '../webservice/orders.php',
			type: 'GET',
			data: {
				id: orderId,
				target: target,
				action: "nombreAction"
			},
			success: function (data) {
				//Aca va para cargar la tabla de nuevo
				console.log("data pre:", data);
				let productList = JSON.parse(data);
				console.log("data post:", productList);
				let tableContent = document.getElementById("orderDetailsTableBody");
				let tablerows = "";
				let readOnly = "readonly";
				productList.forEach((prod) => {
					console.log("Prod: ", prod);
					console.log("qty: ", prod.quantity);
					if (prod.unitBarcode == "Special") {
						readOnly = "";
					}
					tablerows += `
				<tr>
					<td>
						<div>${prod.unitBarcode}</div>
					</td>
					<td class="text-center">
						<div><img src="${prod.image}" class="d-inline-block align-top mr-3" alt=""></div>
					</td>
					<td class="text-center">
						<input ${readOnly} type='number' onchange="changeSpecialProdQuantity(${prod.orderId},${prod.id}, this.value)" class='form-control' style='border: none; text-align: center;' value=${prod.quantity} min=1 step=1>
					</td>
					<td>
						<div>${prod.quantity == 0 ? '<strike>' + prod.productName + '</strike>' : prod.productName}</div>
					</td>
					<td>
					<div>${prod.quantity == 0 ? '<strike>' + prod.productName2 + '</strike>' : prod.productName2}</div>
					</td>
					<td>
						<div style="text-align:center">
							${prod.unitBarcode == "Special" ? '-' : `<button type="button" id="modifyDates" onclick="openModalDates('${prod.unitBarcode}', '<?= $_GET['target']; ?>', '${prod.orderId}')" class="btn-success btn-sm"><i class="far fa-calendar"></i> </button>`}
						</div>
					</td>
					<td>
						<div>${prod.pack}</div>
					</td>
					<?php if ($_SESSION["user"]["roleId"] == 1) { ?>
						<td class="text-right">
							<div><a onclick="removeProductByBarcode('${prod.unitBarcode}',<?= $_GET["id"]; ?>,${prod.id})"><i class="fe fe-x"></i></a></div>
						</td>
					<?php } ?>				
				</tr>
				`
				})
				//console.log("lista:",tablerows);
				tableContent.innerHTML = tablerows;
				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});
	}

	function changeSpecialProdQuantity(orderId, productId, quantity) {
		console.log("cool: ", orderId, productId, quantity);
		$.ajax({
			url: '../webservice/updateInOut.php',
			type: 'GET',
			data: { orderId: orderId, productId: productId, quantity: quantity, action: "updateSpecialProdQuantity" },
			success: function (data) {
				console.log("data updateinout:", data);
				if (data["type"] == "success") {
					console.log(data.type, data.message);
					//notification(data.type,data.message);
				}
				if (data["type"] == "error") {
					console.log(data.type, data.message);
					//notification(data.type,data.message);
				}
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
			}
		})
	}

	function sendBarcodeToUpdate() {
		event.preventDefault();
		let target = document.getElementById("targetInput").value;
		let userId = document.getElementById("userIdInput").value;
		let businessId = document.getElementById("businessIdInput").value;
		let orderId = document.getElementById("orderIdInput").value;
		let action = document.getElementById("inputActionId").value;
		let unitbarcode = document.getElementById("unitBarcode").value;
		let dataInfo = {
			target: target,
			userId: userId,
			businessId: businessId,
			orderId: orderId,
			action: action,
			unitBarcode: unitbarcode
		}
		if (target == "out") {
			dataInfo.checkboxSpecialProduct = document.getElementById("checkboxSpecialProduct").checked;
		}
		document.getElementById("unitBarcode").value = "";

		console.log("info:", dataInfo);
		$.ajax({
			url: '../webservice/updateInOut.php',
			type: 'GET',
			data: dataInfo,
			success: function (data) {
				console.log("data updateinout:", data);
				//Aca va para cargar la tabla de nuevo
				data = JSON.parse(data);
				if (data["type"] == "success") {
					confirmationSound();
					notification(data.type, data.message);
					getTableDetailsContent();
				} if (data["type"] == "error") {
					alertSound();
					toastr.options.timeOut = 300000;
					toastr.error(data.message);

				} if (data["type"] == "newProduct") {
					window.location.href = data["route"]
					return;
				}


				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});

	}


	function updateNewQuantity(id, unitBarcode) {

		var quantity = document.getElementById("quantityId" + id).value;

		$.ajax({
			url: '../webservice/orders.php',
			type: 'GET',
			data: { id: id, unitBarcode: unitBarcode, quantity: quantity, action: "updateNewQuantitySimple" },
			success: function (data) {
				location.reload();
				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});

	}

	function updateNewPrice(cartId) {

		var price = document.getElementById("priceId" + cartId).value;

		$.ajax({
			url: '../webservice/orders.php',
			type: 'GET',
			data: { cartId: cartId, price: price, action: "updateNewPrice" },
			success: function (data) {
				location.reload();
				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});

	}

	function updateNewPrice(cartId) {

		var price = document.getElementById("priceId" + cartId).value;

		$.ajax({
			url: '../webservice/orders.php',
			type: 'GET',
			data: { cartId: cartId, price: price, action: "updateNewPrice" },
			success: function (data) {
				location.reload();
				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});

	}

	function removeProductByBarcode(unitBarcode, orderId, rowId) {
		//rowId solo para productos Special
		if (confirm("Desea eliminar el producto")) {

			$.ajax({
				url: '../webservice/orders.php',
				type: 'GET',
				data: { unitBarcode: unitBarcode, orderId: orderId, rowId: rowId, action: "removeProductByBarcode" },
				success: function (data) {
					toastr.options.positionClass = "toast-top-left";
					location.reload();
					console.log(data); // Inspect this in your console
				},
				error: function (data) {
					toastr.options.positionClass = "toast-top-left";
					toastr.error("No se puede remover el producto");
					console.log(data); // Inspect this in your console
				}
			});
		}
	}


	function removeProduct(orderDetailsId, unitBarcode, flagInOut, orderId) {

		if (confirm("Desea eliminar el producto")) {

			$.ajax({
				url: '../webservice/orders.php',
				type: 'GET',
				data: { orderDetailsId: orderDetailsId, action: "removeProduct" },
				success: function (data) {
					toastr.options.positionClass = "toast-top-left";
					//location.reload();			
					getProductStockAndDueDates(unitBarcode, flagInOut, orderId);
					console.log(data); // Inspect this in your console
				},
				error: function (data) {
					toastr.options.positionClass = "toast-top-left";
					toastr.error("No se puede remover el producto");
					console.log(data); // Inspect this in your console
				}
			});
		}
	}



	function updateAdditional(id, option) {

		if (option == 1) {
			var value = document.getElementById("chargePercent" + id).value;
		}

		if (option == 2) {
			var value = document.getElementById("charge" + id).value;
		}

		if (option == 3) {
			var value = document.getElementById("discountPercent" + id).value;
		}

		if (option == 4) {
			var value = document.getElementById("discount" + id).value;
		}

		if (value == '') {
			value = 0;
		}


		$.ajax({
			url: '../webservice/orders.php',
			type: 'GET',
			data: { id: id, value: value, option: option, action: "updateAdditional" },
			success: function (data) {
				//toastr.success("Cantidad actualizada");
				location.reload();
				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});

	}


	function update(table, id, variable, type) {

		var value = document.getElementById(variable).value;

		$.ajax({
			url: '../webservice/update.php',
			type: 'GET',
			data: { table: table, id: id, variable: variable, value: value, type: type, action: "update" },
			success: function (data) {
				toastr.success("Dato actualizado");
				//location.reload();
				toastr.options.positionClass = "toast-top-left";
				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});


		/*
		$('#loading').modal({
			backdrop: 'static',
			keyboard: false
		})
		*/


	}

	function updateDueDate(productId) {
		var dueDate = document.getElementById("dueDateId").value;
		console.log("ProdId: " + productId + " y dueDate: " + dueDate);
		$.ajax({
			url: '../webservice/update.php',
			type: 'GET',
			data: { action: "updateDueDate", dueDate: dueDate, productId: productId },
			success: function (data) {
				toastr.success("Dato actualizado");
				//location.reload();
				toastr.options.positionClass = "toast-top-left";
				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});


		/*
		$('#loading').modal({
			backdrop: 'static',
			keyboard: false
		})
		*/


	}

	function openModalDates(unitBarcode, flagInOut, orderId) {
		$("#modalDates").modal('show');
		getProductStockAndDueDates(unitBarcode, flagInOut, orderId);
	}

	function updateSingleProductQty(quantity, maxStock) {
		if (quantity > maxStock) {
			quantity = maxStock
		}

	}

	function changeLoteQty(loteId, orderId, flagInOut, dueDate, stock, productId, available, oldQty) {
		let loteQty = document.getElementById("loteQty" + loteId).value;
		// if(loteQty <= 0){
		//     toastr.error("La cantidad debe ser mayor a 0.");
		// 	return;
		// }
		if (flagInOut == "out" && available != null && loteQty > (available + oldQty)) {
			toastr.error("No hay stock suficiente.");
			return;
		}
		if (flagInOut == "out" && loteQty > stock) {
			toastr.error("No hay stock suficiente.");
			return;
		}
		console.log("nro: ", loteId);
		console.log("nro orden: ", orderId);
		console.log("flagInOut: ", flagInOut);
		console.log("dueDate: ", dueDate);
		console.log("productId: ", productId);
		dataInfo = { action: "updateLoteQty", loteQty: loteQty, loteId: loteId, orderId: orderId, flagInOut: flagInOut, dueDate: dueDate };
		// if(flagInOut == "in"){
		// 	dataInfo.loteId = productId;
		// }
		$.ajax({
			url: '../webservice/orders.php',
			type: 'GET',
			data: dataInfo,
			success: function (data) {
				toastr.success("Dato actualizado");
				//location.reload();
				toastr.options.positionClass = "toast-top-left";
				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});
	}

	function changeLoteNewDueDate(loteId, orderId, flagInOut) {
		let loteNewDueDate = document.getElementById("loteNewDueDate" + loteId).value
		// console.log("Entre a change due  date lote",loteId,orderId,flagInOut,loteNewDueDate);
		// console.log("fecha:",loteNewDueDate);
		if (loteNewDueDate == "") {
			return;
		}
		$.ajax({
			url: '../webservice/orders.php',
			type: 'GET',
			data: { action: "updateLoteNewDueDate", flagInOut: flagInOut, loteNewDueDate: loteNewDueDate, loteId: loteId, orderId: orderId },
			success: function (data) {
				toastr.success("Dato actualizado");
				//location.reload();
				toastr.options.positionClass = "toast-top-left";
				console.log(data); // Inspect this in your console
			},
			error: function (data) {
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se pudo actualizar");
				console.log(data); // Inspect this in your console
			}
		});
	}
	console.log("Roleid: <?= $_SESSION["user"]["roleId"]; ?>");
</script>