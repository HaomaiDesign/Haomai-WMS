					<?php
					
					
					$target = "companyId=".$_SESSION['user']['companyId']." AND status<6";
					$pageUrl = "report.php?tableStatus=view&page=";
					
					
					$sql0 = "SELECT COUNT(DISTINCT(date)) AS rowNum FROM swrOrder ".$target.";";  
					$stmt0= mysqli_query( $conn, $sql0); 
						
					if ( $stmt0 ) {
					$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );  
					$totalItem = $row0['rowNum'];
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
					
					
					<div class="row">
						<?php if ($_GET['tableStatus']=='view') { ?>
						
						<div class="col-md-6 col-xs-12">
						
						
						<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<?php echo $_SESSION['language']['Annual Report']; ?>
									</h3>
								
								</div>

								
								  <div class="table-responsive">
									<table id="table2" class="table table-hover table-outline table-vcenter text-truncate card-table">
									  <thead>
										<tr>
										 
										
										  <th class="text-left" style="width:40%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Year'];?></th>
										  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Orders'];?> </th>
										  <th class="text-right" style="width:50%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Amount'];?> </th>	
										
										 
										</tr>
									  </thead>
									  <tbody>
										
										
										<?php
										
										$sql3 = "SELECT YEAR(date) as year, SUM(quantity) AS yearQuantity, SUM(dailyPrice) AS yearPrice FROM (SELECT date, companyId, COUNT(requestId) as quantity, SUM(price) AS dailyPrice FROM ( SELECT id, requestId, date, companyId, SUM(itemPrice) AS price, status FROM swrViewOrderList WHERE ".$target." GROUP BY id, requestId, date, companyId, status) as auxTab GROUP BY date, companyId) AS auxTab2 GROUP BY YEAR(date) ORDER BY YEAR(date) DESC;";  
										$stmt3 = mysqli_query( $conn, $sql3);  
										
										
										if ( $stmt3 ) {
										while( $row3 = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC ))  
										{  
							
										
										?>
										
										<tr>
										  
										  
										  <td class="text-left">
											<div><?php echo $row3['year']; ?></div>
										  </td>
										  <td class="text-center">
											<div><?php echo $row3['yearQuantity']; ?></div>
										  </td>
										  <td class="text-right" >
											<div><font color="green"><?php echo "$ ".number_format($row3['yearPrice'],2,",","."); ?></font></div>
										  </td>
										  
										</tr>
										<?php }; ?>
									
									 </tbody>
									</table>
								  </div>
								  
										<?php }; ?>
								
									</div>
									
									
									
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<?php echo $_SESSION['language']['Monthly Report']; ?>
									</h3>
									
								</div>

								
								  <div class="table-responsive">
									<table id="table2" class="table table-hover table-outline table-vcenter text-truncate card-table">
									  <thead>
										<tr>
										 
										
										  <th class="text-left" style="width:40%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Month'];?></th>
										  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Orders'];?> </th>
										  <th class="text-right" style="width:50%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Amount'];?> </th>	
										
										 
										</tr>
									  </thead>
									  <tbody>
										
										
										<?php
										
										$sql2 = "SELECT YEAR(date) as year, MONTH(date) as month, SUM(quantity) AS monthQuantity, SUM(dailyPrice) AS monthPrice FROM (SELECT date, companyId, COUNT(requestId) as quantity, SUM(price) AS dailyPrice FROM ( SELECT id, requestId, date, companyId, SUM(itemPrice) AS price, status FROM swrViewOrderList WHERE ".$target." GROUP BY id, requestId, date, companyId, status) as auxTab GROUP BY date, companyId) AS auxTab2 GROUP BY YEAR(date), MONTH(date) ORDER BY YEAR(date) DESC, MONTH(date) DESC;";  
										$stmt2 = mysqli_query( $conn, $sql2);  
										
										
										if ( $stmt2 ) {
										while( $row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC ))  
										{  
							
										
										?>
										
										<tr>
										  
										  
										  <td class="text-left">
											<div><?php echo $row2['year']."-".$row2['month']; ?></div>
										  </td>
										  <td class="text-center">
											<div><?php echo $row2['monthQuantity']; ?></div>
										  </td>
										  <td class="text-right" >
											<div><font color="green"><?php echo "$ ".number_format($row2['monthPrice'],2,",","."); ?></font></div>
										  </td>
										  
										</tr>
										<?php }; ?>
									
									 </tbody>
									</table>
								  </div>
								  
										<?php }; ?>
								
									</div>
									
							
									
							</div>	
							
						<div class="col-md-6 col-xs-12">
							<div class="card">
								<div class="card-status card-status-left bg-teal"></div>
								<div class="card-header">
									<h3 class="card-title" style="font-weight:bold;">
									<?php echo $_SESSION['language']['Daily Report']; ?>
									</h3>
									
								</div>

								
								  <div class="table-responsive">
									<table id="table" class="table table-hover table-outline table-vcenter text-truncate card-table">
									  <thead>
										<tr>
										 
										
										  <th class="text-left" style="width:40%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Date'];?></th>
										  <th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Orders'];?> </th>
										  <th class="text-right" style="width:50%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['Amount'];?> </th>	
										
										 
										</tr>
									  </thead>
									  <tbody>
										
										
										<?php
										//$sql = "SELECT id, requestId, date, time, userId, companyId, businessName, roleId, fullName, userEmail, companyEmail, COUNT(productId) AS item, SUM(quantity) AS quantity, SUM(itemPrice) AS price, currency, status FROM  ORDER BY id DESC;";  
										
										//$sql = "SELECT * FROM (SELECT id, companyId, userId, sequenceId, type, datetime, account, documentId, currency, amount, description, ROW_NUMBER() OVER (ORDER BY datetime ASC) as row FROM fncTreasury WHERE companyId=".$_SESSION['user']['companyId'].") as alias WHERE row>".$min." and row<=".$max." ORDER BY row DESC;";  
										//$sql = "SELECT * FROM (SELECT id, companyId, userId, sequenceId, type, datetime, account, documentId, currency, amount, description, ROW_NUMBER() OVER (ORDER BY datetime ASC) as row FROM fncTreasury WHERE companyId=".$_SESSION['user']['companyId'].") as alias  ORDER BY row DESC;";  
										$sql = "SELECT TOP 365 date, companyId, COUNT(requestId) as quantity, SUM(price) AS dailyPrice FROM ( SELECT id, requestId, date, companyId, SUM(itemPrice) AS price, status FROM swrViewOrderList WHERE ".$target." GROUP BY id, requestId, date, companyId, status) as auxTab GROUP BY date, companyId ORDER BY date DESC;";  
									
										
										$stmt = mysqli_query( $conn, $sql);  
										
										
										if ( $stmt ) {
										while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC ))  
										{  
							
										
										?>
										
										<tr>
										  
										  
										  <td class="text-left">
											<div><?php echo $row['date']->format('Y-m-d'); ?></div>
										  </td>
										  <td class="text-center">
											<div><?php echo $row['quantity']; ?></div>
										  </td>
										  <td class="text-right" >
											<div><font color="green"><?php echo "$ ".number_format($row['dailyPrice'],2,",","."); ?></font></div>
										  </td>
										  
										</tr>
										<?php }; ?>
									
									 </tbody>
									</table>
								  </div>
								  
									<?php }}; ?>
								
									</div>
							</div>	
							
							
							
							
							
							
							
						</div>
<div id="loading"></div>							

<script>	




function selectCheck(id){							

var result = document.getElementById(id);

if ( result.checked == true) {
	var selected = 1;
} else {
	var selected = 0;
}

    $.ajax({
        url: 'orderUpdate.php',
        type: 'GET',
        data: {id:id, selected:selected, action:"select"},
        success: function(data) {
			//toastr.success(id+selected);
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function clearCheck(){							

    $.ajax({
        url: 'orderUpdate.php',
        type: 'GET',
        data: {action:"clear"},
        success: function(data) {
			//toastr.success(id+selected);
			location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function assign(companyId){							

var deliveryUserId = document.getElementById("deliveryUser").value;

    $.ajax({
        url: 'orderUpdate.php',
        type: 'GET',
        data: {companyId:companyId, deliveryUserId:deliveryUserId, action:"assign"},
        success: function(data) {
			toastr.success(companyId+deliveryUserId);
			location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo actualizar");
		console.log(data); // Inspect this in your console
    }  
    });

}

function statusUpdate(statusId, newStatus, companyId, userId){							

    $.ajax({
        url: 'orderUpdate.php',
        type: 'GET',
        data: {statusId:statusId, newStatus:newStatus, companyId:companyId, userId:userId, action:"update"},
        success: function(data) {
			toastr.options.positionClass = "toast-top-left";
			location.reload();
			console.log(data); // Inspect this in your console
        },
		error: function(data) { 
		toastr.options.positionClass = "toast-top-left";
        toastr.error("No se pudo modificar");
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
var bypass = true;
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

if (variable=='expense'){
	if (value<0) {
		bypass = false;
	}
	if (value>0) {
		value = value * -1;
	}
	
	variable = 'amount';
	
}

if (variable=='income'){
	variable = 'amount';
	if (value<0) {
		bypass = false;
	}
}



$('#loading').modal({
    backdrop: 'static',
    keyboard: false
})


if (bypass==true) {
// type 1 =  string // type 2 = number

    $.ajax({
        url: '../webservice/update.php',
        type: 'GET',
        data: {table:table, id:id, variable:variable, value:value, type:type, action:"update"},
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
	
	if (variable=='account'){
	
	var amount = document.getElementById("amount"+id).value;
	
	if (value=='Cancelled') {
		newValue = 0;
	}	
	if (value=='Expenses') {
		newValue = 1;
	}
	if (value=='Profits') {
		newValue = 2;
	}
	if (value=='Costs') {
		newValue = 3;
	}
	if (value=='Sales') {
		newValue = 4;
	}
	
	if (amount>=0){
		if ((value=='Costs')||(value=='Expenses')){
			value = amount * -1;
		}
		if ((value=='Sales')||(value=='Profits')){
			value = amount;
		}
		if (value=='Cancelled') {
			value = 0;
		}	
	}
	
	if (amount<0){
		if ((value=='Costs')||(value=='Expenses')){
			value = amount;
		}
		if ((value=='Sales')||(value=='Profits')){
			value = amount * -1;
		}
		if (value=='Cancelled') {
			value = 0;
		}	
	}


	
	variable = "amount";
	type = 2;
	
	
	
	$.ajax({
	url: '../webservice/update.php',
	type: 'GET',
	data: {table:table, id:id, variable:variable, value:value, type:type, action:"update"},
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
	
	
	variable = "type";

	
	$.ajax({
	url: '../webservice/update.php',
	type: 'GET',
	data: {table:table, id:id, variable:variable, value:newValue, type:type, action:"update"},
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

};
	
};


location.reload();
}

function remove(table, id, variable, value){							

//if (confirm("Desea eliminar el registro con el valor $ "+value)) {
/*
$('#loading').modal({
    backdrop: 'static',
    keyboard: false
})

*/
    $.ajax({
        url: '../webservice/update.php',
        type: 'GET',
        data: {table:table, id:id, variable:variable, value:value, action:"remove"},
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

//}
	
}
</script>																