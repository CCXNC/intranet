<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Calendar Display</title>
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/gcal.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h4>
                <div class="card-header">
                    <h4>
                        <a href="<?php echo base_url(); ?>calendar/calendar_list" id="back" class="btn btn-info float-right" title="Go Back" style="margin-right:10px;">BACK</a>
                        </h4>
                </div>
            </h4>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Calendar</h1>
                    <div id="calendar">
                    </div>
                </div>
            </div>
        </div>
        <!--add-->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Calendar Event</h4>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open(site_url("calendar/add_event"), array("class" => "form-horizontal")) ?>
                        
                        <div class="form-group">
                            <label for="p-in" class="col-md-4 label-heading">Type</label>
                            <div class="col-md-8 ui-front">
                               <select class="form-control" name="name">
                                    <option value="">Select Type</option>
                                    <option value="Special Working Holiday">Special Working Holiday</option>
                                    <option value="Special Nonworking Holiday">Special Nonworking Holiday</option>
                                    <option value="Legal Holiday">Legal Holiday</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="p-in" class="col-md-4 label-heading">Description</label>
                            <div class="col-md-8 ui-front">
                                <input type="text" class="form-control" name="description">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="p-in" class="col-md-4 label-heading">Date</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="start_date">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" title="Close" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" title="Add Event" class="btn btn-primary" value="Add Event">
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <!--edit-->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Update Calendar Event</h4>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open(site_url("calendar/edit_event"), array("class" => "form-horizontal")) ?>
                        <div class="form-group">
                                <label for="p-in" class="col-md-4 label-heading">Type</label>
                                <div class="col-md-8 ui-front">
                                    <select class="form-control" name="name" value="" id="name">
                                        <option value="">Select Type</option>
                                        <option value="Special Working Holiday">Special Working Holiday</option>
                                        <option value="Special Nonworking Holiday">Special Nonworking Holiday</option>
                                        <option value="Legal Holiday">Legal Holiday</option>
                                    </select>
                                </div>
                                
                        </div>
                        <div class="form-group">
                            <label for="p-in" class="col-md-4 label-heading">Description</label>
                            <div class="col-md-8 ui-front">
                                <input type="text" class="form-control" name="description" id="description">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="p-in" class="col-md-4 label-heading">Date</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="start_date" id="start_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="p-in" class="col-md-4 label-heading">Delete Event</label>
                            <div class="col-md-8">
                                <input type="checkbox" name="delete" value="1">
                            </div>
                        </div>
                        <input type="hidden" name="eventid" id="event_id" value="0" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" title="Close" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" title="Update Event" class="btn btn-primary" value="Update Event">
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                var date_last_clicked = null;
                $('#calendar').fullCalendar({
                    eventSources: [
                        {
                            events: function(start, end, timezone, callback) {
                                $.ajax({
                                    url: '<?php echo base_url() ?>calendar/get_events',
                                    dataType: 'json',
                                    data: {
                                        // our hypothetical feed requires UNIX timestamps
                                        start: start.unix()
                                    },
                                    success: function(msg) {
                                        var events = msg.events;
                                        callback(events);
                                    }
                                });
                            }
                        },
                    ],
                    dayClick: function(date, jsEvent, view) {
                        date_last_clicked = $(this);
                        $(this).css('background-color', '#bed7f3');
                        $('#addModal').modal();
                    },
                    eventClick: function(event, jsEvent, view) {
                        $('#name').val(event.type);
                        $('#description').val(event.description);
                        $('#start_date').val(moment(event.start).format('YYYY-MM-DD'));
                        $('#event_id').val(event.id);
                        $('#editModal').modal();
                    },
                });
            });
        </script>
    </body>
</html>