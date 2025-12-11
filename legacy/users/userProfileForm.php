     <?php
				$_SESSION['form']['table']= 'users';  
				if ($_GET['formStatus']=='view')
				{
					$_SESSION['form']['condition'] = "id=".$_SESSION['user']['id'];
					include "../system/formQuery.php"; // Get data from DB	
				}
			?>

			<?php $_SESSION['form']['quantity'] = -1;?>
      <form action="userProfileUpdate.php<?php if ($_GET['formStatus']=='view') echo '?formStatus=edit&id='.$_SESSION['user']['id'];?>" method="post" enctype="multipart/form-data">
			<div class="row">
			<div class="col-md-4">
			  <div class="card">
                <div class="card-header">
                  <div class="container">                  
                  <div class="row justify-content-between">
                    <div class="col-8"> <h3 class="card-title" style="font-weight:bold;"><?php echo $_SESSION['language']['My Profile'];?></h3> </div>
                    <?php if(isset($_GET["modify"]) == true){ ?>
                    <div class="col-4"> <button type="submit" class="btn btn-primary btn-sm"><?php echo $_SESSION['language']['Update my profile'];?></label></button></div>
                    <?php } ?>  
                  </div>                    
                  </div>
                </div>
				<div class="card-body">
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar avatar-xxl" style="background-image: url(<?php if (isset($_SESSION['form']['server']['avatar'])) echo $_SESSION['form']['server']['avatar']; ?>)"></span>
                      </div>

                      <div class="col">
                        <div class="form-group">
                          <?php
                            if(isset($_GET["modify"]) == false){
                                                
                          ?>
                          
                          <div class="row">
                            <div class="col">
                              <label class="form-label"><span><?php if (isset($_SESSION['form']['server']['fullName'])) echo $_SESSION['form']['server']['fullName']; ?></span></label> 
						                  <p><?php echo $_SESSION['user']['businessName']; ?></p>
                              <p><?php if (isset($_SESSION['form']['server']['email'])) echo $_SESSION['form']['server']['email']; ?></p>
                            </div>
                            <div class="col">
                              <a href="userProfile.php?formStatus=view&modify=true"><i class="fas fa-pencil-alt"></i></a>                            
                            </div>
                          </div>

                          <?php

                            } else {

                          ?>
                          <div class="container">
                            <input class="form-control" name="fullName" value="<?php if (isset($_SESSION['form']['server']['fullName'])) $_SESSION['user']['fullName'] = $_SESSION['form']['server']['fullName']; echo $_SESSION['user']['fullName']; ?>"></input>
                            <?php $_SESSION['form']['data'][]='fullName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                            <br>
                            <input class="form-control" name="email" value="<?php if (isset($_SESSION['form']['server']['email'])) $_SESSION['user']['email'] = $_SESSION['form']['server']['email']; echo $_SESSION['user']['email']; ?>"></input>
                            <?php $_SESSION['form']['data'][]='email'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>            
                          </div>
                            
                          <?php

                            }

                          ?>
                        </div>
                      </div>
                    </div>
				</div>
				<div class="card-body">
          <div class="form-group">
					  <label class="form-label"><?php echo $_SESSION['language']['User']; ?></label>
					  <input class="form-control" name="username" value="<?php $_SESSION['user']['username'] = $_SESSION['form']['server']['username']; echo $_SESSION['form']['server']['username']; ?>" readonly>
            <?php $_SESSION['form']['data'][]='username'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
					</div>
					<div class="form-group">
					  <label class="form-label"><?php echo $_SESSION['language']['Job Title'];?></label>
					  <input class="form-control" name="jobTitle" value="<?php if (isset($_SESSION['form']['server']['jobTitle'])) echo $_SESSION['form']['server']['jobTitle']; ?>">
					  <?php $_SESSION['form']['data'][]='jobTitle'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
					</div>
					<div class="form-group">
					  <label class="form-label"><?php echo $_SESSION['language']['Department'];?></label>
					  <input type="text" name="department" class="form-control" value="<?php if (isset($_SESSION['form']['server']['department'])) echo $_SESSION['form']['server']['department']; ?>">
					  <?php $_SESSION['form']['data'][]='department'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
					</div>
					
                </div>
				</div>
			</div>

			<div class="col-md-8">	
				<div class="card">
                  <div class="card-header">
					<h3 class="card-title" style="font-weight:bold;"><?php echo $_SESSION['language']['Personal Information'];?></label></h3>
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
                        <div class="form-label"><?php echo $_SESSION['language']['Avatar'];?></label></div>
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
                        <label class="form-label"><?php echo $_SESSION['language']['Language'];?></label></label>
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
  
										
                  </div>            
				</div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPassword"><?php echo $_SESSION['language']['Change Password'];?></button></div>
                    <div class="col text-right"><button type="submit" class="btn btn-primary"><?php echo $_SESSION['language']['Update my profile'];?></button></div>
                  </div>                  
                </div>
			  </div>
			</div>
			</div>
      </form>
      
      <div id="modalPassword" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><?php echo $_SESSION['language']['Change Password'];?></h4>
            </div>

            <div class="modal-body">
              <form class="card" action="../recoveryUpdate.php?resetOldPassword=true" method="post">
                <div class="card-body p-6">
                  <div class="card-title text-center"><?php echo $_SESSION['language']['Change Password'];?></div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $_SESSION['language']['Old Password'];?></label>
                    <input type="password" class="form-control" name="oldPassword" required>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $_SESSION['language']['New Password'];?></label>
                    <input type="password" name="newPassword" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?php echo $_SESSION['language']['Re-enter Password'];?></label>
                    <input type="password" name="renewPassword" class="form-control" required>
                  </div>

                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block"><?php echo $_SESSION['language']['Confirm changes'];?></button>
                  </div>
                </div>
              </form>
            </div>
            <?php
            if (isset($_SESSION['user']['flagResetPassword']) && $_SESSION['user']['flagResetPassword']!=1){
            ?>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>

            <?php } ?>


          </div>
        </div>
      </div>

      <script>
      let open_modal = false;
      open_modal = <?php if(isset($_SESSION['user']['flagResetPassword']) && $_SESSION['user']['flagResetPassword']==1){ echo "true";} else{echo "false";}?>;
      if (open_modal == true){
        $('#modalPassword').modal({backdrop: 'static',keyboard: false});
      }
      </script>