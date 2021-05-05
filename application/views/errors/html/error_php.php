<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap 4 Modal</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$("#myModal").modal('show');
	});
</script>
<style>
    .bs-example{
    	margin: 20px;
    }
</style>
</head>
<body>
	<!-- Modal -->
	<div id="myModal" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle" style="color: red"><i class="fas fa-exclamation-triangle"></i> <b>Error Message</b></h5>
				</div>
				<div class="modal-body">
					<center>
						<p>INVALID INPUT</p>
						<p class="text-info"><a href="<?php echo base_url(); ?>homepage/index" style="font-size: 15px">Click here to go back to Homepage</a></p>
					</center>
				</div>
			</div>
		</div>
	</div>
</body>
</html>