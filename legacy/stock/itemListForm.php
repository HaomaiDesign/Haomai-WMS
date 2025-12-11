            <?php if (($_GET['formStatus']=='create')or($_GET['formStatus']=='view')) { 
			
			$_SESSION['form']['table']= 'products';

			if ($_GET['formStatus']=='view')
			{
				$_SESSION['form']['condition'] = "id=".$_GET['id'];
				include "../system/formQuery.php"; // Get data from DB
			}
			?>
			
			<?php $_SESSION['form']['quantity'] = -1;?>

		<div class="card">
			<div class="card-status card-status-left bg-teal"></div>
			<div class="card-header">
				<h3 class="card-title" style="font-weight:bold;">
				<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='javascript:history.back()' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
				<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit product']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
				</h3>
		
	    </div>
		
				<div class="card-body">
                  <form id="productForm" action="itemListUpdate.php<?php if ($_GET['formStatus']=='create') echo '?formStatus=create'; if ($_GET['formStatus']=='view') echo "?formStatus=edit&currentPage=".$_GET['currentPage']."&id=".$_GET['id'];?>" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
						 <div class="col-10">
							<div class="row">
								<div class="col-sm-3 col-md-3">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Pack Barcode'];?></label> <!-- Esto en realidad esta cargado en la columna de Unit Barcode -->
									  <input type="text" name="unitBarcode" class="form-control" value="<?php if (isset($_SESSION['form']['server']['unitBarcode'])){echo $_SESSION['form']['server']['unitBarcode'];} else if (isset($_GET["target"]) && isset($_GET["unitBarcode"]) && $_GET["target"] == "in") {echo $_GET["unitBarcode"];} ?>">
									  <?php $_SESSION['form']['data'][]='unitBarcode'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								
								<div class="col-sm-3 col-md-3">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Unit Barcode'];?></label> <!-- Esto en realidad esta cargado en la columna de Pack Barcode -->
									  <input type="text" name="packBarcode" class="form-control" value="<?php if (isset($_SESSION['form']['server']['packBarcode'])) echo $_SESSION['form']['server']['packBarcode']; ?>">
									  <?php $_SESSION['form']['data'][]='packBarcode'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								
								<div class="col-sm-3 col-md-3">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Product Code'];?></label>
									  <input type="text" name="code" class="form-control" value="<?php if (isset($_SESSION['form']['server']['code'])) echo $_SESSION['form']['server']['code']; ?>">
									  <?php $_SESSION['form']['data'][]='code'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								
								<div class="col-sm-3 col-md-3">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['SKU'];?></label>
									  <input type="text" name="sku" class="form-control" value="<?php if (isset($_SESSION['form']['server']['sku'])) echo $_SESSION['form']['server']['sku']; ?>" readonly>
									  <?php $_SESSION['form']['data'][]='sku'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								
								<div class="col-sm-10 col-md-10">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Product Name (Spanish)'];?><span class="form-required">*</span></label>
									  <input type="text" name="name" class="form-control" value="<?php if (isset($_SESSION['form']['server']['name'])) echo $_SESSION['form']['server']['name']; ?>" required>
									  <?php $_SESSION['form']['data'][]='name'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								
								<!-- <div class="col-sm-5 col-md-5">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Product Name (Chinese)'];?><span class="form-required">*</span></label>
									  <input type="text" name="name2" class="form-control" value="<?php if (isset($_SESSION['form']['server']['name2'])) echo $_SESSION['form']['server']['name2']; ?>">
									  <?php $_SESSION['form']['data'][]='name2'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div> -->
								
								
								<div class="col-sm-2 col-md-2">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Due Date'];?></label>
									  <input type="date" name="dueDate" class="form-control" value="<?php if (isset($_SESSION['form']['server']['dueDate'])) echo $_SESSION['form']['server']['dueDate']; else echo date("Y-m-d");?>">
									  <?php $_SESSION['form']['data'][]='dueDate'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								
								<!-- <div class="col-sm-6 col-md-6">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Brand'];?></label>
									  <input type="text" name="brand" class="form-control" value="<?php if (isset($_SESSION['form']['server']['brand'])) echo $_SESSION['form']['server']['brand']; ?>">
									  <?php $_SESSION['form']['data'][]='brand'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div> -->
								
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Category'];?></label>
									  <input type="text" name="category" class="form-control" value="<?php if (isset($_SESSION['form']['server']['category'])) echo $_SESSION['form']['server']['category']; ?>">
									  <?php $_SESSION['form']['data'][]='category'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								<div class="col-sm-3 col-md-3">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Stock alert'];?></label>
									  <input type="number" name="minStock" step=1 class="form-control" value="<?php if (isset($_SESSION['form']['server']['minStock'])) echo $_SESSION['form']['server']['minStock']; else echo '0'; ?>">
									  <?php $_SESSION['form']['data'][]='minStock'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								<div class="col-sm-3 col-md-3">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Capacity'];?></label>
									  <input type="number" name="capacity" step=0.01 class="form-control" value="<?php if (isset($_SESSION['form']['server']['capacity'])) echo $_SESSION['form']['server']['capacity']; else echo '0'; ?>">
									  <?php $_SESSION['form']['data'][]='capacity'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								<div class="col-sm-3 col-md-3">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Unit'];?></label>
									  <input type="text" name="unit" class="form-control" value="<?php if (isset($_SESSION['form']['server']['unit'])) echo $_SESSION['form']['server']['unit']; ?>">
									  <?php $_SESSION['form']['data'][]='unit'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								
								<div class="col-sm-3 col-md-3">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Pack'];?></label>
									  <input type="number" min=1 step=1 name="packWholesale" class="form-control" value=<?php if (isset($_SESSION['form']['server']['packWholesale'])) echo $_SESSION['form']['server']['packWholesale']; else echo '1'; ?> required>
									  <?php $_SESSION['form']['data'][]='packWholesale'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
									</div>
								</div>
								<?php
									if(isset($_GET["target"]) && isset($_GET["unitBarcode"]) && isset($_GET["orderId"])){
										echo "<input type='hidden' name='target' class='form-control' value=".$_GET["target"].">";
										echo "<input type='hidden' name='orderId' class='form-control' value=".$_GET["orderId"].">";
									}
								?>
								
								
								<?php
								if ($_GET['formStatus']=='create')
								{	
								echo "<input type='hidden' name='businessId' class='form-control' value=".$_SESSION['user']['businessId'].">";
								$_SESSION['form']['data'][]='businessId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
								}
								?>
								
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
									  <label class="form-label"><?php echo $_SESSION['language']['Description'];?></label>
									  <input type="text" name="description" class="form-control" value="<?php if (isset($_SESSION['form']['server']['description'])) echo $_SESSION['form']['server']['description']; ?>">
									 
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-2">
							<div class="row">
								<div class="col-sm-12 col-md-12">
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
								
								<div class="col-sm-12 col-md-12">
								  <div class="form-group">
									
										<img src="<?php if (isset($_SESSION['form']['server']['image'])) echo $_SESSION['form']['server']['image']; else echo "../assets/images/noimage.png"; ?>" width="100%" alt="Imagen del Producto">
										<?php $_SESSION['form']['data'][]='description'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
								  </div>
								</div>
							</div>
						</div>
						
					</div>
					</div>
			
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"><?php if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Update product']; ?></button>
                </div>
				</form>
			  
			<?php }; ?>
			
				</div>
			</div>
			
			<script>
			
				
				
				$('#productForm').on('keyup keypress', function(e) {
				  var keyCode = e.keyCode || e.which;
				  if (keyCode === 13) { 
					e.preventDefault();
					return false;
				  }
				});
				
			</script>