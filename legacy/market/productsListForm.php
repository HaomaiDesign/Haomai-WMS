



            <?php if (($_GET['formStatus']=='create')or($_GET['formStatus']=='view')) { 
			
			$_SESSION['form']['table']= 'product';
			if ($_GET['formStatus']=='create')
			{
				$folder = "../assets/images/company/".$_SESSION['eShop']['companyId'];
				if(!is_dir($folder))
					mkdir($folder, 0777, true);
			}
			if ($_GET['formStatus']=='view')
			{
				$_SESSION['form']['condition'] = "id=".$_GET['id'];
				include "../system/formQuery.php"; // Get data from DB
			}
			?>
			
				<div class="col-12">
					<div class="card">
						<div class="card-status card-status-left bg-teal"></div>
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;">
							<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
							<?php if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit product']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
							</h3>
						
						
						</div>
			
			
			<?php $_SESSION['form']['quantity'] = -1;?>

				<div class="card-body">
                  <form action="productsListUpdate.php<?php if ($_GET['formStatus']=='create') echo '?formStatus=create'; if ($_GET['formStatus']=='view') echo '?formStatus=edit&id='.$_GET['id']; if ($_GET['market']=="retail") echo "&market=retail"; if ($_GET['market']=="wholesale") echo "&market=wholesale"; if ($_GET['companyId']!="") echo "&companyId=".$_GET['companyId']; if ($_GET['customerId']!="") echo "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") echo "&supplierId=".$_GET['supplierId']; if ($_GET['target']!="") echo "&target=".$_GET['target'];?>" method="post" enctype="multipart/form-data">
                    <div class="row">
					<div class="col-sm-2 col-md-2">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Product Code'];?></label>
						  <input type="text" name="code" class="form-control" value="<?php if (isset($_SESSION['form']['server']['code'])) echo $_SESSION['form']['server']['code']; ?>">
						  <?php $_SESSION['form']['data'][]='code'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					
					<div class="col-sm-6 col-md-6">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Product Name'];?><span class="form-required">*</span></label>
						  <input type="text" name="name" class="form-control" value="<?php if (isset($_SESSION['form']['server']['name'])) echo $_SESSION['form']['server']['name']; ?>" autofocus required>
						  <?php $_SESSION['form']['data'][]='name'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					
					<div class="col-sm-4 col-md-4">
					  <div class="form-group">
                        <div class="form-label"><?php echo $_SESSION['language']['Product Image'];?></div>
                        <div class="custom-file">
                          <input type="file" id="image" class="custom-file-input" name="image" onchange="updateName()">
                          <label id="fileName" class="custom-file-label"><?php echo $_SESSION['language']['Choose file'];?></label>
						  <?php $_SESSION['form']['data'][]='image'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>
						  <script> function updateName(){
								var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
								document.getElementById("fileName").innerHTML  = filename;
							  } </script>
                        </div>
                      </div>
					</div>
					
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Category'];?></label>
						  <input type="text" name="category" class="form-control" list="category" value="<?php if (isset($_SESSION['form']['server']['category'])) echo $_SESSION['form']['server']['category']; ?>">
						  <datalist id="category">
							
							<option value=""></option>
							<?php 

								$sqlcategory = "SELECT DISTINCT category FROM product WHERE companyId=".$_SESSION['user']['companyId'].";";  
								$stmtcategory = mysqli_query( $conn, $sqlcategory); 
																	

									if ( $stmtcategory ) {
										while( $rowcategory = mysqli_fetch_array( $stmtcategory, MYSQLI_ASSOC))  
										{  
											echo "<option value='".$rowcategory['category']."'>".$rowcategory['category']."</option>"; 
										}  
									}
							 ?>
							
                          </datalist>
						  
						  <?php $_SESSION['form']['data'][]='category'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Subcategory'];?></label>
						  <input type="text" name="subcategory" class="form-control" list="subcategory" value="<?php if (isset($_SESSION['form']['server']['subcategory'])) echo $_SESSION['form']['server']['subcategory']; ?>">
						  <datalist id="subcategory">
							
							<?php 

								$sqlsubcategory = "SELECT DISTINCT subcategory FROM product WHERE companyId=".$_SESSION['user']['companyId'].";";  
								$stmtsubcategory = mysqli_query( $conn, $sqlsubcategory); 
																	

									if ( $stmtsubcategory ) {
										while( $rowsubcategory = mysqli_fetch_array( $stmtsubcategory, MYSQLI_ASSOC))  
										{  
											echo "<option value='".$rowsubcategory['subcategory']."'>".$rowsubcategory['subcategory']."</option>"; 
										}  
									}
							 ?>
							
                          </datalist>
						  <?php $_SESSION['form']['data'][]='subcategory'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Brand'];?></label>
						  <input type="text" name="brand" class="form-control" list="brand" value="<?php if (isset($_SESSION['form']['server']['brand'])) echo $_SESSION['form']['server']['brand']; ?>">
						  <datalist id="brand">
							
							<?php 

								$sqlbrand = "SELECT DISTINCT brand FROM product WHERE companyId=".$_SESSION['user']['companyId'].";";  
								$stmtbrand = mysqli_query( $conn, $sqlbrand); 
																	

									if ( $stmtbrand ) {
										while( $rowbrand = mysqli_fetch_array( $stmtbrand, MYSQLI_ASSOC))  
										{  
											echo "<option value='".$rowbrand['brand']."'>".$rowbrand['brand']."</option>"; 
										}  
									}
							 ?>
							
                          </datalist>
						  <?php $_SESSION['form']['data'][]='brand'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					
					<!--
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Group'];?></label>
						  <input type="text" name="groups" class="form-control" list="groups" value="<?php if (isset($_SESSION['form']['server']['groups'])) echo $_SESSION['form']['server']['groups']; ?>">
						  <datalist id="groups">
							
							<?php 

								$sqlgroups = "SELECT DISTINCT groups FROM product WHERE companyId=".$_SESSION['user']['companyId'].";";  
								$stmtgroups = mysqli_query( $conn, $sqlgroups); 
																	

									if ( $stmtgroups ) {
										while( $rowgroups = mysqli_fetch_array( $stmtgroups, MYSQLI_ASSOC))  
										{  
											echo "<option value='".$rowgroups['groups']."'>".$rowgroups['groups']."</option>"; 
										}  
									}
							 ?>
							
                          </datalist>
						  <?php $_SESSION['form']['data'][]='groups'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					-->
					
					<div class="col-sm-3 col-md-3">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Group'];?></label>				  
							<div style="padding-top:5px;">
                          <div class="form-check form-check-inline">
                            <input type="checkbox" name="flagGroup1" class="form-check-input" value="1" <?php if ($_SESSION['form']['server']['flagGroup1']==1) echo "checked"; ?>>
                            <label class="form-check-label"><?php if ($_SESSION['user']['companyGroup']=='tich') echo "上货架贩卖品"; else echo $_SESSION['language']['Group']." 1";?></label>
						  </div>
                          <div class="form-check form-check-inline">
                            <input type="checkbox" name="flagGroup2" class="form-check-input" value="1" <?php if ($_SESSION['form']['server']['flagGroup2']==1) echo "checked"; ?>>
                            <label class="form-check-label"><?php if ($_SESSION['user']['companyGroup']=='tich') echo "特价活动"; else echo $_SESSION['language']['Group']." 2";?></label>
						  </div>
						  <div class="form-check form-check-inline">
                            <input type="checkbox" name="flagGroup3" class="form-check-input" value="1" <?php if ($_SESSION['form']['server']['flagGroup3']==1) echo "checked"; ?>>
                            <label class="form-check-label"><?php if ($_SESSION['user']['companyGroup']=='tich') echo "新货上架"; else echo $_SESSION['language']['Group']." 3";?></label>
						  </div>
                        </div>
						  
						</div>
					</div>
					
					<div class="col-sm-1 col-md-1">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Pack'];?></label>
						  <input type="number" min=1 step=0.01 name="packWholesale" class="form-control" value=<?php if (isset($_SESSION['form']['server']['packWholesale'])) echo $_SESSION['form']['server']['packWholesale']; else echo '1'; ?> required>
						  <?php $_SESSION['form']['data'][]='packWholesale'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					<div class="col-sm-1 col-md-1">
						<div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Currency'];?></label>
                        <select name="currency" id="select-currency" class="form-control custom-select">
                          <option value="ARS" <?php if ($_SESSION['form']['server']['currency']=='ARS') echo 'selected'; ?>> ARS</option>
                          <option value="RMB" <?php if ($_SESSION['form']['server']['currency']=='RMB') echo 'selected'; ?>> RMB</option>
						  <option value="USD" <?php if ($_SESSION['form']['server']['currency']=='USD') echo 'selected'; ?>> USD</option>
                        </select>
						<?php $_SESSION['form']['data'][]='currency'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
					</div>
					<div class="col-sm-2 col-md-2">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Retail Price'];?></label>
						  <input type="number" min=0 step=0.01 name="priceRetail" class="form-control" value=<?php if (isset($_SESSION['form']['server']['priceRetail'])) echo $_SESSION['form']['server']['priceRetail']; else echo '0'; ?> required>
						  <?php $_SESSION['form']['data'][]='priceRetail'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					<div class="col-sm-2 col-md-2">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Wholesale Price'];?></label>
						  <input type="number" min=0 step=0.01 name="priceWholesale" class="form-control" value=<?php if (isset($_SESSION['form']['server']['priceWholesale'])) echo $_SESSION['form']['server']['priceWholesale']; else echo '0'; ?> required>
						  <?php $_SESSION['form']['data'][]='priceWholesale'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					<div class="col-sm-2 col-md-2">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Private Price'];?></label>
						  <input type="number" min=0 step=0.01 name="pricePrivate" class="form-control" value=<?php if (isset($_SESSION['form']['server']['pricePrivate'])) echo $_SESSION['form']['server']['pricePrivate']; else echo '0'; ?> required>
						  <?php $_SESSION['form']['data'][]='pricePrivate'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Short Description'];?></label>
						  <input type="text" name="subtitle" class="form-control" value="<?php if (isset($_SESSION['form']['server']['subtitle'])) echo $_SESSION['form']['server']['subtitle']; ?>">
						  <?php $_SESSION['form']['data'][]='subtitle'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					
					<?php
					if ($_GET['formStatus']=='create')
					{	
						
							echo "<input type='hidden' name='companyId' class='form-control' value=".$_SESSION['user']['companyId'].">";
							$_SESSION['form']['data'][]='companyId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
						
					}
					?>
					
					<div class="col-sm-12 col-md-12">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Description'];?></label>
						  <input type="text" name="description" class="form-control" value="<?php if (isset($_SESSION['form']['server']['description'])) echo $_SESSION['form']['server']['description']; ?>">
						  <?php $_SESSION['form']['data'][]='description'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					
					
						
                    </div>
				</div>

                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"><?php if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Update product']; ?></button>
                </div>
				</form>
			  				</div>
  </div>
			<?php }; ?>
			
