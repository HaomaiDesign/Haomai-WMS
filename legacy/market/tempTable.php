					<?php if ($_GET['tableStatus']=='view') { ?>

					<?php
					
					$pageUrl = "temp.php?tableStatus=view";
					

						$sqlPage = "SELECT COUNT(*) AS rowNum FROM customer";  
						
						if ($_GET['search']!="")
							$sqlPage.=" WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1 AND ((customer.businessName LIKE '%".$_GET['search']."%') OR (customer.address LIKE '%".$_GET['search']."%') OR (customer.code LIKE '%".$_GET['search']."%') OR (customer.id LIKE '%".$_GET['search']."%') OR (customer.phone LIKE '%".$_GET['search']."%') OR (customer.taxId LIKE '%".$_GET['search']."%'))";
						else
							$sqlPage.=" WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1";

		
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
					
					if ($_GET['businessName']!="") {
						$pageGet.= "&businessName=".$_GET['businessName'];
					}
					
					if ($_GET['taxId']!="") {
						$pageGet.= "&taxId=".$_GET['taxId'];
					}
					
					if ($_GET['whatsapp']!="") {
						$pageGet.= "&whatsapp=".$_GET['whatsapp'];
					}
					
					if ($_GET['wechat']!="") {
						$pageGet.= "&wechat=".$_GET['wechat'];
					}
					
					if ($_GET['phone']!="") {
						$pageGet.= "&phone=".$_GET['phone'];
					}
					
					if ($_GET['description']!="") {
						$pageGet.= "&description=".$_GET['description'];
					}
					
					$pageUrl.= $pageGet;
					
					if ($_GET['search']!="") {
						$pageSearch = $pageUrl.$pageGet."&search=".$_GET['search']."&page=";
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
								<h3 class="card-title" style="font-weight:bold;">
								<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Order Customer Details'];  ?>
								</h3>
							  
								<div class="card-options">
									
									<div class="item-action">
										<?php if (($_GET['tableStatus']=='view')AND($_GET['customerId']=="")) { echo "<a href='temp.php?formStatus=create&tempId=".$_GET['tempId']."&businessName=".$_GET['businessName']."&address=".$_GET['address']."&location=".$_GET['location']."&phone=".$_GET['phone']."&taxId=".$_GET['taxId']."&whatsapp=".$_GET['whatsapp']."&wechat=".$_GET['wechat']."&description=".$_GET['description']."' class='btn btn-icon btn-lg'><i class='fe fe-user-plus'></i></a>"; }?>
									</div>
								</div>
						  </div>
							 
							  <div class="table-responsive">
								<table class="table table-hover table-outline table-vcenter card-table" style="table-layout: fixed;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
								  <thead>
									<tr>
									  
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Tax ID'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Business Name'];?></th>
									  <th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Address'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Location'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Phone'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Whatsapp'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Wechat'];?></th>
									  <th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Description'];?></th>									  
									  
									 
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									if ($_GET['customerId']!="") {
										$sqlTarget = "SELECT * FROM customer WHERE id=".$_GET['customerId'].";";
									
									
									
									$stmtTarget = mysqli_query( $conn, $sqlTarget);  
									

									
									if ( $stmtTarget ) {
									while( $rowTarget = mysqli_fetch_array( $stmtTarget, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
							
									  <td>
										<div><?php echo $rowTarget['taxId']; ?></div>
									  </td>
									  <td>
										<div><?php  echo $rowTarget['businessName']; ?></div>
									  </td>
									  <td>
										<div><?php echo $rowTarget['address']; ?></div>
									  </td>
									  <td>
										<div><?php echo $rowTarget['location']; ?></div>
									  </td>
									  <td>
										<div><?php echo $rowTarget['phone']; ?></div>
									  </td>
									  <td>
										<div><?php echo $rowTarget['whatsapp']; ?></div>
									  </td>
									  <td>
										<div><?php echo $rowTarget['wechat']; ?></div>
									  </td>
									  <td>
										<div><?php echo $rowTarget['description']; ?></div>
									  </td>
									</tr>
									<?php }}} else { ?>
								
									<tr>
										
										<td>
										<div><?php echo $_GET['taxId']; ?></div>
									  </td>
									  <td>
										<div><?php  echo $_GET['businessName']; ?></div>
									  </td>
									  <td>
										<div><?php echo $_GET['address']; ?></div>
									  </td>
									  <td>
										<div><?php echo $_GET['location']; ?></div>
									  </td>
									  <td>
										<div><?php echo $_GET['phone']; ?></div>
									  </td>
									  <td>
										<div><?php echo $_GET['whatsapp']; ?></div>
									  </td>
									  <td>
										<div><?php echo $_GET['wechat']; ?></div>
									  </td>
									  <td>
										<div><?php echo $_GET['description']; ?></div>
									  </td>
									  
									  
									</tr>
								
								<?php }?>
								  </tbody>
								</table>
							  </div>
							
						</div>
						
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
							<!--
							<div class="tags">
							
								<?php if ($_GET['search']!="") { ?> 
								  <span class="tag">
									<?php echo $_GET['search']; ?> 
									<a href="<?php echo $pageUrl;?>" class="tag-addon"><i class="fe fe-x"></i></a>
								  </span>
								<?php } ?>  
							</div>
							-->
							
							<div class="card-options">
									<div class="item-action">
										<form action="temp.php" method="get">
											<input type="hidden" name="tableStatus" class="form-control" value="view">
											<?php echo "<input type='hidden' name='page' class='form-control' value='1'>";?>
											<?php if ($_GET['date']!="") echo "<input type='hidden' name='date' class='form-control' value='".$_GET['date']."'>";?>
											<?php if ($_GET['taxId']!="") echo "<input type='hidden' name='taxId' class='form-control' value='".$_GET['taxId']."'>";?>
											<?php if ($_GET['businessName']!="") echo "<input type='hidden' name='businessName' class='form-control' value='".$_GET['businessName']."'>";?>
											<?php if ($_GET['address']!="") echo "<input type='hidden' name='address' class='form-control' value='".$_GET['address']."'>";?>
											<?php if ($_GET['location']!="") echo "<input type='hidden' name='location' class='form-control' value='".$_GET['location']."'>";?>
											<?php if ($_GET['phone']!="") echo "<input type='hidden' name='phone' class='form-control' value='".$_GET['phone']."'>";?>
											<?php if ($_GET['whatsapp']!="") echo "<input type='hidden' name='whatsapp' class='form-control' value='".$_GET['whatsapp']."'>";?>
											<?php if ($_GET['wechat']!="") echo "<input type='hidden' name='wechat' class='form-control' value='".$_GET['wechat']."'>";?>
											<?php if ($_GET['description']!="") echo "<input type='hidden' name='description' class='form-control' value='".$_GET['description']."'>";?>
											<?php if ($_GET['tempId']!="") echo "<input type='hidden' name='tempId' class='form-control' value='".$_GET['tempId']."'>";?>
											<input id="search" name="search" value="<?php if ($_GET['search']!="") echo $_GET['search'];?>" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['Search'];?>&hellip;">
										</form>
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
									<?php echo $_SESSION['language']['Total']." ".$totalItem." ".$_SESSION['language']['Customer']; ?>&nbsp&nbsp&nbsp
								</div>
								
								<div class="item-action">
									<a href="<?php echo $pageSearch."1";?>"<?php if ($_GET['page']==1) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-double-left"></i></a>
									<a href="<?php echo $pageSearch.($_GET['page']-1);?>"<?php if ($_GET['page']==1) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-left"></i></a>
									<a style="color: black;"><?php echo $_SESSION['language']['Page']." ".$_GET['page']." / ".$totalPage; ?>&nbsp </a> 
									<a href="<?php echo $pageSearch.($_GET['page']+1);?>"<?php if ($_GET['page']==$totalPage) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-right"></i></a>
									<a href="<?php echo $pageSearch.$totalPage;?>"<?php if ($_GET['page']==$totalPage) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-double-right"></i></a>&nbsp
								</div>
								
								
							  </div>	
						  </div>
							  
							  <div class="table-responsive">
								<table class="table table-hover table-outline table-vcenter card-table" style="table-layout: fixed;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
								  <thead>
									<tr>
									  <th style="width:5%;font-weight:bold;" class="text-center">#</i></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Tax ID'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Business Name'];?></th>
									  <th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language']['Address'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Location'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Phone'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Whatsapp'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Wechat'];?></th>
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Description'];?></th>									  
									  
									  <th style="width:5%;font-weight:bold;" class="text-center"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
						
										
									$sql = "SELECT * FROM (SELECT ROW_NUMBER() OVER (ORDER BY customer.id ASC) as row, id, code, taxId, businessName, address, location, phone, whatsapp, wechat, email, description FROM customer";
									
									if ($_GET['search']!="") 
										$sql.= " WHERE (companyId=".$_SESSION['user']['companyId']." AND flagActive=1 AND ((customer.businessName LIKE '%".$_GET['search']."%') OR (customer.address LIKE '%".$_GET['search']."%') OR (customer.code LIKE '%".$_GET['search']."%') OR (customer.id LIKE '%".$_GET['search']."%') OR (customer.phone LIKE '%".$_GET['search']."%') OR (customer.taxId LIKE '%".$_GET['search']."%')))";
									else
										$sql.= " WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1";
									
									$id = "customerId";
									
						
									

									
									
									$sql.=") AS newTable WHERE (row>".$min.") AND (row<=".$max.") ORDER BY row DESC;"; 
									 
									//$sql = "SELECT * FROM customer WHERE companyId=".$_SESSION['user']['companyId']." ORDER BY id DESC";  
									$stmt = mysqli_query( $conn, $sql);  
									

									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  
									  <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['code']; ?><?php echo $row['companyCode']; ?></div>
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
										<div><?php echo $row['location']; ?></div>
									  </td>
									  <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['phone']; ?></div>
									  </td>
									  <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['whatsapp']; ?></div>
									  </td>
									  <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['wechat']; ?></div>
									  </td>
									  <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
										<div><?php echo $row['description']; ?></div>
									  </td>
									   
									  <td class="text-center">
										<div class="item-action dropdown">
										  <a href="tempUpdate.php?action=update&tempId=<?php echo $_GET['tempId']; ?>&customerId=<?php echo $row['id']; ?>" class="icon"><i class="fe fe-arrow-right-circle"></i></a>
										</div>
									  </td>
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
							
						