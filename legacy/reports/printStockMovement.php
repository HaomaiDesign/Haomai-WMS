<?php
// Iniciar la sesión y establecer la zona horaria
session_start();
include '../system/db.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user']['id'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['language']['Stock Movement Report'] ?? 'Reporte de Movimientos de Stock'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-subtitle {
            font-size: 14px;
            margin-bottom: 15px;
        }
        .filter-info {
            margin-bottom: 15px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            color: white;
        }
        .badge-received {
            background-color: #28a745;
        }
        .badge-delivered {
            background-color: #dc3545;
        }
        .badge-checked {
            background-color: #17a2b8;
        }
        .print-controls {
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        @media print {
            .print-controls {
                display: none;
            }
            body {
                margin: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
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
    $warehouseName = $_SESSION['language']['All Warehouses'] ?? "Todos los Depósitos";
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
    $totalRows = mysqli_num_rows($movementsResult);

    // Formatear fechas para el título
    $formattedDateFrom = date('d/m/Y', strtotime($dateFrom));
    $formattedDateTo = date('d/m/Y', strtotime($dateTo));

    // Determinar el tipo de movimiento para el título
    $movementTypeTitle = $_SESSION['language']['All Movements'] ?? "Todos los Movimientos";
    if ($movementType == '0') {
        $movementTypeTitle = $_SESSION['language']['Only Incomes'] ?? "Solo Entradas";
    } elseif ($movementType == '1') {
        $movementTypeTitle = $_SESSION['language']['Only Outcomes'] ?? "Solo Salidas";
    } elseif ($movementType == '2') {
        $movementTypeTitle = $_SESSION['language']['Only Corrections'] ?? "Solo Correcciones";
    }
    ?>

    <div class="print-controls">
        <button class="btn btn-primary" onclick="window.print();">
            <i class="fas fa-print"></i> <?php echo $_SESSION['language']['Print'] ?? 'Imprimir'; ?>
        </button>
        <button class="btn btn-secondary" onclick="window.close();">
            <i class="fas fa-times"></i> <?php echo $_SESSION['language']['Close'] ?? 'Cerrar'; ?>
        </button>
    </div>

    <div class="report-header">
        <div class="report-title"><?php echo $_SESSION['language']['Stock Movement Report'] ?? 'Reporte de Movimientos de Stock'; ?></div>
        <div class="report-subtitle"><?php echo $_SESSION['user']['businessName']; ?></div>
    </div>

    <div class="filter-info">
        <strong><?php echo $_SESSION['language']['Date Range'] ?? 'Rango de Fecha'; ?>:</strong> <?php echo $formattedDateFrom; ?> - <?php echo $formattedDateTo; ?><br>
        <strong><?php echo $_SESSION['language']['Warehouse'] ?? 'Depósito'; ?>:</strong> <?php echo $warehouseName; ?><br>
        <strong><?php echo $_SESSION['language']['Movement Type'] ?? 'Tipo de Movimiento'; ?>:</strong> <?php echo $movementTypeTitle; ?><br>
        <?php if (!empty($search)): ?>
        <strong><?php echo $_SESSION['language']['Search'] ?? 'Búsqueda'; ?>:</strong> <?php echo htmlspecialchars($search); ?><br>
        <?php endif; ?>
        <strong><?php echo $_SESSION['language']['Total records'] ?? 'Total de registros'; ?>:</strong> <?php echo $totalRows; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center"><?php echo $_SESSION['language']['Date'] ?? 'Fecha'; ?></th>
                <th class="text-center"><?php echo $_SESSION['language']['Time'] ?? 'Hora'; ?></th>
                <th class="text-center"><?php echo $_SESSION['language']['Code'] ?? 'Código'; ?></th>
                <th><?php echo $_SESSION['language']['Product Name'] ?? 'Producto'; ?></th>
                <th class="text-center"><?php echo $_SESSION['language']['Quantity'] ?? 'Cantidad'; ?></th>
                <th class="text-center"><?php echo $_SESSION['language']['Type'] ?? 'Tipo'; ?></th>
                <th class="text-center"><?php echo $_SESSION['language']['Warehouse'] ?? 'Depósito'; ?></th>
                <th><?php echo $_SESSION['language']['Description'] ?? 'Descripción'; ?></th>
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
                    $badgeClass = "";
                    switch ($row['type']) {
                        case 0:
                            $type = $_SESSION['language']['Received'] ?? "Recibido";
                            $badgeClass = "badge-received";
                            break;
                        case 1:
                            $type = $_SESSION['language']['Delivered'] ?? "Entregado";
                            $badgeClass = "badge-delivered";
                            break;
                        case 2:
                            $type = $_SESSION['language']['Corrected'] ?? "Corregido";
                            $badgeClass = "badge-checked";
                            break;
                    }
                    
                    echo "<tr>";
                    echo "<td class='text-center'>{$date}</td>";
                    echo "<td class='text-center'>{$time}</td>";
                    echo "<td class='text-center'>{$row['unitBarcode']}</td>";
                    echo "<td>{$row['productName']}</td>";
                    echo "<td class='text-center'><strong>{$row['stock']}</strong></td>";
                    echo "<td class='text-center'><span class='badge {$badgeClass}'>{$type}</span></td>";
                    echo "<td class='text-center'>{$row['warehouseName']}</td>";
                    echo "<td>{$row['description']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>";
                echo $_SESSION['language']['No movements found for the selected criteria'] ?? 'No se encontraron movimientos para los criterios seleccionados';
                echo "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        // Imprimir automáticamente al cargar completamente
        window.onload = function() {
            // Esperar a que las fuentes y estilos se carguen
            setTimeout(function() {
                // No imprimir automáticamente, dejar que el usuario decida
                // window.print();
            }, 500);
        };
    </script>
</body>
</html> 