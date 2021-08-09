<div class="card">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>ELECTRONIC MATERIAL SOURCING REQUEST<a href="<?php echo base_url(); ?>procurement/material_sourcing_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body" style="font-size:12px">
        <div class="card">
            <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">REQUEST DETAILS</div>
            <div class="card-body" style="background-color: #E9FAFD;color:black">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>*Business Unit</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>*Material Source ID</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>*Sourcing Category</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>*Date Required</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>*Date Requested</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="background-color: #0D635D; font-size:15px; color:white">MATERIAL DETAILS</div>
                <div class="card-body" id="form_field" style="background-color: #E9FAFD;color:black">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="description[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Specification</label>
                                <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="specification[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">UOM</label>
                                <input type="text" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder="" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Shelf Life (Months)</label>
                                <input type="text" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder="" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Purpose/Remarks</label>
                                <textarea class="form-control" style="font-size:12px; background-color: white" id="" name="purpose[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Item Application</label>
                                <textarea class="form-control" id="" style="font-size:12px; background-color:white" name="item_application[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Required Document</label>
                                <textarea class="form-control" style="font-size:12px; background-color:white" id="exampleFormControlTextarea1" name="required_document[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Material Category</label>
                                <input type="text" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder="" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>File Attachment</label>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <table class="table table-bordered" style="font-size:12px; line-height:13px;">
                <thead>
                    <tr style="background-color: #0D635D; color: white;">
                    <th scope="col">Step/Approver</th>
                    <th scope="col">Primary Approver</th>
                    <th scope="col">Alternate Approver</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Sign-off</th>
                    <th scope="col">Date CT</th>
                    <th scope="col">Sign-off By</th>
                    <th scope="col">Remarks</th>
                    </tr>
                </thead>
                <tbody style="line-height:12px; background-color: #F5F5F5">
                    <tr >
                        <th scope="row" style="background-color: #0C2D48; color:white">Request Submission</th>
                        <td >Mark</td>
                        <td>John</td>
                        <td>Done</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>5</td>
                        <td>John</td>
                        <td>Lorem ipsum sit amet dolor</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: #0C2D48; color:white">Immediate Superior Approval</th>
                        <td>Jacob</td>
                        <td>Paul</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>3</td>
                        <td>Paul</td>
                        <td>Lorem ipsum sit amet dolor</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: #0C2D48; color:white">Procurement Request Acceptance</th>
                        <td>John</td>
                        <td>Paul</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>4</td>
                        <td>John</td>
                        <td>Lorem ipsum sit amet dolor</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: #0C2D48; color:white">Procurement Report Generation</th>
                        <td>Peter</td>
                        <td>Mark</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>10</td>
                        <td>Peter</td>
                        <td>Lorem ipsum sit amet dolor</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: #0C2D48; color:white">Requestor Feedback</th>
                        <td>Matthew</td>
                        <td>Phillip</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>2</td>
                        <td>Phillip</td>
                        <td>Lorem ipsum sit amet dolor</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: #0C2D48; color:white">Procurement Request Closure</th>
                        <td>Jude</td>
                        <td>David</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>1</td>
                        <td>David</td>
                        <td>Lorem ipsum sit amet dolor</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; font-size:15px; color:white">APPROVAL DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sign Off:</label>
                                <br>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="form-check" style="margin-right: 20px; margin-left: 15px">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                <p style="border-radius: 5px; border: 2px solid #469A49; background-color:#469A49;padding:2px; color:white">Approve</p>
                                            </label>
                                        </div>
                                        <div class="form-check" style="margin-right: 20px; margin-left: 15px">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                <p style="border-radius: 5px; border: 2px solid #E12A2A; background-color:#E12A2A;padding:2px; color:white">Disapprove</p>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <p style="border-radius: 5px; border: 2px solid #FAD02C; background-color:#FAD02C;padding:2px; color:white">Action Required</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" id="" style="font-size:12px; background-color:white" name="item_application[]" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" title="Submit Employee Information" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
        </div>
    </div>
</div>