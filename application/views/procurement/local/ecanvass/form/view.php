<div class="card">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>ELECTRONIC MATERIAL SOURCING REQUEST<a href="<?php echo base_url(); ?>procurement/form_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body" style="font-size:12px">
        <div class="card">
            <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">REQUEST DETAILS</div>
            <div class="card-body" style="background-color: #E9FAFD;color:black">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Business Unit</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input style="background-color:white" type="text" class="form-control" name="first_name" style="" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Reference Number</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input style="background-color:white" type="text" class="form-control" name="first_name" style="" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date Requested</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input style="background-color:white" type="text" class="form-control" name="first_name" style="" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date Required</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input style="background-color:white" type="text" class="form-control" name="first_name" style="" readonly>
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
                        <input style="background-color:white" type="text" class="form-control" name="first_name" style="" readonly>
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
                                <textarea style="background-color:white" class="form-control" id="" name="description[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Specification</label>
                                <textarea style="background-color:white" class="form-control" id="" name="specification[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Item Application</label>
                                <textarea style="background-color:white" class="form-control" id="" name="item_application[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input style="background-color:white" type="number" class="form-control" name="quantity[]" placeholder="" readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">UOM</label>
                                <textarea style="background-color:white" class="form-control" id="exampleFormControlTextarea1" name="required_document[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Purpose/Remarks</label>
                                <textarea style="background-color:white" class="form-control" id="" name="purpose[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Required Document</label>
                                <textarea style="background-color:white" class="form-control" id="exampleFormControlTextarea1" name="required_document[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Material Category</label>
                                <textarea style="background-color:white" class="form-control" id="exampleFormControlTextarea1" name="required_document[]" rows="1" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Shelf Life (Months)</label>
                                <input style="background-color:white" type="number" class="form-control" name="shelf_life[]" placeholder="" readonly>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>File Attachment</label>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <table class="table table-bordered" style="font-size:12px; line-height:13px">
                <thead>
                    <tr>
                    <th scope="col" style="background-color: #0C2D48; color: white;">Step/Approver</th>
                    <th scope="col" style="background-color: #0C2D48; color: white">Primary Approver</th>
                    <th scope="col" style="background-color: #0C2D48; color: white">Alternate Approver</th>
                    <th scope="col" style="background-color: #0C2D48; color: white">Status</th>
                    <th scope="col" style="background-color: #0C2D48; color: white">Date Sign-off</th>
                    <th scope="col" style="background-color: #0C2D48; color: white">Sign-off By</th>
                    <th scope="col" style="background-color: #0C2D48; color: white">Remarks</th>
                    </tr>
                </thead>
                <tbody style="line-height:12px; background-color: #F5F5F5">
                    <tr >
                        <th scope="row">Request Submission</th>
                        <td >Mark</td>
                        <td>John</td>
                        <td>Done</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>John</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">Immediate Superior Approval</th>
                        <td>Jacob</td>
                        <td>Paul</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>Paul</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">Procurement Request Acceptance</th>
                        <td>John</td>
                        <td>Paul</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>John</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">Procurement Report Generation</th>
                        <td>Peter</td>
                        <td>Mark</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>Peter</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">Requestor Feedback</th>
                        <td>Matthew</td>
                        <td>Phillip</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>Phillip</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">Request Closure</th>
                        <td>Jude</td>
                        <td>David</td>
                        <td>Pending</td>
                        <td>20-Jul-2021 13:05</td>
                        <td>David</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; font-size:15px; color:white"><h4></h4></div>
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
                                <input type="text" class="form-control" name="first_name" style="">
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