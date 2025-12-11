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
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;  // Asegurar valor mínimo
$summaryPage = isset($_GET['summaryPage']) ? max(1, intval($_GET['summaryPage'])) : 1;  // Asegurar valor mínimo
$limit = 50; // Establecemos 50 filas por página
$offset = ($page - 1) * $limit;
$summaryLimit = 50; // Límite para la tabla de resumen
$summaryOffset = ($summaryPage - 1) * $summaryLimit;

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

// Contar total de movimientos para paginación
$countSql = "SELECT COUNT(*) AS total 
             FROM products 
             LEFT JOIN stockLogs ON products.id=stockLogs.productId 
             INNER JOIN users ON stockLogs.userId=users.id 
             INNER JOIN warehouse ON stockLogs.warehouseId=warehouse.id 
             WHERE products.businessId=" . $_SESSION['user']['businessId'] . 
             $dateCondition . 
             $productCondition . 
             $whCondition .
             $searchCondition .
             $movementTypeCondition;

$countResult = mysqli_query($conn, $countSql);
if ($countResult && mysqli_num_rows($countResult) > 0) {
    $totalRows = mysqli_fetch_assoc($countResult)['total'];
} else {
    $totalRows = 0; // En caso de error o sin resultados
}
$totalPages = ($totalRows > 0) ? ceil($totalRows / $limit) : 1;

// Asegurar que la página actual es válida
if ($page > $totalPages && $totalRows > 0) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
    // Ya no redireccionamos automáticamente, sólo corregimos los valores
}

// Si estamos en una página mayor a la 1 y no hay resultados, volvemos a la página 1
if ($page > 1 && $totalRows == 0) {
    $page = 1;
    $offset = 0;
    // Creamos parámetros específicos para esta redirección, conservando sólo lo necesario
    $redirectParams = $paginationParams;
    $redirectUrl = generatePaginationUrl($redirectParams, 'page', 1);
    echo "<!-- DEBUG: No hay resultados en la página $page, redirigiendo a $redirectUrl -->";
    header("Location: $redirectUrl");
    exit;
}

// Obtener datos de movimientos con límite para paginación
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
                    products.unitBarcode ASC
                LIMIT " . $offset . "," . $limit;

$movementsResult = mysqli_query($conn, $movementsSql);

// Verificar si hay errores en la consulta
if (!$movementsResult) {
    // Establecer valores por defecto para evitar errores
    $movementsResult = false;
    $totalRows = 0;
    $totalPages = 1;
    $page = 1;
    $offset = 0;
}

// Formatear fechas para el título
$formattedDateFrom = date('d/m/Y', strtotime($dateFrom));
$formattedDateTo = date('d/m/Y', strtotime($dateTo));

// Construir URL para paginación
$paginationParams = [];
// Conservar todos los parámetros de filtro necesarios
if ($year != 'all') {
    $paginationParams['year'] = $year;
}
if ($month != 'all') {
    $paginationParams['month'] = $month;
}
if (!empty($dateFrom) && $dateFrom != date('Y-m-d', strtotime('-30 days'))) {
    $paginationParams['dateFrom'] = $dateFrom;
}
if (!empty($dateTo) && $dateTo != date('Y-m-d')) {
    $paginationParams['dateTo'] = $dateTo;
}
if ($warehouseId != 'allWarehouse') {
    $paginationParams['warehouseId'] = $warehouseId;
}
if (!empty($search)) {
    $paginationParams['search'] = $search;
}
if ($movementType != 'all') {
    $paginationParams['movementType'] = $movementType;
}
// Solo incluir productId si está explícitamente definido en la URL actual
if (isset($_GET['productId']) && !empty($_GET['productId'])) {
    $paginationParams['productId'] = $_GET['productId'];
}

// Función para generar URL de paginación
function generatePaginationUrl($params, $pageType, $pageNum) {
    
    // Copia los parámetros para no modificar el original
    $urlParams = $params;
    
    // Establecer valor de la página (al menos 1)
    $urlParams[$pageType] = max(1, $pageNum);
    
    // Construir la URL
    $url = "stockMovementReport.php?";
    $parts = [];
    
    // Generar pares clave=valor para la URL (sólo para parámetros con valor)
    foreach ($urlParams as $key => $value) {
        // Omitir valores vacíos
        if (is_null($value) || $value === '') continue;
        
        // Asegurar que el valor está codificado correctamente para URL
        $parts[] = urlencode($key) . "=" . urlencode($value);
    }
    
    // Si no hay parámetros, al menos incluir el parámetro de página actual
    if (empty($parts)) {
        $parts[] = urlencode($pageType) . "=" . urlencode(max(1, $pageNum));
    }
    
    // Unir los parámetros y devolver la URL completa
    $finalUrl = $url . implode("&", $parts);
    
    return $finalUrl;
}

/**
 * Función para generar controles de paginación
 * @param int $currentPage Página actual
 * @param int $totalPages Total de páginas
 * @param int $totalItems Total de elementos
 * @param int $offset Desplazamiento actual
 * @param int $limit Límite por página
 * @param array $params Parámetros de la URL
 * @param string $pageType Tipo de página (page o summaryPage)
 * @return string HTML con los controles de paginación
 */
function generatePagination($currentPage, $totalPages, $totalItems, $offset, $limit, $params, $pageType) {
    $html = '<div class="d-flex justify-content-between align-items-center mt-4 mb-4">';
    
    // Información de registros
    $html .= '<div class="item-action">';
    $html .= $_SESSION['language']['Total records'] . ' ' . $totalItems;
    $html .= '</div>';
    
    // Navegación de paginación
    $html .= '<div class="item-action">';
    
    // Botón primera página
    $html .= '<a href="' . generatePaginationUrl($params, $pageType, 1) . '"';
    if ($currentPage == 1) {
        $html .= ' style="pointer-events: none;"';
    } else {
        $html .= ' style="color: black;"';
    }
    $html .= '><i class="fas fa-angle-double-left"></i></a>';
    
    // Botón página anterior
    $html .= '<a href="' . generatePaginationUrl($params, $pageType, max(1, $currentPage - 1)) . '"';
    if ($currentPage == 1) {
        $html .= ' style="pointer-events: none;"';
    } else {
        $html .= ' style="color: black;"';
    }
    $html .= '><i class="fas fa-angle-left"></i></a>';
    
    // Página actual
    $html .= '<a style="color: black;">';
    $html .= $_SESSION['language']['Page'] . ' ' . $currentPage . ' / ' . $totalPages;
    $html .= '</a>';
    
    // Botón página siguiente
    $html .= '<a href="' . generatePaginationUrl($params, $pageType, min($totalPages, $currentPage + 1)) . '"';
    if ($currentPage == $totalPages) {
        $html .= ' style="pointer-events: none;"';
    } else {
        $html .= ' style="color: black;"';
    }
    $html .= '><i class="fas fa-angle-right"></i></a>';
    
    // Botón última página
    $html .= '<a href="' . generatePaginationUrl($params, $pageType, $totalPages) . '"';
    if ($currentPage == $totalPages) {
        $html .= ' style="pointer-events: none;"';
    } else {
        $html .= ' style="color: black;"';
    }
    $html .= '><i class="fas fa-angle-double-right"></i></a>';
    
    $html .= '</div>';
    $html .= '</div>';
    
    return $html;
}

// URL para la paginación de movimientos
$movementsPaginationUrl = generatePaginationUrl($paginationParams, 'page', $page);

// Depuración de los parámetros de paginación
echo "<!-- 
DEBUG: Parámetros de paginación generados:
";
foreach ($paginationParams as $key => $value) {
    echo "$key: $value\n";
}
echo "-->";
?>

<div class="col-12">
    <!-- Card de Filtros -->
    <div class="card">
        <div class="card-status card-status-left bg-teal"></div>
        <!-- <div class="card-header">
            <h3 class="card-title" style="font-weight:bold;">Filtros</h3>
        </div> -->
        <div class="card-body">
            <form class="form-inline" action="stockMovementReport.php" method="GET">
                <div class="input-group mb-2 mr-sm-2" style="width: 150px">
                    <select class="form-control" id="year" name="year">
                        <option value="all"><?php echo $_SESSION['language']['All Years']; ?></option>
                        <?php
                        $currentYear = date('Y');
                        for ($i = $currentYear; $i >= $currentYear - 3; $i--) {
                            $selected = ($year == $i) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group mb-2 mr-sm-2" style="width: 160px">
                    <select class="form-control" id="month" name="month">
                        <option value="all"><?php echo $_SESSION['language']['All Months']; ?></option>
                        <?php
                        $months = [
                            '01' => $_SESSION['language']['January'],
                            '02' => $_SESSION['language']['February'],
                            '03' => $_SESSION['language']['March'],
                            '04' => $_SESSION['language']['April'],
                            '05' => $_SESSION['language']['May'],
                            '06' => $_SESSION['language']['June'],
                            '07' => $_SESSION['language']['July'],
                            '08' => $_SESSION['language']['August'],
                            '09' => $_SESSION['language']['September'],
                            '10' => $_SESSION['language']['October'],
                            '11' => $_SESSION['language']['November'],
                            '12' => $_SESSION['language']['December']
                        ];
                        foreach ($months as $key => $value) {
                            $selected = ($month == $key) ? 'selected' : '';
                            echo "<option value='$key' $selected>$value</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group mb-2 mr-sm-2" style="width: 200px">
                    <select class="form-control" id="warehouseId" name="warehouseId">
                        <option value="allWarehouse"><?php echo $_SESSION['language']['All Warehouses']; ?></option>
                        <?php
                        $warehousesSql = "SELECT id, name FROM warehouse WHERE businessId = " . $_SESSION['user']['businessId'];
                        $warehousesResult = mysqli_query($conn, $warehousesSql);
                        while ($wh = mysqli_fetch_assoc($warehousesResult)) {
                            $selected = ($warehouseId != 'allWarehouse' && $id == $wh['id']) ? 'selected' : '';
                            echo "<option value='{$wh['id']}_{$wh['name']}' $selected>{$wh['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group mb-2 mr-sm-2" style="width: 200px">
                    <select class="form-control" id="movementType" name="movementType">
                        <option value="all" <?php echo $movementType == 'all' ? 'selected' : ''; ?>><?php echo $_SESSION['language']['All Movements']; ?></option>
                        <option value="0" <?php echo $movementType == '0' ? 'selected' : ''; ?>><?php echo $_SESSION['language']['Only Incomes']; ?></option>
                        <option value="1" <?php echo $movementType == '1' ? 'selected' : ''; ?>><?php echo $_SESSION['language']['Only Outcomes']; ?></option>
                        <option value="2" <?php echo $movementType == '2' ? 'selected' : ''; ?>><?php echo $_SESSION['language']['Only Corrections']; ?></option>
                    </select>
                </div>
                <div class="input-group mb-2 mr-sm-2" style="width: 300px">
                    <input type="text" id="search" name="search" class="form-control" value="<?php echo htmlspecialchars($search); ?>" placeholder="<?php echo $_SESSION['language']['Search product']; ?>">
                </div>
                <input type="hidden" name="page" value="1">
                <button type="submit" class="btn btn-primary mb-2"><?php echo $_SESSION['language']['Apply Filters']; ?></button>
                <a href="stockMovementReport.php" class="btn btn-secondary mb-2 ml-2" style="color: white;">
                    <?php echo $_SESSION['language']['Clear Filters']; ?>
                </a>
            </form>
        </div>
    </div>

    <!-- Card de Tabla -->
    <div class="card">
        <div class="card-status card-status-left bg-teal"></div>
        <div class="card-header">
            <h3 class="card-title" style="font-weight:bold;"><?php echo $_SESSION['language']['Stock Movement Report']; ?></h3>

                <div class="item-action">
                    <a style="margin-left: 25px;" href="./printStockMovement.php?warehouseId=<?php echo $warehouseId; ?>&year=<?php echo $year; ?>&month=<?php echo $month; ?>&dateFrom=<?php echo $dateFrom; ?>&dateTo=<?php echo $dateTo; ?>&productId=<?php echo $productId; ?>&search=<?php echo $search; ?>&movementType=<?php echo $movementType; ?>" target="_blank" style="color: white !important;">
                        <i class="dropdown-icon fe fe-printer"></i>
                    </a>
                    <a style="margin-left: 5px;" href="exportStockMovementToExcel.php?warehouseId=<?php echo $warehouseId; ?>&year=<?php echo $year; ?>&month=<?php echo $month; ?>&dateFrom=<?php echo $dateFrom; ?>&dateTo=<?php echo $dateTo; ?>&productId=<?php echo $productId; ?>&search=<?php echo $search; ?>&movementType=<?php echo $movementType; ?>" target="_blank" style="color: white !important;">
                        <i class="dropdown-icon fas fa-file-excel"></i>
                    </a>
                </div>

            <div class="card-options">
                <div class="item-action">
                    <?php echo $_SESSION['language']['Total records'] . ' ' . $totalRows; ?>&nbsp&nbsp&nbsp
                </div>

                <div class="item-action">
                    <a href="<?php echo generatePaginationUrl($paginationParams, 'page', 1); ?>" <?php if ($page == 1) echo " style='pointer-events: none;'"; else echo " style='color: black;'"; ?>><i class="fas fa-angle-double-left"></i></a>
                    <a href="<?php echo generatePaginationUrl($paginationParams, 'page', max(1, $page - 1)); ?>" <?php if ($page == 1) echo " style='pointer-events: none;'"; else echo " style='color: black;'"; ?>><i class="fas fa-angle-left"></i></a>
                    <a style="color: black;"><?php echo $_SESSION['language']['Page'] . ' ' . $page . ' / ' . $totalPages; ?>&nbsp</a>
                    <a href="<?php echo generatePaginationUrl($paginationParams, 'page', min($totalPages, $page + 1)); ?>" <?php if ($page == $totalPages) echo " style='pointer-events: none;'"; else echo " style='color: black;'"; ?>><i class="fas fa-angle-right"></i></a>
                    <a href="<?php echo generatePaginationUrl($paginationParams, 'page', $totalPages); ?>" <?php if ($page == $totalPages) echo " style='pointer-events: none;'"; else echo " style='color: black;'"; ?>><i class="fas fa-angle-double-right"></i></a>&nbsp
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="table" class="table table-hover table-outline table-vcenter text-truncate card-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Date']; ?></th>
                        <th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Time']; ?></th>
                        <th class="text-center" style="width:5%;font-weight:bold;"><?php echo $_SESSION['language']['Code']; ?></th>
                        <th style="width:35%;font-weight:bold;"><?php echo $_SESSION['language']['Product Name']; ?></th>
                        <th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Quantity']; ?></th>
                        <th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Type']; ?></th>
                        <th class="text-center" style="width:10%;font-weight:bold;"><?php echo $_SESSION['language']['Warehouse']; ?></th>
                        <th style="width:15%;font-weight:bold;"><?php echo $_SESSION['language']['Description']; ?></th>
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
                                    $type = "Recibido";
                                    $badgeClass = "badge-received";
                                    break;
                                case 1:
                                    $type = "Entregado";
                                    $badgeClass = "badge-delivered";
                                    break;
                                case 2:
                                    $type = "Corregido";
                                    $badgeClass = "badge-checked";
                                    break;
                            }
                            
                            $productName = (strlen($row['productName']) > 150) 
                                          ? substr($row['productName'], 0, 150) . "..." 
                                          : $row['productName'];
                            
                            echo "<tr>";
                            echo "<td class='text-center'><div>{$date}</div></td>";
                            echo "<td class='text-center'><div>{$time}</div></td>";
                            echo "<td class='text-center'><div>{$row['unitBarcode']}</div></td>";
                            echo "<td><div>{$productName}</div></td>";
                            echo "<td class='text-center'><div><strong>{$row['stock']}</strong></div></td>";
                            echo "<td class='text-center'><div><span class='badge {$badgeClass}'>{$type}</span></div></td>";
                            echo "<td class='text-center'><div>{$row['warehouseName']}</div></td>";
                            echo "<td><div>{$row['description']}</div></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No se encontraron movimientos para los criterios seleccionados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .card {
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
    }
    .card-status {
        position: absolute;
        top: -1px;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 7px 7px 0 0;
    }
    .card-status-left {
        right: auto;
        bottom: 0;
        height: auto;
        width: 3px;
        border-radius: 3px 0 0 3px;
    }
    .bg-teal {
        background-color: #20c997 !important;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        background-color: #fff;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .card-title {
        margin-bottom: 0;
        color: #495057;
    }
    .card-options {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .item-action {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .item-action a {
        text-decoration: none;
        font-size: 16px;
    }
    .item-action a[style*="pointer-events: none"] {
        color: #ccc !important;
        cursor: not-allowed;
    }
    .btn-success {
        color: white;
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        color: white;
        background-color: #218838;
        border-color: #1e7e34;
    }
    .btn-info {
        color: white;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    .btn-info:hover {
        color: white;
        background-color: #138496;
        border-color: #117a8b;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
    .mr-1 {
        margin-right: 0.25rem !important;
    }
    .mr-2 {
        margin-right: 0.5rem !important;
    }
    .table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }
    .table th {
        font-weight: 600;
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
    .badge-received {
        background-color: #28a745;
        color: white;
    }
    .badge-delivered {
        background-color: #dc3545;
        color: white;
    }
    .badge-checked {
        background-color: #17a2b8;
        color: white;
    }
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>