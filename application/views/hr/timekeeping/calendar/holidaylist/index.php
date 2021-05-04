<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color: #478C5C; border: #478C5C; color: white">
    <h4>CALENDAR OF HOLIDAYS
        <a href="<?php echo base_url(); ?>calendar/add_calendar_list" title="Add Holiday" class="btn btn-dark float-right" >ADD</a>
        <!--<a href="<?php echo base_url(); ?>calendar/holiday_calendar" title="View Holiday Calendar" class="btn btn-dark float-right" style="margin-right:10px;">CALENDAR</a>-->
    </h4> 
</div>
<br>
<table id="" class="display" width="100%">
    <thead>
        <tr style="">
            <th scope="col">Date</th>
            <th scope="col">Type</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($calendars) : ?> 
            <?php foreach($calendars as $calendar) : ?>
                <tr>
                    <td data-label="Start Date"><?php echo $calendar->date;  ?></td>
                    <td data-label="Type"><?php echo $calendar->type; ?></td>
                    <td data-label="Description"><?php echo word_limiter($calendar->description, 10); ?></td>
                    <td data-label="Action">
                        <div class="btn-group">
                            <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!--<a title="View Holiday" class="dropdown-item" href="<?php echo base_url(); ?>calendar/add_employee_holiday/<?php echo $calendar->id; ?>"> Add Employee</a>-->
                                <a title="View Holiday" class="dropdown-item" href="<?php echo base_url(); ?>calendar/view_calendar_list/<?php echo $calendar->date; ?>"> View</a>
                                <a title="Edit Holiday" class="dropdown-item" href="<?php echo base_url(); ?>calendar/edit_calendar_list/<?php echo $calendar->id; ?>">Edit</a>
                                <a title="Delete Holiday" onclick="return confirm('Are you sure you want to delete data?');" class="dropdown-item" href="<?php echo base_url(); ?>calendar/delete_calendar_list/<?php echo $calendar->id?>">Delete</a>
                                <?php if($calendar->type != "Economic Holiday") : ?><a title="Update Employee Holiday" class="dropdown-item" href="<?php echo base_url(); ?>calendar/update_employee/<?php echo $calendar->id; ?>/<?php echo $calendar->date;?>">Update Employee</a> <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<script type="text/javascript">  
    $(document).ready(function() {
        $('table.display').DataTable( {
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
            "scrollX": true,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Calendar Of Holiday',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Calendar Of Holiday',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    title: 'Calendar Of Holiday',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    title: 'Calendar Of Holiday',
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
    } );
</script>