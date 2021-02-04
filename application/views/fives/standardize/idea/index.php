<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header"><h4>5S IDEA LIST
    <a href="<?php echo base_url(); ?>fives/idea_add" class="btn btn-info float-right" style="margin-right:10px;">ADD</a>
    </h4> 
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Control No.</th>
            <th scope="col">Submitted By</th>
            <th scope="col">BU</th>
            <th scope="col">Department</th>
            <th scope="col">Proposal</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($ideas) : ?> 
            <?php foreach($ideas as $idea) : ?>
                <tr>
                    <td data-label="Date"><?php echo $idea->submit_date;  ?></td>
                    <td data-label="Business Unit"><?php echo $idea->control_number;?></td>
                    <td data-label="Department"><?php echo $idea->submit_by; ?></td>
                    <td data-label="Position"><?php echo $idea->company; ?></td>
                    <td data-label="Date Hired"><?php echo $idea->department; ?></td>
                    <td data-label="Employee Status"><?php echo $idea->proposal; ?></td>
                    <td data-label="Employee Status" <?php echo $idea->status == "Implemented" ? 'style="background-color:green; color:white;"' : ''; ?>><?php echo $idea->status; ?></td>
                    <td data-label="Action">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>fives/idea_view/<?php echo $idea->id; ?>"> View</a>
                                <a class="dropdown-item" href="<?php echo base_url(); ?>fives/idea_edit/<?php echo $idea->id; ?>/<?php echo $idea->control_number; ?>">Edit</a>
                                <a class="dropdown-item" href="">Delete</a>
                                <?php if($this->session->userdata('access_level_id') == 1 && $idea->status != "Implemented") : ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>fives/status/<?php echo $idea->id; ?>/<?php echo $idea->control_number; ?>/<?php echo $idea->status; ?>">Status</a>
                                    
                                <?php endif; ?>    
                                <?php if($this->session->userdata('access_level_id') == 1 && $idea->status != 'Open') : ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>fives/edit_status/<?php echo $idea->control_number; ?>/<?php echo $idea->status; ?>">Edit Status</a>
                                <?php endif; ?>  
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
            ],
            columnDefs: [ {
                targets: -1,
                visible: false
            } ]
        } );
    } );
</script>