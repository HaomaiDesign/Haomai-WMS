					<?php if ($_GET['tableStatus']=='view') { ?>

					<?php
					
					$pageUrl = "list.php?tableStatus=view";
					
					if ($_GET['target']=="customer") {
						
						$sqlPage = "SELECT COUNT(*) AS rowNum FROM customer";  
						
						if ($_GET['search']!="")
							$sqlPage.=" WHERE businessId=".$_SESSION['user']['businessId']." AND flagActive=1 AND ((customer.businessName LIKE '%".$_GET['search']."%') OR (customer.address LIKE '%".$_GET['search']."%') OR (customer.code LIKE '%".$_GET['search']."%') OR (customer.id LIKE '%".$_GET['search']."%') OR (customer.phone LIKE '%".$_GET['search']."%') OR (customer.taxId LIKE '%".$_GET['search']."%'))";
						else
							$sqlPage.=" WHERE businessId=".$_SESSION['user']['businessId']." AND flagActive=1";

					}

					if ($_GET['target']=="supplier") {
					
						$sqlPage = "SELECT COUNT(*) AS rowNum FROM srmSupplier INNER JOIN company ON srmSupplier.supplierId=company.id";  

						if ($_GET['search']!="")
							$sqlPage.=" WHERE srmSupplier.businessId=".$_SESSION['user']['businessId']." AND ((company.businessName LIKE '%".$_GET['search']."%') OR (company.address LIKE '%".$_GET['search']."%') OR (srmSupplier.companyCode LIKE '%".$_GET['search']."%') OR (company.id LIKE '%".$_GET['search']."%') OR (company.phone LIKE '%".$_GET['search']."%') OR (company.taxId LIKE '%".$_GET['search']."%'))";
						else
							$sqlPage.=" WHERE srmSupplier.businessId=".$_SESSION['user']['businessId'];

					}			
									
					$sqlPage.=";";
					
					$pageGet = "";
					
					if ($_GET['market']=="retail") {
						$pageGet.= "&market=retail";
					}
					
					if ($_GET['market']=="wholesale") {
						$pageGet.= "&market=wholesale";
					}
					
					if ($_GET['businessId']!="") {
						$pageGet.= "&businessId=".$_GET['businessId'];
					}
					
					if ($_GET['customerId']!="") {
						$pageGet.= "&customerId=".$_GET['customerId'];
					}
					
					if ($_GET['supplierId']!="") {
						$pageGet.= "&supplierId=".$_GET['supplierId'];
					}
					
					if ($_GET['target']!="") {
						$pageGet.= "&target=".$_GET['target'];
					}
					
					$pageUrl.= $pageGet;
					
					if ($_GET['search']!="") {
						$pageUrl.= "&search=".$_GET['search'];
					}
					
					$pageUrl.="&page=";
					
					$stmtPage= mysqli_query( $conn, $sqlPage); 
						
					if ( $stmtPage ) {
					$rowPage = mysqli_fetch_array( $stmtPage, MYSQLI_ASSOC  );  
					$totalItem = $rowPage['rowNum'];
					$limit = 100;
					
					$totalPage = intdiv($totalItem, $limit);
					
					if ($totalItem%$limit!=0) $totalPage = $totalPage + 1;
					
					if ($totalItem!=""){
						
					$min = $totalItem - $limit * $_GET['page'];
					$max = $totalItem - $limit * $_GET['page'] + $limit;	
						
					if ($min<0) $min = 0;
					
					} else {
					
						$min = 0;
						$max = 0;	
						
					}
					}
					
	

					?>

						<div class="col-12">
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
							<div class="tags">
							
								<?php if ($_GET['search']!="") { ?> 
								  <span class="tag">
									<?php echo $_GET['search']; ?> 
									<a href="list.php?tableStatus=view<?php echo $pageGet; ?>&page=1" class="tag-addon"><i class="fe fe-x"></i></a>
								  </span>
								<?php } ?>  
							</div>
							
							
							<div class="card-options">
									<div class="item-action">
										<form action="list.php" method="get">
											<input type="hidden" name="tableStatus" class="form-control" value="view">
											<?php echo "<input type='hidden' name='page' class='form-control' value='1'>";?>
											<?php if ($_GET['search']!="") echo "<input type='hidden' name='search' class='form-control' value='".$_GET['search']."'>";?>
											<?php if ($_GET['target']!="") echo "<input type='hidden' name='target' class='form-control' value='".$_GET['target']."'>";?>
											<?php if ($_GET['market']!="") echo "<input type='hidden' name='market' class='form-control' value='".$_GET['market']."'>";?>
											<?php if ($_GET['businessId']!="") echo "<input type='hidden' name='businessId' class='form-control' value='".$_GET['businessId']."'>";?>
											<?php if ($_GET['customerId']!="") echo "<input type='hidden' name='customerId' class='form-control' value='".$_GET['customerId']."'>";?>
											<?php if ($_GET['supplierId']!="") echo "<input type='hidden' name='supplierId' class='form-control' value='".$_GET['supplierId']."'>";?>
											
											<input id="search" name="search" value="<?php if ($_GET['search']!="") echo $_GET['search'];?>" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['Search'];?>&hellip;">
										</form>
									</div>
									<div class="item-action">
										<?php if ($_GET['tableStatus']=='view') { echo "<a href='list.php?formStatus=create&target=".$_GET['target']."' class='btn btn-icon btn-lg'><i class='fe fe-user-plus'></i></a>"; }?>
									</div>
								</div>
							</div>
						</div>	
				
							
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='new.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
								<?php if ($_GET['tableStatus']=='view') echo "Select Customer"; if ($_GET['formStatus']=='view') echo "Edit Customer"; if ($_GET['formStatus']=='create') echo "Create a new customer"; ?>
								</h3>
		
							 <div class="card-options">
								<div class="item-action">
									<?php echo $_SESSION['language']['Total']." ".$totalItem." ".$_SESSION['language']['products']; ?>&nbsp&nbsp&nbsp
								</div>
								
								<div class="item-action">
									<a href="<?php echo $pageUrl."1";?>"<?php if ($_GET['page']==1) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-double-left"></i></a>
									<a href="<?php echo $pageUrl.($_GET['page']-1);?>"<?php if ($_GET['page']==1) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-left"></i></a>
									<a style="color: black;"><?php echo $_SESSION['language']['Page']." ".$_GET['page']." / ".$totalPage; ?>&nbsp </a> 
									<a href="<?php echo $pageUrl.($_GET['page']+1);?>"<?php if ($_GET['page']==$totalPage) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-right"></i></a>
									<a href="<?php echo $pageUrl.$totalPage;?>"<?php if ($_GET['page']==$totalPage) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-double-right"></i></a>&nbsp
								</div>
								
								
							  </div>	
						  </div>
							 
							  <div class="table-responsive">
								<table class="table table-hover table-outline table-vcenter text-truncate card-table">
								  <thead>
									<tr>
									  <th style="width:5%;font-weight:bold;" class="text-center">#</i></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Tax ID'];?></th>
									  <th style="width:30%;font-weight:bold;"><?php echo $_SESSION['language']['Business Name'];?></th>
									  <th style="width:30%;font-weight:bold;"><?php echo $_SESSION['language']['Address'];?></th>
									  <th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Description'];?></th>									  
									  
									  <th style="width:5%;font-weight:bold;" class="text-center"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									if ($_GET['target']=="customer") {
										
									$sql = "SELECT * FROM (SELECT ROW_NUMBER() OVER (ORDER BY customer.id ASC) as row, id, code, taxId, businessName, address, location, phone, email FROM customer";
									
									if ($_GET['search']!="") 
										$sql.= " WHERE (businessId=".$_SESSION['user']['businessId']." AND flagActive=1 AND ((customer.businessName LIKE '%".$_GET['search']."%') OR (customer.address LIKE '%".$_GET['search']."%') OR (customer.code LIKE '%".$_GET['search']."%') OR (customer.id LIKE '%".$_GET['search']."%') OR (customer.phone LIKE '%".$_GET['search']."%') OR (customer.taxId LIKE '%".$_GET['search']."%')))";
									else
										$sql.= " WHERE businessId=".$_SESSION['user']['businessId']." AND flagActive=1";
									
									$table = "customer";
									
									}
									
									if ($_GET['target']=="supplier") {
										
									$sql = "SELECT * FROM (SELECT ROW_NUMBER() OVER (ORDER BY srmSupplier.id ASC) as row, company.id, srmSupplier.id AS supplierId, srmSupplier.companyCode, company.taxId, company.businessName, company.address, company.location, company.phone, company.email, company.flagCompanyActive, company.flagCompanyVerified FROM srmSupplier INNER JOIN company ON srmSupplier.supplierId=company.id";
									
									if ($_GET['search']!="") 
										$sql.= " WHERE (srmSupplier.businessId=".$_SESSION['user']['businessId']." AND ((company.businessName LIKE '%".$_GET['search']."%') OR (company.address LIKE '%".$_GET['search']."%') OR (srmSupplier.companyCode LIKE '%".$_GET['search']."%') OR (company.id LIKE '%".$_GET['search']."%') OR (company.phone LIKE '%".$_GET['search']."%') OR (company.taxId LIKE '%".$_GET['search']."%')))";
									else
										$sql.= " WHERE srmSupplier.businessId=".$_SESSION['user']['businessId'];
									
									$table = "srmSupplier";
									
									}
										
									$sql.=") AS newTable WHERE (row>".$min.") AND (row<=".$max.") ORDER BY row DESC;"; 
									 
									//$sql = "SELECT * FROM customer WHERE businessId=".$_SESSION['user']['businessId']." ORDER BY id DESC";  
									$stmt = mysqli_query( $conn, $sql);  
									
									echo $sql;
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC  ))  
									{  
									
									if ($_GET['target']=="supplier")
										$deleteId = $row['supplierId'];
									else
										$deleteId = $row['id'];
									?>
									
									<tr>
									  
									 <td>
										<div data-toggle="tooltip" data-placement="top" title="<?php echo $row['code'].$row['companyCode']; ?>"><?php echo $row['code']; ?><?php echo $row['companyCode']; ?></div>
									  </td>
									  <td>
										<div data-toggle="tooltip" data-placement="top" title="<?php echo $row['taxId']; ?>"><?php echo $row['taxId']; ?></div>
									  </td>
									 <td>
										<div data-toggle="tooltip" data-placement="top" title="<?php echo $row['businessName']; ?>">
											<?php 
											
											if (strlen($row['businessName'])>30)
												echo substr($row['businessName'],0,30)."..."; 
											else
												echo $row['businessName'];
											
											if ($row['flagCompanyActive']==1)
												echo "&nbsp&nbsp&nbsp&nbsp&nbsp<i class='dropdown-icon fe fe-check-circle' style='color: green;'></i>";
											
											if ($row['flagCompanyVerified']==1)
												echo "&nbsp<i class='dropdown-icon fe fe-award' style='color: green;'></i>";
											?>
										</div>
									  </td>
									  <td>
										<div data-toggle="tooltip" data-placement="top" title="<?php echo $row['address']; ?>">
											<?php 
											
											if (strlen($row['address'])>30)
												echo substr($row['address'],0,30)."..."; 
											else
												echo $row['address'];
											
											?>
										</div>
									  </td>
									  <td>
										<div data-toggle="tooltip" data-placement="top" title="<?php echo $row['description']; ?>"><?php echo $row['description']; ?></div>
									  </td>
									   
									  <td class="text-center">
										<div class="item-action dropdown">
										  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
										  <div class="dropdown-menu dropdown-menu-right">
										  
											<?php if ($row['flagCompanyActive']==0) { ?><a href="list.php?formStatus=view&page=<?php echo $_GET['page']; ?>&target=<?php echo $_GET['target'];  ?>&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> <?php echo $_SESSION['language']['Edit'];?> </a> <?php } ?>
											<a href="listUpdate.php?formStatus=delete&target=<?php echo $_GET['target']; ?>&table=<?php echo $table; ?>&id=<?php echo $deleteId; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-user-minus"></i> <?php echo $_SESSION['language']['Delete'];?></a>
										  </div>
										</div>
									  </td>
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							
									<?php }}; ?>
							
						