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
    <div style="background-color: #478C5C; border: #478C5C; color: white" class="card-header"><h4>
        VIEW HOLIDAY
        <a href="<?php echo base_url(); ?>calendar/calendar_list" id="back" title="Go Back" class="btn btn-dark float-right" style="margin-right:10px;">BACK</a>
        <!--<input type="submit" style="margin-right:10px;" class="btn btn-info float-right" title="Print Holiday" id="printButton" value="PRINT">-->
    </h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header">Holiday Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input class="form-control" name="start" value="<?php echo $calendar->date; ?>" readonly></input>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type</label>
                            <input class="form-control" name="type" value="<?php echo $calendar->type; ?>" readonly></input>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <input class="form-control" name="description" value="<?php echo $calendar->description; ?>" readonly></input>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card-header" style="background-color:#D4F1F4;">Employee Holiday List</div>
                <div class="card-body">
                    <div class="row">
                        <?php if($employees_holiday) : ?>
                            <?php foreach($employees_holiday as $employee_holiday) : ?>
                                <div class="col-md-12">
                                    <div class="form-control"><?php echo $employee_holiday->fullname; ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
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