				
					<?php if ($_GET['tableStatus']=='view') { ?>
					 <div class="col-12">
					<div class="card">
						<div class="card-status card-status-left bg-teal"></div>
						<div class="card-header">
							
							<div class="tags">
												
							  <span class="tag<?php if ($_GET['market']=="") echo " tag-success"; ?>">
								<a href="productsList.php?tableStatus=view" class="tag-addon"><?php echo $_SESSION['language']['All']; ?></a>
							  </span>
							  
							  <span class="tag<?php if ($_GET['market']=="retail") echo " tag-success"; ?>">
								<a href="productsList.php?tableStatus=view&market=retail" class="tag-addon"><?php echo $_SESSION['language']['Retail']; ?></a>
							  </span>
							  
							  <span class="tag<?php if ($_GET['market']=="wholesale") echo " tag-success"; ?>">
								<a href="productsList.php?tableStatus=view&market=wholesale" class="tag-addon"><?php echo $_SESSION['language']['Wholesale']; ?></a>
							  </span>
							  
							  <span class="tag<?php if ($_GET['market']=="private") echo " tag-success"; ?>">
								<a href="productsList.php?tableStatus=view&market=private" class="tag-addon"><?php echo $_SESSION['language']['Private']; ?></a>
							  </span>
							  
							
							 </div>
							
							
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
								<?php if ($_SESSION['user']['companyGroup']=="tich") { ?><a href="productsListSecond.php?tableStatus=view" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> <font color="black"> <?php echo $_SESSION['language']['Second market'];?></font></a><?php }; ?>
								<!--<a onclick="fnExcelReport()" class="dropdown-item"><i class="dropdown-icon fe fe-log-out"></i> <font color="black"> <?php echo $_SESSION['language']['Export to Excel'];?></font></a>-->
							  </div>
							</div>
							
							
						  </div>
						  
						  
						</div>


							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th class="text-center" style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Market'];?></th>	
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['SKU'];?></th>
									  <!--<th style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Image'];?></th>  -->
									  
									  <?php if ($_SESSION['user']['subscription']>=2) { ?> <th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></th>  <?php } ?>
									  <th style="width:<?php if ($_SESSION['user']['subscription']>=2) echo "40"; else echo "30"; ?>%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>
									  <th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Unit/Pack'];?></th>
									  <?php if ($_SESSION['user']['subscription']>=2) { ?><th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Pack'];?></th> <?php } ?>
									  <th class="text-right" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Retail'];?> ($)</th>	
									  <th class="text-right" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Wholesale'];?> ($)</th>
									  <th class="text-right" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Private'];?> ($)</th>									  
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									$sql = "SELECT * FROM product WHERE companyId=".$_SESSION['user']['companyId']; 
									
									if ($_GET['market']=='')
										$sql.=" AND flagActive=1 ORDER BY id ASC";
									
									if ($_GET['market']=='retail')
										$sql.=" AND flagActive=1 AND priceRetail>0 ORDER BY id ASC";
									
									if ($_GET['market']=='wholesale')
										$sql.=" AND flagActive=1 AND priceWholesale>0 ORDER BY id ASC";
									
									if ($_GET['market']=='private')
										$sql.=" AND flagActive=1 AND pricePrivate>0 ORDER BY id ASC";
									
									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr id="tableRow<?php echo $row['id'];?>">
									  <td class="text-center">
									  <label class="custom-switch">
										<input id="<?php echo $row['id'];?>" onchange="market(<?php echo "'".$row['id']."'"; ?>)" type="checkbox" class="custom-switch-input"<?php if ($row['flagMarket']==1) echo " checked";?>>
										<span class="custom-switch-indicator"></span>
									  </label>
									  </td>
									  <td>
										<div><?php echo $row['sku']; ?></div>
										<div class="small text-muted">
										  <?php echo $row['code']; ?>
										</div>
									  </td>
									  <!--
									  <td class="text-center">
										<div><img src="<?php echo $row['image'];?>" class="d-inline-block align-top mr-3" alt=""></div>
									  </td>
									  -->
									 
									  <?php if ($_SESSION['user']['subscription']>=2) { ?>
									  <td class="text-center">
										
										<div id="marketLimitDisplay<?php echo $row['id'];?>" onclick="ableUpdate('<?php echo $row['id'];?>','marketLimit')"><?php echo number_format($row['marketLimit'],2,",","."); ?></div>
										<input id="marketLimitInput<?php echo $row['id'];?>" onchange="update('product','<?php echo $row['id'];?>','marketLimit','2')" onblur="update('product','<?php echo $row['id'];?>','marketLimit','2')" type="number" class="form-control" style="display: none; text-align: right; padding: 1px;" value=<?php echo $row['marketLimit']; ?> min=0 step=0.01>
									  
									  </td>
									  <?php } ?>
									  <td>
										
										<div><a onclick="window.location.href='productsList.php?formStatus=view&id=<?php echo $row['id']; ?>'" style="cursor: pointer;"><?php if (strlen($row['name'])>50) echo substr($row['name'],0,50)."..."; else echo $row['name']; ?></a></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['packWholesale']; ?></div>
									  </td>
									  
									  <?php if ($_SESSION['user']['subscription']>=2) { ?>
									  
									  <td class="text-center">
										<div><?php echo intval(($rowStock['stock']-$rowCheckStock['check'])/$row['packWholesale']); ?></div>
									  </td>
									  
									  <?php } ?>
									  
									  <td class="text-right">
										<div id="priceRetailDisplay<?php echo $row['id'];?>" onclick="ableUpdate('<?php echo $row['id'];?>','priceRetail')">$ <?php echo number_format($row['priceRetail'],2,",","."); ?></div>
										<input id="priceRetailInput<?php echo $row['id'];?>" onchange="update('product','<?php echo $row['id'];?>','priceRetail','2')" onblur="update('product','<?php echo $row['id'];?>','priceRetail','2')" type="number" class="form-control" style="display: none; text-align: right; padding: 1px;" value=<?php echo $row['priceRetail']; ?> min=0 step=0.01>
									  </td>
									  <td class="text-right">
										<div id="priceWholesaleDisplay<?php echo $row['id'];?>" onclick="ableUpdate('<?php echo $row['id'];?>','priceWholesale')">$ <?php echo number_format($row['priceWholesale'],2,",","."); ?></div>
										<input id="priceWholesaleInput<?php echo $row['id'];?>" onchange="update('product','<?php echo $row['id'];?>','priceWholesale','2')" onblur="update('product','<?php echo $row['id'];?>','priceWholesale','2')" type="number" class="form-control" style="display: none; text-align: right; padding: 1px;" value=<?php echo $row['priceWholesale']; ?> min=0 step=0.01>
									  </td>
									  <td class="text-right">
										<div id="pricePrivateDisplay<?php echo $row['id'];?>" onclick="ableUpdate('<?php echo $row['id'];?>','pricePrivate')">$ <?php echo number_format($row['pricePrivate'],2,",","."); ?></div>
										<input id="pricePrivateInput<?php echo $row['id'];?>" onchange="update('product','<?php echo $row['id'];?>','pricePrivate','2')" onblur="update('product','<?php echo $row['id'];?>','pricePrivate','2')" type="number" class="form-control" style="display: none; text-align: right; padding: 1px;" value=<?php echo $row['pricePrivate']; ?> min=0 step=0.01>
									  </td>
									  <td class="text-center">
										<div class="item-action dropdown">
										  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
										  <div class="dropdown-menu dropdown-menu-right">
											<a href="productsList.php?formStatus=view&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> <?php echo $_SESSION['language']['Edit product'];?></a>
											<a href="productFeature.php?formStatus=create&tableStatus=view&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-eye"></i> <?php echo $_SESSION['language']['See features'];?></a>
											<!--<a href="productsListUpdate.php?formStatus=delete&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-x"></i> <?php echo $_SESSION['language']['Delete'];?></a>-->
											<a href="javascript:void(0)" onclick="remove('<?php echo $row['id']; ?>')" class="dropdown-item"><i class="dropdown-icon fe fe-x"></i> <?php echo $_SESSION['language']['Delete'];?></a>
										  </div>
										</div>
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
        data: {productId:productId, market:market, action:"market"},
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

function remove(productId){							

var check = document.getElementById(productId).checked;

var response = confirm("<?php echo $_SESSION['language']['Remove']; ?> <?php echo $_SESSION['language']['Product']; ?>");
if (response == true) {

	$.ajax({
        url: '../webservice/products.php',
        type: 'GET',
        data: {productId:productId, action:"remove"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			document.getElementById("tableRow"+productId).style.display = "none";
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede agregar el producto");
		console.log(data); // Inspect this in your console
    }  
    });

} 

}

function ableUpdate(id,variable){							

	document.getElementById(variable+'Display'+id).style.display = 'none';
	document.getElementById(variable+'Input'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).focus();
	
}

function update(table, id, variable, type){							

var value = document.getElementById(variable+"Input"+id).value;

if (isNaN(value)){
	document.getElementById(variable+'Display'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).style.display = 'none';
} else { 
	var val = Number(value);
	val.toFixed(2);
	document.getElementById(variable+'Display'+id).innerHTML = val;
	document.getElementById(variable+'Display'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).style.display = 'none';
}

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


															