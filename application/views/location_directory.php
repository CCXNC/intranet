<div class="card-header" style="background-color: #0C2D48; color: white">
    <h4>
        Location Directory List
        <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#exampleModal">
            FAQ
        </button>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#0C2D48; color:white;">
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
            <th scope="col">Name</th>
            <th scope="col">Telephone No.</th>
        </tr>
    </thead>
    <tbody>
        <?php if($location_directories) : ?>
        <?php foreach($location_directories as $loc_directory) :?>
            <tr>
                <td><?php echo strtoupper($loc_directory->name); ?></td>
                <td><?php echo $loc_directory->telephone_no; ?></td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<script type="text/javascript">  
    $(document).ready(function() {
        $('.display').DataTable( {
            "bStateSave": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );
    } );
</script>