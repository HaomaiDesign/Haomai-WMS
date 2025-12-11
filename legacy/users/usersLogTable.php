
							  <?php if ($_GET['tableStatus']=='view') { ?>
							
							  <div class="table-responsive">
								<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th><?php echo $_SESSION['language']['Date'];?></th>
									  <th><?php echo $_SESSION['language']['Time'];?></th>
									  <th><?php echo $_SESSION['language']['Avatar'];?></th>
									  <th><?php echo $_SESSION['language']['Full Name'];?></th>
									  <th><?php echo $_SESSION['language']['Category'];?></th>	
									  <th><?php echo $_SESSION['language']['Description'];?></th>										  
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									$sql = "SELECT userLog.userLogDate, userLog.userLogTime, userLog.module, userLog.description, users.avatar, users.fullName FROM userLog INNER JOIN users ON userLog.userId=users.id WHERE users.businessId=".$_SESSION['user']['businessId']." ORDER BY userLog.id DESC;";  
									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC  ))  
									{  
									
									?>
									
									<tr>
									  <td>
										<div><?php echo $row['userLogDate']->format('Y-m-d');; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['userLogTime']->format('H:i:s'); ?></div>
									  </td>
									  <td class="text-center">
										<div class="avatar d-block" style="background-image: url(<?php echo $row['avatar']; ?>)">
										  <span class="avatar-status bg-green"></span>
										</div>
									  </td>
									  <td>
										<div><?php echo $row['fullName']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['module']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['description']; ?></div>
									  </td>
									  
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
									