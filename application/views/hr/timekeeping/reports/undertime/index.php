<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header" style="background-color: #067593;color:white;"><h4>UNDERTIME LIST <a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a> <a href="<?php echo base_url(); ?>reports/add_ut" class="btn btn-dark float-right" title="Add Undertime" style="border:1px solid #ccc; margin-right:10px;">ADD</a> </h4></div>
<br>
<form method="POST" id="" enctype="multipart/form-data">
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
            <input class="form-control btn btn-success" id="" type="submit" value="APPROVAL">
        </div>
    </div>    
    <table id="" class="display" style="width:100%">
        <thead> 
            <tr style="background-color:#D4F1F4;">
                <th scope="col"><center><input type="checkbox" id="checkAll" name=""></center></th>
                <th scope="col">EMPLOYEE NAME</th>
                <th scope="col">DEPARTMENT</th>
                <th scope="col">DATE</th>
                <th scope="col">TIME START</th>
                <th scope="col">TIME END</th>
                <th scope="col">TOTAL HOURS</th>
                <th scope="col">REASON</th>
                <th scope="col">STATUS</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if($uts) :?>
                <?php foreach($uts as $ut) : ?>
                    <tr <?php echo $ut->status != 1 ? 'style="background-color:#e3342f;color:white;"' : ''; ?>>
                        <td><center><input type="checkbox" name="ut[]" value=""></center></td>
                        <td><?php echo $ut->fullname; ?></td>
                        <td><?php echo $ut->department; ?></td>
                        <td><?php echo $ut->date_ut; ?></td>
                        <td><?php echo $ut->time_start; ?></td>
                        <td><?php echo $ut->time_end; ?></td>
                        <td>
                            <?php 
                                $ut_num = $ut->ut_num;
                                $ut_hrs = intdiv($ut_num, 60).'.'. ($ut_num % 60);
                                echo $ut_hrs;
                            ?>
                        </td>
                        <td><?php echo substr($ut->reason,0,50); ?></td>
                        <td>
                            <?php 
                                if($ut->status == 1) {
                                    echo 'APPROVED';
                                } else {
                                    echo 'FOR APPROVAL';
                                }
                            ?>
                        </td>
                        <td data-label="Action">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="<?php echo base_url();?>reports/view_employee_ut/<?php echo $ut->id; ?>">View</a>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>reports/edit_employee_ut/<?php echo $ut->id; ?>">Edit</a>
                                    <a class="dropdown-item" onclick="return confirm('Do you want to delete data?');" href="<?php echo base_url(); ?>reports/delete_employee_ut/<?php echo $ut->id; ?>">Delete</a>
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