						<?php
						
						if ($_GET['target']=="company") {
							
							if ($_GET['customerId']!="")
							{
								$conditionId = $_GET['customerId'];
								$_SESSION['form']['table']= 'customer';
								$view = "business";
								$tempCustomer = 1;
							} else {
							
								$conditionId = $_GET['id'];
								$_SESSION['form']['table']= 'swrOrder';
								$view = "business";
								$tempCustomer = 1;
							}
								
						}
						
						if ($_GET['target']=="user") {
							$_SESSION['form']['table']= 'supplier';
							$conditionId = $_GET['supplierId'];
							$view = "business";
						}
						
						
						if ($_GET['formStatus']=='view')
						{
							$_SESSION['form']['condition'] = "id=".$conditionId;
							include "../system/formQuery.php"; // Get data from DB	
						}
						
				
						?>
						
						
						<?php if ($view=="personal") { ?>
						
						 <div class="col-12">
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<?php if ($_GET['tableStatus']=='view') echo "<a href='orderList.php?target=".$_GET['target']."&tableStatus=view&page=1' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
									<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Order details']; ?>
									<?php echo "N° ".str_pad($_GET['companyId'], 4, "0", STR_PAD_LEFT)."-".str_pad($_GET["requestId"], 6, "0", STR_PAD_LEFT); ?> 
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
							  <form class="card" action="" method="post" enctype="multipart/form-data">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<?php if ($_GET['tableStatus']=='view') echo "<a href='orderList.php?target=".$_GET['target']."&tableStatus=view&page=1' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
									<?php echo $_SESSION['language']['Order details'];?>
									<?php echo "N° ".str_pad($_GET['companyId'], 4, "0", STR_PAD_LEFT)."-".str_pad($_GET["requestId"], 6, "0", STR_PAD_LEFT); ?> 
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
										<label class="form-label"><?php echo $_SESSION['language']['Business Name'];?><span class="form-required">*</span></label>
										<input type="text" name="businessName" id="businessName" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','businessName','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['businessName'])) echo $_SESSION['form']['server']['businessName']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='businessName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-6 col-md-6">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Legal Name'];?><span class="form-required">*</span></label>
										<input type="text" name="legalName" id="legalName" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','legalName','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['legalName'])) echo $_SESSION['form']['server']['legalName']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='legalName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-2 col-md-2">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Tax ID'];?><span class="form-required">*</span></label>
										<input type="text" name="taxId" id="taxId" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','taxId','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['taxId'])) echo $_SESSION['form']['server']['taxId']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='taxId'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-2 col-md-2">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Phone'];?></label>
										<input type="text" name="phone" id="phone" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','phone','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['phone'])) echo $_SESSION['form']['server']['phone']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='phone'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-2 col-md-2">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Whatsapp'];?></label>
										<input type="text" name="whatsapp" id="whatsapp" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','whatsapp','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['whatsapp'])) echo $_SESSION['form']['server']['whatsapp']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='whatsapp'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-2 col-md-2">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Wechat'];?></label>
										<input type="text" name="wechat" id="wechat" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','wechat','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['wechat'])) echo $_SESSION['form']['server']['wechat']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='wechat'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Email'];?></label>
										<input type="email" name="email" id="email" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','email','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['email'])) echo $_SESSION['form']['server']['email']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='email'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-7 col-md-7">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Address'];?></label>
										<input type="text" name="address" id="address" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','address','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['address'])) echo $_SESSION['form']['server']['address']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='address'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-2 col-md-2">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Postal Code'];?></label>
										<input type="text" name="postalCode" id="postalCode" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','postalCode','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['postalCode'])) echo $_SESSION['form']['server']['postalCode']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='postalCode'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Transport company'];?></label>
										<input type="text" name="transport" id="transport" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','transport','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['transport'])) echo $_SESSION['form']['server']['transport']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='transport'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
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
									</div>
									<div class="col-sm-12 col-md-12">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Description'];?></label>
										<input type="text" name="description" id="description" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','description','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['description'])) echo $_SESSION['form']['server']['description']; ?>"<?php if ($tempCustomer==0) echo " readonly"; ?>>
										<?php $_SESSION['form']['data'][]='description'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
								  </div>
								</div>
								
							  </form>  
							

							<?php } ?>
														

							<?php if ($_GET['tableStatus']=='view') { ?>
							<div class="card">
							<div class="card-status card-status-left bg-teal"></div>	
							
							
							<div class="card-header">
								<strong>
								<?php echo "Pedido N° ".str_pad($_GET['companyId'], 4, "0", STR_PAD_LEFT)."-".str_pad($_GET["requestId"], 6, "0", STR_PAD_LEFT); ?>
								</strong>
							  <div class="card-options">
								<div class="item-action">
								  <button type="button" id="add" onclick="window.location.href='orderDetailsAdd.php?tableStatus=view&target=<?php echo $_GET['target']?>&companyId=<?php echo $_GET['companyId']?>&supplierId=<?php echo $_GET['supplierId']?>&userId=<?php echo $_GET['userId']?>&customerId=<?php echo $_GET['customerId']?>&roleId=<?php echo $_GET['roleId']?>&status=<?php echo $_GET['status']?>&requestId=<?php echo $_GET['requestId']?>&id=<?php echo $_GET['id']?>&market=wholesale&page=1'" class="btn btn-success btn-sm"><i class="fe fe-plus mr-2"></i> <?php echo $_SESSION['language']['Add product'];?> </button> 
								</div>
							  </div>
							</div>
							
							
							  <div class="table-responsive">
								<table id="table" class="table table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Product ID'];?></th>
									  <th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></th>
									  <th class="text-center" style="width:5%;min-width:100px;font-weight:bold;"> <?php echo $_SESSION['language']['Quantity'];?></th>	
									  <th class="text-center" style="width:5%;font-weight:bold;"> <i class="fe fe-settings"></i></th>
									  <th style="width:40%;font-weight:bold;"> <?php echo $_SESSION['language']['Product Name'];?></th>
									  <th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Pack'];?></th>
									  <!--<th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Market'];?></th>-->
									  <th class="text-left" style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Currency'];?></th>
									  <th class="text-center" style="width:15%;font-weight:bold;"> <?php echo $_SESSION['language']['Unit Price'];?></th>	
									  <th class="text-right" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Price'];?></th>	
									  	
									  </tr>
								  </thead>
								  <tbody>
									
									<?php
									
									if ($_GET['target']=="company") 
										$sql = "SELECT b.id, b.productSku, b.image, a.status, b.quantity, b.productName, b.pack, b.market, b.currency, b.price, b.oldPrice, b.oldQuantity FROM swrOrder as a RIGHT JOIN swrOrderDetails as b ON a.id=b.orderId WHERE b.orderId=".$_GET['id']." AND a.companyId=".$_GET['companyId']." ORDER BY b.productSku ASC;";  
									
									if ($_GET['target']=="user") 
										$sql = "SELECT b.id, b.productSku, b.image, a.status, b.quantity, b.productName, b.pack, b.market, b.currency, b.price, b.oldPrice, b.oldQuantity FROM swrOrder as a RIGHT JOIN swrOrderDetails as b ON a.id=b.orderId WHERE b.orderId=".$_GET['id']." AND a.supplierId=".$_GET['supplierId']." ORDER BY b.productSku ASC;";  
									
									
									
									$stmt = mysqli_query( $conn, $sql);  
									$totalPrice = 0;
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  <td>
										<div><?php echo $row['productSku']; ?></div>
									  </td>
									  <td class="text-center">
										<div><img src="<?php echo $row['image'];?>" class="d-inline-block align-top mr-3" alt=""></div>
									  </td>
									  <td class="text-center">
										<?php 
										if (($_GET['status']==0)OR($_GET['status']==1))
										{
											echo  "<input id='quantityId".$row['id']."' type='number' onchange='updateNewQuantity(\"".$row['id']."\")' class='form-control' style='border: none; text-align: center;' value=".$row['quantity']." min=0 step=1>";
											if ($row['oldQuantity']!="") echo "<small class='text-muted'>".$_SESSION['language']['Original'].": <strike>".$row['oldQuantity']."</strike></small>";
										}
										else
										{
												echo "<div>".$row['quantity']."</div>";
												if ($row['oldQuantity']!="") echo "<small class='text-muted'>".$_SESSION['language']['Original'].": <strike>".$row['oldQuantity']."</strike></small>";
										}
										?>
										
									  </td>
									  <td class="text-center">
										<div><a onclick="removeProduct(<?php echo "'".$row['id']."'"; ?>)"><i class="fe fe-x"></i></a></div>
									  </td>
									  <td>
										<div><?php if ($row['quantity']==0) echo "<strike>".$row['productName']."</strike>"; else echo $row['productName'];?></div>
									  </td>
									  <td>
										<div><?php echo $row['pack']; ?></div>
									  </td>
									  <!--<td>
										<div><?php if ($row['market']==0) echo $_SESSION['language']['Retail']; if ($row['market']==1) echo $_SESSION['language']['Wholesale']; if ($row['market']==2) echo $_SESSION['language']['Private'];?></div>
									  </td>-->
									  <td class="text-right">
										<div><?php echo $row['currency']; ?></div>
									  </td>
									  <td class="text-center">
										<?php 
										if ((($_GET['status']==0)OR($_GET['status']==1)))
										{
											echo  "<input id='priceId".$row['id']."' type='number' onchange='updateNewPrice(\"".$row['id']."\")' class='form-control' style='border: none; text-align: right;' value=".$row['price']." min=0 step=0.01>";
											if ($row['oldPrice']!="") echo "<small class='text-muted' class='text-left'>".$_SESSION['language']['Original'].": <strike>".$row['oldPrice']."</strike></small>";
										}
										else
										{
												echo "<div>".number_format($row['price'],2,",",".")."</div>";
												if ($row['oldPrice']!="") echo "<small class='text-muted' class='text-left'>Original: <strike>".$row['oldPrice']."</strike></small>";
										}	
										
										$itemPrice = $row['price']*$row['quantity'];
										?>
									  
									  </td>
									  <td class="text-right">
										<div><font color="green"><?php echo "$ ".number_format($itemPrice,2,",","."); $totalPrice+=$itemPrice;?></font></div>
									  </td>
									  
									  
									  
									</tr>
									<?php }; ?>
								  </tbody>
								
								</table>
							  </div>
							
							</div>
							
							
							<?php
							if ($_GET['target']=="company") {
							?>
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-body" style="padding-top: 10px; padding-bottom: 10px; ">
							    <div class="row">
									
									<?php
									
									$sqlOrder = "SELECT * FROM swrOrder WHERE id=".$_GET['id'].";";  
									$stmtOrder = mysqli_query( $conn, $sqlOrder);  
								
									
									if ( $stmtOrder ) {
									
										$rowOrder = mysqli_fetch_array( $stmtOrder, MYSQLI_ASSOC ); 
									  
									
									?>
									
									
										<div class="col">
											<a><strong><?php echo $_SESSION['language']['Charge'];?> (%) :</strong></a>
										</div>
										<div class="col-1">
											<input onchange="updateAdditional('<?php echo $rowOrder['id'];?>','1')" id="chargePercent<?php echo $rowOrder['id'];?>" type="number" class="form-control" style="border: none; text-align: right; padding: 1px;" value=<?php if ($rowOrder['chargePercent']!=0) echo $rowOrder['chargePercent'];?> min=0.01 max=100 step=0.01>
										</div>
									
										<div class="col">
											<a><strong><?php echo $_SESSION['language']['Charge'];?> ($) :</strong></a>
										</div>
										<div class="col-2">
											<input onchange="updateAdditional('<?php echo $rowOrder['id'];?>','2')" id="charge<?php echo $rowOrder['id'];?>" type="number" class="form-control" style="border: none; text-align: right; padding: 1px;" value=<?php if ($rowOrder['chargePercent']!=0) { $charge = $totalPrice * ($rowOrder['chargePercent']/100); echo $charge; } if ($rowOrder['charge']!=0) { echo $rowOrder['charge']; $charge = $rowOrder['charge']; }?> min=0.01 step=0.01>
										</div>
									
										<div class="col text-right">
											<a><strong><?php echo $_SESSION['language']['Discount'];?> (%) :</strong></a>
										</div>
										<div class="col-1">
											<input onchange="updateAdditional('<?php echo $rowOrder['id'];?>','3')" id="discountPercent<?php echo $rowOrder['id'];?>" type="number" class="form-control" style="border: none; text-align: right; padding: 1px;" value=<?php if ($rowOrder['discountPercent']!=0) echo $rowOrder['discountPercent'];?> min=0.01 max=100 step=0.01>
										</div>
									
										<div class="col text-right">
											<a><strong><?php echo $_SESSION['language']['Discount'];?> ($) :</strong></a>
										</div>
										<div class="col-2">
											<input onchange="updateAdditional('<?php echo $rowOrder['id'];?>','4')" id="discount<?php echo $rowOrder['id'];?>" type="number" class="form-control" style="border: none; text-align: right; padding: 1px;" value=<?php if ($rowOrder['discountPercent']!=0) { $discount = $totalPrice*($rowOrder['discountPercent']/100); echo $discount; } if ($rowOrder['discount']!=0) { echo $rowOrder['discount']; $discount = $rowOrder['discount']; }?> min=0.01 step=0.01>
										</div>
									<?php  }	?>
								</div>
							  </div>

							</div>
							
							<?php
								}
							?>
							
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
								<div><strong><?php echo $_SESSION['language']['Subtotal'];?> : <font color="green"><?php echo "$ ".number_format($totalPrice,2,",",".");?></font></strong></div>
								  <div class="card-options">
									<div><strong><?php echo $_SESSION['language']['total'];?> : <font color="green"><?php $totalPrice = $totalPrice + $charge - $discount; echo "$ ".number_format($totalPrice,2,",",".");?></font></strong></div>
								  </div>
								</div>

							</div>
							
							<?php }}; ?>
							
							</div>	
<script>							
function updateNewQuantity(cartId){							

var quantity = document.getElementById("quantityId"+cartId).value;

    $.ajax({
        url: '../webservice/orders.php',
        type: 'GET',
        data: {cartId:cartId, quantity:quantity, action:"updateNewQuantity"},
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
																