<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header"><h4>CALENDAR OF HOLIDAYS
<a href="<?php echo base_url(); ?>timekeeping/add_calendar_list" class="btn btn-info float-right">ADD</a>
    </h4> 
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="">
            <th scope="col">Type</th>
            <th scope="col">Date</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($calendars) : ?> 
            <?php foreach($calendars as $calendar) : ?>
                <tr>
                    <td data-label="Date"><?php echo $calendar->type;  ?></td>
                    <td data-label="Department"><?php echo $calendar->date; ?></td>
                    <td data-label="Date Hired"><?php echo word_limiter($calendar->description, 10); ?></td>
                    <td data-label="Action">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>timekeeping/view_calendar_list/<?php echo $calendar->id; ?>"> View</a>
                                <a class="dropdown-item" href="<?php echo base_url(); ?>timekeeping/edit_calendar_list/<?php echo $calendar->id?>">Edit</a>
                                <a onclick="return confirm('Are you sure you want to delete data?');" class="dropdown-item" href="<?php echo base_url(); ?>timekeeping/delete_calendar_list/<?php echo $calendar->id?>">Delete</a>
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
            dom: 'Blfrtip',
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
    } );
</script>