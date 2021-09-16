<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color: #0C2D48; color: white"><h4>Blaine Acronyms<a href="<?php echo base_url(); ?>forms/index" id="back" title="Go Back" class="btn btn-info float-right d-print-none" style="margin-right:10px;">BACK</a></h4></div>
<br>
<table id="" class="display" width="100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Department</th>
            <th scope="col">Abbreviation</th>
            <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td>Productivity</td>
                <td>CIT</td>
                <td>Continuous Improvement Team</td>
            </tr> 
            <tr>
                <td>Productivity</td>
                <td>IT</td>
                <td>Information Technology</td>
            </tr> 
            <tr>
                <td>Productivity</td>
                <td>KPI</td>
                <td>Key Performance Indicator</td>
            </tr> 
            <tr>
                <td>Warehouse</td>
                <td>Bx</td>
                <td>Box</td>
            </tr> 
            <tr>
                <td>Warehouse</td>
                <td>Cm</td>
                <td>Centimeters</td>
            </tr> 
            <tr>
                <td>Accounting</td>
                <td>FS</td>
                <td>Financial Statement</td>
            </tr> 
            <tr>
                <td>Accounting</td>
                <td>AR</td>
                <td>Accounts Receivable</td>
            </tr> 
            <tr>
                <td>Accounting</td>
                <td>Accr</td>
                <td>Accrued</td>
            </tr> 
    </tbody>
</table>
<script type="text/javascript">  
    $(document).ready(function() {
        $('.display').DataTable( {
            dom: 'Alfrtip',
            alphabetSearch: {
                column: 0
            },
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