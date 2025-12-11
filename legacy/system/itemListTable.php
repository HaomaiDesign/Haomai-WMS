				
					<?php if ($_GET['tableStatus']=='view') { ?>
					 <div class="col-12">
					
				
						<div class="card">
						
						<div class="card-header">
							<h3 class="card-title" style="font-weight:bold;">
							
							<!--  <?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; ?>-->
							
								Detalle del Item:					
						
							</h3>						  
						  
						</div>






							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								 
								  <tbody>
																		
									<?php
									
									if ($_GET['search2']!="") 										
										$sql = "SELECT a.dueDate,a.id, a.unitBarcode, a.sku, a.name, a.name2, a.category, a.subtitle, a.packWholesale, a.image, a.capacity, a.unit,  a.flagActive, SUM(b.stock) AS stock
												FROM products AS a LEFT JOIN stockLogs AS b ON a.id=b.productId 
												WHERE a.flagActive=1 
												AND a.unitBarcode = ".$_GET['search2']."
												ORDER BY dueDate DESC LIMIT 200;"; 
												
												
								
									
									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
								
									
									
									
								<div class="card-body">
								  <div class="row">
									

								<div class="col-sm-4 col-md-4">
									  <div class="form-group">
										<label class="form-label"><span>Code</span></label>
										<input type="text" name="taxId" id="taxId" class="form-control" value="<?php echo $row['unitBarcode']; ?>"<?php echo " readonly"; ?>>
														
									  </div>
									</div>	
									
									
								<div class="col-sm-3 col-md-3">
									   <div class="form-group">
										<label class="form-label"><span>Name</span></label>
										<input type="text" name="taxId" id="taxId" class="form-control" value="<?php echo $row['name']; ?>"<?php echo " readonly"; ?>>
														
									  </div>
									</div>									
									
									
									<div class="col-sm-3 col-md-3">
									   <div class="form-group">
										<label class="form-label"><span>Name (Chinese)</span></label>
										<input type="text" name="taxId" id="taxId" class="form-control" value="<?php echo $row['name2']; ?>"<?php echo " readonly"; ?>>
														
									  </div>
									</div>
									
									<div class="col-sm-3 col-md-3">
									   <div class="form-group">
										<label class="form-label"><span>Category</span></label>
										<input type="text" name="taxId" id="taxId" class="form-control" value="<?php echo $row['category']; ?>"<?php echo " readonly"; ?>>
														
									  </div>
									</div>
									
									<div class="col-sm-3 col-md-3">
									   <div class="form-group">
										<label class="form-label"><span>Subtitle</span></label>
										<input type="text" name="taxId" id="taxId" class="form-control" value="<?php echo $row['subtitle']; ?>"<?php echo " readonly"; ?>>
														
									  </div>
									</div>									
									
									
									<div class="col-sm-3 col-md-3">
									   <div class="form-group">
										<label class="form-label"><span>PackWholesale</span></label>
										<input type="text" name="taxId" id="taxId" class="form-control" value="<?php echo $row['packWholesale']; ?>"<?php echo " readonly"; ?>>
														
									  </div>
									  
									  
									 </div> 									 									 
									 
									
									 <div class="col-sm-3 col-md-3">
								  <div class="form-group">
									
										<label class="form-label"><span>Image</span></label>
										<img src="<?php if ($row['image'])  echo $row['image']; else echo "../assets/images/noimage.png"; ?>" width="100%" alt="Imagen del Producto"> 
										
										
								  </div>
								</div>
																 
									
									
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }; ?>
							
							<div id="loading"></div>
							
								</div>
							</div>
							
								<?php }; ?>
<script>	

</script>	


															