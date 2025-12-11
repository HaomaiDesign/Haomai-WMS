						<div class="col-12">
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<div class="tags">
								
								<?php if (($_SESSION['user']['roleId']==1)OR($_SESSION['user']['roleId']==4)OR($_SESSION['user']['roleId']==6)) { ?>								
								  <span class="tag<?php if ($_GET['target']=="sale") echo " tag-success"; ?>">
									<a href="marketCart.php?tableStatus=view<?php echo "&target=sale"; if ($_GET['companyId']!="") echo "&companyId=".$_GET['companyId']; if ($_GET['customerId']!="") echo "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") echo "&supplierId=".$_GET['supplierId']; ?>&page=1" class="tag-addon"><?php echo $_SESSION['language']['Sales'];?></a>
								  </span>
								<?php }; ?>
								
								<?php if (($_SESSION['user']['roleId']==1)OR($_SESSION['user']['roleId']==5)OR($_SESSION['user']['roleId']==6)) { ?>									
								  <span class="tag<?php if (($_GET['target']=="purchase")or($_GET['target']=="")) echo " tag-success"; ?>">
									<a href="marketCart.php?tableStatus=view<?php echo "&target=purchase"; if ($_GET['companyId']!="") echo "&companyId=".$_GET['companyId']; if ($_GET['customerId']!="") echo "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") echo "&supplierId=".$_GET['supplierId']; ?>&page=1" class="tag-addon"><?php echo $_SESSION['language']['Purchases'];?></a>
								  </span>
								<?php }; ?>
	
							</div>
						</div>
						</div>
						</div>
						
						<div class="col-12">
						
						
						
						<?php
						
						if (($_GET['target']=="purchase")or($_GET['target']==""))
							//$sqlCompany = "SELECT DISTINCT swrCart.companyId, company.businessName, company.address, swrCart.ownerId from swrCart inner join product on swrCart.productId=product.id inner join company on swrCart.companyId=company.id where swrCart.userId=".$_SESSION['user']['id'].";";
							$sqlCompany = "SELECT DISTINCT swrCart.supplierId, supplier.businessName, supplier.address, swrCart.ownerId from swrCart inner join product on swrCart.productId=product.id inner join supplier on swrCart.supplierId=supplier.id where swrCart.userId=".$_SESSION['user']['id'].";";
						
						if ($_GET['target']=="sale")
							//$sqlCompany = "SELECT DISTINCT swrCart.customerId, swrCart.tempId, swrCart.companyId, swrCart.businessName as tempBusinessName, swrCart.address as tempAddress, swrCart.location as tempLocation, swrCart.phone as tempPhone, swrCart.whatsapp as tempWhatsapp, swrCart.wechat as tempWechat, swrCart.taxId, swrCart.datetime, swrCart.description, customer.businessName, customer.address, swrCart.chargePercent, swrCart.charge, swrCart.discountPercent, swrCart.discount, swrCart.ownerId from swrCart LEFT JOIN customer on swrCart.customerId=customer.id  where (((swrCart.customerId<>'') or (swrCart.tempId<>'')) and swrCart.companyId=".$_SESSION['user']['companyId'].");";
							$sqlCompany = "SELECT DISTINCT  swrCart.userId, swrCart.customerId, swrCart.tempId, swrCart.companyId, swrCart.businessName as tempBusinessName, swrCart.address as tempAddress, swrCart.location as tempLocation, swrCart.phone as tempPhone, swrCart.whatsapp as tempWhatsapp, swrCart.wechat as tempWechat, swrCart.taxId, swrCart.datetime, swrCart.description, customer.businessName, customer.address, swrCart.chargePercent, swrCart.charge, swrCart.discountPercent, swrCart.discount, swrCart.ownerId from swrCart LEFT JOIN customer on swrCart.customerId=customer.id  where (((swrCart.customerId<>'') or (swrCart.tempId<>'')) and swrCart.companyId=".$_SESSION['user']['companyId'].");";
							
						
						$stmtCompany = mysqli_query( $conn, $sqlCompany); 
						$total = 0;
						
				
					
						
						if ( $stmtCompany ) {

						while( $rowCompany = mysqli_fetch_array( $stmtCompany, MYSQLI_ASSOC ))  
						{  
					
							if (($_GET['target']=="purchase")or($_GET['target']==""))
								$sql = "SELECT product.sku, product.code, product.image, product.name, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, swrCart.quantity, swrCart.quantity, swrCart.productId, swrCart.market, swrCart.id FROM swrCart INNER JOIN product ON swrCart.productId=product.id WHERE swrCart.userId=".$_SESSION['user']['id']." AND swrCart.supplierId=".$rowCompany['supplierId']." ORDER BY product.name ASC;";  
							
							if ($_GET['target']=="sale")
								if ($rowCompany['tempId']!="")
									$sql = "SELECT product.sku, product.code, product.image, product.name, company.businessName, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, swrCart.quantity, swrCart.quantity, swrCart.productId, swrCart.market, swrCart.tempId, swrCart.id FROM swrCart INNER JOIN product ON swrCart.productId=product.id INNER JOIN company ON product.companyId=company.id WHERE swrCart.tempId=".$rowCompany['tempId']." AND swrCart.companyId=".$_SESSION['user']['companyId']." ORDER BY product.name ASC;";  
								else
									if ($rowCompany['userId']!="")
										$sql = "SELECT product.sku, product.code, product.image, product.name, company.businessName, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, swrCart.quantity, swrCart.quantity, swrCart.productId, swrCart.market, swrCart.tempId, swrCart.id FROM swrCart INNER JOIN product ON swrCart.productId=product.id INNER JOIN company ON product.companyId=company.id WHERE swrCart.userId=".$rowCompany['userId']." AND swrCart.companyId=".$_SESSION['user']['companyId']." ORDER BY product.name ASC;";  
									else
										$sql = "SELECT product.sku, product.code, product.image, product.name, company.businessName, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate, swrCart.quantity, swrCart.quantity, swrCart.productId, swrCart.market, swrCart.tempId, swrCart.id FROM swrCart INNER JOIN product ON swrCart.productId=product.id INNER JOIN company ON product.companyId=company.id WHERE swrCart.customerId=".$rowCompany['customerId']." AND swrCart.companyId=".$_SESSION['user']['companyId']." ORDER BY product.name ASC;";  
									
							$stmt = mysqli_query( $conn, $sql); 

							$totalCompany = 0;
							
						
							
						?>
						 
						

						
						 
						 
						 
						  
							<div id="<?php echo $rowCompany['businessName'];?>" class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<?php echo $rowCompany['businessName'];?>
								<?php 
									if ($rowCompany['tempAddress']!="") {
										//echo $rowCompany['tempBusinessName'];
										echo "<a href='temp.php?tableStatus=view&page=1&tempId=".$rowCompany['tempId']."&businessName=".$rowCompany['tempBusinessName']."&address=".$rowCompany['tempAddress']."&location=".$rowCompany['tempLocation']."&phone=".$rowCompany['tempPhone']."&taxId=".$rowCompany['taxId']."&whatsapp=".$rowCompany['tempWhatsapp']."&wechat=".$rowCompany['tempWechat']."&description=".$rowCompany['description']."' class='btn btn-icon btn-lg'> <i class='fe fe-user-plus'></i></a>";
									}
									
								?>
								</h3>
							  <div class="card-options">
								<button type="button" id="cleanCompany" onclick="cleanCompany(<?php echo "'".$_SESSION['user']['id']."', '".$rowCompany['customerId']."', '".$rowCompany['companyId']."', '".$rowCompany['supplierId']."', '".$rowCompany['businessName']."'"; ?>)" class="btn btn-danger btn-sm"<?php if ($rowCompany['tempAddress']!="") echo " disabled";?>><i class="fe fe-trash mr-2"></i> <?php echo $_SESSION['language']['Empty order'];?></button> &nbsp &nbsp &nbsp 
								<button type="button" id="sendCompany" onclick="sendCompany(<?php echo "'".$_SESSION['user']['id']."', '".$_SESSION['user']['companyId']."', '".$rowCompany['customerId']."', '".$_SESSION['user']['companyId']."', '".$rowCompany['supplierId']."', '".$rowCompany['businessName']."', '".$_GET['target']."'"; ?>)" class="btn btn-success btn-sm"<?php if ($rowCompany['tempAddress']!="") echo " disabled";?>><i class="fe fe-shopping-cart mr-2"></i> <?php echo $_SESSION['language']['Send order'];?></button> 
							  </div>
							</div>
							
							<div class="card-header">
								
										<strong><?php echo $_SESSION['language']['Address'];?>: &nbsp </strong>
										<?php echo $rowCompany['address'];?>
									
									<div class="card-options">
										
										
											<?php
												if ($_GET['target']=="sale") {
											?>										
												<select id="ownerId<?php echo $rowCompany['customerId'];?>" name="ownerId<?php echo $rowCompany['customerId'];?>" onchange="updateOwner('<?php echo $rowCompany['customerId'];?>','')" style="width: 300px; padding: 5px; " class="form-control">
											<?php
												}
												
												if ($_GET['target']=="purchase") {
											?>
													<select id="ownerId<?php echo $rowCompany['supplierId'];?>" name="ownerId<?php echo $rowCompany['supplierId'];?>" onchange="updateOwner('<?php echo $rowCompany['supplierId'];?>','<?php echo $_SESSION['user']['id'];?>')" style="width: 300px; padding: 5px;" class="form-control">
											
											<?php	}	?>
										  
												<option value='' selected><?php echo $_SESSION['language']['Without Responsable'];?></option>
												
												<?php 

														$sqlUsers = "SELECT * FROM users WHERE companyId=".$_SESSION['user']['companyId'].";";  
														$stmtUsers = mysqli_query( $conn, $sqlUsers); 
																							

															if ( $stmtUsers ) {
																while( $rowUsers = mysqli_fetch_array( $stmtUsers, MYSQLI_ASSOC))  
																{  
																	if ($rowUsers['id']==$rowCompany['ownerId'])
																		echo "<option value='".$rowUsers['id']."' selected>".$rowUsers['fullName']."</option>"; 
																	else
																		echo "<option value='".$rowUsers['id']."'>".$rowUsers['fullName']."</option>"; 
																}
															}
												?>
												
											  </select>
													  
									
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
									  <th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Pack'];?></th>
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
										<!--
										<div class="small text-muted">
										  <?php echo $row['businessName']; ?>
										</div>
										-->
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
										<div>$ <?php if ($row['market']==0) echo number_format($row['priceRetail']*$row['quantity'],2,",","."); if ($row['market']==1) echo number_format($row['priceWholesale']*$row['quantity'],2,",","."); if ($row['market']==2) echo number_format($row['pricePrivate']*$row['quantity'],2,",",".");?></div>
									  </td>
									  <td class="text-center">
										
										  <a id="removeCart" onclick="removeCart(<?php echo "'".$row['id']."', '".$row['name']."'"; ?>)" class="icon"><i class="fe fe-trash-2"></i></a>
										
									  </td>
									</tr>
									
									<?php 
									
									if ($row['market']==0)
										$totalCompany = $totalCompany + ($row['priceRetail']*$row['quantity']); 
									
									if ($row['market']==1)
										$totalCompany = $totalCompany + ($row['priceWholesale']*$row['quantity']); 
									
									if ($row['market']==2)
										$totalCompany = $totalCompany + ($row['pricePrivate']*$row['quantity']); 
									?>
									
									<?php }; ?>
									
									
								  </tbody>
								</table>
							  </div>
							  
							  <?php 
							  
							  $discount = 0;
							  $charge = 0;
							  
							  if ($rowCompany['customerId']!="") { 
							  
							  ?>
							  
							  <div class="card-footer">
							    <div class="row">
									
										<div class="col">
											<a><strong><?php echo $_SESSION['language']['Charge'];?> (%) :</strong></a>
										</div>
										<div class="col-1">
											<input onchange="updateAdditional('<?php echo $rowCompany['customerId'];?>','1')" id="chargePercent<?php echo $rowCompany['customerId'];?>" type="number" class="form-control" style="text-align: right; padding: 1px;" value=<?php if ($rowCompany['chargePercent']!=0) echo $rowCompany['chargePercent'];?> min=0.01 max=100 step=0.01>
										</div>
									
										<div class="col">
											<a><strong><?php echo $_SESSION['language']['Charge'];?> ($) :</strong></a>
										</div>
										<div class="col-2">
											<input onchange="updateAdditional('<?php echo $rowCompany['customerId'];?>','2')" id="charge<?php echo $rowCompany['customerId'];?>" type="number" class="form-control" style="text-align: right; padding: 1px;" value=<?php if ($rowCompany['chargePercent']!=0) { $charge = $totalCompany * ($rowCompany['chargePercent']/100); echo $charge; } if ($rowCompany['charge']!=0) { echo $rowCompany['charge']; $charge = $rowCompany['charge']; }?> min=0.01 step=0.01>
										</div>
									
										<div class="col text-right">
											<a><strong><?php echo $_SESSION['language']['Discount'];?> (%) :</strong></a>
										</div>
										<div class="col-1">
											<input onchange="updateAdditional('<?php echo $rowCompany['customerId'];?>','3')" id="discountPercent<?php echo $rowCompany['customerId'];?>" type="number" class="form-control" style=" text-align: right; padding: 1px;" value=<?php if ($rowCompany['discountPercent']!=0) echo $rowCompany['discountPercent'];?> min=0.01 max=100 step=0.01>
										</div>
									
										<div class="col text-right">
											<a><strong><?php echo $_SESSION['language']['Discount'];?> ($) :</strong></a>
										</div>
										<div class="col-2">
											<input onchange="updateAdditional('<?php echo $rowCompany['customerId'];?>','4')" id="discount<?php echo $rowCompany['customerId'];?>" type="number" class="form-control" style=" text-align: right; padding: 1px;" value=<?php if ($rowCompany['discountPercent']!=0) { $discount = $totalCompany*($rowCompany['discountPercent']/100); echo $discount; } if ($rowCompany['discount']!=0) { echo $rowCompany['discount']; $discount = $rowCompany['discount']; }?> min=0.01 step=0.01>
										</div>
									
								</div>
							  </div>
							  
							  <?php } ?>
							   
							  <div id="<?php echo $rowCompany['companyId']; echo $rowCompany['customerId']; echo $rowCompany['supplierId'];?>" class="card-footer text-right">
									<a><strong><?php echo $_SESSION['language']['total'];?> : $ <?php $totalCompany = $totalCompany + $charge - $discount; $total = $total + $totalCompany; echo number_format($totalCompany,2,",","."); ?> </strong></a>
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
										<button type="button" id="cleanAll" onclick="cleanAll(<?php echo "'".$_SESSION['user']['id']."', '".$_SESSION['user']['companyId']."', '".$_GET['target']."'"; ?>)" class="btn btn-danger btn-sm" disabled><i class="fe fe-trash mr-2"></i><?php echo $_SESSION['language']['Empty all'];?></button> &nbsp &nbsp &nbsp 
										<button type="button" id="sendAll" onclick="sendAll(<?php echo "'".$_SESSION['user']['id']."', '".$_SESSION['user']['companyId']."', '".$_GET['target']."'"; ?>)" class="btn btn-success btn-sm" disabled><i class="fe fe-shopping-cart mr-2"></i><?php echo $_SESSION['language']['Send all '];?></button>
									<!--
									
									<button type="button" id="cleanAll" onclick="cleanAll(<?php echo "'".$_SESSION['user']['id']."', '".$_SESSION['user']['companyId']."', '".$_GET['target']."'"; ?>)" class="btn btn-danger btn-sm"<?php if ($total==0) echo " disabled"; ?>><i class="fe fe-trash mr-2"></i><?php echo $_SESSION['language']['Empty all'];?></button> &nbsp &nbsp &nbsp 
										<button type="button" id="sendAll" onclick="sendAll(<?php echo "'".$_SESSION['user']['id']."', '".$_SESSION['user']['companyId']."', '".$_GET['target']."'"; ?>)" class="btn btn-success btn-sm"<?php if ($total==0) echo " disabled"; ?>><i class="fe fe-shopping-cart mr-2"></i><?php echo $_SESSION['language']['Send all '];?></button>
										
									-->
									</div>
								</div>
							</div>
						
						</div>
						
						
			
						
						
<script>	
function removeCart(cartId, productName){							

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
			//document.getElementById(companyId).style.display = "none";
			
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

function cleanAll(userId, userCompanyId, target){							

if (confirm("Desea eliminar TODOS los pedido?")) {
document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {userId:userId, userCompanyId:userCompanyId, target:target, action:"cleanAll"},
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
}

function cleanCompany(userId, customerId, companyId, supplierId, businessName){							

if (confirm("Desea eliminar el pedido?")) {
	
document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {userId:userId, companyId:companyId, customerId:customerId, supplierId:supplierId, action:"cleanCompany"},
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
}

function sendCompany(userId, userCompanyId, customerId, companyId, supplierId, businessName, target){							

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {userId:userId, userCompanyId:userCompanyId, customerId:customerId, companyId:companyId, supplierId:supplierId, target:target, action:"sendCompany"},
        success: function(data) {
			//toastr.success("Solicitud enviado a "+businessName);
			document.getElementById(businessName).style.display = "none";
			
			location.reload();
			
			console.log(userId+"-"+userCompanyId+"-"+customerId+"-"+companyId+"-"+supplierId+"-"+businessName+"-"+target); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se enviar el pedido");
		console.log(data); // Inspect this in your console
    }  
    });

}

function sendAll(userId, userCompanyId, target){							

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {userId:userId, userCompanyId:userCompanyId, target:target, action:"sendAll"},
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

function updateAdditional(id, option){							

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

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
        url: '../webservice/cart.php',
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

function updateOwner(id, userId){							

document.getElementById("cleanAll").disabled = true;
document.getElementById("sendAll").disabled = true;
document.getElementById("cleanCompany").disabled = true;
document.getElementById("sendCompany").disabled = true;
document.getElementById("removeCart").disabled = true;

var value = document.getElementById("ownerId"+id).value;

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {id:id, value:value, userId:userId, action:"updateOwner"},
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
																