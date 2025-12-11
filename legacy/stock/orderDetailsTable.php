						<?php
						
						if ($_GET['target']=="in") {
							
								$conditionId = $_GET['id'];
								$_SESSION['form']['table']= 'orders';
								$view = "business";
				
						
								
						}
						
						if ($_GET['target']=="out") {
							$conditionId = $_GET['id'];
							$_SESSION['form']['table']= 'orders';
							$view = "business";
						}
						
						
						if ($_GET['formStatus']=='view')
						{
							$_SESSION['form']['condition'] = "id=".$conditionId;
							include "../system/formQuery.php"; // Get data from DB	
						}
						
						$tempCustomer = 0;
						
						?>
						
						
						<?php if ($view=="personal") { ?>
						
						 <div class="col-12">
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<?php if ($_GET['tableStatus']=='view') echo "<a href='orderList.php?target=".$_GET['target']."&tableStatus=view&page=1' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
									<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Order details']; ?>
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
										<label class="form-label"><?php echo $_SESSION['language']['Full Name'];?></label>
										<input type="text" name="fullName" class="form-control" value="<?php if (isset($_SESSION['form']['server']['fullName'])) echo $_SESSION['form']['server']['fullName']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='fullName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-6 col-md-6">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Email'];?></label>
										<input type="text" name="email" class="form-control" value="<?php if (isset($_SESSION['form']['server']['email'])) echo $_SESSION['form']['server']['email']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='email'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-6 col-md-6">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Personal ID'];?></label>
										<input type="text" name="personalId" class="form-control" value="<?php if (isset($_SESSION['form']['server']['personalId'])) echo $_SESSION['form']['server']['personalId']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='personalId'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Personal Phone'];?></label>
										<input type="text" name="phone" class="form-control" value="<?php if (isset($_SESSION['form']['server']['phone'])) echo $_SESSION['form']['server']['phone']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='phone'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Personal Mobile'];?></label>
										<input type="text" name="mobile" class="form-control" value="<?php if (isset($_SESSION['form']['server']['mobile'])) echo $_SESSION['form']['server']['mobile']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='mobile'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div> 
									<div class="col-sm-9 col-md-9">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Address'];?></label>
										<input type="text" name="address" class="form-control" value="<?php if (isset($_SESSION['form']['server']['address'])) echo $_SESSION['form']['server']['address']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='address'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Postal Code'];?></label>
										<input type="text" name="postalCode" class="form-control" value="<?php if (isset($_SESSION['form']['server']['postalCode'])) echo $_SESSION['form']['server']['postalCode']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='postalCode'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Location'];?></label>
										<input type="text" name="location" class="form-control" value="<?php if (isset($_SESSION['form']['server']['location'])) echo $_SESSION['form']['server']['location']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='location'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Province / State'];?></label>
										<input type="text" name="province" class="form-control" value="<?php if (isset($_SESSION['form']['server']['province'])) echo $_SESSION['form']['server']['province']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='province'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Country'];?></label>
										<input type="text" name="country" class="form-control" value="<?php if (isset($_SESSION['form']['server']['country'])) echo $_SESSION['form']['server']['country']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='country'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
														
								  </div>            
								</div>
							</div>

							<?php } if ($view=="business") { ?>

							<div class="col-lg-12">
							  <form class="card" action="" autocomplete="off" method="post" enctype="multipart/form-data">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp
									<?php echo $_SESSION['language']['Order details']." N° ".str_pad($_GET['id'], 8, "0", STR_PAD_LEFT);?>
									</h3>
									<?php
										if ($_GET['target'] == 'out') {
									?>
										<a style="margin-left:5%; cursor:pointer;" onclick="clientInfoVisibility();"><i class="fe fe-eye fa-lg"></i></a>
									<?php
										}
									?>
									<!--
									<div class="card-options">
										<a onclick="window.print()" class='btn btn-icon btn-lg'><i class='fe fe-printer'></i></a>
									</div>
									-->
								</div>
								<?php if($_GET['target'] == 'out') {?>
								<div id="clientData" class="card-body" style="display:none;">
								  <div class="row">
									<div class="col-sm-8 col-md-8">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Business Name'];?></label>
										<input type="text" name="businessName" id="businessName" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','businessName','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['businessName'])) echo $_SESSION['form']['server']['businessName']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='businessName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Tax ID'];?></label>
										<input type="text" name="taxId" id="taxId" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','taxId','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['taxId'])) echo $_SESSION['form']['server']['taxId']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='taxId'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Phone'];?></label>
										<input type="text" name="phone" id="phone" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','phone','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['phone'])) echo $_SESSION['form']['server']['phone']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='phone'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<!-- <div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Whatsapp'];?></label>
										<input type="text" name="whatsapp" id="whatsapp" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','whatsapp','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['whatsapp'])) echo $_SESSION['form']['server']['whatsapp']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='whatsapp'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Wechat'];?></label>
										<input type="text" name="wechat" id="wechat" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','wechat','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['wechat'])) echo $_SESSION['form']['server']['wechat']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='wechat'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div> -->
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Email'];?></label>
										<input type="email" name="email" id="email" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','email','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['email'])) echo $_SESSION['form']['server']['email']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='email'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Address'];?></label>
										<input type="text" name="address" id="address" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','address','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['address'])) echo $_SESSION['form']['server']['address']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='address'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<!-- <div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Postal Code'];?></label>
										<input type="text" name="postalCode" id="postalCode" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','postalCode','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['postalCode'])) echo $_SESSION['form']['server']['postalCode']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='postalCode'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Location'];?></label>
										<input type="text" name="location" id="location" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','location','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['location'])) echo $_SESSION['form']['server']['location']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='location'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Province / State'];?></label>
										<input type="text" name="province" id="province" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','province','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['province'])) echo $_SESSION['form']['server']['province']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='province'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Country'];?></label>
										<select name="country" id="select-countries" class="form-control custom-select" readonly>
										  <option value="Argentina" data-data='{"image": "assets/images/flags/ar.svg"}' <?php if ($_SESSION['form']['server']['country']=='Argentina') echo 'selected'; ?>> Argentina</option>
										  <option value="Brazil" data-data='{"image": "assets/images/flags/br.svg"}' <?php if ($_SESSION['form']['server']['country']=='Brazil') echo 'selected'; ?>> Brazil</option>
										  <option value="Chile" data-data='{"image": "assets/images/flags/de.svg"}' <?php if ($_SESSION['form']['server']['country']=='Chile') echo 'selected'; ?>> Chile</option>
										  <option value="China" data-data='{"image": "assets/images/flags/cn.svg"}' <?php if ($_SESSION['form']['server']['country']=='China') echo 'selected'; ?>> China</option>
										</select>
										<?php $_SESSION['form']['data'][]='country'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div> -->
									<!-- <div class="col-sm-12 col-md-12">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Description'];?></label>
										<input type="text" name="description" id="description" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','description','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['description'])) echo $_SESSION['form']['server']['description']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='description'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div> -->
								  </div>
								</div>

								<div id="clientDataCollapsed" class="card-body">
									<h5><?php if (isset($_SESSION['form']['server']['businessName'])) echo $_SESSION['language']['Customer'] . " : " . $_SESSION['form']['server']['businessName']; ?></h5>
								</div>
								<?php } ?>
							  </form>  
							

							<?php } ?>
														

							<?php if ($_GET['tableStatus']=='view') { ?>
							<div class="card">
							<div class="card-status card-status-left bg-teal"></div>	
							
							  <div class="table-responsive">
								<table id="table" class="table table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Unit Barcode'];?></th>
									  <th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></th>
									  <th class="text-center" style="width:5%;min-width:100px;font-weight:bold;"> <?php echo $_SESSION['language']['Quantity'];?></th>	
									  <th style="width:35%;font-weight:bold;"> <?php echo $_SESSION['language']['Product Name'];?></th>
									  <th style="width:35%;font-weight:bold;"> <?php echo $_SESSION['language']['Product Name'];?></th>
									  <th style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Pack'];?></th>
									  
									  </tr>
								  </thead>
								  <tbody>
									
									<?php
									
									
									if ($_GET["target"] == "out"){
										// $sql = "SELECT orderDetails.*, products.dueDate AS productDueDate FROM orderDetails INNER JOIN products AS products ON orderDetails.unitBarcode = products.unitBarcode WHERE orderId=".$_GET['id']." GROUP BY products.unitBarcode ORDER BY id ASC;";
										// $sql = "SELECT SUM(quantity) as quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack  FROM orderDetails WHERE orderId=".$_GET["id"]." GROUP BY unitBarcode ORDER BY id ASC;";
										$sql = "";
										if($_SESSION["user"]["roleId"] == 1){
											$sql .= "(SELECT quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack  FROM orderDetails WHERE orderId=".$_GET["id"]." AND unitBarcode = 'Special' ORDER BY id ASC)
													UNION ";
										}
										$sql .= "SELECT SUM(quantity) as quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack  FROM orderDetails WHERE orderId=".$_GET["id"]." AND unitBarcode != 'Special' GROUP BY unitBarcode ORDER BY id ASC;";
									}
									if ($_GET["target"] == "in"){
										// $sql = "SELECT * FROM orderDetails WHERE orderId=".$_GET['id']." ORDER BY id ASC;";
										$sql = "SELECT SUM(quantity) as quantity, id, orderId, productId, productSku, productName, productName2, unitBarcode, image, pack FROM orderDetails WHERE orderId=".$_GET['id']." GROUP BY unitBarcode ORDER BY id ASC;";
									}
										//$sql = "SELECT b.id, b.unitBarcode, b.image, a.status, b.quantity, b.productName, b.pack, b.market, b.currency, b.price, b.oldPrice, b.oldQuantity FROM orders as a RIGHT JOIN orderDetails as b ON a.id=b.orderId WHERE b.orderId=".$_GET['id']." AND a.businessId=".$_GET['businessId']." ORDER BY b.productSku ASC;";  
									
									
									
									$stmt = mysqli_query( $conn, $sql);  
									$totalPrice = 0;
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  <td>
										<div><?php echo $row['unitBarcode']; ?></div>
									  </td>
									  <td class="text-center">
										<div><img src="<?php echo $row['image'];?>" class="d-inline-block align-top mr-3" alt=""></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['quantity']; ?></div>
									  </td>
									  <td>
										<div><?php if ($row['quantity']==0) echo "<strike>".$row['productName']."</strike>"; else echo $row['productName'];?></div>
									  </td>
									  <td>
										<div><?php if ($row['quantity']==0) echo "<strike>".$row['productName2']."</strike>"; else echo $row['productName2'];?></div>
									  </td>
									  <td>
										<div><?php echo $row['pack']; ?></div>
									  </td>
								
									  
									  
									</tr>
									<?php }; ?>
								  </tbody>
								
								</table>
							  </div>
							
							</div>
							
							
							
							<?php }}; ?>
							
							</div>	
<script>	

function clientInfoVisibility () {
	let allInfo = document.getElementById('clientData')
	let infoCollapsed = document.getElementById('clientDataCollapsed')
	currentInfoDisplay = allInfo.style.display

	allInfo.style.display = currentInfoDisplay == 'none' ? '' : 'none'
	infoCollapsed.style.display = currentInfoDisplay == 'none' ? 'none' : ''
}	


function updateNewQuantity(id){							

var quantity = document.getElementById("quantityId"+id).value;

    $.ajax({
        url: '../webservice/orders.php',
        type: 'GET',
        data: {id:id, quantity:quantity, action:"updateNewQuantitySimple"},
        success: function(data) {
			location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function updateNewPrice(cartId){							

var price = document.getElementById("priceId"+cartId).value;

    $.ajax({
        url: '../webservice/orders.php',
        type: 'GET',
        data: {cartId:cartId, price:price, action:"updateNewPrice"},
        success: function(data) {
			location.reload();			
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function updateNewPrice(cartId){							

var price = document.getElementById("priceId"+cartId).value;

    $.ajax({
        url: '../webservice/orders.php',
        type: 'GET',
        data: {cartId:cartId, price:price, action:"updateNewPrice"},
        success: function(data) {
			location.reload();			
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}	


function removeProduct(orderDetailsId){							

if (confirm("Desea eliminar el producto")) {

    $.ajax({
        url: '../webservice/orders.php',
        type: 'GET',
        data: {orderDetailsId:orderDetailsId, action:"removeProduct"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			location.reload();			
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede remover el producto");
		console.log(data); // Inspect this in your console
    }  
    });
}
}
		

function updateAdditional(id, option){							

if (option==1) {	
	var value = document.getElementById("chargePercent"+id).value;
}

if (option==2) {	
	var value = document.getElementById("charge"+id).value;
}

if (option==3) {	
	var value = document.getElementById("discountPercent"+id).value;
}

if (option==4) {	
	var value = document.getElementById("discount"+id).value;
}

if (value=='') {	
	value = 0;
}


    $.ajax({
        url: '../webservice/orders.php',
        type: 'GET',
        data: {id:id, value:value, option:option, action:"updateAdditional"},
        success: function(data) {
			//toastr.success("Cantidad actualizada");
			location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}


function update(table, id, variable, type){							

var value = document.getElementById(variable).value;

    $.ajax({
        url: '../webservice/update.php',
        type: 'GET',
        data: {table:table, id:id, variable:variable, value:value, type:type, action:"update"},
        success: function(data) {
			toastr.success("Dato actualizado");
			//location.reload();
			toastr.options.positionClass = "toast-top-left";
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
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

</script>						
																