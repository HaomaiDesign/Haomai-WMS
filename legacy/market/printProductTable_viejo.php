<div class="container" style="border: 2px solid gray; border-radius: 20px; padding-inline:10px; width:100%; padding-top:40px;<?php if($_GET["target"] == 'out'){ echo "margin-bottom:300px;"; }else{ echo "margin-bottom:370px;";}?>">
    <!-- HEADER -->
    <?php if($_GET["target"] == 'out'){?>
    <div class="card"  style="padding-block:15px; font-size: 15pt; border: 1px solid gray; border-radius: 25px;">
        <div class="col-12" style="padding-top: 10px; padding-left: 50px;">
            <div class="row">
                <div class="col-6">
                    <div class="row" style="padding: 3px; padding-bottom:20px; ">
                        <div class="col-4">
                            <strong>Cliente:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                            <?php
                                echo $rowCustomer["businessName"];
                            ?>
                        </div>                                            
                    </div>
                    <!-- <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-4">
                            <strong>CUIT:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                        <?php
                                echo $rowCustomer["taxId"];
                            ?>
                        </div> 
                    </div> -->
                    <?php if ($_SESSION['user']['subscription']>=3) {?>
                    <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-4">
                            <strong>Whatsapp:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                        <?php
                                echo $rowCustomer["whatsapp"];
                            ?>
                        </div> 
                    </div>
                    <?php };?>
                    <!-- <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-4">
                            <strong>Localidad:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                            <?php
                                echo $rowCustomer["location"];
                            ?>
                        </div> 
                    </div> -->
                </div>
                <div class="col-6">
                    <!-- <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-4">
                            <strong>Razon Social:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt'>
                            <?php
                                echo $rowCustomer["legalName"];
                            ?>
                        </div> 
                    </div> -->
                    <!-- <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-3">
                            <strong>Email:</strong>
                        </div>
                        <div class='col-9' style='text-align: left; padding-right: 60px; font-size: 16pt;'>
                            <?php
                                echo $rowCustomer["email"];
                            ?>
                        </div> 
                    </div> -->
                    <?php if ($_SESSION['user']['subscription']>=3) {?>
                    <div class="row" style="padding: 3px; ">
                        <div class="col-3">
                            <strong>Wechat:</strong>
                        </div>
                        <div class='col-9' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                            <?php
                                echo $rowCustomer["wechat"];
                            ?>
                        </div> 
                    </div>
                    <?php };?>
                    <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-4">
                            <strong>Telefono:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                            <?php
                                echo $rowCustomer["phone"];
                            ?>
                        </div> 
                    </div>
                    <!--
                    <div class="row" style="padding: 3px; ">
                        <div class="col-4">
                            <strong>Descripcion:</strong>
                        </div>
                        <div class='col-8' style='text-align: right; padding-right: 60px;'>
                            <?php
                                echo $rowCustomer["description"];
                            ?>
                        </div> 
                    </div>
                    -->
                </div>
                <div class="col-6">
                    <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-4">
                            <strong>Domicilio:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                            <?php
                                echo $rowCustomer["address"];
                            ?>
                        </div> 
                    </div>
                </div>
                <div class ="col-6">
                    <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-4">
                            <strong>N° pedido:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                            <?php
                                echo str_pad($_GET['orderId'], 8, "0", STR_PAD_LEFT);
                            ?>
                        </div> 
                    </div>
                </div>
                <div class ="col-12">
                    <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-2">
                            <strong>Fecha:</strong>
                        </div>
                        <div class='col-10' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                            <?php
                                echo $_GET['date'];
                            ?>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- TABLA BODY. -->
    <div class="card"  style="border: 1px solid gray; border-radius: 15px">
        <?php
            if ($stmtProd) {
        ?>
        <table class="table table-sm" style="margin-top:15px; border-radius: 25px">
            <thead style="font-size: 10pt; border-radius: 25px">
                <tr>
                    <!-- <th style="width:15%; font-weight:bold; font-size: 16pt; text-align: center;"><?php echo $_SESSION['language']['Unit Barcode'];?></th> -->
                    <th style="width:10%; font-weight:bold; font-size: 16pt; text-align: center;"><?php echo $_SESSION['language']['Quantity'];?></th>
                    <th style="width:35%; font-weight:bold; font-size: 16pt;"><?php echo $_SESSION['language']['Product Name'];?></th>
                    <!-- <th style="width:35%; font-weight:bold; font-size: 16pt;"><?php echo $_SESSION['language']['Product Name'];?></th> -->
                    <th style="width:5%; font-weight:bold; font-size: 16pt; text-align: center;"><?php echo $_SESSION['language']['Unit/Pack'];?></th>
                </tr>
            </thead>
            <tbody style="font-size: 10pt; border-radius: 25px">
                <?php
                    while ($row = mysqli_fetch_array($stmtProd,MYSQLI_ASSOC)) {
                        if ($row["quantity"]!=0) {									
                            if($row["market"] == 0){
                                $pack = "1.00";
                            }
                            if($row["market"] == 1){
                                $pack = $row["pack"];
                            }
                            
                            $import = $row["quantity"] * $row["price"];
                            
                            echo "<tr>";
                            // echo "<td style='text-align: center; font-size: 16pt;'>" . $row["unitBarcode"] ."</td>";
                            echo "<td style='text-align: center; font-size: 16pt;'>" . $row["quantity"] . "</td>";
                            echo "<td style='font-size: 16pt;'>" . $row["productName"] . "</td>";
                            // echo "<td style='font-size: 16pt;'>" . $row["productName2"] . "</td>";
                            echo "<td style='text-align: center; font-size: 16pt;'>" . $pack . "</td>";
                            echo "</tr>";

                            $products += 1;
                            $units += $row["quantity"];
                            if($products == $productsPerPage){
                                $products = 0;
                                break;
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>
