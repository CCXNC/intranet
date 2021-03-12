<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header"><h4>OFFICIAL BUSINESS LIST <a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a> <a href="<?php echo base_url(); ?>reports/add_ob" class="btn btn-dark float-right" title="Add OB" style="border:1px solid #ccc; margin-right:10px;">ADD</a> </h4></div>
<br>
<form method="POST" enctype="multipart/form-data">
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
            <input type="submit" title="Submit Date" value="SUBMIT" class="form-control btn btn-dark">
        </div> &nbsp;
        <div class="form-group">
            <label for="">&nbsp;</label>
            <input class="form-control btn btn-dark" title="Process Data" id="afp" type="submit" value="PROCESS">
        </div>
       
    </div>    
    <table id="" class="display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col"><center><input type="checkbox" id="checkAll" name=""></center></th>
                <th scope="col">EMPLOYEE NAME</th>
                <th scope="col">DEPARTMENT</th>
                <th scope="col">DATE OB</th>
                <th scope="col">DESTINATION</th>
                <th scope="col">PURPOSE</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if($obs) : ?>
            <?php foreach($obs as $ob) : ?>
                <tr>
                    <td><center><input type="checkbox" name="employee[]" value=""> </center></td>
                    <td><?php echo $ob->fullname; ?></td>
                    <td><?php echo $ob->department; ?></td>
                    <td><?php echo date('F j, Y', strtotime($ob->date_ob)); ?></td>
                    <td><?php echo substr($ob->destination,0,50); ?></td>
                    <td><?php echo substr($ob->purpose,0,50); ?></td>
                    <td data-label="Action">
                            <div class="btn-group">
                                <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" title="View OB" href="<?php echo base_url(); ?>reports/view_employee_ob/<?php echo $ob->id; ?>">View</a>
                                    <a class="dropdown-item" title="Edit OB" href="<?php echo base_url(); ?>reports/edit_employee_ob/<?php echo $ob->id; ?>">Edit</a>
                                    <a class="dropdown-item" title="Delete OB" onclick="return confirm('Do you want to delete data?');" href="<?php echo base_url(); ?>reports/delete_employee_ob/<?php echo $ob->id; ?>">Delete</a>
                                </div>
                            </div>
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
    } );
</script>