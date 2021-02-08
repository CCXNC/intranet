<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header"><h4>IMPLEMENTED 5S SHARE MY IDEA LIST
    <a href="<?php echo base_url(); ?>fives/idea" class="btn btn-info float-right" style="margin-right:10px;">BACK</a>
    </h4> 
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr>
            <th scope="col">Control No.</th>
            <th scope="col">Date</th>
            <th scope="col">Submitted By</th>
            <th scope="col">Department</th>
            <th scope="col">Current</th>
            <th scope="col">Proposal</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if($ideas) : ?> 
            <?php foreach($ideas as $idea) : ?>
                <tr>
                    <td data-label="Business Unit"><a href="<?php echo base_url(); ?>fives/idea_view/<?php echo $idea->id; ?>"><?php echo $idea->control_number;?></a></td>
                    <td data-label="Date"><?php echo $idea->submit_date;  ?></td>
                    <td data-label="Department"><?php echo $idea->submit_by; ?></td>
                    <td data-label="Date Hired"><?php echo $idea->department; ?></td>
                    <td data-label="Date Hired"><?php echo $idea->current; ?></td>
                    <td data-label="Employee Status"><?php echo $idea->proposal; ?></td>
                    <td data-label="Employee Status" <?php echo $idea->status == "Implemented" ? 'style="background-color:green; color:white;"' : ''; ?>><?php echo $idea->status; ?></td>
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