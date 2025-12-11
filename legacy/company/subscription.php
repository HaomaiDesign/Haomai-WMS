<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>
<?php unset($_SESSION['form']); ?>
<!-- Start content-->

<div class="my-3 my-md-5">
  <div class="container">
	<!--
	<div class="page-header">
	  <h1 class="page-title">
		Pricing cards
	  </h1>
	</div>
	-->
	<div class="row">
	
	  <div class="col-4">
		<div class="card">
		  <div class="card-status bg-green"></div>
		  <div class="card-body text-center">
			<div class="card-category">Free Plan </div>
			<div class="display-3 my-4">$ 0 </div>
			<div class="card-category">per month</div>
			<ul class="list-unstyled leading-loose">
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> <strong>1</strong> Retail Access</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> <strong>100</strong> Retail Products </li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Virtual Showroom</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Manage Orders </li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> 5% transaction fee</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Email support</li>
			  <li><i class="fe fe-x text-danger mr-2" aria-hidden="true"></i> Customized web domain</li>
			  <li><i class="fe fe-x text-danger mr-2" aria-hidden="true"></i> Wholesale access</li>
			</ul>
			<div class="text-center mt-6">
			   <?php if ($_SESSION['user']['subscription']!=0) echo "<a href='subscriptionUpdate.php?plan=0' class='btn btn-primary btn-block'> Monthly $0 per Month</a>"; else echo "<button class='btn btn-green btn-block' disabled> Monthly $0 per Month (Activated)</button>"; ?>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="col-4">
		<div class="card">
		  
		  <div class="card-body text-center">
			<div class="card-category">Annual Retail Plan</div>
			<div class="display-3 my-4">$ 299</div>
			<div class="card-category">per month</div>
			<ul class="list-unstyled leading-loose">
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> <strong>1</strong> Retail Access</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> <strong>1</strong> Wholesale Access</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> <strong>300</strong> Retail Products </li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Virtual Showroom</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Manage Orders </li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> 3% transaction fee</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Email support</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Customized web domain</li>
			</ul>
			<div class="text-center mt-6">
			<?php if ($_SESSION['user']['subscription']!=1) echo "<a href='subscriptionUpdate.php?plan=1' class='btn btn-primary btn-block'> Annual $299 per Month</a>"; else echo "<button class='btn btn-green btn-block' disabled> Annual $299 per Month (Activated)</button>"; ?>
			<?php if ($_SESSION['user']['subscription']!=2) echo "<a href='subscriptionUpdate.php?plan=2' class='btn btn-primary btn-block'> Monthly $499 per Month</a>"; else echo "<button class='btn btn-green btn-block' disabled> Monthly $499 per Month (Activated)</button>"; ?>  


			</div>
		  </div>
		</div>
	  </div>
	  <div class="col-4">
		<div class="card">
		  <div class="card-body text-center">
			<div class="card-category">Monthly Wholesale Plan</div>
			<div class="display-3 my-4">$ 599</div>
			<div class="card-category">per month</div>
			<ul class="list-unstyled leading-loose">
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> <strong>1</strong> Retail Access</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> <strong>1</strong> Wholesale Access</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> <strong>500</strong> Retail & Wholesale Products </li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Virtual Showroom	</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Manage Orders </li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> 3% transaction fee</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Email support</li>
			  <li><i class="fe fe-check text-success mr-2" aria-hidden="true"></i> Customized web domain</li>
			</ul>
			<div class="text-center mt-6">
				<?php if ($_SESSION['user']['subscription']!=3) echo "<a href='subscriptionUpdate.php?plan=3' class='btn btn-primary btn-block'> Annual $599 per Month</a>"; else echo "<button class='btn btn-green btn-block' disabled> Annual $599 per Month (Activated)</button>"; ?>
				<?php if ($_SESSION['user']['subscription']!=4) echo "<a href='subscriptionUpdate.php?plan=4' class='btn btn-primary btn-block'> Monthly $999 per Month</a>"; else echo "<button class='btn btn-green btn-block' disabled> Monthly $999 per Month (Activated)</button>"; ?>			  

			</div>
		  </div>
		</div>
	  </div>
 
	  
	</div>
  </div>
</div>


<!-- End content-->  
<?php include "../system/contentEnd.php"; ?>	