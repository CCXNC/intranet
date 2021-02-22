<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color:#1C4670; color:white;"><h4>5S CONTINUOUS IMPROVEMENT PROJECTS
    <a href="<?php echo base_url(); ?>fives/idea" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a>
    </h4> 
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Control No.</th>
            <th scope="col">Date</th>
            <th scope="col">Encoded By</th>
            <th scope="col">Idea Owner</th>
            <th scope="col">Before</th>
            <th scope="col">After</th>
            <th scope="col">Impact</th>
            <th scope="col">Category</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($ideas) : ?> 
            <?php foreach($ideas as $idea) : ?>
                <tr>
                    <td data-label="Business Unit"><a href="<?php echo base_url(); ?>fives/idea_implemented_view/<?php echo $idea->id; ?>/<?php echo $idea->control_number;?>"><?php echo $idea->control_number;?></a></td>
                    <td data-label="Date"><?php echo date('F j, Y',strtotime($idea->created_date));  ?></td>
                    <td data-label="Submitted By"><?php echo $idea->submit_by; ?></td>
                    <td data-label="Proposed_by"><?php echo $idea->propose_by; ?></td>
                    <td data-label="Before"><?php echo substr($idea->current,0,50); ?></td>
                    <td data-label="After"><?php echo substr($idea->proposal,0,50); ?></td>
                    <td data-label="Impact"><?php echo substr($idea->impact,0,50); ?></td>
                    <td data-label="Impact"><?php echo $idea->classification; ?></td>
                    <td data-label="Action">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if($idea->submit_by == $this->session->userdata('username')) : ?><a class="dropdown-item" href="<?php echo base_url(); ?>fives/edit_implemented_idea/<?php echo $idea->implemented_id; ?>">Edit</a><?php endif; ?>
                                <a class="dropdown-item" href="<?php echo base_url(); ?>fives/idea_implemented_view/<?php echo $idea->id; ?>/<?php echo $idea->control_number;?>">View</a>
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
            //"scrollX": true,
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