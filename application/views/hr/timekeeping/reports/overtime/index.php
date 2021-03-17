<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header" style=""><h4>OVERTIME LIST <a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a> <a href="<?php echo base_url(); ?>reports/add_ot" class="btn btn-dark float-right" title="Add Overtime" style="border:1px solid #ccc; margin-right:10px;">ADD</a> </h4></div>
<br>
<form method="POST" id="" enctype="multipart/form-data">
    <div class="row">
        &nbsp;&nbsp;&nbsp;<div class="form-group">
            <label for="">START DATE</label>
            <input type="date" class="form-control" name="start_date" value="">
        </div> &nbsp;
        <div class="form-group">
            <label for="">END DATE</label>
            <input type="date" class="form-control" name="end_date" value="">
        </div> &nbsp;
        <div class="form-group">
            <label for="">&nbsp;</label>
            <input type="submit" title="Submit Date" value="SUBMIT" class="form-control btn btn-dark">
        </div> &nbsp;
        <div class="form-group">
            <label for="">&nbsp;</label>
            <input class="form-control btn btn-success" id="" type="submit" value="APPROVAL">
        </div>
    </div>    
    <table id="" class="display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col"><center><input type="checkbox" id="checkAll" name=""></center></th>
                <th scope="col">EMPLOYEE NAME</th>
                <th scope="col">DEPARTMENT</th>
                <th scope="col">OT DATE</th>
                <th scope="col">NO. OF HOURS</th>
                <th scope="col">TASK</th>
                <th scope="col">STATUS</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                </tr>
        </tbody>
    </table>  
</form>
          
<script type="text/javascript">
    $(document).ready(function() {
        $('table.display').DataTable( {
            "paging":   false,
            "ordering": false,
            "info":     false,
            dom: 'Bf',
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
                ]
        } );
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    } );
</script>