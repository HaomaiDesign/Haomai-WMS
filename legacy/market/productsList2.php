<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>
<?php include "../system/notification.php"; ?>



<?php
//Armado logica del paginado

	if (empty($_GET['page'])) { $_GET['page'] = 1;}

	if ($_GET['target']=="sale") {
		if ($_GET['search']!=""){
			$target = "((companyId=".$_SESSION['user']['companyId'].") AND (name LIKE '%".$_GET['search']."%'))";
			$pageUrl = "productsList2.php?tableStatus=view&target=sale";
			if(isset($_GET['sel_flag'])) $pageUrl .="&sel_flag=" .$_GET['sel_flag'];
			$pageUrl .= "&search=".$_GET['search']."&page=";
		}
			
		else {
			$target = "companyId=".$_SESSION['user']['companyId'];
			$pageUrl = "productsList2.php?tableStatus=view&target=sale";
			if(isset($_GET['sel_flag'])) $pageUrl .="&sel_flag=" .$_GET['sel_flag'];			
			$pageUrl .= "&page=";
		}
	
		if($_GET['sel_flag'] == 'active'){
			$target .=" AND flagMarket = 1 ";
		}
		if($_GET['sel_flag'] == 'inactive'){
			$target .=" AND flagMarket = 0 ";
		}
		
	}
	
	$sql0 = "SELECT COUNT(*) AS rowNum FROM product WHERE ".$target.";";
	//echo $sql0;
	$stmt0= mysqli_query( $conn, $sql0); 
		
	if ( $stmt0 ) {
	$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );  
	$totalItem = $row0['rowNum'];
	$limit = 10;

	$totalPage = intdiv($totalItem, $limit);

	if ($totalItem%$limit!=0) $totalPage = $totalPage + 1;

	if ($totalItem!=""){
		
	$min = $totalItem - $limit * $_GET['page'];
	$max = $totalItem - $limit * $_GET['page'] + $limit;	
		
	if ($min<0) $min = 0;

	}
	else {
		$min = 0;
		$max = 0;	
		
	}
	}
	?>

<?php unset($_SESSION['form']); ?>
<!-- Start content-->
<div class="col-12">
	<?php if ($_GET['tableStatus']=='view') { ?>
	<div class="card">
		<div class="card-status card-status-left bg-teal"></div>
		<div class="card-header">
			
			<div class="tags">
								
			  <span class="tag<?php if ($_GET['market']=="") echo " tag-success"; ?>">
				<a href="productsList2.php?tableStatus=view&target=sale" class="tag-addon"><?php echo $_SESSION['language']['All']; ?></a>
			  </span>
			  
			  <span class="tag<?php if ($_GET['market']=="retail") echo " tag-success"; ?>">
				<a href="productsList2.php?tableStatus=view&target=sale&market=retail" class="tag-addon"><?php echo $_SESSION['language']['Retail']; ?></a>
			  </span>
			  
			  <span class="tag<?php if ($_GET['market']=="wholesale") echo " tag-success"; ?>">
				<a href="productsList2.php?tableStatus=view&target=sale&market=wholesale" class="tag-addon"><?php echo $_SESSION['language']['Wholesale']; ?></a>
			  </span>
			  
			  <span class="tag<?php if ($_GET['market']=="private") echo " tag-success"; ?>">
				<a href="productsList2.php?tableStatus=view&target=sale&market=private" class="tag-addon"><?php echo $_SESSION['language']['Private']; ?></a>
			  </span>

			  <span class="tag<?php if ($_GET['sel_flag']=="active") echo " tag-success"; ?>">
				<a href="productsList2.php?tableStatus=view&target=sale&market=<?php echo $_GET['market']; ?>&sel_flag=active" class="tag-addon"><?php echo "Activo"; ?></a>
			  </span>
			  
			  <span class="tag<?php if ($_GET['sel_flag']=="inactive") echo " tag-success"; ?>">
				<a href="productsList2.php?tableStatus=view&target=sale&market=<?php echo $_GET['market']; ?>&sel_flag=inactive" class="tag-addon"><?php echo "Inactivo"; ?></a>
			  </span>			  
	
			</div>
						
			<div class="card-options">
				<div class="item-action">
					<form action="productsList2.php" method="get">
						<input type="hidden" name="tableStatus" class="form-control" value="view">
							
						<?php if ($_GET['tableStatus']!="") echo "<input type='hidden' name='tableStatus' class='form-control' value='".$_GET['tableStatus']."'>";?>
						<?php if ($_GET['search']!="") echo "<input type='hidden' name='search' class='form-control' value='".$_GET['search']."'>";?>
						<?php if ($_GET['target']!="") echo "<input type='hidden' name='target' class='form-control' value='".$_GET['target']."'>";?>
						<?php echo "<input type='hidden' name='page' class='form-control' value='1'>";?>
						<input id="search" name="search" value="<?php if ($_GET['search']!="") echo $_GET['search'];?>" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['Search'];?>&hellip;">
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
			<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='productsList2.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
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

				if(isset($_GET['sel_flag'])){
					if($_GET['sel_flag'] == 'active'){
						$sqlCount.=" AND flagMarket = 1 ";
					}
					if($_GET['sel_flag'] == 'inactive'){
						$sqlCount.=" AND flagMarket = 0 ";
					}
				}
				
				$sqlCount.=";";
				
				$stmtCount= mysqli_query( $conn, $sqlCount); 
					
				if ( $stmtCount ) {
				$rowCount = mysqli_fetch_array( $stmtCount, MYSQLI_ASSOC );  
				echo $_SESSION['language']['Total']." ".$rowCount['items']." ".$_SESSION['language']['products'];
				}
			
				?> &nbsp&nbsp&nbsp
			</div>

			<div class="item-action">
				<a href="<?php echo $pageUrl."1";?>"<?php if ($_GET['page']==1) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-double-left"></i></a>
				<a href="<?php echo $pageUrl.($_GET['page']-1);?>"<?php if ($_GET['page']==1) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-left"></i></a>
				<a style="color: black;"><?php echo $_SESSION['language']['Page']." ".$_GET['page']." / ".$totalPage; ?>&nbsp </a> 
				<a href="<?php echo $pageUrl.($_GET['page']+1);?>"<?php if ($_GET['page']==$totalPage) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-right"></i></a>
				<a href="<?php echo $pageUrl.$totalPage;?>"<?php if ($_GET['page']==$totalPage) echo " style='pointer-events: none;'"; else echo " style='color: black;'";?>><i class="fas fa-angle-double-right"></i></a>&nbsp
			</div>
			
		    <div class="item-action dropdown">
			  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-horizontal"></i></a>
			  <div class="dropdown-menu dropdown-menu-right">
				<a href="productsList2.php?formStatus=create" class="dropdown-item"><i class="dropdown-icon fe fe-plus"></i> <font color="black"> <?php echo $_SESSION['language']['Add product'];?></font></a>
				<a href="" onclick="disableSubmit();" data-toggle="modal" data-target="#modalUpdate" class="dropdown-item"><i class="dropdown-icon fe fe-plus"></i> <font color="black"> <?php echo "Importar desde Excel";?></font></a>
				<a href="exportData.php" class="dropdown-item"><i class="dropdown-icon fe fe-plus"></i> <font color="black"> <?php echo "Exportar productos a Excel";?></font></a>
				<!--<a onclick="fnExcelReport()" class="dropdown-item"><i class="dropdown-icon fe fe-log-out"></i> <font color="black"> <?php echo $_SESSION['language']['Export to Excel'];?></font></a>-->
			  </div>
			</div>
		  </div>
		  
		  <?php } ?>
	</div>

	<div id="modalUpdate" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          	<div class="modal-content">
            	<div class="modal-header">
            	  	<h4 class="modal-title">Agregar productos con archivo</h4>
            	</div>

            	<div class="modal-body">
					<!--<?php if (!empty($_GET['success'])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?>-->
					<div class="alert alert-info" role="alert">
  						<p>Seleccione una planilla de <strong> Excel </strong> el cual respete el encolumnado de la página, para actualizar o agregar nuevos productos.</p>
					</div>
					<form class="form" action="importData.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
						<div class="form-row">
							<div class="col">
  								<input type="file" class="custom-file-input" id="excel" name="excel" onchange="updateName()" >
								<label id="fileName" class="custom-file-label" for="file">Elegir Archivo...</label>
								<script>		
									function isCompatible(filename){  //Agregar varios endsWith si admite otros formatos
										return filename.endsWith(".xls") || filename.endsWith(".xlsx") || filename.endsWith(".csv");
									}				

									function disableSubmit(){
										document.getElementById("btn-sbmit").disabled = true;
										document.getElementById("fileName").innerHTML  = "Elegir Archivo...";
										document.getElementById("excel").value = null;
									}

									function updateName(){
										var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
										document.getElementById("fileName").innerHTML  = filename;
										//console.log(filename);
										if(isCompatible(filename)){
											document.getElementById("btn-sbmit").disabled = false;
										} else {
											document.getElementById("btn-sbmit").disabled = true;
										}
									}
								</script>
							</div>
							<div class="col">
  								<div class="input-group-append">
    								<button data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modalLoading" class="btn btn-primary" id="btn-sbmit" type="submit" name="Submit">
									Actualizar Productos
									</button>
  								</div>
							</div>
						</div>
					</form>
            	</div>
           		<div class="modal-footer">
            	  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            	</div>
          	</div>
        </div>
    </div>
	
	<div id="modalLoading" class="modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">
					<div class="alert alert-danger" role="alert">
						<p><strong>Por favor no cerrar el navegador mientras se cargan los productos de su archivo al sistema. </strong></p>
					</div>
					<div class="container">
						<div class="row justify-content-md-center">
							<div class="col-md-auto">
								<div class="loader"></div>
							</div>
							<div class="col-md-auto">
								<h5 style="margin-top:12px">Cargando...</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="modalLog" class="modal" role="dialog">
		<div class="modal-dialog modal-dialog-centered ">
			<div class="modal-content">
				<div class="modal-body">
					<h3 class="text-center"><strong>El (Los) siguiente(s) producto(s) del archivo no se pudieron cargar al sistema:</strong></h3>
					<br>
					<div style="width: 470px;  height: 400px;  overflow: auto;" class="table-responsive">
  						<table class="table table-sm table-striped">
							<tr>
								<th>Code</th><!--Agregar session language-->
								<th>Name</th>
							</tr>
							<?php 
                                 foreach($_SESSION['wrongLines'] as $dataError){
									echo "<tr>
											<td><p style='font-size: 13px'>" . $dataError[0] . "</p></td>
											<td><p style='font-size: 13px'>" . $dataError[1] . "</p></td>
										  </tr>";
                                }
                        	?>
  						</table>
					</div>
					<br>
					<div class="alert alert-info" role="alert">
						<p>Por favor verifique el formato de la linea o los valores ingresados.</p>
					</div>
				</div>
				<div class="modal-footer">
            	  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            	</div>
			</div>
		</div>
	</div>

	<?php if (isset($_SESSION['wrongLines'])){ ?>
		<script>		
			$(document).ready(function(){$('#modalLog').modal();});
    	</script>
		<?php
			unset($_SESSION['wrongLines']);
		} ?>


<?php include "productsListTable.php"; ?>
<?php include "productsListForm.php"; ?>		
</div>
  
<!-- End content-->  
<script>
$(searchTable).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>

<?php include "../system/tableFilters.php"; ?>
<?php include "../system/contentEnd.php"; ?>				
			
