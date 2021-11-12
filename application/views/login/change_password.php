<!--right side content section start here-->
<div class="page-content">
    <div class="breadcrumb-section">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>"> <i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><?php echo isset($meta_title)?$meta_title:'';?></li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="form_section">
        <div class="container-fluid">
        <div class="row">
            <div class="form-content">
			
			<?php if ($this->session->flashdata('error')!='') { ?>
			<div class="alert alert-danger">
			   <?php echo $this->session->flashdata('error'); ?>
			</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')!='') { ?>
			<div class="alert alert-success">
			   <?php echo $this->session->flashdata('success'); ?>
			</div>
			<?php } ?>
            
            <form action="" method="post" autocomplete="off" >
                <div class="form-row category-form">
                <h2><?php echo isset($meta_title)?$meta_title:'';?></h2>

                <?php
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );
                ?>
				
               <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />

                <div class="form-content-inner">

                    <div class="form-content-inner">
                        <div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label for="password">Old Password<span class="star">*</span></label>
								<input type="password" name="old_password" value="<?php echo set_value('old_password');?>" class="form-control" placeholder="Enter old password" />
								<?php echo form_error('old_password', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label for="password">New Password<span class="star">*</span></label>
								<input type="password" name="new_password" value="<?php echo set_value('new_password');?>" class="form-control" placeholder="Enter new password" />
								<?php echo form_error('new_password', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						<div class="clearfix"></div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label for="password">Confirm New Password<span class="star">*</span></label>
								<input type="password" name="cnf_new_password" value="<?php echo set_value('cnf_new_password');?>" class="form-control" placeholder="Enter confirm new password" />
								<?php echo form_error('cnf_new_password', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						
                     </div>
                    <div class="clearfix"></div>

                </div>

                <div class="submit-btn">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <input type="submit" value="Submit" class="yellow btn-radius15">
                        </div>
                        <div class="col-md-4 col-sm-4" >
                            <a href="<?php echo base_url('change-password');?>" class=" darkgrey btn-radius15" style="cursor: pointer;"> Reset </a>
                        </div>
                        <div class="col-md-4 col-sm-4" >
                            <button type="button" style="cursor: pointer;" value="Back" class="darkgrey btn-radius15 back" onclick="goBack()">Back</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
	
</div>
</div>
<?php $this->load->view('layouts/includeJS.php');?>