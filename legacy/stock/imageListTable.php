
				
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								
									<h3 class="card-title" style="font-weight:bold;">
										<?php if (isset($_GET['search'])) echo "<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?> 
										<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; ?>
									</h3>
									
									<div class="card-options">
										
										<?php
												
												$sql = "SELECT * FROM products GROUP BY unitBarcode ORDER BY id ASC;";
												$stmt = mysqli_query( $conn, $sql);  
													
												
										?>   
									
										
									
									</div>
									
							</div>


							  <div class="table-responsive">
								<table id="table" class="table table-sm table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>

									
									<tr>
										
										<th class="text-center" style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Unit Barcode'];?></th>
										<th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Image'];?></th>
										<th style="width:60%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>
										
									</tr>
									
								  </thead>
								  <tbody>
									
									
									<?php       

									$noImgQty = 0;
									$totalQty = 0;
									
									if ( $stmt ) {                                                        
										while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC )){                                                                                                          
											
											$totalQty = $totalQty + 1;
											
											if (!file_exists($row['image'])) {
									?>

												
												<tr>
												
													<td class="text-center">                                                                                      
														<div><?php echo $row['unitBarcode']; ?></div>                                                               
													</td> 
													<td>
												
														<div><?php echo $row['image']; ?></div>
													</td>
													<td>
												
														<div><?php echo $row['name']; ?></div>
													</td>
												
												</tr>

											<?php $noImgQty = $noImgQty + 1;
												};
											}; ?>
									<?php }; ?>
								  </tbody>
								  
							
								  
								</table>
								
								<?php       

									echo "Imagenes : ".$noImgQty." / ".$totalQty;
									
									?>
							  </div>
							  
									
							
							
							
								</div>
							</div>
						
	