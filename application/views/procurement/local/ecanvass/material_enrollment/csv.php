
<style type="text/css">
	.container {
		margin-top: 100px;
	}
	form {
		border: 2px solid;
		width: 50%;
    	padding: 10px;
    	box-shadow: 5px 10px;
	}
</style>
	<div class="container box">  
	
		<h3 align="center">UPLOAD MATERIAL INFORMATION</h3>
		<br />
		<center>
			
			<form method="post" id="import_csv" enctype="multipart/form-data">
				<?php if($this->session->flashdata('error_msg')) : ?>
					<p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
				<?php endif; ?>
				<div class="form-group">
					<label style="font-size:12px">Select CSV File</label>
					<input type="file" style="font-size:12px" name="csv_file" id="csv_file" required accept=".csv" />
				</div>
				<button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn" style="font-size:12px">Import</button>
			</form>
		</center>
	</div>
<script>
$(document).ready(function(){

	$('#import_csv').on('submit', function(event){
		event.preventDefault();
		//document.getElementById('loadarea').src = '<?php echo base_url(); ?>csv_import/import';
		$.ajax({
			url:"<?php echo base_url(); ?>procurement/material_import",
			method:"POST",
			data:new FormData(this), 
			contentType:false,
			cache:false,
			processData:false,
			beforeSend:function(){
				$('#import_csv_btn').html('Importing...');
			},
			success:function(data)
			{
				$('#import_csv')[0].reset();
				$('#import_csv_btn').attr('disabled', false);
				$('#import_csv_btn').html('Import Done');
				load_data();
			}
		})
	});
	
});
</script>