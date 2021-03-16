<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
    <div class="card-header" style="background-color: #2E8BC0; border:#2E8BC0; color: white"><h4>RAW ATTENDANCE LIST<a href="<?php echo base_url(); ?>attendance/index_raw_data" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4> 
    </div>
    <br>
    <table id="" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col">BIOMETRIC ID</th>
                <th scope="col">EMPLOYEE NAME</th>
                <th scope="col">DATE</th>
                <th scope="col">TIME</th>
                <th scope="col">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php if($datas) : ?>
                <?php foreach($datas as $data) : ?>
                    <tr>
                        <td><?php echo $data->biometric_id; ?></td>
                        <td><?php echo $data->fullname; ?></td>
                        <td><?php echo $data->date; ?></td>
                        <td><?php echo $data->time; ?></td>
                        <td><?php echo $data->status; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>  
    <script type="text/javascript">  
        $(document).ready(function() {
            $('.display').DataTable( {
                "bStateSave": true,
                "fnStateSave": function (oSettings, oData) {
                    localStorage.setItem('table.display', JSON.stringify(oData));
                },
                "fnStateLoad": function (oSettings) {
                    return JSON.parse(localStorage.getItem('table.display'));
                },
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false
            } );
        } );
    </script>