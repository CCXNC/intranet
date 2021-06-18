<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
    <b style="background-color:#ffed4a; color:rgb(50,50,50);"><?php echo date('F j, Y', strtotime($first_date->first_date))  .' - ' . date('F j, Y', strtotime($last_date->last_date)); ?></b>
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

                        <!-- ND -->                
                        <td></td>

                        <!-- RD -->
                        <td>
                            <?php if($total_rds) : ?>
                                <?php foreach($total_rds as $total_rd) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_rd->employee_number)
                                        {
                                            $cnvrt_rd = $total_rd->ot_num / 60;
                                            $roundoff_rd = round($cnvrt_rd, 2);
                                            echo $roundoff_rd;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                        <!-- RDOT-->
                        <td>
                            <?php if($total_rdots) : ?>
                                <?php foreach($total_rdots as $total_rdot) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_rdot->employee_number)
                                        {
                                            $cnvrt_rdot = $total_rdot->ot_num / 60;
                                            $roundoff_rdot = round($cnvrt_rdot, 2);
                                            echo $roundoff_rdot;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                       
                        <!-- RH -->
                        <td>
                            <?php if($total_rhs) : ?>
                                <?php foreach($total_rhs as $total_rh) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_rh->employee_number)
                                        {
                                            $cnvrt_rh = $total_rh->ot_num / 60;
                                            $roundoff_rh = round($cnvrt_rh, 2);
                                            echo $roundoff_rh;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                      
                        <!-- RHOT -->
                        <td>
                            <?php if($total_rhots) : ?>
                                <?php foreach($total_rhots as $total_rhot) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_rhot->employee_number)
                                        {
                                            $cnvrt_rhot = $total_rhot->ot_num / 60;
                                            $roundoff_rhot = round($cnvrt_rhot, 2);
                                            echo $roundoff_rhot;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        
                        <!-- SH -->
                        <td>
                            <?php if($total_shs) : ?>
                                <?php foreach($total_shs as $total_sh) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_sh->employee_number)
                                        {
                                            $cnvrt_sh = $total_sh->ot_num / 60;
                                            $roundoff_sh = round($cnvrt_sh, 2);
                                            echo $roundoff_sh;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                         <!-- SH -->
                       <td>
                            <?php if($total_shots) : ?>
                                <?php foreach($total_shots as $total_shot) : ?>
                                    <?php 
                                        if($employee->emp_no == $total_shot->employee_number)
                                        {
                                            $cnvrt_shot = $total_shot->ot_num / 60;
                                            $roundoff_shot = round($cnvrt_shot, 2);
                                            echo $roundoff_shot;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                       
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