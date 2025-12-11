<?php include "../system/session.php";?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" type="text/css" href="../assets/css/adminx.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/toastr.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/all.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<style type="text/css">

  table { overflow: visible !important; page-break-after:auto }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }


@media print {
    .export-table {
        overflow: visible !important;
    }
}
</style>

    </head>

    <body>

		<!--<div class='page'>-->
		<div>
		<div class="container">
			<div class="card" style="border: 1px solid gray;">
				<div class="card-body" style="padding: 10px; padding-bottom: 0px;">
					<div class="row">
						<div class="col" style="text-align: center; padding: 25px;">

							<strong>RESUMEN DE PRODUCTOS POR CATEGORIA</strong><br>

							<strong><?php echo $_SESSION['language']['Category'];?>: </strong><?php echo $_GET["reportCat"];?>

							<!--
							<img src="<?php echo $row["logo"]?>" style="height: 50px; width: auto; margin: 0px; padding: 0px;">

							<p style="font-size: 10pt;">
								<strong><?php echo $row["businessName"]; ?></strong><br>
								<?php if (($row["address"]!="")AND($row["location"]!="")) echo $row["address"]." ".$row["location"]."<br>"; ?>
								<?php if ($row["phone"]!="") echo "TEL: ".$row["phone"]; ?>
							</p>
							-->

						</div>
						<br>
						<div class="col" style="text-align: center; padding: 25px;">

							<strong><?php echo $_SESSION['language']['Date'];?>: </strong><?php


// Return current date from the remote server
$date = date('Y-m-d');
echo $date;
?><br>

							<?php if ($_GET['search']!="") echo "<strong>".$_SESSION['language']['Search'].": </strong> ".$_GET["search"];?>

						</div>

					</div>
				</div>
				</div>
                <!-- php code para provedor-->
				<div class="card" style="border: 1px solid gray;">
				<div id="infinite" class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">

						<!-- <table class="table table-sm">


							<tbody id="infinite" style="font-size: 10pt; padding-top: 0px"> -->


								<!-- <th>
									<td class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></td>
									<td class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></td>
									<td class="text-left" style="width:50%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></td>
									<td class="text-center" style="width:10%;font-weight:bold; text-align: center;"><?php echo $_SESSION['language']['Category'];?></td>
									<td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Capacity']."/".$_SESSION['language']['Unit'];?></td>
									<td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></td>
								</th> -->


								<!-- <div id="infinite"></div> -->

								<!-- <?php

									// if ($_GET['reportCat']!="ALL")
									// $sql = "SELECT stockLogs.productId, products.unitbarcode, products.image, products.dueDate, products.category, products.capacity, products.unit, products.name, sum(stockLogs.stock) AS stock 
									// 		FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId
									// 		WHERE products.flagActive = 1
									// 		AND products.category = '".$_GET['reportCat']."'
									// 		GROUP BY products.unitbarcode
									// 		ORDER BY products.name DESC;";

									// if ($_GET['reportCat']=="ALL")
									// $sql = "SELECT stockLogs.productId, products.unitbarcode, products.image, products.dueDate, products.category, products.capacity, products.unit, products.name, sum(stockLogs.stock) AS stock 
									// 		FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
									// 		WHERE products.flagActive = 1
									// 		GROUP BY products.unitbarcode
									// 		ORDER BY products.category, products.name DESC;";

									// if ($_GET['reportCat']=="EMPTY")
									// $sql = "SELECT stockLogs.productId, products.unitbarcode, products.image, products.dueDate, products.category, products.capacity, products.unit, products.name, sum(stockLogs.stock) AS stock
									// 		FROM products   LEFT JOIN stockLogs  ON products.id=stockLogs.productId
									// 		WHERE products.flagActive = 1
									// 		AND products.category = ''
									// 		GROUP BY products.unitbarcode
									// 		ORDER BY products.category, products.name DESC;";

									// if ($_GET['search']!="")
									// $sql = "SELECT stockLogs.productId, products.unitbarcode, products.image, products.dueDate, products.category, products.capacity, products.unit, products.name, sum(stockLogs.stock) AS stock
									// 		FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId
									// 		WHERE products.flagActive = 1
									// 		AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )
									// 		GROUP BY products.id
									// 		ORDER BY products.name DESC;";


									// $stmtProduct = mysqli_query( $conn,$sql);

									// if ($stmtProduct) {

									// 	$totalProducts = 0;

									// 	while ($row = mysqli_fetch_array($stmtProduct,MYSQLI_ASSOC)) {
								?>

								<tr>

									<td class='align-middle' style='text-align: center;'><strong><?php if($row["stock"]!="") echo $row["stock"]; else echo "0.00";?></strong></td>
									<td style='text-align: center;'> <img src="<?php echo $row["image"];?>" /></td>
									<td class='align-middle' style='text-align: left;'><?php echo $row["name"]; ?></td>
									<td class='align-middle' style='text-align: center;'><?php echo $row["category"]; ?></td>
									<td class='align-middle' style='text-align: center;'><?php echo $row["capacity"]."/".$row["unit"]; ?></td>
									<td class='align-middle' style='text-align: center;'>
										<?php if ($_GET["details"] != "true") echo $row["dueDate"]; ?>          
									</td>

								</tr>

								<?php
		
										// }
									// }
								?> -->
							<!-- </tbody>
						</table> -->

				</div>


			</div>
		</div>
		</div>


		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

        <script src="../assets/js/vendor.js"></script>
        <script src="../assets/js/adminx.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
		<script>
			$(window).on('load', function () {  

			$.ajax({  
					url:"infScrollPrintCSOrd.php",  
					method:"GET",  
					dataType: 'text',
					data: {
						reportCat: '<?php echo $_GET['reportCat'];?>',
						search: '<?php echo $_GET['search'];?>',
						details: '<?php echo $_GET["details"] ?>'
					},

					success:function(data){
						$('#infinite').append(data);
						// window.print()
					} 
			});  

			})
		</script>
    </body>

</html>
