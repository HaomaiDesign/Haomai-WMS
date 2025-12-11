<?php
// include 'hola.php';
$pageUrl = "lowStockProducts.php?tableStatus=view";

$searchFilter = "";
if ($_GET["search"] != "") {
    $searchFilter = " AND (products.name LIKE '%" . $_GET['search'] . "%' OR products.`unitBarcode` LIKE '%" . $_GET['search'] . "%')";
}

if ($_GET['unitBarcode'] != "") {
    $pageUrl .= "&unitBarcode=" . $_GET['unitBarcode'];
    $productCondition = " AND stockLogs.unitBarcode=" . $_GET['unitBarcode'];
} else {
    $productCondition = "";
}


if (isset($_GET['date'])) {
    $pageUrl .= "&date=" . $_GET['date'];
    $fechaElegida = $_GET['date'];
    list($y, $m, $d) = explode("-", $_GET['date']);
    $_SESSION['dateChange'] = $d . "/" . $m . "/" . $y;
    if ($_GET['date'] == date("Y-m-d"))
        $dateCondition = "";
    else
        $dateCondition = "a.date BETWEEN  '" . $fechaElegida . " 00:00:00' AND '" . $fechaElegida . " 23:59:59'";
} else {
    $dateCondition = "";
}

// $currentDate = date('Y-m-01');
// $startDate = date('Y-m-01', strtotime('-4 month', strtotime($currentDate)));

$pageUrl .= "&page=";
$productStatesFilter = "";
if (!isset($_GET['filterReceived'])) {
    $productStatesFilter = "lowStock = 1 OR lowStock = 2";
} else {
    $productStatesFilter = "products.lowStock = 3";
}
$sql0 = "SELECT COUNT(*) AS rowNum FROM products WHERE flagActive = 1 AND category NOT IN ('BEBIDAS', 'GOLOSINAS') AND (" . $productStatesFilter . ") " . $searchFilter . ";";

$stmt0 = mysqli_query($conn, $sql0);

if ($stmt0) {
    $row0 = mysqli_fetch_array($stmt0, MYSQLI_ASSOC);

    $totalItem = $row0['rowNum'];
    // echo $totalItem;
    $limit = 50;

    $totalPage = ceil($totalItem / $limit);
    $start = ($_GET['page'] - 1) * $limit;

}


?>


<div class="col-12">


    <?php if ($_GET['tableStatus'] == 'view') { ?>
        <div class="card">
            <div class="card-status card-status-left bg-teal"></div>
            <div class="card-header">

                <div class="card-options">
                    <div class="item-action">
                        <form action="lowStockProducts.php" method="GET">
                            <div class="row">
                                <div style="width: 200px;">
                                    <input class="form-check-input" type="checkbox" onchange="filterReceivedProducts()" <?php if ($_GET["filterReceived"] == "true") echo "checked"; ?> id="checkboxFilterReceived">
                                    <label class="form-check-label" for="checkboxFilterReceived">
                                        <? if ($_GET['tableStatus'] == 'view') echo $_SESSION['language']['Products received']; ?>
                                    </label>
                                </div>
                                <div style="width: 200px; margin-right: 20px;">
                                    <div class="input-icon mb-3">
                                        <input id="search" name="search" type="search" class="form-control header-search" placeholder="<?php echo $_SESSION['language']['search']; ?>">
                                        <input id="tableStatus" name="tableStatus" type="hidden" class="form-control header-search"value="view">
                                        <input id="page" name="page" type="hidden" class="form-control header-search" value="1">
                                        <span class="input-icon-addon">
                                            <i class="fe fe-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    ; ?>

    <div class="card">
        <div class="card-status card-status-left bg-teal"></div>
        <div class="card-header">
            <h3 class="card-title" style="font-weight:bold;">
                <?php echo $_SESSION['language']['Report']; ?>
            </h3>

            <!-- <div class="item-action">
                <a style="margin-left:15px;" target="_blank" href="printLogs.php?page=<?php echo $_GET['page'] . "&";
                if ($_GET["search"] != "")
                    echo "search=" . $_GET["search"];
                if ($_GET["date"] != "")
                    echo "&date=" . $_GET["date"];
                if ($_GET["warehouseId"] != "")
                    echo "&warehouseId=" . $_GET["warehouseId"]; ?>"><i class="dropdown-icon fe fe-printer"></i></a>
            </div> -->
            <div class="card-options">
                <div class="item-action">
                    <?php echo $_SESSION['language']['Total'] . " " . $totalItem . " " . $_SESSION['language']['Report']; ?>&nbsp&nbsp&nbsp
                </div>

                <div class="item-action">
                    <a href="<?php echo $pageUrl . "1"; ?>" <?php if ($_GET['page'] == 1)
                             echo " style='pointer-events: none;'";
                         else
                             echo " style='color: black;'"; ?>><i class="fas fa-angle-double-left"></i></a>
                    <a href="<?php echo $pageUrl . ($_GET['page'] - 1); ?>" <?php if ($_GET['page'] == 1)
                               echo " style='pointer-events: none;'";
                           else
                               echo " style='color: black;'"; ?>><i
                            class="fas fa-angle-left"></i></a>
                    <a style="color: black;">
                        <?php echo $_SESSION['language']['Page'] . " " . $_GET['page'] . " / " . $totalPage; ?>&nbsp
                    </a>
                    <a href="<?php echo $pageUrl . ($_GET['page'] + 1); ?>" <?php if ($_GET['page'] == $totalPage)
                               echo " style='pointer-events: none;'";
                           else
                               echo " style='color: black;'"; ?>><i
                            class="fas fa-angle-right"></i></a>
                    <a href="<?php echo $pageUrl . $totalPage; ?>" <?php if ($_GET['page'] == $totalPage)
                             echo " style='pointer-events: none;'";
                         else
                             echo " style='color: black;'"; ?>><i
                            class="fas fa-angle-double-right"></i></a>&nbsp
                </div>
            </div>
        </div>




        <div class="table-responsive">
            <table id="reportTable" class="table table-hover table-outline table-vcenter text-truncate card-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width:10%;font-weight:bold;">
                            <?php echo $_SESSION['language']['Image']; ?>
                        </th>
                        <th style="width:35%;font-weight:bold;">
                            <?php echo $_SESSION['language']['Product Name']; ?>
                        </th>
                        <th style="width:10%;font-weight:bold;" class="text-center">
                            <?php echo $_SESSION['language']['Unit Barcode']; ?>
                        </th>
                        <th class="text-center" style="width:20%;font-weight:bold;">
                            <?php echo $_SESSION['language']['Stock']; ?>
                        </th>
                        <th class="text-center" style="width:20%;font-weight:bold;">
                            <?php echo $_SESSION['language']['Stock alert']; ?>
                        </th>
                        <th class="text-center" style="width:10%;font-weight:bold;">
                            <i class="fe fe-settings"></i>
                        </th>
                        <!--<th class="text-center" style="width:10%;font-weight:bold;"><i class="fas fa-sort"></i> <?php echo $_SESSION['language']['User']; ?> </th>-->
                    </tr>
                </thead>
                <tbody>


                    <?php


                    // $currentDate = date('Y-m-01');
                    // $startDate = date('Y-m-01', strtotime('-4 month', strtotime($currentDate)));
                    
                    $sql = "SELECT products.id, stockLogs.productId, products.unitbarcode, products.image,products.id, 
                            products.lowStock, products.name, products.name2,sum(stockLogs.stock) AS stock, 
                            products.minStock, products.category
                            FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
                            WHERE products.flagActive = 1 AND products.category NOT IN ('BEBIDAS', 'GOLOSINAS') AND (" . $productStatesFilter . ") " . $searchFilter . "
                            GROUP BY products.unitbarcode
                            ORDER BY products.category, products.name DESC
                            LIMIT " . $start . "," . $limit . ";";

                    $stmt = mysqli_query($conn, $sql);

                    if ($stmt) {
                        while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {

                            $phpdate = strtotime($row['date']);

                            ?>

                            <tr>

                                <td class="text-center">
                                    <div>
                                        <img src="<?php echo $row['image']; ?>" class="d-inline-block align-top mr-3" alt="">
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?php

                                        if (strlen($name) > 30)
                                            echo substr($row['name'], 0, 50) . "...";
                                        else
                                            echo $row['name'];
                                        ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div>
                                        <?php echo $row['unitbarcode']; ?>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div><strong>
                                            <?php if ($row['stock'] != "")
                                                echo $row['stock'];
                                            else
                                                echo "0.00"; ?>
                                        </strong></div>
                                </td>
                                <td class="text-center">
                                    <div><strong>
                                            <?php if ($row['minStock'] != "")
                                                echo $row['minStock'];
                                            else
                                                echo "0.00"; ?>
                                        </strong></div>
                                </td>
                                <td class="text-center">
                                    <div class="item-action dropdown">
                                        <a href="javascript:void(0)" <?php if ($row['lowStock'] != 0)
                                            echo "data-toggle='dropdown'"; ?> class="icon">
                                            <?php
                                            if ($row['lowStock'] == 1) {
                                                echo "<span id='dropdownStatusInfoId" . $row['id'] . "' class='badge badge-warning'>" . $_SESSION['language']['Low Stock'] . "</span>";
                                            }
                                            if ($row['lowStock'] == 2) {
                                                echo "<span id='dropdownStatusInfoId" . $row['id'] . "' class='badge badge-primary'>" . $_SESSION['language']['Requested'] . "</span>";
                                            }
                                            if ($row['lowStock'] == 0) {
                                                echo "<span id='dropdownStatusInfoId" . $row['id'] . "' class='badge badge-success'>" . $_SESSION['language']['Uploaded to the system'] . "</span>";
                                            }
                                            if ($row['lowStock'] == 3) {
                                                echo "<span id='dropdownStatusInfoId" . $row['id'] . "' class='badge badge-info'>" . $_SESSION['language']['Received'] . "</span>";
                                            }
                                            ?>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- El received pasa a ser  3. El nuevo estado pasa a ser 0, que son los prods que cuando entras al listado no aparecen. -->
                                            <a href="javascript:void(0)"
                                                onclick="statusUpdateLowStock('dropdownStatusInfoId<?= $row['id']; ?>', 2, '<?= $row['unitbarcode'] ?>')"
                                                class="dropdown-item">
                                                <?php echo $_SESSION['language']['Requested']; ?>
                                            </a>
                                            <a href="javascript:void(0)"
                                                onclick="statusUpdateLowStock('dropdownStatusInfoId<?= $row['id']; ?>', 3, '<?= $row['unitbarcode'] ?>')"
                                                class="dropdown-item">
                                                <?php echo $_SESSION['language']['Received']; ?>
                                            </a>
                                            <a href="javascript:void(0)"
                                                onclick="statusUpdateLowStock('dropdownStatusInfoId<?= $row['id']; ?>', 0, '<?= $row['unitbarcode'] ?>')"
                                                class="dropdown-item">
                                                <?php echo $_SESSION['language']['Uploaded to the system']; ?>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                        ; ?>

                    </tbody>
                </table>
            </div>

        <?php }
                    ; ?>

    </div>
</div>

<script>

    function statusUpdateLowStock(dropdownId, stockState, unitBarcode) {

        statusBadge = document.getElementById(dropdownId);

        var flagName = "";
        var flagClass = "badge badge-success";
        if (stockState == 2) {
            flagName = "<?php echo $_SESSION['language']['Requested'] ?>";
            flagClass = "badge badge-primary";
        }
        if (stockState == 0) {
            flagName = "<?php echo $_SESSION['language']['Received'] ?>";
            flagClass = "badge badge-success";
        }

        $.ajax({
            url: '../webservice/stock.php',
            type: 'GET',
            data: { stockState: stockState, unitBarcode: unitBarcode, action: "updateProdStockState" },
            success: function (data) {
                toastr.options.positionClass = "toast-top-left";
                if (data) {
                    statusBadge.className = flagClass;
                    statusBadge.innerHTML = flagName;
                    statusBadge.style.backgroundColor = "";
                    toastr.success("库存状态更新成功");
                }
                console.log(data)
            },
            error: function (data) {
                toastr.options.positionClass = "toast-top-left";
                toastr.error("无法更新库存状态");
                console.log(data); // Inspect this in your console
            }
        });
    }

    function colorEqualCellGroups() {
        var table = document.getElementById("reportTable");
        var rows = table.getElementsByTagName("tr");
        var prevCellValue = "";
        var prevRowColor = "";

        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName("td");
            if (prevCellValue != "" && cells[0].innerHTML != prevCellValue && prevRowColor == rows[i].style.backgroundColor) {
                if (prevRowColor == "")
                    rows[i].style.backgroundColor = "rgba(242, 242, 242, 1)";
            }
            if (prevCellValue != "" && cells[0].innerHTML == prevCellValue && prevRowColor != rows[i].style.backgroundColor) {
                rows[i].style.backgroundColor = prevRowColor;
            }
            var prevCellValue = cells[0].innerHTML;
            var prevRowColor = rows[i].style.backgroundColor;
        }
    }

    colorEqualCellGroups();


    function filterReceivedProducts() {
        var checkboxChecked = document.getElementById("checkboxFilterReceived").checked;
        let filterReceived = '';
        if (checkboxChecked) {
            filterReceived = '&filterReceived=true';
        }
        window.location.replace("lowStockProducts.php?tableStatus=view&page=1<?php if ($_GET["search"] != "") echo "&search=" . $_GET["search"]; ?>" + filterReceived);
    }
</script>