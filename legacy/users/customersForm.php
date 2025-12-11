            <?php if (($_GET['formStatus']=='create')or($_GET['formStatus']=='view')) { 
			
			$_SESSION['form']['table']= 'customers';  
			if ($_GET['formStatus']=='view')
			{
				$_SESSION['form']['condition'] = "id=".$_GET['id'];
				include "../system/formQuery.php"; // Get data from DB
			}
			?>
			
			<?php $_SESSION['form']['quantity'] = -1;?>

				
							  <form action="customersUpdate.php<?php if ($_GET['formStatus']=='create') echo '?formStatus=create'; if ($_GET['formStatus']=='view') echo '?formStatus=edit&id='.$_GET['id'];?>" autocomplete="off" method="post" enctype="multipart/form-data">
								
								<div class="card-body">
								  <div class="row">
									<div class="col-sm-8 col-md-8">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Business Name'];?><span class="form-required">*</span></label>
										<input type="text" name="businessName" id="businessName" class="form-control" value="<?php if (isset($_SESSION['form']['server']['businessName'])) echo $_SESSION['form']['server']['businessName']; ?>">
										<?php $_SESSION['form']['data'][]='businessName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Tax ID'];?><span class="form-required">*</span></label>
										<input type="text" name="taxId" id="taxId" class="form-control" value="<?php if (isset($_SESSION['form']['server']['taxId'])) echo $_SESSION['form']['server']['taxId']; ?>">
										<?php $_SESSION['form']['data'][]='taxId'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Phone'];?></label>
										<input type="text" name="phone" id="phone" onchange="update('<?php echo $_SESSION['form']['table'];?>','<?php echo $_SESSION['form']['server']['id'];?>','phone','1')" class="form-control" value="<?php if (isset($_SESSION['form']['server']['phone'])) echo $_SESSION['form']['server']['phone']; ?>">
										<?php $_SESSION['form']['data'][]='phone'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Whatsapp'];?></label>
										<input type="text" name="whatsapp" id="whatsapp" class="form-control" value="<?php if (isset($_SESSION['form']['server']['whatsapp'])) echo $_SESSION['form']['server']['whatsapp']; ?>">
										<?php $_SESSION['form']['data'][]='whatsapp'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Wechat'];?></label>
										<input type="text" name="wechat" id="wechat" class="form-control" value="<?php if (isset($_SESSION['form']['server']['wechat'])) echo $_SESSION['form']['server']['wechat']; ?>">
										<?php $_SESSION['form']['data'][]='wechat'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Email'];?></label>
										<input type="email" name="email" id="email" class="form-control" value="<?php if (isset($_SESSION['form']['server']['email'])) echo $_SESSION['form']['server']['email']; ?>">
										<?php $_SESSION['form']['data'][]='email'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
									  </div>
									</div>
									<div class="col-sm-9 col-md-9">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Address'];?></label>
										<input type="text" name="address" id="address" class="form-control" value="<?php if (isset($_SESSION['form']['server']['address'])) echo $_SESSION['form']['server']['address']; ?>">
										<?php $_SESSION['form']['data'][]='address'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-3 col-md-3">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Postal Code'];?></label>
										<input type="text" name="postalCode" id="postalCode" class="form-control" value="<?php if (isset($_SESSION['form']['server']['postalCode'])) echo $_SESSION['form']['server']['postalCode']; ?>">
										<?php $_SESSION['form']['data'][]='postalCode'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Location'];?></label>
										<input type="text" name="location" id="location" class="form-control" value="<?php if (isset($_SESSION['form']['server']['location'])) echo $_SESSION['form']['server']['location']; ?>">
										<?php $_SESSION['form']['data'][]='location'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Province / State'];?></label>
										<input type="text" name="province" id="province" class="form-control" value="<?php if (isset($_SESSION['form']['server']['province'])) echo $_SESSION['form']['server']['province']; ?>">
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
										</select>
										<?php $_SESSION['form']['data'][]='country'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
									<div class="col-sm-12 col-md-12">
									  <div class="form-group">
										<label class="form-label"><?php echo $_SESSION['language']['Description'];?></label>
										<input type="text" name="description" id="description"class="form-control" value="<?php if (isset($_SESSION['form']['server']['description'])) echo $_SESSION['form']['server']['description']; ?>">
										<?php $_SESSION['form']['data'][]='description'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									  </div>
									</div>
								  </div>
								</div>
								
								
								<?php
								if ($_GET['formStatus']=='create'){	
									echo "<input type='hidden' name='businessId' class='form-control' value=".$_SESSION['user']['businessId'].">";
									$_SESSION['form']['data'][]='businessId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
								}
								if(isset($_GET["orderId"]) && isset($_GET["target"])){
									echo "<input type='hidden' name='orderId' class='form-control' value=".$_GET["orderId"].">";
									echo "<input type='hidden' name='target' class='form-control' value=".$_GET["target"].">";
								}

								
								?>
				
				
				
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"><?php if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create profile']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Update profile']; ?></button>
                </div>
				</form>
			  
			<?php }; ?>