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
    <div class="card-header"  style="background-color:#1C4670; color:white;">
        <h4>VIEW RED TAG
            <a href="<?php echo base_url(); ?>fives/red_tag" id="back" title="Go Back"  class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a>
            <input type="submit" class="btn btn-dark float-right" title="Print Idea" style="border:1px solid #ccc; margin-right:10px;" id="printButton" value="PRINT">
        </h4>
    </div>
    <!--<div class="card-header container-fluid"  style="background-color:#1C4670; color:white;">
        <div class="row">
            <div class="col-md-9">
                <h3 class="">VIEW 5S SHARE MY IDEA LIST</h3>
            </div>
            <div class="col-md-3 float-right" style="">
                <button class="btn btn-md btn-dark" style="border:1px solid #ccc;" id="printButton">PRINT</button>
                <button class="btn btn-md btn-dark" style="border:1px solid #ccc;" onclick="location.href='<?php echo base_url(); ?>fives/idea'" id="back">BACK</button>
            </div>
        </div>
    </div>-->
    <div class="card-body">
        <div class="card">
            <div class="card-header" style="background-color:#1C4670; color:white;">Red Tag</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Quantity</label>
                            <div class="form-control"><?php echo $redtag->quantity; ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Unit</label>
                            <div class="form-control"><?php echo $redtag->unit; ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Item Description</label>
                            <div class="form-control"><?php echo $redtag->item_description; ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Item Location</label>
                            <div class="form-control"><?php echo $redtag->item_location; ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <div class="form-control"><?php echo $redtag->category; ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Reason</label>
                            <div class="form-control"><?php echo $redtag->reason; ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Action</label>
                            <div class="form-control"><?php echo $redtag->action; ?></div>
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
                                        <tr>
                                            <td data-label="Date"></td>
                                            <td data-label="Title"></td>
                                            <td data-label="File"></td>
                                            <td data-label="File"></td>
                                            <td data-label="Action"></td>
                                        </tr>
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
                            <div class="form-control"><?php echo $redtag->red_tag_date; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Red Tag Number</label>
                            <div class="form-control"><?php echo $redtag->red_tag_number; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Encoded By</label>
                            <div class="form-control"><?php echo $redtag->submit_by?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tagged By</label>
                            <div class="form-control"><?php echo $redtag->tagged_by; ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Company</label>
                            <div class="form-control"><?php echo $redtag->company?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Department</label>
                            <div class="form-control"><?php echo $redtag->department; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <div class="form-control"></div>
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