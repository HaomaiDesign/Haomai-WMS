					 <div class="col-12">
						<div class="card">
							<div class="card-status card-status-left bg-teal"></div>
							<div class="card-header">
								<h3 class="card-title" style="font-weight:bold;">
								<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp
								<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='productsList.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit product']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
								</h3>
							
							<?php if ($_GET['tableStatus']=='view') { ?>
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
								
							  </div>
							  
							  <?php } ?>
							</div>
							
							
							  <?php if ($_GET['tableStatus']=='view') { ?>
							
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
									  <th class="text-center" style="width:5%;font-weight:bold;"> #</th>	
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['SKU'];?></th>
									  <!--<th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Image'];?></th>-->
									  
									  
									  <th style="width:35%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>
									  <th class="text-center" style="width:15%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?></th>
									  <th class="text-center" style="width:10%;font-weight:bold;"><?php if ($_SESSION['user']['companyGroup']=='tich') echo "上货架贩卖品"; else echo $_SESSION['language']['Group']." 1";?></th>
									  <th class="text-center" style="width:10%;font-weight:bold;"><?php if ($_SESSION['user']['companyGroup']=='tich') echo "特价处理"; else echo $_SESSION['language']['Group']." 2";?></th>	
									  <th class="text-center" style="width:10%;font-weight:bold;"><?php if ($_SESSION['user']['companyGroup']=='tich') echo "新货上架"; else echo $_SESSION['language']['Group']." 3";?></th>	
									  <th class="text-center" style="width:10%;font-weight:bold;"><?php if ($_SESSION['user']['companyGroup']=='tich') echo "即将上架"; else echo $_SESSION['language']['Group']." 4";?></th>	
									  
									</tr>
								  </thead>
								  <tbody>
									
									
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
								  
									<?php
									
									$sql = "SELECT * FROM product WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1 ORDER BY sortId ASC;"; 
									$stmt = mysqli_query( $conn, $sql);  
									
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
							
									
									?>
									
									<tr id="productLine<?php echo $row['id'];?>">
									  <td class="text-center"  onclick="selected(<?php echo "'".$row['id']."', '".$_SESSION['user']['companyId']."', '".$row['sortId']."'"; ?>)" onMouseOver="this.style.cursor='move'">
										<i class="fe fe-move"></i>
									  </td>
									  <td class="text-center" onclick="ableUpdate('<?php echo $row['id'];?>','sortId')">
									    <div id="sortIdDisplay<?php echo $row['id'];?>"><?php echo $row['sortId']; ?></div>
										<input id="sortIdInput<?php echo $row['id'];?>" onchange="sortProduct(<?php echo "'".$row['id']."', '".$_SESSION['user']['companyId']."', '".$row['sortId']."'"; ?>)" onblur="sortProduct(<?php echo "'".$row['id']."', '".$_SESSION['user']['companyId']."', '".$row['sortId']."'"; ?>)" type="number" class="form-control" style="display: none; text-align: center; padding: 1px;" min=1 step=1>
									  
									   
									  </td>
									  <td>
										<div><?php echo $row['sku']; ?></div>
										<div class="small text-muted">
										  <?php echo $row['code']; ?>
										</div>
									  </td>
									  <!--
									  <td class="text-center">
										<div><img src="<?php echo $row['image'];?>" height="50px" class="d-inline-block align-top mr-3" alt=""></div>
									  </td>
									  -->
									  <td>
										
										<div><a onclick="window.location.href='productsList.php?formStatus=view&id=<?php echo $row['id']; ?>'" style="cursor: pointer;"><?php if (strlen($row['name'])>50) echo substr($row['name'],0,50)."..."; else echo $row['name']; ?></a></div>
										<div class="small text-muted">
										 <?php if (strlen($row['subtitle'])>50) echo substr($row['subtitle'],0,50)."..."; else echo $row['subtitle']; ?>
										</div>
									  </td>
									  <td class="text-center"  onclick="ableUpdate('<?php echo $row['id'];?>','category')">
									  
										  <div id="categoryDisplay<?php echo $row['id'];?>"><?php echo $row['category']; ?></div>
										  <input  id="categoryInput<?php echo $row['id'];?>" onchange="update('product','<?php echo $row['id'];?>','category','1')" onblur="update('product','<?php echo $row['id'];?>','category','1')" style="width: 150px; display: none;" type="text" name="category" class="form-control" list="category" value="<?php echo $row['category']; ?>">
										  
										
									  </td>

									  <td class="text-center">
										  <label class="custom-switch">
											<input id="flagGroup1<?php echo $row['id'];?>" onchange="group(<?php echo "'".$row['id']."', 'flagGroup1'"; ?>)" type="checkbox" class="custom-switch-input"<?php if ($row['flagGroup1']==1) echo " checked";?>>
											<span class="custom-switch-indicator"></span>
										</label>	
									  </td>
									  <td class="text-center">
										  <label class="custom-switch">
											<input id="flagGroup2<?php echo $row['id'];?>" onchange="group(<?php echo "'".$row['id']."', 'flagGroup2'"; ?>)" type="checkbox" class="custom-switch-input"<?php if ($row['flagGroup2']==1) echo " checked";?>>
											<span class="custom-switch-indicator"></span>
										  </label>
									  </td>
									  <td class="text-center">
										  <label class="custom-switch">
											<input id="flagGroup3<?php echo $row['id'];?>" onchange="group(<?php echo "'".$row['id']."', 'flagGroup3'"; ?>)" type="checkbox" class="custom-switch-input"<?php if ($row['flagGroup3']==1) echo " checked";?>>
											<span class="custom-switch-indicator"></span>
										  </label>
									  </td>
									  <td class="text-center">
										  <label class="custom-switch">
											<input id="flagGroup4<?php echo $row['id'];?>" onchange="group(<?php echo "'".$row['id']."', 'flagGroup4'"; ?>)" type="checkbox" class="custom-switch-input"<?php if ($row['flagGroup4']==1) echo " checked";?>>
											<span class="custom-switch-indicator"></span>
										  </label>
									  </td>
									  
									  
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
							
							<div id="loading"></div>
							<input id="productSelected" type="hidden" value="">
							<input id="sortSelected" type="hidden" value="">
							
							
							</div>
  </div>
  
<script>

function selected(productId, companyId, sortId){

var color = "azure";
var productSelected = document.getElementById('productSelected').value;

if (productSelected=='') {
	document.getElementById('productLine'+productId).style.backgroundColor = color;
	document.getElementById('table').style.cursor = "move";
	document.getElementById('productSelected').value = productId;
	document.getElementById('sortSelected').value = sortId;
} 
else
{
	if (productSelected==productId) {
		document.getElementById('productLine'+productId).style.backgroundColor = "white";
		document.getElementById('table').style.cursor = "default";
		document.getElementById('productSelected').value = "";
		document.getElementById('sortSelected').value = "";
	}
	else
	{
		var oldSortValue = document.getElementById('sortSelected').value;
		var sortValue = sortId;
		var productId = productSelected;
		
		oldSortValue = parseInt(oldSortValue);
		sortValue = parseInt(sortValue);
		
	
			$('#loading').modal({
			backdrop: 'static',
			keyboard: false
			})

	
			$.ajax({
				url: '../webservice/products.php',
				type: 'GET',
				data: {productId:productId, sortValue:sortValue, oldSortValue:oldSortValue, companyId:companyId, action:"sort"},
				success: function(data) {
					toastr.options.positionClass = "toast-top-left";
					console.log(data); // Inspect this in your console
					location.reload();
				},
				error: function(data) { 
				toastr.options.positionClass = "toast-top-left";
				toastr.error("No se puede agregar el producto");
				console.log(data); // Inspect this in your console
			}  
			});
		
	
		
		
	}

}

}


function sortProduct(productId, companyId, oldSortValue){							

var sortValue = document.getElementById('sortIdInput'+productId).value;

if (sortValue=='') {
	
	document.getElementById('sortIdDisplay'+productId).style.display = 'inline';
	document.getElementById('sortIdInput'+productId).style.display = 'none';
	
}
else 
{
	

	$('#loading').modal({
    backdrop: 'static',
    keyboard: false
	})
 

    $.ajax({
        url: '../webservice/products.php',
        type: 'GET',
        data: {productId:productId, sortValue:sortValue, oldSortValue:oldSortValue, companyId:companyId, action:"sort"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			console.log(data); // Inspect this in your console
			location.reload();
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se puede agregar el producto");
		console.log(data); // Inspect this in your console
    }  
    });
	
}

}

function group(productId, variable){							

var check = document.getElementById(variable+productId).checked;

if (check==false) {
  var value = 0;
} else {
  var value = 1;
}

    $.ajax({
        url: '../webservice/products.php',
        type: 'GET',
        data: {productId:productId, variable:variable, value:value, action:"group"},
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
/*
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
*/
	
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







}


</script>	

															