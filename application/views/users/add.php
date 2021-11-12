<!--right side content section start here-->
<div class="page-content">
    <div class="breadcrumb-section">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>"> <i class="fa fa-home" aria-hidden="true"></i> Dashboard </a></li>
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
            
            <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
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
								<label>Branch<span class="star">*</span></label>
								<select name="branch_id" class="form-control dropdown-search">
									<option value="">Select Branch</option>
									<?php foreach($branch as $value){ ?>
										<option value="<?php echo isset($value['code'])?$value['code']:'';?>"><?php echo isset($value['branch'])?$value['branch']:'';?></option>
									<?php } ?>
								</select>
								<?php echo form_error('branch_id', '<div class="text-danger">', '</div>'); ?>
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>User Email<span class="star">*</span></label>
								<input type="text" name="user_email" value="<?php echo set_value('user_email');?>" class="form-control" placeholder="Enter user email" />
								<?php echo form_error('user_email', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						<div class="clearfix"></div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>User Full Name<span class="star">*</span></label>
								<input type="text" name="user_full_name" value="<?php echo set_value('user_full_name');?>"  class="form-control" placeholder="Enter user full name" />
								<?php echo form_error('user_full_name', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						
						<div class="col-md-3 col-sm-3">
							<div class="form-group">
								<label>User Type<span class="star">*</span></label>
								<select name="user_type" class="form-control">
									<option value="">Select User Type</option>
									<?php foreach($userType as $user_type){ ?>
										<option value="<?php echo isset($user_type['_id'])?$user_type['_id']:'';?>"><?php echo isset($user_type['name'])?$user_type['name']:'';?></option>
									<?php } ?>
								</select>
								<?php echo form_error('user_type', '<div class="text-danger">', '</div>'); ?>
							</div>
						</div>
						
						<div class="col-md-3 col-sm-3">
							<div class="form-group">
								<label>Gender<span class="star">*</span></label>
								<select name="gender" class="form-control">
									<option value="">Select Gender</option>
									<option value="1">Male</option>
									<option value="2">Female</option>
									<option value="3">Transgender</option>
								</select>
								<?php echo form_error('gender', '<div class="text-danger">', '</div>'); ?>
							</div>
						</div>
						
						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Phone Number<span class="star">*</span></label>
								<input type="text" name="phone_number" value="<?php echo set_value('phone_number');?>" class="form-control" placeholder="Enter user phone number" />
								<?php echo form_error('phone_number', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Mobile Number<span class="star">*</span></label>
								<input type="text" name="mobile_number" value="<?php echo set_value('mobile_number');?>" class="form-control" placeholder="Enter user mobile number" />
								<?php echo form_error('mobile_number', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						
						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Street Name<span class="star">*</span></label>
								<input type="text" name="street_name" value="<?php echo set_value('street_name');?>" class="form-control" placeholder="Enter street name" />
								<?php echo form_error('street_name', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>City/Town<span class="star">*</span></label>
								<input type="text" name="city_town" value="<?php echo set_value('city_town');?>" class="form-control" placeholder="Enter city/town" />
								<?php echo form_error('city_town', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						
						<div class="clearfix"></div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>State<span class="star">*</span></label>
								<select name="state_id" class="form-control dropdown-search">
									<option value="">Select User Type</option>
									<?php foreach($states as $state){ ?>
										<option value="<?php echo isset($state['_id'])?$state['_id']:'';?>"><?php echo isset($state['state_name'])?$state['state_name']:'';?></option>
									<?php } ?>
								</select>
								<?php echo form_error('state_id', '<div class="text-danger">', '</div>'); ?>
							</div>
						</div>
					
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								Status
								<input type="checkbox" name="status" value="0" style="width: 100px; height: 30px" />Blocked
							</div>
                        </div>
						<div class="clearfix"></div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Image</label>
								<input type="file" name="user_image" class="form-control" onchange="readURL(this);"/>
								<div class="text-danger"> <?php if(isset($image_error) && $image_error!=''){ echo $image_error;} ?> </div>
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Image Preview<span class="star">*</span></label>
								<img id="preview" src="" style="display:none"/>
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
                            <a href="<?php echo base_url('user/add');?>" class=" darkgrey btn-radius15" style="cursor: pointer;"> Reset </a>
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