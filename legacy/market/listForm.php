			

			
			
			<?php if (($_GET['formStatus']=='create')or($_GET['formStatus']=='view')) { ?>
			
			<div class="col-12">
				<div class="card">
					<div class="card-status card-status-left bg-teal"></div>
					<div class="card-header">
						<h3 class="card-title" style="font-weight:bold;">
						<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='javascript:history.go(-1)' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
						<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Customers']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit Customer']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create a new customer']; ?>
						</h3>
					<div class="card-options">
					  <?php if ($_GET['tableStatus']=='view') { echo "<a href='new.php?formStatus=create' class='btn btn-icon btn-lg'><i class='fe fe-user-plus'></i></a>"; }?>
					</div>
				  </div>
			
			<?php
				if ($_GET['target']=="supplier") 
					$_SESSION['form']['table']= 'supplier'; 
				 
				if ($_GET['target']=="customer")
					$_SESSION['form']['table']= 'customer'; 
					
				if ($_GET['formStatus']=='view')
				{
					$_SESSION['form']['condition'] = "id=".$_GET['id'];
					include "../system/formQuery.php"; // Get data from DB
				}
			?>
			
			
			<?php $_SESSION['form']['quantity'] = -1;?>

              <form action="listUpdate.php<?php if ($_GET['formStatus']=='create') echo '?formStatus=create&table='.$_SESSION['form']['table'].'&target='.$_GET['target']; if ($_GET['formStatus']=='view') echo '?formStatus=edit&target='.$_GET['target'].'&table='.$_SESSION['form']['table'].'&page='.$_GET['page'].'&id='.$_GET['id'];?>" method="post" enctype="multipart/form-data">
				
                <div class="card-body">
                  <div class="row">
					<div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Business Name'];?><span class="form-required">*</span></label>
                        <input type="text" name="businessName" class="form-control" value="<?php if (isset($_SESSION['form']['server']['businessName'])) echo $_SESSION['form']['server']['businessName']; ?>" required>
						<?php $_SESSION['form']['data'][]='businessName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Legal Name'];?></label>
                        <input type="text" name="legalName" class="form-control" value="<?php if (isset($_SESSION['form']['server']['legalName'])) echo $_SESSION['form']['server']['legalName']; ?>">
						<?php $_SESSION['form']['data'][]='legalName'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
					<!--
					<div class="col-sm-3 col-md-3">
					  <div class="form-group">
                        <div class="form-label"><?php echo $_SESSION['language']['Company Logo'];?></div>
                        <div class="custom-file">
                          <input type="file" id="logo" class="custom-file-input" name="logo" onchange="updateName()">
                          <label id="fileName" class="custom-file-label"><?php echo $_SESSION['language']['Choose file'];?></label>
						  <?php $_SESSION['form']['data'][]='logo'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>
						  <script> function updateName(){
								var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
								document.getElementById("fileName").innerHTML  = filename;
							  } </script>
                        </div>
                      </div>
					</div>
					-->
					<div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Tax ID'];?></label>
                        <input type="text" name="taxId" class="form-control" value="<?php if (isset($_SESSION['form']['server']['taxId'])) echo $_SESSION['form']['server']['taxId']; ?>">
						<?php $_SESSION['form']['data'][]='taxId'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
                      </div>
                    </div>
					<div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Tax Status'];?><span class="form-required">*</span></label>
                        <input type="text" name="condition" class="form-control" value="<?php if (isset($_SESSION['form']['server']['condition'])) echo $_SESSION['form']['server']['condition']; ?>">
						<?php $_SESSION['form']['data'][]='condition'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
                      </div>
                    </div>
					<div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Category'];?><span class="form-required">*</span></label>
                        <input type="text" name="category" class="form-control" value="<?php if (isset($_SESSION['form']['server']['category'])) echo $_SESSION['form']['server']['category']; ?>">
						<?php $_SESSION['form']['data'][]='category'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
                      </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Phone'];?></label>
                        <input type="text" name="phone" class="form-control" value="<?php if (isset($_SESSION['form']['server']['phone'])) echo $_SESSION['form']['server']['phone']; ?>">
						<?php $_SESSION['form']['data'][]='phone'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
					<div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Whatsapp'];?></label>
                        <input type="text" name="whatsapp" class="form-control" value="<?php if (isset($_SESSION['form']['server']['whatsapp'])) echo $_SESSION['form']['server']['whatsapp']; ?>">
						<?php $_SESSION['form']['data'][]='whatsapp'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
                      </div>
                    </div>
					<div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Wechat'];?></label>
                        <input type="text" name="wechat" class="form-control" value="<?php if (isset($_SESSION['form']['server']['wechat'])) echo $_SESSION['form']['server']['wechat']; ?>">
						<?php $_SESSION['form']['data'][]='wechat'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
                      </div>
                    </div>
					<div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Web Page'];?></label>
                        <input type="text" name="webPage" class="form-control" value="<?php if (isset($_SESSION['form']['server']['webPage'])) echo $_SESSION['form']['server']['webPage']; ?>">
						<?php $_SESSION['form']['data'][]='webPage'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
                      </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Email'];?></label>
                        <input type="email" name="email" class="form-control" value="<?php if (isset($_SESSION['form']['server']['email'])) echo $_SESSION['form']['server']['email']; ?>">
						<?php $_SESSION['form']['data'][]='email'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>						
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
					
					<?php
					if ($_GET['formStatus']=='create')
					{	
					echo "<input type='hidden' name='companyId' class='form-control' value=".$_SESSION['user']['companyId'].">";
					$_SESSION['form']['data'][]='companyId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
					}
					?>
					
                    <div class="col-sm-4 col-md-4">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Country'];?></label>
                        <select name="country" id="select-countries" class="form-control custom-select">
                          <option value="Argentina" data-data='{"image": "assets/images/flags/ar.svg"}' <?php if ($_SESSION['form']['server']['country']=='Argentina') echo 'selected'; ?>> Argentina</option>
                        </select>
						<?php $_SESSION['form']['data'][]='country'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
					
					<div class="col-sm-12 col-md-12">
                      <div class="form-group">
                        <label class="form-label"><?php echo $_SESSION['language']['Description'];?></label>
                        <input type="text" name="description" class="form-control" value="<?php if (isset($_SESSION['form']['server']['description'])) echo $_SESSION['form']['server']['description']; ?>">
						<?php $_SESSION['form']['data'][]='description'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
                      </div>
                    </div>
					
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary"><?php if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create company profile']; else echo $_SESSION['language']['Update company profile'];?> </button>
                </div>
			  </form>  
           
			
			<?php }; ?>
			
			</div>
			</div>		

				