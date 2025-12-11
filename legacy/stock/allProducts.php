<?php include "../system/session.php"; ?>
<?php include "../system/head.php"; ?>
<?php include "../system/navbar.php"; ?>
<?php include "../system/menu.php"; ?>
<?php include "../system/contentStart.php"; ?>

<?php unset($_SESSION['form']); ?>
<!-- Start content-->
  
<?php 

if ($_SESSION['user']['roleId']==99) {
	include "user/".$_SESSION['user']['id']."/productsListTable.php";
} else {
	include "productsListTable.php"; 
}
?>
<?php include "productsListForm.php"; ?>		


  
<!-- End content-->  
<script>
$(searchTable).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});

</script>

<?php include "../system/tableFilters.php"; ?>
<?php include "../system/contentEnd.php"; ?>				
			
