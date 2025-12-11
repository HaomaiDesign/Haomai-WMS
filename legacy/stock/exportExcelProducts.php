<?php include "../system/session.php"; ?>
<?php
    $groupbyClause = "";
                                                    
    if ($_GET["checkboxBarcode"] == "true"){
        $groupbyClause = " products.unitbarcode ";
    } else {
        $groupbyClause =" products.id ";
    }
        
        if ($_GET['search']!="")  {
            $sql = "SELECT stockLogs.productId,products.unitbarcode, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description,sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
                WHERE products.flagActive = 1";
                
            $sql2 = "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
                WHERE products.flagActive = 1";	
                

            if($_GET['search']!=""){
                $sql.= " AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )";
                
                $sql2.= " AND (products.unitbarcode LIKE '%".$_GET['search']."%' OR products.name LIKE '%".$_GET['search']."%'OR products.sku LIKE '%".$_GET['search']."%' )";
            }
            
            $sql .=	" GROUP BY ".$groupbyClause."
                    ORDER BY products.category ASC, products.unitbarcode ASC ;"; 
                    
            $sql2 .=	" GROUP BY ".$groupbyClause."
                    ;"; 
                    
                    //echo "sql SEARCH: ". $sql;
                    
        } else {
        
        if (($_GET['reportCat'] != "")AND($_GET['reportCat'] != "ALL")AND($_GET['reportCat'] != "EMPTY")) {
            
            $sql = "SELECT stockLogs.productId,products.unitbarcode, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description,sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
            WHERE products.flagActive = 1";
            
            $sql2 = "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
            WHERE products.flagActive = 1";

            $sql.= " AND products.category = '".$_GET['reportCat']."'";
            
            $sql2.= " AND products.category = '".$_GET['reportCat']."'";
            
            $sql .=	" GROUP BY ".$groupbyClause."
                ORDER BY stock DESC, products.unitbarcode ASC ;"; 
                
            $sql2 .= " GROUP BY ".$groupbyClause."
                ;"; 
            
            //echo "sql CATEGORY: ". $sql;
            
        }
        
        if ($_GET['reportCat'] == "EMPTY" ){
            
            $sql = "SELECT stockLogs.productId,products.unitbarcode, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description,sum(stockLogs.stock) AS stock FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
            WHERE products.flagActive = 1";
            
            $sql2 = "SELECT COUNT(*) AS rowNum FROM products LEFT JOIN stockLogs ON products.id=stockLogs.productId 
            WHERE products.flagActive = 1";

            $sql.= " AND products.category = ''";
            
            $sql2.= " AND products.category = ''";
            
            $sql .=	" GROUP BY ".$groupbyClause."
                ORDER BY stock DESC ;"; 
                
            $sql2 .=	" GROUP BY ".$groupbyClause."
                ;"; 
            
            
            
        }
        
        if ($_GET['reportCat'] == "ALL" ){
            
        $sql = "
            SELECT stockLogs.productId,products.unitbarcode, products.dueDate, products.category, products.sku,products.capacity,products.unit, products.id, products.code, products.brand, products.name, products.name2, products.packWholesale, products.description ,sum(stockLogs.stock) AS stock 
            FROM products   LEFT JOIN stockLogs  ON products.id=stockLogs.productId 
            WHERE products.flagActive = 1
            GROUP BY ".$groupbyClause."
            ORDER BY products.category ASC, products.unitbarcode ASC;";
            
        $sql2 = "
            SELECT COUNT(*) AS rowNum
            FROM products   LEFT JOIN stockLogs  ON products.id=stockLogs.productId 
            WHERE products.flagActive = 1
            GROUP BY ".$groupbyClause."
            ;";	
            
            //echo "sql ALL: ". $sql;
        }
    }

    // echo "sql1:".$sql." ola xd2\n";
    // echo "sql2:".$sql2;
    $stmt = mysqli_query( $conn, $sql);
    $numRows =  mysqli_num_rows($stmt);
    // $stmt2 = mysqli_query( $conn, $sql2); 	

?>
<!DOCTYPE html>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>	
    <body  onload="exportAndClose();">
        <h4>Iniciando descarga...</h4>
        <table id='productsTable' style='display:none'>
            <thead>					
                <tr>    
                    <!-- <th class="text-center"style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['SKU'];?></th> -->
                
                    <th style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></th>
                    <th style="width:30%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>
                    
                    <th style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?></th>
                    <th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Unit/Pack'];?></th>
                    <th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Capacity']."/".$_SESSION['language']['Unit'];?></th>	
                    
                    
                    <th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></th>
                    <th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Unit Barcode'];?></th>								  
                    
                    <th class="text-center" style="width:5%;font-weight:bold;"><i class="fe fe-settings"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php                                                                                                                
                if ( $stmt ) {
                    while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC )){
                ?>
                <tr id="tableRow<?=$row['id'];?>">
                    <td class="text-center">                                                                                      
                        <div><strong><?php if ($row['stock']!="") echo $row['stock']; else echo "0";?></strong></div>                             
                    </td>
                    <!-- <td class="text-center">
                        <div><?= $row['sku']; ?></div>                                                                       
                    </td>-->
                    <td>
                        <div><?php echo $row['name']; ?></div>
                    </td>
                
                    <td>                                                                                                          
                        <div><?= $row['category']; ?></div>                                                                  
                    </td>
                    <td class="text-center">
                        <div><?= $row['packWholesale']; ?></div>
                    </td>
                    <td class="text-center">
                        <div><?= $row['capacity']." ".$row['unit']; ?></div>
                    </td>
                    
                    <td class="text-center">

                        <?php
                            $today = date('Y-m-d');
                            $days = round((strtotime($row['dueDate']) - strtotime($today))/86400);
                        ?>
                        
                            <div <?php if ($days <= 60 && $days > 0) echo "style='color: blue;'"; if($days <= 0) echo "style='color: red;'"; ?> ><?php echo strval($row['dueDate']); ?></div>

                    </td>
                    <td class="text-center">                                                                                      
                        <div><?= $row['unitbarcode'] ?></div>                                                               
                    </td> 
                </tr>

                <?php 
                        };
                    }; 
                ?>

            </tbody>
        </table>
    </body>

    <script>
        function exportAndClose() {
            ExportToExcel().then(window.close());
        }
        function ExportToExcel(type, fn, dl) {
            var wscols = [
                {wch:15},
                {wch:70},
                {wch:15},
                {wch:10},
                {wch:15},
                {wch:20},
                {wch:22}
            ];

            // let today = new Date().format('Y-m-d');

            var elt = document.getElementById('productsTable');
            //var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1",dateNF:'yyyy-mm-dd' });
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(elt, {dateNF:'yyyy-mm-dd'})
            
            // for (var i=2; i< <?= $numRows;?>; i++) {
            //     //console.log(ws['F'+i]);
            //     ws["F"+i].s = {
            //         font: {
            //             color: "FF0000"
            //         }
            //     }
            // }
            
            ws['!cols'] = wscols;

            XLSX.utils.book_append_sheet(wb, ws, 'listado_productos');

            for(var i=2; i< <?= $numRows;?>; i++) {
                wb.Sheets['listado_productos']['G'+i].z = "0";
                // XLSX.utils.format_cell(wb.Sheets['listado_productos']['F'+i]);
                // console.log(wb.Sheets['listado_productos']['F'+i]);
                // wb.Sheets['listado_productos']['F'+i].s = {
                //     font: {
                //         color:{
                //             rgb: "FF0000"
                //         }
                //     }
                // }
                // console.log(wb.Sheets['listado_productos']['F'+i]);
            }
            
            // return dl ?
            //     XLSX.write(wb, { bookType: type, raw:true, bookSST: true, type: 'base64' }):
            XLSX.writeFile(wb, fn || ('listado_productos.' + (type || 'xlsx')))
        }

    </script>							

</html>