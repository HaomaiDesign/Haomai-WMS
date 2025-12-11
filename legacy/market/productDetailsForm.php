    
	<?php $_SESSION['form']['table']= 'product';  $_SESSION['form']['quantity'] = -1;?>
	<div class="row">
	<div class="col-sm-4 col-lg-4">
		<div class="card">
			<div class="card-status card-status-left bg-teal"></div>
			<div class="card-header">
				<h3 class="card-title" style="font-weight:bold;">
				<?php if ($_GET['formStatus']=='create') echo "<a href='productsList.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
				<?php if ($_GET['formStatus']=='create') echo "Add Features"; ?>
				</h3>
			</div>
			<div class="card-body">
				<form action="productFeatureUpdate.php?formStatus=create&tableStatus=view&id=<?php echo $_GET['id'];?>" method="post" enctype="multipart/form-data">
					
						<?php 
						
						$sql1 = "SELECT product.id, product.sku, product.code, product.name, product.category, product.brand, product.currency, product.price, product.image, product.description, productFeatures.productId, productFeatures.property, productFeatures.value FROM product INNER JOIN productFeatures ON product.id=productFeatures.productId WHERE product.id=".$_GET['id'].";";  
						$stmt1 = mysqli_query( $conn, $sql1);  
						if ( $stmt1 ) {
						$row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );  	
						}
						?>
						
						
                        <div class="mb-4 text-center">
                          <img src="<?php echo $row1['image']; ?>" alt="<?php echo $row1['image']; ?>" class="img-fluid">
                        </div>
                        <h4 class="card-title"><?php echo $row1['name']; ?></h4>
                        <div class="card-subtitle">
                          <?php echo $row1['brand']." - ".$row1['category']." - ".$row1['sku']; ?>
                        </div>
                        <div class="mt-5 d-flex align-items-center">
                          <div class="product-price">
                            <strong><?php if ($_SESSION['eShop']['marketDisplay']==0) echo $row1['currency']." ".number_format($row1['priceRetail'],2,",","."); if ($_SESSION['eShop']['marketDisplay']==1) echo $row1['currency']." ".number_format($row1['priceWholesale'],2,",",".");?></strong>
                          </div>
                        </div>
                      </div>
                    </div>
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
							<?php
							if ($_GET['formStatus']=='create')
							{	
							echo "<input type='hidden' name='productId' class='form-control' value=".$_GET['id'].">";
							$_SESSION['form']['data'][]='productId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
							}
							?>
							
							<div class="form-group">
							<label class="form-label">Feature</label>
							<select name="category" id="select-category" onchange="showHint(this.value,'property','newFeatureText')" class="form-control custom-select">
							<option selected disabled>Select an option</option>
							<option disabled>----------------</option>
							<?php 
							if ( $stmt1 ) {
							while( $row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC))  
							{
								echo "<option value='".$row1['value']."'>".$row1['value']."</option>";	
							}
							}
							?>
							<option value="addNewFeature">+ New Feature...</option>
							</select>
						  </div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label id="newFeatureText" class="form-label" style="display: none;">New Feature</label>
								<input id="property" name="property" type="hidden" class="form-control" placeholder="Search&hellip;" tabindex="1">
								<?php $_SESSION['form']['data'][]='property'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">Value</label>
								<input id="value" name="value" type="text" class="form-control" placeholder="Value" tabindex="1">
								<?php $_SESSION['form']['data'][]='value'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
							</div>
						</div>
						
						
					</div>
				
			</div>
			<div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"><?php if ($_GET['formStatus']=='create') echo "Add feature";?></button>
            </div>
			</form>
		</div>
	</div>
	
	
	<div class="col-sm-8 col-lg-8">
		<div class="card">
			<div class="card-status card-status-left bg-teal"></div>
			<?php include "productFeatureTable.php"; ?>
	
		</div>
	</div>
</div>

<script>
function showHint(str,id,idtxt) {
			
    if (str == "addNewFeature") { 
           document.getElementById(id).setAttribute("type", "text");
		   document.getElementById(id).setAttribute("value", "");
		   document.getElementById(idtxt).style.display = "inline";

    } else {
          document.getElementById(id).setAttribute("type", "hidden");
		  document.getElementById(id).setAttribute("value", str);
		  document.getElementById(idtxt).style.display = "none";
			
    }
}
</script>	  