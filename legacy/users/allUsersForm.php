            <?php if (($_GET['formStatus']=='create')or($_GET['formStatus']=='view')) { 
			
			$_SESSION['form']['table']= 'users';  
			if ($_GET['formStatus']=='view')
			{
				$_SESSION['form']['condition'] = "id=".$_GET['id'];
				include "../system/formQuery.php"; // Get data from DB
			}
			?>
			
			<?php $_SESSION['form']['quantity'] = -1;?>

				<div class="card-body">
                  <form action="allUsersUpdate.php<?php if ($_GET['formStatus']=='create') echo '?formStatus=create'; if ($_GET['formStatus']=='view') echo '?formStatus=edit&id='.$_GET['id'];?>" method="post" enctype="multipart/form-data">
                    <div class="row">
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Full Name'];?> <span class="form-required">*</span></label>
						  <input type="text" name="fullName" class="form-control" value="<?php if (isset($_SESSION['form']['server']['fullName'])) echo $_SESSION['form']['server']['fullName']; ?>" required>
						  <?php $_SESSION['form']['data'][]='fullName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Role'];?></label>
                        <select name="roleId" id="select-language" class="form-control custom-select">
						  <option value="3" <?php if ($_SESSION['form']['server']['roleId']==3) echo 'selected'; ?>> User</option>
						  <option value="2" <?php if ($_SESSION['form']['server']['roleId']==2) echo 'selected'; ?>> Responsable</option>
                          <option value="1" <?php if ($_SESSION['form']['server']['roleId']==1) echo 'selected'; ?>> Administrator</option>
						  <option value="4" <?php if ($_SESSION['form']['server']['roleId']==4) echo 'selected'; ?>> Ventas</option>
						  <option value="5" <?php if ($_SESSION['form']['server']['roleId']==5) echo 'selected'; ?>> Compras</option>
						  <option value="6" <?php if ($_SESSION['form']['server']['roleId']==6) echo 'selected'; ?>> Market</option>
                          </select>
						<?php $_SESSION['form']['data'][]='roleId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
                      </div>
					</div>
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Company Name'];?></label>
						  <input class="form-control" value="<?php echo $_SESSION['user']['businessName']; ?>" disabled>
						</div>
					</div>
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Department'];?></label>
						  <input type="text" name="department" class="form-control" value="<?php if (isset($_SESSION['form']['server']['department'])) echo $_SESSION['form']['server']['department']; ?>">
						  <?php $_SESSION['form']['data'][]='department'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Job Title'];?></label>
						  <input class="form-control" name="jobTitle" value="<?php if (isset($_SESSION['form']['server']['jobTitle'])) echo $_SESSION['form']['server']['jobTitle']; ?>">
						  <?php $_SESSION['form']['data'][]='jobTitle'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Email'];?> <span class="form-required">*</span></label>
						  <input type="email" name="email" class="form-control" value="<?php if (isset($_SESSION['form']['server']['email'])) echo $_SESSION['form']['server']['email']; ?>" required>
						  <?php $_SESSION['form']['data'][]='email'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
                    </div>
				</div>

				<div class="card-body">
                  <div class="row">
					
					<div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Personal ID'];?></label>
                        <input type="text" name="personalId" class="form-control" value="<?php if (isset($_SESSION['form']['server']['personalId'])) echo $_SESSION['form']['server']['personalId']; ?>">
						<?php $_SESSION['form']['data'][]='personalId'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
                      </div>
                    </div>
					<div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Personal Phone'];?></label>
                        <input type="text" name="phone" class="form-control" value="<?php if (isset($_SESSION['form']['server']['phone'])) echo $_SESSION['form']['server']['phone']; ?>">
						<?php $_SESSION['form']['data'][]='phone'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
                      </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Personal Mobile'];?></label>
                        <input type="text" name="mobile" class="form-control" value="<?php if (isset($_SESSION['form']['server']['mobile'])) echo $_SESSION['form']['server']['mobile']; ?>">
						<?php $_SESSION['form']['data'][]='mobile'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div> 
                    <div class="col-sm-9 col-md-9">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Address'];?></label>
                        <input type="text" name="address" class="form-control" value="<?php if (isset($_SESSION['form']['server']['address'])) echo $_SESSION['form']['server']['address']; ?>">
						<?php $_SESSION['form']['data'][]='address'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Postal Code'];?></label>
                        <input type="text" name="postalCode" class="form-control" value="<?php if (isset($_SESSION['form']['server']['postalCode'])) echo $_SESSION['form']['server']['postalCode']; ?>">
						<?php $_SESSION['form']['data'][]='postalCode'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Location'];?></label>
                        <input type="text" name="location" class="form-control" value="<?php if (isset($_SESSION['form']['server']['location'])) echo $_SESSION['form']['server']['location']; ?>">
						<?php $_SESSION['form']['data'][]='location'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Province / State'];?></label>
                        <input type="text" name="province" class="form-control" value="<?php if (isset($_SESSION['form']['server']['province'])) echo $_SESSION['form']['server']['province']; ?>">
						<?php $_SESSION['form']['data'][]='province'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Country'];?></label>
                        <select name="country" id="select-countries" class="form-control custom-select">
                          <option value="Argentina" data-data='{"image": "assets/images/flags/ar.svg"}' <?php if ($_SESSION['form']['server']['country']=='Argentina') echo 'selected'; ?>> Argentina</option>
                          <option value="Brazil" data-data='{"image": "assets/images/flags/br.svg"}' <?php if ($_SESSION['form']['server']['country']=='Brazil') echo 'selected'; ?>> Brazil</option>
                          <option value="Chile" data-data='{"image": "assets/images/flags/de.svg"}' <?php if ($_SESSION['form']['server']['country']=='Chile') echo 'selected'; ?>> Chile</option>
                          <option value="China" data-data='{"image": "assets/images/flags/cn.svg"}' <?php if ($_SESSION['form']['server']['country']=='China') echo 'selected'; ?>> China</option>
                        </select>
						<?php $_SESSION['form']['data'][]='country'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
					<div class="col-sm-6 col-md-6">
					  <div class="form-group">
                        <div class="form-label"><?php echo $_SESSION['language']['Avatar'];?></div>
                        <div class="custom-file">
                          <input type="file" id="avatar" class="custom-file-input" name="avatar" onchange="updateName()">
                          <label id="fileName" class="custom-file-label">Choose file</label>
						  <?php $_SESSION['form']['data'][]='avatar'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>
						  <script> function updateName(){
								var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
								document.getElementById("fileName").innerHTML  = filename;
							  } </script>
                        </div>
                      </div>
					</div>
					<div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Language'];?></label>
                        <select name="languageId" id="select-language" class="form-control custom-select">
                          <option value="1" <?php if ($_SESSION['form']['server']['languageId']==1) echo 'selected'; ?>> English</option>
                          <option value="2" <?php if ($_SESSION['form']['server']['languageId']==2) echo 'selected'; ?>> Español</option>
						  <option value="3" <?php if ($_SESSION['form']['server']['languageId']==3) echo 'selected'; ?>> Português</option>
						  <option value="4" <?php if ($_SESSION['form']['server']['languageId']==4) echo 'selected'; ?>> 繁體中文</option>
						  <option value="5" <?php if ($_SESSION['form']['server']['languageId']==5) echo 'selected'; ?>> 日本語</option>
                          <option value="6" <?php if ($_SESSION['form']['server']['languageId']==6) echo 'selected'; ?>> 한국인</option>
					   </select>
						<?php $_SESSION['form']['data'][]='languageId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
					
					<?php
					if ($_GET['formStatus']=='create')
					{	
					echo "<input type='hidden' name='flagEmailChecked' class='form-control' value=0>";
					$_SESSION['form']['data'][]='flagEmailChecked'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
					echo "<input type='hidden' name='flagResetPassword' class='form-control' value=1>";
					$_SESSION['form']['data'][]='flagResetPassword'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
					echo "<input type='hidden' name='businessId' class='form-control' value=".$_SESSION['user']['businessId'].">";
					$_SESSION['form']['data'][]='businessId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
					}
					?>
                    
										
                  </div>            
				</div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"><?php if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create profile']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Update profile']; ?></button>
                </div>
				</form>
			  
			<?php }; ?>