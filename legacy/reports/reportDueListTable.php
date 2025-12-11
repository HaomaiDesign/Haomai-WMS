<script>
	function updateFilterCat(category){							
		//var reportCat = document.getElementById("reportCat").value;
		$('#loading').modal({
		backdrop: 'static',
		keyboard: false
		})
		window.location.replace("reportDueList.php?reportCat="+category+"&tableStatus=view&page=1");
		
	}
</script>
					<?php if ($_GET['tableStatus']=='view') { ?>
					 <div class="col-12">
					<div class="card">
						<div class="card-status card-status-left bg-teal"></div>
						<div class="card-header">
							
							<?php 
							
								$today = date('Y-m-d');	

									if ($_GET['search']!="") 
										$quantityDays = $_GET['search'];
									else
										$quantityDays = 30;								
								
								echo "<a style='font-size: 15pt;'><strong> ".$_SESSION['language']['Date'].": </strong>".$today."</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ";
								
								echo "<a style='font-size: 15pt;'><strong> ".$_SESSION['language']['Due Date'].": </strong>".$quantityDays." ".$_SESSION['language']['Days']."</a>";
							
							?>
							
								<div class="card-options">
								<div class="item-action">								
															
									<form action="reportDueList.php" method="get" autocomplete="off" >
										<div class="row">
											<div style="width: 200px; margin-right: 20px;">
												<!-- <?php echo $_SESSION['language']['Quantity'];?> -->
												<div class="input-icon mb-3">

													<input id="search" name="search" type="search" class="form-control header-search" value="" placeholder="<?php echo "Cantidad de días"?>" autofocus>
													<input id="tableStatus" name="tableStatus" type="hidden" value="view">

													<span class="input-icon-addon">
													<i class="fe fe-search"></i>
													</span>
												</div>
											</div>

											<div style="width: 200px; margin-right: 20px;">
												<select id="reportCat" name="reportCat" onchange="updateFilterCat(this.value)" class="form-control">
												
													<option value='ALL' <?php if ($_GET["reportCat"] == "ALL") echo "selected" ?>  ><?=$_SESSION["language"]["All"];?></option>
													
													<?php 
														$sqlreportCat = "SELECT distinct category FROM products order by category;";  
														$stmtreportCat = mysqli_query($conn, $sqlreportCat); 
														
														if ( $stmtreportCat ) {
															while( $rowreportCat = mysqli_fetch_array( $stmtreportCat, MYSQLI_ASSOC))  
															{
																if ($rowreportCat['category']=="")
																	if ($_GET['reportCat']=="EMPTY")
																		echo "<option value='EMPTY' selected>(".$_SESSION["language"]["Without category"].")</option>"; 
																	else
																		echo "<option value='EMPTY'>(".$_SESSION["language"]["Without category"].")</option>"; 
																else
																	if ($_GET['reportCat']==$rowreportCat['category'])	
																		echo "<option value='".$rowreportCat['category']. "' selected>".$rowreportCat['category']."</option>"; 
																	else
																		echo "<option value='".$rowreportCat['category']."'>".$rowreportCat['category']." </option>";
															}
														}
													?>													
												</select>
											</div>
										</div>
									</form>
									
								</div>
							</div>
						</div>
					</div>
				
						<div class="card">
						<div class="card-status card-status-left bg-teal"></div>
						<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
									<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; ?>
									<!-- &nbsp &nbsp <a target="_blank" href="printRoute.php?search=<?php if ($_GET["search"]!="") echo $_GET["search"]; else echo "30";?>"><i class="dropdown-icon fe fe-printer"></i></a> -->
								</h3>

								<div class="item-action">
									<a target="_blank" style="margin-left:20px;" href="printRoute.php?search=<?php if ($_GET["search"] != "") echo $_GET["search"]; else echo "30"; echo "&".$GET["reportCat"]?>"><i class="dropdown-icon fe fe-printer"></i></a>
									<a target="_blank" style="margin-left:15px;" href="exportExcelDueList.php?search=<?php if($_GET["search"] != "") echo $_GET["search"]; else echo "30"; echo "&".$GET["reportCat"]?>"><i class="dropdown-icon fe fe-log-out"></i></a>
								</div>
						  
						</div>

							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  	<th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></th>									  
									 	<th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Days'];?></th>									  
									  	<th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></th>
									  	<th class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></th>
										<th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>
										<?php if ($_SESSION['user']['roleId'] != 2) {?>
											<th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>
										<?php } ?>

										<th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?></th>

										<?php if ($_SESSION['user']['roleId'] != 2) {?>
											<th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['SKU'];?></th>
											<th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Unit Barcode'];?></th>
											
											<th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Unit/Pack'];?></th>
											<th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Capacity']."/".$_SESSION['language']['Unit'];?></th>
										<?php } ?>
										
									</tr>
								  </thead>
								  <tbody>
																		
									<?php
										$catSql = "";
											
										if (($_GET['reportCat'] != "")AND($_GET['reportCat'] != "ALL")AND($_GET['reportCat'] != "EMPTY")) {
											$catSql .= "AND a.category = '".$_GET['reportCat']."'";
										}

										$sql = "SELECT a.dueDate, a.id, a.unitBarcode, a.category, a.sku, a.name, a.name2, a.image, a.packWholesale, a.capacity, a.unit,  a.flagActive, SUM(b.stock) AS stock
											FROM products AS a LEFT JOIN stockLogs AS b ON a.id=b.productId 
											WHERE a.flagActive=1 
											AND duedate  BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ".$quantityDays." DAY) ".$catSql."
											GROUP BY a.unitBarcode 
											HAVING stock > 0 
											ORDER BY dueDate ASC;";

										//echo $sql;
										
										$stmt = mysqli_query( $conn, $sql);  
										
										if ( $stmt ) {
										while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
										{  
									
									?>
									
									<tr id="tableRow<?php echo $row['id'];?>">
										<td class="text-center">
											<div>
												<div <?php if ($_SESSION['user']['roleId'] == 2) echo "style='font-size:15pt;font-weight:bold;'" ?> ><?php echo $row['dueDate']; ?></div>
											</div>
										</td>
										<td class="text-center">
											<div style="color: red;">
												<strong <?php if ($_SESSION['user']['roleId'] == 2) echo "style='font-size:15pt;'" ?> >
												<?php 
													$days = round((strtotime($row['dueDate'])-strtotime($today))/86400);
													echo $days;
												?>
												</strong>
											</div>
										</td>
										<td class="text-center">                                                                                      
											<strong><div><?php if ($row['stock']!="") echo $row['stock']; else echo "0";?></div>  </strong>                           
										</td>
										<td class="text-center">
											<div><img src="<?php echo $row['image'];?>" class="d-inline-block align-top mr-3" alt=""></div>
										</td>
										<td>
											<!-- <div><a onclick="window.location.href='itemList.php?tableStatus=view&search=<?php echo $row['unitBarcode']; ?>&page=1'" style="cursor: pointer;"><?php if (strlen($row['name'])>50) echo substr($row['name'],0,50)."..."; else echo $row['name']; ?></a></div> -->
											<?php if ($_SESSION['user']['roleId'] != 2) {?>
												<div><?php if (strlen($row['name'])>50) echo substr($row['name'],0,50)."..."; else echo $row['name']; ?></div>
											<?php } else {?>
												<div style="font-weight:bold"><?php echo $row['name']; ?></div>
											<?php }?>
										</td>
										<?php if ($_SESSION['user']['roleId'] != 2) {?>
											<td>
												<div><?php if (strlen($row['name2'])>50) echo substr($row['name2'],0,50)."..."; else echo $row['name2']; ?></div>
											</td>
										<?php } ?>
										<td>                                                                                                          
											<div><?php echo $row['category']; ?></div>                                                                  
										</td>
										<?php if ($_SESSION['user']['roleId'] != 2) {?>
											<td>                                                                                                         
												<div><?php echo $row['sku']; ?></div>                                                                       
											</td>   										
											<td>                                                                                                          
												<div><?php echo $row['unitBarcode']; ?></div>                                                               
											</td>                                                                                                         
											
											<td class="text-center">
												<div><?php echo $row['packWholesale']; ?></div>
											</td>
											<td class="text-center">
												<div><?php echo $row['capacity']." ".$row['unit']; ?></div>
											</td>
										<?php } ?>
										
									</tr>
									
									
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


															