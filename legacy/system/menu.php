<!-- expand-hover push -->
  <!-- Sidebar -->
  <div class="adminx-sidebar expand-hover push">
	<ul class="sidebar-nav">
	
	<?php /* if (($_SESSION['user']['businessId']!=0)AND($_SESSION['user']['roleId']==1)) { ?>	
	  <li class="sidebar-nav-item">
		<a href="../dashboard/orderList.php?tableStatus=view&target=company&page=1" class="sidebar-nav-link">
		  <span class="sidebar-nav-abbr">
			<i class="fas fa-tachometer-alt"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Dashboard'];?>
		  </span>
		  <span class="sidebar-nav-end">
		  </span>
		</a>
	  </li>
	<?php } */ ?>
	
	<?php /* if (($_SESSION['user']['businessId']!=0)AND(($_SESSION['user']['roleId']==1)OR($_SESSION['user']['roleId']==2)OR($_SESSION['user']['roleId']==3)OR($_SESSION['user']['roleId']==4))) { ?>	
	  <li class="sidebar-nav-item">
		<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#market" aria-expanded="false" aria-controls="market">
		  <span class="sidebar-nav-icon">
			<i class="fas fa-handshake"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Market Center'];?>
		  </span>
		  <span class="sidebar-nav-end">
			<i class="fe fe-chevron-down nav-collapse-icon"></i>
		  </span>
		</a>

		<ul class="sidebar-sub-nav collapse" id="market">
		   
		  <li class="sidebar-nav-item">
			<a href="../membership/company.php?tableStatus=view&target=orders" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-store"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Member Shop'];?> 
			  </span>
			  </a>
		  </li>
	

	<?php if ($_SESSION['user']['roleId']==1) { ?>	
	
		   <li class="sidebar-nav-item">
			<a href="../market/report.php?tableStatus=view" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-chart-bar"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Report'];?> 
			  </span>
			  </a>
		  </li>
		  
	<?php } ?>	
		  
		   <li class="sidebar-nav-item">
			<a href="../market/settings.php?formStatus=view" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-cog"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Settings'];?> 
			  </span>
			  </a>
		  </li>
	
		  
		</ul>
	  </li>
	<?php } */ ?>
	<!-- <?php if($_SESSION["user"]["roleId"] == 2){
	?>

		<li class="sidebar-nav-item">
			<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#sales" aria-expanded="false" aria-controls="showroom">
				<span class="sidebar-nav-icon">
					<i class="fas fa-money-check-alt"></i>
				</span>
				<span class="sidebar-nav-name">
					<?php echo $_SESSION['language']['Orders'];?>
				</span>
				<span class="sidebar-nav-end">
					<i class="fe fe-chevron-down nav-collapse-icon"></i>
				</span>
			</a>

			<ul class="sidebar-sub-nav collapse" id="sales">
				<li class="sidebar-nav-item">
					<a href="../market/orderList.php?tableStatus=view&target=out&page=1" class="sidebar-nav-link">
					<span class="sidebar-nav-abbr">
						<i class="fas fa-file-export"></i>
					</span>
					<span class="sidebar-nav-name">
						<?php echo $_SESSION['language']['Merchandise Shipment'];?>
					</span>
					</a>
				</li>
			</ul>
	  	</li>

	<?php
	}
	?> -->

	<?php if($_SESSION["user"]["roleId"] == 2){	?>

		<a href="../stock/productsList.php?reportCat=ALL&tableStatus=view&page=1" class="sidebar-nav-link">
			<span class="sidebar-nav-abbr">
				<i class="fas fa-list"></i>
			</span>
			<span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Products List'];?>
			</span>
		</a>
		<a href="../reports/reportDueList.php?tableStatus=view&page=1" class="sidebar-nav-link">
			<span class="sidebar-nav-abbr">
			<i class="far fa-clock"></i>
			</span>
			<span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Due Date'];?>
			</span>
		</a>
		<a href="../reports/reportExpired.php?tableStatus=view&page=1" class="sidebar-nav-link">
			<span class="sidebar-nav-abbr">
			<i class="far fa-calendar-times"></i>
			</span>
			<span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Expired'];?>
			</span>
		</a>

	<?php } ?>

	<?php if ($_SESSION["user"]["roleId"] == 1 || ($_SESSION['user']['roleId'] == 6)) { ?>	
	  
	  <li class="sidebar-nav-item">
		<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#sales" aria-expanded="false" aria-controls="showroom">
		  <span class="sidebar-nav-icon">
			<i class="fas fa-money-check-alt"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Orders'];?>
		  </span>
		  <span class="sidebar-nav-end">
			<i class="fe fe-chevron-down nav-collapse-icon"></i>
		  </span>
		</a>

		<ul class="sidebar-sub-nav collapse" id="sales">
		
		  
	      <li class="sidebar-nav-item">
			<a href="../market/orderList.php?tableStatus=view&target=in&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-file-import"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Merchandise Income'];?>
			  </span>
			</a>
		  </li>
		  
		  <li class="sidebar-nav-item">
			<a href="../market/orderList.php?tableStatus=view&target=out&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-file-export"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Merchandise Shipment'];?>
			  </span>
			</a>
		  </li>
		
		  
		</ul>
	  </li>

	<?php } ?>
	
	
	
	
	<?php if ($_SESSION['user']['roleId']==1) { ?>
	<!-- ASIA - Comento logistic de momento para reducir alcance de uso -->
	  
	  <li class="sidebar-nav-item">
		<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#logistic" aria-expanded="false" aria-controls="approvals">
		  <span class="sidebar-nav-icon">
			<i class="fas fa-truck"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Logistic'];?>
		  </span>
		  <span class="sidebar-nav-end">
			<i class="fe fe-chevron-down nav-collapse-icon"></i>
		  </span>
		</a>
		
		
		<ul class="sidebar-sub-nav collapse" id="logistic">
		  <li class="sidebar-nav-item">
			<a href="../logistic/orderList.php?target=out&tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-money-check-alt"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Orders'];?> 
			  </span>
			</a>
		  </li>

		  <li class="sidebar-nav-item">
			<a href="../logistic/delivery.php?tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-truck-loading"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Delivery'];?> 
			  </span>
			</a>
		  </li>

		  
		  
		</ul>
	  </li>

	<?php } ?>

	<?php if (($_SESSION['user']['roleId']==1) || ($_SESSION['user']['roleId'] == 6)) { ?>
	
	  
	  <li class="sidebar-nav-item">
		<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#warehouse" aria-expanded="false" aria-controls="approvals">
		  <span class="sidebar-nav-icon">
			<i class="fas fa-warehouse"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Warehouse'];?> 
		  </span>
		  <span class="sidebar-nav-end">
			<i class="fe fe-chevron-down nav-collapse-icon"></i>
		  </span>
		</a>
		
	
		
		<ul class="sidebar-sub-nav collapse" id="warehouse">
		
		  <li class="sidebar-nav-item">
			<a href="../stock/productsList.php?reportCat=ALL&tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-list"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Products List'];?>
			  </span>
			</a>
		  </li>
		  
		 
		  
		  <li class="sidebar-nav-item">
			<a href="../stock/itemList.php?tableStatus=view" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-boxes"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Stock'];?>
			  </span>
			</a>
		  </li>
		
		  <!-- ASIA - Comentamos este botón, se unifico con modulo Pedidos -->
		  <!-- <li class="sidebar-nav-item">
			<a href="../stock/orderList.php?target=in&tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-money-check-alt"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Orders'];?> 
			  </span>
			</a>
		  </li> -->

		  
		  
		  <li class="sidebar-nav-item">
			<a href="../stock/logs.php?tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-tasks"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Logs'];?>
			  </span>
			</a>
		  </li>	

		  <li class="sidebar-nav-item">
			<a href="../stock/warehouse.php?tableStatus=view" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-map-marker-alt"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Warehouse Location'];?>
			  </span>
			</a>
		  </li>

		 
		  
		</ul>
	  </li>

	<?php } ?>
	
	<?php if (($_SESSION['user']['roleId']==1) || ($_SESSION['user']['roleId'] == 6)) { ?>
	
	  <li class="sidebar-nav-item">
		<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#customers" aria-expanded="false" aria-controls="users">
		  <span class="sidebar-nav-icon">
			<i class="fas fa-address-card"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Customers'];?>
		  </span>
		  <span class="sidebar-nav-end">
			<i class="fe fe-chevron-down nav-collapse-icon"></i>
		  </span>
		</a>

		<ul class="sidebar-sub-nav collapse" id="customers">
		  <li class="sidebar-nav-item">
			<a href="../users/customers.php?tableStatus=view" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-address-card"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['All customers'];?> 
			  </span>
			</a>
		  </li>
		 
		</ul>
	  </li>
	<?php } ?>
	
	
	<?php /* if (($_SESSION['user']['businessId']!=0)AND(($_SESSION['user']['roleId']==1)OR($_SESSION['user']['roleId']==2))) { ?>
	
	  <li class="sidebar-nav-item">
		<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#finance" aria-expanded="false" aria-controls="users">
		  <span class="sidebar-nav-icon">
			<i class="fas fa-money-bill"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Finance'];?>
		  </span>
		  <span class="sidebar-nav-end">
			<i class="fe fe-chevron-down nav-collapse-icon"></i>
		  </span>
		</a>

		<ul class="sidebar-sub-nav collapse" id="finance">
		  <li class="sidebar-nav-item">
			<a href="../finance/orderList.php?target=company&tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-file-export"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Orders'];?> 
			  </span>
			</a>
		  </li>
		  
		  <li class="sidebar-nav-item">
			<a href="../finance/treasury.php?formStatus=create&tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-hand-holding-usd"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Treasury'];?> 
			  </span>
			</a>
		  </li>

		</ul>
	  </li>
	<?php } */ ?>
	
	<!-- <?php if (($_SESSION['user']['roleId']==1)  || ($_SESSION['user']['roleId'] == 6)) { ?>
	
	  <li class="sidebar-nav-item">
		<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="users">
		  <span class="sidebar-nav-icon">
			<i class="fas fa-users"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Users'];?>
		  </span>
		  <span class="sidebar-nav-end">
			<i class="fe fe-chevron-down nav-collapse-icon"></i>
		  </span>
		</a>

		<ul class="sidebar-sub-nav collapse" id="users">
		  <li class="sidebar-nav-item">
			<a href="../users/allUsers.php?tableStatus=view" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-id-badge"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['All Users'];?> 
			  </span>
			</a>
		  </li> -->
		<!-- 		  
		  <li class="sidebar-nav-item">
			<a href="../users/usersLog.php?tableStatus=view" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-user-clock"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Logs'];?>
			  </span>
			</a>
		  </li>
			 -->
		<!-- </ul>
	  </li>
	<?php } ?> -->
	
	
	<!--  reportes  -->
	<!-- ASIA - ROLEID = 1 ES ADMIN, = 3 ES GERENTE -->
<?php if (($_SESSION['user']['roleId'] == 1) || ($_SESSION['user']['roleId'] == 3) || ($_SESSION['user']['roleId'] == 6)) { ?>	
	  
	  <li class="sidebar-nav-item">
		<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#report" aria-expanded="false" aria-controls="report">
		  <span class="sidebar-nav-icon">
			<i class="fas fa-money-check-alt"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Report'];?>
		  </span>
		  <span class="sidebar-nav-end">
			<i class="fe fe-chevron-down nav-collapse-icon"></i>
		  </span>
		</a>

		<ul class="sidebar-sub-nav collapse" id="report">
		
		
	      <li class="sidebar-nav-item">
			<a href="../reports/reportCatList.php?reportCat=ALL&tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="far fa-list-alt"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Per Category'];?>
			  </span>
			</a>
		  </li>
		
		  
		  <li class="sidebar-nav-item">
			<a href="../reports/reportDueList.php?tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="far fa-clock"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Due Date'];?>
			  </span>
			</a>
		  </li>
		  
		  <li class="sidebar-nav-item">
			<a href="../reports/reportExpired.php?tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="far fa-calendar-times"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Expired'];?>
			  </span>
			</a>
		  </li>
		  
		  <li class="sidebar-nav-item">
			<a href="../reports/lowStockProducts.php?reportCat=ALL&tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="far fa-chart-bar"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Stock alert'];?>
			  </span>
			</a>
		  </li>

		  <!-- <li class="sidebar-nav-item">
			<a href="../reports/productsDemand.php?tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="far fa-chart-bar"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Products demand'];?>
			  </span>
			</a>
		  </li> -->
		 
		  <li class="sidebar-nav-item">
			<a href="../reports/stockMovementReport.php?tableStatus=view&page=1" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-chart-line"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Stock Movement Report'];?>
			  </span>
			</a>
		  </li>
		</ul>
	  </li>

	<?php } ?>

<!--  ---  -->	
<!--	  
	  <li class="sidebar-nav-item">
		<a class="sidebar-nav-link collapsed" data-toggle="collapse" href="#company" aria-expanded="false" aria-controls="company">
		  <span class="sidebar-nav-icon">
			<i class="fas fa-cog"></i>
		  </span>
		  <span class="sidebar-nav-name">
			<?php echo $_SESSION['language']['Settings'];?>
		  </span>
		  <span class="sidebar-nav-end">
			<i class="fe fe-chevron-down nav-collapse-icon"></i>
		  </span>
		</a>

		<ul class="sidebar-sub-nav collapse" id="company">
		  <li class="sidebar-nav-item">
			<a href="../company/profile.php?formStatus=<?php if ($_SESSION['user']['businessId']==0) echo 'create'; else echo 'view&id='.$_SESSION['user']['businessId'].'';?>" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-file-alt"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Company Profile'];?>
			  </span>
			</a>
		  </li> 

		  <li class="sidebar-nav-item">
			<a href="../company/wallet.php?businessId=<?php if ($_SESSION['user']['businessId']!=0) echo $_SESSION['user']['businessId'];?>" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-wallet"></i>
			  </span>
			  <span class="sidebar-nav-name">
				Company Wallet
			  </span>
			</a>
		  </li> 

		  <li class="sidebar-nav-item">
			<a href="../company/profile.php?formStatus=<?php if ($_SESSION['user']['businessId']==0) echo 'create'; else echo 'view&id='.$_SESSION['user']['businessId'].'';?>" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-bell"></i>
			  </span>
			  <span class="sidebar-nav-name">
				Notifications
			  </span>
			</a>
		  </li> 

		  <li class="sidebar-nav-item">
			<a href="../company/subscription.php?id=<?php if ($_SESSION['user']['id']!="") echo $_SESSION['user']['id'];?>" class="sidebar-nav-link">
			  <span class="sidebar-nav-abbr">
				<i class="fas fa-edit"></i>
			  </span>
			  <span class="sidebar-nav-name">
				<?php echo $_SESSION['language']['Subscription'];?>
			  </span>
			</a>
		  </li> 

		</ul>
	  </li>
-->	  
	</ul>
  </div><!-- Sidebar End -->