<!--TITLE-->
<div class="card-header" style="background-color: #0C2D48; color: white">
    <h5>HR DASHBOARD</h5> 
</div>
<br>
<!--MANCOUNT-->
<input type="text" id="babyBommer" hidden value="<?php echo $baby_boomer->total_baby_boomer; ?>">
<input type="text" id="genX" hidden value="<?php echo $gen_x->total_gen_x; ?>">
<input type="text" id="genY" hidden value="<?php echo $millennial->total_millennials; ?>">
<input type="text" id="genZ" hidden value="<?php echo $gen_z->total_gen_z; ?>">

<div class="row">
  
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="padding:10px 0 10px 0; box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);">
                    <div class="card-body">
                        <h5 class="card-title">Total Employees</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <i class="fas fa-users fa-4x" aria-hidden="true" style="color:#41B5AF"></i>
                            </div>
                            <div class="col-md-6">
                                <p style="font-size:40px"><b><?php echo $employee->total_employee; ?></b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="padding-top:10px; box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);">
                    <div class="card-body">
                        <h5 class="card-title">Male Employees</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <i class="fas fa-male fa-4x" aria-hidden="true" style="color:#1848A0"></i>
                            </div>
                            <div class="col-md-6">
                                <p style="font-size:40px"><b><?php echo $male->total_male; ?></b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="padding-top:10px; box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);">
                    <div class="card-body">
                        <h5 class="card-title">Female Employees</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <i class="fas fa-female fa-4x" aria-hidden="true" style="color:#FF6584"></i>
                            </div>
                            <div class="col-md-6">
                                <p style="font-size:40px"><b><?php echo $female->total_female; ?></b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card" style="box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);">
            <div class="card-body">
            <h5 class="card-title">Year of Generation</h5>
                    <canvas id="myPie" style="margin:0 auto;"></canvas>
            </div>
        </div>
    </div>
    
</div>
<br>
<!--DEPT & RANK-->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="background-color: #0C2D48; color: white">
                <h5>Personnel Per Department</h5>
            </div>
            <div class="card-body">
                <canvas id="myChart1" style="width:100px; height:70px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="background-color: #0C2D48; color: white">
                <h5>Personnel Per Rank</h5>
            </div>
            <div class="card-body">
                <canvas id="myChart" style="width:100px; height:70px;"></canvas>
            </div>
        </div>
    </div>
</div>
<br>
<!--TABLE-->
<section>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="13" style="text-align:center;background-color: #0C2D48; color: white">2021</th>
            </tr>
            <tr>
            <th scope="col" style="background-color: #0C2D48; color: white">Category</th>
            <th scope="col" style="background-color: #3C7782; color: white">Jan</th>
            <th scope="col" style="background-color: #3C7782; color: white">Feb</th>
            <th scope="col" style="background-color: #3C7782; color: white">Mar</th>
            <th scope="col" style="background-color: #3C7782; color: white">Apr</th>
            <th scope="col" style="background-color: #3C7782; color: white">May</th>
            <th scope="col" style="background-color: #3C7782; color: white">Jun</th>
            <th scope="col" style="background-color: #3C7782; color: white">Jul</th>
            <th scope="col" style="background-color: #3C7782; color: white">Aug</th>
            <th scope="col" style="background-color: #3C7782; color: white">Sep</th>
            <th scope="col" style="background-color: #3C7782; color: white">Oct</th>
            <th scope="col" style="background-color: #3C7782; color: white">Nov</th>
            <th scope="col" style="background-color: #3C7782; color: white">Dec</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row" style="background-color: #3C7782; color: white">Total Number of Employees</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th scope="row" style="background-color: #3C7782; color: white">Retention</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th scope="row" style="background-color: #3C7782; color: white">New Hire</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</section>
<br>
<!--BDAY & NEW HIRES-->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="background-color: #0C2D48; color: white">
                <h5><?php echo date('F'); ?> New Hires</h5>
            </div>
            <div class="card-body">
                <b>Let's welcome them to our company!</b>
                <br><br>
                <div class="row">
                    <?php if($employee_new_hires) : ?>
                        <?php foreach($employee_new_hires as $employee_new_hire) :  ?>
                            <div class="col-md-4" style="padding:10px; text-align:center;">
                                <?php if($employee_new_hire->picture != NULL) : ?>
                                    <img src="<?php echo base_url(); ?>uploads/employee/<?php echo $employee_new_hire->picture; ?>" style="width:120px;height: 120px;border:1px solid #cccccc;border-radius: 50%;" alt="">
                                <?php else : ?>
                                    <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" style="width:120px;height: 120px; border:1px solid #cccccc;border-radius: 50%;"  alt="">
                                <?php endif; ?>  
                                <center><b style="font-size:12px;"><?php echo $employee_new_hire->fullname; ?>  </b>  </center>
                            </div>   
                        <?php endforeach; ?>
                    <?php endif;  ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="background-color: #0C2D48; color: white">
                <h5>Meet Your HR</h5>
            </div>
            <div class="card-body">
                <b>&nbsp;</b>
                <div class="row">
                    <?php if($hr_teams) : ?>
                        <?php foreach($hr_teams as $hr_team) :  ?>
                            <?php if($hr_team->emp_no == "03171124" || $hr_team->emp_no == "04212104" || $hr_team->emp_no == "06212105") : ?>
                                <div class="col-md-4" style="text-align:center;">
                                    <?php if($hr_team->picture != NULL) : ?>
                                        <img src="<?php echo base_url(); ?>uploads/employee/<?php echo $hr_team->picture; ?>" style="width:120px;height: 120px;border:1px solid #cccccc;border-radius: 50%;" alt="">
                                    <?php else : ?>
                                        <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" style="width:120px;height: 120px;border:1px solid #cccccc;border-radius: 50%;"  alt="">
                                    <?php endif; ?>  
                                    <center><b style="font-size:12px;"><?php echo $hr_team->fullname; ?>  </b>  </center>
                                </div>  
                            <?php endif;  ?>     
                        <?php endforeach; ?>
                    <?php endif;  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<!--HR-->
<div class="row">
    <div class="col-md-12">
        <div class="card" style="background-image: url('../assets/images/bday.png');background-size:contain;">
            <div class="card-header" style="background-color: #0C2D48; color: white">
                <h5><?php echo date('F'); ?> Celebrants</h5>
            </div>
            <div class="card-body">
                <center><h1 style="color:#C85250"><b>Happy Birthday! <i class="fa fa-birthday-cake" aria-hidden="true"></i></b></h1></center>
                <br>
                <div class="row">
                    <?php if($employee_bdays) : ?>
                        <?php foreach($employee_bdays as $employee_bday) :  ?>
                            <div class="col-md-3" style="padding:5px; text-align:center;">
                                <?php if($employee_bday->picture != NULL) : ?>
                                    <center>
                                        <div class="card" style="height:200px;width: 180px; border-radius:5%; border: solid #0B514C 2px; color:black; background-color:#E8FCFB;">
                                            <center>
                                                <br>
                                                <img class="card-img-top" src="<?php echo base_url(); ?>uploads/employee/<?php echo $employee_bday->picture; ?>" style="border-radius:20%;width:100px;height: 100px;border:1px solid #cccccc;box-shadow:0 12px 15px 0 rgba(0,0,0,.50),0 17px 50px 0 rgba(0,0,0,.30);" alt="">
                                                <div class="card-body">
                                                    <b style="font-size:12px;"><?php echo $employee_bday->fullname; ?>  </b>
                                                </div>
                                            </center>
                                        </div>
                                    </center>
                                <?php else : ?>
                                    <center>
                                        <div class="card" style="height:200px;width: 180px; border-radius:5%; border: solid #0B514C 2px; color:black; background-color:#E8FCFB;">
                                            <center>
                                                <br>
                                                <img class="card-img-top" src="<?php echo base_url(); ?>uploads/employee/user.jpg" style="border-radius:20%;width:100px;height: 100px;border:1px solid #cccccc;box-shadow:0 12px 15px 0 rgba(0,0,0,.50),0 17px 50px 0 rgba(0,0,0,.30);"  alt="">
                                                <div class="card-body">
                                                    <b style="font-size:12px;"><?php echo $employee_bday->fullname; ?>  </b>
                                                </div>
                                            </center>
                                        </div>
                                    </center>
                                <?php endif; ?> 
                            </div>   
                        <?php endforeach; ?>
                    <?php endif;  ?>
                </div>
            </div>                          
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    // RANK
    var bgColor = [];
    $.post("<?php echo base_url();?>dashboard/get_rank",
        function(data){
            var obj = JSON.parse(data);

            range = [];
            title = [];
            $.each(obj, function(i,rank){
                range.push(rank.count_rank);
                title.push(rank.rank_name);
                bgColor.push('#0C2D48');
            });

            

        var ctx = $("#myChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: title,
                datasets: [{
                    label: 'Employee Per Rank ',
                    data: range,
                    backgroundColor: bgColor,
                    borderColor: bgColor,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
           
        });    
    });

    // DEPARTMENT
    var bgColor = [];
    $.post("<?php echo base_url();?>dashboard/get_department",
        function(data){
            var obj = JSON.parse(data);

            range = [];
            title = [];
            code = [];
            $.each(obj, function(i,department){
                range.push(department.count_department);
                title.push(department.department_name);
                code.push(department.department_code);
                bgColor.push('#0C2D48');
            });

            

        var ctx = $("#myChart1");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: title,
                datasets: [{
                    label: 'Total Per Department ',
                    data: range,
                    backgroundColor: bgColor,
                    borderColor: bgColor,
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
            }
           
           
        });    
    });

    var ctx = $("#myPie");
    var bbyBoomer = $("#babyBommer").val();
    var genX = $("#genX").val();
    var genY = $("#genY").val();
    var genZ = $("#genZ").val();
    var generations = [bbyBoomer, genX, genY, genZ];
    console.log(generations);
    var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Baby Boomer', 'Generation X', 'Millennials', 'Generation Z'],
        datasets: [{
            label: '# of Votes',
            data: generations,
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)'
            
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)'
            ],
            borderWidth: 1
        }]
    }
});
   
</script>
