				
					<?php if ($_GET['tableStatus']=='view') { ?>
					 <div class="col-12">
					<div class="card">
						<div class="card-status card-status-left bg-teal"></div>
						<div class="card-header">
							
							<div class="card-options">
								<div class="item-action">
									<form>
									<div class="input-icon mb-3">
										<input id="searchTable" onkeyup="tableFilter()" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['search'];?>" tabindex="1">
										<span class="input-icon-addon">
										  <i class="fe fe-search"></i>
										</span>
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
							</h3>
							<div class="card-options">
							<div class="item-action">
								<?php 
								
								$sqlCount = "SELECT COUNT(*) AS items FROM product WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1";  
								
								if ($_GET['market']=='retail')
									$sqlCount.=" AND priceRetail>0";
								
								if ($_GET['market']=='wholesale')
									$sqlCount.=" AND priceWholesale>0";
								
								if ($_GET['market']=='private')
									$sqlCount.=" AND pricePrivate>0";
								
								$sqlCount.=";";
								
								$stmtCount= mysqli_query( $conn, $sqlCount); 
									
								if ( $stmtCount ) {
								$rowCount = mysqli_fetch_array( $stmtCount, MYSQLI_ASSOC );  
								echo $_SESSION['language']['Total']." ".$rowCount['items']." ".$_SESSION['language']['products']; 
								}
								
								?> &nbsp&nbsp&nbsp
							</div>
							
							
							<div class="item-action dropdown">
							  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-horizontal"></i></a>
							  <div class="dropdown-menu dropdown-menu-right">
								<a href="productsList.php?formStatus=create" class="dropdown-item"><i class="dropdown-icon fe fe-plus"></i> <font color="black"> <?php echo $_SESSION['language']['Add product'];?></font></a>
								<a href="productSort.php?tableStatus=view" class="dropdown-item"><i class="dropdown-icon fe fe-filter"></i> <font color="black"> <?php echo $_SESSION['language']['Sort products'];?></font></a>
								<a href="productsRestore.php?tableStatus=view" class="dropdown-item"><i class="dropdown-icon fe fe-refresh-cw"></i> <font color="black"> <?php echo $_SESSION['language']['Restore products'];?></font></a>
								<!--<a onclick="fnExcelReport()" class="dropdown-item"><i class="dropdown-icon fe fe-log-out"></i> <font color="black"> <?php echo $_SESSION['language']['Export to Excel'];?></font></a>-->
							  </div>
							</div>
							
							
						  </div>
						  
						  
						</div>


										<datalist id="category">
											
										<?php 

											$sqlcategory = "SELECT DISTINCT category FROM product WHERE companyId=".$_SESSION['user']['companyId'].";";  
											$stmtcategory = mysqli_query( $conn, $sqlcategory); 
																				

												if ( $stmtcategory ) {
													while( $rowcategory = mysqli_fetch_array( $stmtcategory, MYSQLI_ASSOC))  
													{  
														echo "<option value='".$rowcategory['category']."'>".$rowcategory['category']."</option>"; 
														
													}  
												}
										 ?>
										
									  </datalist>
									  
									  
									  <datalist id="subcategory">
										
										<?php 

											$sqlsubcategory = "SELECT DISTINCT subcategory FROM product WHERE companyId=".$_SESSION['user']['companyId'].";";  
											$stmtsubcategory = mysqli_query( $conn, $sqlsubcategory); 
																				

												if ( $stmtsubcategory ) {
													while( $rowsubcategory = mysqli_fetch_array( $stmtsubcategory, MYSQLI_ASSOC))  
													{  
														echo "<option value='".$rowsubcategory['subcategory']."'>".$rowsubcategory['subcategory']."</option>"; 
														
													}  
												}
										 ?>
										
									  </datalist>

							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline card-table" style="table-layout:fixed;">
								  <thead>
									<tr>
									  <th class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Market'];?></th>	
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['SKU'];?></th>
									  <th style="width:25%;font-weight:bold;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $_SESSION['language']['Product Name'];?> 1</th>
									  <th style="width:25%;font-weight:bold;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $_SESSION['language']['Product Name'];?> 2</th>
									  <th class="text-center" style="width:15%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?> 1</th>
									  <th class="text-center" style="width:15%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?> 2</th>
									  
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									
									$sql = "SELECT * FROM product WHERE companyId=".$_SESSION['user']['companyId']; 
									
									if ($_GET['market']=='')
										$sql.=" AND flagActive=1 ORDER BY id ASC";
								
									
									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  <td class="text-center">
									  <label class="custom-switch">
										<input id="<?php echo $row['id'];?>" onchange="market(<?php echo "'".$row['id']."'"; ?>)" type="checkbox" class="custom-switch-input"<?php if ($row['flagMarket2']==1) echo " checked";?>>
										<span class="custom-switch-indicator"></span>
									  </label>
									  </td>
									  <td>
										<div><?php echo $row['sku']; ?></div>
										<div class="small text-muted">
										  <?php echo $row['code']; ?>
										</div>
									  </td>
									  
									  <td class="text-left" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" onclick="ableUpdate('<?php echo $row['id'];?>','name')">
									  
										  <div id="nameDisplay<?php echo $row['id'];?>"><?php echo $row['name']; ?></div>
										  <input  id="nameInput<?php echo $row['id'];?>" onchange="update('product','<?php echo $row['id'];?>','name','1')" onblur="update('product','<?php echo $row['id'];?>','name','1')" style="display: none;" type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>">
										  
										
									  </td>
									  <td class="text-left" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" onclick="ableUpdate('<?php echo $row['id'];?>','name2')">
									  
										  <div id="name2Display<?php echo $row['id'];?>"><?php echo $row['name2']; ?></div>
										  <input  id="name2Input<?php echo $row['id'];?>" onchange="update('product','<?php echo $row['id'];?>','name2','1')" onblur="update('product','<?php echo $row['id'];?>','name2','1')" style="display: none;" type="text" name="name2" class="form-control" value="<?php echo $row['name2']; ?>">
										  
										
									  </td>
										  
									  <td class="text-center"  onclick="ableUpdate('<?php echo $row['id'];?>','category')">
									  
										  <div id="categoryDisplay<?php echo $row['id'];?>"><?php echo $row['category']; ?></div>
										  <input  id="categoryInput<?php echo $row['id'];?>" onchange="update('product','<?php echo $row['id'];?>','category','1')" onblur="update('product','<?php echo $row['id'];?>','category','1')" style="width: 150px; display: none;" type="text" name="category" class="form-control" list="category" value="<?php echo $row['category']; ?>">
										  
										
									  </td>
									  
									  <td class="text-center"  onclick="ableUpdate('<?php echo $row['id'];?>','subcategory')">
									  
										  <div id="subcategoryDisplay<?php echo $row['id'];?>"><?php echo $row['subcategory']; ?></div>
										  <input  id="subcategoryInput<?php echo $row['id'];?>" onchange="update('product','<?php echo $row['id'];?>','subcategory','1')" onblur="update('product','<?php echo $row['id'];?>','subcategory','1')" style="width: 150px; display: none;" type="text" name="subcategory" class="form-control" list="subcategory" value="<?php echo $row['subcategory']; ?>">
										  
										
									  </td>
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
function market(productId){							

var check = document.getElementById(productId).checked;

if (check==false) {
  var market = 0;
} else {
  var market = 1;
}

    $.ajax({
        url: '../webservice/products.php',
        type: 'GET',
        data: {productId:productId, market:market, action:"market2"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede agregar el producto");
		console.log(data); // Inspect this in your console
    }  
    });

}

function ableUpdate(id,variable){							

	document.getElementById(variable+'Display'+id).style.display = 'none';
	document.getElementById(variable+'Input'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).focus();
	
}

function update(table, id, variable, type){							

var value = document.getElementById(variable+"Input"+id).value;

	document.getElementById(variable+'Display'+id).innerHTML = value;
	document.getElementById(variable+'Input'+id).innerHTML = value;
	document.getElementById(variable+'Display'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).style.display = 'none';
	
// type 1 =  string // type 2 = number

    $.ajax({
        url: '../webservice/update.php',
        type: 'GET',
        data: {table:table, id:id, variable:variable, value:value, type:type, action:"update"},
        success: function(data) {
			
			//location.reload();
			toastr.options.positionClass = "toast-top-left";
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede agregar el producto");
		console.log(data); // Inspect this in your console
    }  
    });


/*
$('#loading').modal({
    backdrop: 'static',
    keyboard: false
})
*/


}
</script>	


															