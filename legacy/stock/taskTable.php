					<?php
									
					
					$sqlTask = "SELECT COUNT(id) as result FROM tasks WHERE userId=".$_SESSION['user']['id']." AND businessId=".$_SESSION['user']['businessId']; 
					$stmtTask = mysqli_query( $conn, $sqlTask);  
					
					if ( $stmtTask ) {
					while( $rowTask = mysqli_fetch_array( $stmtTask, MYSQLI_ASSOC ))  
					{  
		
						$taskResult = $rowTask['result'];
					
					}
					}
					
					
					?>				
					
					<div class="col-12">
						<?php if ($_GET['tableStatus']=='view') { ?>
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
							
					
							
								<div class="tags">
							
								  <span class="tag <?php if ($_GET['target']=='unit') echo "tag-success";?>">
									<a href="task.php?tableStatus=view&target=unit" class="tag-addon"> <?php echo $_SESSION['language']['Stock'];?> (<?php echo $_SESSION['language']['Unit'];?>)</a>
								  </span>
								  <!--
								  <span class="tag <?php if ($_GET['target']=='pack') echo "tag-success";?>">
									<a href="task.php?tableStatus=view&target=pack" class="tag-addon"> <?php echo $_SESSION['language']['Stock'];?> (<?php echo $_SESSION['language']['Box'];?>)</a>
								  </span>
								  -->
								<?php if ($_GET['search']!="") { ?> 
								  <span class="tag">
									<?php echo $_GET['search']; ?> 
									<a href="task.php?tableStatus=view&target=unit" class="tag-addon"><i class="fe fe-x"></i></a>
								  </span>
								<?php } ?>  
								  </div>
								
								
								<div class="card-options">
								<div class="item-action">
									<form action="task.php" method="get" autocomplete="off" >
									<div class="input-icon mb-3">
										<input id="search" name="search" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['search'];?>">
										<input id="tableStatus" name="tableStatus" type="hidden" value="view">
										<input id="target" name="target" type="hidden" value="unit">
										<span class="input-icon-addon">
										  <i class="fe fe-search"></i>
										</span>
									</div>
									</form>
								</div>
							</div>
							</div>
						</div>
						<?php }; ?>
						
						
						
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit product']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
								</h3>
								<div class="card-options">
									<div class="item-action">  
										  <button type="button" id="view" onclick="window.location.href='taskRequest.php?tableStatus=view'" class="btn btn-success btn-sm"><i class="fe fe-clipboard mr-2"></i> <?php echo $_SESSION['language']['Operations'];?> </button> &nbsp &nbsp &nbsp 
									</div>
								</div>

							</div>


							  <?php if ($_GET['tableStatus']=='view') { ?>
							
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								   <thead>
									<tr>
									  <th style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['SKU'];?></th>
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Code'];?></th>
									  <?php if ($_GET['target']=='unit') { ?>
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Units'];?> </th>
									  <?php } ?>
									  <?php if ($_GET['target']=='pack') { ?>
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Boxes'];?> </th>
									  <?php } ?>
									  <th style="width:30%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Product Name'];?></th>
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Unit/Box'];?></th>
									  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Due Date'];?></th>
									  
									  <th style="width:15%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Description'];?></th>
									 
									</tr>
								  </thead>
								  <tbody>
									
								
									
									<?php
									
									if ($_GET['search']!='') {

									$inputSearch = "N'%".$_GET['search']."%'";
									//$sql = "SELECT products.id, products.sku, products.unitBarcode, products.name, products.packWholesale, tasks.stock, tasks.description FROM products AS products LEFT JOIN tasks AS tasks ON tasks.productId=products.id WHERE products.businessId=".$_SESSION['user']['businessId']." AND products.flagActive=1 ORDER BY products.id ASC;"; 
									$sql = "SELECT * FROM products WHERE unitBarcode LIKE ".$inputSearch." OR name LIKE ".$inputSearch." OR name2 LIKE ".$inputSearch." ORDER BY name ASC;"; 
									//echo "sql query:". $sql;
									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  <td>
										<div><?php echo $row['sku']; ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['unitBarcode']; ?></div>
									  </td>
									  <td class="text-center">
										<!--<input id="stock<?php echo $row['id'];?>" onchange="addItem(<?php echo "'".$_SESSION['user']['businessId']."','".$row['id']."','".$row['unitBarcode']."','".$_SESSION['user']['id']."', '".$row['name']."', '".$_GET['target']."', '".$row['packWholesale']."'"; ?>)" type="number" class="form-control" style="border: none; text-align: center;" value="<?php if ($_GET['target']=='unit') echo $row['stock']; else if ($row['stock']!=0) echo $row['stock']/$row['packWholesale'];?>" step=1>-->
									  <input id="stock<?php echo $row['id'];?>" onchange="addItem(<?php echo "'".$_SESSION['user']['businessId']."','".$row['id']."','".$row['unitBarcode']."','".$_SESSION['user']['id']."', '".$row['name']."', '".$_GET['target']."', '".$row['packWholesale']."'"; ?>)" type="number" class="form-control" style="border: none; text-align: center;" value="" step=1>
									  
										</td>
									  <td>
										<div><?php echo $row['name']; ?></a></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['packWholesale']; ?></a></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['dueDate']; ?></a></div>
									  </td>
									  
									  <td class="text-center">
										<input id="description<?php echo $row['id'];?>" onchange="addItem(<?php echo "'".$_SESSION['user']['businessId']."','".$row['id']."','".$row['unitBarcode']."','".$_SESSION['user']['id']."', '".$row['name']."', '".$_GET['target']."', '".$row['packWholesale']."'"; ?>)" type="text" class="form-control" style="border: none; text-align: left;" value="<?php echo $row['description'];?>">
									  </td>
									  
									</tr>
									<?php }; }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
							
							
						</div>
						
						
			
						
		
						
  </div>	
  
<script>	
function addItem(businessId, productId, unitBarcode, userId, itemName, target, pack){							

var stockId = "stock"+productId;
var descriptionId = "description"+productId;

var stock  = document.getElementById(stockId).value;
var description  = document.getElementById(descriptionId).value;

if (target=="pack") {
  stock = stock * pack;
}

    $.ajax({
        url: '../webservice/stock.php',
        type: 'GET',
        data: {productId:productId, unitBarcode:unitBarcode, userId:userId, businessId:businessId, stock:stock, description:description, action:"add"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			toastr.success("<?php echo $_SESSION['language']['Product added'];?>: "+itemName);
			//document.getElementById(stockId).value = "0";
			//document.getElementById(descriptionId).value = "";
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error(itemName);
		console.log(data); // Inspect this in your console
    }  
    });

}
</script>																	