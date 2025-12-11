<?php include '../system/session.php';?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" type="text/css" href="../assets/css/adminx.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/toastr.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/all.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

	<script>
		function preparePrint(){
			window.print();
      		// window.onafterprint = window.close;
		}
	</script>


	<?php
        // php code para client data
		$sql1 = "SELECT businessName, phone, email, address, location, taxId, whatsapp, wechat, description FROM orders WHERE id=".$_GET['orderId'];
		$stmtCustomer = mysqli_query($conn,$sql1);

		if ($stmtCustomer) {
			$rowCustomer = mysqli_fetch_array($stmtCustomer,MYSQLI_ASSOC);
		} else {
			echo "hubo un error al conectar con el (customer)";
		}

        // Chequeo si existe customer en tabla customers
        $sqlCheckUser = "SELECT businessName FROM customers WHERE businessName = N'".$row["businessName"]."' LIMIT 1;";
        $stmtCheckUser = mysqli_query($conn,$sqlCheckUser);
        if($stmtCheckUser){
            $user_num_rows = mysqli_num_rows($stmtCheckUser);
            if($user_num_rows == 0 && $row["businessName"] != ""){
                $sqlInsertNewUser = "INSERT INTO customers (businessName, phone, email, address, location, taxId, whatsapp, wechat, description)
                VALUES (N'".$row["businessName"]."',N'".$row["phone"]."',N'".$row["email"]."',N'".$row["address"]."',
                N'".$row["location"]."',N'".$row["taxId"]."',N'".$row["whatsapp"]."',N'".$row["wechat"]."',N'".$row["description"]."')";

                $stmtInsertNewUser = mysqli_query($conn,$sqlInsertNewUser);
            }
        }
        
        // PHP code para info producto de pedido

        $sql2 = "(SELECT orderId, productName, productName2, unitBarcode, image, quantity, pack, currency 
                FROM orderDetails 
                WHERE orderId=".$_GET['orderId']." AND unitBarcode = 'Special')
                UNION
                (SELECT orderId, productName, productName2, unitBarcode, image, SUM(quantity) AS quantity, pack, currency 
                FROM orderDetails 
                WHERE orderId=".$_GET['orderId']." AND unitBarcode != 'Special'
                GROUP BY unitBarcode);";
        // echo $sql2;
        $stmtProd = mysqli_query($conn,$sql2);
        $products = 0;
        $units = 0;  
        if(!$stmtProd){
            echo "Error al obtener datos del pedido";
        } else {
            //entran 25 productos por A4
            $qtyProducts = mysqli_num_rows($stmtProd);
            $productsPerPage = 20;
            $totalPages = ceil($qtyProducts / $productsPerPage);
            // echo "total pages:".$totalPages;
        }

    ?>

    <body onload="preparePrint()">
        <div class="container">
            <!-- TABLA FULL CONTENIDO-->
            <?php 
                for($currPage = 1; $currPage <= $totalPages; $currPage++){
                    include 'printProductTable.php';
                }
            ?>

            <!-- FOOTER -->
            <div class="container" style="padding-top:10px; position:fixed; background-color: white; bottom:0; font-size: 15pt; border: 1px solid gray; border-radius: 25px; width:100%; padding-inline:10px">
                <div class="row">
                    <div class="col-12" style="padding-top: 10px; padding-left: 50px; padding-bottom: 50px;">
                        <div class="row" style="padding: 2px; ">
                            <div class="col-12">
                                <strong>Cantidad de Productos: </strong>
                                <?php echo $qtyProducts; ?>
                            </div>
                        </div>
                        <div class="row" style="padding: 2px; ">
                            <div class="col-12">
                                <strong>Total de Unidades: </strong>
                                <?php
                                    
                                    echo $units;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>