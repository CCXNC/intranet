<script type="text/javascript">
    $(document).ready(function(){
        
        var html = '<div id="sib"><br><div class="row"><div class="col-md-3"><div class="form-group"><label>School/Establishment</label><input type="text" class="form-control" name="school[]" ></div></div><div class="col-md-3"><div class="form-group"><label>Course/Diploma</label><input type="text" class="form-control" name="course[]" ></div></div><div class="col-md-3"><div class="form-group"><label>Year Graduated</label><input type="text" class="form-control"  name="year_graduated[]" > </div></div><div class="col-md-3"><div class="form-group"><label>License</label> <input type="text" class="form-control"  name="license[]" ></div></div></div> <input class="btn btn-danger" type="button" name="remove" id="remove" value="Remove"></div>';
        var children = '<div id="child"><br><div class="row"><div class="col-md-12"><div class="form-group"><input type="text" class="form-control" name="children_full_name[]" placeholder="Full Name"></div></div></div><div class="row"><div class="col-md-4"><div class="form-group"><label>Birthdate</label><input type="date" class="form-control"  name="children_birthday[]"></div></div><div class="col-md-4"><div class="form-group"><label>Age</label><input type="text" class="form-control"  name="children_age[]"></div></div><div class="col-md-4"><div class="form-group"><label>Gender</label><select class="form-control" name="children_gender[]"><option value="">Select Gender</option><option value="male">Male</option><option value="female">Female</option></select></div></div></div>   <input class="btn btn-danger" type="button" name="remove" id="cremove" value="Remove"></div></div>';
        var max = 10;
        var x = 1;
        var cmax = 10;
        var c = 1;

        $("#add").click(function(){
        if(x <= max){
            $("#table_field").append(html);
            x++;
        }
        });
        $("#table_field").on('click','#remove',function(){
        $(this).closest('#sib').remove();
        x--;
        });

        $("#cadd").click(function(){
        if(c <= cmax){
            $("#children_field").append(children);
            c++;
        }
        });
        $("#children_field").on('click','#cremove',function(){
        $(this).closest('#child').remove();
        c--;
        });

    });
</script>

    <div class="card">
        <div class="card-header"><h4><?php echo $employee->fullname; ?></h4></div>
        <div class="card-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
            <form method="post" action="<?php echo base_url(); ?>employee/add_info/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">Spouse's Information</div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="employee_number" value="<?php echo $employee->emp_no; ?>" hidden>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="spouse_full_name" placeholder="Full Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input type="date" class="form-control"  name="spouse_birthday">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input type="text" class="form-control"  name="spouse_age">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Occupation</label>
                                    <input type="text" class="form-control"  name="occupation">
                                </div>
                            </div>
                        </div> 
                       
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">Children's Information</div>
                    <div class="card-body" id="children_field">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="children_full_name[]" placeholder="Full Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input type="date" class="form-control"  name="children_birthday[]">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input type="text" class="form-control"  name="children_age[]">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control" name="children_gender[]">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>   
                        <input class="btn btn-success" type="button" name="add" id="cadd" value="ADD">
                        <br>
                    </div>
                </div>
                 <br>   
                <div class="card">
                    <div class="card-header">Academe Information</div>
                    <div class="card-body" id="table_field">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>School/Establishment</label>
                                    <input type="text" class="form-control" name="school[]" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Course/Diploma</label>
                                    <input type="text" class="form-control" name="course[]" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Year Graduated</label>
                                    <input type="text" class="form-control"  name="year_graduated[]" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>License</label>
                                    <input type="text" class="form-control"  name="license[]" >
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-success" type="button" name="add" id="add" value="ADD">
                        <br>
                    </div>
                </div>
                <br>
                <center>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                    </div>
                </center>
               
            </form>
        </div>
    </div>
