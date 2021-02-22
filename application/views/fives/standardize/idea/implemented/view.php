<style>
    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    table th,
    table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        font-size: .85em;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    @media screen and (max-width: 950px) {
        table {
            border: 0;
        }

        table caption {
            font-size: 1.3em;
        }
        
        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
    
        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }
        
        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }
    
        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        table td:last-child {
            border-bottom: 0;
        }
    }

    
        @page {
            margin-top: 70pt;
            margin-bottom:100pt;
        }


</style>
<div class="card">
    <div class="card-header" style="background-color:#1C4670; color:white;"><h4>VIEW 5S SHARE IMPLEMENTED IDEA<a href="<?php echo base_url(); ?>fives/implemented" id="back"  class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a><input type="submit"  class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;" id="printButton" value="PRINT"></h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header" style="background-color:#1C4670; color:white;">My Idea</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Before</label>
                            <textarea readonly class="form-control" name="content" rows="4" cols="50"><?php echo $idea->before; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>After</label>
                            <textarea readonly class="form-control" name="content" rows="4" cols="50"><?php echo $idea->after; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Impact</label>
                            <textarea readonly class="form-control" name="content" rows="4" cols="50"><?php echo $idea->impact; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CATEGORY:</label>
                            <h5><?php echo $idea->classification; ?></h5>
                        </div>
                        <div class="form-group">
                            <label>5S CHAMPION :</label>
                            <h5><?php echo $idea->implemented_by; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="background-color:#1C4670; color:white;">Attachments</div>
            <div class="card-body">
                <div class="row">
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">File</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($attachments) : ?>
                                <?php foreach($attachments as $attachment) : ?>
                                        <tr>
                                            <td data-label="Date"><?php echo date('F j, Y',strtotime($attachment->created_date));  ?></td>
                                            <td data-label="Title"><?php echo $attachment->status; ?></td>
                                            <td data-label="File"><a href="<?php echo base_url(); ?>fives/download_attachment/<?php echo $attachment->file; ?>"><?php echo $attachment->file; ?></a></td>
                                            <td data-label="File"><?php echo $attachment->remarks; ?></td>
                                            <td data-label="Action"><?php echo $attachment->created_by; ?></td>
                                        </tr>
                                <?php endforeach; ?> 
                            <?php endif; ?>
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
        
        <br><br>
        <div class="card">
            <div class="card-header" style="background-color:#1C4670; color:white;">User Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date Submitted</label>
                            <div class="form-control"><?php echo $idea->submit_date; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Control Number</label>
                            <div class="form-control"><?php echo $idea->control_number; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Encoded By</label>
                            <div class="form-control"><?php echo $idea->submit_by; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Idea Owner</label>
                            <div class="form-control"><?php echo $idea->propose_by; ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Company</label>
                            <div class="form-control"><?php echo $idea->company; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Department</label>
                            <div class="form-control"><?php echo $idea->department; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <div class="form-control"><?php echo $idea->status; ?></div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>      
</div>    
<script>
    $(document).ready(function(){
        $('#printButton').click(function() {
            $('#menuTab').css('display', 'none');
            $('#show-sidebar').hide();
            $('#back').hide();
            $('#printButton').hide();
            window.print();
        });
        
    });
</script>