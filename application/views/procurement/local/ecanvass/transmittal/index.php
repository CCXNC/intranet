<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color: #0C2D48; color: white;">
    <h4>TRANSMITTAL LIST<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-left:10px;">BACK</a><a href="<?php echo base_url(); ?>procurement/transmittal" title="Add Form" class="btn btn-info float-right">ADD</a></h4> 
</div>
<br>
<table id="" class="display" style="width:100%;font-size:14px">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Transmittal No</th>
            <th scope="col">Material Source ID</th>
            <th scope="col">Material Source Request Date</th>
            <th scope="col">Company</th>
            <th scope="col">Requestor</th>
            <th scope="col">Transmittal Date</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($transmittal_lists) : ?>
            <?php foreach($transmittal_lists as $transmittal_list) : ?>
                <tr>
                    <td><?php echo $transmittal_list->transmittal_no; ?></td>
                    <td><?php echo $transmittal_list->msid; ?></td>
                    <td><?php echo $transmittal_list->ms_request_date; ?></td>
                    <td><?php echo $transmittal_list->company; ?></td>
                    <td><?php echo $transmittal_list->requestor; ?></td>
                    <td><?php echo $transmittal_list->transmittal_date; ?></td>
                    <td data-label="Action">
                        <div class="btn-group">
                            <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" title="View Transmittal" href="<?php echo base_url(); ?>procurement/transmittal_view/<?php echo $transmittal_list->id; ?>/<?php echo $transmittal_list->transmittal_no; ?>">View</a>
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
            <?php if($this->session->userdata('access_level_id') == 1 && $this->session->userdata('department_id') == 25) : ?>
                //EXCEL
                {
                    extend: 'excel',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                //PRINT
                {
                    extend: 'print',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                //COPY
                {
                    extend: 'copy',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
            <?php endif; ?>  
                //PDF
                {
                    extend: 'pdf',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                //FILTER
                {
                    extend: 'colvis',
                    text: 'Filter'
                }
            ]
        } );
    } );
</script>