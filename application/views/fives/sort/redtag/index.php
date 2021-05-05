<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color:#1C4670; color:white;"><h4>DEPARTMENT RED TAG LIST
    <a href="" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">RED TAG</a>
    <a href="<?php echo base_url(); ?>fives/red_tag_add" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">ADD</a>
    </h4> 
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Red Tag Number</th>
            <th scope="col">Date</th>
            <th scope="col">Tagged By</th>
            <th scope="col">Department</th>
            <th scope="col">Description</th>
            <th scope="col">Location</th>
            <th scope="col">Reason</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($redtags) : ?>
            <?php foreach ($redtags as $redtag) : ?>
                <tr>
                    <td><?php echo $redtag->red_tag_number; ?></td>
                    <td><?php echo date('F j, Y', strtotime($redtag->red_tag_date)); ?></td>
                    <td><?php echo $redtag->tagged_by;?></td>
                    <td><?php echo $redtag->department;?></td>
                    <td><?php echo $redtag->item_description;?></td>
                    <td><?php echo $redtag->item_location;?></td>
                    <td><?php echo $redtag->reason;?></td>
                    <td></td>
                    <td>
                        <div class="btn-group">
                            <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" title="View Idea" href="<?php echo base_url(); ?>fives/red_tag_view/<?php echo $redtag->id; ?>/<?php echo $redtag->red_tag_number; ?>"> View</a>
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
            //"scrollY" : '50vh',
            //"scrollX" : true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Red Tag',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Red Tag',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    title: 'Red Tag',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    title: 'Red Tag',
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