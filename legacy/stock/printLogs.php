<?php include "../system/session.php"; ?>
<!--Copypaste para mantener session on-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="../assets/css/adminx.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/all.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        @page {
            size: 8.5in 11in;
            margin: 1cm
        }

        body {
            zoom: 100%
        }

        div.page {
            page-break-after: always
        }
    </style>

</head>
<!-- onload="window.print()" -->
<body>

    <!--<div class='page'>-->
    <div>
        <div class="container">
            <div class="card" style="border: 1px solid gray; border-radius: 10px;">
                <div class="card-body" style="border-bottom: 1px solid gray; padding: 10px; padding-bottom: 0px;">
                    <div class="row">
                        <br>
                        <div class="col" style="text-align: center; padding-top: 10px; font-size: 15pt; padding-bottom:20px;">
                            <strong>
                                <?= strtoupper($_SESSION['language']['Logs']); ?>
                            </strong><br>
                            <strong>Fecha: </strong>
                            <?php $date = date('d-m-y h:i:s');
                                echo $date;
                                ?><br>
                        </div>
                        <a onclick="printScreen()"><i class="dropdown-icon fe fe-printer"></i></a>

                    </div>
                </div>

                <!-- php code para provedor-->

                <div class="card-body" style="margin: 0px; padding: 0px; font-size: 10pt;">

                    <table class="table table-sm">
                        <thead style="font-size: 10pt;">
                            <tr>
                                <th class="text-center" style="width:5%;font-weight:bold;">
                                <th class="text-center" style="width:10%;font-weight:bold;">
                                    <?php echo $_SESSION['language']['Date']; ?>
                                </th>
                                <th class="text-center" style="width:5%;font-weight:bold;">
                                    <?php echo $_SESSION['language']['Time']; ?>
                                </th>
                                <th class="text-center" style="width:5%;font-weight:bold;">
                                    <?php echo $_SESSION['language']['Code']; ?>
                                </th>
                                <th class="text-center" style="width:5%;font-weight:bold;">
                                    <?php echo $_SESSION['language']['Quantity']; ?>
                                </th>
                                <th style="width:25%;font-weight:bold;">
                                    <?php echo $_SESSION['language']['Product Name']; ?>
                                </th>
                                <th style="width:25%;font-weight:bold;">
                                    <?php echo $_SESSION['language']['Description']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 10pt; padding-top: 0px">
                            <?php

                            //Filtro por product id
                            if ($_GET['productId'] != "") {
                                $pageUrl .= "&productId=" . $_GET['productId'];
                                $productCondition = " AND stockLogs.productId=" . $_GET['productId'];
                            } else {
                                $productCondition = "";
                            }

                            //Filtro por fecha
                            if (isset($_GET['date'])) {
                                $pageUrl .= "&date=" . $_GET['date'];
                                $fechaElegida = $_GET['date'];
                                list($y, $m, $d) = explode("-", $_GET['date']);
                                $_SESSION['dateChange'] = $d . "/" . $m . "/" . $y;
                                if ($_GET['date'] == date("Y-m-d"))
                                    $dateCondition = "";
                                else
                                    $dateCondition = " AND stockLogs.date BETWEEN  '" . $fechaElegida . " 00:00:00' AND '" . $fechaElegida . " 23:59:59'";
                            } else {
                                $dateCondition = "";
                                //$fechaElegida = date("Y-m-d");
                                //$_SESSION['dateChange'] = date("d/m/Y");
                            }

                            //Filtro por warehouse
                            if (!isset($_GET['warehouseId']) || $_GET['warehouseId'] == "allWarehouse") {
                                $whSQLrequest = "";
                            } else {
                                $whSQLrequest = " AND stockLogs.warehouseId=" . $id;
                            }

                            //Filtro por search
                            $searchFilter = "";
                            if ($_GET["search"] != "") {
                                $searchFilter = " AND (products.name LIKE '%" . $_GET['search'] . "%' OR stockLogs.description LIKE '%" . $_GET['search'] . "%')";
                            }

                            // Page - Limit 
                            $limit = 100;
                            $start = ($_GET['page'] - 1) * $limit;

                            $sql = "SELECT * FROM (SELECT stockLogs.id, stockLogs.requestId, stockLogs.date, stockLogs.stock, stockLogs.type, stockLogs.warehouseId, stockLogs.productId, stockLogs.userId, stockLogs.orderId, stockLogs.description, products.name AS productName, products.sku, products.unitBarcode, warehouse.name as warehouseName FROM products as products LEFT JOIN stockLogs as stockLogs ON products.id=stockLogs.productId INNER JOIN warehouse as warehouse ON stockLogs.warehouseId=warehouse.id WHERE products.businessId=" . $_SESSION['user']['businessId'] . " " . $searchFilter . $whSQLrequest . $productCondition . $dateCondition . " GROUP BY products.id, products.sku, products.unitBarcode, products.brand, products.name, products.packWholesale, products.description,stockLogs.id,stockLogs.requestId,stockLogs.date,stockLogs.stock,stockLogs.type,stockLogs.warehouseId,stockLogs.productId,stockLogs.userId,stockLogs.orderId,stockLogs.description,warehouse.name) AS newTable ORDER BY date DESC LIMIT " . $start . "," . $limit . ";";
                            $stmt = mysqli_query($conn, $sql);
                            
                            if ($stmt) {

                                $totalRegisters = 0;
                                // $row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)
                                $rows = array_reverse(mysqli_fetch_all($stmt, MYSQLI_ASSOC));
                                foreach ($rows as $i => $row) {

                                    //$totPack = $row['totalProduct']/$row['pack'];
                                    $phpdate = strtotime($row['date']);

                                    echo "<tr id='row_". $i ."'>";
                                    echo "<td style='text-align: center; font-size:11pt;'><a id='deleteRow' onclick=buttonHandler(".$i.")><i id='rowIcon_". $i ."' class='dropdown-icon fe fe-x'></i></a></td>";
                                    echo "<td style='text-align: center; font-size:11pt;'>" . date('Y-m-d', $phpdate) . "</td>";
                                    echo "<td style='text-align: center; font-size:11pt;'>" . date('H:i:s', $phpdate) . "</td>";
                                    echo "<td style='text-align: center; font-size:11pt;'>" . $row['unitBarcode'] . "</td>";
                                    if (isset($row["stock"]))
                                        echo "<td style='text-align: center; font-size:11pt;'>" . $row["stock"] . "</td>";
                                    else
                                        echo "<td style='text-align: center; font-size:11pt;'>0</td>";
                                    // echo "<td style='text-align: center; font-size:11pt;'>" . $row["stock"]  . "</td>";
                                    if (strlen($row['productName']) > 30)
                                        echo "<td style=' font-size:11pt;'>" . substr($row['productName'], 0, 45) . "..." . "</td>";
                                    else
                                        echo "<td style=' font-size:11pt;'>" . $row['productName'] . "</td>";

                                    echo "<td style=' font-size:11pt;'><textarea style='border: 0px' rows='1' cols='50'>". $row['description'] ."</textarea></td>";


                                    echo "</tr>";

                                    $totalRegisters += 1;


                                }
                            } else {
                                echo "Sin datos de registro.";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

                <div class="card-body" style="padding: 10px; padding-left: 30px; font-size: 10pt;">
                    <div class="row">
                        <div class="col">
                            <strong>Total Registros: </strong>
                            <?php echo $totalRegisters; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        function buttonHandler(rowNum) {
            const row = document.getElementById('row_'+rowNum);
            const rowIcon = document.getElementById('rowIcon_'+rowNum);
            const deletedRow = document.getElementById('eliminado_'+rowNum);
            const deletedRowIcon = document.getElementById('eliminadoIcon_'+rowNum);

            console.log(row,rowIcon,deletedRow,deletedRowIcon);
            if (row && rowIcon){
                removePrintLog(row, rowIcon, rowNum);
            }
            if (deletedRow && deletedRowIcon){
                revertPrintLog(deletedRow, deletedRowIcon, rowNum);
            }
        }

        function revertPrintLog(deletedRow, deletedRowIcon, rowNum) {
            // const deletedRow = document.getElementById('eliminado_'+rowNum);
            // const deletedRowIcon = document.getElementById('eliminadoIcon_'+rowNum);

            deletedRow.style.opacity = 1;
            deletedRow.id = 'row_'+rowNum;
            deletedRowIcon.id = 'rowIcon_'+rowNum;
            deletedRowIcon.className = 'dropdown-icon fe fe-x';
        }

        function removePrintLog(row, rowIcon, rowNum) {
            // const row = document.getElementById('row_'+rowNum);
            // const rowIcon = document.getElementById('rowIcon_'+rowNum);
            
            row.style.opacity = 0.2;
            row.id = 'eliminado_'+rowNum;
            rowIcon.id = 'eliminadoIcon_'+rowNum;
            rowIcon.className = 'dropdown-icon fe fe-check';
        }

        function printScreen() {
            const deletedRows = document.querySelectorAll('tr[id^="eliminado_"]');
            for (row of deletedRows) {
                document.getElementById(row.id).style.display = 'none';
            }
            
            window.print();
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

    <script src="../assets/js/vendor.js"></script>
    <script src="../assets/js/adminx.js"></script>
    <script src="../assets/js/toastr.min.js"></script>
</body>

</html>