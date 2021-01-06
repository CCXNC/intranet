<?php if($this->session->flashdata('success_msg')) : ?>
     <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Employee Picture</th>
                <th>Employee Number</th>
                <th>Full Name</th>
                <th>Date Hired</th>
                <th>Employee Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row"><center><img src="<?php echo base_url(); ?>/assets/images/user1.png" width="80px;" height="80px;" alt=""></center> </td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Male</td>
            </tr>
            <tr>
                <td scope="row"><center><img src="<?php echo base_url(); ?>/assets/images/user2.png" width="80px;" height="80px;" alt=""></center> </td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Male</td>
            </tr>
            <tr>
                <td scope="row"><center><img src="<?php echo base_url(); ?>/assets/images/user3.png" width="80px;" height="80px;" alt=""></center> </td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Male</td>
            </tr>
        </tbody>
    </table>