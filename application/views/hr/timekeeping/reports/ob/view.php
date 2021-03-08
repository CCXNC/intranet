<div class="card-header"><h4>OB LIST<a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
<br>
<table id="" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">NAME</th>
            <th scope="col">DESTINATION</th>
            <th scope="col">PURPOSE</th>
            <th scope="col">TRANSPORT</th>
            <th scope="col">DEPARTURE</th>
            <th scope="col">ARRIVAL</th>
            <th scope="col">ACTION</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>            
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
    } );
</script>