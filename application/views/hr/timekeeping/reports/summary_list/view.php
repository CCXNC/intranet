<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
    <div class="card-header" style="background-color: #2E8BC0; border:#2E8BC0; color: white"><h4>SUMMARY LIST<a href="<?php echo base_url(); ?>reports/summary_list" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4> 
    </div>
    <br>
    <table id="" class="display table-responsive" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col">EMPLOYEE NAME</th>
                <th scope="col">DEPARTMENT</th>
                <th scope="col">RANK</th>
                <th scope="col">TARDINESS</th>
                <th scope="col">UNDERTIME</th>
                <th scope="col">ABSENCES</th>
                <th scope="col">SL</th>
                <th scope="col">VL</th>
                <th scope="col">ML</th>
                <th scope="col">PL</th>
                <th scope="col">BL</th>
                <th scope="col">SPL</th>
                <th scope="col">ROT</th>
                <th scope="col">ND</th>
                <th scope="col">RD</th>
                <th scope="col">RDOT</th>
                <th scope="col">RH</th>
                <th scope="col">RHOT</th>
                <th scope="col">SH</th>
                <th scope="col">SHOT</th>
            </tr>
        </thead>
        <tbody>
            <?php if($employees) : ?>
                <?php foreach($employees as $employee) : ?>
                    <tr>
                        <td><?php echo $employee->fullname; ?></td>
                        <td><?php echo $employee->department_name; ?></td>
                        <td><?php echo $employee->rank_name; ?></td>
                        <td></td>
                        <td></td>

                        <!-- ABCENSES -->
                        <td>
                            <?php if($total_absences) : ?>
                                <?php foreach($total_absences as $total_absent) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_absent->employee_number)
                                        {
                                            echo $total_absent->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                        <!-- SL -->
                        <td>
                            <?php if($total_sls) : ?>
                                <?php foreach($total_sls as $total_sl) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_sl->employee_number)
                                        {
                                            echo $total_sl->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                        <!-- VL -->
                        <td>
                            <?php if($total_vls) : ?>
                                <?php foreach($total_vls as $total_vl) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_vl->employee_number)
                                        {
                                            echo $total_vl->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                        <!-- ML -->
                        <td>
                            <?php if($total_mls) : ?>
                                <?php foreach($total_mls as $total_ml) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_ml->employee_number)
                                        {
                                            echo $total_ml->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                        <!-- PL -->
                        <td>
                            <?php if($total_pls) : ?>
                                <?php foreach($total_pls as $total_pl) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_pl->employee_number)
                                        {
                                            echo $total_pl->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                        <!-- BL -->
                        <td>
                            <?php if($total_bls) : ?>
                                <?php foreach($total_bls as $total_bl) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_bl->employee_number)
                                        {
                                            echo $total_bl->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        
                        <!-- SPL -->
                        <td>
                            <?php if($total_spls) : ?>
                                <?php foreach($total_spls as $total_spl) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_spl->employee_number)
                                        {
                                            echo $total_spl->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                         <!-- ROT -->
                        <td>
                            <?php if($total_rots) : ?>
                                <?php foreach($total_rots as $total_rot) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_rot->employee_number)
                                        {
                                            $cnvrt_rot = $total_rot->ot_num / 60;
                                            $roundoff_rot = round($cnvrt_rot, 2);
                                            echo $roundoff_rot;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>  
    <script type="text/javascript">  
        $(document).ready(function() {
            $('.display').DataTable( {
                "bStateSave": true,
                dom: 'Blfrtip',
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