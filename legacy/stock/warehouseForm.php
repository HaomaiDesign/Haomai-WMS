            <?php if (($_GET['formStatus']=='create')or($_GET['formStatus']=='view')) { 
			
			$_SESSION['form']['table']= 'warehouse';

			if ($_GET['formStatus']=='view')
			{
				$_SESSION['form']['condition'] = "id=".$_GET['id'];
				include "../system/formQuery.php"; // Get data from DB
			}
			?>
			
			<div class="card">
				<div class="card-status card-status-left bg-teal"></div>
				<div class="card-header">
					<h3 class="card-title" style="font-weight:bold;">
					<?php if (($_GET['formStatus']=='view')or($_GET['formStatus']=='create')) echo "<a href='warehouse.php?tableStatus=view' class='btn btn-icon btn-sm'><i class='fe fe-arrow-left'></i></a>&nbsp"; ?>
					<?php if ($_GET['tableStatus']=='view') echo $_SESSION['language']['Warehouse List']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Edit Warehouse']; if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create Warehouse']; ?>
					</h3>	
			</div>
				
			<?php $_SESSION['form']['quantity'] = -1;?>

				<div class="card-body">
                  <form action="warehouseUpdate.php<?php if ($_GET['formStatus']=='create') echo '?formStatus=create'; if ($_GET['formStatus']=='view') echo '?formStatus=edit&id='.$_GET['id'];?>" method="post" enctype="multipart/form-data">
                    <div class="row">
					<div class="col-sm-4 col-md-4">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Code'];?></label>
						  <input type="text" name="code" class="form-control" value="<?php if (isset($_SESSION['form']['server']['code'])) echo $_SESSION['form']['server']['code']; ?>">
						  <?php $_SESSION['form']['data'][]='code'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
						</div>
					</div>
					<div class="col-sm-8 col-md-8">
						<div class="form-group">
						  <label class="form-label"><?php echo $_SESSION['language']['Warehouse Name'];?><span class="form-required">*</span></label>
						  <input type="text" name="name" class="form-control" value="<?php if (isset($_SESSION['form']['server']['name'])) echo $_SESSION['form']['server']['name']; ?>" required>
						  <?php $_SESSION['form']['data'][]='name'; $_SESSION['form']['type'][]='string'; $_SESSION['form']['quantity']++;?>
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
					
					
					<?php
					if ($_GET['formStatus']=='create') 
					{	
					echo "<input type='hidden' name='businessId' class='form-control' value=".$_SESSION['user']['businessId'].">";
					$_SESSION['form']['data'][]='businessId'; $_SESSION['form']['type'][]='number'; $_SESSION['form']['quantity']++;
					}
					?>
					
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
                  <button type="submit" class="btn btn-primary"><?php if ($_GET['formStatus']=='create') echo $_SESSION['language']['Create']; if ($_GET['formStatus']=='view') echo $_SESSION['language']['Update']; ?></button>
                </div>
				</form>
			  
			<?php }; ?>
			
			
	</div>
  </div>