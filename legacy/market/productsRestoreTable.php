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
								<a href='productsList.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp
								<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Products List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit product']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create product']; ?>
								</h3>
							
							<?php if ($_GET['tableStatus']=='view') { ?>
							<div class="card-options">
								<div class="item-action">
									<?php 
									
									$sqlCount = "SELECT COUNT(*) AS items FROM product WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=1;";  
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
									  <th class="text-center" style="width:5%;font-weight:bold;"> <?php echo $_SESSION['language']['Market'];?></th>	
									  <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['SKU'];?></th>
									  <!--<th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Image'];?></th>-->
									  <th style="width:30%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>
									  <th style="width:30%;font-weight:bold;"><?php echo $_SESSION['language']['Short Description'];?></th>
									  <th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Unit/Pack'];?></th>
									  <th class="text-right" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Retail'];?> ($)</th>	
									  <th class="text-right" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Wholesale'];?> ($)</th>
									  
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									$sql = "SELECT * FROM product WHERE companyId=".$_SESSION['user']['companyId']." AND flagActive=0 ORDER BY id DESC;"; 
									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  <td class="text-center">
									  <label class="custom-switch">
										<input id="restore<?php echo $row['id'];?>" onchange="active(<?php echo "'".$row['id']."'"; ?>)" type="checkbox" class="custom-switch-input"<?php if ($row['flagActive']==1) echo " checked";?>>
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
									 
									  <td>										
										<div><?php if (strlen($row['name'])>40) echo substr($row['name'],0,40)."..."; else echo $row['name']; ?></div>
									  </td>
									  <td>										
										<div><?php if (strlen($row['subtitle'])>40) echo substr($row['subtitle'],0,40)."..."; else echo $row['subtitle']; ?></div>
									  </td>
									  <td class="text-center">
										<div><?php echo $row['packWholesale']; ?></div>
									  </td>
									  
									  <td class="text-right">
										<div id="priceRetailDisplay<?php echo $row['id'];?>">$ <?php echo number_format($row['priceRetail'],2,",","."); ?></div>
										
									  </td>
									  <td class="text-right">
										<div id="priceWholesaleDisplay<?php echo $row['id'];?>">$ <?php echo number_format($row['priceWholesale'],2,",","."); ?></div>
										
									  </td>						
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
							
							<div id="loading"></div>
							

						</div>
					  </div>
						
<script>	
function active(productId){							

var check = document.getElementById("restore"+productId).checked;

if (check==false) {
  var active = 0;
} else {
  var active = 1;
}

    $.ajax({
        url: '../webservice/products.php',
        type: 'GET',
        data: {productId:productId, active:active, action:"active"},
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

if (isNaN(value)){
	document.getElementById(variable+'Display'+id).style.display = 'inline';
	document.getElementById(variable+'Input'+id).style.display = 'none';
} else { 
	var val = Number(value);
	val.toFixed(2);
	document.getElementById(variable+'Display'+id).innerHTML = '$ '+val;
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


															