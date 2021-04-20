<div class="card-header" style="background-color:#1C4670; color:white;"><h4>Location Directory List</h4>
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