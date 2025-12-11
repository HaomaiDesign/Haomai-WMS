<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>
<?php include "../PHPExcel/IOFactory.php";?>

<?php
    set_time_limit(0);
    if(!empty($_FILES["excel"]["tmp_name"])){
  
        $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
        $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
        $lenCol = 12;   //Cuantas columnas modifica el usuario
        $lineErrors = array();  
        $rowData = array();

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
            $highestRow = $worksheet->getHighestRow();
            $rowCountBlank = 0;
            for($row=1; $row <= $highestRow; $row++){
                if($row > 1){
                    $cellCountBlank = 0;
                    for($i = 0; $i < $lenCol; $i++){
                        echo "Leo cell";
                        $rowData[$i] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
                        if($rowData[$i] == ""){
                            $cellCountBlank += 1;
                        }
                    }                    
                    if($cellCountBlank >= $lenCol-1){ //Si tengo 11 celdas o mas vacias (12 si el sku es vacio tmb)
                        $rowCountBlank +=1; //Hay una linea vacia
					echo $rowCountBlank;
                        if($rowCountBlank == 10){
                            break;
                        } else {
                            continue;
                        }
                    } else {
                        $rowCountBlank = 0; //Reseteo el count si encuentro linea no vacia
						echo $rowCountBlank;
                    }
echo "1";
                    //Campos que pueden ser vacios.
                    $optionalDataIns = " ";
                    $optionalDataVal = " ";
                    $optionalDataUpd = " ";
                    if($rowData[4] != "") {$optionalDataIns .= "brand,"; $optionalDataVal .= "N'".$rowData[4]."',"; $optionalDataUpd .= "brand=N'".$rowData[4]."',";}
                    if($rowData[9] != "") {$optionalDataIns .="description,"; $optionalDataVal .= "N'".$rowData[9]."',"; $optionalDataUpd .= "description=N'".$rowData[9]."',";}
                    if($rowData[7] != "") {$optionalDataIns .="packWholesale,"; $optionalDataVal .= $rowData[7].","; $optionalDataUpd .= " packWholesale=".$rowData[7].",";}
                    if($rowData[7] == "") {$optionalDataIns .="packWholesale,"; $optionalDataVal .= "1,"; $optionalDataUpd .= " packWholesale= 1,";}

echo "2";
                    if($rowData[11] == ""){ //Es el sku
                        $sql = "INSERT INTO product (".$optionalDataIns."companyId, currency, unitBarcode, name, subtitle, category, priceRetail, priceWholesale) 
                                values (".$optionalDataVal." ".$_SESSION['user']['companyId']." , 'ARS' , ".$rowData[8]." , N'".$rowData[1]."' ,N'".$rowData[2]."' , N'".$rowData[3]."' ,".$rowData[5]." ,".$rowData[6].");";
                                
                        $stmt = mysqli_query( $conn, $sql);
                        if($stmt){
                            $sql1 = "SELECT COUNT(id) as items FROM product WHERE companyId=".$_SESSION['user']['companyId'].";";  		
                            $stmt1 = mysqli_query( $conn, $sql1);  
                            $date = date('Y-m-d H:i:s');
                              
                            if ( $stmt1 ) {
                                $row1 = mysqli_fetch_array( $stmt1, MYSQLI_ASSOC );  
                                $getItemId = $row1['items'];	
                            }
                        
                            $sql2 = "SELECT TOP 1 id FROM product ORDER BY id DESC";  
                            $stmt2 = mysqli_query( $conn, $sql2);  
                            if ( $stmt2 ) {
                                $row2 = mysqli_fetch_array( $stmt2, MYSQLI_ASSOC );  
                                $getProductId = $row2['id'];	
                            }
                            
                            $sku = "AR-".str_pad($_SESSION['user']['companyId'], 4, "0", STR_PAD_LEFT)."-".str_pad($getItemId, 4, "0", STR_PAD_LEFT);
                            echo "3";
                            if ($rowData[0]!="")
                                $code = $rowData[0];
                            else
                                $code = $sku;

                            $addFlagMarket = "flagMarket=1";
                            if($rowData[10] != ""){
                                $addFlagMarket = "flagMarket=" . $rowData[10];
                            }
                            
                        
                            $sql3 = "UPDATE product SET creationDate='".$date."', flagActive=1, ".$addFlagMarket.", flagStock=1, flagPurchase=1, code=N'".$code."', sku=N'".$sku."' WHERE id=".$getProductId.";"; 	
                            $stmt3 = mysqli_query( $conn, $sql3);
                        }
                    } else {
                        $sql = " UPDATE product  SET ".$optionalDataUpd." code= N'".$rowData[0]."', name=N'".$rowData[1]."', category=N'".$rowData[3]."', priceRetail = ".$rowData[5].", priceWholesale = ".$rowData[6].", flagMarket=".$rowData[10]." WHERE companyId = ".$_SESSION['user']['companyId']." AND sku = '".$rowData[11]."';";
                        $stmt = mysqli_query( $conn, $sql);
                    }
                    
                    
                    if(!$stmt){ //Si entra aca posiblemente el usuario metio verdura en el sheet en un campo donde no debia (Ej: uno donde admite solo nums)                        
                        $productData = array($rowData[0],$rowData[1]);
                        array_push($lineErrors,$productData);
                    }  
                    mysqli_free_result($stmt);
                }         
            }
        } 
		echo $sql;
		echo $sql1;
		echo $sql2;
		echo $sql3;
        mysqli_close($conn);
        if(!empty($lineErrors)){
            $_SESSION['wrongLines'] = $lineErrors;
        }

    } else {
        $_SESSION['notification']['type'] = "error";
        $_SESSION['notification']['message'] = "Hubo un error al cargar el archivo.";
        //echo "<script> location.href='productsList2.php?tableStatus=view&target=sale&error=1' </script>";

    }
    $_SESSION['notification']['type'] = "success";      
	$_SESSION['notification']['message'] = "Se ha cargado el archivo exitosamente.";    			
   // echo "<script> location.href='productsList2.php?tableStatus=view&target=sale' </script>";

//Tip memoria: Error = 1: $_POST no recibio el worksheet
?>