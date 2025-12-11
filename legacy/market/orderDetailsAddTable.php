					<?php
					
					if ($_GET['companyId']!="")	
						$companyCondition = $_GET['companyId'];
					else
						$companyCondition = "";
						
					if ($_GET['target']=="purchase")
						$companyCondition = $_SESSION['user']['companyId']; // ex $_GET['supplierId'] * crea su propia lista de productos
						
					if ($_GET['target']=="sale")
						$companyCondition = $_SESSION['user']['companyId'];
						
					
					$companyCondition = $_SESSION['user']['companyId'];
					
					$pageUrl = "orderDetailsAdd.php?tableStatus=view";
					
					$sqlPage = "SELECT COUNT(*) AS rowNum FROM product INNER JOIN company on product.companyId=company.id";  
					
					if ($_GET['market']=="retail")
					{
						if ($companyCondition!="") 
							if ($_GET['search']!="")
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.priceRetail!=0) AND ((product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%') OR (product.code LIKE N'%".$_GET['search']."%') OR (product.sku LIKE N'%".$_GET['search']."%')))";
							else
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.priceRetail!=0))";
						else
							if ($_GET['search']!="")
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.priceRetail!=0) AND (product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%'))";
							else
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.priceRetail!=0))";
					}
				
					if ($_GET['market']=="wholesale")
					{
						if ($companyCondition!="") 
							if ($_GET['search']!="")
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.priceWholesale!=0) AND ((product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%') OR (product.code LIKE N'%".$_GET['search']."%') OR (product.sku LIKE N'%".$_GET['search']."%')))";
							else
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.priceWholesale!=0))";
						else
							if ($_GET['search']!="")
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.priceWholesale!=0) AND (product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%'))";
							else
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.priceWholesale!=0))";
					}
					
					if ($_GET['market']=="private")
					{
						if ($companyCondition!="") 
							if ($_GET['search']!="")
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.pricePrivate!=0) AND ((product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%') OR (product.code LIKE N'%".$_GET['search']."%') OR (product.sku LIKE N'%".$_GET['search']."%')))";
							else
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.pricePrivate!=0))";
						else
							if ($_GET['search']!="")
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.pricePrivate!=0) AND (product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%'))";
							else
								$sqlPage.=" WHERE ((product.flagMarket=1) AND (product.pricePrivate!=0))";
					}
					
					$sqlPage.=";";
					
					
					// if ($_GET['market']=="retail") echo "&market=retail"; if ($_GET['market']=="wholesale") echo "&market=wholesale"; if ($_GET['companyId']!="") echo "&companyId=".$_GET['companyId']; if ($_GET['customerId']!="") echo "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") echo "&supplierId=".$_GET['supplierId']; if ($_GET['target']!="") echo "&target=".$_GET['target'];
					
					
					
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
					
					if ($_GET['userId']!="") {
						$pageGet.= "&userId=".$_GET['userId'];
					}
					
					if ($_GET['roleId']!="") {
						$pageGet.= "&roleId=".$_GET['roleId'];
					}
					
					if ($_GET['requestId']!="") {
						$pageGet.= "&requestId=".$_GET['requestId'];
					}
					
					if ($_GET['id']!="") {
						$pageGet.= "&id=".$_GET['id'];
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
					
					
					
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
										<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp
									</h3>
								<div class="tags">
								
									
								
 								  <span class="tag<?php if ($_GET['market']=="wholesale") echo " tag-success"; ?>">
									<a href="orderDetailsAdd.php?tableStatus=view<?php echo "&market=wholesale"; if ($_GET['companyId']!="") echo "&companyId=".$_GET['companyId']; if ($_GET['customerId']!="") echo "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") echo "&supplierId=".$_GET['supplierId']; if ($_GET['target']!="") echo "&target=".$_GET['target']; if ($_GET['userId']!="") echo "&userId=".$_GET['userId']; if ($_GET['roleId']!="") echo "&roleId=".$_GET['roleId']; if ($_GET['requestId']!="") echo "&requestId=".$_GET['requestId']; if ($_GET['id']!="") echo "&id=".$_GET['id'];?>&page=1" class="tag-addon"><?php echo $_SESSION['language']['Wholesale']; ?></a>
								  </span>
								  
								  <span class="tag<?php if ($_GET['market']=="retail") echo " tag-success"; ?>">
									<a href="orderDetailsAdd.php?tableStatus=view<?php echo "&market=retail"; if ($_GET['companyId']!="") echo "&companyId=".$_GET['companyId']; if ($_GET['customerId']!="") echo "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") echo "&supplierId=".$_GET['supplierId']; if ($_GET['target']!="") echo "&target=".$_GET['target']; if ($_GET['userId']!="") echo "&userId=".$_GET['userId']; if ($_GET['roleId']!="") echo "&roleId=".$_GET['roleId']; if ($_GET['requestId']!="") echo "&requestId=".$_GET['requestId']; if ($_GET['id']!="") echo "&id=".$_GET['id'];?>&page=1" class="tag-addon"><?php echo $_SESSION['language']['Retail']; ?></a>
								  </span>
								  
								  
								  								  
								<?php if ($_GET['search']!="") { ?> 
								  <span class="tag tag-success">
									<?php echo $_GET['search']; ?> 
									<a href="orderDetailsAdd.php?tableStatus=view<?php echo $pageGet; ?>&page=1" class="tag-addon"><i class="fe fe-x"></i></a>
								  </span>
								<?php } ?>  
								  </div>
								
								
								<div class="card-options">
									<div class="item-action">
										<form action="orderDetailsAdd.php" method="get">
											<input type="hidden" name="tableStatus" class="form-control" value="view">
											<?php echo "<input type='hidden' name='page' class='form-control' value='1'>";?>
											<?php if ($_GET['target']!="") echo "<input type='hidden' name='target' class='form-control' value='".$_GET['target']."'>";?>
											<?php if ($_GET['market']!="") echo "<input type='hidden' name='market' class='form-control' value='".$_GET['market']."'>";?>
											<?php if ($_GET['companyId']!="") echo "<input type='hidden' name='companyId' class='form-control' value='".$_GET['companyId']."'>";?>
											<?php if ($_GET['customerId']!="") echo "<input type='hidden' name='customerId' class='form-control' value='".$_GET['customerId']."'>";?>
											<?php if ($_GET['supplierId']!="") echo "<input type='hidden' name='supplierId' class='form-control' value='".$_GET['supplierId']."'>";?>
											<?php if ($_GET['requestId']!="") echo "<input type='hidden' name='requestId' class='form-control' value='".$_GET['requestId']."'>";?>
											<?php if ($_GET['id']!="") echo "<input type='hidden' name='id' class='form-control' value='".$_GET['id']."'>";?>
											<?php if ($_GET['supplierId']!="") echo "<input type='hidden' name='supplierId' class='form-control' value='".$_GET['supplierId']."'>";?>
											<input id="search" name="search" value="<?php if ($_GET['search']!="") echo $_GET['search'];?>" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['Search'];?>&hellip;">
										</form>
									</div>
								</div>
							</div>
						</div>
					
						
						<?php if (($_GET['companyId']!='')OR($_GET['search']!='')OR($_GET['customerId']!='')OR($_GET['supplierId']!='')) { ?>
						
						
						<!-----------LISTADO DE PRODUCTOS----------------------------->
						
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='productsList.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit product']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
								</h3>
								
								
									<?php
									/*
									if ($_GET['target']=="purchase") {
									
										$sqlCompanyActive = "SELECT flagCompanyActive FROM suppl WHERE id=".$_GET['supplierId'].";";  
										$stmtCompanyActive = mysqli_query( $conn, $sqlCompanyActive);  
									
										if ( $stmtCompanyActive ) {
											
											$rowCompanyActive = mysqli_fetch_array( $stmtCompanyActive, MYSQLI_ASSOC );
											
											if ($rowCompanyActive['flagCompanyActive']=="0") {
											
											//echo "<div class='item-action'>";
												echo "<a href='productsList.php?formStatus=create";
												if ($_GET['market']=="retail") echo "&market=retail"; if ($_GET['market']=="wholesale") echo "&market=wholesale"; if ($_GET['companyId']!="") echo "&companyId=".$_GET['companyId']; if ($_GET['customerId']!="") echo "&customerId=".$_GET['customerId']; if ($_GET['supplierId']!="") echo "&supplierId=".$_GET['supplierId']; if ($_GET['target']!="") echo "&target=".$_GET['target'];
												echo "' class='btn btn-icon btn-lg'><i class='fe fe-plus-square'></i></a>";
											//echo "</div>";										
											
											}
										}
									}									
									*/
									?>
								
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


							  <?php if ($_GET['tableStatus']=='view') { ?>
							
							  <div class="table-responsive">
								<!--<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">-->
								<table id="table" class="table table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Code'];?></th>
									  
									  <?php if ($_GET['target']=='sale') { ?> <th class="text-center" style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language'][''];?>Stock</th>  <?php } ?> 
									  
									  <th style="width:<?php if ($_GET['target']=='sale') echo "5"; else echo "10"; ?>%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></th>  
									  <th class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Quantity'];?></th>
									  <th style="width:30%;font-weight:bold;"> <?php echo $_SESSION['language']['Product Name'];?></th>
									  <th style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Pack'];?></th>
									  <th class="text-center" style="width:15%;font-weight:bold;"> <?php echo $_SESSION['language']['Category'];?></th>
									 	
									  <th class="text-right" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Price'];?></th>									  
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									$sql = "SELECT * FROM (SELECT ROW_NUMBER() OVER (ORDER BY product.id ASC) as row, product.id, product.supplierId, product.companyId, product.sku, product.code, product.image, product.name, company.businessName, product.category, product.currency, product.priceRetail, product.priceWholesale, product.packWholesale, product.pricePrivate FROM product INNER JOIN company on product.companyId=company.id";  
					
									if ($_GET['market']=="retail")
									{
										if ($companyCondition!="") 
											if ($_GET['search']!="")
												$sql.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.priceRetail!=0) AND ((product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%') OR (product.code LIKE N'%".$_GET['search']."%') OR (product.sku LIKE N'%".$_GET['search']."%')))";
											else
												$sql.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.priceRetail!=0))";
										else
											if ($_GET['search']!="")
												$sql.=" WHERE ((product.flagMarket=1) AND (product.priceRetail!=0) AND (product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%'))";
											else
												$sql.=" WHERE ((product.flagMarket=1) AND (product.priceRetail!=0))";
									}
								
									if ($_GET['market']=="wholesale")
									{
										if ($companyCondition!="") 
											if ($_GET['search']!="")
												$sql.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.priceWholesale!=0) AND ((product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%') OR (product.code LIKE N'%".$_GET['search']."%') OR (product.sku LIKE N'%".$_GET['search']."%')))";
											else
												$sql.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.priceWholesale!=0))";
										else
											if ($_GET['search']!="")
												$sql.=" WHERE ((product.flagMarket=1) AND (product.priceWholesale!=0) AND (product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%'))";
											else
												$sql.=" WHERE ((product.flagMarket=1) AND (product.priceWholesale!=0))";
									}
									
									if ($_GET['market']=="private")
									{
										if ($companyCondition!="") 
											if ($_GET['search']!="")
												$sql.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.pricePrivate!=0) AND ((product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%') OR (product.code LIKE N'%".$_GET['search']."%') OR (product.sku LIKE N'%".$_GET['search']."%')))";
											else
												$sql.=" WHERE ((product.flagMarket=1) AND (product.companyId=".$companyCondition.") AND (product.pricePrivate!=0))";
										else
											if ($_GET['search']!="")
												$sql.=" WHERE ((product.flagMarket=1) AND (product.pricePrivate!=0) AND (product.name LIKE N'%".$_GET['search']."%') OR (company.businessName LIKE N'%".$_GET['search']."%'))";
											else
												$sql.=" WHERE ((product.flagMarket=1) AND (product.pricePrivate!=0))";
									}
									
									$sql.=") AS newTable WHERE (row>".$min.") AND (row<=".$max.") ORDER BY row DESC;";
									
									$stmt = mysqli_query( $conn, $sql);  
									
								
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
										if ($_GET['target']=='sale')
										{
											$sqlStock = "SELECT SUM(stock) AS stock FROM stkLog WHERE productId=".$row['id'].";"; 
											$stmtStock = mysqli_query( $conn, $sqlStock);  
											$rowStock = mysqli_fetch_array( $stmtStock, MYSQLI_ASSOC );
											
											$sqlCheckStock = "SELECT SUM(quantity) AS check from swrOrder inner join swrOrderDetails on swrOrder.id=swrOrderDetails.orderId where ((swrOrder.userId!='')OR(swrOrder.customerId!=''))AND(swrOrder.flagStock=0)AND(swrOrderDetails.productId=".$row['id'].");";
											$stmtCheckStock = mysqli_query( $conn, $sqlCheckStock);  
											$rowCheckStock = mysqli_fetch_array( $stmtCheckStock, MYSQLI_ASSOC );
										}
									?>
									
									<tr>
									  <td>
										<div><?php echo $row['sku']; ?></div>
										<div class="small text-muted">
										  <?php echo $row['code']; ?>
										</div>
									  </td>
									  <?php if ($_GET['target']=='sale') { ?>
									  <td class="text-center">
										<div><?php echo number_format($rowStock['stock']-$rowCheckStock['check'],0,",","."); ?></div>
										<div class="small text-muted">
										  <?php echo "(".number_format(($rowStock['stock']-$rowCheckStock['check'])/$row['packWholesale'],0,",",".").")"; ?>
										</div>
									  </td>
									  <?php } ?>
									  <td class="text-center">
										<div><img src="<?php echo $row['image'];?>" class="d-inline-block align-top mr-3" style="max-height: 50px; width: auto;" alt=""></div>
									  </td>
									  <td class="text-center">
										<div><?php if ($_GET['market']=="wholesale") echo number_format($row['packWholesale'],0,",","."); else echo "1";?></div>
										
									  </td>
									  <td>
										<div><a onclick="window.location.href='marketProduct.php?tableStatus=view&market=<?php echo $_GET['market']; ?>&id=<?php echo $row['id']; ?>'" style="cursor: pointer;"><?php echo $row['name']; ?></a></div>
									  
									    <div class="small text-muted">
										  <a onclick="<?php if (($_GET['target']!="purchase")AND($_GET['target']!="sale")) echo "window.location.href='market.php?tableStatus=view&market=".$_GET['market']."&companyId=".$row['companyId']."&page=1'"; ?>" style="cursor: pointer;"><?php if (($_GET['target']!="purchase")AND($_GET['target']!="sale")) echo $row['businessName']; ?></a>
										</div>
									  </td>
									  <td class="text-center">
										<div><?php if ($_GET['market']=="wholesale") echo $row['packWholesale']; else echo '1.00'; ?></div>
									  </td>
						
									  <td class="text-center">
										<div><?php echo $row['category']; ?></div>
									  </td>
									  <td class="text-right">									    
										<div>$ 
											<?php 
											if ($_GET['market']=="retail")
												echo number_format($row['priceRetail'],2,",",".");
											
											if ($_GET['market']=="wholesale")
												if ($_SESSION['user']['subscription']>=0) 
													echo number_format($row['priceWholesale'],2,",","."); 
												else 
													echo "******,**"; 
											
											if ($_GET['market']=="private")
												echo number_format($row['pricePrivate'],2,",",".");
											?>
										</div>
									  </td>
									  <td class="text-center">
										<?php
										if ($_GET['market']=="retail")
											$marketId=0;
										
										if ($_GET['market']=="wholesale")
											$marketId=1;
										
										if ($_GET['market']=="private")
											$marketId=2;
										?>
										<a href="orderDetailsAddUpdate.php?action=add&productId=<?php echo $row['id'].$pageGet; ?>" class="icon"><i class="fe fe-plus"></i></a>
									  </td>
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
							
							
						</div>
						
						<!-----------FIN DE LISTADO DE PRODUCTOS----------------------------->
						
						<?php } else { ?>
						
						<!-----------POR PROVEEDORES ----------------------------->
						
						<div class="row row-cards">	

						<?php
						
						if ($_GET['market']=="retail")
							$price = "priceRetail";
						if ($_GET['market']=="wholesale")
							$price = "priceWholesale";
						
						$sqlGroup = "SELECT TOP 12 company.businessName, company.logo, company.flagCompanyActive, product.companyId, count( case when product.".$price." > 0 then 1 end)as items from product INNER JOIN company ON product.companyId=company.id WHERE product.flagMarket=1 AND company.id<>".$_SESSION['user']['id']." GROUP BY company.logo, company.businessName, company.flagCompanyActive, product.companyId ORDER BY NEWID();";  
						
						if ($_GET['market']=="private")
							$sqlGroup = "SELECT company.businessName, company.logo, company.flagCompanyActive, swrPrivate.companyId, count( case when product.pricePrivate > 0 then 1 end)as items from swrPrivate INNER JOIN company ON swrPrivate.companyId=company.id INNER JOIN product ON product.companyId=company.Id WHERE product.flagMarket=1 AND swrPrivate.userId=".$_SESSION['user']['id']." GROUP BY company.logo, company.businessName, company.flagCompanyActive, swrPrivate.companyId ORDER BY NEWID();";  
						
						$stmtGroup = mysqli_query( $conn, $sqlGroup); 
						
						if ( $stmtGroup ) {
						while( $rowGroup = mysqli_fetch_array( $stmtGroup, MYSQLI_ASSOC ))  
						{  
			
						?>	  
						  
						  <div class="col-sm-6 col-lg-4">
							<div class="card p-4">
							  <div class="d-flex align-items-center">
								<div>
								  <img src="<?php if ($rowGroup['logo']!="") echo $rowGroup['logo']; else echo "../assets/images/logo/logo.png";?>" alt="<?php echo $rowGroup['businessName'];?>" height="50" width="50" style="margin-right: 20px;">
								</div>
								<div>
								  <h4 class="m-0"><a href="../market/market.php?tableStatus=view&market=<?php echo $_GET['market'];?>&companyId=<?php echo $rowGroup['companyId'];?>&page=1"><?php echo $rowGroup['businessName'];?></a></h4>
								  <small class="text-muted"><?php echo $rowGroup['items'];?> <?php echo $_SESSION['language']['products'];?></small>
								</div>
								<div class="ml-auto text-muted">
									<?php if ($rowGroup['flagCompanyActive']==1) echo "<i style='color: green;' class='fe fe-check-circle mr-1' data-toggle='tooltip' data-placement='top' title='Company and Products Verified'>"; else echo "<i style='color: yellow;' class='fe fe-alert-circle mr-1' data-toggle='tooltip' data-placement='top' title='Company and Products NOT Verified'>";?></i>
							  </div>
							</div>
						  </div>
						 </div> 
						<?php

						}};
						
						?>	  
						  
						
						
						
						<!-----------FIN POR PROVEEDORES ----------------------------->
						
						<?php } ?>
						
  </div>	
  