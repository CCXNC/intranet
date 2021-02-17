<style>
    p {
        font-size: 18px;
    }
</style>
<div class="card"> 
    <div class="card-header"><h4><?php echo $schedule->fullname; ?><a href="<?php echo base_url(); ?>schedule/index" class="btn btn-dark float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header"><h5>SCHEDULE</h5></div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">EMPLOYEE NUMBER</th>
                            <th scope="col">BIOMETRIC ID</th>
                            <th scope="col">EFFECTIVE DATE</th>
                            <th scope="col">DAYS</th>
                            <th scope="col">TIME</th>
                            <th scope="col">GRACE PERIOD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $schedule->employee_number; ?></td>
                            <td><?php echo $schedule->biometric_id; ?></td>
                            <td><?php echo date('F j, Y', strtotime($schedule->effective_date)); ?></td>
                            <td><?php echo $schedule->days; ?></td>
                            <td><?php echo date('h:i A', strtotime($schedule->time_in)) . ' | ' . date('h:i A', strtotime($schedule->time_out)); ?></td>
                            <td><?php echo $schedule->grace_period; ?></td>
                        </tr>
                    </tbody>
                </table>   
            </div>
        </div> 
    </div>
</div>
