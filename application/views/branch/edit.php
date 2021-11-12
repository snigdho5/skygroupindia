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
			   <input type="hidden" name="hdn_code" value="<?php echo isset($EditData[0]['code'])?$EditData[0]['code']:'';?>" >

                <div class="form-content-inner">

                    <div class="form-content-inner">
                        <div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Branch Name<span class="star">*</span></label>
								<input type="text" name="branch_name" value="<?php echo isset($EditData[0]['branch'])?$EditData[0]['branch']:'';?>" class="form-control" placeholder="Enter branch name" />
								<?php echo form_error('branch_name', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>Branch Code<span class="star">*</span></label>
								<input type="text" name="branch_code" value="<?php echo isset($EditData[0]['code'])?$EditData[0]['code']:'';?>" class="form-control" placeholder="Enter branch code" />
								<?php echo form_error('branch_code', '<div class="text-danger">', '</div>'); ?>
							</div>
                        </div>
						<div class="clearfix"></div>
						
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="submit-btn">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <input type="submit" value="Submit" class="yellow btn-radius15">
                        </div>
                        <div class="col-md-4 col-sm-4" >
                            <a href="<?php echo base_url('branch/edit/').isset($EditData[0]['_id'])?$EditData[0]['_id']:'';?>" class=" darkgrey btn-radius15" style="cursor: pointer;"> Reset </a>
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