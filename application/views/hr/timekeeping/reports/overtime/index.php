<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header" style="background-color: #0C2D48; color:white;"><h4>OVERTIME LIST <a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a> <a href="<?php echo base_url(); ?>reports/add_ot" class="btn btn-dark float-right" title="Add Overtime" style="border:1px solid #ccc; margin-right:10px;">ADD</a> </h4></div>
<br>
<form method="POST" id="" enctype="multipart/form-data">
    <div class="row">
        &nbsp;&nbsp;&nbsp;<div class="form-group">
            <label for="">START DATE</label>
            <input type="date" class="form-control" min="2018-12-31" max="2030-12-31" name="start_date" value="<?php echo $start_date; ?>">
        </div> &nbsp;
        <div class="form-group">
            <label for="">END DATE</label>
            <input type="date" class="form-control" min="2018-12-31" max="2030-12-31" name="end_date" value="<?php echo $end_date; ?>">
        </div> &nbsp;
        <div class="form-group">
            <label for="">&nbsp;</label>
            <input type="submit" title="Submit Date"  value="SUBMIT" class="form-control btn btn-dark">
        </div> &nbsp;
        <!--<div class="form-group">
            <label for="">&nbsp;</label>
            <input class="form-control btn btn-success" id="" type="submit" value="APPROVAL">
        </div>-->
    </div>    
    <table id="" class="display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col">DATE</th>
                <th scope="col">EMPLOYEE NAME</th>
                <!--<th scope="col">DEPARTMENT</th>-->
                <!--<th scope="col">TYPE</th>-->
                <th scope="col">ACTUAL IN</th>
                <th scope="col">ACTUAL OUT</th>
                <th scope="col">OT TIME START</th>
                <th scope="col">OT TIME END</th>
                <th scope="col">ROT AM</th>
                <th scope="col">ROT PM</th>
                <th scope="col">RD</th>
                <th scope="col">RDOT</th>
                <th scope="col">RH</th>
                <th scope="col">RHOT</th>
                <th scope="col">SH</th>
                <th scope="col">SHOT</th>
                <th scope="col">TASK</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if($ots) : ?>
                <?php foreach($ots as $ot) : ?>
                    <tr <?php //echo $actual_total_ot < $total_ot ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                        <td title="
                            <?php 
                                if($ot->emp_sched_date == $ot->date_ot)
                                {
                                    echo $ot->emp_sched_time_in . ' AM | ' . $ot->emp_sched_time_out . ' PM | ' . $ot->emp_sched_grace_period . ' MINS'; 
                                }
                                else
                                {
                                    echo $ot->sched_time_in . ' AM | ' . $ot->sched_time_out . ' PM | ' . $ot->grace_period . ' MINS'; 
                                }
                               
                            ?>
                        "><?php echo $ot->date_ot; ?></td>
                        <td><?php echo $ot->fullname; ?></td>
                        <!--<td><?php echo $ot->department; ?></td>-->
                        <td><?php echo $ot->actual_time_in; ?></td>
                        <td><?php echo  $ot->actual_time_out; ?></td>
                        <td><?php if($ot->type == "ROT") { echo $ot->time_in; } else { echo $ot->time_start; } ?></td>
                        <td><?php if($ot->type == "ROT") { echo $ot->time_out; } else { echo $ot->time_end; } ?></td>
                        <td><?php echo $ot->rotam; ?></td>
                        <td><?php echo $ot->rotpm; ?></td>
                        <td><?php echo $ot->rd; ?></td>
                        <td><?php echo $ot->rdot; ?></td>
                        <td><?php echo $ot->rh; ?></td>
                        <td><?php echo $ot->rhot; ?></td>
                        <td><?php echo $ot->sh; ?></td>
                        <td><?php echo $ot->shot; ?></td>
                        <td><?php echo substr($ot->task,0,50); ?></td>
                        <!--<td> <center><input type="checkbox" name="leave[]" value=""> </center></td>-->
                        <td data-label="Action">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="">View</a>
                                    <a class="dropdown-item" href="">Edit</a>
                                    <a class="dropdown-item" onclick="return confirm('Do you want to delete data?');" href="">Delete</a>
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
            "order": [[ 0, 'desc' ]],
            //"bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
            //"scrollY" : '50vh',
            "scrollX" : true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'Blfrtip',
            buttons: [
                    {
                        extend: 'excel',
                        title: 'Overtime',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Overtime',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        title: 'Overtime',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Overtime',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'copy',
                        title: 'Overtime',
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
				$('#ut').attr('action', 'process_ut');
				$('#ut').submit();
			} else {
				return false;
			} 
		});
    } );
</script>