<?php include "../system/session.php";?>


<table class="table table-sm">
    <tbody id="infinite" style="font-size: 10pt; padding-top: 0px">
    
    <tr>
        <td class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></td>
        <td class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></td>
        <td class="text-left" style="width:50%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></td>
        <td class="text-center" style="width:10%;font-weight:bold; text-align: center;"><?php echo $_SESSION['language']['Category'];?></td>
        <td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Capacity']."/".$_SESSION['language']['Unit'];?></td>
        <td class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></td>
    </tr>

    <?php 

        if (($_GET['reportCat']!="")AND($_GET['reportCat'] != "ALL")AND($_GET['reportCat'] != "EMPTY")) {

            $catList = explode(',', $_GET['reportCat']);
            $catFilter = "(";
            for ($i=0; $i < count($catList); $i++) {

                $catFilter .= "'".$catList[$i]."'" . ',';
            }
            $catFilter = substr($catFilter,0,-1) . ')';
            $sql = "SELECT stockLogs.productId, products.unitbarcode, products.image, products.dueDate, products.category, products.capacity, products.unit, products.name, sum(stockLogs.stock) AS stock 
                    FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId
                    WHERE products.flagActive = 1
                    AND products.category IN ".$catFilter."
                    GROUP BY products.unitbarcode
                    ORDER BY products.category, products.name DESC;";
        }
        if ($_GET['reportCat']=="ALL")
        $sql = "SELECT stockLogs.productId, products.unitbarcode, products.image, products.dueDate, products.category, products.capacity, products.unit, products.name, sum(stockLogs.stock) AS stock 
                FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
                WHERE products.flagActive = 1
                GROUP BY products.unitbarcode
                ORDER BY products.category, products.name DESC;";

        if ($_GET['reportCat']=="EMPTY")
        $sql = "SELECT stockLogs.productId, products.unitbarcode, products.image, products.dueDate, products.category, products.capacity, products.unit, products.name, sum(stockLogs.stock) AS stock
                FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId
                WHERE products.flagActive = 1
                AND products.category = ''
                GROUP BY products.unitbarcode
                ORDER BY products.category, products.name DESC;";

        if ($_GET['search']!="")
        $sql = "SELECT stockLogs.productId, products.unitbarcode, products.image, products.dueDate, products.category, products.capacity, products.unit, products.name, sum(stockLogs.stock) AS stock
                FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId
                WHERE products.flagActive = 1
                AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )
                GROUP BY products.id
                ORDER BY products.name DESC;";

        $stmtProduct = mysqli_query( $conn,$sql);

        if ($stmtProduct) {

            $totalProducts = 0;

            while ($row = mysqli_fetch_array($stmtProduct,MYSQLI_ASSOC)) {

                //$totPack = $row['totalProduct']/$row['pack'];
    ?>

        <tr>
            
            <td class='align-middle' style='text-align: center; font-size: 20pt;'><strong><?php if($row["stock"] == "" || $row["stock"] == 0.00) echo ""; else echo intval($row["stock"]);?></strong></td> <!--if($row["stock"]!="") echo $row["stock"]; else echo "";-->
            <td style='text-align: center;'> <img src="<?= $row["image"];?>" /></td>
            <td class='align-middle' style='text-align: left;'><?= $row["name"]; ?></td>
            <td class='align-middle' style='text-align: center;'><?= $row["category"]; ?></td>
            <td class='align-middle' style='text-align: center;'><?= $row["capacity"]."/".$row["unit"]; ?></td>
            <td class='align-middle' style='text-align: center;'>
                <?php if ($_GET["details"] != "true") echo $row["dueDate"]; ?>          
            </td>

        </tr>

    <?php
            }
        }
    
    ?>
    </tbody>
</table>