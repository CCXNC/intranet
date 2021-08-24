<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color: #0C2D48; color: white;">
    <h4>MATERIAL LIST SUMMARY<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-left:10px;">BACK</a><a href="<?php echo base_url(); ?>procurement/material_enrollment_add" title="Add Form" class="btn btn-info float-right">ADD</a><a href="<?php echo base_url(); ?>procurement/material_enrollment_csv" title="Add Form" class="btn btn-info float-right" style="margin-right: 10px">IMPORT</a></h4> 
</div>
<br>
<table id="" class="display" style="width:100%;font-size:14px">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Material Code</th>
            <th scope="col">Material Description</th>
            <th scope="col">Material Group</th>
            <th scope="col">Material Type</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($materials) : ?>
            <?php foreach($materials as $material) :?>
                <tr>
                    <td><?php echo $material->mcode;?></td>
                    <td><?php echo $material->description;?></td>
                    <td><?php echo $material->group_name;?></td>
                    <td>
                        <?php if ($types) : ?>
                            <?php foreach($types as $type) :?>
                                <?php 
                                    $explode_data = explode("-", $material->mcode); 
                                    $matcode = $explode_data[0];

                                    if($matcode == $type->code)
                                    {
                                        echo $type->type_name;
                                    }
                                ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="btn-group">
                            <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" title="View Material" href="<?php echo base_url();?>procurement/material_enrollment_view/<?php echo $material->id;?>">View</a>
                                <a class="dropdown-item" title="Edit Material" href="<?php echo base_url();?>procurement/material_enrollment_edit/<?php echo $material->id;?>">Edit</a>
                                <a onclick="return confirm('Are you sure you want to delete data?');" title="Delete Material" class="dropdown-item" href="<?php echo base_url(); ?>procurement/material_enrollment_delete/<?php echo $material->id?>">Delete</a>
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
            // "order": [[ 1, 'desc' ]],
            //"bStateSave": true,
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
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    title: 'E-Canvass',
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