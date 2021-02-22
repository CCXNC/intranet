<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color:#1C4670; color:white;"><h4>5S SHARE MY IDEA LIST
    <?php if($this->session->userdata('access_level_id') == 1) : ?>
        <a href="<?php echo base_url(); ?>fives/implemented" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">IMPLEMENTED</a>
    <?php endif; ?>    
    <a href="<?php echo base_url(); ?>fives/idea_add" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">ADD</a>
    </h4> 
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Control No.</th>
            <th scope="col">Date</th>
            <th scope="col">Submitted By</th>
            <th scope="col">Proposed By</th>
            <th scope="col">Department</th>
            <th scope="col">Current</th>
            <th scope="col">Proposal</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($ideas) : ?> 
            <?php foreach($ideas as $idea) : ?>
                <tr>
                    <td data-label="Business Unit"><a href="<?php echo base_url(); ?>fives/idea_view/<?php echo $idea->id; ?>/<?php echo $idea->control_number; ?>"><?php echo $idea->control_number; ?></a></td>
                    <td data-label="Date"><?php echo date('F j, Y', strtotime($idea->submit_date));  ?></td>
                    <td data-label="Department"><?php echo $idea->submit_by; ?></td>
                    <td data-label="Department"><?php echo $idea->propose_by; ?></td>
                    <td data-label="Date Hired"><?php echo $idea->department; ?></td>
                    <td data-label="Date Hired"><?php echo substr($idea->current,0,50); ?></td>
                    <td data-label="Proposal"><?php echo substr($idea->proposal,0,50); ?></td>
                    <?php if($idea->status == "Open" ): ?>
                        <td data-label="Employee Status" style="background-color:#A8D9F8; "><?php echo $idea->status; ?></td>
                    <?php endif; ?>
                    <?php if($idea->status == "Ongoing" ): ?>
                        <td data-label="Employee Status" style="background-color:#FEDE00; "><?php echo $idea->status; ?></td>
                    <?php endif; ?>
                    <?php if($idea->status == "Implemented" ): ?>
                        <td data-label="Employee Status" style="background-color:#7CF3A0; "><?php echo $idea->status; ?></td>
                    <?php endif; ?>
                    <td data-label="Action">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>fives/idea_view/<?php echo $idea->id; ?>/<?php echo $idea->control_number; ?>"> View</a>
                                <?php if($this->session->userdata('username') == $idea->submit_by && $idea->status != "Implemented") : ?>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>fives/idea_edit/<?php echo $idea->id; ?>/<?php echo $idea->control_number; ?>">Edit</a>
                                    <a onclick="return confirm('Are you sure you want to delete data?');" class="dropdown-item" href="<?php echo base_url(); ?>fives/idea_delete/<?php echo $idea->id?>">Delete</a>
                                <?php endif; ?>       
                                <?php if($this->session->userdata('access_level_id') == 1 && $idea->status != "Implemented") : ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>fives/status/<?php echo $idea->id; ?>/<?php echo $idea->control_number; ?>/<?php echo $idea->status; ?>">Edit Status</a>
                                <?php endif; ?>    
                                <?php if($this->session->userdata('access_level_id') == 1 && $idea->status != 'Open' && $idea->status != 'Implemented') : ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>fives/edit_status/<?php echo $idea->control_number; ?>/<?php echo $idea->status; ?>">Edit Remarks</a>
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
           // "scrollX" : true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
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