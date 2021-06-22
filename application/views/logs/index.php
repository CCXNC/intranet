<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color: #0C2D48; border: #0C2D48; color: white">
    <h4>ACTIVITY LOGS</h4> 
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Date</th>
            <th scope="col">Username</th>
            <th scope="col">Type</th>
            <th scope="col">Activity</th>
            <th scope="col">PC IP</th>
        </tr>
    </thead>
    <tbody>
    <?php if($logs) : ?>
        <?php foreach($logs as $log) : ?>
            <tr>
                <td data-label="Date"><?php echo $log->date;  ?></td> 
                <td data-label="Username"><?php echo $log->username;  ?></td>
                <td data-label="Type"><?php echo $log->type?></td>
                <td data-label="Activity"><?php echo $log->activity; ?></td>
                <td data-label="PC IP"><?php echo $log->pc_ip?></td>
            </tr>        
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<script type="text/javascript">  
    $(document).ready(function() {
        $('table.display').DataTable( {
            "order": [[0, "asc" ]],
            //"scrollX": true,
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Activity Logs',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Activity Logs',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    title: 'Activity Logs',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    title: 'Activity Logs',
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