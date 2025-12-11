<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php require_once '../PHPExcel.php'; ?>

<?php
	echo "HOLA";
    // Create your database query
    $query = "SELECT code,name,subtitle,category,brand,priceRetail,priceWholesale,packWholesale,unitBarcode,description,flagMarket,sku FROM product WHERE companyId=". $_SESSION['user']['companyId'] ."ORDER BY id ASC";  
    //echo $query;

    // Execute the database query
    $stmt = mysqli_query($conn, $query); // or die(sqlsrv_error());
    if(!$stmt){
        $error = 1;    
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        print_r( mysqli_error($conn), true);
        $_SESSION['notification']['type'] = "error";
        $_SESSION['notification']['message'] = "Hubo un error al generar la planilla.";
        echo "<script> location.href='productsList.php?tableStatus=view&target=sale&error=1' </script>";
    }  

    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel(); 
    // Set the active Excel worksheet to sheet 0
    $objPHPExcel->setActiveSheetIndex(0); 
    $objPHPExcel->getActiveSheet()->setTitle("Export");


    // Initialise the Excel row number
    $rowCount = 1; 
    $rowInsertExcel = 2;   //Bcz of the headers at row 1

    $letters = array('A','B','C','D','E','F','G','H','I','J','K','L');
    $lettersHeader = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1');
    $namesHeader = array('Code','Name','Subtitle','Category','Brand','Priceretail','Pricewholesale','Packwholesale','Barcode','Description','Market','Haomai ID'); //Market = flagMarket
    $lenLetters = count($letters);

    //HEADER INSERT
    for($i=0; $i<$lenLetters; $i++){
        $objPHPExcel->getActiveSheet()->SetCellValue($lettersHeader[$i], $namesHeader[$i]);
    }

    while($row = mysqli_fetch_array( $stmt, MYSQLI_NUM)){ 
        //ROW INSERT
        for($i=0; $i<$lenLetters; $i++){
            $objPHPExcel->getActiveSheet()->SetCellValue($letters[$i].$rowInsertExcel, $row[$i]);
        }

        $rowCount++; 
        $rowInsertExcel ++;
    } 

    /*$lettersHide = array('A','B','C','D','G','I','K','O','P','Q','R','S','T','U','V','X','Z','AA');
    $lenLettersHide = count($lettersHide);
    //COLUMNS HIDE
    for($i=0; $i<$lenLettersHide; $i++){
        $objPHPExcel->getActiveSheet()->getColumnDimension($lettersHide[$i])->setVisible(false);
    }*/
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setVisible(false);


    // PROTEGIDO
    
    $objPHPExcel->getActiveSheet()->getProtection()->setPassword('haomai2020');
    $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);  

    $lettersUnprotect = $letters;
    $lenLettersUnprotect = count($lettersUnprotect);

    $objPHPExcel->getActiveSheet()->getStyle('A2:K'.$rowInsertExcel)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
    /*$objPHPExcel->getActiveSheet()->getStyle('H2:H'.$rowInsertExcel)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
    $objPHPExcel->getActiveSheet()->getStyle('J2:J'.$rowInsertExcel)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
    $objPHPExcel->getActiveSheet()->getStyle('L2:N'.$rowInsertExcel)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
    $objPHPExcel->getActiveSheet()->getStyle('W2:Y'.$rowInsertExcel)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);*/

    for($i = 0; $i < $lenLettersUnprotect; $i++){
        $objPHPExcel->getActiveSheet()->getStyle($lettersUnprotect[$i])->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
    }
    $objPHPExcel->getActiveSheet()->freezePane('M2');






/*
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="userList.xls"');
header('Cache-Control: max-age=0'); //SIN ESTO TAMBIEN FUNCIONABA PERO LO DEJO IGUAL, DESPUES VER QUE HACE ESTO
*/

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="MisProductos.xlsx"');
header('Cache-Control: max-age=0'); //SIN ESTO TAMBIEN FUNCIONABA PERO LO DEJO IGUAL, DESPUES VER QUE HACE ESTO

ob_end_clean();   //HAY ESPACIOS, NO SE DONDE, ESTO TIENE QUE ESTAR ACA SI O SIIIIIIIIIIIIII
$objWriter->save('php://output');

mysqli_free_result($stmt);
mysqli_close($conn);
  			

?>