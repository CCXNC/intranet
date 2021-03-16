<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header" style="background-color: #6547cd;color: white;"><h4>LEAVE OF ABSENCE LIST <a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a> <a href="<?php echo base_url(); ?>reports/add_slvl" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">ADD</a></h4></div>
<br>
<form method="POST" id="slvl" enctype="multipart/form-data">
    <div class="row">
        &nbsp;&nbsp;&nbsp;<div class="form-group">
            <label for="">START DATE</label>
            <input type="date" class="form-control" name="start_date" value="<?php echo $start_date; ?>">
        </div> &nbsp;
        <div class="form-group">
            <label for="">END DATE</label>
            <input type="date" class="form-control" name="end_date" value="<?php echo $end_date; ?>">
        </div> &nbsp;
        <div class="form-group">
            <label for="">&nbsp;</label>
            <input type="submit" value="SUBMIT" class="form-control btn btn-dark">
        </div> &nbsp;
        <div class="form-group">
            <label for="">&nbsp;</label>
            <input class="form-control btn btn-success" style="background-color:#38c172;color:white;" id="process" type="submit" value="APPROVAL">
        </div>
    </div>   
    <table id="" class="display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col"><center><input type="checkbox" id="checkAll" name=""></center></th>
                <th scope="col">EMPLOYEE NAME</th>
                <th scope="col">DEPARTMENT</th>
                <th scope="col">DATE</th>
                <th scope="col">TYPE</th>
                <th scope="col">REASON</th>
                <th scope="col">REMARKS</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if($leaves) : ?>
                <?php foreach($leaves as $leave) : ?>
                    <tr>
                        <td><?php if($leave->status != 1) : ?> <center><input type="checkbox" name="leave[]" value="<?php echo $leave->id . '|' . $leave->fullname; ?>"> <?php endif; ?> </center></td>
                        <td><?php echo $leave->fullname; ?></td>
                        <td><?php echo $leave->department; ?></td>
                        <td><?php echo $leave->leave_date; ?></td>
                        <td><?php echo $leave->type_name . ' (' . $leave->leave_day . ')'; ?></td>
                        <td><?php echo substr($leave->reason,0,50); ?></td>
                        <td><?php if($leave->status == 0) {  echo '<p class="" style="text-align:center;padding:5px;margin-top:15px;background-color:#e3342f;color:white;">FOR APPROVAL</p>';  } else {  echo '<p class="" style="text-align:center;padding:5px;margin-top:15px;background-color:#38c172;color:white;">APPROVED</p>'; } ?></td>
                        <td data-label="Action">
                            <?php if($leave->status != 1) : ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>reports/view_slvl/<?php echo $leave->id; ?>">View</a>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>reports/edit_employee_slvl/<?php echo $leave->id; ?>">Edit</a>
                                        <a class="dropdown-item" onclick="return confirm('Do you want to delete data?');" href="<?php echo base_url(); ?>reports/delete_employee_slvl/<?php echo $leave->id; ?>">Delete</a>
                                    </div>
                                </div>
                            <?php else : ?>
                                <a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>reports/view_slvl/<?php echo $leave->id; ?>">VIEW</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table> 
</form>               
<script type="text/javascript">
    $(document).ready(function() {
        $('table.display').DataTable( {
            "paging":   false,
            "ordering": false,
            "info":     false, 
            dom: 'Bf',
            buttons: [
                    {
                        extend: 'excel',
                        title: '',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        title: '',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        title: '',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        title: '',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'copy',
                        title: '',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Filter'
                    }
                ]
        } );

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $('#process').click(function() {
			var a = confirm("Are you sure you want to Approved Data?");
			if (a == true) {
				$('#slvl').attr('action', 'process_slvl');
				$('#slvl').submit();
			} else {
				return false;
			} 
		});
    } );
</script>
