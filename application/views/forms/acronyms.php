<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color: #0C2D48; color: white"><h4>Blaine Acronyms<a href="<?php echo base_url(); ?>forms/index" id="back" title="Go Back" class="btn btn-info float-right d-print-none" style="margin-right:10px;">Back</a></h4></div>
<br>
<table id="" class="display" width="100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Abbreviation</th>
            <th scope="col">Department</th>
            <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        <?php if($acronyms) : ?>
            <?php foreach($acronyms as $acronym) : ?>
                <tr>
                    <td data-label="Abbreviation"><?php echo $acronym->abbreviation;  ?></td>
                    <td data-label="Department"><?php echo $acronym->department;  ?></td>
                    <td data-label="Definition"><?php echo $acronym->definition;  ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<script type="text/javascript">  
    $(document).ready(function() {
        $('.display').DataTable( {
            dom: 'Alfrtip',
            alphabetSearch: {
                column: 0
            },
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: -1,
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
            //"scrollX" : true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );
    } );
</script>