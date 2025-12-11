					<?php if ($_GET['tableStatus']=='view') { ?>

					<?php
					
					$pageUrl = "list.php?tableStatus=view";
					
					if ($_GET['target']=="sale") {
						
						$sqlPage = "SELECT COUNT(*) AS rowNum FROM customer";  
						
						if ($_GET['search']!="")
							$sqlPage.=" WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1 AND ((customer.businessName LIKE '%".$_GET['search']."%') OR (customer.address LIKE '%".$_GET['search']."%') OR (customer.code LIKE '%".$_GET['search']."%') OR (customer.id LIKE '%".$_GET['search']."%') OR (customer.phone LIKE '%".$_GET['search']."%') OR (customer.taxId LIKE '%".$_GET['search']."%'))";
						else
							$sqlPage.=" WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1";

					}

					if ($_GET['target']=="purchase") {
					
						$sqlPage = "SELECT COUNT(*) AS rowNum FROM supplier";  

						if ($_GET['search']!="")
							$sqlPage.=" WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1 AND ((businessName LIKE '%".$_GET['search']."%') OR (address LIKE '%".$_GET['search']."%') OR (companyCode LIKE '%".$_GET['search']."%') OR (id LIKE '%".$_GET['search']."%') OR (phone LIKE '%".$_GET['search']."%') OR (taxId LIKE '%".$_GET['search']."%'))";
						else
							$sqlPage.=" WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1";

					}					
					$sqlPage.=";";
										
					$pageGet = "";
					
					if ($_GET['market']=="retail") {
						$pageGet.= "&market=retail";
					}
					
					if ($_GET['market']=="wholesale") {
						$pageGet.= "&market=wholesale";
					}
					
					if ($_GET['companyId']!="") {
						$pageGet.= "&companyId=".$_GET['companyId'];
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
					$rowPage = mysqli_fetch_array( $stmtPage, MYSQLI_ASSOC );  
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
									<a href="new.php?tableStatus=view&page=1" class="tag-addon"><i class="fe fe-x"></i></a>
								  </span>
								<?php } ?>  
							</div>
							
							
							<div class="card-options">
									<div class="item-action">
										<form action="new.php" method="get">
											<input type="hidden" name="tableStatus" class="form-control" value="view">
											<?php echo "<input type='hidden' name='page' class='form-control' value='1'>";?>
											<?php if ($_GET['search']!="") echo "<input type='hidden' name='search' class='form-control' value='".$_GET['search']."'>";?>
											<?php if ($_GET['target']!="") echo "<input type='hidden' name='target' class='form-control' value='".$_GET['target']."'>";?>
											<?php if ($_GET['market']!="") echo "<input type='hidden' name='market' class='form-control' value='".$_GET['market']."'>";?>
											<?php if ($_GET['companyId']!="") echo "<input type='hidden' name='companyId' class='form-control' value='".$_GET['companyId']."'>";?>
											<?php if ($_GET['customerId']!="") echo "<input type='hidden' name='customerId' class='form-control' value='".$_GET['customerId']."'>";?>
											<?php if ($_GET['supplierId']!="") echo "<input type='hidden' name='supplierId' class='form-control' value='".$_GET['supplierId']."'>";?>
											
											<input id="search" name="search" value="<?php if ($_GET['search']!="") echo $_GET['search'];?>" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['Search'];?>&hellip;">
										</form>
									</div>
									<div class="item-action">
										<?php if ($_GET['tableStatus']=='view') { echo "<a href='new.php?formStatus=create&target=".$_GET['target']."' class='btn btn-icon btn-lg'><i class='fe fe-user-plus'></i></a>"; }?>
									</div>
								</div>
							</div>
						</div>	
				
							
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='new.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Select Customer']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit Customer']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create a new customer']; ?>
								</h3>
		
							 <div class="card-options">
								<div class="item-action">
									<?php echo $_SESSION['language']['Total']." ".$totalItem." ".$_SESSION['language']['Customers']; ?>&nbsp&nbsp&nbsp
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
								<table class="table table-hover table-outline table-vcenter card-table" style="table-layout: fixed;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
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
									
									if ($_GET['target']=="sale") {
										
									$sql = "SELECT * FROM (SELECT ROW_NUMBER() OVER (ORDER BY customer.id ASC) as row, id, code, taxId, businessName, address, location, phone, email FROM customer";
									
									if ($_GET['search']!="") 
										$sql.= " WHERE (companyId=".$_SESSION['user']['companyId']." AND flagActive=1 AND ((customer.businessName LIKE '%".$_GET['search']."%') OR (customer.address LIKE '%".$_GET['search']."%') OR (customer.code LIKE '%".$_GET['search']."%') OR (customer.id LIKE '%".$_GET['search']."%') OR (customer.phone LIKE '%".$_GET['search']."%') OR (customer.taxId LIKE '%".$_GET['search']."%')))";
									else
										$sql.= " WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1";
									
									$id = "customerId";
									
									}
									
									if ($_GET['target']=="purchase") {
										
									$sql = "SELECT * FROM (SELECT ROW_NUMBER() OVER (ORDER BY id ASC) as row, id, supplierCode, taxId, businessName, address, location, phone, email FROM supplier";
									
									if ($_GET['search']!="") 
										$sql.= " WHERE (companyId=".$_SESSION['user']['companyId']." AND flagActive=1 AND ((businessName LIKE '%".$_GET['search']."%') OR (address LIKE '%".$_GET['search']."%') OR (companyCode LIKE '%".$_GET['search']."%') OR (id LIKE '%".$_GET['search']."%') OR (phone LIKE '%".$_GET['search']."%') OR (taxId LIKE '%".$_GET['search']."%')))";
									else
										$sql.= " WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1";
									
									$id = "supplierId";
									
									}
									
									
									$sql.=") AS newTable WHERE (row>".$min.") AND (row<=".$max.") ORDER BY row DESC;"; 
									 
									//$sql = "SELECT * FROM customer WHERE companyId=".$_SESSION['user']['companyId']." ORDER BY id DESC";  
									$stmt = mysqli_query( $conn, $sql);  
									

									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  
									  <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['code']; ?><?php echo $row['companyCode']; ?><?php echo $row['supplierCode']; ?></div>
									  </td>
									   <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['taxId']; ?></div>
									  </td>
									  <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['businessName']; ?></div>
									  </td>
									   <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['address']; ?></div>
									  </td>
									  <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['description']; ?></div>
									  </td>
									   
									  <td class="text-center">
										<div class="item-action dropdown">
										  <a href="market.php?tableStatus=view&market=wholesale&<?php echo $id; ?>=<?php echo $row['id']; ?>&target=<?php echo $_GET['target']; ?>&page=1" class="icon"><i class="fe fe-arrow-right-circle"></i></a>
										</div>
									  </td>
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
							
						