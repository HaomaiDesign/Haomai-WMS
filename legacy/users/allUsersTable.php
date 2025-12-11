
							  <?php if ($_GET['tableStatus']=='view') { ?>
							
							  <div class="table-responsive">
								<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
								  <thead>
									<tr>
									  <th style="width:5%;font-weight:bold;" class="text-center"><i class="fe fe-users"></i></th>
									  <th style="width:25%;font-weight:bold;"><?php echo $_SESSION['language']['User'];?></th>
									  <th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language'][''];?>Puesto</th>
									  <th style="width:20%;font-weight:bold;"><?php echo $_SESSION['language'][''];?>Contacto</th>
									  <th style="width:25%;font-weight:bold;"><?php echo $_SESSION['language']['Email'];?></th>									  
									  <th style="width:5%;font-weight:bold;" class="text-center"><i class="fe fe-settings"></i></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php
									
									$sql = "SELECT * FROM users WHERE businessId=".$_SESSION['user']['businessId']." ORDER BY id DESC";  
									$stmt = mysqli_query( $conn, $sql);  
									
									if ( $stmt ) {
									while( $row = mysqli_fetch_array( $stmt, MYSQLI_ASSOC  ))  
									{  
									
									?>
									
									<tr>
									  <td class="text-center">
										<div class="avatar d-block" style="background-image: url(<?php echo $row['avatar']; ?>)">
										  <span class="avatar-status bg-green"></span>
										</div>
									  </td>
									  <td>
										<div><?php echo $row['fullName']; ?></div>
										<div class="small text-muted">
										  <?php if ($row['roleId']==1) echo $_SESSION['language']['Administrator']; ?>
										  <?php if ($row['roleId']==2) echo $_SESSION['language']['Responsable']; ?>
										  <?php if ($row['roleId']==3) echo $_SESSION['language']['User']; ?>
										  <?php if ($row['roleId']==4) echo $_SESSION['language']['Sales']; ?>
										  <?php if ($row['roleId']==5) echo $_SESSION['language']['Purchases']; ?>
										  <?php if ($row['roleId']==6) echo $_SESSION['language']['Market']; ?>
										</div>
									  </td>
									  <td>
										<div><?php echo $row['jobTitle']; ?></div>
										<div class="small text-muted">
										  <?php echo $row['department']; ?>
										</div>
									  </td>
									  <td>
										<div><?php echo $row['mobile']; ?></div>
									  </td>
									  <td>
										<div><?php echo $row['email']; ?></div>
									  </td>
									  <td class="text-center">
										<div class="item-action dropdown">
										  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
										  <div class="dropdown-menu dropdown-menu-right">
											<a href="allUsers.php?formStatus=view&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> <?php echo $_SESSION['language']['Edit'];?> </a>
											<a onclick="setId('<?php echo $row['id']; ?>')"class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> <?php echo $_SESSION['language'][''];?> Restore Password</a>
											<a href="allUsersUpdate.php?formStatus=delete&id=<?php echo $row['id']; ?>" class="dropdown-item"><i class="dropdown-icon fe fe-user-minus"></i> <?php echo $_SESSION['language']['Delete'];?></a>
										  </div>
										</div>
									  </td>
									</tr>
									<?php }; ?>
								  </tbody>
								</table>
							  </div>
							  
									<?php }}; ?>
									
									
							     <div id="modalPassword" class="modal fade" role="dialog">
								<div class="modal-dialog">
								  <!-- Modal content-->
								  <div class="modal-content">
									<div class="modal-header">
									  <h4 class="modal-title">Restablecer Contraseña</h4>
									</div>

									<div class="modal-body">
									  <form class="card" action="allUsersUpdate.php" method="get">
									  
										<input type='hidden' name='action' class='form-control' value='resetPassword'>
										<input type='hidden' id='userId' name='userId' class='form-control'>
										
										
										<div class="card-body p-6">
										  <div class="card-title text-center">RESTABLECER CONTRASEÑA</div>
										 
										  <div class="form-group">
											<label class="form-label">Nueva Contraseña Temporal</label>
											<input type="string" name="newPassword" class="form-control" required>
										  </div>
										  
										  <div class="form-footer">
											<button type="submit" class="btn btn-primary btn-block">Restablecer Contraseña</button>
										  </div>
										</div>
									  </form>
									</div>
									

									<div class="modal-footer">
									  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
									</div>

								
								  </div>
								</div>
							  </div>		
									
<script>	
function setId(userId){							
document.getElementById("userId").value = userId;
$("#modalPassword").modal('show');
}
</script>									