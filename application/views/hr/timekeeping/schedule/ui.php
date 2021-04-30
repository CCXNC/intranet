<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card">
    <div class="card-header" style=""><h4><?php echo $this->session->userdata('fullname'); ?></h4> 
    </div>
    <div class="card-body" >
        <div class="card">
            <div class="card-header" style="background-color: #3490dc; color:white;"><h4>SCHEDULE <a href="#" title="Add Form" class="btn btn-dark float-right"  data-toggle="modal" data-target="#exampleModal" style="border:1px solid #ccc; margin-right:10px;">ADD</a></h4></div>
            <div class="card-body">
                <div class="row">
                    &nbsp;&nbsp;&nbsp;<div class="form-group">
                        <label for="">START DATE</label>
                        <input type="date" class="form-control" name="start_date" >
                    </div> &nbsp;
                    <div class="form-group">
                        <label for="">END DATE</label>
                        <input type="date" class="form-control" name="end_date">
                    </div> &nbsp;
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <input type="submit" title="Submit Date" value="SUBMIT" class="form-control btn btn-dark">
                    </div> &nbsp;
                </div>  
                <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TIME</th>
                            <th scope="col">GRACE PERIOD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mon</td>
                            <td>2021-04-26</td>
                            <td>7:00 AM | 5:00 PM</td>
                            <td>5 MINUTES</td>
                        </tr>
                        <tr>
                            <td>Tue</td>
                            <td>2021-04-27</td>
                            <td>7:00 AM | 5:00 PM</td>
                            <td>5 MINUTES</td>
                        </tr>
                        <tr>
                            <td>Wed</td>
                            <td>2021-04-28</td>
                            <td>8:00 AM | 6:00 PM</td>
                            <td>5 MINUTES</td>
                        </tr>
                        <tr>
                            <td>Thu</td>
                            <td>2021-04-29</td>
                            <td>7:00 AM | 5:00 PM</td>
                            <td>5 MINUTES</td>
                        </tr>
                        <tr>
                            <td>Fri</td>
                            <td>2021-04-30</td>
                            <td>8:00 AM | 6:00 PM</td>
                            <td>5 MINUTES</td>
                        </tr>
                    </tbody>
                </table>   
            </div>
        </div> 
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ADD SCHEDULE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
            <form method="post" action="<?php echo base_url(); ?>forms/add_attachment" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">START DATE</label>
                            <input type="date" class="form-control" name="attachment1" required><br>
                            <label for="">END DATE</label>
                            <input type="date" class="form-control" name="attachment1" required><br>
                            <label for="">TIME IN</label>
                            <input type="time" class="form-control" name="attachment1" required><br>
                            <label for="">TIME OUT</label>
                            <input type="time" class="form-control" name="attachment1" required><br>
                            <label for="">GRACE PERIOD</label>
                            <input type="text" class="form-control" name="attachment1" required><br>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" title="Close Form" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" title="Submit Form" class="btn btn-primary">Submit</button>
            </div>
            </form>
    </div>
  </div>
</div>

    
                                                