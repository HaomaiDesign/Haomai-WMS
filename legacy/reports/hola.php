<?php
$sql0 = "WITH totalStock AS (
				SELECT prod.`unitBarcode`, SUM(stock) OVER (PARTITION BY prod.`unitBarcode`) AS totalStock
				FROM products prod
				INNER JOIN stocklogs sl ON prod.id = sl.`productId`
				GROUP BY prod.`unitBarcode`
			),
			stockByDate AS (
				SELECT prod.`unitBarcode`, prod.`minStock`, stock, ROW_NUMBER() OVER (PARTITION BY prod.`unitBarcode` ORDER BY date DESC) AS rn
				FROM products prod
				INNER JOIN stocklogs sl ON prod.id = sl.`productId`
				AND sl.stock > 0
			)
		SELECT sbd.`unitBarcode`, sbd.stock, SUM(stock) AS sumIncome, totalStock, sbd.`minStock`
		FROM totalStock ts
		INNER JOIN stockByDate sbd ON ts.`unitBarcode` = sbd.`unitBarcode`
		WHERE rn <= 2
		GROUP BY sbd.`unitBarcode`, totalStock
		ORDER BY sbd.`unitBarcode`ASC;";

echo $sql0;

$stmt0 = mysqli_query( $conn, $sql0); 

if ( $stmt0 ) {
	echo 'entre al stmt0';
	while( $row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC ))  {
		if ($row0['totalStock'] < ($row0['sumIncome']*0.6)){
			$unitBarcodes[] = $row0['unitBarcode'];
			echo $row0['unitBarcode'];
		}
	}
	echo 'sali del while';
}
echo 'sali del stmt0';
echo $unitBarcodes;
$sql2 = "UPDATE products SET lowStock=1 WHERE unitBarcode IN (";

for ($i = 0; $i < count($unitBarcodes); $i++) {
	if ($i < count($unitBarcodes)-1)
		$sql2.= "'".$unitBarcodes[$i]."', ";
	else
		$sql2.= "'".$unitBarcodes[$i]."'";
}

$sql2 .= ");";
// $stmt2 = mysqli_query( $conn, $sql2);
print_r($unitBarcodes);
?>