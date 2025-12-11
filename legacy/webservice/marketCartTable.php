						<div class="col-12">
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<div class="tags">
									
								  <span class="tag<?php if ($_GET['target']=="sale") echo " tag-success"; ?>">
									<a href="marketCart.php?tableStatus=view<?php echo "&target=sale"; if ($_GET['businessId']!="") echo "&businessId=".$_GET['businessId']; if ($_GET['customerId']!="") echo "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") echo "&supplierId=".$_GET['supplierId']; ?>&page=1" class="tag-addon"><?php echo "Ventas"; ?></a>
								  </span>
								  
								  <span class="tag<?php if ($_GET['target']=="purchase") echo " tag-success"; ?>">
									<a href="marketCart.php?tableStatus=view<?php echo "&target=purchase"; if ($_GET['businessId']!="") echo "&businessId=".$_GET['businessId']; if ($_GET['customerId']!="") echo "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") echo "&supplierId=".$_GET['supplierId']; ?>&page=1" class="tag-addon"><?php echo "Compras"; ?></a>
								  </span>
								  
	
							</div>
						</div>
						</div>
						</div>
						
						<div class="col-12">
						
						
						
						<?php
						
						if ($_GET['target']=="purchase")
							$sqlCompany = "SELECT DISTINCT product.businessId, company.businessName from cart inner join products on cart.productId=product.id inner joinbusinesson product.businessId=company.id where cart.userId=".$_SESSION['user']['id'].";";
						
						if ($_GET['target']=="sale")
							$sqlCompany = "SELECT DISTINCT product.businessId, company.businessName from cart inner join products on cart.productId=product.id inner joinbusinesson product.businessId=company.id where cart.businessId=".$_SESSION['user']['businessId']." and cart.customerId<>'';";
						
						
						$stmtCompany = mysqli_query( $conn, $sqlCompany); 
						$total = 0;
						
						if ( $stmtCompany ) {

						while( $rowCompany = mysqli_fetch_array( $stmtCompany, MYSQLI_ASSOC ))  
						{  
					
							if ($_GET['target']=="purchase")
								$sql = "SELECT product.sku, product.code, product.image, product.name, company.businessName, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, cart.quantity, cart.quantity, cart.productId, cart.market, cart.id FROM cart INNER JOIN products ON cart.productId=product.id INNER JOINbusinessON product.businessId=company.id WHERE cart.userId=".$_SESSION['user']['id']." AND cart.businessId=".$rowCompany['businessId']." ORDER BY product.name ASC;";  
							
							if ($_GET['target']=="sale")
								$sql = "SELECT product.sku, product.code, product.image, product.name, company.businessName, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, cart.quantity, cart.quantity, cart.productId, cart.market, cart.id FROM cart INNER JOIN products ON cart.productId=product.id INNER JOINbusinessON product.businessId=company.id WHERE cart.customerId<>'' AND cart.businessId=".$_SESSION['user']['businessId']." ORDER BY product.name ASC;";  
							
							$stmt = mysqli_query( $conn, $sql); 

							$totalCompany = 0;
							
							
						?>
						 
						

						
						 
						 
						 
						  
							<div id="<?php echo $rowCompany['businessName'];?>" class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<?php echo $rowCompany['businessName'];?>
								</h3>
							  <div class="card-options">
								<button type="button" id="cleanCompany" onclick="cleanCompany(<?php echo "'".$_SESSION['user']['id']."', '".$rowCompany['businessId']."', '".$rowCompany['businessName']."'"; ?>)" class="btn btn-danger btn-sm"><i class="fe fe-trash mr-2"></i> <?php echo $_SESSION['language']['Empty order'];?></button> &nbsp &nbsp &nbsp 
								<button type="button" id="sendCompany" onclick="sendCompany(<?php echo "'".$_SESSION['user']['id']."', '".$_SESSION['user']['businessId']."', '".$rowCompany['businessId']."', '".$rowCompany['businessName']."'"; ?>)" class="btn btn-success btn-sm"><i class="fe fe-shopping-cart mr-2"></i> <?php echo $_SESSION['language']['Send order'];?></button> 
							  </div>
							</div>

							  <?php if ($_GET['tableStatus']=='view') { ?>
							
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th style="width:10%;min-width:100px;font-weight:bold;"> <?php echo $_SESSION['language']['Code'];?></th>
									  <th style="width:5%;min-width:50px;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></th>  
									  <th class="text-center" style="width:10%;min-width:100px;font-weight:bold;"> <?php echo $_SESSION['language']['Quantity'];?></th>
									  <th style="width:30%;font-weight:bold;"> <?php echo $_SESSION['language']['Product Name'];?></th>
									  <th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Pack'];?> Pack</th>
									  <th class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Market'];?></th>
									  <th class="text-right" style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Currency'];?></th>		
									  <th class="text-right" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Unit Price'];?></th>	
									  <th class="text-right" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Price'];?></th>									  
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr id="<?php echo $row['id']; ?>">
									  <td>
										<div><?php echo $row['sku']; ?></div>
										<div class="small text-muted">
										  <?php echo $row['code']; ?>
										</div>
									  </td>
									  <td class="text-center">
										<div><img src="<?php echo $row['image'];?>" class="d-inline-block align-top mr-3" alt=""></div>
									  </td>
									  <td class="text-center">										
										<div><input onchange="updateQuantity('<?php echo $row['id'];?>')" id="quantityId<?php echo $row['id'];?>" type="number" class="form-control" style="border: none; text-align: center;" value=<?php echo $row['quantity'];?> min=1 step=1></div>
									  </td>

									  <td>
										
										<div><a onclick="window.location.href='marketProduct.php?tableStatus=view&market=<?php if ($row['market']==0) echo "retail"; if ($row['market']==1) echo "wholesale"; ?>&id=<?php echo $row['productId']; ?>'" style="cursor: pointer;"><?php echo $row['name']; ?></a></div>
										<div class="small text-muted">
										  <?php echo $row['businessName']; ?>
										</div>
									  </td>
									  <td class="text-center">
										<div><?php if ($row['market']==1) echo $row['packWholesale']; else echo '1.00'; ?></div>
									  </td>
									  <td class="text-center">
										<div><?php if ($row['market']==0) echo $_SESSION['language']['Retail']; if ($row['market']==1) echo $_SESSION['language']['Wholesale']; if ($row['market']==2) echo $_SESSION['language']['Private'];?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['currency']; ?></div>
									  </td>
									  <td class="text-right">
										<div>$ <?php if ($row['market']==0) echo number_format($row['priceRetail'],2,",","."); if ($row['market']==1) echo number_format($row['priceWholesale'],2,",","."); if ($row['market']==2) echo number_format($row['pricePrivate'],2,",",".");?></div>
									  </td>
									  <td class="text-right">
										<div>$ <?php if ($row['market']==0) echo number_format($row['priceRetail']*$row['quantity'],2,",","."); if ($row['market']==1) echo number_format($row['priceWholesale']*$row['quantity']*$row['packWholesale'],2,",","."); if ($row['market']==2) echo number_format($row['pricePrivate']*$row['quantity'],2,",",".");?></div>
									  </td>
									  <td class="text-center">

										  <a id="removeCart" onclick="removeCart(<?php echo "'".$row['id']."', '".$row['name']."', '".$rowCompany['businessId']."'"; ?>)" class="icon"><i class="fe fe-trash-2"></i></a>

									  </td>
									</tr>
									
									<?php 
									if ($row['market']==0)
										$totalCompany = $totalCompany + ($row['priceRetail']*$row['quantity']); 
									
									if ($row['market']==1)
										$totalCompany = $totalCompany + ($row['priceWholesale']*$row['quantity']*$row['packWholesale']); 
									
									if ($row['market']==2)
										$totalCompany = $totalCompany + ($row['pricePrivate']*$row['quantity']); 
									?>
									
									<?php }; ?>
									
									
								  </tbody>
								</table>
							  </div>
							  
							  
							  <div id=<?php echo $rowCompany['businessId']; ?> class="card-footer text-right">
							    
								<a><strong><?php echo $_SESSION['language']['total'];?> : $ <?php $total = $total + $totalCompany; echo number_format($totalCompany,2,",","."); ?> </strong></a>
								
							  </div>
							  
							  
									<?php }}; ?>
							</div>	
						
						
						
						
						<?php

								mysqli_free_result( $stmt);
								
							}
						}
						
						?>
						 
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
										<a><strong><?php echo $_SESSION['language']['total'];?> : $ <?php echo number_format($total,2,",","."); ?> </strong></a>
									</h3>
								
								
									<div class="card-options">
										<button type="button" id="cleanAll" onclick="cleanAll(<?php echo "'".$_SESSION['user']['id']."'"; ?>)" class="btn btn-danger btn-sm"<?php if ($total==0) echo " disabled"; ?>><i class="fe fe-trash mr-2"></i><?php echo $_SESSION['language']['Empty all'];?></button> &nbsp &nbsp &nbsp 
										<button type="button" id="sendAll" onclick="sendAll(<?php echo "'".$_SESSION['user']['id']."', '".$_SESSION['user']['businessId']."'"; ?>)" class="btn btn-success btn-sm"<?php if ($total==0) echo " disabled"; ?>><i class="fe fe-shopping-cart mr-2"></i><?php echo $_SESSION['language']['Send all '];?></button> 
							  
									</div>
								</div>
							</div>
						
						</div>
						
						
			
						
						
<script>	
function removeCart(cartId, productName, businessId){							

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {cartId:cartId, action:"remove"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			//toastr.success("Producto removido: "+productName);
			//document.getElementById("countCart").innerHTML = <?php $countCart-=1; echo $countCart;?>;
			document.getElementById(cartId).style.display = "none";
			document.getElementById(businessId).style.display = "none";
			
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

function cleanAll(userId){							

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {userId:userId, action:"cleanAll"},
        success: function(data) {
			//document.getElementById("countCart").innerHTML = <?php $countCart=0; echo $countCart;?>;
			location.reload();
			//toastr.success("Carrito vaciado");
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede vaciar el carrito");
		console.log(data); // Inspect this in your console
    }  
    });

}

function cleanCompany(userId, businessId, businessName){							

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {userId:userId, businessId:businessId, action:"cleanCompany"},
        success: function(data) {
			toastr.success("Carrito vaciado de "+businessName);
			document.getElementById(businessName).style.display = "none";
			
			location.reload();
			
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede vaciar el carrito");
		console.log(data); // Inspect this in your console
    }  
    });

}

function sendCompany(userId, userbusinessId, businessId, businessName){							

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {userId:userId, userbusinessId:userbusinessId, businessId:businessId, action:"sendCompany"},
        success: function(data) {
			//toastr.success("Solicitud enviado a "+businessName);
			document.getElementById(businessName).style.display = "none";
			
			location.reload();
			
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se enviar el pedido");
		console.log(data); // Inspect this in your console
    }  
    });

}

function sendAll(userId, userbusinessId){							

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {userId:userId, userbusinessId:userbusinessId, action:"sendAll"},
        success: function(data) {
			//toastr.success("Solicitudes enviado");
			location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se enviar el pedido");
		console.log(data); // Inspect this in your console
    }  
    });

}

function updateQuantity(cartId){							

var quantity = document.getElementById("quantityId"+cartId).value;

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {cartId:cartId, quantity:quantity, action:"updateQuantity"},
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
</script>																	
																