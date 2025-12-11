<?php include "../system/session.php"; ?>
<?php

    $today = date('Y-m-d');	

    if ($_GET['search']!="")  {
        $sql = "SELECT a.dueDate, a.id, a.unitBarcode, a.category, a.name, a.image, a.packWholesale, a.capacity, a.unit, a.flagActive, SUM(b.stock) AS stock
                FROM products AS a LEFT JOIN stockLogs AS b ON a.id=b.productId 
                WHERE a.flagActive=1 
                AND duedate  BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ".$_GET['search']." DAY) 
                GROUP BY a.unitBarcode 
                HAVING stock > 0 
                ORDER BY dueDate ASC;";
    } 

    $stmt = mysqli_query( $conn, $sql);
    $numRows =  mysqli_num_rows($stmt);

?>
<!DOCTYPE html>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>	
    <body onload="exportAndClose();">
        <h4>Iniciando descarga...</h4>
        <table id='productsTable' style='display:none'>
            <thead>					
                <tr>

                    <!-- <th class="text-center" style="width:10%;font-weight:bold;"> <?php echo $_SESSION['language']['Image'];?></th> -->
                    <th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Due Date'];?></th>
                    <th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Days'];?></th>	
                    <th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Stock'];?></th>
                    <th class="text-center" style="width:30%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name'];?></th>
                    <th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Category'];?></th>

                </tr>
            </thead>
            <tbody>
                <?php                                                                                                                
                if ( $stmt ) {
                    while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC )){
                ?>
                <tr id="tableRow<?=$row['id'];?>">

                    <!-- <td class="text-center">
                        <div><img src="<?php echo $row['image'];?>" class="d-inline-block align-top mr-3" alt=""></div>
                    </td> -->
                    <td class="text-center">
                        <?= strval($row['dueDate']);?>
                    </td>
                    <td class="text-center">
                        <div style="color: red;">
                            <strong <?php if ($_SESSION['user']['roleId'] == 2) echo "style='font-size:15pt;'" ?> >
                            <?php 
                                $days = round((strtotime($row['dueDate'])-strtotime($today))/86400);
                                echo $days;
                            ?>
                            </strong>
                        </div>
                    </td>
                    <td class="text-center">                                                                                      
                        <div><strong><?php if ($row['stock']!="") echo $row['stock']; else echo "0";?></strong></div>                             
                    </td>
                    <td>
                        <div><?php echo $row['name']; ?></div>
                    </td>
                    <td>                                                                                                          
                        <div><?= $row['category']; ?></div>                                                                  
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
                // {wch:100},
                {wch:20},
                {wch:15},
                {wch:15},
                {wch:80},
                {wch:15}
            ];

            var elt = document.getElementById('productsTable');
            //var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1",dateNF:'yyyy-mm-dd' });
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(elt, {dateNF:'yyyy-mm-dd'})

            ws['!cols'] = wscols;

            XLSX.utils.book_append_sheet(wb, ws, 'listado_productos');

            //wb.Sheets['listado_productos']['A1,A<?= $numRows;?>'].z  = '0';
            // wb.Sheets['listado_productos']['A2'].z = "0";
            // wb.Sheets['listado_productos']['A3'].z = "0";
            // wb.Sheets['listado_productos']['A4'].z = "0";

            // Para guardar en el excel, los unitebarcodes que empiezan con 0
            // for(var i=2; i< <?= $numRows;?>; i++) {
            //     wb.Sheets['listado_productos']['G'+i].z = "0";
            // }
            
            // return dl ?
            //     XLSX.write(wb, { bookType: type, raw:true, bookSST: true, type: 'base64' }):
            XLSX.writeFile(wb, fn || ('listado_productos.' + (type || 'xlsx')))
        }

    </script>

</html>