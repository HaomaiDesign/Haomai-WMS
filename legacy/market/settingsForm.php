			<?php 
			//Cancela la vinculacion: access denied, sino Get[code] es si se vinculó
			if ( (strcmp($_GET['error'],'access-denied') == 0 ) ||  isset($_GET['code']) ){	// "Hardcodeamos" esto para que no rompa al volver de MP.
				$_GET['formStatus']='view';
			}
			?>
			<?php if (($_GET['formStatus']=='create')or($_GET['formStatus']=='view')) { 
			
			$_SESSION['form']['table']= 'swrSettings';  
			if ($_GET['formStatus']=='view')
			{
				
				
				$sql0 = "SELECT COUNT(companyId) as company FROM swrSettings WHERE companyId=".$_SESSION['eShop']['companyId'].";";  
				$stmt0 = mysqli_query( $conn, $sql0); 
				
				
				if ( $stmt0 ) {
					$row0 = mysqli_fetch_array( $stmt0, MYSQLI_ASSOC );
					
					if ($row0['company']==0) {
						$sql2 = "INSERT INTO swrSettings (companyId) VALUES (".$_SESSION['user']['companyId'].");";  
						$stmt2 = mysqli_query( $conn, $sql2);
					}
					
				}
				
				$_SESSION['form']['condition'] = "companyId=".$_SESSION['user']['companyId'];
				include "../system/formQuery.php"; // Get data from DB
				
			}
			?>
			
			<?php $_SESSION['form']['quantity'] = -1;?>

			<?php #Código back - Mercado pago

				$APP_ID = "724439895016636";
				$redirect_uri = "https://www.haomai.com.ar/market/settings.php";
			
				//Obtengo access token si ya existe. Acordarse de que vence cada 6 meses.
				$sql3 = "SELECT mlAccessToken, mlUserId FROM company WHERE id=".$_SESSION['user']['companyId'].";";  
				$stmt3 = mysqli_query( $conn, $sql3); 
				
				if ( $stmt3 ) {					
					$row3 = mysqli_fetch_array( $stmt3, MYSQLI_ASSOC );
					if ($row3['mlAccessToken']!="") {
						$mlAccessToken = $row3['mlAccessToken'];
						$mlUserId = $row3['mlUserId'];
					}
			
				}
				if ($mlAccessToken=="") {
					if(isset($_GET['code'])){
						$ch = curl_init('https://api.mercadopago.com/oauth/token');
			
						$data->client_secret = 'APP_USR-724439895016636-070100-4c922edc8dac38ca4a96a058c1268a03-578417178'; //De Haomai MP App access token prod
						$data->grant_type = 'authorization_code';
						$data->code = $_GET['code']; //Llega del redirect de MP luego de autorizar
						$data->redirect_uri = $redirect_uri;
			
						$data_encoded = json_encode($data);
			
						//adjunto data al curl
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data_encoded);
						
						//seteado de -H (Headers creo)
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
			
						//return response instead of outputting
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
						//set method
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			
						//ejecucion del request
						$exec = curl_exec($ch);
						$err = curl_error($ch);
			
						//catcheo de errores
						
						if ($err) {
							echo "cURL Error #:" . $err;
							print_r($result);
						} else {
							$result = json_decode($exec);
							//print_r($result);
							
							$expirationDate = date_create(); 
							$expirationDate = date_add($expirationDate,date_interval_create_from_date_string("6 months"));
							$expirationDate = date_format($expirationDate,"Y-m-d");
							
							$sql1 = "UPDATE company SET mlAccessToken='". $result->access_token ."', mlPublicKey='". $result->public_key ."', mlRefreshToken='". $result->refresh_token ."', mlUserId='". $result->user_id ."', mlRefreshDate='".$expirationDate."' WHERE id=".$_SESSION['user']['companyId'].";";  
							$stmt1 = mysqli_query( $conn, $sql1); 
							if ($stmt1){
								$_SESSION['notification']['type'] = "success";
								$_SESSION['notification']['message'] = "MercadoPago linked properly"; 
								$mlAccessToken = $result->access_token;
								$mlUserId = $result->user_id;
							}else{
								$_SESSION['notification']['type'] = "error";
								$_SESSION['notification']['message'] = "Error while linking MercadoPago"; 
							}
						}
					}
				}
			
			?>


		  <div class="col-12">
			<div class="card">
				<div class="card-status card-status-left bg-teal"></div>
				<div class="card-header">
					<h3 class="card-title" style="font-weight:bold;">
						<?php echo $_SESSION['language']['Settings'];?>
					</h3>
				</div>


			

				
                <form action="settingsUpdate.php<?php if ($_GET['formStatus']=='view') echo '?formStatus=edit'; ?>" method="post" enctype="multipart/form-data">
                
				<div class="card-body">
					<div class="row">
					
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
							  <label class="form-label"><?php echo $_SESSION['language']['Ecommerce QR'];?> <a href="http://haomai.com.ar/ecommerce<?php if ($_SESSION['user']['flagCompanyVerified']==1) echo "/company/3"; ?>/index.php?companyId=<?php echo $_SESSION['user']['companyId'];?>"  target="_blank"> <i class="fe fe-external-link"></i></a></label>
							  
							 
							  <?php if ($_SESSION['user']['flagCompanyVerified']==1) { ?>
								<img src="qrGenerator.php?data=http://haomai.com.ar/ecommerce/company/3/index.php?companyId=<?php echo $_SESSION['user']['companyId'];?>&logo=<?php echo $_SESSION['user']['logo']; ?>">	
							  <?php } else { ?>
							    <img src="qrGenerator.php?data=http://haomai.com.ar/ecommerce/index.php?companyId=<?php echo $_SESSION['user']['companyId'];?>&logo=<?php echo $_SESSION['user']['logo']; ?>">	
							  <?php };  ?>	
								
								
								
							  <!--<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http://haomai.com.ar/ecommerce/index.php?companyId=<?php echo $_SESSION['user']['companyId']; ?>" />-->
								
							</div>
						</div>
					</div>
				</div>
				
				<?php if ($_SESSION['user']['subscription']>0) { ?>
				
				<div class="card-body">
					<div class="row">
						
						<div class="col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
							<div class="form-label"><?php echo $_SESSION['language']['Carousel'];?> 1</div>						
							  <input type="file" id="carouselOne"  name="carouselOne" >						
							  <?php $_SESSION['form']['data'][]='carouselOne'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>							
						  </div>
							<div class="card p-3">
							  <a href="javascript:void(0)" class="mb-3">
								<img src="<?php if ($_SESSION['form']['server']['carouselOne']!="") echo $_SESSION['form']['server']['carouselOne']; else echo "../showroom/assets/images/banners/slide1.jpg";?>" alt="Carousel 1" height="150px" width="100%" align="middle" class="rounded">
							  </a>
							  <div class="d-flex align-items-center px-2">
								<div class="ml-auto text-muted">
								  <a href="settingsUpdate.php?formStatus=view&action=remove&item=1&c2=<?php echo $_SESSION['form']['server']['carouselTwo']; ?>&c3=<?php echo $_SESSION['form']['server']['carouselThree']; ?>&c4=<?php echo $_SESSION['form']['server']['carouselFour']; ?>&c5=<?php echo $_SESSION['form']['server']['carouselFive']; ?>&c6=<?php echo $_SESSION['form']['server']['carouselSix']; ?>" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-trash mr-1"></i> <?php echo $_SESSION['language']['Remove'];?></a>
								</div>
							  </div>
							</div>
						  
						</div>
						
						<div class="col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
							<div class="form-label"><?php echo $_SESSION['language']['Carousel'];?> 2</div>						
							  <input type="file" id="carouselTwo"  name="carouselTwo" >						
							  <?php $_SESSION['form']['data'][]='carouselTwo'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>							
						  </div>
							<div class="card p-3">
							  <a href="javascript:void(0)" class="mb-3">
								<img src="<?php if ($_SESSION['form']['server']['carouselTwo']!="") echo $_SESSION['form']['server']['carouselTwo']; else echo "../showroom/assets/images/banners/slide2.jpg";?>" alt="Carousel 2" height="150px" width="100%" align="middle" class="rounded">
							  </a>
							  <div class="d-flex align-items-center px-2">
								<div class="ml-auto text-muted">
								  <a href="settingsUpdate.php?formStatus=view&action=remove&item=2&c3=<?php echo $_SESSION['form']['server']['carouselThree']; ?>&c4=<?php echo $_SESSION['form']['server']['carouselFour']; ?>&c5=<?php echo $_SESSION['form']['server']['carouselFive']; ?>&c6=<?php echo $_SESSION['form']['server']['carouselSix']; ?>" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-trash mr-1"></i> <?php echo $_SESSION['language']['Remove'];?></a>
								</div>
							  </div>
							</div>

						</div>
					
						<div class="col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
							<div class="form-label"><?php echo $_SESSION['language']['Carousel'];?> 3</div>						
							  <input type="file" id="carouselThree"  name="carouselThree" >						
							  <?php $_SESSION['form']['data'][]='carouselThree'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>							
						  </div>
							<div class="card p-3">
							  <a href="javascript:void(0)" class="mb-3">
								<img src="<?php if ($_SESSION['form']['server']['carouselThree']!="") echo $_SESSION['form']['server']['carouselThree']; else echo "../showroom/assets/images/banners/slide3.jpg";?>" alt="Carousel 3" height="150px" width="100%" align="middle" class="rounded">
							  </a>
							  <div class="d-flex align-items-center px-2">
								<div class="ml-auto text-muted">
								  <a href="settingsUpdate.php?formStatus=view&action=remove&item=3&c4=<?php echo $_SESSION['form']['server']['carouselFour']; ?>&c5=<?php echo $_SESSION['form']['server']['carouselFive']; ?>&c6=<?php echo $_SESSION['form']['server']['carouselSix']; ?>" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-trash mr-1"></i> <?php echo $_SESSION['language']['Remove'];?></a>
								</div>
							  </div>
							</div>

						</div>
						
						<div class="col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
							<div class="form-label"><?php echo $_SESSION['language']['Carousel'];?> 4</div>						
							  <input type="file" id="carouselFour"  name="carouselFour" >						
							  <?php $_SESSION['form']['data'][]='carouselFour'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>							
						  </div>
							<div class="card p-3">
							  <a href="javascript:void(0)" class="mb-3">
								<img src="<?php if ($_SESSION['form']['server']['carouselFour']!="") echo $_SESSION['form']['server']['carouselFour']; else echo "../showroom/assets/images/banners/slide1.jpg";?>" alt="Carousel 1" height="150px" width="100%" align="middle" class="rounded">
							  </a>
							  <div class="d-flex align-items-center px-2">
								<div class="ml-auto text-muted">
								  <a href="settingsUpdate.php?formStatus=view&action=remove&item=4&c5=<?php echo $_SESSION['form']['server']['carouselFive']; ?>&c6=<?php echo $_SESSION['form']['server']['carouselSix']; ?>" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-trash mr-1"></i> <?php echo $_SESSION['language']['Remove'];?></a>
								</div>
							  </div>
							</div>
						  
						</div>
						
						<div class="col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
							<div class="form-label"><?php echo $_SESSION['language']['Carousel'];?> 5</div>						
							  <input type="file" id="carouselFive"  name="carouselFive" >						
							  <?php $_SESSION['form']['data'][]='carouselFive'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>							
						  </div>
							<div class="card p-3">
							  <a href="javascript:void(0)" class="mb-3">
								<img src="<?php if ($_SESSION['form']['server']['carouselFive']!="") echo $_SESSION['form']['server']['carouselFive']; else echo "../showroom/assets/images/banners/slide2.jpg";?>" alt="Carousel 2" height="150px" width="100%" align="middle" class="rounded">
							  </a>
							  <div class="d-flex align-items-center px-2">
								<div class="ml-auto text-muted">
								  <a href="settingsUpdate.php?formStatus=view&action=remove&item=5&c6=<?php echo $_SESSION['form']['server']['carouselSix']; ?>" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-trash mr-1"></i> <?php echo $_SESSION['language']['Remove'];?></a>
								</div>
							  </div>
							</div>

						</div>
					
						<div class="col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
							<div class="form-label"><?php echo $_SESSION['language']['Carousel'];?> 6</div>						
							  <input type="file" id="carouselSix"  name="carouselSix" >						
							  <?php $_SESSION['form']['data'][]='carouselSix'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>							
						  </div>
							<div class="card p-3">
							  <a href="javascript:void(0)" class="mb-3">
								<img src="<?php if ($_SESSION['form']['server']['carouselSix']!="") echo $_SESSION['form']['server']['carouselSix']; else echo "../showroom/assets/images/banners/slide3.jpg";?>" alt="Carousel 3" height="150px" width="100%" align="middle" class="rounded">
							  </a>
							  <div class="d-flex align-items-center px-2">
								<div class="ml-auto text-muted">
								  <a href="settingsUpdate.php?formStatus=view&action=remove&item=6" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-trash mr-1"></i> <?php echo $_SESSION['language']['Remove'];?></a>
								</div>
							  </div>
							</div>

						</div>
				
                    </div>
				</div>
				
				<?php } ?>
				
				
				  
				  <div class="card-body">
					<div class="row">
						
					
						<div class="col-sm-6 col-md-6">

						  <div class="form-group">
							<label class="form-label"><?php echo $_SESSION['language']['Language'];?></label></label>
							<select name="languageId" id="select-language" class="form-control custom-select">
							  <option value="1" <?php if ($_SESSION['form']['server']['languageId']==1) echo 'selected'; ?>> English</option>
							  <option value="2" <?php if ($_SESSION['form']['server']['languageId']==2) echo 'selected'; ?>> Español</option>
							  <option value="3" <?php if ($_SESSION['form']['server']['languageId']==3) echo 'selected'; ?>> Português</option>
							  <option value="4" <?php if ($_SESSION['form']['server']['languageId']==4) echo 'selected'; ?>> 简体中文</option>
							  <option value="5" <?php if ($_SESSION['form']['server']['languageId']==5) echo 'selected'; ?>> 日本語</option>
							  <option value="6" <?php if ($_SESSION['form']['server']['languageId']==6) echo 'selected'; ?>> 한국인</option>
							</select>
							<?php $_SESSION['form']['data'][]='languageId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
						  </div>

						</div>
						
						<div class="col-sm-6 col-md-6">	
						  <div class="form-group">
	                        <div class="form-label"><?php echo $_SESSION['language']['Prices display'];?></div>
	                        <div class="custom-controls-stacked">
	                          <label class="custom-control custom-radio custom-control-inline">
	                            <input type="radio" class="custom-control-input" id="marketDisplay" value=0 name="marketDisplay"<?php if ($_SESSION['form']['server']['marketDisplay']==0) echo " checked";?>>
	                            <span class="custom-control-label"> &nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $_SESSION['language']['Both'];?></span>
	                          </label>
							  <label class="custom-control custom-radio custom-control-inline">
	                            <input type="radio" class="custom-control-input" id="marketDisplay" value=1 name="marketDisplay"<?php if ($_SESSION['form']['server']['marketDisplay']==1) echo " checked";?>>
	                            <span class="custom-control-label"> &nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $_SESSION['language']['Retail'];?></span>
	                          </label>
	                          <label class="custom-control custom-radio custom-control-inline">
	                            <input type="radio" class="custom-control-input" id="marketDisplay" value=2 name="marketDisplay"<?php if ($_SESSION['form']['server']['marketDisplay']==2) echo " checked";?>>
	                            <span class="custom-control-label"> &nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $_SESSION['language']['Wholesale'];?></span>
	                          </label>
							   
							   <?php $_SESSION['form']['data'][]='marketDisplay'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
	                        </div>
	                      </div>
						</div>
						
					</div>
					
                  </div>
				  
				  <div class="card-body">
					<div class="row">
						
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
							  <label class="form-label"><?php echo $_SESSION['language']['Minimum Purchase'];?> ($)</label>
							  <input type="number" name="minOrder" class="form-control" value="<?php if (isset($_SESSION['form']['server']['minOrder'])) echo $_SESSION['form']['server']['minOrder']; ?>" min=0 step=0.01>
							  <?php $_SESSION['form']['data'][]='minOrder'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
							</div>
						</div>
						
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
							  <label class="form-label"><?php echo $_SESSION['language']['Delivery Zone'];?></label>
							  <input type="text" name="deliveryZone" class="form-control" value="<?php if (isset($_SESSION['form']['server']['deliveryZone'])) echo $_SESSION['form']['server']['deliveryZone']; ?>">
							  <?php $_SESSION['form']['data'][]='deliveryZone'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
							</div>
						</div>
						
						
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
							  <label class="form-label"><?php echo $_SESSION['language']['Message (Before Order)'];?></label>
							  <input type="text" name="msgPreOrder" class="form-control" value="<?php if (isset($_SESSION['form']['server']['msgPreOrder'])) echo $_SESSION['form']['server']['msgPreOrder']; ?>">
							  <?php $_SESSION['form']['data'][]='msgPreOrder'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
							</div>
						</div>
					
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
							  <label class="form-label"><?php echo $_SESSION['language']['Message (After Order)'];?></label>
							  <input type="text" name="msgPostOrder" class="form-control" value="<?php if (isset($_SESSION['form']['server']['msgPostOrder'])) echo $_SESSION['form']['server']['msgPostOrder']; ?>">
							  <?php $_SESSION['form']['data'][]='msgPostOrder'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
							</div>
						</div>
									
				
                    </div>
				</div>
				<!--
				<div class='card-body'>
					<?php
					if ($mlAccessToken == ''){ ?>
						<label class="form-label"><?= $_SESSION['language']['Accept payments with Mercado Pago']?></label>
						<p><?= $_SESSION['language']['Link your Haomai account with Mercado Pago to make payments through the ecommerce']?></p>
						<a href="https://auth.mercadopago.com.ar/authorization?client_id=<?= $APP_ID ?>&response_type=code&platform_id=mp&redirect_uri=<?= $redirect_uri ?>" target='_blank' class='btn btn-primary'><?=$_SESSION['language']['Link']?></a>
					<?php
					} else { ?>
						<label class="form-label"><?= $_SESSION['language']['Unlink Mercado Pago']?></label>
						<p> <?= $_SESSION['language']['By pressing the "unlink" button, you will be redirected to Mercado Libre where you can remove your link.']?></p>
						<a href="https://appstore.mercadolibre.com.ar/apps/permissions" target='_blank' class='btn btn-primary'><?=$_SESSION['language']['Unlink']?></a>						
					<?php 
					} 
					?> 
				</div>
				  -->
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"><?php echo $_SESSION['language']['Update settings']; ?></button>
                </div>
				</form>
			  
			<?php }; ?>
				</div>
			</div>
			
<script> function updateName(item){
var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
document.getElementById(item).innerHTML  = filename;
} 
</script>