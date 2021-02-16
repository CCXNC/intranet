<div class="card">
    <div class="card-header" style="background-color:#1C4670; color:white;"><h4>5S SHARE MY IDEA<a href="<?php echo base_url(); ?>fives/idea" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>fives/idea_add" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color:#1C4670; color:white;">My Idea</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Current</label>
                                <textarea type="text" class="form-control" name="current" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proposal</label>
                                <textarea type="text" class="form-control" name="proposal" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type='file' name='data1' size='20' />
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proposed By</label>
                                <select name="employee" id="" class="form-control col-md-6">
                                    <?php if($employees) : ?>
                                    <?php foreach($employees as $employee) : ?>
                                    <option value="<?php echo $employee->fullname . '|' . $employee->department_id . '|' . $employee->company_id; ?>"<?php echo $this->session->userdata('employee_number') == $employee->emp_no ? 'selected' : ''; ?>><?php echo $employee->fullname; ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>  
            </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" class="btn" style="background-color:#1C4670; color:white;" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
            
        </form>
    </div>
</div>
