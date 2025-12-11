<?php include "../system/session.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <title>Exportando movimientos de stock...</title>
</head>
<body onload="exportAndClose();">
    <h4>Iniciando descarga...</h4>
    
    <?php
    // Parámetros de filtrado
    $warehouseId = isset($_GET['warehouseId']) ? $_GET['warehouseId'] : 'allWarehouse';
    $year = isset($_GET['year']) ? $_GET['year'] : 'all';
    $month = isset($_GET['month']) ? $_GET['month'] : 'all';
    $dateFrom = isset($_GET['dateFrom']) ? $_GET['dateFrom'] : date('Y-m-d', strtotime('-30 days'));
    $dateTo = isset($_GET['dateTo']) ? $_GET['dateTo'] : date('Y-m-d');
    $productId = isset($_GET['productId']) ? $_GET['productId'] : '';
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $movementType = isset($_GET['movementType']) ? $_GET['movementType'] : 'all';

    // Construir condición de fecha
    $dateCondition = "";
    if ($year != 'all' && $month != 'all') {
        $dateFrom = date('Y-m-01', strtotime($year . '-' . $month . '-01'));
        $dateTo = date('Y-m-t', strtotime($year . '-' . $month . '-01'));
        $dateCondition = " AND stockLogs.date BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'";
    } elseif ($year != 'all') {
        $dateFrom = date('Y-01-01', strtotime($year . '-01-01'));
        $dateTo = date('Y-12-31', strtotime($year . '-12-31'));
        $dateCondition = " AND stockLogs.date BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'";
    } elseif ($month != 'all') {
        $currentYear = date('Y');
        $dateFrom = date('Y-m-01', strtotime($currentYear . '-' . $month . '-01'));
        $dateTo = date('Y-m-t', strtotime($currentYear . '-' . $month . '-01'));
        $dateCondition = " AND stockLogs.date BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'";
    }

    // Obtener información del depósito
    $warehouseName = "Todos los Depósitos";
    if ($warehouseId != 'allWarehouse') {
        list($id, $name) = explode("_", $warehouseId);
        $warehouseName = $name;
    }

    // Construir condiciones SQL
    $whCondition = ($warehouseId != 'allWarehouse') ? " AND stockLogs.warehouseId=$id" : "";
    $productCondition = ($productId != "") ? " AND stockLogs.productId=$productId" : "";
    $searchCondition = ($search != "") ? " AND (products.name LIKE '%$search%' OR stockLogs.description LIKE '%$search%' OR products.unitBarcode LIKE '%$search%')" : "";
    $movementTypeCondition = ($movementType != 'all') ? " AND stockLogs.type = " . intval($movementType) : "";

    // Obtener todos los datos de movimientos sin paginación
    $movementsSql = "SELECT 
                        stockLogs.id, 
                        stockLogs.date, 
                        stockLogs.stock, 
                        stockLogs.type, 
                        stockLogs.description, 
                        products.id AS productId,
                        products.name AS productName, 
                        products.sku, 
                        products.unitBarcode,
                        warehouse.name AS warehouseName,
                        users.fullName AS responsibleName
                    FROM 
                        products 
                        LEFT JOIN stockLogs ON products.id=stockLogs.productId 
                        INNER JOIN users ON stockLogs.userId=users.id 
                        INNER JOIN warehouse ON stockLogs.warehouseId=warehouse.id 
                    WHERE 
                        products.businessId=" . $_SESSION['user']['businessId'] . 
                        $dateCondition . 
                        $productCondition . 
                        $whCondition .
                        $searchCondition .
                        $movementTypeCondition . " 
                    ORDER BY 
                        stockLogs.date DESC,
                        products.unitBarcode ASC";

    $movementsResult = mysqli_query($conn, $movementsSql);
    $numRows = mysqli_num_rows($movementsResult);
    ?>

    <table id="movementsTable" style="display:none">
        <thead>
            <tr>
                <th><?php echo $_SESSION['language']['Date']; ?></th>
                <th><?php echo $_SESSION['language']['Time']; ?></th>
                <th><?php echo $_SESSION['language']['Code']; ?></th>
                <th><?php echo $_SESSION['language']['Product Name']; ?></th>
                <th><?php echo $_SESSION['language']['Quantity']; ?></th>
                <th><?php echo $_SESSION['language']['Type']; ?></th>
                <th><?php echo $_SESSION['language']['Warehouse']; ?></th>
                <th><?php echo $_SESSION['language']['Description']; ?></th>
                <th><?php echo $_SESSION['language']['Responsable']; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($movementsResult && mysqli_num_rows($movementsResult) > 0) {
                while ($row = mysqli_fetch_assoc($movementsResult)) {
                    if (empty($row['id']) || empty($row['date'])) continue;
                    
                    $date = date('Y-m-d', strtotime($row['date']));
                    $time = date('H:i:s', strtotime($row['date']));
                    
                    $type = "";
                    switch ($row['type']) {
                        case 0:
                            $type = $_SESSION['language']['Received'] ?? "Recibido";
                            break;
                        case 1:
                            $type = $_SESSION['language']['Delivered'] ?? "Entregado";
                            break;
                        case 2:
                            $type = $_SESSION['language']['Corrected'] ?? "Corregido";
                            break;
                    }
            ?>
                <tr>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $time; ?></td>
                    <td><?php echo $row['unitBarcode']; ?></td>
                    <td><?php echo $row['productName']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td><?php echo $type; ?></td>
                    <td><?php echo $row['warehouseName']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['responsibleName']; ?></td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="9">No se encontraron movimientos para los criterios seleccionados</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <script>
        function exportAndClose() {
            ExportToExcel().then(setTimeout(function() { window.close(); }, 500));
        }
        
        function ExportToExcel(type, fn, dl) {
            var wscols = [
                {wch:15}, // Fecha
                {wch:10}, // Hora
                {wch:15}, // Código
                {wch:80}, // Nombre producto
                {wch:10}, // Cantidad
                {wch:15}, // Tipo
                {wch:15}, // Almacén
                {wch:50}, // Descripción
                {wch:20}  // Responsable
            ];

            var elt = document.getElementById('movementsTable');
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(elt, {dateNF:'yyyy-mm-dd'})

            ws['!cols'] = wscols;

            XLSX.utils.book_append_sheet(wb, ws, 'movimientos_stock');
            
            return XLSX.writeFile(wb, fn || ('movimientos_stock_<?php echo date('Y-m-d'); ?>.' + (type || 'xlsx')));
        }
    </script>
</body>
</html> 