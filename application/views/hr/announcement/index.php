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

        img{
            width: 50% !important;
        }

        .btnaction{
            float: right;
        }
    }
</style>
<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card">
    <div class="card-header"><h4>ANNOUNCEMENT LIST<a href="<?php echo base_url(); ?>announcement/add" class="btn btn-info float-right">ADD</a></h4> </div>
    <div class="card-body">
        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Picture</th>
                    <th scope="col">Category</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($announcement) : ?>
                    <?php foreach($announcement as $announcement) : ?>
                        <tr>
                            <td data-label="Picture"><img src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" style="width:100%" alt=""></td>
                            <td data-label="Category"><?php echo $announcement->category;  ?></td>
                            <td data-label="Title"><?php echo $announcement->title;  ?></td>
                            <td data-label="Content"><?php echo word_limiter($announcement->content,10); ?></td>
                            <td data-label="Date"><?php echo $announcement->created_date; ?></td>
                            <td data-label="Action">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>announcement/view_announcement/<?php echo $announcement->id; ?>"> View</a>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>announcement/edit/<?php echo $announcement->id; ?>">Edit</a>
                                        <a onclick="return confirm('Are you sure you want to delete data?');" class="dropdown-item" href="<?php echo base_url(); ?>announcement/delete/<?php echo $announcement->id?>">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="float-right">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>

        
  