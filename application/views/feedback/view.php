<style>
    p {
        font-size: 18px;
    }
</style>
<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<div class="card"> 
    <div class="card-header"><h4><?php echo $feedback->category; ?><a href="<?php echo base_url(); ?>feedback/index" class="btn btn-dark float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header"><h5>Feedback List<a href="<?php echo base_url(); ?>feedback/index" class="btn btn-dark float-right" data-toggle="modal" data-target="#exampleModal" style="margin-right:10px;">ADD COMMENT</a></h5></div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DATE</th>
                            <th scope="col">NAME</th>
                            <th scope="col">COMMENT</th>
                            <th scope="col">FILE</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($comments) : ?>
                        <?php foreach($comments as $comment) : ?>
                            <tr>
                                <td data-label="Date"><?php echo date('F j, Y | h:i A', strtotime($comment->date)); ?></td>
                                <td data-label="Name"><?php echo $comment->fullname; ?></td>
                                <td data-label="Date"><?php echo $comment->comment; ?></td>
                                <td data-label="Date"><a href="<?php echo base_url(); ?>feedback/download_attachment/<?php echo $comment->file; ?>"><?php echo $comment->file; ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>  

                <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">COMMENT FORM</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo base_url(); ?>feedback/add_comment" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="feedback_id" value="<?php echo $feedback->id; ?>" hidden>
                                                <textarea name="remarks" placeholder="COMMENT" class="form-control" cols="30" rows="10" required></textarea><br>
                                                <input type='file' name='data1' size='20' />
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</div>
<script type="text/javascript">  
    $(document).ready(function() {
        "columnDefs": [
        ],
        $('.display').DataTable( {
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false
        } );
    } );
</script>
