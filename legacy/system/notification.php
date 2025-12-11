

	<script type="text/javascript">
		function notification(type,message) {
		toastr.options.timeOut = 2000;
		toastr.options.extendedTimeOut = 2000;
		toastr.options.closeButton = true;
		toastr.options.progressBar = true;
		toastr.options.positionClass = "toast-bottom-left";
		if (type=="info") {
			toastr.info(message);
		}
		if (type=="warning") {
			toastr.warning(message);
		}
		if (type=="success") {
			toastr.success(message);
		}
		if (type=="error") {
			toastr.error(message);
		}
        };
	</script>
	
<?php if (isset($_SESSION['notification']['message'])) { unset($_SESSION['notification']);}; ?>