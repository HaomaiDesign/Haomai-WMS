<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/contentStart.php"; ?>

						<?php
						if ($_GET['roleId']!=0) $_SESSION['form']['table']= 'company'; else $_SESSION['form']['table']= 'users';  
						if ($_GET['formStatus']=='view')
						{
							$_SESSION['form']['condition'] = "id=".$_GET['userId'];
							include "../system/formQuery.php"; // Get data from DB	
						}
						?>
						
						<div class="container" style="border: 3px solid gray; border-radius: 8px;">
						
						<?php if ($_GET['roleId']==0) { ?>
						
						 <div class="col-12">
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<?php if ($_GET['tableStatus']=='view') echo "<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
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

							<?php } if ($_GET['roleId']!=0) { ?>

							<div class="col-lg-12">
							  <form class="card" action="profileUpdate.php<?php if ($_GET['formStatus']=='create') echo '?formStatus=create'; if ($_GET['formStatus']=='view') echo '?formStatus=edit&id='.$_SESSION['user']['companyId'];?>" method="post" enctype="multipart/form-data">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<?php if ($_GET['tableStatus']=='view') echo "<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
									<?php echo $_SESSION['language']['Order details'];?> 
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
										<input type="text" name="businessName" class="form-control" value="<?php if (isset($_SESSION['form']['server']['businessName'])) echo $_SESSION['form']['server']['businessName']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='businessName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-6 col-md-6">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Legal Name'];?><span class="form-required">*</span></label>
										<input type="text" name="legalName" class="form-control" value="<?php if (isset($_SESSION['form']['server']['legalName'])) echo $_SESSION['form']['server']['legalName']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='legalName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-2 col-md-2">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Tax ID'];?><span class="form-required">*</span></label>
										<input type="text" name="taxId" class="form-control" value="<?php if (isset($_SESSION['form']['server']['taxId'])) echo $_SESSION['form']['server']['taxId']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='taxId'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-2 col-md-2">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Phone'];?></label>
										<input type="text" name="phone" class="form-control" value="<?php if (isset($_SESSION['form']['server']['phone'])) echo $_SESSION['form']['server']['phone']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='phone'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Web Page'];?></label>
										<input type="text" name="webPage" class="form-control" value="<?php if (isset($_SESSION['form']['server']['webPage'])) echo $_SESSION['form']['server']['webPage']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='webPage'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Email'];?></label>
										<input type="email" name="email" class="form-control" value="<?php if (isset($_SESSION['form']['server']['email'])) echo $_SESSION['form']['server']['email']; ?>" readonly>
										<?php $_SESSION['form']['data'][]='email'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
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
										<select name="country" id="select-countries" class="form-control custom-select" readonly>
										  <option value="Argentina" data-data='{"image": "assets/images/flags/ar.svg"}' <?php if ($_SESSION['form']['server']['country']=='Argentina') echo 'selected'; ?>> Argentina</option>
										  <option value="Brazil" data-data='{"image": "assets/images/flags/br.svg"}' <?php if ($_SESSION['form']['server']['country']=='Brazil') echo 'selected'; ?>> Brazil</option>
										  <option value="Chile" data-data='{"image": "assets/images/flags/de.svg"}' <?php if ($_SESSION['form']['server']['country']=='Chile') echo 'selected'; ?>> Chile</option>
										  <option value="China" data-data='{"image": "assets/images/flags/cn.svg"}' <?php if ($_SESSION['form']['server']['country']=='China') echo 'selected'; ?>> China</option>
										</select>
										<?php $_SESSION['form']['data'][]='country'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
								  </div>
								</div>
								
							  </form>  
							

							<?php } ?>
							
							<div style="border: 2px solid gray;"></div>							

							<?php if ($_GET['tableStatus']=='view') { ?>
							
							<div class="card">
							<div class="card-status card-status-left bg-teal"></div>	
							  <div class="table-responsive">
								<table id="table" class="table table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Product ID'];?></th>
									  <th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></th>
									  <th class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Quantity'];?></th>	
									  <th style="width:35%;font-weight:bold;"> <?php echo $_SESSION['language']['Product Name'];?></th>
									  <th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Market'];?></th>
									  <th class="text-left" style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Currency'];?></th>
									  <th class="text-center" style="width:15%;font-weight:bold;"> <?php echo $_SESSION['language']['Unit Price'];?></th>	
									  <th class="text-right" style="width:15%;font-weight:bold;"> <?php echo $_SESSION['language']['Price'];?></th>	
									  </tr>
								  </thead>
								  <tbody>
									
									<?php
									
									$sql = "SELECT * FROM swrOrder as a RIGHT JOIN swrOrderDetails as b ON a.id=b.orderId WHERE orderId=".$_GET['id']." AND companyId=".$_SESSION['user']['companyId']." ORDER BY productSku ASC;";  
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
									  <td>
										<div><?php if ($row['quantity']==0) echo "<strike>".$row['productName']."</strike>"; else echo $row['productName'];?></div>
									  </td>
									  <td>
										<div><?php if ($row['market']==0) echo $_SESSION['language']['Retail']; if ($row['market']==1) echo $_SESSION['language']['Wholesale'];?></div>
									  </td>
									  <td class="text-right">
										<div><?php echo $row['currency']; ?></div>
									  </td>
									  <td class="text-center">
										<?php 
										if (($_GET['status']==0)OR($_GET['status']==1))
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
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
								  <div class="card-options">
									<div><strong><?php echo $_SESSION['language']['total'];?> : <font color="green"><?php echo "$ ".number_format($totalPrice,2,",",".");?></font></strong></div>
								  </div>
								</div>

							</div>
							
							<?php }}; ?>
							
							</div>	
							</div>	
							
	
<?php include "../system/contentEnd.php"; ?>							
													