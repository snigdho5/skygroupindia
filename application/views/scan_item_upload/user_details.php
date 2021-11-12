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
				
				<a href="<?php echo base_url('uploads/scan_item_upload/samples/user_details_format.xlsx');?>" class="btn btn-info excel_css"><i class="fa fa-download"></i> Download Format (xlsx)</a>
				
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
								<label>User Details Upload <span class="star">*</span> <small style="color:red;">(xls and xlsx are allowed only)</small></label>
								<input type="file" name="user_details" class="form-control" />
							</div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="submit-btn">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <input type="submit" value="Submit" name="submitBtn" class="yellow btn-radius15">
                        </div>
                        <div class="col-md-4 col-sm-4" >
                            <a href="<?php echo base_url('user-details-upload');?>" class=" darkgrey btn-radius15" style="cursor: pointer;"> Reset </a>
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