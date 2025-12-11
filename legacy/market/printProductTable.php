<?php
//To php-barcode-generator
require '../vendor/autoload.php';

$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

//To separate the characters
function splitText($text) {
    // Patrón para detectar caracteres chinos
    $pattern = "/([\x{4e00}-\x{9fa5}]+)/u";
    $patternNumber = '/^(.*\s.*?)(?=\d)/';
    
    // Dividir el texto en partes chinas y no chinas
    $parts = preg_split($pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

    $chinesePart = "";
    $nonChinesePart = "";

    foreach ($parts as $part) {
        if (preg_match($pattern, $part)) {
            $chinesePart .= $part;
        } else {
            $nonChinesePart .= $part . " ";  // Agregar un espacio para separar palabras no chinas
        }
    }
    $numberPart=preg_replace($patternNumber, '', $nonChinesePart);
    $nonChinesePart = str_replace($numberPart, '', $nonChinesePart);

    return [$chinesePart, trim($nonChinesePart)];
}
function checkDecimalPart($number) {
    // Verificar si el número multiplicado por 100 tiene una parte decimal diferente de 0
    $decimalPart = ($number * 100) % 100;

    if ($decimalPart !== 0) {
        return $number; // La parte decimal no es '00'
    } else {
        return floor($number); // La parte decimal es '00'
    }
}
?>
<div class="container" style="border: 2px solid gray; border-radius: 20px; padding-inline:10px; width:100%; padding-top:20px;<?php if($_GET["target"] == 'out'){ echo "margin-bottom:300px;"; }else{ echo "margin-bottom:370px;";}?>">
    <!-- HEADER -->
    <?php if($_GET["target"] == 'out'){?>
    <div class="card"  style=" font-size: 15pt; border: 1px solid gray; border-radius: 25px;">
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
                    <!-- <div class="row" style="padding: 3px; padding-bottom:20px;">
                        <div class="col-4">
                            <strong>Telefono:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
                            <?php
                                echo $rowCustomer["phone"];
                            ?>
                        </div> 
                    </div> -->
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
                            <strong>Fecha:</strong>
                        </div>
                        <div class='col-8' style='text-align: left; padding-right: 60px; font-size: 18pt;'>
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
                    <th style="width:10%; font-weight:bold; font-size: 16pt; text-align: center;"><?php echo $_SESSION['language']['Quantity'];?></th>
                    <th style="width:35%; font-weight:bold; font-size: 16pt;"><?php echo $_SESSION['language']['Product Name'];?></th>
                    <th style="width:30%; font-weight:bold; font-size: 16pt; text-align: center;"><?php echo $_SESSION['language']['Unit Barcode'];?></th>
                    <!-- <th style="width:35%; font-weight:bold; font-size: 16pt;"><?php echo $_SESSION['language']['Product Name'];?></th> -->
                    <!-- <th style="width:5%; font-weight:bold; font-size: 16pt; text-align: center;"><?php echo $_SESSION['language']['Unit/Pack'];?></th> -->
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
                            $capacity = checkDecimalPart($row["capacity"]);
                            echo "<tr>";
                            echo "<td style='text-align: center; font-size: 16pt;'>" . $row["quantity"] . "</td>";
                            // echo "<td style='font-size: 16pt;'>" . $row["productName"] . "</td>";
                            //To separate the Chinese and Spanish parts
                            list($chinesePart, $nonChinesePart) = splitText($row["productName"]);
                            if (mb_strlen($chinesePart)>25) $chinesePart = mb_substr($chinesePart,0,25)."...";
                            // echo "<td style='font-size: 10pt;padding: 5px;'>" . $chinesePart . "<br>" . $nonChinesePart. "<br>"  
                            // . $capacity . $row["unit"] . "X" .floor($row["pack"]). "</td>";
                            if ($row['unitBarcode'] == "Special") {
                                echo "<td style='font-size: 14pt;'>".$row['productName']."<br> </td>";
                            } else {
                                echo "<td style='padding: 5px;'>
                                        <span style='font-size: 14pt;'>" . $chinesePart . " ". $capacity . $row['unit'] . "X" . floor($row['pack'])."</span><br>
                                        <span style='font-size: 10pt;'>" . $nonChinesePart . "</span><br>
                                    </td>";
                            }
                            //<span style='font-size: 7pt;'>" . $capacity . $row['unit'] . "X" . floor($row['pack']) . "</span>
                            //To barcode
                            //remove space at beginning or end of string
                            $row['packBarcode'] = trim($row['packBarcode']);
                            //check string just has string of number 
                            if (preg_match('/^[0-9]+$/', $row['packBarcode'])){
                                // Generate a unique file name for each barcode
                                // $destinationFolder = 'assets/images/barcodes/';
                                // $barcodeFileName = $destinationFolder .'barcode_' . $row["packBarcode"] . '.jpg';
                                // Check if the file already exists
                                //if (!file_exists($barcodeFileName)) {
                                    // Generate barcode 
                                    //file_put_contents($barcodeFileName, $generator->getBarcode($row["packBarcode"], $generator::TYPE_CODE_128_A));
                                    // }
                                $barcodeNew = base64_encode($generator->getBarcode($row["packBarcode"], $generator::TYPE_CODE_128));
                                echo "<td style='text-align: center; font-size: 16pt;vertical-align: middle;'><img src='data:image/png;base64," . $barcodeNew . "' alt='Código de Barras' /></td>";
                            }else{
                                if ($row['unitBarcode'] == "Special") {
                                    echo "<td style='font-size: 16pt;text-align: center;'>" . $row["unitBarcode"] . "</td>";
                                } else {
                                    echo "<td style='font-size: 16pt;text-align: center;'>" . $row["packBarcode"] . "</td>";
                                }
                            }
                        // echo "<td style='text-align: center; font-size: 16pt;'>" . $pack . "</td>";
                            echo "</tr>";

                            $products += 1;
                            $units += $row["quantity"];
                            $totalUnit += $row["quantity"]* $row["pack"];
                            if($products == $productsPerPage){
                                $products = 0;
                                break;
                            }
                        }
                    }
                    $endTime = microtime(true);

                ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>
