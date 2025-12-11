

				<div class="card-body">
                  <form action="testUpdate.php" method="post" enctype="multipart/form-data">
                    <div class="row">
					
					<div class="col-sm-6 col-md-6">
					  <div class="form-group">
                        <div class="form-label"><?php echo $_SESSION['language']['Avatar'];?></div>
                        <div class="custom-file">
                          <input type="file" id="images" class="custom-file-input" name="images" onchange="updateName()">
                          <label id="fileName" class="custom-file-label">Choose file</label>
						  <?php $_SESSION['form']['data'][]='images'; $_SESSION['form']['type'][]='image'; $_SESSION['form']['quantity']++;?>
						  <script> function updateName(){
								var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
								document.getElementById("fileName").innerHTML  = filename;
							  } </script>
                        </div>
                      </div>
					</div>
					
										
                  </div>            
				</div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">upload</button>
                </div>
				</form>
			  
		