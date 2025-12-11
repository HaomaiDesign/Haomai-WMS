    
	<?php $_SESSION['form']['table']= 'productFeatures';  $_SESSION['form']['quantity'] = -1;?>
	<div class="row">
	<div class="col-sm-8 col-lg-8">
		<div class="card">
			<div class="card-status card-status-left bg-teal"></div>
			<?php include "productFeatureTable.php"; ?>
	
		</div>
	</div>
	<div class="col-sm-4 col-lg-4">
		<div class="card">
			<div class="card-status card-status-left bg-teal"></div>
			<div class="card-header">
				<h3 class="card-title" style="font-weight:bold;">
				<?php if ($_GET['formStatus']=='create') echo $_SESSION['language']['Add feature']; ?>
				</h3>
			</div>
			<div class="card-body">
				<form action="productFeatureUpdate.php?formStatus=create&tableStatus=view&id=<?php echo $_GET['id'];?>" method="post" enctype="multipart/form-data">
					<div class="row">
						<?php 
						
						$sql1 = "SELECT * FROM swrCategory WHERE name='Feature' ORDER BY value ASC";  
						$stmt1 = mysqli_query( $conn, $sql1);  
						
						?>
						
						<div class="col-sm-12 col-md-12">
						
							<?php
							if ($_GET['formStatus']=='create')
							{	
							echo "<input type='hidden' name='productId' class='form-control' value=".$_GET['id'].">";
							$_SESSION['form']['data'][]='productId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
							}
							?>
							
							<div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Features'];?></label>
							<select name="category" id="select-category" onchange="showHint(this.value,'property','newFeatureText')" class="form-control custom-select">
							<option selected disabled><?php echo $_SESSION['language']['Select an option'];?></option>
							<option disabled>----------------</option>
							<?php 
							if ( $stmt1 ) {
							while( $row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC))  
							{
								echo "<option value='".$row1['value']."'>";
								if ($_SESSION['language'][$row1['value']]!="") echo $_SESSION['language'][$row1['value']]; else echo $row1['value'];
								echo "</option>";	
							}
							}
							?>
							<option value="addNewFeature">+ <?php echo $_SESSION['language']['New feature'];?></option>
							</select>
						  </div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label id="newFeatureText" class="form-label" style="display: none;"><?php echo $_SESSION['language']['New feature'];?></label>
								<input id="property" name="property" type="hidden" class="form-control" placeholder="<?php echo $_SESSION['language']['New feature'];?>" tabindex="1">
								<?php $_SESSION['form']['data'][]='property'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label"><?php echo $_SESSION['language']['Value'];?></label>
								<input id="value" name="value" type="text" class="form-control" placeholder="<?php echo $_SESSION['language']['Value'];?>" tabindex="1">
								<?php $_SESSION['form']['data'][]='value'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
							</div>
						</div>
						
						
					</div>
				
			</div>
			<div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"><?php if ($_GET['formStatus']=='create') echo $_SESSION['language']['Add feature'];?></button>
            </div>
			</form>
		</div>
	</div>
	
</div>

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