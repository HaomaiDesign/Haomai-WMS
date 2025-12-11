    
	<?php $_SESSION['form']['table']= 'productFeatures';  $_SESSION['form']['quantity'] = -1;?>
	
	<?php
									
	$sql = "SELECT * FROM product WHERE id=".$_GET['id'].";";  
	$stmt = mysqli_query( $conn, $sql);  
	
	if ( $stmt ) {
	while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
	{  
	
	?>
	
	<div class="row">
	
	
	<div class="col-sm-4 col-lg-4">
		<div class="card">
			<div class="card-status card-status-left bg-teal"></div>
		
			  <div class="card-body">
				<div class="mb-4 text-center">
				  <img src="<?php echo $row['image']; ?>" alt="" class="img-fluid">
				</div>
				<h4 class="card-title"><a href="javascript:void(0)"><?php echo $row['name']; ?></a></h4>
				<div class="card-subtitle">
				  <?php echo $row['sku']; ?>
				</div>
				<div class="mt-5 d-flex align-items-center">
				  <div class="product-price">
					<strong>$ 
						<?php 
						if ($_GET['market']=="retail")
							echo number_format($row['priceRetail'],2,",",".");
						
						if ($_GET['market']=="wholesale")
							echo number_format($row['priceWholesale'],2,",","."); 
						?>
					</strong>
				  </div>
				  <div class="ml-auto">
					<?php
						if ($_GET['market']=="retail")
							$marketId=0;
						
						if ($_GET['market']=="wholesale")
							$marketId=1;
					?>
					<a onclick="addCart(<?php echo "'".$marketId."','".$row['id']."','".$_SESSION['user']['id']."', '".$row['name']."'"; ?>)" class="btn btn-primary"><i class="fe fe-shopping-cart"></i> <?php echo $_SESSION['language']['Add to Cart'];?></a>
				  </div>
				</div>
          
	
			</div>
		</div>
	</div>
	
	<div class="col-sm-8 col-lg-8">
		<div class="card">
			<div class="card-status card-status-left bg-teal"></div>
			<?php if ($_GET['tableStatus']=='view') { ?>
								
							  <div class="table-responsive">
								<table id="table" class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <th style="width:30%;font-weight:bold;"> <?php echo "<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?> <?php echo $_SESSION['language']['Information'];?></th>
								  <th style="width:70%;font-weight:bold;"> </th> 
								  <tbody>
									<tr>
									  <td>
										<div><strong><?php echo $_SESSION['language']['Short Description'];?></strong></div>
									  </td>
									  <td>
										<div><?php echo $row['subtitle']; ?></div>
									  </td>
									</tr>
									<tr>
									  <td>
										<div><strong><?php echo $_SESSION['language']['Category'];?></strong></div>
									  </td>
									  <td>
										<div><?php echo $row['category']; ?></div>
									  </td>
									</tr>
									<tr>
									  <td>
										<div><strong><?php echo $_SESSION['language']['Brand'];?></strong></div>
									  </td>
									  <td>
										<div><?php echo $row['brand']; ?></div>
									  </td>
									</tr>
									
									
									<?php
								
									$sql1 = "SELECT * FROM productFeatures WHERE productId=".$_GET['id']." ORDER BY property ASC;";  
									$stmt1 = mysqli_query( $conn, $sql1);  
									
									if ( $stmt1 ) {
									while( $row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC ))  
									{  
									
									?>
									
									<tr>
									  <td>
										<div><strong><?php if ($_SESSION['language'][$row1['property']]!="") echo $_SESSION['language'][$row1['property']]; else echo $row1['property']; ?></strong></div>
									  </td>
									  <td>
										<div><?php if ($_SESSION['language'][$row1['value']]!="") echo $_SESSION['language'][$row1['value']]; else echo $row1['value']; ?></div>
									  </td>
									</tr>
									<?php }; }; ?>
									
									<tr>
									  <td>
										<div><strong><?php echo $_SESSION['language']['Description'];?></strong></div>
									  </td>
									  <td>
										<div><?php echo $row['description']; ?></div>
									  </td>
									</tr>
								  </tbody>
								  
								</table>
								
							  </div>
							  
									<?php }; ?>
									
			</form>
		</div>
	</div>
	
	</div>
	
	<?php }; }; ?>

<script>
function showHint(str,id,idtxt) {
			
    if (str == "addNewFeature") { 
           document.getElementById(id).setAttribute("type", "text");
		   document.getElementById(id).setAttribute("value", "");
		   document.getElementById(idtxt).style.display = "inline";

    } else {
          document.getElementById(id).setAttribute("type", "hidden");
		  document.getElementById(id).setAttribute("value", str);
		  document.getElementById(idtxt).style.display = "none";
			
    }
}
</script>	  
<script>	
function addCart(market, productId, userId, productName){							

    $.ajax({
        url: '../webservice/cart.php',
        type: 'GET',
        data: {productId:productId, userId:userId, quantity:1, market:market, action:"add"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			toastr.success("Producto agregado: 1 - "+productName);
			//document.getElementById("countCart").innerHTML = <?php $countCart+=1; echo $countCart;?>;
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