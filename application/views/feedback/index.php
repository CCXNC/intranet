<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color:#1C4670; color:white;"><h4>Blaine E-Feedback List
<?php if($this->session->userdata('access_level_id') == 1 || $this->session->userdata('access_level_id') == 3) : ?><a href="#" class="btn btn-dark float-right"  data-toggle="modal" data-target="#exampleModal" title="Add Feedback" style="border:1px solid #ccc; margin-right:10px;">ADD</a> <?php endif; ?>
    </h4> 
</div>
<br> 
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Date</th>
            <?php if($this->session->userdata('department_id') == 25 && $this->session->userdata('access_level_id') == 1) : ?><th scope="col">Name</th><?php endif; ?>
            <th scope="col">Type</th>
            <th scope="col">Title</th>
            <th>Remarks</th>
            <?php if($this->session->userdata('department_id') == 25 && $this->session->userdata('access_level_id') == 1) : ?><th scope="col">No. Comment</th><?php endif; ?>
            <?php if($this->session->userdata('department_id') == 25 && $this->session->userdata('access_level_id') == 1) : ?><th scope="col">Status</th><?php endif; ?>
            <th scope="col">Action</th>
        </tr>
    </thead> 
    <tbody>
        <?php if($feedbacks) : ?>
            <?php foreach($feedbacks as $feedback) : ?>
                <tr>
                    <td data-label="Date"><?php echo date('y-m-d', strtotime($feedback->date));  ?></td>
                    <?php if($this->session->userdata('department_id') == 25 && $this->session->userdata('access_level_id') == 1) : ?><td data-label="Name"><?php echo $feedback->fullname;  ?></td><?php endif; ?>
                    <td data-label="Category"><?php echo $feedback->category;  ?></td>
                    <td data-label="Title"><?php echo $feedback->title;?></td>
                    <td data-label="Category"><?php echo substr($feedback->comment,0,150);  ?></td>
                    <?php if($this->session->userdata('department_id') == 25 && $this->session->userdata('access_level_id') == 1) : ?><td data-label="Name"><?php echo $feedback->number_comment;  ?></td><?php endif; ?>
                    <?php if($this->session->userdata('department_id') == 25 && $this->session->userdata('access_level_id') == 1) : ?>
                        <?php if($feedback->is_open == 1 ): ?>
                            <td data-label="" style="background-color:#FEDE00; "><?php echo 'OPEN'; ?></td>
                        <?php endif; ?>
                        <?php if($feedback->is_open == 2 ): ?>
                            <td data-label="" style="background-color:#BBBBBB; "><?php echo 'HOLD'; ?></td>
                        <?php endif; ?>
                        <?php if($feedback->is_open == 0 ): ?>
                            <td data-label="" style="background-color:#7CF3A0; "><?php echo 'CLOSE'; ?></td>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($this->session->userdata('access_level_id') == 3) : ?>
                        <td><a class="btn btn-info" href="<?php echo base_url(); ?>feedback/view/<?php echo $feedback->id; ?>">VIEW</a></td>
                    <?php endif; ?>
                    <?php if($this->session->userdata('department_id') == 25 && $this->session->userdata('access_level_id') == 1) : ?>
                        <td data-label="Action">
                            <div class="btn-group">
                                <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a title="View Feedback" class="dropdown-item" href="<?php echo base_url(); ?>feedback/view/<?php echo $feedback->id; ?>">VIEW</a>
                                    <?php if($feedback->is_open != 2 && $feedback->is_open != 0): ?>
                                        <div class="dropdown-divider"></div>
                                        <a title="Hold Feedback" onclick="return confirm('Are you sure you want to hold the status?');" class="dropdown-item" href="<?php echo base_url(); ?>feedback/hold_feedback/<?php echo $feedback->id; ?>">HOLD</a>
                                    <?php endif; ?>
                                    <?php if($feedback->is_open != 0 ): ?>
                                        <div class="dropdown-divider"></div>
                                        <a title="Close Feedback" onclick="return confirm('Are you sure you want to close the status?');" class="dropdown-item" href="<?php echo base_url(); ?>feedback/close_feedback/<?php echo $feedback->id; ?>">CLOSE</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background-color:#1C4670; color:white;">
            <h5 class="modal-title" id="exampleModalLabel" >E-FEEDBACK FORM</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white;">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" action="<?php echo base_url(); ?>feedback/add" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control" name="category" required>
                                <option value="">Select Category</option>
                                <option value="BLAINE 201">BLAINE 201</option>
                                <option value="BLAINE TIMEKEEPING">BLAINE TIMEKEEPING</option>
                                <option value="BLAINE FORMS">BLAINE FORMS</option>
                                <option value="BLAINE 5S">BLAINE 5S</option>
                                <option value="OTHERS">OTHERS</option>
                            </select><br>
                            <input type="text" class="form-control" name="title" placeholder="TITLE"><br>
                            <textarea name="remarks" placeholder="COMMENT" class="form-control" cols="30" rows="10" required></textarea><br>
                            <input type='file' name='data1' size='20' />
                            <p><i style="color: blue">Allowed file types: jpg | jpeg | png | gif | docx | xls | xlsx | pdf</i></p>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" title="Close Feedback Form" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" title="Submit Feedback Form" class="btn btn-primary">Submit</button>
            </div>
            </form>
    </div>
  </div>
</div>
<script type="text/javascript">  
    $(document).ready(function() {
        $('.display').DataTable( {
            "order": [[0, "desc"]],
            "scrollY" : '70vh',
            "scrollX": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            //"scrollX" : true,
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            }
        });
    } );
</script>