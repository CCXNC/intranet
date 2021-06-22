<div class="card-header" style="background-color:#1C4670; color:white;">
    <h4>Active Directory List
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
            FAQ
        </button>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#1C4670; color:white;">
                        <h5 class="modal-title" id="exampleModalLabel" >FAQ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="<?php echo base_url(); ?>assets/images/Telephone_FAQ.jpg" alt="" style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </h4> 
</div>
<br>
<table id="" class="display" width="100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th>Employee Picture</th>
            <th scope="col">Employee Name</th>
            <th scope="col">Department</th>
            <th class="email">Email</th>
            <th scope="col">Telephone No.</th>
        </tr>
    </thead>
    <tbody>
        <?php if($active_directories) : ?>
            <?php foreach($active_directories as $active_directory) : ?>
                <tr>
                    <td data-label="Employee Picture">
                        <?php if($active_directory->picture != NULL) : ?>
                            <center>
                                <img class="emppic" src="<?php echo base_url(); ?>uploads/employee/<?php echo $active_directory->picture; ?>" style="width:75px; height:75px;" alt="">
                            </center>
                        <?php else : ?>
                            <center>
                                <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" style="width: 100px; height: 100px;"  alt="">
                            </center>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $active_directory->fullname; ?></td>
                    <td><?php echo $active_directory->department; ?></td>
                    <td>
                        <?php 
                            if($active_directory->email == NULL){
                                echo '<p class="" style="text-align:center; padding:15px; background-color: #E7D2CC;"></p>';
                            }
                            else{
                                echo $active_directory->email;
                            } 
                        ?>
                    </td>
                    <td><?php echo $active_directory->telephone_no; ?></td>
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
           // "scrollX" : true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'Blfrtip',
            buttons: [
                {
                    header: false,
                    extend: 'copy',
                    text: 'Copy All Email',
                    title: '',
                    exportOptions: {
                        columns: [3]
                    }
                }
            ]
        } );
    } );
</script>